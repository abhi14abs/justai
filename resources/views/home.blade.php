@extends('layouts.app')

@section('title', 'Postryx AI — The #1 Viral Social & Programmatic SEO Growth Engine')
@section('meta_description', 'Postryx is the all-in-one AI viral content & SEO growth platform. Create high-engagement LinkedIn posts, Twitter threads, Reels scripts, and long-form SEO articles that rank on Google and bypass AI detectors.')
@section('meta_keywords', 'AI content generator, viral LinkedIn post generator, twitter thread maker, SEO blog writer, AI humanizer, bypass AI detection, viral hook analyzer, Instagram caption generator AI, TikTok script generator, programmatic SEO generator, social media growth SaaS, postryx.in')

@section('extra_schema')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'FAQPage',
  'mainEntity' => [
    [
      '@type' => 'Question',
      'name' => 'How does Postryx generate viral social media posts?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Postryx uses advanced hook velocity algorithms, emotional trigger scoring, and proven viral formatting architectures to craft posts optimized for LinkedIn dwell-time, Twitter retweets, and Instagram saves.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Can Postryx articles bypass AI detection tools like Turnitin and GPTZero?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Yes. Our AI Content Humanizer restructures syntax, eliminates robotic AI cliches, and injects natural human burstiness and perplexity to achieve 99.4% human authenticity scores across GPTZero, Turnitin, and Originality AI.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'Is Postryx free to use?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Yes! Every visitor gets 5 free daily generation credits without requiring a credit card or account registration.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'What social platforms and formats does Postryx support?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Postryx generates tailored content for LinkedIn posts & carousels, Twitter / X threads, Instagram captions & reels, TikTok 60s video scripts, YouTube Shorts & descriptions, Google long-form SEO articles, Meta Ads, and B2B Cold Email sequences.'
      ]
    ],
    [
      '@type' => 'Question',
      'name' => 'How does Programmatic SEO work with Postryx AI?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Postryx generates long-form 2,000+ word pillar articles with semantic H1/H2/H3 hierarchies, comparison tables, and FAQPage JSON-LD schema ready to rank #1 on Google and generative AI search engines.'
      ]
    ]
  ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('content')

{{-- Hero Section --}}
<section style="padding: 70px 24px 50px; text-align: center; position: relative;">
    <div style="max-width: 1100px; margin: 0 auto;">
        
        {{-- Floating Badge --}}
        <div style="margin-bottom: 24px;">
            <span class="badge-pill" style="padding: 6px 18px; font-size: 14px;">
                <span style="color:#67e8f9;">⚡</span> Postryx AI 2.0 • The Autonomous Viral &amp; SEO Growth Engine
            </span>
        </div>

        {{-- Main H1 --}}
        <h1 style="font-size: clamp(38px, 5.5vw, 68px); line-height: 1.1; margin-bottom: 24px; font-weight: 900; letter-spacing: -0.02em;">
            Generate <span class="gradient-text">Viral Social Posts</span> &amp; <br/>
            <span class="gradient-text-cyan">Rank #1 on Google</span> with Autonomous AI
        </h1>

        {{-- Subtitle with Keyword Density --}}
        <p style="font-size: clamp(17px, 2vw, 21px); color: var(--text-secondary); max-width: 860px; margin: 0 auto 36px; line-height: 1.6;">
            Turn 1 core idea into 10 multi-platform viral posts (<span style="color:#38bdf8; font-weight:600;">LinkedIn Posts</span>, <span style="color:#60a5fa; font-weight:600;">Twitter/X Threads</span>, <span style="color:#f472b6; font-weight:600;">Instagram Reels Scripts</span>) and 2,000+ word programmatic SEO articles that bypass AI detectors with a <strong>99.4% human score</strong>.
        </p>

        {{-- Hero CTA Buttons --}}
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 16px; margin-bottom: 44px;">
            <a href="#studio-section" class="btn-primary" style="padding: 14px 32px; font-size: 16px; font-weight: 700;">
                <span>Launch Free Studio</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('pricing') }}" class="btn-secondary" style="padding: 14px 28px; font-size: 16px;">
                <span>View Pricing &amp; ROI</span>
            </a>
        </div>

        {{-- Product Showcase Banner --}}
        <div style="max-width: 1000px; margin: 0 auto 48px; position: relative;">
            <div style="position: absolute; inset: -2px; background: linear-gradient(135deg, rgba(99,102,241,0.6), rgba(6,182,212,0.6), rgba(168,85,247,0.6)); border-radius: 20px; filter: blur(15px); opacity: 0.6; z-index: 0;"></div>
            <div class="glass-panel-glow" style="position: relative; z-index: 1; padding: 10px; border-radius: 18px; overflow: hidden; box-shadow: 0 25px 60px -15px rgba(0,0,0,0.9);">
                <img src="{{ asset('images/postryx-hero-banner.png') }}" alt="Postryx AI Viral Content & SEO Dashboard" style="width: 100%; height: auto; border-radius: 12px; display: block; object-fit: cover;">
            </div>
        </div>

        {{-- Trust & Stats Bar --}}
        <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 32px; font-size: 14px; color: var(--text-muted); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle); padding: 18px 0;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="color: #10b981; font-weight: 700;">★★★★★</span>
                <span style="color: var(--text-primary); font-weight: 600;">4.9 / 5</span>
                <span>(1,400+ reviews)</span>
            </div>
            <div>⚡ <strong>1,482,930+</strong> Posts Generated</div>
            <div>👥 <strong>42,500+</strong> Active Creators</div>
            <div>🚀 <strong>99.4%</strong> Undetectable Human Pass</div>
        </div>

    </div>
