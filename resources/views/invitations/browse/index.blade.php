@extends('layouts.app')

@section('title', 'Digital Invitations Marketplace — Luxury Animated E-Invites | CelebrateAI')
@section('meta_description', 'Browse luxury animated digital invitations for weddings, birthdays, anniversaries, and corporate events with RSVP, QR passes, Google Maps, and background music.')

@section('content')
<div style="max-width: 1280px; margin: 0 auto; padding: 40px 20px 80px;">

    {{-- Hero Section --}}
    <div style="text-align: center; margin-bottom: 40px; position: relative;">
        <div class="badge-pill" style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; background: rgba(212, 175, 55, 0.15); border: 1px solid rgba(212, 175, 55, 0.4); color: #FDE68A;">
            <span>✨</span>
            <span style="font-size: 12px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">Next-Gen Digital Invitation Platform</span>
        </div>

        <h1 class="gold-gradient-text" style="font-family: var(--font-display); font-size: clamp(32px, 5vw, 54px); font-weight: 900; line-height: 1.15; margin: 0 0 16px; letter-spacing: -0.02em;">
            Celebrate Life’s Grandest Milestones
        </h1>

        <p style="color: var(--text-secondary); font-size: clamp(15px, 2vw, 18px); max-width: 680px; margin: 0 auto 28px; line-height: 1.6;">
            Create mobile-first, animated digital invitations with instant RSVP tracking, personalized guest QR passes, Google Maps, photo galleries, and background music.
        </p>

        {{-- AI Invitation Creator Box --}}
        <div class="glass-panel" style="max-width: 800px; margin: 0 auto 36px; padding: 20px; border-radius: 24px; background: linear-gradient(135deg, rgba(30, 27, 75, 0.8), rgba(15, 23, 42, 0.9)); border: 1px solid rgba(212, 175, 55, 0.4); box-shadow: 0 20px 50px rgba(0,0,0,0.6); text-align: left;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 18px;">🪄</span>
                    <strong style="color: #FFF; font-size: 15px;">AI Instant Invitation Assistant</strong>
                    <span style="font-size: 10px; background: rgba(212,175,55,0.2); color: #FDE68A; border: 1px solid rgba(212,175,55,0.4); padding: 2px 8px; border-radius: 999px; font-weight: 700; text-transform: uppercase;">Prompt to Card in 5s</span>
                </div>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" id="ai-user-prompt" placeholder="e.g. Royal Marathi wedding for Rahul & Priya in Mumbai on Dec 15 with Haldi, Sangeet, Maroon & Gold..." style="flex: 1; min-width: 280px; padding: 12px 18px; border-radius: 12px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.18); color: #FFF; font-size: 14px; outline: none;">
                <button type="button" onclick="runAiInvitationAssistant()" id="ai-generate-btn" class="btn-primary" style="padding: 12px 24px; border-radius: 12px; font-size: 14px; font-weight: 700; white-space: nowrap;">
                    <span>✨ Generate Draft</span>
                </button>
            </div>

            {{-- Quick Chips --}}
            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 14px; align-items: center;">
                <span style="font-size: 11px; color: #94A3B8; font-weight: 600;">Try Prompts:</span>
                <button type="button" onclick="fillPrompt('Grand Saffron Ganeshotsav for our home in Lalbaug Mumbai with daily evening Mahamangal aarti, 56 bhog modak prasad and dhol tasha')" style="background: rgba(234,88,12,0.2); border: 1px solid rgba(234,88,12,0.5); color: #FDBA74; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 999px; cursor: pointer;">
                    🕉️ Saffron Ganeshotsav
                </button>
                <button type="button" onclick="fillPrompt('Peshwai traditional Puneri Ganeshotsav with Dhol-Tasha pathak in Pune on 7 September with 300 guests, Haldi-Kunku and Modak feast')" style="background: rgba(192,38,211,0.2); border: 1px solid rgba(192,38,211,0.5); color: #F0ABFC; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 999px; cursor: pointer;">
                    🥁 Peshwai Dhol-Tasha
                </button>
                <button type="button" onclick="fillPrompt('Eco-friendly natural clay Ganesha sthapana in Bengaluru with green pot visarjan and organic modak feast')" style="background: rgba(21,128,61,0.2); border: 1px solid rgba(21,128,61,0.5); color: #86EFAC; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 999px; cursor: pointer;">
                    🌱 Eco Clay Bappa
                </button>
                <button type="button" onclick="fillPrompt('Royal Marathi Vivah for Rahul & Priya in Mumbai on Dec 15 with Haldi, Sangeet & Reception, Maroon and Gold colors, 300 guests')" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: #CBD5E1; font-size: 11px; padding: 4px 10px; border-radius: 999px; cursor: pointer;">
                    👑 Royal Wedding
                </button>
                <button type="button" onclick="fillPrompt('Space Galactic 1st Birthday party for Vivaan on Nov 10 in Bangalore with Cake cutting, magic show and balloon bash')" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: #CBD5E1; font-size: 11px; padding: 4px 10px; border-radius: 999px; cursor: pointer;">
                    🚀 1st Birthday
                </button>
            </div>
        </div>

        {{-- Search & Quick Filter Bar --}}
        <form action="{{ route('invitations.browse.index') }}" method="GET" style="max-width: 600px; margin: 0 auto; display: flex; gap: 10px; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); padding: 6px; border-radius: 999px; backdrop-filter: blur(20px); box-shadow: 0 20px 40px rgba(0,0,0,0.6);">
            <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Search royal wedding, 1st birthday, luxury gala..." style="flex: 1; background: none; border: none; padding: 12px 20px; color: #FFF; font-size: 14px; outline: none;">
            <button type="submit" class="btn-primary" style="padding: 10px 24px; border-radius: 999px; font-size: 14px; font-weight: 700;">
                <span>Search</span>
            </button>
        </form>
    </div>

    {{-- Category Pills Bar --}}
    <div style="display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 40px;">
        <a href="{{ route('invitations.browse.index') }}" class="badge-pill {{ empty($selectedCategory) ? 'active' : '' }}" style="padding: 10px 20px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 999px; {{ empty($selectedCategory) ? 'background: linear-gradient(135deg, #D4AF37, #996515); color: #FFF; border-color: rgba(255,255,255,0.4);' : 'background: rgba(15, 23, 42, 0.8); color: #94A3B8; border: 1px solid rgba(255,255,255,0.1);' }}">
            🌟 All Categories
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('invitations.browse.index', ['category' => $cat->slug]) }}" class="badge-pill {{ $selectedCategory === $cat->slug ? 'active' : '' }}" style="padding: 10px 20px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 999px; {{ $selectedCategory === $cat->slug ? 'background: linear-gradient(135deg, #D4AF37, #996515); color: #FFF; border-color: rgba(255,255,255,0.4);' : 'background: rgba(15, 23, 42, 0.8); color: #CBD5E1; border: 1px solid rgba(255,255,255,0.1);' }}">
            <span>{{ $cat->icon ?? '💌' }}</span>
            <span>{{ $cat->name }}</span>
        </a>
        @endforeach
    </div>


    {{-- Templates Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 32px; margin-bottom: 50px;">
        @forelse($templates as $template)
        <div class="glass-panel" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.1); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s ease; box-shadow: 0 15px 35px rgba(0,0,0,0.6);" onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='rgba(212, 175, 55, 0.6)';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='rgba(255, 255, 255, 0.1)';">
            
            {{-- Template Thumbnail & Badges --}}
            <div style="position: relative; height: 260px; overflow: hidden; background: #030712;">
                <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                
                {{-- Category Tag --}}
                <div style="position: absolute; top: 14px; left: 14px; background: rgba(3, 7, 18, 0.85); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; color: #FFF;">
                    {{ $template->category->name ?? 'Celebration' }}
                </div>

                {{-- Premium / Free Badge --}}
                <div style="position: absolute; top: 14px; right: 14px;">
                    @if($template->is_premium)
                        <span style="background: linear-gradient(135deg, #F59E0B, #D97706); color: #FFF; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.5);">👑 Premium</span>
                    @else
                        <span style="background: linear-gradient(135deg, #10B981, #059669); color: #FFF; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Free Template</span>
                    @endif
                </div>

                {{-- Interactive Demo Overlay Button --}}
                <div style="position: absolute; bottom: 14px; right: 14px;">
                    <a href="{{ route('invitations.browse.preview', $template->slug) }}" class="btn-secondary" style="font-size: 12px; padding: 6px 14px; border-radius: 8px; backdrop-filter: blur(10px); background: rgba(15, 23, 42, 0.9); text-decoration: none;">
                        👁️ Live Demo
                    </a>
                </div>
            </div>

            {{-- Body Details --}}
            <div style="padding: 24px; display: flex; flex-direction: column; flex: 1;">
                <h3 style="font-size: 18px; font-weight: 800; color: #FFF; margin: 0 0 8px; line-height: 1.35;">
                    {{ $template->name }}
                </h3>

                <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.6; margin: 0 0 20px; flex: 1;">
                    {{ Str::limit($template->description, 110) }}
                </p>

                {{-- Feature Tags --}}
                @if(is_array($template->tags))
                <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 20px;">
                    @foreach(array_slice($template->tags, 0, 3) as $tag)
                    <span style="font-size: 10px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; padding: 3px 8px; border-radius: 6px; background: rgba(255,255,255,0.06); color: #94A3B8;">
                        #{{ $tag }}
                    </span>
                    @endforeach
                </div>
                @endif

                {{-- Pricing & CTA Bar --}}
                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 18px;">
                    <div>
                        <div style="font-size: 11px; color: #94A3B8; text-transform: uppercase; font-weight: 600;">Starting at</div>
                        <div style="font-size: 20px; font-weight: 900; color: var(--gold-primary);">
                            {{ $template->base_price_inr > 0 ? '₹' . number_format($template->base_price_inr, 0) : 'Free' }}
                        </div>
                    </div>

                    <a href="{{ route('invitations.builder.create', $template->slug) }}" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 12px;">
                        <span>Customize ⚡</span>
                    </a>
                </div>

            </div>

        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px;">
            <div style="font-size: 48px; margin-bottom: 16px;">💌</div>
            <h3 style="font-size: 20px; color: #FFF; margin-bottom: 8px;">No templates found</h3>
            <p style="color: #94A3B8; font-size: 14px; margin-bottom: 24px;">Try searching for different keywords or browse all categories.</p>
            <a href="{{ route('invitations.browse.index') }}" class="btn-secondary" style="padding: 10px 20px;">View All Templates</a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($templates->hasPages())
    <div style="display: flex; justify-content: center; margin-top: 40px;">
        {{ $templates->links('invitations.partials.pagination') }}
    </div>
    @endif

</div>

{{-- AI Blueprint Preview & Auto-Provision Modal --}}
<div id="ai-draft-modal" style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); display: none; align-items: center; justify-content: center; z-index: 999999; padding: 20px;">
    <div class="glass-panel" style="width: 100%; max-width: 680px; max-height: 90vh; overflow-y: auto; padding: 28px; border-radius: 24px; background: #0B111E; border: 1px solid rgba(212,175,55,0.4); box-shadow: 0 25px 60px rgba(0,0,0,0.8); position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 22px;">🪄</span>
                <h3 style="font-size: 20px; font-weight: 800; color: #FFF; margin: 0;">AI Generated Invitation Blueprint</h3>
            </div>
            <button type="button" onclick="closeAiModal()" style="background: none; border: none; color: #94A3B8; font-size: 24px; cursor: pointer; padding: 4px 8px;">&times;</button>
        </div>

        <div id="ai-modal-loading" style="text-align: center; padding: 40px 0;">
            <div style="font-size: 40px; margin-bottom: 16px;">⏳</div>
            <h4 style="color: #FFF; font-size: 16px; margin: 0 0 6px;">Crafting Your Custom Invitation...</h4>
            <p style="color: #94A3B8; font-size: 13px;">Analyzing culture, creating itinerary, matching colors &amp; RSVP questions...</p>
        </div>

        <div id="ai-modal-content" style="display: none;">
            {{-- Title & Matched Template --}}
            <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                <div>
                    <span id="ai-blueprint-culture" style="font-size: 11px; font-weight: 800; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.05em;"></span>
                    <h4 id="ai-blueprint-title" style="font-size: 18px; font-weight: 800; color: #FFF; margin: 4px 0 0;"></h4>
                </div>
                <div id="ai-blueprint-template-tag" style="background: rgba(212,175,55,0.15); border: 1px solid rgba(212,175,55,0.3); color: #FDE68A; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700;"></div>
            </div>

            {{-- Palette & Details Grid --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px;">
                <div style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.06); padding: 14px; border-radius: 12px;">
                    <div style="font-size: 11px; color: #94A3B8; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Color &amp; Theme Palette</div>
                    <div id="ai-blueprint-palette" style="display: flex; gap: 8px; align-items: center;"></div>
                </div>
                <div style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.06); padding: 14px; border-radius: 12px;">
                    <div style="font-size: 11px; color: #94A3B8; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Target City &amp; Date</div>
                    <div id="ai-blueprint-location" style="font-size: 13px; font-weight: 700; color: #FFF;"></div>
                </div>
            </div>

            {{-- Generated Itinerary --}}
            <div style="margin-bottom: 20px;">
                <div style="font-size: 12px; color: #94A3B8; font-weight: 700; text-transform: uppercase; margin-bottom: 10px;">Generated Multi-Event Itinerary</div>
                <div id="ai-blueprint-events" style="display: flex; flex-direction: column; gap: 8px;"></div>
            </div>

            {{-- Suggested Wording --}}
            <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 14px; margin-bottom: 24px;">
                <div style="font-size: 11px; color: #94A3B8; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Welcome &amp; Invocation Copy</div>
                <p id="ai-blueprint-intro" style="font-size: 13px; color: #CBD5E1; margin: 0; line-height: 1.5; font-style: italic;"></p>
            </div>

            {{-- CTA Action Buttons --}}
            <div style="display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap;">
                <button type="button" onclick="closeAiModal()" class="btn-secondary" style="padding: 10px 20px; font-size: 13px; border-radius: 10px;">
                    Cancel
                </button>
                <button type="button" onclick="provisionAiInvitation()" id="ai-provision-btn" class="btn-primary" style="padding: 10px 24px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                    <span>⚡ Create &amp; Open in Builder</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAiPrompt = '';

