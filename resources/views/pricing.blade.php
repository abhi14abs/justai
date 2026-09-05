@extends('layouts.app')

@section('title', 'Pricing & Plans — Postryx AI Viral Content & SEO SaaS Platform')
@section('meta_description', 'Transparent, high-ROI pricing for creators, founders, and agencies. Start free with 5 daily credits or upgrade to Pro Growth with unlimited generations and AI humanizer.')
@section('meta_keywords', 'Postryx AI pricing, AI content generator plans, viral SaaS pricing, affordable AI copywriter, Postryx pro lifetime deal, postryx.in')
@section('og_title', 'Pricing & Plans — Postryx AI Viral SaaS Platform')
@section('og_description', 'Start free or get 50% OFF Lifetime Pro Access with code LAUNCH50. Unlimited viral copy and programmatic SEO generation.')

@section('extra_schema')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'Product',
  'name' => 'Postryx AI Growth Platform',
  'image' => url('/images/postryx-og-banner.png'),
  'description' => 'Autonomous AI platform for viral content creation, LinkedIn post generation, AI humanization, and programmatic SEO.',
  'brand' => [
    '@type' => 'Brand',
    'name' => 'Postryx AI'
  ],
  'offers' => [
    [
      '@type' => 'Offer',
      'name' => 'Starter Creator Plan',
      'price' => '4.99',
      'priceCurrency' => 'USD',
      'availability' => 'https://schema.org/InStock',
      'url' => url('/pricing')
    ],
    [
      '@type' => 'Offer',
      'name' => 'Pro Growth Plan',
      'price' => '12.49',
      'priceCurrency' => 'USD',
      'availability' => 'https://schema.org/InStock',
      'url' => url('/pricing')
    ],
    [
      '@type' => 'Offer',
      'name' => 'Agency Scale Plan',
      'price' => '29.99',
      'priceCurrency' => 'USD',
      'availability' => 'https://schema.org/InStock',
      'url' => url('/pricing')
    ]
  ],
  'aggregateRating' => [
    '@type' => 'AggregateRating',
    'ratingValue' => '4.9',
    'reviewCount' => '1420'
  ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('content')

<section style="padding: 70px 24px 40px; text-align: center;">
    <div style="max-width: 960px; margin: 0 auto;">
        
        <span class="badge-pill" style="margin-bottom: 16px;">Transparent Pricing</span>
        
        <h1 style="font-size: clamp(34px, 5vw, 56px); font-weight: 800; margin-bottom: 20px;">
            Accelerate Your <span class="gradient-text">Organic Reach Engine</span>
        </h1>

        <p style="font-size: 18px; color: var(--text-secondary); max-width: 720px; margin: 0 auto 36px; line-height: 1.6;">
            Start with 5 free daily credits or upgrade to unlimited generations, team seats, and priority model access.
        </p>

        {{-- Currency & Billing Controls --}}
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 20px; margin-bottom: 40px;">
            
            {{-- Currency Selector --}}
            <div style="background: rgba(15, 23, 42, 0.8); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 4px; display: inline-flex;">
                <button id="curr-inr" onclick="setCurrency('INR')" class="studio-tab-btn active" style="padding: 6px 16px; font-size: 13px;">
                    🇮🇳 INR (₹)
                </button>
                <button id="curr-usd" onclick="setCurrency('USD')" class="studio-tab-btn" style="padding: 6px 16px; font-size: 13px;">
                    🌐 USD ($)
                </button>
            </div>

            {{-- Billing Cycle Selector --}}
            <div style="background: rgba(15, 23, 42, 0.8); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 4px; display: inline-flex; align-items: center;">
                <button id="bill-monthly" onclick="setBilling('monthly')" class="studio-tab-btn active" style="padding: 6px 16px; font-size: 13px;">
                    Monthly
                </button>
                <button id="bill-annual" onclick="setBilling('annual')" class="studio-tab-btn" style="padding: 6px 16px; font-size: 13px;">
                    Annual <span class="badge-pill-emerald" style="font-size: 10px; margin-left: 4px;">Save 20%</span>
                </button>
            </div>

        </div>

        {{-- Coupon Box --}}
        <div class="glass-panel" style="max-width: 500px; margin: 0 auto 50px; padding: 16px 20px;">
            <div style="display: flex; gap: 8px;">
                <input type="text" id="pricing-coupon-input" class="postryx-input" placeholder="Have a coupon code? (e.g. LAUNCH50)" value="LAUNCH50" style="padding: 8px 14px; font-size: 13px; text-transform: uppercase;">
                <button onclick="applyPricingCoupon()" class="btn-secondary" style="padding: 8px 16px; font-size: 13px; white-space: nowrap;">Apply Code</button>
            </div>
            <div id="pricing-coupon-msg" style="font-size: 12px; margin-top: 6px; text-align: left;">
                <span style="color:#10b981;">✓ 50% Lifetime Launch Discount Applied with LAUNCH50!</span>
            </div>
        </div>

    </div>
</section>

{{-- 4 Pricing Cards (Starter, Pro, Agency, Lifetime Founders Pass) --}}
<section style="padding: 0 24px 80px;">
    <div style="max-width: 1240px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 24px; align-items: stretch;">
        
        {{-- Starter Creator --}}
        <div class="pricing-card">
            <h3 style="font-size: 20px; color: #fff; margin-bottom: 6px;">Starter Creator</h3>
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">For solopreneurs building personal brand presence.</p>
            
            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: baseline; gap: 4px;">
                    <span id="price-starter" style="font-size: 38px; font-weight: 800; color: #fff;">₹399</span>
                    <span id="period-starter" style="color: var(--text-muted); font-size: 13px;">/ mo</span>
                </div>
                <div id="orig-starter" style="font-size: 12px; color: var(--text-muted); text-decoration: line-through;">Original: ₹799/mo</div>
            </div>

            <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: var(--text-secondary);">
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> 500 AI Generations / month</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> All 12 Social &amp; SEO Tools</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> AI Humanizer (50k words)</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Social Card Graphic Exporter</li>
            </ul>

            <button onclick="triggerCheckout('starter')" class="btn-secondary" style="width: 100%; margin-top: auto;">Get Started</button>
        </div>

        {{-- Pro Growth (Popular) --}}
        <div class="pricing-card popular">
            <div class="popular-badge">Most Popular</div>
            <h3 style="font-size: 20px; color: #fff; margin-bottom: 6px;">Pro Growth</h3>
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">For founders, creators, and marketers scaling reach.</p>
            
            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: baseline; gap: 4px;">
                    <span id="price-pro" style="font-size: 38px; font-weight: 800; color: #38bdf8;">₹999</span>
                    <span id="period-pro" style="color: var(--text-muted); font-size: 13px;">/ mo</span>
                </div>
                <div id="orig-pro" style="font-size: 12px; color: var(--text-muted); text-decoration: line-through;">Original: ₹1,999/mo</div>
            </div>

            <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: #e2e8f0;">
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> <strong>Unlimited</strong> AI Generations</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> 1-Click Omni Repurposing Engine</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Unlimited AI Humanizer Pass</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Priority Gemini 2.0 &amp; GPT-4o</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Custom Brand Voices</li>
            </ul>

            <button onclick="triggerCheckout('pro')" class="btn-primary" style="width: 100%; margin-top: auto;">Claim Pro Growth 🚀</button>
        </div>

        {{-- Agency & Scale --}}
        <div class="pricing-card">
            <h3 style="font-size: 20px; color: #fff; margin-bottom: 6px;">Agency &amp; Scale</h3>
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">For agencies managing multiple client brands.</p>
            
            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: baseline; gap: 4px;">
                    <span id="price-agency" style="font-size: 38px; font-weight: 800; color: #fff;">₹2,499</span>
                    <span id="period-agency" style="color: var(--text-muted); font-size: 13px;">/ mo</span>
                </div>
                <div id="orig-agency" style="font-size: 12px; color: var(--text-muted); text-decoration: line-through;">Original: ₹4,999/mo</div>
            </div>

            <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: var(--text-secondary);">
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Everything in Pro Growth</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> 5 Team Member Seats</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Separate Client Workspaces</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> REST API &amp; Webhooks</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Dedicated 24/7 Slack Account Manager</li>
            </ul>

            <button onclick="triggerCheckout('agency')" class="btn-secondary" style="width: 100%; margin-top: auto;">Get Agency Plan</button>
        </div>

        {{-- Lifetime Founders Deal (High FOMO) --}}
        <div class="pricing-card" style="border-color: rgba(236, 72, 153, 0.5); background: rgba(236, 72, 153, 0.05);">
            <div class="badge-pill-amber" style="margin-bottom: 12px; align-self: flex-start;">Limited: 18 Spots Left</div>
            <h3 style="font-size: 20px; color: #fff; margin-bottom: 6px;">Lifetime Founders Pass</h3>
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">Pay once, access Postryx Pro forever with no recurring fees.</p>
            
            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: baseline; gap: 4px;">
                    <span id="price-lifetime" style="font-size: 38px; font-weight: 800; color: #f472b6;">₹4,999</span>
                    <span style="color: var(--text-muted); font-size: 13px;">one-time</span>
                </div>
                <div id="orig-lifetime" style="font-size: 12px; color: var(--text-muted); text-decoration: line-through;">Original: ₹9,999</div>
            </div>

            <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: #e2e8f0;">
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Lifetime Pro Growth Access</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> All Future Features Included</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Zero Monthly Fees Ever</li>
                <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> VIP Founders Discord Access</li>
            </ul>

            <button onclick="triggerCheckout('lifetime')" class="btn-glow-cyan btn-primary" style="width: 100%; margin-top: auto;">Claim Lifetime Deal 👑</button>
        </div>

    </div>
</section>

{{-- FAQ Section --}}
<section style="padding: 40px 24px 80px; max-width: 860px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 36px;">
        <h2 style="font-size: 30px; color: #fff;">Billing &amp; Subscription FAQ</h2>
    </div>

    <div class="faq-item active">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>What payment methods do you support?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            We support all major payment methods including UPI (Google Pay, PhonePe, Paytm), Netbanking, and Indian Rupee Debit/Credit cards via Razorpay, as well as International Credit/Debit Cards (Visa, Mastercard, Amex) via Stripe.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>Can I cancel or switch my plan at any time?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            Yes, you can cancel or upgrade your subscription anytime directly from your dashboard with zero lock-in or cancellation penalties.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>Do you offer a money-back guarantee?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            Yes, we offer a 14-day 100% money-back guarantee if you are not satisfied with the reach and engagement boost from Postryx AI.
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    let currentCurrency = 'INR';
    try {
        const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
        const isIndia = tz.includes('Calcutta') || tz.includes('Kolkata') || tz.includes('India');
        if (!isIndia) {
            currentCurrency = 'USD';
        }
    } catch (e) {}

    let currentBilling = 'monthly';
    let currentDiscount = 50; // default launch discount

    const basePricing = {
        INR: {
            starter: { monthly: 799, annual: 7990 },
            pro: { monthly: 1999, annual: 19990 },
            agency: { monthly: 4999, annual: 49990 },
            lifetime: 9999
        },
        USD: {
            starter: { monthly: 9.99, annual: 99 },
            pro: { monthly: 24.99, annual: 249 },
            agency: { monthly: 59.99, annual: 599 },
            lifetime: 129
        }
    };

    function setCurrency(curr) {
        currentCurrency = curr;
        document.getElementById('curr-inr').classList.toggle('active', curr === 'INR');
        document.getElementById('curr-usd').classList.toggle('active', curr === 'USD');
        renderPricing();
    }

    function setBilling(bill) {
        currentBilling = bill;
        document.getElementById('bill-monthly').classList.toggle('active', bill === 'monthly');
        document.getElementById('bill-annual').classList.toggle('active', bill === 'annual');
        renderPricing();
    }

    function applyPricingCoupon() {
        const code = document.getElementById('pricing-coupon-input').value;
        const msgEl = document.getElementById('pricing-coupon-msg');
        if (code.toUpperCase() === 'LAUNCH50') {
            currentDiscount = 50;
            msgEl.innerHTML = '<span style="color:#10b981;">✓ 50% Launch Discount Applied!</span>';
            renderPricing();
        } else {
            msgEl.innerHTML = '<span style="color:#f43f5e;">Invalid code. Try "LAUNCH50"</span>';
        }
    }

    function renderPricing() {
        const symbol = currentCurrency === 'INR' ? '₹' : '$';
        const p = basePricing[currentCurrency];
        const mult = (100 - currentDiscount) / 100;

        const starterVal = currentBilling === 'monthly' ? p.starter.monthly : Math.round(p.starter.annual / 12);
        const proVal = currentBilling === 'monthly' ? p.pro.monthly : Math.round(p.pro.annual / 12);
        const agencyVal = currentBilling === 'monthly' ? p.agency.monthly : Math.round(p.agency.annual / 12);
        const lifetimeVal = p.lifetime;

        document.getElementById('price-starter').textContent = `${symbol}${Math.round(starterVal * mult)}`;
        document.getElementById('orig-starter').textContent = `Original: ${symbol}${starterVal}/mo`;

        document.getElementById('price-pro').textContent = `${symbol}${Math.round(proVal * mult)}`;
        document.getElementById('orig-pro').textContent = `Original: ${symbol}${proVal}/mo`;

        document.getElementById('price-agency').textContent = `${symbol}${Math.round(agencyVal * mult)}`;
        document.getElementById('orig-agency').textContent = `Original: ${symbol}${agencyVal}/mo`;

        document.getElementById('price-lifetime').textContent = `${symbol}${Math.round(lifetimeVal * mult)}`;
        document.getElementById('orig-lifetime').textContent = `Original: ${symbol}${lifetimeVal}`;
    }

    function triggerCheckout(plan) {
        const bill = plan === 'lifetime' ? 'lifetime' : currentBilling;
        if (typeof window.trackGAEvent === 'function') {
            window.trackGAEvent('begin_checkout', {
                plan_name: plan,
                currency: currentCurrency,
                billing_cycle: bill,
                value: plan === 'lifetime' ? 99 : (plan === 'agency' ? 29.99 : (plan === 'pro' ? 12.49 : 4.99))
            });
        }
        window.location.href = `/checkout?plan=${plan}&currency=${currentCurrency}&billing=${bill}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('curr-inr')?.classList.toggle('active', currentCurrency === 'INR');
        document.getElementById('curr-usd')?.classList.toggle('active', currentCurrency === 'USD');
        renderPricing();
    });
</script>
@endsection
