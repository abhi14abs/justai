{{-- Chronological Timeline Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];
    $milestones = $content['milestones'] ?? [
        ['phase' => 'First Meeting', 'title' => 'A Serendipitous Chai in Bangalore', 'desc' => 'Two kindred souls crossing paths on a rainy afternoon, beginning a journey of a lifetime.', 'color' => '#D4AF37'],
        ['phase' => 'The Proposal', 'title' => 'Under the Udaipur Sunset', 'desc' => 'Overlooking Lake Pichola as the skies turned purple and gold, he asked and she said Yes!', 'color' => '#F59E0B'],
        ['phase' => 'The Wedding Day', 'title' => 'Forever Begins', 'desc' => 'Surrounded by our loved ones, stepping into a lifetime of love and companionship.', 'color' => '#10B981'],
    ];

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-timeline" data-section-type="timeline">
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'Sacred Milestones' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Our Milestone Moments' }}</span>
        </h2>
    </div>

    <div class="event-card {{ $settings['card_style'] ?? '' }}" style="padding: 24px 20px; {{ $cardStyleAttr }}">
        <div style="position: relative; padding-left: 28px; border-left: 2px dashed var(--invite-card-border, rgba(212, 175, 55, 0.4)); margin-left: 8px;">
            @foreach($milestones as $mIdx => $m)
            <div style="margin-bottom: {{ $loop->last ? '0' : '28px' }}; position: relative;">
                <div style="position: absolute; left: -36px; top: 2px; width: 16px; height: 16px; border-radius: 50%; background: {{ $m['color'] ?? 'var(--gold-primary)' }}; box-shadow: 0 0 12px {{ $m['color'] ?? 'var(--gold-primary)' }};"></div>
                <div style="font-size: 12px; color: {{ $m['color'] ?? 'var(--gold-primary)' }}; font-weight: 700; text-transform: uppercase;">{{ $m['phase'] }}</div>
                <h4 style="font-size: 16px; color: var(--invite-heading, #FFF); margin: 2px 0 4px; font-weight: 700;">{{ $m['title'] }}</h4>
                <p style="font-size: 13px; color: var(--invite-text-muted, #94A3B8); line-height: 1.5; margin: 0;">{{ $m['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
