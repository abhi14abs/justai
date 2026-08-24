@extends('layouts.app')

@section('title', 'Privacy Policy | Postryx AI')
@section('meta_description', 'Privacy policy outlining data security, GDPR compliance, and user protection on Postryx AI.')

@section('content')

<section style="padding: 70px 24px 80px; max-width: 860px; margin: 0 auto;">
    <h1 style="font-size: clamp(32px, 4vw, 44px); font-weight: 800; color: #fff; margin-bottom: 12px;">Privacy Policy</h1>
    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 30px;">Last updated: August 24, 2026</div>

    <div class="glass-panel" style="padding: 36px; line-height: 1.8; color: #cbd5e1; font-size: 15px;">
        <h2 style="font-size: 20px; color: #fff; margin: 24px 0 12px;">1. Information We Collect</h2>
        <p>Postryx AI (postryx.in) collects only the necessary information required to provide our AI generation services, such as email addresses for registered users, newsletter subscribers, and anonymous session identifiers for free credit tracking.</p>

        <h2 style="font-size: 20px; color: #fff; margin: 24px 0 12px;">2. How We Protect Your Content</h2>
        <p>Your inputs, brand voices, and private generated posts are strictly protected. We do not sell your personal data or your private generated content to third-party data brokers.</p>

        <h2 style="font-size: 20px; color: #fff; margin: 24px 0 12px;">3. Cookies &amp; Analytics</h2>
        <p>We use standard session cookies to remember user preferences (such as dark mode and selected currency) and measure anonymous traffic trends for performance optimization.</p>

        <h2 style="font-size: 20px; color: #fff; margin: 24px 0 12px;">4. GDPR &amp; CCPA Compliance</h2>
        <p>You have the right to request deletion of your account and all associated data at any time by emailing us at <strong style="color:#fff;">privacy@postryx.in</strong>.</p>
    </div>
</section>

@endsection
