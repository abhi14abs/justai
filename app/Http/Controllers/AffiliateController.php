<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\AffiliatePayout;
use App\Models\Order;
use App\Models\ReferralClick;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    /**
     * Public Affiliate Program Landing Page.
     */
    public function index()
    {
        $user = Auth::user();
        $affiliate = $user ? Affiliate::where('user_id', $user->id)->first() : null;

        return view('affiliate', [
            'user' => $user,
            'affiliate' => $affiliate
        ]);
    }

    /**
     * Protected Affiliate Partner Dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Ensure user has an affiliate profile
        $affiliate = Affiliate::firstOrCreate(
            ['user_id' => $user->id],
            [
                'affiliate_code' => $user->affiliate_code ?? Str::slug($user->name . '-' . Str::random(4)),
                'commission_rate' => 30.00,
                'payout_method' => 'upi',
                'payout_details' => 'Enter UPI ID'
            ]
        );

        $referralClicksCount = ReferralClick::where('affiliate_id', $affiliate->id)->count();
        $referralUsers = User::where('referred_by_id', $user->id)->latest()->get();
        $commissionOrders = Order::where('affiliate_id', $affiliate->id)
            ->where('status', 'completed')
            ->latest()
            ->get();
        $payoutHistory = AffiliatePayout::where('affiliate_id', $affiliate->id)->latest()->get();

        return view('affiliate.dashboard', [
            'user' => $user,
            'affiliate' => $affiliate,
            'clicksCount' => $referralClicksCount,
            'referralUsers' => $referralUsers,
            'commissionOrders' => $commissionOrders,
            'payoutHistory' => $payoutHistory
        ]);
    }

    /**
     * Save / Update Payout Settings (UPI / Bank / PayPal).
     */
    public function savePayoutSettings(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'payout_method' => 'required|string|in:upi,paypal,bank_transfer',
            'payout_details' => 'required|string|max:1000'
        ]);

        $affiliate = Affiliate::where('user_id', $user->id)->first();
        if ($affiliate) {
            $affiliate->payout_method = $validated['payout_method'];
            $affiliate->payout_details = $validated['payout_details'];
            $affiliate->save();
        }

        return back()->with('success', '✓ Payout details updated successfully!');
    }

    /**
     * Request Commission Payout.
     */
    public function requestPayout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $affiliate = Affiliate::where('user_id', $user->id)->first();
        if (!$affiliate) {
            return back()->with('error', 'Affiliate profile not found.');
        }

        $pendingAmount = (float) $affiliate->pending_payout;
        if ($pendingAmount < 100.00) {
            return back()->with('error', 'Minimum payout threshold is ₹100 / $5. Your current pending balance is ₹' . number_format($pendingAmount, 2));
        }

        // Create Payout Request in DB
        AffiliatePayout::create([
            'affiliate_id' => $affiliate->id,
            'amount' => $pendingAmount,
            'currency' => 'INR',
            'payment_method' => $affiliate->payout_method,
            'payout_details' => $affiliate->payout_details,
            'status' => 'pending'
        ]);

        // Move pending to paid or hold in processing
        $affiliate->pending_payout = 0.00;
        $affiliate->save();

        return back()->with('success', '🎉 Payout request for ₹' . number_format($pendingAmount, 2) . ' submitted successfully! Admin will process via ' . strtoupper($affiliate->payout_method) . ' within 24-48 hours.');
    }
}
