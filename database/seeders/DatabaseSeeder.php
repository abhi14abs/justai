<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Account
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@postryx.in'],
            [
                'name' => 'Postryx Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
                'plan' => 'lifetime',
                'credits_remaining' => 999999,
                'affiliate_code' => 'admin'
            ]
        );

        // 2. Demo Creator Affiliate Account
        $creator = \App\Models\User::firstOrCreate(
            ['email' => 'creator@postryx.in'],
            [
                'name' => 'Aarav Creator',
                'password' => \Illuminate\Support\Facades\Hash::make('creator123'),
                'role' => 'user',
                'plan' => 'pro',
                'credits_remaining' => 999999,
                'affiliate_code' => 'creator'
            ]
        );

        \App\Models\Affiliate::firstOrCreate(
            ['user_id' => $creator->id],
            [
                'affiliate_code' => 'creator',
                'commission_rate' => 30.00,
                'payout_method' => 'upi',
                'payout_details' => 'creator@okhdfcbank',
                'total_clicks' => 342,
                'total_referrals' => 14,
                'total_earnings' => 14392.80,
                'pending_payout' => 4310.00,
                'paid_payout' => 10082.80
            ]
        );

        // 3. SEO Pillar Blog Guides
        $this->call(BlogSeeder::class);

        // 4. Digital Invitation Platform Seeder
        $this->call(InvitationPlatformSeeder::class);
    }
}
