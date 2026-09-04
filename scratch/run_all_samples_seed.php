<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

require_once 'database/seeders/AllTemplatesSampleInvitationsSeeder.php';

$seeder = new Database\Seeders\AllTemplatesSampleInvitationsSeeder();
$seeder->run();
echo "\nDONE RUNNING ALL TEMPLATES SAMPLE SEEDER!\n";
