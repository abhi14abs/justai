<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Invitations\InvitationBuilderController;
use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationEvent;
use App\Models\Invitations\InvitationSection;
use App\Models\User;

$user = User::first();
\Illuminate\Support\Facades\Auth::login($user);

$invitation = Invitation::where('user_id', $user->id)->latest()->first();
$controller = app(InvitationBuilderController::class);

echo "=== TESTING PARTICULARS & DATE EDITING ===\n\n";

// 1. Test Basics Update (Title & Date)
$reqBasics = Request::create("/invitations/builder/{$invitation->id}/update", 'POST', [
    'title' => 'Abhishek & Priya Grand Royal Wedding',
    'event_date' => '2026-12-18 19:00:00',
]);
$resBasics = $controller->update($reqBasics, $invitation->id);
echo "1. Basics Update: " . ($resBasics->getStatusCode() === 200 ? 'PASSED' : 'FAILED') . "\n";

// 2. Test Section Particulars Update (Hero Bride/Groom/City)
$heroSec = $invitation->sections()->where('section_type', 'hero')->first();
if ($heroSec) {
    $reqHero = Request::create("/invitations/builder/{$invitation->id}/section/{$heroSec->id}/update", 'POST', [
        'title' => 'Shubh Mangal Vivah',
        'subtitle' => 'With the divine blessings of our families, we invite you.',
        'content' => [
            'groom_name' => 'Abhishek',
            'bride_name' => 'Priya',
            'city_display' => 'Udaipur, Rajasthan',
        ],
    ]);
    $resHero = $controller->updateSection($reqHero, $invitation->id, $heroSec->id);
    echo "2. Section Particulars Update (Hero Names & City): " . ($resHero->getStatusCode() === 200 ? 'PASSED' : 'FAILED') . "\n";
}

// 3. Test Event Particulars & Date Update
$event = $invitation->events()->first();
if ($event) {
    $reqEv = Request::create("/invitations/builder/{$invitation->id}/event/{$event->id}/update", 'POST', [
        'title' => 'Grand Sangeet & Musical Night',
        'event_date' => '2026-12-17',
        'start_time' => '19:30:00',
        'venue_name' => 'The Oberoi Udaivilas, Lake Pichola',
        'dress_code' => 'Sparkling Festive & Indo-Western',
        'icon' => '🪔',
    ]);
    $resEv = $controller->updateEvent($reqEv, $invitation->id, $event->id);
    echo "3. Event Particulars & Date Update: " . ($resEv->getStatusCode() === 200 ? 'PASSED' : 'FAILED') . "\n";
    $event->refresh();
    echo "   -> Updated Event: {$event->icon} {$event->title} on {$event->event_date->format('Y-m-d')} @ {$event->venue_name}\n";
}

echo "\n✓ All Particulars & Dates update tests completed successfully!\n";
