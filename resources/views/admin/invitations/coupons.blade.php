@extends('layouts.admin')

@section('title', 'Invitation Coupons — Admin Portal')

@section('content')
<div class="admin-content">

    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #FFF; margin: 0 0 4px;">
            🎟️ Invitation Discount Coupons
        </h1>
        <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
            Promotional codes and launch discounts
        </p>
    </div>

    <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                    <th style="padding: 14px 20px;">Code</th>
                    <th style="padding: 14px 20px;">Discount</th>
                    <th style="padding: 14px 20px;">Min Order</th>
                    <th style="padding: 14px 20px;">Used Count</th>
                    <th style="padding: 14px 20px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $coup)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 14px 20px; color: var(--gold-primary); font-weight: 800; font-family: monospace; font-size: 14px;">
                        {{ $coup->code }}
                    </td>
                    <td style="padding: 14px 20px; color: #FFF; font-weight: 700;">
                        {{ $coup->discount_type === 'percentage' ? $coup->discount_value . '%' : '₹' . number_format($coup->discount_value, 2) }}
                    </td>
                    <td style="padding: 14px 20px; color: #94A3B8;">₹{{ number_format($coup->min_order_amount, 2) }}</td>
                    <td style="padding: 14px 20px; color: #FFF;">{{ $coup->used_count }} redemptions</td>
                    <td style="padding: 14px 20px;">
                        <span class="badge-pill" style="font-size: 10px; background: rgba(16,185,129,0.2); color: #34D399;">Active</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
