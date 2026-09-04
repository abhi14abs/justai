@extends('layouts.app')

@section('title', 'Guest Management — ' . $invitation->title . ' | CelebrateAI')

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
                Guest Management &amp; RSVPs
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">
                {{ $invitation->title }}
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('invitations.dashboard.scanner', $invitation->id) }}" class="btn-secondary" style="padding: 9px 16px; font-size: 13px; text-decoration: none; border-radius: 10px;">
                📷 QR Door Scanner
            </a>
            <button type="button" onclick="document.getElementById('import-csv-modal').style.display='flex'" class="btn-secondary" style="padding: 9px 16px; font-size: 13px; border-radius: 10px;">
                📥 Import CSV
            </button>
            <button type="button" onclick="document.getElementById('add-guest-modal').style.display='flex'" class="btn-primary" style="padding: 9px 18px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                <span>+ Add Guest</span>
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 32px;">
        <div class="glass-panel" style="padding: 20px; border-radius: 16px;">
            <div style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 600;">Total Guests Listed</div>
            <div style="font-size: 28px; font-weight: 800; color: #FFF; margin-top: 4px;">{{ $stats['total'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 20px; border-radius: 16px;">
            <div style="font-size: 12px; color: #10B981; text-transform: uppercase; font-weight: 600;">Confirmed Attending</div>
            <div style="font-size: 28px; font-weight: 800; color: #34D399; margin-top: 4px;">{{ $stats['attending'] }} seats</div>
        </div>
        <div class="glass-panel" style="padding: 20px; border-radius: 16px;">
            <div style="font-size: 12px; color: #F59E0B; text-transform: uppercase; font-weight: 600;">Pending Response</div>
            <div style="font-size: 28px; font-weight: 800; color: #FBBF24; margin-top: 4px;">{{ $stats['pending'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 20px; border-radius: 16px;">
            <div style="font-size: 12px; color: #38BDF8; text-transform: uppercase; font-weight: 600;">Checked-in at Venue</div>
            <div style="font-size: 28px; font-weight: 800; color: #38BDF8; margin-top: 4px;">{{ $stats['checked_in'] }}</div>
        </div>
    </div>

    {{-- Guests Table --}}
    <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 20px;">
        <div style="padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 15px; font-weight: 700; color: #FFF;">Guest Roster</div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255,255,255,0.08); color: #94A3B8;">
                        <th style="padding: 14px 20px;">Guest Name</th>
                        <th style="padding: 14px 20px;">Group</th>
                        <th style="padding: 14px 20px;">Seats</th>
                        <th style="padding: 14px 20px;">RSVP Status</th>
                        <th style="padding: 14px 20px;">Check-In</th>
                        <th style="padding: 14px 20px;">Personal Invite URL</th>
                        <th style="padding: 14px 20px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guests as $g)
                    @php
                        $personalUrl = $invitation->getGuestUrl($g->guest_code);
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 14px 20px; color: #FFF; font-weight: 700;">
                            {{ $g->name }}
                            @if($g->is_vip)
                                <span class="badge-pill" style="font-size: 9px; background: rgba(245, 158, 11, 0.2); color: #FBBF24; padding: 2px 6px;">VIP</span>
                            @endif
                        </td>
                        <td style="padding: 14px 20px; color: #94A3B8;">{{ $g->group_name ?? 'General' }}</td>
                        <td style="padding: 14px 20px; color: #FFF;">{{ $g->allocated_seats }}</td>
                        <td style="padding: 14px 20px;">
                            @if($g->attending_status === 'attending')
                                <span style="color: #34D399; font-weight: 700;">● Confirmed</span>
                            @elseif($g->attending_status === 'declined')
                                <span style="color: #F87171; font-weight: 700;">● Declined</span>
                            @else
                                <span style="color: #FBBF24; font-weight: 700;">● Pending</span>
                            @endif
                        </td>
                        <td style="padding: 14px 20px;">
                            @if($g->check_in_status)
                                <span style="color: #38BDF8; font-weight: 700;">✅ Checked In</span>
                            @else
                                <span style="color: #64748B;">Not arrived</span>
                            @endif
                        </td>
                        <td style="padding: 14px 20px;">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <input type="text" value="{{ $personalUrl }}" readonly style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; padding: 4px 8px; color: #94A3B8; font-size: 11px; width: 160px;">
                                <button type="button" onclick="navigator.clipboard.writeText('{{ $personalUrl }}'); alert('Link copied!');" class="btn-secondary" style="padding: 4px 8px; font-size: 11px;">📋</button>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode('Dear ' . $g->name . ', You are cordially invited to celebrate with us: ' . $personalUrl) }}" target="_blank" class="btn-secondary" style="padding: 4px 8px; font-size: 11px; text-decoration: none;">💬</a>
                            </div>
                        </td>
                        <td style="padding: 14px 20px; text-align: right;">
                            <form action="{{ route('invitations.dashboard.guest.delete', [$invitation->id, $g->id]) }}" method="POST" onsubmit="return confirm('Remove this guest?')" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #F87171; cursor: pointer; font-size: 12px;">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #94A3B8;">
                            No guests added yet. Click "+ Add Guest" or "Import CSV" above.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($guests->hasPages())
        <div style="padding: 16px 20px;">
            {{ $guests->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Add Guest Modal --}}
<div id="add-guest-modal" class="mobile-drawer-overlay" style="display: none; align-items: center; justify-content: center; z-index: 1000;">
    <div class="glass-panel" style="width: 100%; max-width: 480px; padding: 24px; border-radius: 20px; background: #0B111E;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #FFF; margin: 0;">Add New Guest</h3>
            <button type="button" onclick="document.getElementById('add-guest-modal').style.display='none'" style="background: none; border: none; color: #FFF; font-size: 20px; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('invitations.dashboard.guest.add', $invitation->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Guest Full Name *</label>
                <input type="text" name="name" required placeholder="e.g. Anand Mahindra" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Email Address</label>
                    <input type="email" name="email" placeholder="anand@example.com" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">WhatsApp Number</label>
                    <input type="tel" name="phone" placeholder="+91 98765 43210" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Group Name</label>
                    <input type="text" name="group_name" placeholder="VIP / Family / Friends" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; color: #94A3B8; margin-bottom: 4px;">Allocated Seats</label>
                    <input type="number" name="allocated_seats" value="1" min="1" max="20" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                <span>Save Guest</span>
            </button>
        </form>
    </div>
</div>

{{-- CSV Import Modal --}}
<div id="import-csv-modal" class="mobile-drawer-overlay" style="display: none; align-items: center; justify-content: center; z-index: 1000;">
    <div class="glass-panel" style="width: 100%; max-width: 480px; padding: 24px; border-radius: 20px; background: #0B111E;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #FFF; margin: 0;">Import Guest CSV</h3>
            <button type="button" onclick="document.getElementById('import-csv-modal').style.display='none'" style="background: none; border: none; color: #FFF; font-size: 20px; cursor: pointer;">&times;</button>
        </div>

        <p style="font-size: 13px; color: #94A3B8; line-height: 1.6; margin-bottom: 16px;">
            Upload a CSV file containing columns: <code>name</code>, <code>email</code>, <code>phone</code>, <code>group</code>, <code>seats</code>.
        </p>

        <form action="{{ route('invitations.dashboard.guests.import', $invitation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 20px;">
                <input type="file" name="csv_file" required accept=".csv,.txt" style="color: #FFF; font-size: 13px;">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                <span>Upload &amp; Import</span>
            </button>
        </form>
    </div>
</div>
@endsection
