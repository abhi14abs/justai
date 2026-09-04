{{-- Hero Cover Section --}}
@php
    $content = $section->content ?? [];
    $groom = $content['groom_name'] ?? '';
    $bride = $content['bride_name'] ?? '';
    $hasCouple = !empty($groom) && !empty($bride);
    $dateDisplay = $content['date_display'] ?? ($invitation->event_date ? $invitation->event_date->format('F d, Y') : 'September 07 - 17, 2026');
    $cityDisplay = $content['city_display'] ?? ($invitation->events->first()->venue_name ?? 'Sacred Celebration Venue');
@endphp

<section class="invitation-hero" id="section-hero">
    @if(!empty($invitation->cover_image))
        <img src="{{ $invitation->cover_image }}" alt="Cover Banner" class="invitation-hero-cover">
    @endif

    <div style="position: relative; z-index: 2; width: 100%; max-width: 520px; display: flex; flex-direction: column; align-items: center;">
        
        {{-- Auspicious Religious / Divine Top Motif --}}
        <div style="font-size: 13px; font-weight: 700; letter-spacing: 0.15em; color: var(--invite-primary, #D4AF37); text-transform: uppercase; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <span>✦</span>
            <span>{{ $section->title ?? '|| श्री गणेशाय नमः ||' }}</span>
            <span>✦</span>
        </div>

        {{-- Invitation Top Callout --}}
        <p style="font-size: 14px; line-height: 1.6; color: var(--invite-text-muted, #94A3B8); margin-bottom: 20px; font-style: italic; max-width: 460px; text-align: center;">
            {{ $section->subtitle ?? 'You and your family are cordially invited to celebrate with us.' }}
        </p>

        @if($hasCouple)
            {{-- Couple Names in Luxury Script Typography --}}
            <div style="margin: 14px 0 24px; width: 100%;">
                <h1 class="gold-gradient-text" style="font-family: var(--font-display-lux, 'Cinzel Decorative'); font-size: clamp(30px, 7vw, 42px); font-weight: 900; line-height: 1.15; margin: 0; text-transform: uppercase;">
                    {{ $groom }}
                </h1>
                
                <div style="font-family: var(--font-script, 'Great Vibes'); font-size: 36px; color: var(--invite-primary, #D4AF37); margin: -4px 0 -8px; opacity: 0.9;">
                    &amp;
                </div>

                <h1 class="gold-gradient-text" style="font-family: var(--font-display-lux, 'Cinzel Decorative'); font-size: clamp(30px, 7vw, 42px); font-weight: 900; line-height: 1.15; margin: 0; text-transform: uppercase;">
                    {{ $bride }}
                </h1>
            </div>
        @else
            {{-- Grand Festival / Celebration Title --}}
            <div style="margin: 14px 0 24px; width: 100%;">
                <h1 class="gold-gradient-text" style="font-family: var(--font-display-lux, 'Cinzel Decorative'); font-size: clamp(26px, 6.5vw, 38px); font-weight: 900; line-height: 1.25; margin: 0; text-transform: uppercase;">
                    {{ $content['heading'] ?? $invitation->title }}
                </h1>
            </div>
        @endif

        {{-- Date & Venue Pill Badge --}}
        <div style="display: inline-flex; flex-direction: column; gap: 6px; padding: 14px 28px; background: var(--invite-card-bg, rgba(15, 23, 42, 0.75)); backdrop-filter: blur(16px); border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.4)); border-radius: 999px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div style="font-size: 15px; font-weight: 700; color: var(--invite-heading, #FFFFFF); letter-spacing: 0.05em; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <span>📅</span>
                <span>{{ $dateDisplay }}</span>
            </div>
            <div style="font-size: 12px; color: var(--invite-primary, #D4AF37); letter-spacing: 0.08em; text-transform: uppercase; font-weight: 700;">
                📍 {{ $cityDisplay }}
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div style="margin-top: 36px; animation: bounce 2s infinite;">
            <a href="#section-events" style="color: var(--invite-text-muted, rgba(255,255,255,0.6)); text-decoration: none; font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; display: flex; flex-direction: column; align-items: center; gap: 4px;">
                <span>Explore Events</span>
                <span style="font-size: 16px;">↓</span>
            </a>
        </div>

    </div>
</section>
