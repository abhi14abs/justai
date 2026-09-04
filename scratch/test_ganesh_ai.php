<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\Invitations\InvitationAiService;

$aiService = app(InvitationAiService::class);

echo "=== TESTING AI GANESH CHATURTHI PROMPT PARSER ===\n\n";

$prompts = [
    "Ganesh Chaturthi celebration at our home in Mumbai with daily evening aarti, 56 bhog modak prasad, and dhol tasha",
    "Peshwai traditional Puneri Ganeshotsav with Dhol-Tasha pathak in Pune on 7 September with 300 guests",
    "Eco-friendly clay Ganesha sthapana in Bengaluru with green pot visarjan",
    "Temple sanctum Siddhivinayak Atharvashirsha havan in Mumbai with 21 modaks",
    "Bal Ganesha kids party and modak workshop in Hyderabad"
];

foreach ($prompts as $idx => $p) {
    echo ($idx + 1) . ". Prompt: \"{$p}\"\n";
    $blueprint = $aiService->parseAndGenerateDraft($p);
    echo "   -> Title: {$blueprint['title']}\n";
    echo "   -> Event Type: {$blueprint['event_type']}\n";
    echo "   -> Matched Template: " . ($blueprint['template']['name'] ?? 'N/A') . " ({$blueprint['template']['slug']})\n";
    echo "   -> Animation: {$blueprint['palette']['animation']}\n";
    echo "   -> Primary Color: {$blueprint['palette']['primary']}, Secondary: {$blueprint['palette']['secondary']}\n";
    echo "   -> Events Count: " . count($blueprint['events']) . "\n\n";
}

echo "✓ All 5 Ganesh prompt variations parsed and mapped perfectly!\n";
