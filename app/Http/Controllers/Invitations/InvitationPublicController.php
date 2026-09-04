<?php

namespace App\Http\Controllers\Invitations;

use App\Http\Controllers\Controller;
use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationGuest;
use App\Models\Invitations\InvitationShareLink;
use App\Services\Invitations\InvitationAnalyticsService;
use App\Services\Invitations\InvitationRsvpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvitationPublicController extends Controller
{
    protected InvitationRsvpService $rsvpService;
    protected InvitationAnalyticsService $analyticsService;

    public function __construct(InvitationRsvpService $rsvpService, InvitationAnalyticsService $analyticsService)
    {
        $this->rsvpService = $rsvpService;
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display Public Digital Invitation.
     */
    public function show(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->with(['enabledSections', 'events', 'rsvpForm.fields', 'assets'])
            ->firstOrFail();

        // Check if published or if current authenticated user owns it
        if (!$invitation->isPublished()) {
            $user = Auth::user();
            if (!$user || ($user->id !== $invitation->user_id && !$user->isAdmin())) {
                abort(404, 'This invitation is not yet published.');
            }
        }

        // Check for personalized guest code
        $guestCode = $request->query('g');
        $guest = null;
        if (!empty($guestCode)) {
            $guest = InvitationGuest::where('invitation_id', $invitation->id)
                ->where('guest_code', $guestCode)
                ->first();
        }

        // Record Analytics View
        $this->analyticsService->recordEvent($invitation, 'page_view', $request, $guest?->id);

        return view('invitations.public.show', [
            'invitation' => $invitation,
            'guest' => $guest,
        ]);
    }

    /**
     * Submit RSVP via AJAX.
     */
    public function submitRsvp(Request $request, string $slug): JsonResponse
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $data = $request->all();
        $result = $this->rsvpService->submitRsvp($invitation, $data, $request->ip());

        // Record analytics
        $this->analyticsService->recordEvent($invitation, 'rsvp_submit', $request, null, [
            'status' => $data['attending_status'] ?? 'attending',
            'party_size' => $data['party_size'] ?? 1,
        ]);

        return response()->json($result);
    }

    /**
     * Upload Guest Memory Photo with Wish.
     */
    public function uploadMemory(Request $request, string $slug): JsonResponse
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'guest_name' => 'required|string|max:150',
            'caption' => 'nullable|string|max:500',
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $file = $request->file('photo');
        $fileName = 'memory_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('storage/invitations/' . $invitation->id . '/memories');
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        $file->move($destinationPath, $fileName);
        $fileUrl = '/storage/invitations/' . $invitation->id . '/memories/' . $fileName;

        $asset = \App\Models\Invitations\InvitationAsset::create([
            'invitation_id' => $invitation->id,
            'asset_type' => 'guest_memory',
            'name' => $validated['guest_name'] . "'s Moment",
            'file_path' => $fileUrl,
            'thumbnail_path' => $fileUrl,
            'caption' => $validated['caption'] ?? null,
            'sort_order' => 0,
            'file_size' => filesize($destinationPath . '/' . $fileName),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for sharing your memory! It has been posted to the celebration wall.',
            'memory' => [
                'id' => $asset->id,
                'guest_name' => $validated['guest_name'],
                'caption' => $asset->caption,
                'file_path' => $asset->file_path,
                'created_at' => $asset->created_at->diffForHumans(),
            ]
        ]);
    }

    /**
     * Get Guest Memories / Photo Pool for Invitation.
     */
    public function getMemories(string $slug): JsonResponse
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        
        $memories = \App\Models\Invitations\InvitationAsset::where('invitation_id', $invitation->id)
            ->where('asset_type', 'guest_memory')
            ->latest()
            ->take(50)
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'file_path' => $m->file_path,
                    'caption' => $m->caption,
                    'created_at' => $m->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'memories' => $memories,
        ]);
    }

    /**
     * Track 1-Click Share interactions.
     */
    public function trackShare(Request $request, string $slug, string $channel): JsonResponse
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $shareLink = InvitationShareLink::firstOrCreate(
            ['invitation_id' => $invitation->id, 'channel' => $channel],
            ['shares_count' => 0, 'clicks_count' => 0]
        );
        $shareLink->increment('shares_count');

        $this->analyticsService->recordEvent($invitation, 'share_click', $request, null, ['channel' => $channel]);

        return response()->json(['success' => true]);
    }
}

