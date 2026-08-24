@extends('layouts.app')

@section('title', 'Postryx AI — The #1 Viral Social & Programmatic SEO Growth Engine')
@section('meta_description', 'Postryx is the next-gen AI content SaaS. Generate viral LinkedIn posts, Twitter threads, Reels scripts, and long-form SEO articles that rank #1 on Google and bypass AI detectors.')

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
        'text' => 'Yes. Our AI Content Humanizer restructures syntax, eliminates robotic AI cliches, and injects natural human burstiness and perplexity to achieve 99.4% human authenticity scores.'
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
      'name' => 'What platforms does Postryx support?',
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text' => 'Postryx generates tailored content for LinkedIn, Twitter / X, Instagram, TikTok, YouTube Shorts, Google SEO blogs, Meta Ads, and B2B Cold Email sequences.'
      ]
    ]
  ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('content')

{{-- Hero Section --}}
<section style="padding: 70px 24px 50px; text-align: center; position: relative;">
    <div style="max-width: 1080px; margin: 0 auto;">
        
        {{-- Floating Badge --}}
        <div style="margin-bottom: 24px;">
            <span class="badge-pill" style="padding: 6px 16px; font-size: 14px;">
                <span style="color:#67e8f9;">⚡</span> Postryx AI 2.0 • The Autonomous Viral Growth Engine
            </span>
        </div>

        {{-- Main H1 --}}
        <h1 style="font-size: clamp(38px, 5.5vw, 68px); line-height: 1.1; margin-bottom: 24px; font-weight: 800;">
            Generate <span class="gradient-text">Viral Social Posts</span> &amp; <br/>
            <span class="gradient-text-cyan">Rank #1 on Google</span> with Autonomous AI
        </h1>

        {{-- Subtitle --}}
        <p style="font-size: clamp(17px, 2vw, 21px); color: var(--text-secondary); max-width: 820px; margin: 0 auto 36px; line-height: 1.6;">
            Turn 1 core idea into 10 multi-platform viral posts (<span style="color:#38bdf8;">LinkedIn</span>, <span style="color:#60a5fa;">Twitter/X</span>, <span style="color:#f472b6;">Instagram Reels</span>) and 2,000+ word programmatic SEO articles that bypass AI detectors with a <strong>99.4% human score</strong>.
        </p>

        {{-- Hero CTA Buttons --}}
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 16px; margin-bottom: 40px;">
            <a href="#studio-section" class="btn-primary" style="padding: 14px 32px; font-size: 16px; font-weight: 700;">
                <span>Launch Free Studio</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('pricing') }}" class="btn-secondary" style="padding: 14px 28px; font-size: 16px;">
                <span>View Pricing &amp; ROI</span>
            </a>
        </div>

        {{-- Hero Product Showcase Banner --}}
        <div style="max-width: 1000px; margin: 0 auto 48px; position: relative;">
            <div style="position: absolute; inset: -2px; background: linear-gradient(135deg, rgba(99,102,241,0.6), rgba(6,182,212,0.6), rgba(168,85,247,0.6)); border-radius: 20px; filter: blur(15px); opacity: 0.6; z-index: 0;"></div>
            <div class="glass-panel-glow" style="position: relative; z-index: 1; padding: 10px; border-radius: 18px; overflow: hidden; box-shadow: 0 25px 60px -15px rgba(0,0,0,0.9);">
                <img src="{{ asset('images/postryx-hero-banner.png') }}" alt="Postryx AI Autonomous Growth Dashboard" style="width: 100%; height: auto; border-radius: 12px; display: block; object-fit: cover;">
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

