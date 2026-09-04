@extends('layouts.admin')

@section('title', 'Feature Pricing Matrix — Admin Portal')

@section('content')
<div class="admin-content">

    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #FFF; margin: 0 0 4px;">
            💰 Feature Addons &amp; Pricing Matrix
        </h1>
        <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
            Database-driven pricing for invitation features, guest tiers, and duration options
        </p>
    </div>

    <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                    <th style="padding: 14px 20px;">Feature</th>
                    <th style="padding: 14px 20px;">Code Identifier</th>
                    <th style="padding: 14px 20px;">INR Price</th>
                    <th style="padding: 14px 20px;">USD Price</th>
                    <th style="padding: 14px 20px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($features as $feat)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 14px 20px; color: #FFF; font-weight: 700;">
                        <span style="margin-right: 8px;">{{ $feat->icon ?? '✨' }}</span>
                        {{ $feat->name }}
                        <div style="font-size: 11px; color: #94A3B8; font-weight: normal; margin-top: 2px;">{{ $feat->description }}</div>
                    </td>
                    <td style="padding: 14px 20px; color: #94A3B8;"><code>{{ $feat->code }}</code></td>
                    <td style="padding: 14px 20px; color: var(--gold-primary); font-weight: 700;">
                        ₹{{ number_format($feat->getPrice('INR'), 2) }}
                    </td>
                    <td style="padding: 14px 20px; color: #38BDF8; font-weight: 700;">
                        ${{ number_format($feat->getPrice('USD'), 2) }}
                    </td>
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
