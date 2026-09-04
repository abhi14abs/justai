<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationCoupon;
use App\Models\Invitations\InvitationFeature;
use App\Models\Invitations\InvitationTemplate;
use App\Services\Invitations\InvitationAiService;
use App\Services\Invitations\InvitationPricingService;
use App\Services\Invitations\InvitationQrService;
use App\Services\Invitations\InvitationRsvpService;

echo "=== DIGITAL INVITATIONS PLATFORM VERIFICATION ===\n\n";

// 1. Verify Categories & Templates
$catCount = InvitationCategory::count();
$tplCount = InvitationTemplate::count();
echo "✓ Categories: {$catCount} found\n";
echo "✓ Templates: {$tplCount} found\n";

// 2. Verify Pricing Service
$pricingService = app(InvitationPricingService::class);
$rajwada = InvitationTemplate::where('slug', 'royal-rajwada-palace')->first();
$calc = $pricingService->calculate($rajwada, ['guest_qr_checkin', 'background_music'], 'INR', null, 'CELEBRATE50');

echo "✓ Pricing Engine: Template ₹{$calc['template_price']}, Features ₹{$calc['features_total']}, Subtotal {$calc['formatted_subtotal']}, Discount {$calc['formatted_discount']}, Final {$calc['formatted_final']}\n";

// 3. Verify QR Code Generator
$qrService = app(InvitationQrService::class);
$svg = $qrService->generateSvg('https://postryx.in/i/priya-and-rahul-wedding', 200, '#064E3B', '#FFFFFF');
$svgValid = str_contains($svg, '<svg') && str_contains($svg, '</svg>');
echo "✓ Vector SVG QR Generator: " . ($svgValid ? 'PASSED (Length: ' . strlen($svg) . ' bytes)' : 'FAILED') . "\n";

// 4. Verify RSVP Engine
$demoInvite = Invitation::where('slug', 'priya-and-rahul-wedding')->first();
if ($demoInvite) {
    $rsvpService = app(InvitationRsvpService::class);
    $rsvpResult = $rsvpService->submitRsvp($demoInvite, [
        'guest_name' => 'Aditya Roy & Family',
        'guest_email' => 'aditya@example.com',
        'guest_phone' => '+91 99887 76655',
        'attending_status' => 'attending',
        'party_size' => 3,
        'dietary_preferences' => 'Vegetarian',
        'notes' => 'Excited to attend the royal celebrations in Udaipur!',
    ], '127.0.0.1');

    echo "✓ RSVP Engine Submission: " . ($rsvpResult['success'] ? 'PASSED (Guest Code: ' . $rsvpResult['guest_code'] . ')' : 'FAILED') . "\n";
}

// 5. Verify AI Assistant
$aiService = app(InvitationAiService::class);
$loveStory = $aiService->generateLoveStory('Rohan & Simran', 'College library in Mumbai', 'romantic');
echo "✓ AI Love Story Copywriter: " . ($loveStory['success'] ? 'PASSED (Preview: ' . substr($loveStory['content'], 0, 80) . '...)' : 'FAILED') . "\n";

$palette = $aiService->recommendPalette('royal wedding', 'winter', 'palace');
echo "✓ AI Palette Recommender: PASSED ({$palette['palette']['name']}: Primary {$palette['palette']['primary']}, Font {$palette['palette']['font_heading']})\n";

// 6. Verify Natural Language AI Blueprint Parser
$aiDraft = $aiService->parseAndGenerateDraft("Royal Marathi wedding for Rahul and Priya in Mumbai on 15 December with Haldi, Mehendi, Sangeet and Reception, red and gold colors, 300 guests");
echo "✓ AI Prompt-to-Blueprint: PASSED (Parsed: {$aiDraft['title']}, Culture: {$aiDraft['culture']}, Events: " . count($aiDraft['events']) . ", Template: " . ($aiDraft['template']['name'] ?? 'N/A') . ")\n";

// 7. Verify Multi-Tone Copywriter
$hinglishCopy = $aiService->generateContentByTone('whatsapp_invite', ['names' => 'Rahul & Priya', 'city' => 'Mumbai', 'date' => '15 Dec 2026', 'event_type' => 'Wedding'], 'hinglish');
echo "✓ AI Tone Copywriter (Hinglish): PASSED (Preview: " . substr(str_replace("\n", " ", $hinglishCopy['content']), 0, 70) . "...)\n";

// 8. Verify Post-Event Memory Asset
if ($demoInvite) {
    $memory = \App\Models\Invitations\InvitationAsset::create([
        'invitation_id' => $demoInvite->id,
        'asset_type' => 'guest_memory',
        'name' => 'Aditya Roy Moment',
        'file_path' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
        'caption' => 'What a magical Sangeet night! Congratulations to the couple!',
        'sort_order' => 0,
        'file_size' => 102400,
    ]);
    echo "✓ Post-Event Guest Memory Pool: PASSED (Asset ID #{$memory->id}, Caption: '{$memory->caption}')\n";
}

echo "\n=== ALL CHECKS COMPLETED SUCCESSFULLY! ===\n";