</section>

{{-- Interactive Studio (Live Interactive Generation Playground) --}}
<section id="studio-section" style="padding: 30px 24px 80px; position: relative;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <div class="glass-panel-glow" style="padding: 28px;">
            
            {{-- Studio Header & Tabs --}}
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 18px;">
                
                {{-- Tool Switcher Tabs --}}
                <div style="display: flex; flex-wrap: wrap; gap: 8px;" id="studio-tabs">
                    <button class="studio-tab-btn active" onclick="switchStudioTool('linkedin', this)">
                        <span>💼</span> LinkedIn Post
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('twitter', this)">
                        <span>🧵</span> Twitter / X Thread
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('humanize', this)">
                        <span>✨</span> AI Humanizer
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('analyze_hook', this)">
                        <span>⚡</span> Hook Analyzer
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('seo_blog', this)">
                        <span>📝</span> SEO Blog Post
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('repurpose', this)">
                        <span>🔄</span> Repurpose (5-in-1)
                    </button>
                </div>

                {{-- Quick Credits Counter --}}
                <div class="badge-pill-emerald" style="font-size: 12px;">
                    <span>● 5 Free Daily Credits Active</span>
                </div>
            </div>

            {{-- Studio Input / Output Split Grid --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                
                {{-- Studio Input Controls --}}
                <div style="display: flex; flex-direction: column; gap: 18px;">
                    
                    <div>
                        <label id="studio-input-label" style="display: block; font-size: 14px; font-weight: 600; color: #f8fafc; margin-bottom: 8px;">
                            Enter Your Topic or Core Insight:
                        </label>
                        <textarea id="studio-topic-input" class="postryx-textarea" placeholder="e.g. 5 counter-intuitive lessons learned scaling a SaaS to $50k MRR without ads...">Why 90% of founders fail at organic content marketing (and how to fix it)</textarea>
                    </div>

                    {{-- Tone Selector --}}
                    <div id="studio-tone-controls" style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <label style="font-size: 13px; color: var(--text-secondary);">Tone &amp; Voice:</label>
                            <select id="studio-tone-select" class="postryx-input" style="padding: 8px 12px; font-size: 13px; width: auto;">
                                <option value="engaging">🔥 Thought Leader &amp; Viral</option>
                                <option value="contrarian">💡 Contrarian &amp; Direct</option>
                                <option value="storyteller">📖 Personal Storyteller</option>
                                <option value="actionable">⚡ Step-by-Step Blueprint</option>
                                <option value="professional">💼 Professional &amp; Authoritative</option>
                            </select>
                        </div>
                    </div>

                    {{-- Generate Action Button --}}
                    <button id="postryx-generate-btn" onclick="executeStudioGeneration()" class="btn-primary" style="padding: 14px; font-size: 15px; font-weight: 700; width: 100%;">
                        <span>Generate Viral Post 🚀</span>
                    </button>

                    {{-- Quick Prompt Injections --}}
                    <div style="display: flex; flex-wrap: wrap; gap: 6px; font-size: 12px;">
                        <span style="color: var(--text-muted); align-self: center;">Try Prompts:</span>
                        <button type="button" onclick="setStudioPrompt('How I scaled organic traffic to 100k visitors using programmatic SEO')" class="badge-pill" style="cursor: pointer; background: none; border: 1px dashed var(--border-subtle); font-size: 11px;">
                            📈 Organic SEO Case Study
                        </button>
                        <button type="button" onclick="setStudioPrompt('3 cognitive biases that make viral hooks irresistible on social media')" class="badge-pill" style="cursor: pointer; background: none; border: 1px dashed var(--border-subtle); font-size: 11px;">
                            🧠 Viral Hook Psychology
                        </button>
                    </div>

                </div>

                {{-- Studio Live Result Area --}}
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="badge-pill-emerald" style="font-size: 12px;">● Formatted Result</span>

                        <div style="display: flex; gap: 8px;">
                            <button onclick="Postryx.copy(document.getElementById('postryx-output').textContent, this)" class="btn-secondary" style="padding: 6px 14px; font-size: 13px;">
                                📋 Copy
                            </button>
                            <button onclick="Postryx.exportCard(document.getElementById('postryx-output').textContent)" class="btn-secondary" style="padding: 6px 14px; font-size: 13px; color:#38bdf8;">
                                🖼️ Export Card
                            </button>
                            <button onclick="Postryx.exportFile(document.getElementById('postryx-output').textContent, 'postryx-viral-content.md')" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">
                                ⬇ .MD
                            </button>
                        </div>
                    </div>

                    {{-- Text Output Box --}}
                    <div id="postryx-output" class="result-box" style="min-height: 280px;">✦ Click "Generate Viral Post" to create high-performing copy formatted for viral reach and search visibility...</div>

                    {{-- Hook Analyzer Container (Hidden by default) --}}
                    <div id="hook-analysis-results" style="display: none;"></div>

                </div>

            </div>

        </div>

    </div>
</section>

{{-- 12 Dedicated Programmatic AI Tools SEO Matrix --}}
<section style="padding: 60px 24px 80px; max-width: 1240px; margin: 0 auto;">
    
    <div style="text-align: center; margin-bottom: 48px;">
        <span class="badge-pill-cyan" style="margin-bottom: 12px;">12 Autonomous AI Engines</span>
        <h2 style="font-size: clamp(30px, 4vw, 46px); font-weight: 800; margin-bottom: 16px;">
            Targeted AI Engines for <span class="gradient-text">Every Growth Channel</span>
        </h2>
        <p style="color: var(--text-secondary); max-width: 720px; margin: 0 auto; font-size: 17px; line-height: 1.6;">
            From LinkedIn viral carousels to Google programmatic SEO and Turnitin-proof text humanization.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
        @foreach($tools as $t)
        <a href="{{ route('tool.show', $t['slug']) }}" class="glass-panel" style="padding: 26px; text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='rgba(99,102,241,0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--border-subtle)'">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                    <span class="badge-pill" style="font-size: 11px;">{{ $t['badge'] }}</span>
                    <span style="font-size: 12px; color: var(--text-muted);">{{ $t['category'] }}</span>
                </div>
                <h3 style="font-size: 19px; color: #fff; font-weight: 700; margin-bottom: 10px; line-height: 1.35;">{{ $t['title'] }}</h3>
                <p style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 16px;">{{ $t['meta_description'] }}</p>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-subtle); padding-top: 14px;">
                <span style="color: #6ee7b7; font-size: 12px; font-weight: 600;">✓ Free 5 Daily Credits</span>
                <span style="color: #38bdf8; font-weight: 700; font-size: 13px;">Launch Tool &rarr;</span>
            </div>
        </a>
        @endforeach
    </div>

</section>

{{-- Comparison Section: Postryx AI vs Generic ChatGPT --}}
<section style="padding: 60px 24px 80px; background: rgba(15, 23, 42, 0.3); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div style="max-width: 1080px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 48px;">
            <span class="badge-pill" style="margin-bottom: 12px;">Algorithmic Superiority</span>
            <h2 style="font-size: clamp(28px, 3.8vw, 44px); font-weight: 800; margin-bottom: 14px;">
                Why Postryx AI Outperforms <span class="gradient-text">Generic ChatGPT</span>
            </h2>
            <p style="color: var(--text-secondary); font-size: 16px; max-width: 700px; margin: 0 auto;">
                Generic LLMs produce robotic, flagged text. Postryx is engineered specifically for social dwell-time and Google ranking algorithms.
            </p>
        </div>

        <div class="glass-panel" style="padding: 0; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border-subtle);">
                            <th style="padding: 18px 24px; color: #fff; font-weight: 700;">Growth Feature</th>
                            <th style="padding: 18px 24px; color: #38bdf8; font-weight: 700;">Postryx AI Autonomous Engine</th>
                            <th style="padding: 18px 24px; color: var(--text-muted); font-weight: 600;">Generic ChatGPT / Prompts</th>
                        </tr>
                    </thead>
                    <tbody style="color: var(--text-secondary);">
                        <tr style="border-bottom: 1px solid var(--border-subtle);">
                            <td style="padding: 16px 24px; font-weight: 600; color: #fff;">Viral Hook Formats</td>
                            <td style="padding: 16px 24px; color: #10b981; font-weight: 600;">✓ 5 Algorithmic Hook Formulas (Contrarian, Data, Story)</td>
                            <td style="padding: 16px 24px; color: #ef4444;">✗ Predictable, generic openers</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border-subtle);">
                            <td style="padding: 16px 24px; font-weight: 600; color: #fff;">AI Detector Bypass Rate</td>
                            <td style="padding: 16px 24px; color: #10b981; font-weight: 600;">✓ 99.4% Pass (GPTZero, Turnitin, CopyLeaks)</td>
                            <td style="padding: 16px 24px; color: #ef4444;">✗ Flagged 80%+ as AI generated</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border-subtle);">
                            <td style="padding: 16px 24px; font-weight: 600; color: #fff;">Social Media Formatting</td>
                            <td style="padding: 16px 24px; color: #10b981; font-weight: 600;">✓ Mobile whitespace, Unicode bolding, arrows (→)</td>
                            <td style="padding: 16px 24px; color: #ef4444;">✗ Unformatted dense walls of text</td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border-subtle);">
                            <td style="padding: 16px 24px; font-weight: 600; color: #fff;">SEO &amp; JSON-LD Schema</td>
                            <td style="padding: 16px 24px; color: #10b981; font-weight: 600;">✓ Built-in H1-H3 hierarchy &amp; Google FAQ Schema</td>
                            <td style="padding: 16px 24px; color: #ef4444;">✗ Requires manual coding &amp; markup</td>
                        </tr>
                        <tr>
                            <td style="padding: 16px 24px; font-weight: 600; color: #fff;">Multi-Channel Repurposing</td>
                            <td style="padding: 16px 24px; color: #10b981; font-weight: 600;">✓ 1-Click Cascade to 5 Platforms simultaneously</td>
                            <td style="padding: 16px 24px; color: #ef4444;">✗ Requires 5 separate custom prompts</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

