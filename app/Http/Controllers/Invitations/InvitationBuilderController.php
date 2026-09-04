<?php

namespace App\Http\Controllers\Invitations;

use App\Http\Controllers\Controller;
use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationEvent;
use App\Models\Invitations\InvitationFeature;
use App\Models\Invitations\InvitationForm;
use App\Models\Invitations\InvitationFormField;
use App\Models\Invitations\InvitationSection;
use App\Models\Invitations\InvitationTemplate;
use App\Services\Invitations\InvitationPricingService;
use App\Services\Invitations\InvitationTemplateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationBuilderController extends Controller
{
    protected InvitationTemplateService $templateService;
    protected InvitationPricingService $pricingService;

    public function __construct(InvitationTemplateService $templateService, InvitationPricingService $pricingService)
    {
        $this->templateService = $templateService;
        $this->pricingService = $pricingService;
    }

    /**
     * Start Customization from a Template.
     */
    public function createFromTemplate(Request $request, string $templateSlug)
    {
        $template = InvitationTemplate::where('slug', $templateSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('info', 'Please log in or create a free account to customize this invitation.');
        }

        $invitation = $this->templateService->createFromTemplate($template, $user->id);

        return redirect()->route('invitations.builder.edit', $invitation->id)
            ->with('success', 'Invitation created! Customize your colors, events, and RSVP below.');
    }

    /**
     * Visual Live Customizer & Builder.
     */
    public function edit(int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['template', 'sections', 'events', 'rsvpForm.fields', 'assets'])
            ->firstOrFail();

        $features = InvitationFeature::where('is_active', true)
            ->with('prices')
            ->orderBy('sort_order')
            ->get();

        $pricingBreakdown = $this->pricingService->calculate(
            $invitation->template,
            $invitation->selected_features ?? [],
            'INR'
        );

        return view('invitations.builder.edit', [
            'invitation' => $invitation,
            'features' => $features,
            'pricing' => $pricingBreakdown,
        ]);
    }

    /**
     * Autosave / Update Invitation Basics & Design.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'cover_image' => 'nullable|string|max:1000',
            'primary_color' => 'nullable|string|max:30',
            'secondary_color' => 'nullable|string|max:30',
            'accent_color' => 'nullable|string|max:30',
            'font_family_heading' => 'nullable|string|max:100',
            'font_family_body' => 'nullable|string|max:100',
            'animation_style' => 'nullable|string|max:50',
            'music_url' => 'nullable|string|max:1000',
            'selected_features' => 'nullable|array',
            'custom_css' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $invitation->update(array_filter($validated, fn($val) => $val !== null));

        return response()->json([
            'success' => true,
            'message' => 'Invitation saved successfully.',
            'invitation' => $invitation,
        ]);
    }

    /**
     * Add Event to Itinerary.
     */
    public function addEvent(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:500',
            'dress_code' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]);

        $maxSort = $invitation->events()->max('sort_order') ?? 0;
        $event = InvitationEvent::create(array_merge($validated, [
            'invitation_id' => $invitation->id,
            'sort_order' => $maxSort + 1,
        ]));

        return response()->json([
            'success' => true,
            'event' => $event,
            'message' => 'Event added to itinerary.',
        ]);
    }

    /**
     * Delete Event from Itinerary.
     */
    public function deleteEvent(int $id, int $eventId): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $event = InvitationEvent::where('invitation_id', $invitation->id)
            ->where('id', $eventId)
            ->firstOrFail();

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event removed.',
        ]);
    }

    /**
     * Update Event Particulars & Date/Time.
     */
    public function updateEvent(Request $request, int $id, int $eventId): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $event = InvitationEvent::where('invitation_id', $invitation->id)
            ->where('id', $eventId)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:500',
            'dress_code' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]);

        $event->update(array_filter($validated, fn($v) => $v !== null));

        return response()->json([
            'success' => true,
            'event' => $event,
            'message' => 'Event updated successfully.',
        ]);
    }

    /**
     * Update Section Content / Visibility.
     */
    public function updateSection(Request $request, int $id, int $sectionId): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $section = InvitationSection::where('invitation_id', $invitation->id)
            ->where('id', $sectionId)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'content' => 'nullable|array',
            'is_enabled' => 'nullable|boolean',
        ]);

        $section->update($validated);

        return response()->json([
            'success' => true,
            'section' => $section,
            'message' => 'Section updated.',
        ]);
    }

    /**
     * Update RSVP Form Settings.
     */
    public function updateRsvp(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'deadline' => 'nullable|date',
            'max_party_size' => 'nullable|integer|min:1|max:20',
            'allow_guest_plus_one' => 'nullable|boolean',
        ]);

        $form = $invitation->rsvpForm;
        if (!$form) {
            $form = InvitationForm::create([
                'invitation_id' => $invitation->id,
                'title' => 'RSVP to Our Celebration',
                'deadline' => $validated['deadline'] ?? now()->addMonth(),
                'max_party_size' => $validated['max_party_size'] ?? 5,
                'allow_guest_plus_one' => $validated['allow_guest_plus_one'] ?? true,
                'is_active' => true,
            ]);
        } else {
            $form->update($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'RSVP settings updated.',
            'form' => $form,
        ]);
    }
}
