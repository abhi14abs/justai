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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            'event_date' => 'nullable|string',
            'cover_image' => 'nullable|string|max:1000',
            'bg_opacity' => 'nullable|numeric|min:0|max:1',
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

        $updateData = [];

        if ($request->has('bg_opacity')) {
            $opacity = max(0, min(1, (float) $request->input('bg_opacity')));
            $existingCss = $request->input('custom_css') ?? ($invitation->custom_css ?? '');
            if (preg_match('/--invite-bg-opacity:\s*[0-9.]+;?/', $existingCss)) {
                $existingCss = preg_replace('/--invite-bg-opacity:\s*[0-9.]+;?/', "--invite-bg-opacity: {$opacity};", $existingCss);
            } else {
                $existingCss = trim($existingCss) . "\n:root { --invite-bg-opacity: {$opacity}; }";
            }
            $updateData['custom_css'] = $existingCss;
        }

        foreach ($validated as $key => $value) {
            if ($value === null || $key === 'bg_opacity') continue;

            if ($key === 'event_date') {
                if (empty(trim($value))) {
                    $updateData['event_date'] = null;
                } else {
                    try {
                        $updateData['event_date'] = \Carbon\Carbon::parse($value);
                    } catch (\Exception $e) {
                        // ignore unparseable date
                    }
                }
            } elseif ($key === 'slug') {
                $cleanSlug = \Illuminate\Support\Str::slug($value);
                if (!empty($cleanSlug)) {
                    $exists = Invitation::where('slug', $cleanSlug)->where('id', '!=', $invitation->id)->exists();
                    $updateData['slug'] = $exists ? $cleanSlug . '-' . \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(4)) : $cleanSlug;
                }
            } elseif ($key === 'cover_image') {
                if (!empty(trim($value))) {
                    $val = trim($value);
                    if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
                        if (!str_contains($val, '/uploads/invitations/' . $invitation->id . '/')) {
                            // Download and cache remote image permanently
                            $val = $this->downloadAndStoreRemoteImage($val, $invitation);
                        }
                    }
                    $updateData['cover_image'] = $val;
                } else {
                    $updateData['cover_image'] = null;
                }
            } elseif ($key === 'custom_css') {
                if (!isset($updateData['custom_css'])) {
                    $updateData['custom_css'] = $value;
                }
            } else {
                $updateData[$key] = $value;
            }
        }

        if (!empty($updateData)) {
            $invitation->update($updateData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Invitation saved successfully.',
            'invitation' => $invitation->fresh(['sections', 'events', 'rsvpForm']),
        ]);
    }

    /**
     * Save Location Details across Venue, Map & Hero Sections.
     */
    public function saveLocation(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:500',
            'city_display' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|string|max:1000',
            'map_embed_url' => 'nullable|string|max:1000',
            'airport_distance' => 'nullable|string|max:255',
            'train_distance' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'directions_notes' => 'nullable|string|max:1000',
        ]);

        $venueName = $validated['venue_name'] ?? 'Celebration Venue';
        $venueAddress = $validated['venue_address'] ?? '';
        $cityDisplay = $validated['city_display'] ?? '';
        $mapsUrl = $validated['google_maps_url'] ?? '';
        if (empty($mapsUrl) && (!empty($venueName) || !empty($venueAddress))) {
            $mapsUrl = 'https://maps.google.com/?q=' . urlencode(trim($venueName . ' ' . $venueAddress . ' ' . $cityDisplay));
        }

        // 1. Update Venue Section
        $venueSec = $invitation->sections()->where('section_type', 'venue')->first();
        if ($venueSec) {
            $vContent = $venueSec->content ?? [];
            $vContent['venue_name'] = $venueName;
            $vContent['venue_address'] = $venueAddress;
            $vContent['city_display'] = $cityDisplay;
            $vContent['google_maps_url'] = $mapsUrl;
            $vContent['map_embed_url'] = $validated['map_embed_url'] ?? ($vContent['map_embed_url'] ?? '');
            $vContent['airport_distance'] = $validated['airport_distance'] ?? ($vContent['airport_distance'] ?? '');
            $vContent['train_distance'] = $validated['train_distance'] ?? ($vContent['train_distance'] ?? '');
            $vContent['landmark'] = $validated['landmark'] ?? ($vContent['landmark'] ?? '');
            $vContent['description'] = $validated['description'] ?? ($vContent['description'] ?? '');
            $vContent['directions_notes'] = $validated['directions_notes'] ?? ($vContent['directions_notes'] ?? '');
            $venueSec->update(['content' => $vContent]);
        }

        // 2. Update Map Section
        $mapSec = $invitation->sections()->where('section_type', 'map')->first();
        if ($mapSec) {
            $mContent = $mapSec->content ?? [];
            $mContent['venue_name'] = $venueName;
            $mContent['venue_address'] = $venueAddress;
            $mContent['city_display'] = $cityDisplay;
            $mContent['google_maps_url'] = $mapsUrl;
            $mContent['map_embed_url'] = $validated['map_embed_url'] ?? ($mContent['map_embed_url'] ?? '');
            $mapSec->update(['content' => $mContent]);
        }

        // 3. Update Hero Section city_display
        if (!empty($cityDisplay)) {
            $heroSec = $invitation->sections()->where('section_type', 'hero')->first();
            if ($heroSec) {
                $hContent = $heroSec->content ?? [];
                $hContent['city_display'] = $cityDisplay;
                $heroSec->update(['content' => $hContent]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Location and venue details updated successfully.',
            'location' => [
                'venue_name' => $venueName,
                'venue_address' => $venueAddress,
                'city_display' => $cityDisplay,
                'google_maps_url' => $mapsUrl,
                'map_embed_url' => $validated['map_embed_url'] ?? '',
                'airport_distance' => $validated['airport_distance'] ?? '',
                'train_distance' => $validated['train_distance'] ?? '',
                'landmark' => $validated['landmark'] ?? '',
            ]
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
            'event_date' => 'nullable|string',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:500',
            'map_embed_url' => 'nullable|string|max:1000',
            'dress_code' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]);

        if (!empty($validated['event_date'])) {
            try {
                $validated['event_date'] = \Carbon\Carbon::parse($validated['event_date'])->toDateString();
            } catch (\Exception $e) {
                $validated['event_date'] = null;
            }
        }

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
            'event_date' => 'nullable|string',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:500',
            'map_embed_url' => 'nullable|string|max:1000',
            'dress_code' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:10',
        ]);

        if (array_key_exists('event_date', $validated)) {
            if (!empty($validated['event_date'])) {
                try {
                    $validated['event_date'] = \Carbon\Carbon::parse($validated['event_date'])->toDateString();
                } catch (\Exception $e) {
                    $validated['event_date'] = null;
                }
            } else {
                $validated['event_date'] = null;
            }
        }

        $event->update(array_filter($validated, fn($v) => $v !== null));

        return response()->json([
            'success' => true,
            'event' => $event,
            'message' => 'Event updated successfully.',
        ]);
    }

    /**
     * Update Section Content, Settings (Colors, Backgrounds) & Visibility.
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
            'subtitle' => 'nullable|string|max:1000',
            'content' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_enabled' => 'nullable|boolean',
        ]);

        $updateData = [];
        if (array_key_exists('title', $validated)) {
            $updateData['title'] = $validated['title'];
        }
        if (array_key_exists('subtitle', $validated)) {
            $updateData['subtitle'] = $validated['subtitle'];
        }
        if (array_key_exists('is_enabled', $validated)) {
            $updateData['is_enabled'] = (bool) $validated['is_enabled'];
        }
        if (array_key_exists('content', $validated) && is_array($validated['content'])) {
            $existingContent = $section->content ?? [];
            $updateData['content'] = array_merge($existingContent, $validated['content']);
        }
        if (array_key_exists('settings', $validated) && is_array($validated['settings'])) {
            $existingSettings = $section->settings ?? [];
            $updateData['settings'] = array_merge($existingSettings, $validated['settings']);
        }

        if (!empty($updateData)) {
            $section->update($updateData);
        }

        return response()->json([
            'success' => true,
            'section' => $section,
            'message' => 'Section updated successfully.',
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
            'deadline' => 'nullable|string',
            'max_party_size' => 'nullable|integer|min:1|max:20',
            'allow_guest_plus_one' => 'nullable|boolean',
        ]);

        if (!empty($validated['deadline'])) {
            try {
                $validated['deadline'] = \Carbon\Carbon::parse($validated['deadline']);
            } catch (\Exception $e) {
                $validated['deadline'] = null;
            }
        }

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
            $form->update(array_filter($validated, fn($v) => $v !== null));
        }

        return response()->json([
            'success' => true,
            'message' => 'RSVP settings updated.',
            'form' => $form,
        ]);
    }

    /**
     * Normalize Image URLs (Unsplash, Google Drive, Dropbox, direct CDN).
     */
    public function normalizeImageUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // 1. Unsplash Webpage URL -> Direct download endpoint
        if (preg_match('/unsplash\.com\/photos\/(?:[\w-]+-)?([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            if (!str_contains($url, 'images.unsplash.com')) {
                $photoId = $matches[1];
                return "https://unsplash.com/photos/{$photoId}/download?w=1600";
            }
        }

        // 2. Google Drive Share Link
        if (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            return "https://drive.google.com/uc?export=view&id={$matches[1]}";
        }

        // 3. Dropbox Link
        if (str_contains($url, 'dropbox.com') && str_contains($url, 'dl=0')) {
            return str_replace('dl=0', 'raw=1', $url);
        }

        return $url;
    }

    /**
     * Upload Image Asset directly from Computer/Device.
     */
    public function uploadAsset(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:12288', // 12MB max
            'type' => 'nullable|string|in:cover,card,gallery,avatar',
        ]);

        $file = $request->file('image');
        $fileName = 'invite_' . $invitation->id . '_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/invitations/' . $invitation->id);

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $fileName);
        $publicUrl = asset('uploads/invitations/' . $invitation->id . '/' . $fileName);

        // If type is cover, auto update invitation cover_image
        if ($request->input('type') === 'cover') {
            $invitation->cover_image = $publicUrl;
            $invitation->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully! ✨',
            'url' => $publicUrl,
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Download and Ingest Remote Image URL (Unsplash, Google Drive, direct web image)
     */
    public function ingestRemoteUrl(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'url' => 'required|string|max:2000',
            'type' => 'nullable|string|in:cover,card,gallery',
        ]);

        $remoteUrl = trim($request->input('url'));
        $localUrl = $this->downloadAndStoreRemoteImage($remoteUrl, $invitation);

        if ($request->input('type', 'cover') === 'cover') {
            $invitation->cover_image = $localUrl;
            $invitation->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Remote image successfully fetched & stored! ✨',
            'url' => $localUrl,
            'original_url' => $remoteUrl,
        ]);
    }

    /**
     * Helper to download remote images and store in public/uploads/invitations/{id}
     */
    public function downloadAndStoreRemoteImage(string $url, Invitation $invitation): string
    {
        $url = trim($url);
        if (empty($url)) {
            return '';
        }

        // If already local uploaded file, return as-is
        if (str_contains($url, '/uploads/invitations/' . $invitation->id . '/')) {
            return $url;
        }

        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
            'Accept' => 'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.9',
        ];

        $fetchUrl = $url;
        // Unsplash photo page or ID
        if (preg_match('/unsplash\.com\/photos\/(?:[\w-]+-)?([a-zA-Z0-9_-]+)/i', $url, $m) && !str_contains($url, 'images.unsplash.com')) {
            $photoId = $m[1];
            $fetchUrl = "https://unsplash.com/photos/{$photoId}/download?force=true&w=1600";
        } elseif (preg_match('/drive\.google\.com\/(?:file\/d\/|open\?id=)([a-zA-Z0-9_-]+)/i', $url, $m)) {
            $fetchUrl = "https://drive.google.com/uc?export=download&id={$m[1]}";
        } elseif (str_contains($url, 'dropbox.com') && str_contains($url, 'dl=0')) {
            $fetchUrl = str_replace('dl=0', 'raw=1', $url);
        }

        try {
            $response = Http::withHeaders($headers)
                ->withOptions([
                    'force_ip_resolve' => 'v4',
                    'follow_redirects' => true,
                    'verify' => false,
                    'timeout' => 15,
                ])
                ->get($fetchUrl);

            // If response is HTML (e.g. Unsplash page fallback), extract og:image
            $contentType = $response->header('Content-Type') ?? '';
            if (str_contains($contentType, 'text/html')) {
                $html = $response->body();
                if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $ogMatch) ||
                    preg_match('/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:image["\']/i', $html, $ogMatch)) {
                    $ogImage = html_entity_decode($ogMatch[1]);
                    $response = Http::withHeaders($headers)
                        ->withOptions(['force_ip_resolve' => 'v4', 'follow_redirects' => true, 'verify' => false, 'timeout' => 15])
                        ->get($ogImage);
                    $contentType = $response->header('Content-Type') ?? '';
                }
            }

            if ($response->successful() && strlen($response->body()) > 100) {
                $ext = 'jpg';
                if (str_contains($contentType, 'png')) $ext = 'png';
                elseif (str_contains($contentType, 'webp')) $ext = 'webp';
                elseif (str_contains($contentType, 'gif')) $ext = 'gif';
                elseif (str_contains($contentType, 'svg')) $ext = 'svg';

                $fileName = 'invite_' . $invitation->id . '_' . time() . '_' . Str::random(8) . '.' . $ext;
                $destinationPath = public_path('uploads/invitations/' . $invitation->id);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                file_put_contents($destinationPath . '/' . $fileName, $response->body());
                return asset('uploads/invitations/' . $invitation->id . '/' . $fileName);
            }
        } catch (\Exception $e) {
            Log::warning("Failed to download remote image for invitation {$invitation->id}: " . $e->getMessage());
        }

        return $url;
    }
}
