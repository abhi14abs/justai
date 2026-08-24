@extends('layouts.app')

@section('title', 'Sign Up for Postryx AI — Free 5 Daily Credits')
@section('meta_description', 'Create your free Postryx AI account. Get 5 free daily generation credits for viral LinkedIn posts, Twitter threads, Reels scripts, and SEO blogs.')

@section('content')

<section style="padding: 60px 24px 80px; max-width: 480px; margin: 0 auto;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <span class="badge-pill-cyan" style="margin-bottom: 10px;">⚡ Instant Free Access</span>
        <h1 style="font-size: 32px; font-weight: 800; color: #fff; margin-top: 6px;">Create Your Account</h1>
        <p style="color: var(--text-secondary); font-size: 14px; margin-top: 4px;">Get 5 free credits every day + full access to all 12 viral AI tools.</p>
    </div>

    <div class="glass-panel-glow" style="padding: 34px;">
        
        @if (isset($errors) && $errors->any())
        <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.4); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #fca5a5;">
            {{ $errors->first() }}
        </div>
        @endif

        @if(!empty($refCode))
        <div style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.4); border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; font-size: 12px; color: #c7d2fe;">
            🎁 Partner Referral: Joining via <strong>{{ $refCode }}</strong> (30% partner tracking active)
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
            @csrf

            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Full Name:</label>
                <input type="text" name="name" class="postryx-input" placeholder="e.g. Alex Johnson" value="{{ old('name') }}" required autofocus>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Email Address:</label>
                <input type="email" name="email" class="postryx-input" placeholder="name@company.com" value="{{ old('email') }}" required>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Password (Min. 6 characters):</label>
                <input type="password" name="password" class="postryx-input" placeholder="••••••••" required>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Confirm Password:</label>
                <input type="password" name="password_confirmation" class="postryx-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-primary" style="padding: 13px; font-size: 15px; font-weight: 700; width: 100%; margin-top: 6px;">
                Create Free Account 🚀
            </button>
        </form>

        <div style="border-top: 1px solid var(--border-subtle); margin-top: 24px; padding-top: 20px; text-align: center; font-size: 14px; color: var(--text-secondary);">
            Already have an account? <a href="{{ route('login') }}" style="color: #38bdf8; font-weight: 600; text-decoration: none;">Log In &rarr;</a>
        </div>

    </div>

</section>

@endsection
