<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Preview — {{ $template->name }} | CelebrateAI</title>
    
    <link rel="stylesheet" href="{{ asset('css/postryx-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invitations-market.css') }}">
</head>
<body style="background: #030712; color: #FFF; margin: 0; padding: 0; overflow: hidden;">

    {{-- Top Bar Controller --}}
    <header style="height: 64px; background: rgba(11, 17, 30, 0.95); border-bottom: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; position: sticky; top: 0; z-index: 100;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('invitations.browse.index') }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px; text-decoration: none;">
                &larr; Back to Catalog
            </a>
            <div>
                <h1 style="font-size: 15px; font-weight: 800; color: #FFF; margin: 0;">{{ $template->name }}</h1>
                <span style="font-size: 11px; color: var(--gold-primary); font-weight: 600;">{{ $template->category->name ?? 'Celebration' }}</span>
            </div>
        </div>

        {{-- Device Frame Switcher Buttons --}}
        <div style="display: flex; align-items: center; gap: 6px; background: rgba(0,0,0,0.4); padding: 4px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08);">
            <button type="button" class="btn-secondary device-switch-btn active" onclick="setPreviewDevice('mobile', this)" style="padding: 6px 12px; font-size: 12px; border-radius: 6px;">
                📱 Mobile
            </button>
            <button type="button" class="btn-secondary device-switch-btn" onclick="setPreviewDevice('tablet', this)" style="padding: 6px 12px; font-size: 12px; border-radius: 6px;">
                💻 Tablet
            </button>
            <button type="button" class="btn-secondary device-switch-btn" onclick="setPreviewDevice('desktop', this)" style="padding: 6px 12px; font-size: 12px; border-radius: 6px;">
                🖥️ Desktop
            </button>
        </div>

        {{-- CTA Button --}}
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="text-align: right;">
                <div style="font-size: 10px; color: #94A3B8; text-transform: uppercase;">Price</div>
                <div style="font-size: 16px; font-weight: 900; color: var(--gold-primary);">
                    {{ $template->base_price_inr > 0 ? '₹' . number_format($template->base_price_inr, 0) : 'Free' }}
                </div>
            </div>
            <a href="{{ route('invitations.builder.create', $template->slug) }}" class="btn-primary" style="padding: 8px 18px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 10px;">
                <span>Use This Template ⚡</span>
            </a>
        </div>
    </header>

    {{-- Main Preview Canvas Stage --}}
    <main class="builder-preview-stage" style="height: calc(100vh - 64px);">
        <div class="preview-device-frame mobile" id="preview-device-frame">
            <iframe src="{{ route('invitations.public.show', $sampleInvitation ? $sampleInvitation->slug : 'shree-ganeshotsav-2026') }}?no_curtain=1" class="preview-iframe" id="preview-iframe"></iframe>
        </div>
    </main>

    <script src="{{ asset('js/invitations-builder.js') }}"></script>
</body>
</html>
