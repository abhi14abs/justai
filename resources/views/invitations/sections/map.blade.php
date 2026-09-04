{{-- Google Map Directions Section --}}
<section class="invitation-section" id="section-map" style="text-align: center;">
    <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
        ✦ {{ $section->title ?? 'Directions & Navigation' }} ✦
    </div>
    
    <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: #FFF; margin: 0 0 16px; font-weight: 700;">
        {{ $section->subtitle ?? 'Get Directions via Google Maps' }}
    </h2>

    <div style="border-radius: 20px; overflow: hidden; border: 1px solid rgba(212, 175, 55, 0.3); box-shadow: 0 10px 30px rgba(0,0,0,0.6); position: relative; background: #0F172A; min-height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px;">
        <span style="font-size: 40px; margin-bottom: 12px;">🗺️</span>
        <div style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 4px;">Taj Lake Palace, Udaipur</div>
        <div style="font-size: 12px; color: #94A3B8; margin-bottom: 18px;">Pichola, Udaipur, Rajasthan 313001</div>
        
        <a href="https://maps.google.com/?q=Taj+Lake+Palace+Udaipur" target="_blank" class="btn-primary" style="padding: 10px 24px; font-size: 13px; text-decoration: none; border-radius: 999px;">
            <span>Open in Google Maps &rarr;</span>
        </a>
    </div>
</section>
