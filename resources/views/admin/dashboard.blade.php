@extends('layouts.admin')

@section('title', 'Admin Overview — Postryx Master Portal')

@section('content')

<div style="margin-bottom: 32px;">
    <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 6px;">
        Analytics &amp; Revenue Overview
    </h1>
    <p style="color: var(--text-secondary); font-size: 14px;">Live tracking of subscriptions, customer acquisition, payouts, and AI engine velocity.</p>
</div>

{{-- Top KPI Metric Cards --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 36px;">
    
    {{-- Total Gross Revenue --}}
    <div class="glass-panel" style="padding: 24px; position: relative; overflow: hidden;">
        <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Total Gross Revenue</div>
        <div style="font-size: 32px; font-weight: 900; color: #10b981; line-height: 1.1;">
            ₹{{ number_format($totalRevenueINR, 2) }}
        </div>
        <div style="font-size: 13px; color: var(--text-secondary); margin-top: 6px;">
            + ${{ number_format($totalRevenueUSD, 2) }} USD (PayPal)
        </div>
    </div>

    {{-- Completed Orders --}}
    <div class="glass-panel" style="padding: 24px;">
        <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Paid Orders Completed</div>
        <div style="font-size: 32px; font-weight: 900; color: #38bdf8; line-height: 1.1;">
            {{ $completedOrdersCount }}
        </div>
        <div style="font-size: 13px; color: var(--text-secondary); margin-top: 6px;">
            Total Checkout Attempts: {{ $totalOrdersCount }}
        </div>
    </div>

    {{-- Total Users & Paid Conversion --}}
    <div class="glass-panel" style="padding: 24px;">
        <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Active User Accounts</div>
        <div style="font-size: 32px; font-weight: 900; color: #c084fc; line-height: 1.1;">
            {{ $totalUsers }}
        </div>
        <div style="font-size: 13px; color: var(--text-secondary); margin-top: 6px;">
            <strong style="color: #6ee7b7;">{{ $paidSubscribers }}</strong> Paid Subscribers
        </div>
    </div>

    {{-- Affiliate Commissions --}}
    <div class="glass-panel" style="padding: 24px;">
        <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">30% Partner Commissions</div>
        <div style="font-size: 32px; font-weight: 900; color: #f59e0b; line-height: 1.1;">
            ₹{{ number_format($totalAffiliateCommissions, 2) }}
        </div>
        <div style="font-size: 13px; color: var(--text-secondary); margin-top: 6px;">
            Pending Payouts: ₹{{ number_format($pendingAffiliatePayouts, 2) }}
        </div>
    </div>

</div>

{{-- Pending Payout Requests Alert Section --}}
@if($pendingPayoutRequests->count() > 0)
<div class="glass-panel-glow" style="border-color: #f59e0b; padding: 28px; margin-bottom: 36px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div>
            <h3 style="font-size: 18px; color: #fff;">⚠️ Pending Affiliate Withdrawal Requests</h3>
            <p style="color: var(--text-secondary); font-size: 13px;">Review payout requests and enter transaction UTR to mark as disbursed.</p>
        </div>
        <span class="badge-pill-amber">{{ $pendingPayoutRequests->count() }} Actions Required</span>
    </div>

    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Affiliate User</th>
                <th>Amount</th>
                <th>Payout Destination</th>
                <th>Requested Date</th>
                <th>Process Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingPayoutRequests as $pr)
            <tr>
                <td style="font-family: monospace; color: #38bdf8;">#PO-{{ $pr->id }}</td>
                <td>
                    <div style="font-weight: 700; color: #fff;">{{ $pr->affiliate->user->name ?? 'Affiliate' }}</div>
                    <div style="font-size: 11px; color: var(--text-muted);">{{ $pr->affiliate->user->email ?? '' }}</div>
                </td>
                <td style="font-weight: 800; color: #10b981; font-size: 15px;">₹{{ number_format($pr->amount, 2) }}</td>
                <td>
                    <span class="badge-pill" style="font-size: 11px; text-transform: uppercase;">{{ $pr->payment_method }}</span>
                    <div style="font-family: monospace; font-size: 12px; color: #fff; margin-top: 4px;">{{ $pr->account_details }}</div>
                </td>
                <td style="color: var(--text-muted);">{{ $pr->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.payouts.process', $pr->id) }}" method="POST" style="display: flex; gap: 6px;">
                        @csrf
                        <input type="text" name="transaction_ref" placeholder="Enter Bank / UPI UTR" required class="postryx-input" style="padding: 6px 10px; font-size: 12px; width: 150px;">
                        <button type="submit" class="btn-primary" style="padding: 6px 12px; font-size: 12px; white-space: nowrap;">Mark Paid ✓</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Recent Transactions DataTable --}}
<div class="glass-panel" style="padding: 28px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h3 style="font-size: 18px; color: #fff;">Recent Order Transactions</h3>
            <p style="color: var(--text-secondary); font-size: 13px;">Real-time stream of incoming customer subscriptions.</p>
        </div>
        <a href="{{ route('admin.orders') }}" class="btn-secondary" style="padding: 8px 14px; font-size: 13px;">View All Orders &rarr;</a>
    </div>

    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Plan</th>
                <th>Gateway</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $ro)
            <tr>
                <td style="font-family: monospace; color: #38bdf8; font-weight: 700;">{{ $ro->order_number }}</td>
                <td>
                    <div style="font-weight: 600; color: #fff;">{{ $ro->customer_name ?? $ro->user->name ?? 'Guest User' }}</div>
                    <div style="font-size: 11px; color: var(--text-muted);">{{ $ro->customer_email ?? $ro->user->email ?? '' }}</div>
                </td>
                <td>
                    <span class="badge-pill" style="font-size: 11px;">{{ strtoupper($ro->plan) }}</span>
                </td>
                <td style="text-transform: uppercase; font-size: 12px; font-weight: 600;">{{ $ro->payment_gateway }}</td>
                <td style="font-weight: 800; color: #fff; font-size: 14px;">{{ $ro->currency === 'INR' ? '₹' : '$' }}{{ number_format($ro->amount, 2) }}</td>
                <td style="color: var(--text-muted); font-size: 12px;">{{ $ro->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <span class="badge-pill-{{ $ro->status === 'completed' ? 'emerald' : 'amber' }}" style="font-size: 11px;">
                        {{ strtoupper($ro->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
