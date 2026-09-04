{{-- Photo Gallery Section --}}
@php
    $content = $section->content ?? [];
    $images = $content['images'] ?? [
        ['url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80', 'caption' => 'The Proposal'],
        ['url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80', 'caption' => 'Pre-Wedding Shoot'],
        ['url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80', 'caption' => 'Sunset by the Lake'],
        ['url' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=800&q=80', 'caption' => 'Ring Exchange'],
    ];
@endphp

<section class="invitation-section" id="section-gallery">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'Moments of Love' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: #FFF; margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Our Pre-Wedding Memories' }}
        </h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
        @foreach($images as $img)
        <div style="border-radius: 16px; overflow: hidden; position: relative; border: 1px solid rgba(212, 175, 55, 0.3); aspect-ratio: 1/1; box-shadow: 0 8px 20px rgba(0,0,0,0.5);">
            <img src="{{ $img['url'] }}" alt="{{ $img['caption'] ?? 'Photo' }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
            @if(!empty($img['caption']))
            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, transparent 100%); padding: 12px 8px 6px; font-size: 11px; color: #FFF; text-align: center; font-weight: 600;">
                {{ $img['caption'] }}
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>
