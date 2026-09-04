@extends('layouts.app')

@section('title', 'QR Studio — ' . $invitation->title . ' | CelebrateAI')

@section('content')
<div style="max-width: 1280px; margin: 0 auto; padding: 40px 20px 80px;">

    {{-- Breadcrumb --}}
    <div style="margin-bottom: 24px;">
        <a href="{{ route('invitations.dashboard.index') }}" style="color: #94A3B8; text-decoration: none; font-size: 13px;">&larr; Back to My Invitations</a>
    </div>

    {{-- Header --}}
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 36px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: #FFF; margin: 0 0 6px;">
                QR Code Studio &amp; Print Assets
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">
                Download high-resolution vector QR passes for print cards, welcome standees, and digital check-ins.
            </p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">
        
        {{-- Primary Invitation QR Card --}}
        <div class="glass-panel" style="padding: 32px; border-radius: 24px; text-align: center; border: 1px solid rgba(212, 175, 55, 0.4); display: flex; flex-direction: column; align-items: center;">
            <div style="font-size: 12px; letter-spacing: 0.15em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
                ✦ Public Invitation Pass ✦
            </div>
            <h2 style="font-size: 20px; font-weight: 800; color: #FFF; margin: 0 0 20px;">
                {{ $invitation->title }}
            </h2>

            <div id="qr-svg-container" style="background: #FFF; padding: 20px; border-radius: 24px; box-shadow: 0 15px 40px rgba(0,0,0,0.8); margin-bottom: 24px; border: 2px solid var(--gold-primary);">
                {!! $qrSvg !!}
            </div>

            <div style="font-size: 12px; color: #94A3B8; margin-bottom: 24px;">
                Target: <code>{{ $invitation->getPublicUrl() }}</code>
            </div>

            <div style="display: flex; gap: 10px; width: 100%;">
                <button type="button" onclick="downloadQrSvg()" class="btn-primary" style="flex: 1; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                    <span>Download Vector SVG ⬇️</span>
                </button>
            </div>
        </div>

        {{-- QR Uses & Standee Guides --}}
        <div class="glass-panel" style="padding: 32px; border-radius: 24px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: #FFF; margin: 0 0 16px;">
                    Where to Use Your QR Pass
                </h3>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <span style="font-size: 24px;">🪧</span>
                        <div>
                            <div style="font-size: 14px; font-weight: 700; color: #FFF;">Venue Welcome Standees</div>
                            <div style="font-size: 12px; color: #94A3B8; margin-top: 2px;">Print on acrylic or foam boards at the entrance for guests to access the event schedule and itinerary.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <span style="font-size: 24px;">💌</span>
                        <div>
                            <div style="font-size: 14px; font-weight: 700; color: #FFF;">Printed Wedding Box &amp; Cards</div>
                            <div style="font-size: 12px; color: #94A3B8; margin-top: 2px;">Include on physical sweets boxes so guests can view the animated music version on their phones.</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <span style="font-size: 24px;">📷</span>
                        <div>
                            <div style="font-size: 14px; font-weight: 700; color: #FFF;">Expedited Mobile Door Check-In</div>
                            <div style="font-size: 12px; color: #94A3B8; margin-top: 2px;">Venue coordinators can scan guest QR passes using the built-in Door Scanner.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 24px;">
                <a href="{{ route('invitations.dashboard.scanner', $invitation->id) }}" class="btn-secondary" style="display: block; text-align: center; padding: 12px; font-size: 13px; text-decoration: none; border-radius: 10px;">
                    📷 Open Camera Door Scanner
                </a>
            </div>
        </div>

    </div>

</div>

<script>
    function downloadQrSvg() {
        const svgElem = document.querySelector('#qr-svg-container svg');
        if(!svgElem) return;
        const svgData = new XMLSerializer().serializeToString(svgElem);
        const blob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = '{{ $invitation->slug }}-qr-pass.svg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