{{-- Interactive Hero Studio (Live Interactive Generation Playground) --}}
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
                    <button class="studio-tab-btn" onclick="switchStudioTool('instagram', this)">
                        <span>📸</span> Instagram Reel &amp; Caption
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('seo_blog', this)">
                        <span>📄</span> SEO Blog Article
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('analyze_hook', this)">
                        <span>⚡</span> Viral Hook Analyzer
                    </button>
                    <button class="studio-tab-btn" onclick="switchStudioTool('humanize', this)">
                        <span>✨</span> AI Humanizer
                    </button>
                </div>

                {{-- Live Credits Indicator --}}
                <div class="badge-pill-cyan">
                    <span>⚡ 5 Free Daily Generations</span>
                </div>
            </div>

            {{-- Studio Two-Column Grid --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 28px;">
                
                {{-- Input Column --}}
                <div style="display: flex; flex-direction: column; gap: 18px;">
                    
                    <div>
                        <label id="studio-input-label" style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                            Enter Your Topic or Core Insight:
                        </label>
                        <textarea id="studio-topic-input" class="postryx-textarea" style="min-height: 140px;" placeholder="e.g. 5 counter-intuitive lessons learned scaling a digital business to $50k/mo without spending on ads...">Why 90% of creators fail at audience retention (and how to fix it in 2026)</textarea>
                    </div>

                    {{-- Tone Selector & Controls --}}
                    <div id="studio-tone-controls" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <label style="font-size: 13px; color: var(--text-secondary);">Tone:</label>
                            <select id="studio-tone-select" class="postryx-input" style="padding: 8px 12px; font-size: 13px; width: auto;">
                                <option value="engaging">🔥 Thought Leader (Engaging)</option>
                                <option value="contrarian">💡 Contrarian (Bold &amp; Direct)</option>
                                <option value="storyteller">📖 Storyteller (Authentic)</option>
                                <option value="actionable">⚡ Step-by-Step (Actionable)</option>
                                <option value="witty">✨ Conversational &amp; Witty</option>
                            </select>
                        </div>

                        <div style="font-size: 12px; color: var(--text-muted);">
                            <span id="counter-words">12 words</span> • <span id="counter-chars">68 chars</span>
                        </div>
                    </div>

                    {{-- Generate Action Button --}}
                    <button id="postryx-generate-btn" onclick="executeStudioGeneration()" class="btn-primary" style="width: 100%; padding: 14px; font-size: 15px; font-weight: 700;">
                        <span>Generate Viral Copy 🚀</span>
                    </button>

                    {{-- Quick Template Prompts --}}
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 14px;">
                        <div style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;">
                            ✨ Quick Try Templates:
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                            <button onclick="setStudioPrompt('How to bypass AI detectors and create humanized SEO articles that rank on Google')" class="btn-secondary" style="padding: 4px 10px; font-size: 12px;">AI Humanizer</button>
                            <button onclick="setStudioPrompt('The 7 deadly mistakes first-time founders make in their first 90 days')" class="btn-secondary" style="padding: 4px 10px; font-size: 12px;">Founder Mistakes</button>
                            <button onclick="setStudioPrompt('How to repurpose 1 YouTube video into 10 multi-platform social posts in 5 minutes')" class="btn-secondary" style="padding: 4px 10px; font-size: 12px;">Repurposing</button>
                        </div>
                    </div>

                </div>

                {{-- Output Column --}}
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    
                    {{-- Output Header Actions --}}
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="badge-pill-emerald" style="font-size: 12px;">● Live Output</span>
                            <span id="counter-readtime" style="font-size: 12px; color: var(--text-muted);">1m read</span>
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <button onclick="Postryx.copy(document.getElementById('postryx-output').textContent, this)" class="btn-secondary" style="padding: 6px 14px; font-size: 13px;">
                                📋 Copy Text
                            </button>
                            <button onclick="Postryx.exportCard(document.getElementById('postryx-output').textContent)" class="btn-secondary" style="padding: 6px 14px; font-size: 13px; color:#38bdf8;">
                                🖼️ Export Card
                            </button>
                            <button onclick="Postryx.exportFile(document.getElementById('postryx-output').textContent, 'postryx-viral-post.md')" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">
                                ⬇ .MD
                            </button>
                        </div>
                    </div>

                    {{-- Live Output Display Box --}}
                    <div id="postryx-output" class="result-box">99% of creators are approaching audience growth completely backward.

Here is what the top 1% know (that most never realize):

---

✦ 1. Velocity Beats Perfection
Don't wait until everything is flawless. The market rewards those who ship, iterate, and adapt in real time.

✦ 2. Build High-Leverage Systems
If you are repeating the same manual task twice, you are leaving 80% of your growth on the table. Automate the baseline; master the edge.

✦ 3. Distribution > Creation
One great insight distributed across 5 channels beats 10 mediocre posts in a silo.

✦ 4. The 1.2-Second Hook Rule
Your first 2 lines determine 90% of your impressions. Open an immediate curiosity loop.

---

📌 The takeaway:
Stop overcomplicating content growth. Focus on execution, clear messaging, and relentless consistency.

What is your single biggest bottleneck right now? Drop a comment below 👇

#Growth #Productivity #AI #Entrepreneurship #Postryx</div>

                    {{-- Hook Analyzer Container (Swapped dynamically when Hook Analyzer tab is active) --}}
                    <div id="hook-analysis-results" style="display: none;"></div>

                </div>

            </div>

        </div>

    </div>
</section>

{{-- 12 Programmatic SEO Tools Showcase Grid --}}
<section style="padding: 60px 24px 80px; position: relative;">
    <div style="max-width: 1280px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 50px;">
            <span class="badge-pill-cyan" style="margin-bottom: 12px;">Full AI Tool Suite</span>
            <h2 style="font-size: clamp(30px, 4vw, 48px); margin-bottom: 16px;">
                12 Dedicated AI Engines Built for <span class="gradient-text">Massive Organic Traffic</span>
            </h2>
            <p style="color: var(--text-secondary); max-width: 700px; margin: 0 auto; font-size: 17px;">
                Each tool is engineered with specific platform algorithms, viral hook formulas, and SEO schema to maximize reach and conversion.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            @foreach($tools as $t)
            <div class="feature-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                    <div class="badge-pill" style="font-size: 11px;">{{ $t['category'] }}</div>
                    <span class="badge-pill-emerald" style="font-size: 11px;">Free Tool</span>
                </div>
                
                <h3 style="font-size: 20px; color: #ffffff; margin-bottom: 10px;">{{ $t['title'] }}</h3>
                <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    {{ $t['meta_description'] }}
                </p>

                <div style="border-top: 1px solid var(--border-subtle); padding-top: 16px; margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 12px; color: var(--text-muted);">{{ count($t['features']) }} Key Features</span>
                    <a href="{{ route('tool.show', $t['slug']) }}" class="btn-primary" style="padding: 7px 16px; font-size: 13px;">
                        Open Tool &rarr;
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- Omni-Channel 1-to-10 Repurposing Engine Demo --}}
<section style="padding: 60px 24px 80px; background: rgba(15, 23, 42, 0.4); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 48px;">
            <span class="badge-pill-amber" style="margin-bottom: 12px;">Omni-Channel Multiplier</span>
            <h2 style="font-size: clamp(28px, 3.5vw, 44px); margin-bottom: 16px;">
                The 1-to-10 Repurposing Machine: <span class="gradient-text-purple">1 Topic &rarr; 5 Platforms</span>
            </h2>
            <p style="color: var(--text-secondary); max-width: 720px; margin: 0 auto; font-size: 16px;">
                Never create content from scratch for each platform. Let Postryx transform your core insight into perfectly formatted posts for LinkedIn, Twitter, Instagram, Email, and Reels in under 60 seconds.
            </p>
        </div>

        <div class="glass-panel" style="padding: 32px;">
            
            <div style="display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
                <input type="text" id="repurpose-input" class="postryx-input" style="flex: 1; min-width: 280px;" value="How to scale organic search traffic using programmatic SEO and AI content hubs in 2026" placeholder="Enter any topic or blog link...">
                <button id="repurpose-btn" onclick="Postryx.repurpose(document.getElementById('repurpose-input').value)" class="btn-glow-cyan btn-primary" style="padding: 12px 24px; font-weight: 700;">
                    Repurpose Across 5 Platforms 🚀
                </button>
            </div>

            <div id="repurpose-results">
                <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                    <div style="font-size: 32px; margin-bottom: 12px;">🔄</div>
                    <div style="font-size: 15px; color: var(--text-secondary);">Click "Repurpose Across 5 Platforms" above to generate tailored multi-channel assets in real-time!</div>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- Interactive ROI & Time Savings Calculator --}}
