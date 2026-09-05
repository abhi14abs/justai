{{-- Countdown Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];
    $targetDate = $invitation->event_date ? $invitation->event_date->toIso8601String() : now()->addMonths(2)->toIso8601String();

    // Section Custom Card Styling Overrides
    $boxStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $boxStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $boxStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $boxStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
@endphp

<section class="invitation-section" id="section-countdown" data-section-type="countdown" style="text-align: center;">
    <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--invite-primary, #D4AF37); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
        ✦ <span class="sec-title-display">{{ $section->title ?? 'Save The Date' }}</span> ✦
    </div>
    
    <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFFFFF); margin: 0 0 20px; font-weight: 700;">
        <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Counting Down Every Magical Moment' }}</span>
    </h2>

    <div class="countdown-grid" id="invitation-countdown" data-target-date="{{ $targetDate }}">
        <div class="countdown-box" style="{{ $boxStyleAttr }}">
            <div class="countdown-number" id="count-days">--</div>
            <div class="countdown-label">Days</div>
        </div>
        <div class="countdown-box" style="{{ $boxStyleAttr }}">
            <div class="countdown-number" id="count-hours">--</div>
            <div class="countdown-label">Hours</div>
        </div>
        <div class="countdown-box" style="{{ $boxStyleAttr }}">
            <div class="countdown-number" id="count-mins">--</div>
            <div class="countdown-label">Mins</div>
        </div>
        <div class="countdown-box" style="{{ $boxStyleAttr }}">
            <div class="countdown-number" id="count-secs">--</div>
            <div class="countdown-label">Secs</div>
        </div>
    </div>
</section>
