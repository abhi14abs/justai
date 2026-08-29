@extends('layouts.app')

@section('title', $tool['meta_title'] . ' | Postryx AI')
@section('meta_description', $tool['meta_description'])
@section('meta_keywords', ($tool['title'] ?? '') . ', ' . ($tool['h1'] ?? '') . ', AI viral content generator, ' . ($tool['badge'] ?? '') . ', ' . ($tool['category'] ?? '') . ', postryx.in')
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
      'applicationCategory' => 'BusinessApplication',
      'operatingSystem' => 'Web, iOS, Android, macOS, Windows',
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
      'description' => 'A step-by-step guide to generating viral content using ' . $tool['title'] . ' on Postryx AI.',
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
    <div style="max-width: 960px; margin: 0 auto;">
        
        <div style="margin-bottom: 20px;">
            <span class="badge-pill" style="padding: 6px 16px; font-size: 13px;">
                <span>✦</span> {{ $tool['badge'] }}
            </span>
        </div>

        <h1 style="font-size: clamp(32px, 4.5vw, 54px); line-height: 1.15; margin-bottom: 20px; font-weight: 800;">
            {{ $tool['h1'] }}
        </h1>

        <p style="font-size: 18px; color: var(--text-secondary); max-width: 760px; margin: 0 auto 30px; line-height: 1.6;">
            {{ $tool['meta_description'] }}
        </p>

    </div>
</section>

{{-- Interactive Tool Studio Component --}}
<section style="padding: 10px 24px 70px;">
    <div style="max-width: 1140px; margin: 0 auto;">
        
        <div class="glass-panel-glow" style="padding: 32px;">
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px;">
                
                {{-- Input Area --}}
                <div style="display: flex; flex-direction: column; gap: 18px;">
                    
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #f8fafc; margin-bottom: 8px;">
                            {{ $tool['api_type'] === 'analyze_hook' ? 'Enter Headline or Hook to Score:' : ($tool['api_type'] === 'humanize' ? 'Paste AI-Generated Text to Humanize:' : 'Enter Topic, Concept or Instructions:') }}
                        </label>
                        <textarea id="tool-input" class="postryx-textarea" style="min-height: 150px;" placeholder="{{ $tool['placeholder'] }}">{{ $tool['default_prompt'] }}</textarea>
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
                        <span>{{ $tool['api_type'] === 'analyze_hook' ? 'Score Viral Hook ⚡' : ($tool['api_type'] === 'humanize' ? 'Humanize Text (100% Pass) ✨' : 'Generate ' . $tool['badge'] . ' 🚀') }}</span>
                    </button>

                    {{-- Features List --}}
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-subtle); border-radius: 12px; padding: 16px;">
                        <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;">
                            ⚡ Built-in Capabilities:
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; font-size: 13px; color: var(--text-secondary);">
                            @foreach($tool['features'] as $f)
                            <li style="display: flex; gap: 8px;">
                                <span style="color: #10b981;">✓</span>
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
                                🖼️ Export Card
                            </button>
                            <button onclick="Postryx.exportFile(document.getElementById('tool-output').textContent, '{{ $tool['slug'] }}-result.md')" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">
                                ⬇ .MD
                            </button>
                        </div>
                    </div>

                    {{-- Text Output Box --}}
                    <div id="tool-output" class="result-box">Click the button on the left to generate formatted, viral-ready content tailored specifically for this platform...</div>

                    {{-- Hook Analyzer Container --}}
                    <div id="tool-hook-results" style="display: none;"></div>

                </div>

            </div>

        </div>

    </div>
</section>

{{-- Step-by-Step How To Guide --}}
<section style="padding: 50px 24px 70px; background: rgba(15, 23, 42, 0.3); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div style="max-width: 1100px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: clamp(26px, 3vw, 38px); margin-bottom: 12px;">
                How to Use the <span class="gradient-text">{{ $tool['title'] }}</span>
            </h2>
            <p style="color: var(--text-secondary); font-size: 16px;">
                Follow these 4 simple steps to produce high-performing content that drives impressions and clicks.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            @foreach($tool['guide_steps'] as $idx => $step)
            <div class="glass-panel" style="padding: 24px;">
                <div style="font-size: 32px; font-weight: 800; color: #6366f1; margin-bottom: 12px; opacity: 0.8;">0{{ $idx + 1 }}</div>
                <h3 style="font-size: 17px; color: #fff; margin-bottom: 8px;">{{ $step['title'] }}</h3>
                <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.6;">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- Tool-Specific FAQs --}}
<section style="padding: 60px 24px 80px; max-width: 860px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 40px;">
        <span class="badge-pill-cyan" style="margin-bottom: 10px;">FAQ</span>
        <h2 style="font-size: clamp(26px, 3vw, 38px); margin-bottom: 12px;">
            Frequently Asked Questions
        </h2>
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
<section style="padding: 40px 24px 80px; max-width: 1200px; margin: 0 auto; border-top: 1px solid var(--border-subtle);">
    <div style="text-align: center; margin-bottom: 36px;">
        <h3 style="font-size: 24px; color: #fff;">Explore More Viral AI Growth Engines</h3>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
        @foreach($otherTools as $ot)
        <a href="{{ route('tool.show', $ot['slug']) }}" class="glass-panel" style="padding: 20px; text-decoration: none; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div class="badge-pill" style="font-size: 11px; margin-bottom: 10px;">{{ $ot['badge'] }}</div>
                <h4 style="font-size: 16px; color: #fff; margin-bottom: 8px;">{{ $ot['title'] }}</h4>
                <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.5;">{{ Str::limit($ot['meta_description'], 90) }}</p>
            </div>
            <div style="color: #38bdf8; font-size: 13px; font-weight: 600; margin-top: 14px;">Try Free &rarr;</div>
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
