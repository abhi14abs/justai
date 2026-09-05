{{-- Venue & Accommodations Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    $venueName = $content['venue_name'] ?? ($invitation->events->first()->venue_name ?? 'Celebration Venue');
    $venueAddress = $content['venue_address'] ?? ($invitation->events->first()->venue_address ?? '');
    $cityDisplay = $content['city_display'] ?? '';
    $mapsUrl = $content['google_maps_url'] ?? ('https://maps.google.com/?q=' . urlencode(trim($venueName . ' ' . $venueAddress . ' ' . $cityDisplay)));
    $mapEmbed = $content['map_embed_url'] ?? '';
    $landmark = $content['landmark'] ?? '';
    $directionsNotes = $content['directions_notes'] ?? '';
    $airport = $content['airport_distance'] ?? null;
    $train = $content['train_distance'] ?? null;
    $description = $content['description'] ?? 'An idyllic setting providing a majestic backdrop for our sacred celebration.';

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="section-venue" data-section-type="venue">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--invite-primary, #D4AF37); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'Sacred Venue' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFFFFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Mandap & Celebration Hall' }}</span>
        </h2>
    </div>

    <div class="event-card venue-card-box {{ $settings['card_style'] ?? '' }}" style="padding: 24px; {{ $cardStyleAttr }}">
        
        {{-- Primary Venue Title & Address --}}
        <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 16px;">
            <span style="font-size: 28px; width: 48px; height: 48px; border-radius: 12px; background: rgba(212,175,55,0.15); border: 1px solid var(--invite-card-border, rgba(212,175,55,0.3)); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                🏛️
            </span>
            <div style="flex: 1;">
                <h3 class="venue-name-display" style="font-family: var(--font-serif-lux); font-size: 19px; color: var(--invite-heading, #FFFFFF); margin: 0 0 4px; font-weight: 700;">
                    {{ $venueName }}
                </h3>
                @if(!empty($venueAddress))
                <div class="venue-address-display" style="font-size: 13px; color: var(--invite-text-muted, #94A3B8); line-height: 1.5;">
                    📍 {{ $venueAddress }}
                </div>
                @endif
            </div>
        </div>

        {{-- Description / Story --}}
        @if(!empty($description))
        <p class="venue-desc-display" style="font-size: 13px; color: var(--invite-text, #CBD5E1); line-height: 1.7; margin-bottom: 16px;">
            {{ $description }}
        </p>
        @endif

        {{-- Landmark & Notes --}}
        @if(!empty($landmark) || !empty($directionsNotes))
        <div style="background: rgba(0,0,0,0.25); border: 1px dashed var(--invite-card-border, rgba(255,255,255,0.15)); border-radius: 10px; padding: 10px 14px; margin-bottom: 16px; font-size: 12px; color: var(--invite-text-muted, #94A3B8);">
            @if(!empty($landmark))
            <div style="margin-bottom: 4px;"><strong>🚗 Landmark:</strong> {{ $landmark }}</div>
            @endif
            @if(!empty($directionsNotes))
            <div><strong>💡 Note:</strong> {{ $directionsNotes }}</div>
            @endif
        </div>
        @endif

        {{-- Transit & Commute Distances --}}
        @if($airport || $train)
        <div style="border-top: 1px solid var(--invite-card-border, rgba(255, 255, 255, 0.08)); padding-top: 12px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 8px;">
            @if($airport)
            <div style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); display: flex; align-items: center; gap: 8px;">
                <span>✈️</span>
                <span><strong>Airport:</strong> {{ $airport }}</span>
            </div>
            @endif
            @if($train)
            <div style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); display: flex; align-items: center; gap: 8px;">
                <span>🚆</span>
                <span><strong>Railway:</strong> {{ $train }}</span>
            </div>
            @endif
        </div>
        @endif

        {{-- Embedded Map Preview if provided --}}
        @if(!empty($mapEmbed))
        <div style="border-radius: 14px; overflow: hidden; margin-bottom: 16px; aspect-ratio: 16/9; border: 1px solid var(--invite-card-border, rgba(212,175,55,0.3));">
            <iframe src="{{ $mapEmbed }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        @endif

        {{-- Action Button --}}
        <a href="{{ $mapsUrl }}" target="_blank" class="btn-primary venue-maps-link" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 12px; box-sizing: border-box;">
            <span>🗺️ Get Directions via Google Maps</span>
            <span>&rarr;</span>
        </a>
    </div>
</section>
