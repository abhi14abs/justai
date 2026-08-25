@extends('layouts.app')

@section('title', 'Affiliate Partner Dashboard — 30% Recurring Earnings | Postryx AI')
@section('meta_description', 'Track your 30% recurring affiliate commissions, referral clicks, conversions, wallet balance, and payout requests.')

@section('content')

<section style="padding: 50px 24px 80px; max-width: 1200px; margin: 0 auto;">
    
    {{-- Header Banner --}}
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 36px; padding-bottom: 24px; border-bottom: 1px solid var(--border-subtle);">
        <div>
            <div class="badge-pill-emerald" style="margin-bottom: 8px;">★ Official Postryx Partner</div>
            <h1 style="font-size: 32px; font-weight: 800; color: #fff;">
                Affiliate Partner Dashboard
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px;">Earn <strong>30% lifetime recurring commission</strong> on every subscriber you refer.</p>
        </div>

        <div style="display: flex; gap: 12px;">
            <a href="{{ route('dashboard') }}" class="btn-secondary" style="padding: 10px 18px; font-size: 13px;">
                &larr; User Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 12px; padding: 14px 20px; margin-bottom: 28px; font-size: 14px; color: #6ee7b7;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.4); border-radius: 12px; padding: 14px 20px; margin-bottom: 28px; font-size: 14px; color: #fca5a5;">
        {{ session('error') }}
    </div>
    @endif

    {{-- Referral Link Banner --}}
    <div class="glass-panel-glow" style="padding: 24px 28px; margin-bottom: 36px;">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
            <div>
                <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 4px;">Your Unique Partner Referral Link:</div>
                <div style="font-family: monospace; font-size: 18px; color: #38bdf8; font-weight: 700;" id="affiliate-link-text">
                    {{ url('/?ref=' . $affiliate->affiliate_code) }}
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button onclick="Postryx.copy(document.getElementById('affiliate-link-text').textContent.trim(), this)" class="btn-primary" style="padding: 10px 20px; font-size: 14px; font-weight: 700;">
                    📋 Copy Referral Link
                </button>
            </div>
        </div>
    </div>

    {{-- 4 Financial & Conversion Stat Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 36px;">
        
        <div class="glass-panel" style="padding: 24px;">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Total Lifetime Earnings</div>
            <div style="font-size: 32px; font-weight: 800; color: #10b981;">
                ₹{{ number_format($affiliate->total_earnings, 2) }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">30% recurring commission</div>
        </div>

        <div class="glass-panel" style="padding: 24px; border-color: rgba(99,102,241,0.4);">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Pending Wallet Balance</div>
            <div style="font-size: 32px; font-weight: 800; color: #38bdf8;">
                ₹{{ number_format($affiliate->pending_payout, 2) }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Available for withdrawal</div>
        </div>

        <div class="glass-panel" style="padding: 24px;">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Total Referral Clicks</div>
            <div style="font-size: 32px; font-weight: 800; color: #a855f7;">
                {{ number_format($clicksCount) }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Unique link visitors</div>
        </div>

        <div class="glass-panel" style="padding: 24px;">
            <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">Paid Subscribers</div>
            <div style="font-size: 32px; font-weight: 800; color: #fff;">
                {{ $commissionOrders->count() }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Active paying referrals</div>
        </div>

    </div>

    {{-- Payout Settings & Request Section --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px; margin-bottom: 40px;">
        
        {{-- Payout Settings Form --}}
        <div class="glass-panel" style="padding: 28px;">
            <h3 style="font-size: 18px; color: #fff; margin-bottom: 16px;">Payout Account Details</h3>
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 18px;">Specify where you want to receive your affiliate commissions:</p>

            <form action="{{ route('affiliate.settings') }}" method="POST" style="display: flex; flex-direction: column; gap: 14px;">
                @csrf
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Payout Method:</label>
                    <select name="payout_method" class="postryx-input" style="padding: 10px 14px; font-size: 13px;">
                        <option value="upi" {{ $affiliate->payout_method === 'upi' ? 'selected' : '' }}>🇮🇳 UPI (GPay, PhonePe, Paytm, BHIM)</option>
                        <option value="bank_transfer" {{ $affiliate->payout_method === 'bank_transfer' ? 'selected' : '' }}>🏦 Direct Bank Transfer (NEFT/IMPS)</option>
                        <option value="paypal" {{ $affiliate->payout_method === 'paypal' ? 'selected' : '' }}>🌐 PayPal (International USD)</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Payment Details (UPI ID / Bank Account / PayPal Email):</label>
                    <textarea name="payout_details" class="postryx-textarea" style="min-height: 80px; font-size: 13px;" placeholder="e.g. name@okhdfcbank or Bank Account No + IFSC or paypal@example.com" required>{{ $affiliate->payout_details }}</textarea>
                </div>

                <button type="submit" class="btn-secondary" style="padding: 10px; font-size: 13px; font-weight: 600;">
                    Save Payout Details
                </button>
            </form>
        </div>

        {{-- Request Payout Box --}}
        <div class="glass-panel-glow" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="font-size: 18px; color: #fff; margin-bottom: 10px;">Withdraw Earnings</h3>
                <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">
                    Minimum payout threshold is ₹100 / $5. Payouts are reviewed and disbursed within 24-48 hours.
                </p>

                <div style="background: rgba(11, 17, 33, 0.8); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 18px; margin-bottom: 20px; text-align: center;">
                    <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Available for Withdrawal:</div>
                    <div style="font-size: 32px; font-weight: 800; color: #10b981;">₹{{ number_format($affiliate->pending_payout, 2) }}</div>
                    <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">
                        Method: <strong>{{ strtoupper($affiliate->payout_method) }}</strong> ({{ Str::limit($affiliate->payout_details ?? 'Not configured', 30) }})
                    </div>
                </div>
            </div>

            <form action="{{ route('affiliate.requestPayout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-glow-cyan btn-primary" style="width: 100%; padding: 12px; font-size: 14px; font-weight: 700;" {{ $affiliate->pending_payout < 100 ? 'disabled' : '' }}>
                    {{ $affiliate->pending_payout >= 100 ? 'Request Payout of ₹' . number_format($affiliate->pending_payout, 2) . ' 💸' : 'Threshold ₹100 Required to Withdraw' }}
                </button>
            </form>
        </div>

    </div>

    {{-- Commission Orders History Table --}}
    <div class="glass-panel" style="padding: 28px; margin-bottom: 40px;">
        <h3 style="font-size: 18px; color: #fff; margin-bottom: 16px;">Commissions Log (30% Recurring)</h3>
        
        @if($commissionOrders->count() > 0)
        <div class="table-responsive" style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; min-width: 650px;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-subtle); color: var(--text-muted);">
                        <th style="padding: 12px 16px;">Order #</th>
                        <th style="padding: 12px 16px;">Subscriber</th>
                        <th style="padding: 12px 16px;">Plan</th>
                        <th style="padding: 12px 16px;">Order Amount</th>
                        <th style="padding: 12px 16px;">Your 30% Cut</th>
                        <th style="padding: 12px 16px;">Date</th>
                        <th style="padding: 12px 16px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commissionOrders as $co)
                    <tr style="border-bottom: 1px solid var(--border-subtle);">
                        <td style="padding: 14px 16px; font-family: monospace; color: #38bdf8;">{{ $co->order_number }}</td>
                        <td style="padding: 14px 16px; color: #fff;">{{ Str::mask($co->customer_email, '*', 3, -4) }}</td>
                        <td style="padding: 14px 16px; font-weight: 600;">{{ ucfirst($co->plan) }}</td>
                        <td style="padding: 14px 16px;">{{ $co->currency === 'INR' ? '₹' : '$' }}{{ number_format($co->amount, 2) }}</td>
                        <td style="padding: 14px 16px; font-weight: 700; color: #10b981;">+₹{{ number_format($co->affiliate_commission_amount, 2) }}</td>
                        <td style="padding: 14px 16px; color: var(--text-muted);">{{ $co->created_at->format('M d, Y') }}</td>
                        <td style="padding: 14px 16px;">
                            <span class="badge-pill-emerald" style="font-size: 11px;">CREDITED</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align: center; padding: 30px; color: var(--text-muted); font-size: 14px;">
            No referral sales yet. Share your partner link <code>{{ url('/?ref=' . $affiliate->affiliate_code) }}</code> on Twitter, LinkedIn, and YouTube to start earning 30% monthly recurring commissions!
        </div>
        @endif
    </div>

</section>

@endsection
