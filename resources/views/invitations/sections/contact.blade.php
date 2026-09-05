{{-- Contact Coordinators Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    $contacts = $content['contacts'] ?? [
        ['name' => 'Hospitality Desk (Sharma Family)', 'phone' => '+91 98765 43210', 'role' => 'Guest Concierge'],
        ['name' => 'Transport & Logistics (Verma Family)', 'phone' => '+91 98765 12345', 'role' => 'Airport Pickup'],
    ];

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-contact" data-section-type="contact">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'Hospitality & Support' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Event Coordinators' }}</span>
        </h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        @foreach($contacts as $c)
        <div class="event-card {{ $settings['card_style'] ?? '' }}" style="padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; {{ $cardStyleAttr }}">
            <div>
                <div style="font-size: 14px; font-weight: 700; color: var(--invite-heading, #FFF);">{{ $c['name'] }}</div>
                <div style="font-size: 11px; color: var(--gold-primary); font-weight: 600;">{{ $c['role'] }}</div>
            </div>

            @if(!empty($c['phone']))
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $c['phone']) }}" class="btn-secondary" style="padding: 6px 14px; font-size: 12px; border-radius: 8px; text-decoration: none; white-space: nowrap;">
                📞 Call
            </a>
            @endif
        </div>
        @endforeach
    </div>
</section>
