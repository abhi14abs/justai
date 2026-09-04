@extends('layouts.app')

@section('title', 'QR Door Scanner — ' . $invitation->title . ' | CelebrateAI')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 40px 20px 80px; text-align: center;">

    {{-- Breadcrumb --}}
    <div style="margin-bottom: 24px; text-align: left;">
        <a href="{{ route('invitations.dashboard.guests', $invitation->id) }}" style="color: #94A3B8; text-decoration: none; font-size: 13px;">&larr; Back to Guests</a>
    </div>

    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 24px; font-weight: 800; color: #FFF; margin: 0 0 6px;">
            Venue Door Check-In Scanner
        </h1>
        <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
            {{ $invitation->title }}
        </p>
    </div>

    {{-- Scanner Viewport Box --}}
    <div class="glass-panel" style="padding: 24px; border-radius: 24px; border: 1px solid rgba(212, 175, 55, 0.4); margin-bottom: 24px;">
        
        <div style="width: 100%; height: 260px; background: #030712; border-radius: 16px; border: 2px dashed rgba(212, 175, 55, 0.4); display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; overflow: hidden; margin-bottom: 20px;">
            <span style="font-size: 48px; margin-bottom: 8px;">📷</span>
            <div style="font-size: 14px; font-weight: 700; color: #FFF;">Camera Scanner Active</div>
            <div style="font-size: 11px; color: #94A3B8; margin-top: 4px;">Point camera at guest’s pass QR code</div>
            <div style="position: absolute; width: 100%; height: 2px; background: #10B981; top: 50%; box-shadow: 0 0 12px #10B981; animation: scanLaser 2s infinite ease-in-out;"></div>
        </div>

        {{-- Manual Guest Pass Code Input --}}
        <div style="display: flex; gap: 8px;">
            <input type="text" id="manual-guest-code" placeholder="Enter Guest Pass Code (e.g. GST-9X2Y7)" style="flex: 1; padding: 12px 16px; border-radius: 12px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px; text-transform: uppercase;">
            <button type="button" onclick="submitCheckIn()" class="btn-primary" style="padding: 12px 20px; font-size: 13px; font-weight: 700; border-radius: 12px;">
                <span>Check-In</span>
            </button>
        </div>

    </div>

    {{-- Verification Result Box --}}
    <div id="checkin-result" class="glass-panel" style="display: none; padding: 24px; border-radius: 20px; text-align: center;">
        <div id="checkin-icon" style="font-size: 40px; margin-bottom: 8px;">✅</div>
        <h3 id="checkin-guest-name" style="font-size: 18px; font-weight: 800; color: #FFF; margin: 0 0 4px;">Guest Name</h3>
        <div id="checkin-group" style="font-size: 13px; color: var(--gold-primary); margin-bottom: 8px;">Group: VIP</div>
        <div id="checkin-seats" style="font-size: 14px; color: #FFF; font-weight: 700;">Party Size: 2 Seats</div>
        <p id="checkin-msg" style="font-size: 13px; color: #34D399; margin-top: 12px; font-weight: 600;">Check-in Confirmed!</p>
    </div>

</div>

<style>
@keyframes scanLaser {
    0% { top: 10%; }
    50% { top: 90%; }
    100% { top: 10%; }
}
</style>

<script>
    function submitCheckIn() {
        const code = document.getElementById('manual-guest-code').value.trim();
        if(!code) return alert('Please enter a guest pass code.');

        fetch('{{ route("invitations.dashboard.scanner.checkin", $invitation->id, false) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ guest_code: code })
        })
        .then(res => res.json())
        .then(data => {
            const resBox = document.getElementById('checkin-result');
            resBox.style.display = 'block';

            if(data.success) {
                document.getElementById('checkin-icon').innerText = '✅';
                document.getElementById('checkin-guest-name').innerText = data.guest.name;
                document.getElementById('checkin-group').innerText = 'Group: ' + (data.guest.group_name || 'General');
                document.getElementById('checkin-seats').innerText = 'Party Size: ' + data.guest.allocated_seats + ' Seats';
                document.getElementById('checkin-msg').innerText = data.message;
                document.getElementById('checkin-msg').style.color = '#34D399';
                document.getElementById('manual-guest-code').value = '';
            } else {
                document.getElementById('checkin-icon').innerText = '❌';
                document.getElementById('checkin-guest-name').innerText = 'Check-In Failed';
                document.getElementById('checkin-group').innerText = '';
                document.getElementById('checkin-seats').innerText = '';
                document.getElementById('checkin-msg').innerText = data.message || 'Invalid code.';
                document.getElementById('checkin-msg').style.color = '#F87171';
            }
        })
        .catch(err => {
            alert('An error occurred during check-in.');
        });
    }
</script>
@endsection
