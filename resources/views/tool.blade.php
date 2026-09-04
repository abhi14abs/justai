@extends('layouts.app')

@section('title', $tool['meta_title'] . ' | Postryx AI')
@section('meta_description', $tool['meta_description'])
@section('meta_keywords', ($tool['meta_keywords'] ?? ($tool['title'] . ', ' . $tool['h1'] . ', postryx.in')))
@section('og_title', $tool['meta_title'])
@section('og_description', $tool['meta_description'])

@section('extra_schema')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'SoftwareApplication',
      'name' => $tool['title'],
      'applicationCategory' => 'BusinessApplication, ContentMarketingApplication',
      'operatingSystem' => 'Web, iOS, Android, macOS, Windows, Linux',
      'description' => $tool['meta_description'],
      'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'USD',
        'availability' => 'https://schema.org/InStock'
      ],
      'aggregateRating' => [
        '@type' => 'AggregateRating',
        'ratingValue' => '4.9',
        'reviewCount' => '680',
        'ratingCount' => '680',
        'bestRating' => '5',
        'worstRating' => '1'
      ]
    ],
    [
      '@type' => 'HowTo',
      'name' => 'How to use ' . $tool['title'] . ' in 4 Simple Steps',
      'description' => 'A step-by-step guide to generating viral, high-ranking content using ' . $tool['title'] . ' on Postryx AI.',
      'totalTime' => 'PT2M',
      'step' => array_map(function($step, $index) {
        return [
          '@type' => 'HowToStep',
          'position' => $index + 1,
          'name' => $step['title'],
          'text' => $step['desc']
        ];
      }, $tool['guide_steps'] ?? [], array_keys($tool['guide_steps'] ?? []))
    ],
    [
      '@type' => 'FAQPage',
      'mainEntity' => array_map(function($faq) {
        return [
          '@type' => 'Question',
          'name' => $faq['q'],
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $faq['a']
          ]
        ];
      }, $tool['faqs'] ?? [])
    ],
    [
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        [
          '@type' => 'ListItem',
          'position' => 1,
          'name' => 'Home',
          'item' => url('/')
        ],
        [
          '@type' => 'ListItem',
          'position' => 2,
          'name' => 'AI Tools',
          'item' => url('/#studio-section')
        ],
        [
          '@type' => 'ListItem',
          'position' => 3,
          'name' => $tool['title'],
          'item' => url()->current()
        ]
      ]
    ]
  ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('content')

{{-- Tool Hero Header --}}
<section style="padding: 60px 24px 30px; text-align: center; position: relative;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <div style="margin-bottom: 18px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <span class="badge-pill" style="padding: 6px 16px; font-size: 13px;">
                <span>✦</span> {{ $tool['badge'] }}
            </span>
            <span class="badge-pill-cyan" style="font-size: 12px;">
                {{ $tool['category'] }}
            </span>
        </div>

        <h1 style="font-size: clamp(32px, 4.5vw, 54px); line-height: 1.15; margin-bottom: 20px; font-weight: 800;">
            {{ $tool['h1'] }}
        </h1>

        <p style="font-size: 18px; color: var(--text-secondary); max-width: 800px; margin: 0 auto 24px; line-height: 1.6;">
            {{ $tool['meta_description'] }}
        </p>

        {{-- LSI Keyword Tags Cloud --}}
        @if(!empty($tool['lsi_keywords']))
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 30px;">
            @foreach($tool['lsi_keywords'] as $kw)
            <span class="badge-pill" style="font-size: 11px; padding: 4px 10px; background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08); color: #94a3b8;">
                #{{ $kw }}
            </span>
            @endforeach
        </div>
        @endif

    </div>
</section>

