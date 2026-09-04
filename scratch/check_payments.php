<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Invitations\InvitationOrder;
use App\Models\Invitations\InvitationPayment;
use Illuminate\Support\Facades\Log;

echo "=== PAYMENT AUDIT CHECK ===\n";
echo "Total Orders: " . InvitationOrder::count() . "\n";
echo "Total Payments: " . InvitationPayment::count() . "\n";

foreach (InvitationOrder::latest()->take(5)->get() as $ord) {
    echo "Order: {$ord->order_number} | Status: {$ord->status} | Amount: {$ord->final_amount} {$ord->currency} | Gateway: {$ord->payment_gateway}\n";
}

foreach (InvitationPayment::latest()->take(5)->get() as $pmt) {
    echo "Payment: ID {$pmt->id} | Order ID: {$pmt->order_id} | Status: {$pmt->status} | Ref: {$pmt->transaction_ref}\n";
}
