{{-- Couple & Story Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    $brideBio = $content['bride_bio'] ?? '';
    $groomBio = $content['groom_bio'] ?? '';
    $story = $content['story'] ?? '';
    $groomName = $content['groom_name'] ?? 'The Groom';
    $brideName = $content['bride_name'] ?? 'The Bride';

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-couple" data-section-type="couple">
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'The Couple' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 26px; color: var(--invite-heading, #FFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Two Souls, One Sacred Journey' }}</span>
        </h2>
    </div>

    @if(!empty($story))
    <div class="glass-panel couple-story-card {{ $settings['card_style'] ?? '' }}" style="padding: 24px; border-radius: 20px; border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.25)); background: var(--invite-card-bg, rgba(15, 23, 42, 0.6)); margin-bottom: 24px; text-align: center; position: relative; {{ $cardStyleAttr }}">
        <div style="font-family: var(--font-script); font-size: 40px; color: var(--gold-primary); line-height: 0; margin-bottom: 16px; opacity: 0.8;">“</div>
        <p class="couple-story-text" style="color: var(--invite-card-text, #E2E8F0); font-size: 14px; line-height: 1.8; font-style: italic; margin: 0;">
            {{ $story }}
        </p>
        <div style="font-family: var(--font-script); font-size: 40px; color: var(--gold-primary); line-height: 0; margin-top: 20px; opacity: 0.8;">”</div>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
        @if(!empty($groomBio) || !empty($groomName))
        <div class="event-card couple-groom-card {{ $settings['card_style'] ?? '' }}" style="padding: 20px; {{ $cardStyleAttr }}">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span style="font-size: 24px;">🤴</span>
                <div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--invite-heading, #FFF);">The Groom</div>
                    <div class="couple-groom-name" style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 600;">{{ $groomName }}</div>
                </div>
            </div>
            @if(!empty($groomBio))
            <p class="couple-groom-bio" style="font-size: 13px; color: var(--invite-text-muted, #94A3B8); line-height: 1.6; margin: 0;">{{ $groomBio }}</p>
            @endif
        </div>
        @endif

        @if(!empty($brideBio) || !empty($brideName))
        <div class="event-card couple-bride-card {{ $settings['card_style'] ?? '' }}" style="padding: 20px; {{ $cardStyleAttr }}">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span style="font-size: 24px;">👸</span>
                <div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--invite-heading, #FFF);">The Bride</div>
                    <div class="couple-bride-name" style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 600;">{{ $brideName }}</div>
                </div>
            </div>
            @if(!empty($brideBio))
            <p class="couple-bride-bio" style="font-size: 13px; color: var(--invite-text-muted, #94A3B8); line-height: 1.6; margin: 0;">{{ $brideBio }}</p>
            @endif
        </div>
        @endif
    </div>
</section>
