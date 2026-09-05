{{-- Google Map Directions Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    $venueName = $content['venue_name'] ?? ($invitation->events->first()->venue_name ?? 'Celebration Venue');
    $venueAddress = $content['venue_address'] ?? ($invitation->events->first()->venue_address ?? '');
    $cityDisplay = $content['city_display'] ?? '';
    $mapsUrl = $content['google_maps_url'] ?? ('https://maps.google.com/?q=' . urlencode(trim($venueName . ' ' . $venueAddress . ' ' . $cityDisplay)));
    $mapEmbed = $content['map_embed_url'] ?? '';

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-map" data-section-type="map" style="text-align: center;">
    <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
        ✦ <span class="sec-title-display">{{ $section->title ?? 'Directions & Navigation' }}</span> ✦
    </div>
    
    <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0 0 16px; font-weight: 700;">
        <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Get Directions via Google Maps' }}</span>
    </h2>

    <div class="event-card map-card-box {{ $settings['card_style'] ?? '' }}" style="border-radius: 20px; overflow: hidden; border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.3)); box-shadow: 0 10px 30px rgba(0,0,0,0.6); position: relative; background: var(--invite-card-bg, #0F172A); min-height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; {{ $cardStyleAttr }}">
        
        @if(!empty($mapEmbed))
        <div style="width: 100%; border-radius: 14px; overflow: hidden; margin-bottom: 16px; aspect-ratio: 16/9; border: 1px solid var(--invite-card-border, rgba(212,175,55,0.3));">
            <iframe src="{{ $mapEmbed }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        @else
        <span style="font-size: 40px; margin-bottom: 12px;">🗺️</span>
        @endif

        <div class="map-venue-name-display" style="font-size: 17px; font-weight: 700; color: var(--invite-heading, #FFF); margin-bottom: 4px; font-family: var(--font-serif-lux);">
            {{ $venueName }}
        </div>
        
        @if(!empty($venueAddress))
        <div class="map-venue-address-display" style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); margin-bottom: 18px; max-width: 420px;">
            {{ $venueAddress }}
        </div>
        @endif
        
        <a href="{{ $mapsUrl }}" target="_blank" class="btn-primary map-btn-link" style="padding: 10px 24px; font-size: 13px; text-decoration: none; border-radius: 999px; display: inline-flex; align-items: center; gap: 6px;">
            <span>Open in Google Maps</span>
            <span>&rarr;</span>
        </a>
    </div>
</section>
