{{-- Family & Hosts Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    $parentsBride = $content['parents_bride'] ?? 'Mr. Suresh & Mrs. Sunita Sharma';
    $parentsGroom = $content['parents_groom'] ?? 'Mr. Ramesh & Mrs. Kavita Verma';

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-family" data-section-type="family">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'With Blessings From' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Our Beloved Families' }}</span>
        </h2>
    </div>

    <div style="display: grid; grid-template-columns: 1fr; gap: 14px;">
        <div class="event-card {{ $settings['card_style'] ?? '' }}" style="text-align: center; padding: 20px; {{ $cardStyleAttr }}">
            <div style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; letter-spacing: 0.1em; margin-bottom: 4px;">Bride’s Family</div>
            <div class="family-bride-display" style="font-size: 16px; font-weight: 700; color: var(--invite-heading, #FFF);">{{ $parentsBride }}</div>
        </div>

        <div class="event-card {{ $settings['card_style'] ?? '' }}" style="text-align: center; padding: 20px; {{ $cardStyleAttr }}">
            <div style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; letter-spacing: 0.1em; margin-bottom: 4px;">Groom’s Family</div>
            <div class="family-groom-display" style="font-size: 16px; font-weight: 700; color: var(--invite-heading, #FFF);">{{ $parentsGroom }}</div>
        </div>
    </div>
</section>
