@extends('layouts.app')

@section('title', 'Analytics — ' . $invitation->title . ' | CelebrateAI')

@section('content')
<div style="max-width: 1280px; margin: 0 auto; padding: 40px 20px 80px;">

    {{-- Breadcrumb --}}
    <div style="margin-bottom: 24px;">
        <a href="{{ route('invitations.dashboard.index') }}" style="color: #94A3B8; text-decoration: none; font-size: 13px;">&larr; Back to My Invitations</a>
    </div>

    {{-- Header --}}
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: #FFF; margin: 0 0 6px;">
                Real-Time Traffic &amp; Conversion Analytics
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">
                {{ $invitation->title }}
            </p>
        </div>

        <a href="{{ route('invitations.public.show', $invitation->slug) }}" target="_blank" class="btn-secondary" style="padding: 9px 16px; font-size: 13px; text-decoration: none; border-radius: 10px;">
            👁️ View Live Invitation
        </a>
    </div>

    {{-- KPI Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 36px;">
        <div class="glass-panel" style="padding: 24px; border-radius: 20px;">
            <div style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">Total Page Views</div>
            <div style="font-size: 32px; font-weight: 900; color: #FFF; margin-top: 6px;">{{ number_format($metrics['total_views']) }}</div>
            <div style="font-size: 12px; color: var(--gold-primary); margin-top: 4px;">{{ number_format($metrics['unique_visitors']) }} Unique Visitors</div>
        </div>

        <div class="glass-panel" style="padding: 24px; border-radius: 20px;">
            <div style="font-size: 12px; color: #10B981; text-transform: uppercase; font-weight: 700;">RSVP Submissions</div>
            <div style="font-size: 32px; font-weight: 900; color: #34D399; margin-top: 6px;">{{ number_format($metrics['total_rsvps']) }}</div>
            <div style="font-size: 12px; color: #A7F3D0; margin-top: 4px;">{{ $metrics['attending_guests'] }} Confirmed Guests</div>
        </div>

        <div class="glass-panel" style="padding: 24px; border-radius: 20px;">
            <div style="font-size: 12px; color: #38BDF8; text-transform: uppercase; font-weight: 700;">RSVP Conversion Rate</div>
            <div style="font-size: 32px; font-weight: 900; color: #38BDF8; margin-top: 6px;">{{ $metrics['conversion_rate'] }}%</div>
            <div style="font-size: 12px; color: #BAE6FD; margin-top: 4px;">Of unique visitors</div>
        </div>

        <div class="glass-panel" style="padding: 24px; border-radius: 20px;">
            <div style="font-size: 12px; color: #F59E0B; text-transform: uppercase; font-weight: 700;">QR Door Scans</div>
            <div style="font-size: 32px; font-weight: 900; color: #FBBF24; margin-top: 6px;">{{ number_format($metrics['qr_scans']) }}</div>
            <div style="font-size: 12px; color: #FDE68A; margin-top: 4px;">Venue arrival checks</div>
        </div>
    </div>

    {{-- Breakdown Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px;">
        
        {{-- Device Breakdown --}}
        <div class="glass-panel" style="padding: 24px; border-radius: 20px;">
            <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0 0 20px;">Device Distribution</h3>
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #FFF; margin-bottom: 4px;">
                        <span>📱 Mobile (iOS &amp; Android)</span>
                        <span style="font-weight: 700;">{{ $metrics['device_breakdown']['mobile'] }} views</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                        <div style="width: {{ $metrics['total_views'] > 0 ? ($metrics['device_breakdown']['mobile'] / $metrics['total_views']) * 100 : 80 }}%; height: 100%; background: linear-gradient(90deg, #6366F1, #38BDF8);"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #FFF; margin-bottom: 4px;">
                        <span>🖥️ Desktop</span>
                        <span style="font-weight: 700;">{{ $metrics['device_breakdown']['desktop'] }} views</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                        <div style="width: {{ $metrics['total_views'] > 0 ? ($metrics['device_breakdown']['desktop'] / $metrics['total_views']) * 100 : 15 }}%; height: 100%; background: linear-gradient(90deg, #F59E0B, #D97706);"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daily Activity Timeline --}}
        <div class="glass-panel" style="padding: 24px; border-radius: 20px;">
            <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0 0 20px;">Recent 7 Days Engagement</h3>
            @if(count($metrics['timeline']) > 0)
                <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 120px; gap: 8px; padding-top: 20px;">
                    @foreach($metrics['timeline'] as $date => $count)
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 6px; flex: 1;">
                        <div style="font-size: 11px; font-weight: 700; color: var(--gold-primary);">{{ $count }}</div>
                        <div style="width: 100%; height: {{ min($count * 15 + 10, 80) }}px; background: linear-gradient(180deg, #D4AF37, #996515); border-radius: 6px;"></div>
                        <div style="font-size: 9px; color: #94A3B8;">{{ date('d M', strtotime($date)) }}</div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; color: #94A3B8; font-size: 13px; padding: 30px;">
                    Views and RSVP timeline activity will appear here as guests visit your invitation.
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