<section style="padding: 70px 24px 80px;">
    <div style="max-width: 1100px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 48px;">
            <span class="badge-pill-emerald" style="margin-bottom: 12px;">Revenue &amp; Time Impact</span>
            <h2 style="font-size: clamp(28px, 3.5vw, 44px); margin-bottom: 16px;">
                Calculate Your <span class="gradient-text-cyan">Monthly Time &amp; Cost Savings</span>
            </h2>
            <p style="color: var(--text-secondary); max-width: 680px; margin: 0 auto; font-size: 16px;">
                See how much time and money Postryx AI saves your agency, startup, or creator business each month.
            </p>
        </div>

        <div class="glass-panel" style="padding: 36px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; align-items: center;">
                
                {{-- Sliders Column --}}
                <div style="display: flex; flex-direction: column; gap: 28px;">
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <label style="font-weight: 600; font-size: 14px;">Posts &amp; Articles Created / Month:</label>
                            <span id="roi-posts-count" style="font-weight: 700; color: #38bdf8;">30 posts / mo</span>
                        </div>
                        <input type="range" id="roi-posts-slider" class="roi-slider" min="5" max="200" value="30" oninput="Postryx.updateRoi()">
                    </div>

                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <label style="font-weight: 600; font-size: 14px;">Your Hourly Time / Agency Cost Rate:</label>
                            <span id="roi-rate-count" style="font-weight: 700; color: #a855f7;">₹2,500 / hr ($30)</span>
                        </div>
                        <input type="range" id="roi-rate-slider" class="roi-slider" min="500" max="10000" step="250" value="2500" oninput="Postryx.updateRoi()">
                    </div>

                    <div style="font-size: 13px; color: var(--text-muted); background: rgba(0,0,0,0.2); padding: 12px; border-radius: 8px;">
                        💡 <em>Based on industry average of 2.3 hours spent per high-quality post drafted, researched, and formatted manually.</em>
                    </div>
                </div>

                {{-- Computed Output Numbers Column --}}
                <div style="background: rgba(11, 17, 33, 0.9); border: 1px solid var(--border-active); border-radius: 16px; padding: 28px; text-align: center;">
                    <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Time Reclaimed Monthly</div>
                    <div id="roi-hours-saved" style="font-size: 48px; font-weight: 800; color: #38bdf8; line-height: 1.1; margin-bottom: 20px;">69 hrs</div>

                    <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Estimated Monthly Value Saved</div>
                    <div id="roi-money-saved" style="font-size: 42px; font-weight: 800; color: #10b981; line-height: 1.1; margin-bottom: 24px;">₹1,72,500</div>

                    <a href="{{ route('pricing') }}" class="btn-primary" style="width: 100%; padding: 12px;">
                        Claim Postryx Pro Plan &rarr;
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>

