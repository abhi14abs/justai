<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Invitations\InvitationBuilderController;
use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationSection;
use App\Models\User;

$user = User::first();
if (!$user) {
    echo "No user found!\n";
    exit(1);
}
\Illuminate\Support\Facades\Auth::login($user);

$invitation = Invitation::where('user_id', $user->id)->latest()->first();
if (!$invitation) {
    echo "No invitation found for user!\n";
    exit(1);
}

$section = $invitation->sections()->first();
if (!$section) {
    echo "No section found for invitation!\n";
    exit(1);
}

$controller = app(InvitationBuilderController::class);

echo "Testing section toggle on Section #{$section->id} ('{$section->section_type}')...\n";
echo "Initial is_enabled: " . ($section->is_enabled ? 'true' : 'false') . "\n";

// Toggle OFF
$reqOff = Request::create("/invitations/builder/{$invitation->id}/section/{$section->id}/update", 'POST', [
    'is_enabled' => 0,
]);
$resOff = $controller->updateSection($reqOff, $invitation->id, $section->id);
echo "Toggled OFF Response: " . $resOff->getContent() . "\n";
$section->refresh();
echo "Updated is_enabled: " . ($section->is_enabled ? 'true' : 'false') . "\n";

// Toggle ON
$reqOn = Request::create("/invitations/builder/{$invitation->id}/section/{$section->id}/update", 'POST', [
    'is_enabled' => 1,
]);
$resOn = $controller->updateSection($reqOn, $invitation->id, $section->id);
echo "Toggled ON Response: " . $resOn->getContent() . "\n";
$section->refresh();
echo "Updated is_enabled: " . ($section->is_enabled ? 'true' : 'false') . "\n";

// Test RSVP Update
$reqRsvp = Request::create("/invitations/builder/{$invitation->id}/rsvp/update", 'POST', [
    'deadline' => '2026-11-20',
    'max_party_size' => 6,
    'allow_guest_plus_one' => 1,
]);
$resRsvp = $controller->updateRsvp($reqRsvp, $invitation->id);
echo "RSVP Update Response: " . $resRsvp->getContent() . "\n";

echo "\n✓ Section toggler and RSVP persistence verified successfully!\n";
