@extends('layouts.admin')

@section('title', 'Invitation Orders — Admin Portal')

@section('content')
<div class="admin-content">

    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #FFF; margin: 0 0 4px;">
            💳 Invitation Orders &amp; Revenue Transactions
        </h1>
        <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
            Track paid customer checkouts, gateway references, and coupon redemptions
        </p>
    </div>

    <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                    <th style="padding: 14px 20px;">Order #</th>
                    <th style="padding: 14px 20px;">Customer</th>
                    <th style="padding: 14px 20px;">Template / Invite</th>
                    <th style="padding: 14px 20px;">Final Amount</th>
                    <th style="padding: 14px 20px;">Gateway</th>
                    <th style="padding: 14px 20px;">Status</th>
                    <th style="padding: 14px 20px;">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $ord)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 14px 20px; color: #FFF; font-weight: 700;">{{ $ord->order_number }}</td>
                    <td style="padding: 14px 20px; color: #FFF;">
                        {{ $ord->user->name ?? 'Guest Customer' }}
                        <div style="font-size: 11px; color: #94A3B8;">{{ $ord->user->email ?? '' }}</div>
                    </td>
                    <td style="padding: 14px 20px; color: #CBD5E1;">
                        {{ $ord->template->name ?? ($ord->invitation->title ?? 'Custom Invite') }}
                    </td>
                    <td style="padding: 14px 20px; color: var(--gold-primary); font-weight: 800;">
                        {{ $ord->currency === 'INR' ? '₹' . number_format($ord->final_amount, 2) : '$' . number_format($ord->final_amount, 2) }}
                    </td>
                    <td style="padding: 14px 20px; color: #94A3B8; text-transform: uppercase;">{{ $ord->payment_gateway }}</td>
                    <td style="padding: 14px 20px;">
                        <span class="badge-pill" style="font-size: 10px; background: {{ $ord->isCompleted() ? 'rgba(16,185,129,0.2)' : 'rgba(245,158,11,0.2)' }}; color: {{ $ord->isCompleted() ? '#34D399' : '#FBBF24' }};">
                            {{ $ord->status }}
                        </span>
                    </td>
                    <td style="padding: 14px 20px; color: #94A3B8;">{{ $ord->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align: center; padding: 40px; color: #94A3B8;">No orders recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if($orders->hasPages())
        <div style="padding: 16px 20px;">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
