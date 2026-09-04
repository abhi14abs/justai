<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Invitations\InvitationTemplate;
use App\Models\Invitations\Invitation;

echo "=== TESTING TEMPLATE PREVIEW RESOLUTION ===\n";
foreach (InvitationTemplate::all() as $t) {
    $sample = Invitation::where('template_id', $t->id)->where('status', 'published')->first();
    echo sprintf(
        "Template [%-35s] -> Sample: %-40s | Theme Secondary: %s | Events: %d\n",
        $t->slug,
        $sample ? $sample->slug : 'NONE',
        $sample ? $sample->secondary_color : 'N/A',
        $sample ? $sample->events->count() : 0
    );
}
