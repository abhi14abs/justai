{{-- Video Trailer Section --}}
@php
    $content = $section->content ?? [];
    $videoUrl = $content['video_url'] ?? null;
@endphp

@if(!empty($videoUrl))
<section class="invitation-section" id="section-video">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'Wedding Teaser Film' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: #FFF; margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Watch Our Teaser' }}
        </h2>
    </div>

    <div style="border-radius: 20px; overflow: hidden; border: 1px solid rgba(212, 175, 55, 0.3); aspect-ratio: 16/9; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.6);">
        @if(str_contains($videoUrl, 'youtube') || str_contains($videoUrl, 'youtu.be'))
            <iframe src="{{ str_replace('watch?v=', 'embed/', $videoUrl) }}" style="width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
        @else
            <video src="{{ $videoUrl }}" controls style="width: 100%; height: 100%; object-fit: cover;"></video>
        @endif
    </div>
</section>
@endif
