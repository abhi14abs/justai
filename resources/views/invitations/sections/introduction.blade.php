{{-- Introduction & Blessings Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-introduction" data-section-type="introduction" style="text-align: center;">
    <div class="intro-card-box {{ !empty($cardStyleAttr) ? 'event-card' : '' }}" style="max-width: 480px; margin: 0 auto; {{ $cardStyleAttr }}">
        <div style="font-size: 28px; margin-bottom: 12px;">🕉️</div>
        
        <h3 style="font-family: var(--font-serif-lux); font-size: 20px; color: var(--invite-primary, #D4AF37); margin-bottom: 8px; font-weight: 700;">
            <span class="sec-title-display">{{ $section->title ?? '|| Shree Ganeshay Namah ||' }}</span>
        </h3>

        <p style="font-size: 14px; line-height: 1.8; color: var(--invite-text, #CBD5E1); margin: 0;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'With the divine blessings of God, our elders, and ancestors, we solicit your esteemed presence and blessings.' }}</span>
        </p>

        <div style="margin-top: 16px; width: 60px; height: 1px; background: var(--invite-primary, #D4AF37); margin-left: auto; margin-right: auto; opacity: 0.6;"></div>
    </div>
</section>
