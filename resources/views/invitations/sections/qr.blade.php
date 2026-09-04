{{-- Digital QR Pass Section --}}
@php
    $qrCode = $invitation->qrCodes()->where('qr_type', 'invitation_link')->first();
    $qrService = app(\App\Services\Invitations\InvitationQrService::class);
    $svgContent = $qrService->generateSvg(url('/i/' . $invitation->slug), 180, $invitation->primary_color ?? '#064E3B', '#FFFFFF');
@endphp

<section class="invitation-section" id="section-qr" style="text-align: center;">
    <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
        ✦ {{ $section->title ?? 'Instant Digital Pass' }} ✦
    </div>
    
    <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: #FFF; margin: 0 0 16px; font-weight: 700;">
        {{ $section->subtitle ?? 'Scan to View & RSVP' }}
    </h2>

    <div style="display: inline-block; padding: 20px; background: #FFF; border-radius: 24px; box-shadow: 0 12px 35px rgba(0,0,0,0.6); border: 2px solid var(--gold-primary); margin-bottom: 16px;">
        {!! $svgContent !!}
    </div>

    <div style="font-size: 12px; color: #94A3B8; letter-spacing: 0.05em;">
        Point your mobile camera to open on phone
    </div>
</section>
