<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Invitations\Api\InvitationApiController;
use App\Services\Invitations\InvitationAiService;
use App\Models\User;

$user = User::first();
if (!$user) {
    echo "No user found in database!\n";
    exit(1);
}

// Log in as user
\Illuminate\Support\Facades\Auth::login($user);

$controller = app(InvitationApiController::class);

$request = Request::create('/api/invitations/ai/create', 'POST', [
    'prompt' => 'Royal Marathi wedding for Rahul and Priya in Mumbai on 15 December with Haldi, Mehendi, Sangeet and Reception, red and gold colors, 300 guests',
]);

$response = $controller->createFromAiPrompt($request);

echo "Status Code: " . $response->getStatusCode() . "\n";
echo "Response Body: " . $response->getContent() . "\n";
