{{-- Family & Hosts Section --}}
@php
    $content = $section->content ?? [];
    $parentsBride = $content['parents_bride'] ?? 'Mr. Suresh & Mrs. Sunita Sharma';
    $parentsGroom = $content['parents_groom'] ?? 'Mr. Ramesh & Mrs. Kavita Verma';
@endphp

<section class="invitation-section" id="section-family">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'With Blessings From' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: #FFF; margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Our Beloved Families' }}
        </h2>
    </div>

    <div style="display: grid; grid-template-columns: 1fr; gap: 14px;">
        <div class="event-card" style="text-align: center; padding: 20px;">
            <div style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; letter-spacing: 0.1em; margin-bottom: 4px;">Bride’s Family</div>
            <div style="font-size: 16px; font-weight: 700; color: #FFF;">{{ $parentsBride }}</div>
        </div>

        <div class="event-card" style="text-align: center; padding: 20px;">
            <div style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; letter-spacing: 0.1em; margin-bottom: 4px;">Groom’s Family</div>
            <div style="font-size: 16px; font-weight: 700; color: #FFF;">{{ $parentsGroom }}</div>
        </div>
    </div>
</section>
