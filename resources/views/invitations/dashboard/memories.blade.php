@extends('layouts.app')

@section('title', 'Post-Event Memories & Guest Photo Pool — ' . $invitation->title . ' | CelebrateAI')

@section('content')
<div style="max-width: 1280px; margin: 0 auto; padding: 40px 20px 80px;">

    {{-- Breadcrumb --}}
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <a href="{{ route('invitations.dashboard.index') }}" style="color: #94A3B8; text-decoration: none; font-size: 13px;">&larr; Back to My Invitations</a>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('invitations.public.show', $invitation->slug) }}" target="_blank" class="btn-secondary" style="padding: 8px 14px; font-size: 13px; text-decoration: none; border-radius: 10px;">
                👁️ View Live Invitation
            </a>
            <a href="{{ route('invitations.dashboard.guests', $invitation->id) }}" class="btn-secondary" style="padding: 8px 14px; font-size: 13px; text-decoration: none; border-radius: 10px;">
                👥 Guests &amp; RSVPs
            </a>
            <a href="{{ route('invitations.dashboard.qr', $invitation->id) }}" class="btn-secondary" style="padding: 8px 14px; font-size: 13px; text-decoration: none; border-radius: 10px;">
                📱 QR Studio
            </a>
        </div>
    </div>

    {{-- Header --}}
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 32px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(212, 175, 55, 0.12); border: 1px solid rgba(212, 175, 55, 0.3); padding: 4px 12px; border-radius: 999px; margin-bottom: 8px;">
                <span style="font-size: 12px;">📸</span>
                <span style="font-size: 11px; font-weight: 700; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.05em;">Post-Event Memories Hub</span>
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #FFF; margin: 0 0 6px;">
                Guest Photo Pool &amp; Memories Wall
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">
                {{ $invitation->title }} — Photos and candid moments uploaded by your attendees.
            </p>
        </div>

        <div>
            <button type="button" onclick="document.getElementById('upload-qr-modal').style.display='flex'" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px;">
                <span>📷 Guest Photo Upload QR</span>
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 32px;">
        <div class="glass-panel" style="padding: 20px; border-radius: 16px;">
            <div style="font-size: 12px; color: #94A3B8; text-transform: uppercase; font-weight: 600;">Photos in Pool</div>
            <div style="font-size: 28px; font-weight: 800; color: #FFF; margin-top: 4px;">{{ $stats['total_photos'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 20px; border-radius: 16px;">
            <div style="font-size: 12px; color: #34D399; text-transform: uppercase; font-weight: 600;">Guest Wishes &amp; Notes</div>
            <div style="font-size: 28px; font-weight: 800; color: #34D399; margin-top: 4px;">{{ $stats['guest_wishes'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 20px; border-radius: 16px;">
            <div style="font-size: 12px; color: #D4AF37; text-transform: uppercase; font-weight: 600;">Guest Upload URL</div>
            <div style="font-size: 12px; color: #E2E8F0; margin-top: 6px; word-break: break-all; display: flex; align-items: center; gap: 6px;">
                <input type="text" value="{{ url('/i/' . $invitation->slug . '#memories-section') }}" readonly style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; padding: 4px 8px; color: #94A3B8; font-size: 11px; width: 100%;">
                <button type="button" onclick="navigator.clipboard.writeText('{{ url('/i/' . $invitation->slug . '#memories-section') }}'); alert('Upload link copied!');" class="btn-secondary" style="padding: 4px 8px; font-size: 11px; white-space: nowrap;">📋 Copy</button>
            </div>
        </div>
    </div>

    {{-- Photo Grid --}}
    @if($memories->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
        @foreach($memories as $memory)
        <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 16px; display: flex; flex-direction: column; background: rgba(15,23,42,0.6); border: 1px solid rgba(255,255,255,0.08);">
            <div style="position: relative; padding-top: 100%; background: #000;">
                <img src="{{ $memory->file_path }}" alt="{{ $memory->name }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                <form action="{{ route('invitations.dashboard.memories.delete', [$invitation->id, $memory->id]) }}" method="POST" onsubmit="return confirm('Delete this photo from memory pool?')" style="position: absolute; top: 10px; right: 10px;">
                    @csrf
                    <button type="submit" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); color: #F87171; border-radius: 8px; padding: 6px 10px; cursor: pointer; font-size: 12px;">🗑️ Delete</button>
                </form>
            </div>
            <div style="padding: 14px 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="font-weight: 700; color: #FFF; font-size: 14px; margin-bottom: 4px;">{{ $memory->name }}</div>
                    @if($memory->caption)
                    <p style="color: #CBD5E1; font-size: 13px; font-style: italic; margin: 0 0 10px; line-height: 1.4;">"{{ $memory->caption }}"</p>
                    @endif
                </div>
                <div style="font-size: 11px; color: #64748B; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 8px;">
                    Uploaded {{ $memory->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($memories->hasPages())
    <div style="margin-top: 32px;">
        {{ $memories->links() }}
    </div>
    @endif

    @else
    <div class="glass-panel" style="padding: 60px 20px; text-align: center; border-radius: 20px;">
        <div style="font-size: 48px; margin-bottom: 16px;">📷</div>
        <h3 style="font-size: 20px; font-weight: 700; color: #FFF; margin: 0 0 8px;">No Guest Photos Yet</h3>
        <p style="color: #94A3B8; font-size: 14px; max-width: 460px; margin: 0 auto 24px;">
            Place your Guest Photo Upload QR on tables at your venue so guests can snap and upload candid photos directly to your live memory wall.
        </p>
        <button type="button" onclick="document.getElementById('upload-qr-modal').style.display='flex'" class="btn-primary" style="padding: 10px 24px; font-size: 13px; font-weight: 700; border-radius: 10px;">
            <span>Show Photo Upload QR Code</span>
        </button>
    </div>
    @endif

</div>

{{-- QR Code Modal for Guest Photo Uploads --}}
<div id="upload-qr-modal" class="mobile-drawer-overlay" style="display: none; align-items: center; justify-content: center; z-index: 1000;">
    <div class="glass-panel" style="width: 100%; max-width: 440px; padding: 28px; border-radius: 24px; background: #0B111E; text-align: center;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #FFF; margin: 0;">Guest Photo Upload QR</h3>
            <button type="button" onclick="document.getElementById('upload-qr-modal').style.display='none'" style="background: none; border: none; color: #FFF; font-size: 20px; cursor: pointer;">&times;</button>
        </div>

        <p style="color: #94A3B8; font-size: 13px; margin: 0 0 20px;">
            Print or display this QR code at your tables or entrance. Guests scan to snap and share photos instantly!
        </p>

        <div style="background: #FFF; padding: 20px; border-radius: 16px; display: inline-block; box-shadow: 0 10px 30px rgba(0,0,0,0.5); margin-bottom: 20px;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode(url('/i/' . $invitation->slug . '#memories-section')) }}" alt="Photo Upload QR" style="width: 220px; height: 220px; display: block;">
        </div>

        <div>
            <a href="https://api.qrserver.com/v1/create-qr-code/?size=600x600&data={{ urlencode(url('/i/' . $invitation->slug . '#memories-section')) }}" download="photo-upload-qr.png" class="btn-primary" style="padding: 10px 24px; font-size: 13px; font-weight: 700; border-radius: 12px; text-decoration: none; display: inline-block;">
                <span>Download Print-Ready QR PNG</span>
            </a>
        </div>
    </div>
</div>
@endsection