function fillPrompt(text) {
    const input = document.getElementById('ai-user-prompt');
    if (input) {
        input.value = text;
    }
    runAiInvitationAssistant();
}

function closeAiModal() {
    const modal = document.getElementById('ai-draft-modal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function runAiInvitationAssistant() {
    const input = document.getElementById('ai-user-prompt');
    const prompt = input ? input.value.trim() : '';
    if (!prompt) {
        alert('Please enter your event details or choose a prompt chip.');
        return;
    }
    currentAiPrompt = prompt;

    const modal = document.getElementById('ai-draft-modal');
    const loading = document.getElementById('ai-modal-loading');
    const content = document.getElementById('ai-modal-content');

    if (modal) modal.style.display = 'flex';
    if (loading) loading.style.display = 'block';
    if (content) content.style.display = 'none';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    fetch('{{ route("api.invitations.ai.parse", [], false) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ prompt: prompt })
    })
    .then(r => {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
    })
    .then(data => {
        if (loading) loading.style.display = 'none';
        if (content) content.style.display = 'block';

        document.getElementById('ai-blueprint-culture').innerText = (data.culture || 'Indian') + ' • ' + data.event_type;
        document.getElementById('ai-blueprint-title').innerText = data.title;
        document.getElementById('ai-blueprint-template-tag').innerText = '🎨 ' + (data.template ? data.template.name : 'Royal Theme');
        document.getElementById('ai-blueprint-location').innerText = '📍 ' + data.city + ' | 📅 ' + data.event_date;
        document.getElementById('ai-blueprint-intro').innerText = '"' + data.intro_text + '"';

        // Palette Swatches
        const palDiv = document.getElementById('ai-blueprint-palette');
        if (palDiv && data.palette) {
            palDiv.innerHTML = `
                <div style="width: 24px; height: 24px; border-radius: 50%; background: ${data.palette.primary}; border: 2px solid #FFF;" title="Primary"></div>
                <div style="width: 24px; height: 24px; border-radius: 50%; background: ${data.palette.secondary}; border: 1px solid rgba(255,255,255,0.4);" title="Secondary"></div>
                <div style="width: 24px; height: 24px; border-radius: 50%; background: ${data.palette.accent}; border: 1px solid rgba(255,255,255,0.4);" title="Accent"></div>
                <span style="font-size: 12px; color: #FFF; font-weight: 700; margin-left: 4px;">${data.palette.font_heading || 'Luxury'}</span>
            `;
        }

        // Itinerary Events
        const evDiv = document.getElementById('ai-blueprint-events');
        if (evDiv) {
            evDiv.innerHTML = '';
            if (data.events && data.events.length > 0) {
                data.events.forEach(ev => {
                    evDiv.innerHTML += `
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); padding: 10px 14px; border-radius: 10px; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <strong style="color: #FFF; font-size: 13px;">${ev.icon || '✨'} ${ev.title}</strong>
                                <div style="font-size: 11px; color: #94A3B8; margin-top: 2px;">📍 ${ev.venue} • 🕒 ${ev.time}</div>
                            </div>
                            <span style="font-size: 11px; color: #D4AF37; font-weight: 600;">${ev.dress_code || ''}</span>
                        </div>
                    `;
                });
            }
        }
    })
    .catch(err => {
        console.error('AI parsing error:', err);
        alert('Failed to generate draft. Please try again.');
        if (modal) modal.style.display = 'none';
    });
}

function provisionAiInvitation() {
    const btn = document.getElementById('ai-provision-btn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span>⏳ Provisioning card...</span>';
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    fetch('{{ route("api.invitations.ai.create", [], false) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ prompt: currentAiPrompt })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            alert(data.message || 'Please sign in or try again.');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<span>⚡ Create & Open in Builder</span>';
            }
        }
    })
    .catch(err => {
        console.error('Provisioning error:', err);
        alert('Could not complete request. Please make sure you are logged in.');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<span>⚡ Create & Open in Builder</span>';
        }
    });
}
</script>
@endsection


