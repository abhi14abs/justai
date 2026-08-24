@extends('layouts.admin')

@section('title', 'Affiliate Partners — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 4px;">
            Affiliate Partners &amp; 30% Recurring Commission
        </h1>
        <p style="color: var(--text-secondary); font-size: 14px;">Track partner referral links, click counts, paid subscriptions, and pending balances.</p>
    </div>
    <span class="badge-pill-cyan">{{ $affiliates->count() }} Registered Partners</span>
</div>

<div class="glass-panel" style="padding: 28px;">
    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>Partner Name</th>
                <th>Email</th>
                <th>Affiliate Code</th>
                <th>Total Clicks</th>
                <th>Referrals</th>
                <th>Total Lifetime Earnings</th>
                <th>Pending Balance</th>
                <th>Payout Destination</th>
            </tr>
        </thead>
        <tbody>
            @foreach($affiliates as $a)
            <tr>
                <td style="font-weight: 700; color: #fff;">{{ $a->user->name ?? 'User #' . $a->user_id }}</td>
                <td style="color: var(--text-secondary);">{{ $a->user->email ?? '-' }}</td>
                <td style="font-family: monospace; color: #38bdf8; font-weight: 600;">
                    {{ $a->affiliate_code }}
                </td>
                <td style="font-weight: 600; color: #f8fafc;">{{ $a->total_clicks }}</td>
                <td style="font-weight: 700; color: #c084fc;">{{ $a->total_referrals }}</td>
                <td style="font-weight: 800; color: #10b981; font-size: 14px;">₹{{ number_format($a->total_earnings, 2) }}</td>
                <td style="color: #f59e0b; font-weight: 700;">₹{{ number_format($a->pending_payout, 2) }}</td>
                <td>
                    <span class="badge-pill" style="font-size: 10px; margin-right: 4px; text-transform: uppercase;">{{ $a->payout_method }}</span>
                    <span style="font-family: monospace; font-size: 12px; color: var(--text-muted);">{{ Str::limit($a->payout_details ?? 'Not configured', 25) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
