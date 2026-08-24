@extends('layouts.app')

@section('title', '30% Recurring Affiliate & Partner Program | Postryx AI')
@section('meta_description', 'Earn 30% lifetime recurring monthly commissions by promoting Postryx AI to creators, founders, and marketing agencies.')

@section('content')

<section style="padding: 70px 24px 40px; text-align: center;">
    <div style="max-width: 960px; margin: 0 auto;">
        
        <span class="badge-pill-cyan" style="margin-bottom: 16px;">Partner &amp; Earn</span>
        
        <h1 style="font-size: clamp(34px, 5vw, 56px); font-weight: 800; margin-bottom: 20px;">
            Earn <span class="gradient-text">30% Lifetime Recurring</span> Commissions
        </h1>

        <p style="font-size: 18px; color: var(--text-secondary); max-width: 720px; margin: 0 auto 36px; line-height: 1.6;">
            Partner with the fastest-growing AI viral growth SaaS. Get paid every single month for every creator and agency you refer to Postryx.
        </p>

    </div>
</section>

{{-- Affiliate Link Generator Widget --}}
<section style="padding: 0 24px 60px;">
    <div class="glass-panel-glow" style="max-width: 800px; margin: 0 auto; padding: 32px; text-align: center;">
        <h3 style="font-size: 22px; color: #fff; margin-bottom: 12px;">Generate Your Instant Partner Link</h3>
        <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 24px;">Enter your username or handle to generate your custom tracking link immediately:</p>

        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px;">
            <input type="text" id="affiliate-handle" class="postryx-input" placeholder="Enter your creator handle (e.g. growth_guru)" value="creator" style="flex: 1; min-width: 240px;">
            <button onclick="generatePartnerLink()" class="btn-primary" style="padding: 12px 24px; font-weight: 700;">
                Generate Link 🔗
            </button>
        </div>

        <div style="background: rgba(11, 17, 33, 0.9); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 14px; display: flex; justify-content: space-between; align-items: center;">
            <span id="partner-link-display" style="font-family: monospace; color: #38bdf8; font-size: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-right: 12px;">https://postryx.in/?ref=creator</span>
            <button onclick="Postryx.copy(document.getElementById('partner-link-display').textContent, this)" class="btn-secondary" style="padding: 6px 14px; font-size: 13px; white-space: nowrap;">
                Copy Link
            </button>
        </div>
    </div>
</section>

{{-- 3 Benefits Cards --}}
<section style="padding: 20px 24px 70px; max-width: 1100px; margin: 0 auto;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
        <div class="glass-panel" style="padding: 28px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 16px;">💰</div>
            <h3 style="font-size: 20px; color: #fff; margin-bottom: 10px;">30% Recurring Payouts</h3>
            <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6;">You don't just earn on the first month—you get 30% of their subscription every month as long as they stay subscribed.</p>
        </div>

        <div class="glass-panel" style="padding: 28px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 16px;">🍪</div>
            <h3 style="font-size: 20px; color: #fff; margin-bottom: 10px;">60-Day Cookie Window</h3>
            <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6;">Even if your referral tests the free tools first and upgrades 50 days later, you receive full attribution and commission.</p>
        </div>

        <div class="glass-panel" style="padding: 28px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 16px;">⚡</div>
            <h3 style="font-size: 20px; color: #fff; margin-bottom: 10px;">Fast Monthly Payouts</h3>
            <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6;">Receive earnings on the 1st of every month via direct UPI / Bank Transfer (India) or PayPal / Stripe (Global).</p>
        </div>
    </div>

    {{-- Promotional Media Kit Banner --}}
    <div class="glass-panel-glow" style="margin-top: 48px; padding: 28px; text-align: center;">
        <span class="badge-pill-emerald" style="margin-bottom: 12px;">Marketing Media Kit Included</span>
        <h3 style="font-size: 22px; color: #fff; margin-bottom: 10px;">Ready-to-Use High-Converting Promotional Banners</h3>
        <p style="color: var(--text-secondary); font-size: 14px; max-width: 600px; margin: 0 auto 20px;">Use our official 4K graphics, feature mockups, and hook scorecards in your YouTube videos, LinkedIn posts, and tweets.</p>
        <div style="border-radius: 14px; overflow: hidden; border: 1px solid var(--border-active); box-shadow: 0 15px 40px rgba(0,0,0,0.6); max-width: 800px; margin: 0 auto;">
            <img src="{{ asset('images/postryx-hero-banner.png') }}" alt="Postryx AI Promotional Banner" style="width: 100%; height: auto; display: block;">
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    function generatePartnerLink() {
        const handle = document.getElementById('affiliate-handle').value.trim().toLowerCase().replace(/[^a-z0-9_-]/g, '') || 'creator';
        const url = `https://postryx.in/?ref=${handle}`;
        document.getElementById('partner-link-display').textContent = url;
        Postryx.showToast(`Partner tracking link generated for @${handle}!`);
    }
</script>
@endsection
