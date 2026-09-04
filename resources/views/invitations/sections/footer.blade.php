{{-- Footer Section --}}
<footer class="invitation-section" id="section-footer" style="text-align: center; border-bottom: none; padding-bottom: 80px;">
    <div style="font-size: 28px; margin-bottom: 12px;">✨</div>
    
    <h3 style="font-family: var(--font-serif-lux); font-size: 20px; color: var(--gold-primary); margin-bottom: 6px; font-weight: 700;">
        {{ $section->title ?? '#PriyaWedsRahul2026' }}
    </h3>

    <p style="font-size: 13px; color: #94A3B8; margin-bottom: 24px;">
        {{ $section->subtitle ?? 'We eagerly look forward to celebrating our special day with you.' }}
    </p>

    {{-- Share on WhatsApp / Socials --}}
    <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 28px;">
        <button type="button" onclick="shareInvitation('whatsapp')" class="btn-primary" style="padding: 10px 18px; font-size: 12px; border-radius: 999px;">
            <span>Share on WhatsApp 💬</span>
        </button>
        <button type="button" onclick="shareInvitation('native')" class="btn-secondary" style="padding: 10px 18px; font-size: 12px; border-radius: 999px;">
            <span>Copy Link 🔗</span>
        </button>
    </div>

    <div style="font-size: 10px; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 0.1em;">
        Created with ❤️ on CelebrateAI Digital Platform
    </div>
</footer>
