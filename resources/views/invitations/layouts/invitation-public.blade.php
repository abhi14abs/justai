<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $invitation->seo_title ?? $invitation->title }}</title>
    <meta name="description" content="{{ $invitation->seo_description ?? 'You are cordially invited to celebrate with us.' }}">
    
    {{-- OpenGraph Meta Tags for WhatsApp & Social Previews --}}
    <meta property="og:title" content="{{ $invitation->seo_title ?? $invitation->title }}">
    <meta property="og:description" content="{{ $invitation->seo_description ?? 'You are cordially invited to celebrate with us.' }}">
    <meta property="og:url" content="{{ $invitation->getPublicUrl() }}">
    <meta property="og:type" content="website">
    @if($invitation->cover_image)
        <meta property="og:image" content="{{ $invitation->cover_image }}">
    @endif

    {{-- Fonts & Theme Stylesheets --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/postryx-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invitations-market.css') }}">

    @php
        $secondaryHex = strtolower($invitation->secondary_color ?? '#0F172A');
        $isLight = false;
        if (str_starts_with($secondaryHex, '#')) {
            $rawHex = ltrim($secondaryHex, '#');
            if (strlen($rawHex) === 3) {
                $rawHex = $rawHex[0].$rawHex[0].$rawHex[1].$rawHex[1].$rawHex[2].$rawHex[2];
            }
            if (strlen($rawHex) === 6) {
                $r = hexdec(substr($rawHex, 0, 2));
                $g = hexdec(substr($rawHex, 2, 2));
                $b = hexdec(substr($rawHex, 4, 2));
                $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
                $isLight = $luminance > 0.60;
            }
        }
        $bgOpacity = $invitation->bg_opacity ?? 0.45;
    @endphp

    <style>
        @if($isLight)
        :root {
            --invite-theme: light;
            --invite-primary: {{ $invitation->primary_color ?? '#EA580C' }};
            --invite-secondary: {{ $invitation->secondary_color ?? '#FFF7ED' }};
            --invite-accent: {{ $invitation->accent_color ?? '#D97706' }};
            --gold-primary: {{ $invitation->primary_color ?? '#EA580C' }};
            --font-serif-lux: '{{ $invitation->font_family_heading ?? "Cinzel Decorative" }}', serif;
            --font-display-lux: '{{ $invitation->font_family_heading ?? "Cinzel Decorative" }}', serif;
            --invite-bg: {{ $invitation->secondary_color ?? '#FFF7ED' }};
            --invite-surface: #FFFFFF;
            --invite-card-bg: rgba(255, 255, 255, 0.92);
            --invite-card-border: rgba(217, 119, 6, 0.35);
            --invite-card-text: #1E293B;
            --invite-card-radius: 20px;
            --invite-heading: #431407;
            --invite-subheading: #7C2D12;
            --invite-text: #1E293B;
            --invite-text-muted: #64748B;
            --invite-pill-bg: #FEF3C7;
            --invite-pill-text: #92400E;
            --invite-input-bg: #FFFFFF;
            --invite-input-border: #E2E8F0;
            --invite-input-text: #0F172A;
            --envelope-bg: radial-gradient(circle at center, #FFFBEB 0%, #FEF3C7 100%);
            --envelope-title: #431407;
            --invite-bg-opacity: {{ $bgOpacity }};
        }

        body {
            background-color: var(--invite-bg);
            color: var(--invite-text);
            font-family: '{{ $invitation->font_family_body ?? "Outfit" }}', sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .invitation-canvas {
            background: transparent !important;
            box-shadow: 0 0 50px rgba(217, 119, 6, 0.15) !important;
            position: relative;
            z-index: 2;
        }
        @else
        :root {
            --invite-theme: dark;
            --invite-primary: {{ $invitation->primary_color ?? '#D4AF37' }};
            --invite-secondary: {{ $invitation->secondary_color ?? '#0F172A' }};
            --invite-accent: {{ $invitation->accent_color ?? '#F59E0B' }};
            --gold-primary: {{ $invitation->primary_color ?? '#D4AF37' }};
            --font-serif-lux: '{{ $invitation->font_family_heading ?? "Playfair Display" }}', serif;
            --font-display-lux: '{{ $invitation->font_family_heading ?? "Cinzel Decorative" }}', serif;
            --invite-bg: {{ $invitation->secondary_color ?? '#0B111E' }};
            --invite-surface: #0B111E;
            --invite-card-bg: rgba(15, 23, 42, 0.85);
            --invite-card-border: rgba(212, 175, 55, 0.3);
            --invite-card-text: #E2E8F0;
            --invite-card-radius: 20px;
            --invite-heading: #FFFFFF;
            --invite-subheading: #FDE68A;
            --invite-text: #E2E8F0;
            --invite-text-muted: #94A3B8;
            --invite-pill-bg: rgba(15, 23, 42, 0.9);
            --invite-pill-text: #FFFFFF;
            --invite-input-bg: rgba(0, 0, 0, 0.5);
            --invite-input-border: rgba(255, 255, 255, 0.2);
            --invite-input-text: #FFFFFF;
            --envelope-bg: radial-gradient(circle at center, #1E293B 0%, #030712 100%);
            --envelope-title: #FFFFFF;
            --invite-bg-opacity: {{ $bgOpacity }};
        }

        body {
            background-color: var(--invite-bg, #0F172A);
            color: var(--invite-text);
            font-family: '{{ $invitation->font_family_body ?? "Outfit" }}', sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
        }

        .invitation-canvas {
            background: transparent !important;
            position: relative;
            z-index: 2;
        }
        @endif

        /* Custom Background Image & Overlay */
        .invitation-canvas-bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            opacity: var(--invite-bg-opacity, {{ $bgOpacity }}) !important;
            transition: opacity 0.15s ease, background-image 0.3s ease;
        }

        .event-card, .glass-panel {
            background: var(--invite-card-bg, rgba(15, 23, 42, 0.85)) !important;
            border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.3)) !important;
            color: var(--invite-card-text, var(--invite-text, #E2E8F0));
            border-radius: var(--invite-card-radius, 20px);
        }

        {{ $invitation->custom_css ?? '' }}
    </style>
</head>
<body>

    {{-- 1. Optional Wax Seal Envelope Opening Curtain --}}
    @if(!request()->has('no_curtain'))
    <div class="envelope-overlay" id="envelope-overlay" style="background: var(--envelope-bg);">
        <div style="text-align: center; margin-bottom: 24px; padding: 0 20px;">
            <div style="font-size: 13px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--invite-primary, #D4AF37); font-weight: 700; margin-bottom: 8px;">
                ✦ {{ $isLight ? 'Auspicious Invitation' : 'Royal Invitation' }} ✦
            </div>
            <h2 style="font-family: var(--font-serif-lux); font-size: clamp(22px, 5vw, 30px); color: var(--envelope-title, #FFFFFF); margin: 0; font-weight: 700;">
                {{ $invitation->title }}
            </h2>
        </div>

        <button type="button" class="wax-seal-btn" onclick="openEnvelope()" title="Click to Open Invitation">
            <span style="font-size: 26px; line-height: 1;">{{ $isLight ? '🕉️' : '💌' }}</span>
            <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-top: 4px;">OPEN</span>
        </button>

        <p style="font-size: 12px; color: var(--invite-text-muted, #94A3B8); margin-top: 20px; letter-spacing: 0.05em;">
            Tap seal to unroll your personal invitation
        </p>
    </div>
    @endif

    {{-- Background Texture / Image Layer --}}
    @php
        $rawCover = $invitation->cover_image ?? '';
        $normalizedCover = '';
        if (!empty($rawCover)) {
            if (preg_match('/unsplash\.com\/photos\/(?:[\w-]+-)?([a-zA-Z0-9_-]+)/i', $rawCover, $m) && !str_contains($rawCover, 'images.unsplash.com')) {
                $normalizedCover = 'https://unsplash.com/photos/' . $m[1] . '/download?w=1600';
            } elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/i', $rawCover, $m)) {
                $normalizedCover = 'https://drive.google.com/uc?export=view&id=' . $m[1];
            } else {
                $normalizedCover = $rawCover;
            }
        }
    @endphp
    <div id="invitation-bg-layer" class="invitation-canvas-bg-layer" style="{{ !empty($normalizedCover) ? 'background-image: url(\'' . $normalizedCover . '\');' : '' }}"></div>

    {{-- 2. Ambient Particles Canvas --}}
    <canvas id="particles-canvas" class="particles-canvas" data-style="{{ $invitation->animation_style ?? 'sparkles_float' }}"></canvas>

    {{-- 3. Main Mobile-First Canvas --}}
    <main class="invitation-canvas">
        @yield('content')
    </main>

    {{-- 4. Background Audio Player --}}
    @include('invitations.sections.music')

    {{-- Scripts --}}
    <script src="{{ asset('js/invitations-public.js') }}?v={{ time() }}"></script>
    @stack('scripts')
</body>
</html>
