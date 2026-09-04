<?php

namespace App\Http\Controllers\Invitations\Api;

use App\Http\Controllers\Controller;
use App\Models\Invitations\InvitationCoupon;
use App\Models\Invitations\InvitationTemplate;
use App\Services\Invitations\InvitationAiService;
use App\Services\Invitations\InvitationPricingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvitationApiController extends Controller
{
    protected InvitationPricingService $pricingService;
    protected InvitationAiService $aiService;

    public function __construct(InvitationPricingService $pricingService, InvitationAiService $aiService)
    {
        $this->pricingService = $pricingService;
        $this->aiService = $aiService;
    }

    /**
     * Calculate Live Pricing Breakdown.
     */
    public function calculatePricing(Request $request): JsonResponse
    {
        $templateId = $request->input('template_id');
        $features = $request->input('features', []);
        $currency = $request->input('currency', 'INR');
        $coupon = $request->input('coupon');

        $template = null;
        if (!empty($templateId)) {
            $template = InvitationTemplate::find($templateId);
        }

        $pricing = $this->pricingService->calculate($template, $features, $currency, null, $coupon);

        return response()->json([
            'success' => true,
            'pricing' => $pricing,
        ]);
    }

    /**
     * Validate Invitation Coupon Code.
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->input('code', '')));
        $amount = (float) $request->input('amount', 0);

        if (empty($code)) {
            return response()->json(['success' => false, 'error' => 'Please provide a coupon code.'], 422);
        }

        $coupon = InvitationCoupon::where('code', $code)->where('is_active', true)->first();
        if (!$coupon || !$coupon->isValid($amount)) {
            return response()->json(['success' => false, 'error' => 'Invalid or expired coupon code.'], 404);
        }

        $discount = $coupon->calculateDiscount($amount);

        return response()->json([
            'success' => true,
            'coupon' => [
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => (float) $coupon->discount_value,
                'discount_amount' => $discount,
            ],
            'message' => 'Coupon applied successfully!',
        ]);
    }

    /**
     * AI Love Story Copywriter.
     */
    public function generateLoveStory(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'couple_names' => 'required|string|max:200',
            'how_they_met' => 'nullable|string|max:1000',
            'tone' => 'nullable|string|max:50',
        ]);

        $result = $this->aiService->generateLoveStory(
            $validated['couple_names'],
            $validated['how_they_met'] ?? '',
            $validated['tone'] ?? 'romantic'
        );

        return response()->json($result);
    }

    /**
     * AI Poetic Invitation Invocation.
     */
    public function generatePoeticWording(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'couple_names' => 'required|string|max:200',
            'host_names' => 'required|string|max:200',
            'event_type' => 'nullable|string|max:100',
            'style' => 'nullable|string|max:50',
        ]);

        $result = $this->aiService->generatePoeticWording(
            $validated['couple_names'],
            $validated['host_names'],
            $validated['event_type'] ?? 'Wedding',
            $validated['style'] ?? 'royal'
        );

        return response()->json($result);
    }

    /**
     * AI Palette Recommender.
     */
    public function recommendPalette(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_type' => 'required|string|max:100',
            'season' => 'nullable|string|max:50',
            'venue_type' => 'nullable|string|max:100',
        ]);

        $result = $this->aiService->recommendPalette(
            $validated['event_type'],
            $validated['season'] ?? 'winter',
            $validated['venue_type'] ?? 'palace'
        );

        return response()->json($result);
    }

    /**
     * Parse Natural Language Prompt to Generate Full Invitation Blueprint.
     */
    public function parseAiPrompt(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => 'required|string|min:5|max:1000',
        ]);

        $blueprint = $this->aiService->parseAndGenerateDraft($validated['prompt']);

        return response()->json($blueprint);
    }

    /**
     * Multi-Tone AI Copywriter.
     */
    public function generateToneCopy(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'content_type' => 'required|string|max:50',
            'details' => 'required|array',
            'tone' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:20',
        ]);

        $result = $this->aiService->generateContentByTone(
            $validated['content_type'],
            $validated['details'],
            $validated['tone'] ?? 'luxury',
            $validated['language'] ?? 'en'
        );

        return response()->json($result);
    }

    /**
     * 1-Click Provision Invitation directly from Natural Language AI Prompt.
     */
    public function createFromAiPrompt(Request $request): JsonResponse
    {
        $user = \Illuminate\Support\Facades\Auth::user() ?? \App\Models\User::first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Please sign in to create invitations.'], 401);
        }

        $validated = $request->validate([
            'prompt' => 'required|string|min:5|max:1000',
        ]);

        $blueprint = $this->aiService->parseAndGenerateDraft($validated['prompt']);
        
        $templateSlug = $blueprint['template']['slug'] ?? 'royal-rajwada-palace';
        $template = InvitationTemplate::where('slug', $templateSlug)->first() ?? InvitationTemplate::first();

        $templateService = app(\App\Services\Invitations\InvitationTemplateService::class);
        $invitation = $templateService->createInvitationFromTemplate($template, $user->id, [
            'title' => $blueprint['title'],
            'primary_color' => $blueprint['palette']['primary'] ?? '#D4AF37',
            'secondary_color' => $blueprint['palette']['secondary'] ?? '#064E3B',
            'accent_color' => $blueprint['palette']['accent'] ?? '#F59E0B',
            'font_family_heading' => $blueprint['palette']['font_heading'] ?? 'Cinzel Decorative',
            'font_family_body' => $blueprint['palette']['font_body'] ?? 'Outfit',
            'animation_style' => $blueprint['palette']['animation'] ?? 'sparkles_float',
            'event_date' => $blueprint['event_date'] . ' 18:00:00',
            'selected_features' => $blueprint['suggested_features'],
        ]);

        // Overwrite or create customized events
        if (!empty($blueprint['events'])) {
            $invitation->events()->delete();
            foreach ($blueprint['events'] as $eIdx => $evt) {
                \App\Models\Invitations\InvitationEvent::create([
                    'invitation_id' => $invitation->id,
                    'title' => $evt['title'],
                    'event_date' => $evt['date'],
                    'start_time' => $evt['time'] . ':00',
                    'venue_name' => $evt['venue'],
                    'dress_code' => $evt['dress_code'] ?? null,
                    'icon' => $evt['icon'] ?? '✨',
                    'sort_order' => $eIdx + 1,
                ]);
            }
        }

        // Update Hero section with names
        $heroSection = $invitation->sections()->where('section_type', 'hero')->first();
        if ($heroSection) {
            $content = $heroSection->content ?? [];
            $content['groom_name'] = $blueprint['groom_name'] ?? 'Rahul';
            $content['bride_name'] = $blueprint['bride_name'] ?? 'Priya';
            $content['city_display'] = $blueprint['city'] ?? 'Mumbai, India';
            $heroSection->update([
                'subtitle' => $blueprint['intro_text'],
                'content' => $content,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'AI Invitation created successfully!',
            'invitation_id' => $invitation->id,
            'redirect_url' => route('invitations.builder.edit', $invitation->id),
        ]);
    }
}

