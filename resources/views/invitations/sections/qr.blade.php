{{-- Digital QR Pass Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];
    $qrCode = $invitation->qrCodes()->where('qr_type', 'invitation_link')->first();
    $qrService = app(\App\Services\Invitations\InvitationQrService::class);
    $svgContent = $qrService->generateSvg(url('/i/' . $invitation->slug), 180, $invitation->primary_color ?? '#064E3B', '#FFFFFF');

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-qr" data-section-type="qr" style="text-align: center;">
    <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
        ✦ <span class="sec-title-display">{{ $section->title ?? 'Instant Digital Pass' }}</span> ✦
    </div>
    
    <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0 0 16px; font-weight: 700;">
        <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Scan to View & RSVP' }}</span>
    </h2>

    <div class="event-card qr-card-box {{ $settings['card_style'] ?? '' }}" style="display: inline-block; padding: 24px; background: #FFF; border-radius: 24px; box-shadow: 0 12px 35px rgba(0,0,0,0.6); border: 2px solid var(--gold-primary); margin-bottom: 16px; {{ $cardStyleAttr }}">
        <div style="background: #FFF; padding: 8px; border-radius: 12px; display: inline-block;">
            {!! $svgContent !!}
        </div>
    </div>

    <div style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); letter-spacing: 0.05em;">
        Point your mobile camera to open on phone
    </div>
</section>
