<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Analytics 4 (GA4) Tracking --}}
    @php
        $gaId = config('services.google_analytics.id', 'G-POSTRYX2026');
    @endphp
    @if(!empty($gaId))
    <!-- Google tag (gtag.js) - Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $gaId }}', {
        'send_page_view': true,
        'cookie_flags': 'SameSite=None;Secure'
      });
      window.trackGAEvent = function(eventName, eventParams) {
        if (typeof window.gtag === 'function') {
          window.gtag('event', eventName, eventParams || {});
        }
      };
    </script>
    @else
    <script>
      window.trackGAEvent = function(eventName, eventParams) {
        console.log('[GA Event]', eventName, eventParams);
      };
    </script>
    @endif

    {{-- Core Dynamic SEO Meta Tags --}}
    <title>@yield('title', 'Postryx AI — The #1 Viral Social & Programmatic SEO Growth Engine')</title>
    <meta name="description" content="@yield('meta_description', 'Postryx is the all-in-one AI viral content & SEO growth platform. Create high-engagement LinkedIn posts, Twitter threads, Reels scripts, and long-form SEO articles that rank on Google.')">
    <meta name="keywords" content="@yield('meta_keywords', 'AI content generator, viral LinkedIn post generator, twitter thread maker, SEO blog writer, AI humanizer, bypass AI detection, viral hook analyzer, Instagram caption generator AI, TikTok script generator, programmatic SEO generator, social media growth SaaS, postryx.in')">
    <meta name="author" content="Postryx AI Growth Team">
    <meta name="publisher" content="Postryx AI">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="alternate" hreflang="en" href="@yield('canonical', url()->current())">
    <link rel="alternate" hreflang="x-default" href="@yield('canonical', url()->current())">

    {{-- Browser & Mobile OS Meta --}}
    <meta name="theme-color" content="#030712">
    <meta name="msapplication-TileColor" content="#030712">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Postryx AI">
    <meta name="application-name" content="Postryx AI">

    {{-- OpenGraph & Social Sharing --}}
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'Postryx AI — The Autonomous Viral Content & SEO Engine')">
    <meta property="og:description" content="@yield('og_description', 'Generate viral social posts, bypass AI detectors, analyze hooks, and rank #1 on Google with Postryx AI.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:site_name" content="Postryx AI">
    <meta property="og:image" content="@yield('og_image', url('/images/postryx-og-banner.png'))">
    <meta property="og:image:secure_url" content="@yield('og_image', url('/images/postryx-og-banner.png'))">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Postryx AI Autonomous Viral Growth Platform">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@postryx">
    <meta name="twitter:creator" content="@postryx">
    <meta name="twitter:title" content="@yield('og_title', 'Postryx AI — Viral Social & SEO Engine')">
    <meta name="twitter:description" content="@yield('og_description', 'Generate viral social posts and rank #1 on Google with Postryx AI.')">
    <meta name="twitter:image" content="@yield('og_image', url('/images/postryx-og-banner.png'))">
    <meta name="twitter:image:alt" content="Postryx AI Viral Copy & SEO Platform">

    {{-- Favicon SVG & Touch Icons --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236366f1'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E">
    <link rel="apple-touch-icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236366f1'%3E%3Cpath d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E">

    {{-- Core Web Vitals Performance Preconnects --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Master Theme CSS --}}
    <link rel="stylesheet" href="{{ asset('css/postryx-theme.css') }}">

    {{-- Global Schema.org JSON-LD Structured Data --}}
    <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@graph' => [
        [
          '@type' => 'Organization',
          '@id' => 'https://postryx.in/#organization',
          'name' => 'Postryx AI',
          'url' => 'https://postryx.in',
          'logo' => [
            '@type' => 'ImageObject',
            'url' => 'https://postryx.in/images/logo.png',
            'width' => 512,
            'height' => 512
          ],
          'sameAs' => [
            'https://twitter.com/postryx',
            'https://linkedin.com/company/postryx',
            'https://github.com/postryx'
          ],
          'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer support',
            'email' => 'hello@postryx.in',
            'url' => 'https://postryx.in'
          ]
        ],
        [
          '@type' => 'WebSite',
          '@id' => 'https://postryx.in/#website',
          'url' => 'https://postryx.in',
          'name' => 'Postryx AI',
          'description' => 'Autonomous Viral Content & Programmatic SEO Growth Engine',
          'publisher' => [
            '@id' => 'https://postryx.in/#organization'
          ],
          'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
              '@type' => 'EntryPoint',
              'urlTemplate' => 'https://postryx.in/tools?q={search_term_string}'
            ],
            'query-input' => 'required name=search_term_string'
          ]
        ],
        [
          '@type' => 'SoftwareApplication',
          'name' => 'Postryx AI',
          'operatingSystem' => 'Web, iOS, Android, macOS, Windows, Linux',
          'applicationCategory' => 'BusinessApplication, ContentMarketingApplication, DesignApplication',
          'description' => 'Autonomous AI platform for viral LinkedIn posts, Twitter threads, Reels scripts, AI humanization, and programmatic SEO articles.',
          'offers' => [
            '@type' => 'Offer',
            'price' => '0',
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock'
          ],
          'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => '4.9',
            'reviewCount' => '1420',
            'ratingCount' => '1420',
            'bestRating' => '5',
            'worstRating' => '1'
          ]
        ]
      ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>

    @yield('extra_schema')
