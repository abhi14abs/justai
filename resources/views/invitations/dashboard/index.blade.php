@extends('layouts.app')

@section('title', 'My Digital Invitations — Member Dashboard | CelebrateAI')

@section('content')
<div style="max-width: 1280px; margin: 0 auto; padding: 40px 20px 80px;">

    {{-- Header --}}
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 36px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 800; color: #FFF; margin: 0 0 6px;">
                My Digital Invitations
            </h1>
            <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">
                Manage your active invitations, guest lists, RSVP responses, and QR door passes.
            </p>
        </div>

        <a href="{{ route('invitations.browse.index') }}" class="btn-primary" style="padding: 10px 22px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 12px;">
            <span>+ Create New Invitation ✨</span>
        </a>
    </div>

    {{-- Invitations List --}}
    @if(count($invitations) > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 28px;">
        @foreach($invitations as $inv)
        <div class="glass-panel" style="padding: 0; overflow: hidden; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); display: flex; flex-direction: column;">
            
            {{-- Cover & Status --}}
            <div style="position: relative; height: 160px; background: #0F172A; overflow: hidden;">
                @if($inv->cover_image)
                    <img src="{{ $inv->cover_image }}" alt="{{ $inv->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                @endif
                <div style="position: absolute; top: 12px; right: 12px;">
                    @if($inv->isPublished())
                        <span class="badge-pill" style="background: rgba(16, 185, 129, 0.9); color: #FFF; font-size: 11px; font-weight: 700;">● Live &amp; Published</span>
                    @else
                        <span class="badge-pill" style="background: rgba(245, 158, 11, 0.9); color: #FFF; font-size: 11px; font-weight: 700;">● Draft Mode</span>
                    @endif
                </div>
            </div>

            {{-- Body Details --}}
            <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 17px; font-weight: 800; color: #FFF; margin: 0 0 6px;">
                    {{ $inv->title }}
                </h3>

                <div style="font-size: 12px; color: var(--gold-primary); margin-bottom: 16px; font-weight: 600;">
                    📅 {{ $inv->event_date ? $inv->event_date->format('l, M d, Y') : 'Date TBA' }}
                </div>

                {{-- Stats Grid --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 20px; background: rgba(0,0,0,0.3); padding: 12px; border-radius: 12px;">
                    <div>
                        <div style="font-size: 11px; color: #94A3B8;">RSVPs Received</div>
                        <div style="font-size: 16px; font-weight: 800; color: #FFF;">{{ $inv->form_responses_count }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #94A3B8;">Guests Listed</div>
                        <div style="font-size: 16px; font-weight: 800; color: #38BDF8;">{{ $inv->guests_count }}</div>
                    </div>
                </div>

                {{-- Action Links --}}
                <div style="display: flex; flex-direction: column; gap: 8px; margin-top: auto;">
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('invitations.builder.edit', $inv->id) }}" class="btn-primary" style="flex: 1; padding: 8px 12px; font-size: 12px; text-align: center; text-decoration: none; border-radius: 8px;">
                            ✏️ Edit Canvas
                        </a>
                        <a href="{{ route('invitations.public.show', $inv->slug) }}" target="_blank" class="btn-secondary" style="padding: 8px 12px; font-size: 12px; text-decoration: none; border-radius: 8px;">
                            👁️ View
                        </a>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 6px;">
                        <a href="{{ route('invitations.dashboard.guests', $inv->id) }}" class="btn-secondary" style="padding: 6px 8px; font-size: 11px; text-align: center; text-decoration: none; border-radius: 6px;">
                            👥 Guests
                        </a>
                        <a href="{{ route('invitations.dashboard.analytics', $inv->id) }}" class="btn-secondary" style="padding: 6px 8px; font-size: 11px; text-align: center; text-decoration: none; border-radius: 6px;">
                            📊 Analytics
                        </a>
                        <a href="{{ route('invitations.dashboard.qr', $inv->id) }}" class="btn-secondary" style="padding: 6px 8px; font-size: 11px; text-align: center; text-decoration: none; border-radius: 6px;">
                            📱 QR Pass
                        </a>
                    </div>
                </div>

            </div>

        </div>
        @endforeach
    </div>
    @else
    <div class="glass-panel" style="text-align: center; padding: 80px 20px; border-radius: 24px;">
        <div style="font-size: 56px; margin-bottom: 20px;">💌</div>
        <h2 style="font-size: 22px; color: #FFF; margin-bottom: 8px; font-weight: 800;">No Digital Invitations Yet</h2>
        <p style="color: var(--text-secondary); font-size: 14px; max-width: 480px; margin: 0 auto 28px;">
            Choose from dozens of royal wedding, birthday party, or corporate gala templates and build your animated invitation in minutes.
        </p>
        <a href="{{ route('invitations.browse.index') }}" class="btn-primary" style="padding: 12px 28px; font-size: 14px; font-weight: 700; text-decoration: none; border-radius: 12px;">
            <span>Browse Invitation Templates &rarr;</span>
        </a>
    </div>
    @endif

</div>
@endsection
