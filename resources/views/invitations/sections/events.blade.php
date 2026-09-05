{{-- Multi-Event Celebration Itinerary Section --}}
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

<section class="invitation-section" id="section-events" data-section-type="events">
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--invite-primary, #D4AF37); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'Celebration Itinerary' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 26px; color: var(--invite-heading, #FFFFFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Sacred Ceremonies & Celebrations' }}</span>
        </h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px;">
        @forelse($invitation->events as $event)
        <div class="event-card gold-foil-border {{ $settings['card_style'] ?? '' }}" id="event-card-{{ $event->id }}" style="{{ $cardStyleAttr }}">
            
            {{-- Header: Icon, Title & Date --}}
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="width: 44px; height: 44px; border-radius: 12px; background: rgba(212, 175, 55, 0.15); border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.3)); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        {{ $event->icon ?? '🎉' }}
                    </span>
                    <div>
                        <h3 style="font-family: var(--font-serif-lux); font-size: 18px; color: var(--invite-heading, #FFFFFF); margin: 0; font-weight: 700;">
                            {{ $event->title }}
                        </h3>
                        <div style="font-size: 12px; color: var(--invite-primary, #D4AF37); font-weight: 700; margin-top: 2px;">
                            {{ $event->event_date ? $event->event_date->format('l, F d, Y') : 'Date TBA' }}
                        </div>
                    </div>
                </div>

                {{-- Timing Pill --}}
                @if($event->start_time)
                <div class="badge-pill" style="font-size: 11px; background: var(--invite-pill-bg, rgba(15, 23, 42, 0.9)); border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.3)); color: var(--invite-pill-text, #FFFFFF); font-weight: 700; white-space: nowrap;">
                    ⏰ {{ date('g:i A', strtotime($event->start_time)) }}
                </div>
                @endif
            </div>

            {{-- Venue & Address --}}
            @if($event->venue_name)
            <div style="font-size: 13px; color: var(--invite-text, #E2E8F0); margin-bottom: 8px; display: flex; align-items: flex-start; gap: 8px;">
                <span style="color: var(--invite-primary, #D4AF37);">📍</span>
                <div>
                    <strong style="color: var(--invite-heading, #FFFFFF);">{{ $event->venue_name }}</strong>
                    @if($event->venue_address)
                    <div style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); margin-top: 2px;">{{ $event->venue_address }}</div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Dress Code --}}
            @if($event->dress_code)
            <div style="font-size: 12px; color: var(--invite-text, #CBD5E1); margin-bottom: 16px; display: flex; align-items: center; gap: 6px; background: var(--invite-pill-bg, rgba(255, 255, 255, 0.04)); padding: 8px 12px; border-radius: 8px; border: 1px solid var(--invite-card-border, rgba(255, 255, 255, 0.08));">
                <span>👗</span>
                <span><strong>Dress Code:</strong> {{ $event->dress_code }}</span>
            </div>
            @endif

            {{-- Actions: Map Link & Add to Calendar --}}
            <div style="display: flex; align-items: center; gap: 10px; border-top: 1px solid var(--invite-card-border, rgba(255, 255, 255, 0.08)); padding-top: 14px; margin-top: 12px;">
                @if($event->venue_address || $event->venue_name || $event->map_embed_url)
                <a href="{{ $event->map_embed_url ?: ('https://www.google.com/maps/search/?api=1&query=' . urlencode(($event->venue_name ?? '') . ' ' . ($event->venue_address ?? ''))) }}" target="_blank" class="btn-secondary" style="font-size: 11px; padding: 6px 12px; border-radius: 8px; flex: 1; text-align: center; text-decoration: none;">
                    🗺️ Get Directions
                </a>
                @endif

                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($event->title . ' - ' . $invitation->title) }}&dates={{ $event->event_date ? $event->event_date->format('Ymd\THis') : '' }}&location={{ urlencode(($event->venue_name ?? '') . ', ' . ($event->venue_address ?? '')) }}" target="_blank" class="btn-secondary" style="font-size: 11px; padding: 6px 12px; border-radius: 8px; flex: 1; text-align: center; text-decoration: none;">
                    📅 Add to Calendar
                </a>
            </div>

        </div>
        @empty
        <div style="text-align: center; color: var(--invite-text-muted, #94A3B8); font-size: 14px; padding: 32px;">
            No events scheduled yet.
        </div>
        @endforelse
    </div>
</section>
