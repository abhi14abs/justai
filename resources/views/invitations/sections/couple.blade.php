{{-- Couple & Story Section --}}
@php
    $content = $section->content ?? [];
    $brideBio = $content['bride_bio'] ?? '';
    $groomBio = $content['groom_bio'] ?? '';
    $story = $content['story'] ?? '';
@endphp

<section class="invitation-section" id="section-couple">
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'The Couple' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 26px; color: #FFF; margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Two Souls, One Sacred Journey' }}
        </h2>
    </div>

    @if(!empty($story))
    <div class="glass-panel" style="padding: 24px; border-radius: 20px; border: 1px solid rgba(212, 175, 55, 0.25); background: rgba(15, 23, 42, 0.6); margin-bottom: 24px; text-align: center; position: relative;">
        <div style="font-family: var(--font-script); font-size: 40px; color: var(--gold-primary); line-height: 0; margin-bottom: 16px; opacity: 0.8;">“</div>
        <p style="color: #E2E8F0; font-size: 14px; line-height: 1.8; font-style: italic; margin: 0;">
            {{ $story }}
        </p>
        <div style="font-family: var(--font-script); font-size: 40px; color: var(--gold-primary); line-height: 0; margin-top: 20px; opacity: 0.8;">”</div>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
        @if(!empty($groomBio))
        <div class="event-card" style="padding: 20px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span style="font-size: 24px;">🤴</span>
                <div>
                    <div style="font-size: 16px; font-weight: 700; color: #FFF;">The Groom</div>
                    <div style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 600;">Rahul Verma</div>
                </div>
            </div>
            <p style="font-size: 13px; color: #94A3B8; line-height: 1.6; margin: 0;">{{ $groomBio }}</p>
        </div>
        @endif

        @if(!empty($brideBio))
        <div class="event-card" style="padding: 20px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span style="font-size: 24px;">👸</span>
                <div>
                    <div style="font-size: 16px; font-weight: 700; color: #FFF;">The Bride</div>
                    <div style="font-size: 11px; color: var(--gold-primary); text-transform: uppercase; font-weight: 600;">Priya Sharma</div>
                </div>
            </div>
            <p style="font-size: 13px; color: #94A3B8; line-height: 1.6; margin: 0;">{{ $brideBio }}</p>
        </div>
        @endif
    </div>
</section>