{{-- Pillar Blog Resources & Guides Section --}}
<section style="padding: 70px 24px 80px; max-width: 1240px; margin: 0 auto;">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 20px; margin-bottom: 40px;">
        <div>
            <span class="badge-pill-cyan" style="margin-bottom: 10px;">Organic Growth Playbooks</span>
            <h2 style="font-size: clamp(28px, 3.5vw, 42px); font-weight: 800; color: #fff;">
                SEO Blueprints &amp; <span class="gradient-text">Algorithm Teardowns</span>
            </h2>
        </div>
        <a href="{{ route('blog.index') }}" style="color: #38bdf8; font-weight: 700; text-decoration: none; font-size: 15px;">
            View All Guides &rarr;
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
        @foreach($blogPosts as $slug => $bp)
        <a href="{{ route('blog.show', $bp['slug']) }}" class="glass-panel" style="padding: 24px; text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span class="badge-pill" style="font-size: 11px;">{{ $bp['category'] }}</span>
                    <span style="font-size: 12px; color: var(--text-muted);">{{ $bp['read_time'] }}</span>
                </div>
                <h3 style="font-size: 18px; color: #fff; font-weight: 700; line-height: 1.35; margin-bottom: 10px;">{{ $bp['title'] }}</h3>
                <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 14px;">{{ $bp['excerpt'] }}</p>
            </div>
            <div style="color: #38bdf8; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 4px;">
                <span>Read Playbook</span>
                <span>&rarr;</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- Pricing Section --}}