</head>
<body>
    {{-- Ambient Neon Glows --}}
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>
    <div class="ambient-glow-3"></div>

    {{-- Announcement Bar --}}
    <div style="background: linear-gradient(90deg, #6366f1, #8b5cf6, #06b6d4); padding: 8px 16px; text-align: center; font-size: 13px; font-weight: 600; color: #ffffff; letter-spacing: 0.02em; position: relative; z-index: 60;">
        🔥 <span>LAUNCH SPECIAL: Use code <strong style="background:rgba(0,0,0,0.3); padding:2px 8px; border-radius:4px; font-family:monospace;">LAUNCH50</strong> for 50% OFF Lifetime Pro Access!</span>
        <a href="{{ route('pricing') }}" style="color: #ffffff; text-decoration: underline; margin-left: 8px; font-weight: 700;">Claim Deal &rarr;</a>
    </div>

    {{-- Navigation Bar --}}
    <header class="postryx-nav">
        <div style="max-width: 1280px; margin: 0 auto; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0;">
                <img src="{{ asset('images/logo.png') }}" alt="Postryx AI Logo" style="width: 38px; height: 38px; border-radius: 10px; object-fit: cover; box-shadow: 0 0 20px rgba(99, 102, 241, 0.6); border: 1px solid rgba(99, 102, 241, 0.4);">
                <div style="display: flex; flex-direction: column;">
                    <span style="font-family: var(--font-display); font-size: 20px; font-weight: 900; color: #ffffff; letter-spacing: -0.03em;">POSTRYX<span style="color: #38bdf8;">.IN</span></span>
                    <span style="font-size: 9px; color: #94a3b8; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 700; margin-top: -3px;">Viral AI Engine</span>
                </div>
            </a>

            {{-- Desktop Nav Links --}}
            <nav class="nav-desktop" style="display: flex; align-items: center; gap: 8px;">
                <div style="position: relative;" class="nav-dropdown-wrapper">
                    <button class="nav-link" style="display: flex; align-items: center; gap: 4px; background: none; border: none; cursor: pointer;">
                        AI Tools
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    {{-- Dropdown Menu --}}
                    <div class="glass-panel" style="position: absolute; top: 100%; left: 0; width: 340px; padding: 12px; display: none; flex-direction: column; gap: 4px; z-index: 100; margin-top: 8px; box-shadow: 0 20px 40px rgba(0,0,0,0.7);" id="nav-tools-menu">
                        <a href="{{ route('tool.show', 'linkedin-post-generator') }}" class="nav-link" style="display: flex; align-items: center; gap: 10px; padding: 10px;">
                            <span style="color: #60a5fa;">✦</span>
                            <div>
                                <div style="font-weight: 600; color: #fff; font-size: 14px;">LinkedIn Viral Post & Carousel</div>
                                <div style="font-size: 12px; color: #94a3b8;">Thought leadership & formatted hooks</div>
                            </div>
                        </a>
                        <a href="{{ route('tool.show', 'viral-tweet-thread-generator') }}" class="nav-link" style="display: flex; align-items: center; gap: 10px; padding: 10px;">
                            <span style="color: #38bdf8;">✦</span>
                            <div>
                                <div style="font-weight: 600; color: #fff; font-size: 14px;">Twitter / X Thread Maker</div>
                                <div style="font-size: 12px; color: #94a3b8;">Viral thread unroller & hooks</div>
                            </div>
                        </a>
                        <a href="{{ route('tool.show', 'ai-seo-blog-writer') }}" class="nav-link" style="display: flex; align-items: center; gap: 10px; padding: 10px;">
                            <span style="color: #34d399;">✦</span>
                            <div>
                                <div style="font-weight: 600; color: #fff; font-size: 14px;">Programmatic SEO Blog Writer</div>
                                <div style="font-size: 12px; color: #94a3b8;">2,000+ word Google ranking articles</div>
                            </div>
                        </a>
                        <a href="{{ route('tool.show', 'ai-content-humanizer') }}" class="nav-link" style="display: flex; align-items: center; gap: 10px; padding: 10px;">
                            <span style="color: #fbbf24;">✦</span>
                            <div>
                                <div style="font-weight: 600; color: #fff; font-size: 14px;">AI Content Humanizer</div>
                                <div style="font-size: 12px; color: #94a3b8;">Bypass GPTZero & Turnitin</div>
                            </div>
                        </a>
                        <a href="{{ route('tool.show', 'viral-headline-analyzer') }}" class="nav-link" style="display: flex; align-items: center; gap: 10px; padding: 10px;">
                            <span style="color: #ec4899;">✦</span>
                            <div>
                                <div style="font-weight: 600; color: #fff; font-size: 14px;">Viral Headline & Hook Scorecard</div>
                                <div style="font-size: 12px; color: #94a3b8;">Real-time CTR & emotional scoring</div>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('invitations.browse.index') }}" class="nav-link {{ request()->routeIs('invitations.*') ? 'active' : '' }}" style="color: #FDE68A; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                    <span>💌 Digital Invites</span>
                    <span style="font-size: 9px; padding: 2px 6px; border-radius: 4px; background: rgba(212,175,55,0.3); color: #FDE68A; font-weight: 800;">NEW</span>
                </a>
                <a href="{{ route('pricing') }}" class="nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}">Pricing & ROI</a>
                <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">SEO Guides</a>
                <a href="{{ route('affiliate') }}" class="nav-link {{ request()->routeIs('affiliate') ? 'active' : '' }}">Affiliates (30%)</a>
            </nav>

            {{-- Desktop Actions & Auth Navigation --}}
            <div class="nav-actions-desktop" style="display: flex; align-items: center; gap: 10px;">
                @if(Auth::check())
                    <a href="{{ route('invitations.dashboard.index') }}" class="nav-link" style="color: #FDE68A; font-weight: 600;">
                        💌 My Invites
                    </a>
                    <a href="{{ route('dashboard') }}" class="nav-link" style="color: #38bdf8; font-weight: 600;">
                        Dashboard
                    </a>
                    <a href="{{ route('affiliate.dashboard') }}" class="nav-link" style="color: #a855f7; font-weight: 600;">
                        Partner Hub (30%)
                    </a>
                    @if(Auth::user() && Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color: #fbbf24; font-weight: 700;">
                        👑 Admin
                    </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-secondary" style="padding: 7px 12px; font-size: 12px;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link" style="font-size: 14px; font-weight: 600;">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="btn-secondary" style="padding: 8px 16px; font-size: 13px; font-weight: 600;">
                        Sign Up Free
                    </a>
                @endif
                <a href="{{ route('home') }}#studio-section" class="btn-primary" style="padding: 8px 16px; font-size: 13px; font-weight: 700;">
                    <span>Launch Studio ⚡</span>
                </a>
            </div>

            {{-- Mobile Menu Trigger Button --}}
            <button id="mobile-menu-btn" class="mobile-menu-toggle" aria-label="Toggle Menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
        </div>
    </header>

    {{-- Mobile Overlay Backdrop --}}
    <div id="mobile-drawer-overlay" class="mobile-drawer-overlay"></div>

    {{-- Mobile Sliding Drawer Menu --}}
    <div id="mobile-drawer" class="mobile-drawer">
        <div class="mobile-drawer-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ asset('images/logo.png') }}" alt="Postryx AI Logo" style="width: 32px; height: 32px; border-radius: 8px; object-fit: cover;">
                <span style="font-family: var(--font-display); font-size: 18px; font-weight: 900; color: #ffffff;">POSTRYX<span style="color: #38bdf8;">.IN</span></span>
            </div>
            <button id="mobile-menu-close" class="mobile-drawer-close" aria-label="Close Menu">&times;</button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
            {{-- Mobile AI Tools Accordion --}}
            <div class="mobile-tools-accordion">
                <div class="mobile-tools-header" onclick="toggleMobileTools(this)">
                    <span>⚡ AI Tools Suite</span>
                    <span id="mobile-tools-icon">▼</span>
                </div>
                <div class="mobile-tools-content" id="mobile-tools-list">
                    <a href="{{ route('tool.show', 'linkedin-post-generator') }}" class="mobile-tools-sublink">
                        <span style="color:#60a5fa;">✦</span> LinkedIn Viral Post
                    </a>
                    <a href="{{ route('tool.show', 'viral-tweet-thread-generator') }}" class="mobile-tools-sublink">
                        <span style="color:#38bdf8;">✦</span> Twitter / X Thread Maker
                    </a>
                    <a href="{{ route('tool.show', 'ai-seo-blog-writer') }}" class="mobile-tools-sublink">
                        <span style="color:#34d399;">✦</span> Programmatic SEO Writer
                    </a>
                    <a href="{{ route('tool.show', 'ai-content-humanizer') }}" class="mobile-tools-sublink">
                        <span style="color:#fbbf24;">✦</span> AI Content Humanizer
                    </a>
                    <a href="{{ route('tool.show', 'viral-headline-analyzer') }}" class="mobile-tools-sublink">
                        <span style="color:#ec4899;">✦</span> Headline &amp; Hook Scorecard
                    </a>
                    <a href="{{ route('tool.show', 'content-repurposer') }}" class="mobile-tools-sublink">
                        <span style="color:#a855f7;">✦</span> 1-Click Repurposer
                    </a>
                </div>
            </div>

            <a href="{{ route('invitations.browse.index') }}" class="mobile-nav-link {{ request()->routeIs('invitations.*') ? 'active' : '' }}" style="color: #FDE68A; font-weight: 700;">
                💌 Digital Invites <span class="badge-pill" style="font-size: 9px; padding: 1px 5px; background: rgba(212,175,55,0.3); color: #FDE68A;">NEW</span>
            </a>
            <a href="{{ route('pricing') }}" class="mobile-nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}">
                💰 Pricing &amp; ROI
            </a>
            <a href="{{ route('blog.index') }}" class="mobile-nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                📚 SEO Guides
            </a>
            <a href="{{ route('affiliate') }}" class="mobile-nav-link {{ request()->routeIs('affiliate') ? 'active' : '' }}">
                🤝 Affiliates (Earn 30%)
            </a>

            <div style="border-top: 1px solid var(--border-subtle); margin: 16px 0 12px;"></div>

            @if(Auth::check())
                <a href="{{ route('dashboard') }}" class="mobile-nav-link" style="color: #38bdf8;">
                    📊 Member Dashboard
                </a>
                <a href="{{ route('affiliate.dashboard') }}" class="mobile-nav-link" style="color: #a855f7;">
                    🤝 Partner Hub (30%)
                </a>
                @if(Auth::user() && Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link" style="color: #fbbf24;">
                    👑 Admin Console
                </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 8px;">
                    @csrf
                    <button type="submit" class="btn-secondary" style="width: 100%; padding: 10px; font-size: 13px;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-secondary" style="width: 100%; text-align: center; justify-content: center; margin-bottom: 8px; padding: 11px;">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="btn-primary" style="width: 100%; text-align: center; justify-content: center; margin-bottom: 8px; padding: 11px;">
                    Sign Up Free
                </a>
            @endif

            <a href="{{ route('home') }}#studio-section" class="btn-glow-cyan btn-primary" style="width: 100%; margin-top: auto; padding: 12px; font-size: 14px; font-weight: 700; text-align: center; justify-content: center;">
                Launch Studio ⚡
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Master Footer --}}
    <footer style="background: rgba(6, 9, 14, 0.95); border-top: 1px solid var(--border-subtle); padding: 80px 24px 40px; margin-top: 100px; position: relative; z-index: 10;">
        <div style="max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 40px; margin-bottom: 60px;">
            {{-- Brand Column --}}
            <div style="grid-column: span 1.5;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Postryx AI Logo" style="width: 36px; height: 36px; border-radius: 8px; object-fit: cover; box-shadow: 0 0 15px rgba(99, 102, 241, 0.5); border: 1px solid rgba(99, 102, 241, 0.4);">
                    <span style="font-family: var(--font-display); font-size: 20px; font-weight: 800; color: #ffffff;">POSTRYX<span style="color: #38bdf8;">.IN</span></span>
                </div>
                <p style="color: var(--text-secondary); font-size: 14px; line-height: 1.7; margin-bottom: 20px;">
                    The autonomous viral content creation and programmatic SEO growth engine. Generate high-retention posts, bypass AI detectors, and dominate search rankings effortlessly.
                </p>
                <div style="display: flex; gap: 10px;">
                    <div class="badge-pill-emerald">✓ 99.4% Human Authenticity</div>
                    <div class="badge-pill">⚡ Live on postryx.in</div>
                </div>
            </div>

            {{-- 12 Tools Column --}}
            <div>
                <h4 style="color: #ffffff; font-size: 15px; margin-bottom: 18px; text-transform: uppercase; letter-spacing: 0.05em;">AI Creation Tools</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; font-size: 14px;">
                    <li><a href="{{ route('tool.show', 'linkedin-post-generator') }}" style="color: var(--text-secondary); text-decoration: none;">LinkedIn Post Generator</a></li>
                    <li><a href="{{ route('tool.show', 'viral-tweet-thread-generator') }}" style="color: var(--text-secondary); text-decoration: none;">Twitter / X Thread Maker</a></li>
                    <li><a href="{{ route('tool.show', 'instagram-caption-generator') }}" style="color: var(--text-secondary); text-decoration: none;">Instagram Caption & Reels</a></li>
                    <li><a href="{{ route('tool.show', 'youtube-title-and-script-generator') }}" style="color: var(--text-secondary); text-decoration: none;">YouTube Title & Script Writer</a></li>
                    <li><a href="{{ route('tool.show', 'ai-seo-blog-writer') }}" style="color: var(--text-secondary); text-decoration: none;">Programmatic SEO Writer</a></li>
                    <li><a href="{{ route('tool.show', 'ai-content-humanizer') }}" style="color: var(--text-secondary); text-decoration: none;">AI Content Humanizer</a></li>
                </ul>
            </div>

            {{-- Growth Tools Column --}}
            <div>
                <h4 style="color: #ffffff; font-size: 15px; margin-bottom: 18px; text-transform: uppercase; letter-spacing: 0.05em;">Marketing & CRO</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; font-size: 14px;">
                    <li><a href="{{ route('tool.show', 'viral-headline-analyzer') }}" style="color: var(--text-secondary); text-decoration: none;">Viral Headline Analyzer</a></li>
                    <li><a href="{{ route('tool.show', 'ai-ad-copy-generator') }}" style="color: var(--text-secondary); text-decoration: none;">High-ROI Ad Copy Generator</a></li>
                    <li><a href="{{ route('tool.show', 'cold-email-generator') }}" style="color: var(--text-secondary); text-decoration: none;">B2B Cold Email Sequences</a></li>
                    <li><a href="{{ route('tool.show', 'tiktok-reels-script-generator') }}" style="color: var(--text-secondary); text-decoration: none;">TikTok 60s Script Engine</a></li>
                    <li><a href="{{ route('tool.show', 'content-repurposer') }}" style="color: var(--text-secondary); text-decoration: none;">1-Click Content Repurposer</a></li>
                    <li><a href="{{ route('tool.show', 'hashtag-generator') }}" style="color: var(--text-secondary); text-decoration: none;">Viral Hashtags Finder</a></li>
                </ul>
            </div>

            {{-- Lead Magnet Newsletter --}}
            <div>
                <h4 style="color: #ffffff; font-size: 15px; margin-bottom: 18px; text-transform: uppercase; letter-spacing: 0.05em;">Get Free Viral Swipe File</h4>
                <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 14px;">
                    Join 15,000+ creators getting our weekly viral hook formulas and SEO ranking teardowns.
                </p>
                <form onsubmit="event.preventDefault(); Postryx.subscribeNewsletter(document.getElementById('footer-email').value);" style="display: flex; flex-direction: column; gap: 10px;">
                    <input type="email" id="footer-email" placeholder="Enter your work email..." class="postryx-input" style="padding: 10px 14px; font-size: 13px;" required>
                    <button type="submit" id="newsletter-btn" class="btn-glow-cyan btn-primary" style="padding: 10px 16px; font-size: 13px;">
                        Claim Free Swipe File 🎁
                    </button>
                    <div id="newsletter-msg" style="font-size: 12px;"></div>
                </form>
            </div>
        </div>

        {{-- Bottom Copyright & Legal --}}
        <div style="max-width: 1280px; margin: 0 auto; border-top: 1px solid var(--border-subtle); padding-top: 28px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; font-size: 13px; color: var(--text-muted);">
            <div>
                &copy; {{ date('Y') }} <strong>Postryx AI</strong> (postryx.in). All rights reserved. Built for top organic search dominance.
            </div>
            <div style="display: flex; gap: 20px;">
                <a href="{{ route('pricing') }}" style="color: var(--text-secondary); text-decoration: none;">Pricing</a>
                <a href="{{ route('blog.index') }}" style="color: var(--text-secondary); text-decoration: none;">Blog</a>
                <a href="{{ route('affiliate') }}" style="color: var(--text-secondary); text-decoration: none;">Affiliate Program</a>
                <a href="{{ route('terms') }}" style="color: var(--text-secondary); text-decoration: none;">Terms of Service</a>
                <a href="{{ route('privacy') }}" style="color: var(--text-secondary); text-decoration: none;">Privacy Policy</a>
                <a href="{{ route('sitemap') }}" style="color: var(--text-secondary); text-decoration: none;">Sitemap.xml</a>
            </div>
        </div>
    </footer>

    {{-- Master Engine JS --}}
    <script src="{{ asset('js/postryx-engine.js') }}"></script>

    {{-- Interactive Dropdown & UI Scripts --}}
    <script>
        function toggleMobileTools(btn) {
            const content = document.getElementById('mobile-tools-list');
            const icon = document.getElementById('mobile-tools-icon');
            if (content) {
                const isOpen = content.classList.contains('open');
                content.classList.toggle('open', !isOpen);
                if (icon) icon.textContent = isOpen ? '▼' : '▲';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const dropdownBtn = document.querySelector('.nav-dropdown-wrapper button');
            const dropdownMenu = document.getElementById('nav-tools-menu');

            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isVisible = dropdownMenu.style.display === 'flex';
                    dropdownMenu.style.display = isVisible ? 'none' : 'flex';
                });

                document.addEventListener('click', () => {
                    dropdownMenu.style.display = 'none';
                });
            }

            // Mobile Menu Open / Close
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileClose = document.getElementById('mobile-menu-close');
            const mobileDrawer = document.getElementById('mobile-drawer');
            const mobileOverlay = document.getElementById('mobile-drawer-overlay');

            function openMobileMenu() {
                if (mobileDrawer) mobileDrawer.classList.add('open');
                if (mobileOverlay) mobileOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                if (mobileDrawer) mobileDrawer.classList.remove('open');
                if (mobileOverlay) mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (mobileBtn) mobileBtn.addEventListener('click', openMobileMenu);
            if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);
        });
    </script>
    @yield('scripts')
</body>
</html>
