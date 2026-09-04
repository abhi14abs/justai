<?php

namespace App\Http\Controllers\Invitations;

use App\Http\Controllers\Controller;
use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationGuest;
use App\Models\Invitations\InvitationQrCode;
use App\Services\Invitations\InvitationAnalyticsService;
use App\Services\Invitations\InvitationGuestService;
use App\Services\Invitations\InvitationQrService;
use App\Services\Invitations\InvitationTemplateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvitationDashboardController extends Controller
{
    protected InvitationGuestService $guestService;
    protected InvitationAnalyticsService $analyticsService;
    protected InvitationQrService $qrService;
    protected InvitationTemplateService $templateService;

    public function __construct(
        InvitationGuestService $guestService,
        InvitationAnalyticsService $analyticsService,
        InvitationQrService $qrService,
        InvitationTemplateService $templateService
    ) {
        $this->guestService = $guestService;
        $this->analyticsService = $analyticsService;
        $this->qrService = $qrService;
        $this->templateService = $templateService;
    }

    /**
     * Customer Invitation Dashboard List.
     */
    public function index()
    {
        $user = Auth::user();
        $invitations = Invitation::where('user_id', $user->id)
            ->with(['template', 'rsvpForm'])
            ->withCount(['formResponses', 'guests'])
            ->latest()
            ->get();

        return view('invitations.dashboard.index', [
            'invitations' => $invitations,
        ]);
    }

    /**
     * Guest Management Suite.
     */
    public function guests(Request $request, int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $groupFilter = $request->query('group');
        $statusFilter = $request->query('status');

        $guestsQuery = $invitation->guests();
        if (!empty($groupFilter)) {
            $guestsQuery->where('group_name', $groupFilter);
        }
        if (!empty($statusFilter)) {
            $guestsQuery->where('attending_status', $statusFilter);
        }

        $guests = $guestsQuery->orderBy('name')->paginate(25)->withQueryString();
        $groups = $invitation->guests()->distinct('group_name')->pluck('group_name')->filter()->values();

        $stats = [
            'total' => $invitation->guests()->count(),
            'attending' => $invitation->guests()->where('attending_status', 'attending')->sum('allocated_seats'),
            'declined' => $invitation->guests()->where('attending_status', 'declined')->count(),
            'pending' => $invitation->guests()->where('attending_status', 'pending')->count(),
            'checked_in' => $invitation->guests()->where('check_in_status', true)->count(),
        ];

        return view('invitations.dashboard.guests', [
            'invitation' => $invitation,
            'guests' => $guests,
            'groups' => $groups,
            'stats' => $stats,
            'selectedGroup' => $groupFilter,
            'selectedStatus' => $statusFilter,
        ]);
    }

    /**
     * Add Individual Guest.
     */
    public function addGuest(Request $request, int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'group_name' => 'nullable|string|max:100',
            'allocated_seats' => 'nullable|integer|min:1|max:20',
            'is_vip' => 'nullable|boolean',
            'custom_notes' => 'nullable|string|max:500',
        ]);

        InvitationGuest::create(array_merge($validated, [
            'invitation_id' => $invitation->id,
            'guest_code' => 'GST-' . strtoupper(Str::random(6)),
            'allocated_seats' => $validated['allocated_seats'] ?? 1,
            'is_vip' => (bool) ($validated['is_vip'] ?? false),
            'attending_status' => 'pending',
        ]));

        return back()->with('success', 'Guest added successfully.');
    }

    /**
     * Import Guests from CSV.
     */
    public function importGuests(Request $request, int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $content = file_get_contents($request->file('csv_file')->getRealPath());
        $result = $this->guestService->importCsv($invitation, $content);

        return back()->with('success', "Imported {$result['imported']} guests successfully.");
    }

    /**
     * Delete Guest.
     */
    public function deleteGuest(int $id, int $guestId)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $guest = InvitationGuest::where('invitation_id', $invitation->id)->where('id', $guestId)->firstOrFail();
        $guest->delete();

        return back()->with('success', 'Guest removed.');
    }

    /**
     * Real-Time Analytics View.
     */
    public function analytics(int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $metrics = $this->analyticsService->getMetrics($invitation);

        return view('invitations.dashboard.analytics', [
            'invitation' => $invitation,
            'metrics' => $metrics,
        ]);
    }

    /**
     * QR Code Studio & Download Center.
     */
    public function qrStudio(int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $qrSvg = $this->qrService->generateSvg(
            url('/i/' . $invitation->slug),
            320,
            $invitation->primary_color ?? '#064E3B',
            '#FFFFFF'
        );

        return view('invitations.dashboard.qr', [
            'invitation' => $invitation,
            'qrSvg' => $qrSvg,
        ]);
    }

    /**
     * Mobile Camera Door Check-in Scanner View.
     */
    public function checkInScanner(int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        return view('invitations.dashboard.scanner', [
            'invitation' => $invitation,
        ]);
    }

    /**
     * AJAX Door Check-in API.
     */
    public function checkInApi(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $guestCode = $request->input('guest_code');
        if (empty($guestCode)) {
            return response()->json(['success' => false, 'message' => 'Please provide a guest code or scan pass.'], 422);
        }

        $result = $this->guestService->checkIn($invitation, $guestCode);

        if ($result['success']) {
            $this->analyticsService->recordEvent($invitation, 'qr_scan', $request, null, ['guest_code' => $guestCode]);
        }

        return response()->json($result);
    }

    /**
     * Guest Photo Uploads & Memories Wall Dashboard.
     */
    public function memories(Request $request, int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $memories = \App\Models\Invitations\InvitationAsset::where('invitation_id', $invitation->id)
            ->where('asset_type', 'guest_memory')
            ->latest()
            ->paginate(24);

        $stats = [
            'total_photos' => \App\Models\Invitations\InvitationAsset::where('invitation_id', $invitation->id)->where('asset_type', 'guest_memory')->count(),
            'guest_wishes' => \App\Models\Invitations\InvitationFormResponse::where('invitation_id', $invitation->id)->whereNotNull('notes')->count(),
        ];

        return view('invitations.dashboard.memories', [
            'invitation' => $invitation,
            'memories' => $memories,
            'stats' => $stats,
        ]);
    }

    /**
     * Delete Guest Uploaded Memory Asset.
     */
    public function deleteMemory(int $id, int $assetId)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $asset = \App\Models\Invitations\InvitationAsset::where('invitation_id', $invitation->id)
            ->where('id', $assetId)
            ->firstOrFail();

        $asset->delete();

        return back()->with('success', 'Memory photo removed from celebration pool.');
    }

    /**
     * Generate Personalized WhatsApp Invitation Copy.
     */
    public function generateWhatsAppMessage(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $guestName = $request->input('guest_name', 'Dear Guest');
        $guestCode = $request->input('guest_code');
        $tone = $request->input('tone', 'royal'); // royal, casual, traditional, english, hinglish

        $inviteUrl = url('/i/' . $invitation->slug . ($guestCode ? '?g=' . $guestCode : ''));
        $dateStr = $invitation->event_date ? $invitation->event_date->format('l, d F Y') : 'Upcoming Auspicious Day';

        if ($tone === 'hinglish') {
            $msg = "✨ *Shubh Vivah Nimantran* ✨\n\nPyare {$guestName},\nHumare parivar ki khushiyon mein shamil hone ke liye aapko hardik aamantrit karte hain.\n\n💍 *{$invitation->title}*\n📅 *Date:* {$dateStr}\n\n👇 *Aapka Personalized Digital Card & RSVP:* \n{$inviteUrl}\n\nAapka aana humare liye atyant shubh hoga! 🙏";
        } elseif ($tone === 'traditional') {
            $msg = "|| श्री गणेशाय नमः ||\n\nआदरणीय {$guestName} जी,\n\nसस्नेह निमंत्रण। हमारे परिवार के शुभ मांगलिक प्रसंग में आपकी गरिमामयी उपस्थिति एवं शुभाशीर्वाद सादर प्रार्थनीय है।\n\n🌟 *{$invitation->title}*\n📅 *दिनांक:* {$dateStr}\n\n👇 *डिजिटल निमंत्रण पत्रिका एवं लोकेशन:* \n{$inviteUrl}\n\nदर्शनाभिलाषी: समस्त परिवार";
        } else {
            $msg = "✨ *You're Cordially Invited!* ✨\n\nDear {$guestName},\n\nTogether with our families, we request the pleasure of your company to celebrate our auspicious occasion.\n\n👑 *{$invitation->title}*\n📅 *Date:* {$dateStr}\n\n👇 *Open Your Interactive Digital Invitation:* \n{$inviteUrl}\n\nKindly confirm your gracious presence via the RSVP link above.\nWarm Regards!";
        }

        $waLink = 'https://api.whatsapp.com/send?text=' . urlencode($msg);

        return response()->json([
            'success' => true,
            'message' => $msg,
            'whatsapp_url' => $waLink,
            'direct_url' => $inviteUrl,
        ]);
    }

    /**
     * Duplicate Invitation.
     */
    public function duplicate(int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $clone = $this->templateService->duplicate($invitation, $user->id);

        return redirect()->route('invitations.dashboard.index')
            ->with('success', "Invitation duplicated as '{$clone->title}'.");
    }

    /**
     * Delete Invitation.
     */
    public function delete(int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $invitation->delete();

        return redirect()->route('invitations.dashboard.index')->with('success', 'Invitation deleted.');
    }
}