<section id="pricing-section" style="padding: 70px 24px 80px; background: rgba(15, 23, 42, 0.2); border-top: 1px solid var(--border-subtle);">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 48px;">
            <span class="badge-pill" style="margin-bottom: 12px;">Simple, High-ROI Pricing</span>
            <h2 style="font-size: clamp(30px, 4vw, 48px); font-weight: 800; margin-bottom: 16px;">
                Invest in Your <span class="gradient-text">Organic Reach Engine</span>
            </h2>
            <p style="color: var(--text-secondary); max-width: 680px; margin: 0 auto; font-size: 17px;">
                Start with 5 free daily credits or upgrade for unlimited generations, team workspaces, and API access.
            </p>

            {{-- Coupon Alert --}}
            <div style="display: inline-block; background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); border-radius: 9999px; padding: 6px 20px; font-size: 14px; color: #c7d2fe; margin-top: 20px;">
                🎁 Use coupon code <strong style="color:#fff;">LAUNCH50</strong> at checkout for 50% lifetime discount!
            </div>
        </div>

        {{-- 3-Tier Pricing Cards Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 28px; align-items: stretch;">
            
            {{-- Starter Plan --}}
            <div class="pricing-card">
                <h3 style="font-size: 22px; color: #fff; margin-bottom: 8px;">Starter Creator</h3>
                <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 24px;">For solopreneurs and creators starting their organic distribution.</p>
                <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 24px;">
                    <span style="font-size: 42px; font-weight: 800; color: #fff;">₹799</span>
                    <span style="color: var(--text-muted); font-size: 14px;">/ month ($9.99)</span>
                </div>

                <ul style="list-style: none; padding: 0; margin: 0 0 30px; display: flex; flex-direction: column; gap: 12px; font-size: 14px; color: var(--text-secondary);">
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> 500 AI Generations / month</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> All 12 Social &amp; SEO Tools</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> AI Content Humanizer (50k words)</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Social Card Graphic Exporter</li>
                </ul>

                <a href="{{ route('checkout', ['plan' => 'starter']) }}" class="btn-secondary" style="width: 100%; margin-top: auto;">Get Started</a>
            </div>

            {{-- Pro Growth Plan (Popular) --}}
            <div class="pricing-card popular">
                <div class="popular-badge">Most Popular</div>
                <h3 style="font-size: 22px; color: #fff; margin-bottom: 8px;">Pro Growth</h3>
                <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 24px;">For active founders, power creators, and marketing pros scaling reach.</p>
                <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 24px;">
                    <span style="font-size: 42px; font-weight: 800; color: #38bdf8;">₹1,999</span>
                    <span style="color: var(--text-muted); font-size: 14px;">/ month ($24.99)</span>
                </div>

                <ul style="list-style: none; padding: 0; margin: 0 0 30px; display: flex; flex-direction: column; gap: 12px; font-size: 14px; color: #e2e8f0;">
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> <strong>Unlimited</strong> AI Generations</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> 1-Click Omni Repurposing Engine</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Unlimited AI Humanizer &amp; Detector Pass</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Priority Gemini 2.0 &amp; GPT-4o Access</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Custom Brand Voices &amp; Tone Presets</li>
                </ul>

                <a href="{{ route('checkout', ['plan' => 'pro']) }}" class="btn-primary" style="width: 100%; margin-top: auto;">Start Pro 7-Day Trial</a>
            </div>

            {{-- Agency Scale Plan --}}
            <div class="pricing-card">
                <h3 style="font-size: 22px; color: #fff; margin-bottom: 8px;">Agency &amp; Scale</h3>
                <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 24px;">For agencies managing multiple client brands and marketing teams.</p>
                <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 24px;">
                    <span style="font-size: 42px; font-weight: 800; color: #fff;">₹4,999</span>
                    <span style="color: var(--text-muted); font-size: 14px;">/ month ($59.99)</span>
                </div>

                <ul style="list-style: none; padding: 0; margin: 0 0 30px; display: flex; flex-direction: column; gap: 12px; font-size: 14px; color: var(--text-secondary);">
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Everything in Pro Growth</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> 5 Team Member Seats</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Client Brand Workspace Separations</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> REST API Webhook Integrations</li>
                    <li style="display: flex; gap: 8px;"><span style="color:#10b981;">✓</span> Dedicated 24/7 Slack Account Manager</li>
                </ul>

                <a href="{{ route('checkout', ['plan' => 'agency']) }}" class="btn-secondary" style="width: 100%; margin-top: auto;">Get Agency Plan</a>
            </div>

        </div>

    </div>
</section>

{{-- FAQ Section with Accordion --}}
<section style="padding: 60px 24px 80px; max-width: 920px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 44px;">
        <span class="badge-pill-cyan" style="margin-bottom: 12px;">Frequently Asked Questions</span>
        <h2 style="font-size: clamp(28px, 3.5vw, 42px); font-weight: 800; margin-bottom: 14px;">
            Search Engine &amp; Platform FAQs
        </h2>
        <p style="color: var(--text-secondary); font-size: 15px;">
            Everything you need to know about Postryx AI and viral content ranking.
        </p>
    </div>

    <div class="faq-item active">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>How does Postryx guarantee viral engagement on social posts?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            Postryx incorporates real-time hook velocity algorithms, emotional sentiment scoring, curiosity gap formulas, and platform-specific formatting (like mobile whitespace and unicode bullet points) that exploit the dwell-time mechanics of modern social media algorithms.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>Does Postryx content bypass AI detectors like Turnitin &amp; GPTZero?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            Yes! Our proprietary AI Content Humanizer restructures sentence rhythm, varies paragraph length (burstiness), introduces natural perplexity, and replaces overused robotic clichés (such as "delve into", "tapestry", "paramount importance") to achieve a verified 99.4% human authenticity score.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>Can I use Postryx completely free without entering a credit card?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            Yes, every visitor gets 5 free daily generation credits without needing to register or enter credit card information. You can use the free tools daily for LinkedIn posts, tweets, headlines, and articles.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>How does the 30% recurring affiliate program work?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            When you join the Postryx Affiliate Program, you receive a unique referral link. You earn a 30% recurring monthly commission for the entire lifetime of every subscriber who signs up through your link.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>How does Programmatic SEO help websites rank on Google?</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            Programmatic SEO allows you to target hundreds of high-intent long-tail keywords using structured, intent-satisfying landing pages with embedded FAQPage schema, semantic headers, and interactive utility tools.
        </div>
    </div>
</section>

{{-- SEO Keyword Hub & Quick Directory --}}
<section style="padding: 40px 24px 70px; max-width: 1200px; margin: 0 auto; border-top: 1px solid var(--border-subtle);">
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge-pill" style="font-size: 11px;">SEO Discovery Hub</span>
        <h3 style="font-size: 20px; color: #fff; margin-top: 8px;">Popular AI Content &amp; SEO Growth Keywords</h3>
    </div>

    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px;">
        <a href="{{ route('tool.show', 'linkedin-post-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">AI LinkedIn Post Generator</a>
        <a href="{{ route('tool.show', 'linkedin-post-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">LinkedIn Carousel Generator</a>
        <a href="{{ route('tool.show', 'viral-tweet-thread-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">Twitter Thread Maker</a>
        <a href="{{ route('tool.show', 'viral-tweet-thread-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">X Viral Hooks</a>
        <a href="{{ route('tool.show', 'ai-content-humanizer') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">Bypass AI Detection</a>
        <a href="{{ route('tool.show', 'ai-content-humanizer') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">AI Content Humanizer Free</a>
        <a href="{{ route('tool.show', 'ai-seo-blog-writer') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">Programmatic SEO Writer</a>
        <a href="{{ route('tool.show', 'ai-seo-blog-writer') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">Long-form SEO Article Generator</a>
        <a href="{{ route('tool.show', 'viral-headline-analyzer') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">Viral Headline Analyzer</a>
        <a href="{{ route('tool.show', 'instagram-caption-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">AI Instagram Caption Generator</a>
        <a href="{{ route('tool.show', 'tiktok-reels-script-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">TikTok Reels Script Engine</a>
        <a href="{{ route('tool.show', 'content-repurposer') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">1-Click Content Repurposer</a>
        <a href="{{ route('tool.show', 'cold-email-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">B2B Cold Email Generator</a>
        <a href="{{ route('tool.show', 'ai-ad-copy-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">AI Ad Copy Generator for Meta & Google</a>
        <a href="{{ route('tool.show', 'hashtag-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">Viral Hashtag Finder</a>
        <a href="{{ route('tool.show', 'youtube-title-and-script-generator') }}" class="badge-pill" style="text-decoration: none; font-size: 12px; color: #cbd5e1;">YouTube Shorts Script Writer</a>
    </div>
</section>

@endsection

@section('scripts')
<script>
    let activeStudioTool = 'linkedin';

    function switchStudioTool(tool, btnElement) {
        activeStudioTool = tool;
        document.querySelectorAll('#studio-tabs .studio-tab-btn').forEach(btn => btn.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');

        const inputLabel = document.getElementById('studio-input-label');
        const topicInput = document.getElementById('studio-topic-input');
        const toneControls = document.getElementById('studio-tone-controls');
        const outputBox = document.getElementById('postryx-output');
        const hookResults = document.getElementById('hook-analysis-results');

        if (tool === 'analyze_hook') {
            inputLabel.textContent = 'Enter Headline or Opening Hook to Analyze:';
            topicInput.placeholder = 'e.g. 5 deadly mistakes every first-time founder makes in year one';
            toneControls.style.display = 'none';
        } else if (tool === 'humanize') {
            inputLabel.textContent = 'Paste AI-Generated Text to Humanize:';
            topicInput.placeholder = 'Paste text from ChatGPT, Claude, or Gemini...';
            toneControls.style.display = 'none';
        } else if (tool === 'repurpose') {
            inputLabel.textContent = 'Enter Core Idea or Note to Repurpose:';
            topicInput.placeholder = 'Paste article summary or topic to generate LinkedIn, Twitter, Reels, and Email...';
            toneControls.style.display = 'none';
        } else {
            inputLabel.textContent = 'Enter Your Topic or Core Insight:';
            topicInput.placeholder = 'e.g. 5 counter-intuitive lessons learned scaling a digital business...';
            toneControls.style.display = 'flex';
        }

        outputBox.style.display = 'block';
        hookResults.style.display = 'none';
    }

    function setStudioPrompt(text) {
        const input = document.getElementById('studio-topic-input');
        if (input) {
            input.value = text;
            input.focus();
        }
    }

    function executeStudioGeneration() {
        const topic = document.getElementById('studio-topic-input').value;
        const toneSelect = document.getElementById('studio-tone-select');
        const tone = toneSelect ? toneSelect.value : 'engaging';
        const outputBox = document.getElementById('postryx-output');
        const hookResults = document.getElementById('hook-analysis-results');

        if (activeStudioTool === 'analyze_hook') {
            outputBox.style.display = 'none';
            hookResults.style.display = 'block';
            Postryx.analyzeHook(topic, 'hook-analysis-results', 'postryx-generate-btn');
        } else if (activeStudioTool === 'humanize') {
            outputBox.style.display = 'block';
            hookResults.style.display = 'none';
            Postryx.humanize(topic, 'conversational', 'postryx-output', 'postryx-generate-btn');
        } else if (activeStudioTool === 'repurpose') {
            outputBox.style.display = 'none';
            hookResults.style.display = 'block';
            Postryx.repurpose(topic, 'hook-analysis-results', 'postryx-generate-btn');
        } else {
            outputBox.style.display = 'block';
            hookResults.style.display = 'none';
            Postryx.generate(activeStudioTool, topic, tone, 'postryx-output', 'postryx-generate-btn');
        }
    }
</script>
@endsection
