<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationTemplate;
use App\Models\Invitations\Invitation;

echo "=== GANESH CHATURTHI TEMPLATES VERIFICATION ===\n\n";

$cat = InvitationCategory::where('slug', 'festivals-puja')->first();
echo "Category: {$cat->name} (Slug: {$cat->slug})\n";
echo "Subcategories: " . $cat->subcategories->pluck('name')->join(', ') . "\n\n";

$ganeshTemplates = InvitationTemplate::where('category_id', $cat->id)->get();
echo "Found " . $ganeshTemplates->count() . " Festival & Ganesh Chaturthi Templates:\n";

foreach ($ganeshTemplates as $idx => $t) {
    echo ($idx + 1) . ". {$t->name}\n";
    echo "   - Slug: {$t->slug}\n";
    echo "   - Colors: Primary {$t->theme_config['primary_color']}, Secondary {$t->theme_config['secondary_color']}, Accent {$t->theme_config['accent_color']}\n";
    echo "   - Animation: {$t->theme_config['animation_style']}\n";
    echo "   - Thumbnail: {$t->thumbnail_url}\n";
    echo "   - Sections Count: " . $t->sections->count() . "\n";
    echo "   - Base Price: ₹{$t->base_price_inr} / \${$t->base_price_usd}\n\n";
}

$demoInvite = Invitation::where('slug', 'shree-ganeshotsav-2026')->first();
if ($demoInvite) {
    echo "✓ Live Demo Invitation Seeded: {$demoInvite->title}\n";
    echo "  - URL: " . url('/i/' . $demoInvite->slug) . "\n";
    echo "  - Events Count: " . $demoInvite->events->count() . "\n";
    echo "  - Enabled Sections: " . $demoInvite->enabledSections->count() . "\n";
    echo "  - Form Fields: " . $demoInvite->rsvpForm->fields->count() . "\n";
}
