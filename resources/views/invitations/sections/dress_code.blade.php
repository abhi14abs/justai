{{-- Dress Code Guidelines Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    $mehendi = $content['mehendi'] ?? 'Pastels & Bright Floral Lehengas';
    $haldi = $content['haldi'] ?? 'Sunshine Yellow & Mustard Kurtas';
    $wedding = $content['wedding'] ?? 'Traditional Royal Heritage & Sherwanis';

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-dress_code" data-section-type="dress_code">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'Attire & Palette' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Dress Code Guidelines' }}</span>
        </h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        <div class="event-card {{ $settings['card_style'] ?? '' }}" style="padding: 16px 20px; {{ $cardStyleAttr }}">
            <div style="font-size: 12px; font-weight: 700; color: var(--gold-primary); text-transform: uppercase; margin-bottom: 2px;">Mehendi &amp; Sangeet</div>
            <div class="dress-mehendi-display" style="font-size: 14px; color: var(--invite-heading, #FFF);">{{ $mehendi }}</div>
        </div>

        <div class="event-card {{ $settings['card_style'] ?? '' }}" style="padding: 16px 20px; {{ $cardStyleAttr }}">
            <div style="font-size: 12px; font-weight: 700; color: #F59E0B; text-transform: uppercase; margin-bottom: 2px;">Haldi Celebration</div>
            <div class="dress-haldi-display" style="font-size: 14px; color: var(--invite-heading, #FFF);">{{ $haldi }}</div>
        </div>

        <div class="event-card {{ $settings['card_style'] ?? '' }}" style="padding: 16px 20px; {{ $cardStyleAttr }}">
            <div style="font-size: 12px; font-weight: 700; color: #10B981; text-transform: uppercase; margin-bottom: 2px;">Varmala &amp; Royal Reception</div>
            <div class="dress-wedding-display" style="font-size: 14px; color: var(--invite-heading, #FFF);">{{ $wedding }}</div>
        </div>
    </div>
</section>