{{-- Interactive Tool Studio Component --}}
<section style="padding: 10px 24px 70px;">
    <div style="max-width: 1160px; margin: 0 auto;">
        
        <div class="glass-panel-glow" style="padding: 32px;">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px;">
                
                {{-- Input Area --}}
                <div style="display: flex; flex-direction: column; gap: 18px;">
                    
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #f8fafc; margin-bottom: 8px;">
                            {{ $tool['api_type'] === 'analyze_hook' ? 'Enter Headline or Hook to Score:' : ($tool['api_type'] === 'humanize' ? 'Paste AI-Generated Text to Humanize:' : 'Enter Topic, Concept or Instructions:') }}
                        </label>
                        <textarea id="tool-input" class="postryx-textarea" style="min-height: 160px;" placeholder="{{ $tool['placeholder'] }}">{{ $tool['default_prompt'] }}</textarea>
                    </div>

                    @if($tool['api_type'] !== 'analyze_hook' && $tool['api_type'] !== 'humanize')
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <label style="font-size: 13px; color: var(--text-secondary);">Tone &amp; Style:</label>
                            <select id="tool-tone" class="postryx-input" style="padding: 8px 12px; font-size: 13px; width: auto;">
                                <option value="engaging">🔥 Thought Leader &amp; Viral</option>
                                <option value="contrarian">💡 Contrarian &amp; Direct</option>
                                <option value="storyteller">📖 Personal Storyteller</option>
                                <option value="actionable">⚡ Step-by-Step Blueprint</option>
                                <option value="professional">💼 Professional &amp; Authoritative</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    <button id="tool-generate-btn" onclick="executeToolAction()" class="btn-primary" style="padding: 14px; font-size: 15px; font-weight: 700; width: 100%;">
                        <span>{{ $tool['api_type'] === 'analyze_hook' ? 'Score Viral Hook ⚡' : ($tool['api_type'] === 'humanize' ? 'Humanize Text (100% Pass) ✨' : ($tool['api_type'] === 'repurpose' ? 'Repurpose Across 5 Channels 🚀' : 'Generate ' . $tool['badge'] . ' 🚀')) }}</span>
                    </button>

                    {{-- Features List --}}
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 18px;">
                        <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">
                            ⚡ Algorithmic Capabilities:
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; font-size: 13px; color: var(--text-secondary);">
                            @foreach($tool['features'] as $f)
                            <li style="display: flex; gap: 8px; align-items: flex-start;">
                                <span style="color: #10b981; font-weight: bold; flex-shrink: 0;">✓</span>
                                <span>{{ $f }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

                {{-- Output Area --}}
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="badge-pill-emerald" style="font-size: 12px;">● Formatted Result</span>

                        <div style="display: flex; gap: 8px;">
                            <button onclick="Postryx.copy(document.getElementById('tool-output').textContent, this)" class="btn-secondary" style="padding: 6px 14px; font-size: 13px;">
                                📋 Copy
                            </button>
                            <button onclick="Postryx.exportCard(document.getElementById('tool-output').textContent)" class="btn-secondary" style="padding: 6px 14px; font-size: 13px; color:#38bdf8;">
                                🖼️ Social Card
                            </button>
                            <button onclick="Postryx.exportFile(document.getElementById('tool-output').textContent, '{{ $tool['slug'] }}-result.md')" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">
                                ⬇ .MD
                            </button>
                        </div>
                    </div>

                    {{-- Text Output Box --}}
                    <div id="tool-output" class="result-box" style="min-height: 380px;">Click the button on the left to generate formatted, viral-ready content tailored specifically for this platform...</div>

                    {{-- Hook Analyzer / Repurpose Container --}}
                    <div id="tool-hook-results" style="display: none;"></div>

                </div>

            </div>

        </div>

    </div>
</section>

{{-- Step-by-Step How To Guide --}}
<section style="padding: 60px 24px 70px; background: rgba(15, 23, 42, 0.3); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div style="max-width: 1140px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 44px;">
            <span class="badge-pill-cyan" style="margin-bottom: 12px;">Execution Framework</span>
            <h2 style="font-size: clamp(26px, 3.5vw, 40px); margin-bottom: 12px; font-weight: 800;">
                How to Use the <span class="gradient-text">{{ $tool['title'] }}</span>
            </h2>
            <p style="color: var(--text-secondary); font-size: 16px; max-width: 700px; margin: 0 auto;">
                Follow these 4 simple steps to produce high-performing content that drives impressions, clicks, and search visibility.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
            @foreach($tool['guide_steps'] as $idx => $step)
            <div class="glass-panel" style="padding: 26px; display: flex; flex-direction: column;">
                <div style="font-size: 32px; font-weight: 900; color: #6366f1; margin-bottom: 12px; opacity: 0.9;">0{{ $idx + 1 }}</div>
                <h3 style="font-size: 18px; color: #fff; margin-bottom: 8px; font-weight: 700;">{{ $step['title'] }}</h3>
                <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6; margin: 0;">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- In-Depth SEO Educational Guide Section --}}
@if(isset($tool['deep_dive']))
<section style="padding: 70px 24px 60px; max-width: 1000px; margin: 0 auto;">
    <div class="glass-panel" style="padding: 40px; border-left: 4px solid #6366f1;">
        
        <div style="margin-bottom: 24px;">
            <span class="badge-pill-emerald" style="font-size: 11px; margin-bottom: 12px;">Pillar Playbook &amp; Strategies</span>
            <h2 style="font-size: clamp(24px, 3vw, 36px); color: #fff; font-weight: 800; line-height: 1.25; margin-bottom: 12px;">
                {{ $tool['deep_dive']['title'] }}
            </h2>
            <p style="font-size: 16px; color: #cbd5e1; line-height: 1.7;">
                {{ $tool['deep_dive']['summary'] }}
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px; border-top: 1px solid var(--border-subtle); padding-top: 24px;">
            @foreach($tool['deep_dive']['sections'] as $sec)
            <div>
                <h3 style="font-size: 20px; color: #38bdf8; font-weight: 700; margin-bottom: 10px;">
                    {{ $sec['heading'] }}
                </h3>
                <p style="color: var(--text-secondary); font-size: 15px; line-height: 1.8; margin: 0;">
                    {{ $sec['content'] }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- Call to Action Card --}}
        <div style="margin-top: 36px; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.3); border-radius: 14px; padding: 24px; text-align: center;">
            <h4 style="color: #fff; font-size: 18px; margin-bottom: 8px;">Ready to Scale Your Organic Reach?</h4>
            <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 16px;">Generate unlimited viral social posts, SEO blogs, and undetectable copy with Postryx Pro.</p>
            <a href="{{ route('pricing') }}" class="btn-primary" style="padding: 10px 24px; font-size: 14px; font-weight: 700;">
                Upgrade to Pro (50% Off) &rarr;
            </a>
        </div>

    </div>
