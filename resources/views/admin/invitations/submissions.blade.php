@extends('layouts.admin')

@section('title', 'RSVP Submissions — Admin Portal')

@section('content')
<div class="admin-content">

    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #FFF; margin: 0 0 4px;">
            📝 RSVP Submissions Stream
        </h1>
        <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
            Global live response submissions across all invitations
        </p>
    </div>

    <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 18px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: rgba(15,23,42,0.8); color: #94A3B8; text-align: left;">
                    <th style="padding: 14px 20px;">Guest Name</th>
                    <th style="padding: 14px 20px;">Invitation</th>
                    <th style="padding: 14px 20px;">Status</th>
                    <th style="padding: 14px 20px;">Party Size</th>
                    <th style="padding: 14px 20px;">Contact</th>
                    <th style="padding: 14px 20px;">Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $sub)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 14px 20px; color: #FFF; font-weight: 700;">{{ $sub->guest_name }}</td>
                    <td style="padding: 14px 20px; color: var(--gold-primary);">{{ $sub->invitation->title ?? 'N/A' }}</td>
                    <td style="padding: 14px 20px;">
                        @if($sub->attending_status === 'attending')
                            <span style="color: #34D399; font-weight: 700;">● Confirmed</span>
                        @elseif($sub->attending_status === 'declined')
                            <span style="color: #F87171; font-weight: 700;">● Declined</span>
                        @else
                            <span style="color: #FBBF24; font-weight: 700;">● Tentative</span>
                        @endif
                    </td>
                    <td style="padding: 14px 20px; color: #FFF;">{{ $sub->party_size }}</td>
                    <td style="padding: 14px 20px; color: #94A3B8;">
                        <div>{{ $sub->guest_email }}</div>
                        <div style="font-size: 11px;">{{ $sub->guest_phone }}</div>
                    </td>
                    <td style="padding: 14px 20px; color: #94A3B8;">{{ $sub->submitted_at ? $sub->submitted_at->diffForHumans() : '' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center; padding: 40px; color: #94A3B8;">No RSVP submissions received yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if($submissions->hasPages())
        <div style="padding: 16px 20px;">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
