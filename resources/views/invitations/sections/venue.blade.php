{{-- Venue & Accommodations Section --}}
@php
    $content = $section->content ?? [];
    $description = $content['description'] ?? 'An idyllic setting providing a majestic backdrop for our sacred celebration.';
    $airport = $content['airport_distance'] ?? null;
    $train = $content['train_distance'] ?? null;
@endphp

<section class="invitation-section" id="section-venue">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--invite-primary, #D4AF37); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'Sacred Venue' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFFFFF); margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Mandap & Celebration Hall' }}
        </h2>
    </div>

    <div class="event-card" style="padding: 20px;">
        <p style="font-size: 13px; color: var(--invite-text, #CBD5E1); line-height: 1.7; margin-bottom: 16px;">
            {{ $description }}
        </p>

        @if($airport || $train)
        <div style="border-top: 1px solid var(--invite-card-border, rgba(255, 255, 255, 0.08)); padding-top: 12px; display: flex; flex-direction: column; gap: 8px;">
            @if($airport)
            <div style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); display: flex; align-items: center; gap: 8px;">
                <span>✈️</span>
                <span>{{ $airport }}</span>
            </div>
            @endif
            @if($train)
            <div style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); display: flex; align-items: center; gap: 8px;">
                <span>🚆</span>
                <span>{{ $train }}</span>
            </div>
            @endif
        </div>
        @endif
    </div>
</section>
