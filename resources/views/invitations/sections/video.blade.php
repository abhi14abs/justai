{{-- Video Trailer Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];
    $videoUrl = $content['video_url'] ?? null;

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
@endphp

@if(!empty($videoUrl))
<section class="invitation-section" id="section-video" data-section-type="video">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'Wedding Teaser Film' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Watch Our Teaser' }}</span>
        </h2>
    </div>

    <div class="video-container-box" style="border-radius: 20px; overflow: hidden; border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.3)); aspect-ratio: 16/9; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.6); {{ $cardStyleAttr }}">
        @if(str_contains($videoUrl, 'youtube') || str_contains($videoUrl, 'youtu.be'))
            <iframe src="{{ str_replace('watch?v=', 'embed/', $videoUrl) }}" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
        @else
            <video src="{{ $videoUrl }}" controls style="width: 100%; height: 100%; object-fit: cover;"></video>
        @endif
    </div>
</section>
@endif
