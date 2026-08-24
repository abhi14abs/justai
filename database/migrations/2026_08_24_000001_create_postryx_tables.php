<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Enhance Users Table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }
            if (!Schema::hasColumn('users', 'plan')) {
                $table->string('plan')->default('free')->after('role'); // free, starter, pro, agency, lifetime
            }
            if (!Schema::hasColumn('users', 'plan_expires_at')) {
                $table->timestamp('plan_expires_at')->nullable()->after('plan');
            }
            if (!Schema::hasColumn('users', 'credits_remaining')) {
                $table->integer('credits_remaining')->default(5)->after('plan_expires_at');
            }
            if (!Schema::hasColumn('users', 'referred_by_id')) {
                $table->unsignedBigInteger('referred_by_id')->nullable()->after('credits_remaining');
            }
            if (!Schema::hasColumn('users', 'affiliate_code')) {
                $table->string('affiliate_code')->nullable()->unique()->after('referred_by_id');
            }
        });

        // 2. Affiliates Table
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('affiliate_code')->unique();
            $table->string('payout_method')->default('upi'); // upi, paypal, bank_transfer
            $table->text('payout_details')->nullable(); // JSON or formatted text
            $table->decimal('commission_rate', 5, 2)->default(30.00); // 30% recurring
            $table->unsignedInteger('total_clicks')->default(0);
            $table->unsignedInteger('total_referrals')->default(0);
            $table->decimal('total_earnings', 12, 2)->default(0.00);
            $table->decimal('pending_payout', 12, 2)->default(0.00);
            $table->decimal('paid_payout', 12, 2)->default(0.00);
            $table->timestamps();
        });

        // 3. Referral Clicks Table
        Schema::create('referral_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('affiliates')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('referrer_url', 1000)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
        });

        // 4. Orders / Transactions Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('affiliate_id')->nullable()->constrained('affiliates')->onDelete('set null');
            $table->string('plan'); // starter, pro, agency, lifetime
            $table->string('billing_cycle')->default('monthly'); // monthly, annual, lifetime
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('INR'); // INR, USD
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->string('coupon_code')->nullable();
            $table->string('payment_gateway')->default('razorpay'); // paypal, razorpay, stripe, upi_qr
            $table->string('gateway_order_id')->nullable();
            $table->string('gateway_payment_id')->nullable();
            $table->string('gateway_signature')->nullable();
            $table->string('status')->default('pending'); // pending, completed, failed, refunded
            $table->decimal('affiliate_commission_amount', 10, 2)->default(0.00);
            $table->boolean('is_commission_credited')->default(false);
            $table->string('customer_email')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        // 5. Affiliate Payouts Table
        Schema::create('affiliate_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('affiliates')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('INR');
            $table->string('payment_method')->default('upi');
            $table->text('payout_details')->nullable();
            $table->string('transaction_ref')->nullable(); // UPI UTR or Bank Reference
            $table->string('status')->default('pending'); // pending, processing, completed, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        // 6. Generations History Table
        Schema::create('generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('tool', 50);
            $table->text('topic');
            $table->string('tone', 50)->nullable();
            $table->longText('content');
            $table->unsignedInteger('word_count')->default(0);
            $table->unsignedInteger('char_count')->default(0);
            $table->string('provider', 50)->default('heuristic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generations');
        Schema::dropIfExists('affiliate_payouts');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('referral_clicks');
        Schema::dropIfExists('affiliates');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'plan', 'plan_expires_at', 'credits_remaining', 'referred_by_id', 'affiliate_code']);
        });
    }
};
