{{-- Contact Coordinators Section --}}
@php
    $content = $section->content ?? [];
    $contacts = $content['contacts'] ?? [
        ['name' => 'Hospitality Desk (Sharma Family)', 'phone' => '+91 98765 43210', 'role' => 'Guest Concierge'],
        ['name' => 'Transport & Logistics (Verma Family)', 'phone' => '+91 98765 12345', 'role' => 'Airport Pickup'],
    ];
@endphp

<section class="invitation-section" id="section-contact">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'Hospitality & Support' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: #FFF; margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Event Coordinators' }}
        </h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        @foreach($contacts as $c)
        <div class="event-card" style="padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
            <div>
                <div style="font-size: 14px; font-weight: 700; color: #FFF;">{{ $c['name'] }}</div>
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