{{-- Feature Comparison Matrix --}}
<section style="padding: 60px 24px 80px; background: rgba(15, 23, 42, 0.3);">
    <div style="max-width: 1100px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 44px;">
            <h2 style="font-size: clamp(26px, 3vw, 40px); margin-bottom: 14px;">
                Why Top Creators Choose <span class="gradient-text">Postryx AI</span>
            </h2>
            <p style="color: var(--text-secondary); font-size: 16px;">
                See how Postryx compares to generic LLM chatbots and expensive legacy copywriting software.
            </p>
        </div>

        <div class="glass-panel" style="overflow-x: auto; padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-subtle); background: rgba(0,0,0,0.3);">
                        <th style="padding: 18px 24px; color: var(--text-secondary); font-weight: 600;">Feature / Capability</th>
                        <th style="padding: 18px 24px; color: #38bdf8; font-weight: 700; background: rgba(99,102,241,0.1);">Postryx AI</th>
                        <th style="padding: 18px 24px; color: var(--text-muted);">ChatGPT Plus</th>
                        <th style="padding: 18px 24px; color: var(--text-muted);">Jasper AI ($59/mo)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--border-subtle);">
                        <td style="padding: 16px 24px; font-weight: 600; color: #fff;">Viral Hook Velocity Scoring</td>
                        <td style="padding: 16px 24px; color: #10b981; font-weight: 700; background: rgba(99,102,241,0.05);">✓ Built-in (0-100 score)</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ No</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ No</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border-subtle);">
                        <td style="padding: 16px 24px; font-weight: 600; color: #fff;">AI Detection Bypass (99.4% Human)</td>
                        <td style="padding: 16px 24px; color: #10b981; font-weight: 700; background: rgba(99,102,241,0.05);">✓ Automated Humanizer</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ Flagged as 100% AI</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ Often Flagged</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border-subtle);">
                        <td style="padding: 16px 24px; font-weight: 600; color: #fff;">1-Click 5-Platform Repurposer</td>
                        <td style="padding: 16px 24px; color: #10b981; font-weight: 700; background: rgba(99,102,241,0.05);">✓ 1-Click Omni Engine</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ Requires manual prompts</td>
                        <td style="padding: 16px 24px; color: #f59e0b;">Limited</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border-subtle);">
                        <td style="padding: 16px 24px; font-weight: 600; color: #fff;">HTML5 Social Card Graphic Export</td>
                        <td style="padding: 16px 24px; color: #10b981; font-weight: 700; background: rgba(99,102,241,0.05);">✓ Built-in Canvas Exporter</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ No</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ No</td>
                    </tr>
                    <tr>
                        <td style="padding: 16px 24px; font-weight: 600; color: #fff;">Free Daily Tier Without Login</td>
                        <td style="padding: 16px 24px; color: #10b981; font-weight: 700; background: rgba(99,102,241,0.05);">✓ 5 Free Daily Credits</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ Account Required</td>
                        <td style="padding: 16px 24px; color: #f43f5e;">✕ Credit Card Required</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</section>

{{-- Pricing Section --}}
<section id="pricing-section" style="padding: 70px 24px 80px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 48px;">
            <span class="badge-pill" style="margin-bottom: 12px;">Simple, High-ROI Pricing</span>
            <h2 style="font-size: clamp(30px, 4vw, 48px); margin-bottom: 16px;">
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
<section style="padding: 60px 24px 80px; max-width: 900px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 44px;">
        <span class="badge-pill-cyan" style="margin-bottom: 12px;">Frequently Asked Questions</span>
        <h2 style="font-size: clamp(28px, 3.5vw, 42px); margin-bottom: 14px;">
            Got Questions? We Have Answers.
        </h2>
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
        const tone = document.getElementById('studio-tone-select').value;
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
        } else {
            outputBox.style.display = 'block';
            hookResults.style.display = 'none';
            Postryx.generate(activeStudioTool, topic, tone, 'postryx-output', 'postryx-generate-btn');
        }
    }
</script>
@endsection
