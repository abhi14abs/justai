{{-- Dress Code Guidelines Section --}}
@php
    $content = $section->content ?? [];
    $mehendi = $content['mehendi'] ?? 'Pastels & Bright Floral Lehengas';
    $haldi = $content['haldi'] ?? 'Sunshine Yellow & Mustard Kurtas';
    $wedding = $content['wedding'] ?? 'Traditional Royal Heritage & Sherwanis';
@endphp

<section class="invitation-section" id="section-dress_code">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'Attire & Palette' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: #FFF; margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Dress Code Guidelines' }}
        </h2>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        <div class="event-card" style="padding: 16px 20px;">
            <div style="font-size: 12px; font-weight: 700; color: var(--gold-primary); text-transform: uppercase; margin-bottom: 2px;">Mehendi &amp; Sangeet</div>
            <div style="font-size: 14px; color: #FFF;">{{ $mehendi }}</div>
        </div>

        <div class="event-card" style="padding: 16px 20px;">
            <div style="font-size: 12px; font-weight: 700; color: #F59E0B; text-transform: uppercase; margin-bottom: 2px;">Haldi Celebration</div>
            <div style="font-size: 14px; color: #FFF;">{{ $haldi }}</div>
        </div>

        <div class="event-card" style="padding: 16px 20px;">
            <div style="font-size: 12px; font-weight: 700; color: #10B981; text-transform: uppercase; margin-bottom: 2px;">Varmala &amp; Royal Reception</div>
            <div style="font-size: 14px; color: #FFF;">{{ $wedding }}</div>
        </div>
    </div>
</section>
