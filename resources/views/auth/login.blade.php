@extends('layouts.app')

@section('title', 'Log In to Postryx AI — Access Your Growth Studio')
@section('meta_description', 'Log in to your Postryx AI account to access viral post generation history, custom brand voices, and team subscriptions.')

@section('content')

<section style="padding: 70px 24px 80px; max-width: 460px; margin: 0 auto;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <span class="badge-pill-cyan" style="margin-bottom: 10px;">⚡ Member Access</span>
        <h1 style="font-size: 32px; font-weight: 800; color: #fff; margin-top: 6px;">Welcome Back</h1>
        <p style="color: var(--text-secondary); font-size: 14px; margin-top: 4px;">Log in to access your Postryx AI studio &amp; tools.</p>
    </div>

    <div class="glass-panel-glow" style="padding: 34px;">
        
        @if (isset($errors) && $errors->any())
        <div style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.4); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; color: #fca5a5;">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" style="display: flex; flex-direction: column; gap: 18px;">
            @csrf

            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Email Address:</label>
                <input type="email" name="email" class="postryx-input" placeholder="name@company.com" value="{{ old('email') }}" required autofocus>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Password:</label>
                <input type="password" name="password" class="postryx-input" placeholder="••••••••" required>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
                <label style="display: flex; align-items: center; gap: 6px; color: var(--text-secondary); cursor: pointer;">
                    <input type="checkbox" name="remember" style="accent-color: #6366f1;">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn-primary" style="padding: 13px; font-size: 15px; font-weight: 700; width: 100%; margin-top: 4px;">
                Log In &rarr;
            </button>
        </form>

        <div style="border-top: 1px solid var(--border-subtle); margin-top: 24px; padding-top: 20px; text-align: center; font-size: 14px; color: var(--text-secondary);">
            Don't have an account? <a href="{{ route('register') }}" style="color: #38bdf8; font-weight: 600; text-decoration: none;">Sign Up for Free &rarr;</a>
        </div>

    </div>

</section>

@endsection
