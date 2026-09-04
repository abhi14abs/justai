<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationTemplate;

echo "=== TEMPLATES ===\n";
foreach(InvitationTemplate::all() as $t) {
    echo "ID: {$t->id} | Slug: {$t->slug} | Name: {$t->name}\n";
}

echo "\n=== INVITATIONS ===\n";
foreach(Invitation::all() as $i) {
    echo "ID: {$i->id} | Slug: {$i->slug} | Template ID: {$i->template_id} | Title: {$i->title}\n";
}
