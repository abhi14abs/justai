@extends('layouts.admin')

@section('title', 'Orders & Transactions — Postryx Master Portal')

@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 4px;">
            Orders &amp; Subscription Invoices
        </h1>
        <p style="color: var(--text-secondary); font-size: 14px;">Complete real-time ledger of all PayPal, Razorpay, and Direct UPI transactions.</p>
    </div>
    <span class="badge-pill-emerald">{{ $orders->count() }} Total Records</span>
</div>

<div class="glass-panel" style="padding: 28px;">
    <table class="postryx-datatable">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer Info</th>
                <th>Plan &amp; Billing</th>
                <th>Gateway</th>
                <th>Amount</th>
                <th>Gateway Reference</th>
                <th>Affiliate Cut</th>
                <th>Status</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $o)
            <tr>
                <td style="font-family: monospace; color: #38bdf8; font-weight: 700;">{{ $o->order_number }}</td>
                <td>
                    <div style="font-weight: 600; color: #fff;">{{ $o->customer_name ?? $o->user->name ?? 'Customer' }}</div>
                    <div style="font-size: 11px; color: var(--text-muted);">{{ $o->customer_email ?? $o->user->email ?? '' }}</div>
                </td>
                <td>
                    <span class="badge-pill" style="font-size: 10px;">{{ strtoupper($o->plan) }}</span>
                    <span style="font-size: 11px; color: var(--text-muted); margin-left: 4px;">{{ ucfirst($o->billing_cycle) }}</span>
                </td>
                <td style="text-transform: uppercase; font-size: 12px; font-weight: 600;">
                    <span class="badge-pill-{{ $o->payment_gateway === 'paypal' ? 'cyan' : ($o->payment_gateway === 'razorpay' ? 'purple' : 'emerald') }}" style="font-size: 10px;">
                        {{ $o->payment_gateway }}
                    </span>
                </td>
                <td style="font-weight: 800; color: #fff; font-size: 14px;">
                    {{ $o->currency === 'INR' ? '₹' : '$' }}{{ number_format($o->amount, 2) }}
                </td>
                <td style="font-family: monospace; font-size: 11px; color: var(--text-muted);">
                    {{ Str::limit($o->gateway_payment_id ?? $o->gateway_order_id ?? '-', 24) }}
                </td>
                <td style="color: #10b981; font-weight: 600;">
                    {{ $o->affiliate_commission_amount > 0 ? '₹' . number_format($o->affiliate_commission_amount, 2) : '-' }}
                </td>
                <td>
                    <span class="badge-pill-{{ $o->status === 'completed' ? 'emerald' : 'amber' }}" style="font-size: 11px;">
                        {{ strtoupper($o->status) }}
                    </span>
                </td>
                <td style="color: var(--text-muted); font-size: 12px;">{{ $o->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