</section>
@endif

{{-- Tool-Specific FAQs --}}
<section style="padding: 50px 24px 80px; max-width: 900px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 40px;">
        <span class="badge-pill-cyan" style="margin-bottom: 10px;">Search Intent &amp; FAQ</span>
        <h2 style="font-size: clamp(26px, 3vw, 38px); margin-bottom: 12px; font-weight: 800;">
            Frequently Asked Questions
        </h2>
        <p style="color: var(--text-secondary); font-size: 15px;">
            Everything you need to know about {{ $tool['title'] }} and ranking with AI.
        </p>
    </div>

    @foreach($tool['faqs'] as $index => $faq)
    <div class="faq-item {{ $index === 0 ? 'active' : '' }}">
        <div class="faq-header" onclick="Postryx.toggleFaq(this)">
            <span>{{ $faq['q'] }}</span>
            <span style="color: #6366f1;">▼</span>
        </div>
        <div class="faq-body">
            {{ $faq['a'] }}
        </div>
    </div>
    @endforeach
</section>

{{-- Related Tools --}}
<section style="padding: 50px 24px 90px; max-width: 1200px; margin: 0 auto; border-top: 1px solid var(--border-subtle);">
    <div style="text-align: center; margin-bottom: 36px;">
        <span class="badge-pill" style="margin-bottom: 10px;">Internal SEO Network</span>
        <h3 style="font-size: 26px; color: #fff; font-weight: 800;">Explore More AI Growth &amp; Content Engines</h3>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
        @foreach($otherTools as $ot)
        <a href="{{ route('tool.show', $ot['slug']) }}" class="glass-panel" style="padding: 22px; text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
            <div>
                <div class="badge-pill" style="font-size: 11px; margin-bottom: 12px; align-self: flex-start;">{{ $ot['badge'] }}</div>
                <h4 style="font-size: 16px; color: #fff; margin-bottom: 8px; font-weight: 700;">{{ $ot['title'] }}</h4>
                <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; margin-bottom: 12px;">{{ Str::limit($ot['meta_description'], 95) }}</p>
            </div>
            <div style="color: #38bdf8; font-size: 13px; font-weight: 700; margin-top: auto; display: flex; align-items: center; gap: 4px;">
                <span>Try Free</span>
                <span>&rarr;</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

@endsection

@section('scripts')
<script>
    function executeToolAction() {
        const toolType = "{{ $tool['api_type'] }}";
        const topic = document.getElementById('tool-input').value;
        const toneEl = document.getElementById('tool-tone');
        const tone = toneEl ? toneEl.value : 'engaging';
        const outputBox = document.getElementById('tool-output');
        const hookResults = document.getElementById('tool-hook-results');

        if (toolType === 'analyze_hook') {
            outputBox.style.display = 'none';
            hookResults.style.display = 'block';
            Postryx.analyzeHook(topic, 'tool-hook-results', 'tool-generate-btn');
        } else if (toolType === 'humanize') {
            outputBox.style.display = 'block';
            hookResults.style.display = 'none';
            Postryx.humanize(topic, 'conversational', 'tool-output', 'tool-generate-btn');
        } else if (toolType === 'repurpose') {
            outputBox.style.display = 'none';
            hookResults.style.display = 'block';
            Postryx.repurpose(topic, 'tool-hook-results', 'tool-generate-btn');
        } else {
            outputBox.style.display = 'block';
            hookResults.style.display = 'none';
            Postryx.generate(toolType, topic, tone, 'tool-output', 'tool-generate-btn');
        }
    }
</script>
@endsection
