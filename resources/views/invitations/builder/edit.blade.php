<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Builder — {{ $invitation->title }} | CelebrateAI</title>

    <link rel="stylesheet" href="{{ asset('css/postryx-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invitations-market.css') }}">
    
    <style>
        .section-toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            cursor: pointer;
            margin: 0;
            user-select: none;
            flex-shrink: 0;
        }
        .section-toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }
        .section-toggle-switch .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #334155;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .section-toggle-switch .toggle-slider::before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background-color: #FFFFFF;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }
        .section-toggle-switch input:checked + .toggle-slider {
            background-color: #10B981;
            border-color: #059669;
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);
        }
        .section-toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(20px);
        }
    </style>
</head>
<body style="background: #06090F; color: #FFF; margin: 0; padding: 0; overflow: hidden;">

    <input type="hidden" id="builder-invitation-id" value="{{ $invitation->id }}">
    <input type="hidden" id="builder-template-id" value="{{ $invitation->template_id }}">
    <script>window.BUILDER_INVITATION_ID = {{ $invitation->id }};</script>

    {{-- Top Builder Navbar --}}
    <header style="height: 64px; background: rgba(11, 17, 30, 0.98); border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; z-index: 100;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <a href="{{ route('invitations.dashboard.index') }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px; text-decoration: none;">
                &larr; Dashboard
            </a>
            <div>
                <input type="text" id="builder-title-input" value="{{ $invitation->title }}" oninput="syncLiveText('hero-title', this.value)" style="background: none; border: 1px dashed rgba(255,255,255,0.2); border-radius: 6px; padding: 4px 8px; color: #FFF; font-size: 15px; font-weight: 800; width: 280px;" title="Click to rename invitation">
            </div>
            @if($invitation->isPublished())
                <span class="badge-pill" style="font-size: 10px; background: rgba(16, 185, 129, 0.2); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.4);">● Published</span>
            @else
                <span class="badge-pill" style="font-size: 10px; background: rgba(245, 158, 11, 0.2); color: #FBBF24; border: 1px solid rgba(245, 158, 11, 0.4);">● Draft</span>
            @endif
        </div>

        {{-- Device Frame Switcher Buttons --}}
        <div style="display: flex; align-items: center; gap: 4px; background: rgba(0,0,0,0.4); padding: 4px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08);">
            <button type="button" class="btn-secondary device-switch-btn active" onclick="setPreviewDevice('mobile', this)" style="padding: 5px 12px; font-size: 11px; border-radius: 6px;">
                📱 Mobile
            </button>
            <button type="button" class="btn-secondary device-switch-btn" onclick="setPreviewDevice('tablet', this)" style="padding: 5px 12px; font-size: 11px; border-radius: 6px;">
                💻 Tablet
            </button>
            <button type="button" class="btn-secondary device-switch-btn" onclick="setPreviewDevice('desktop', this)" style="padding: 5px 12px; font-size: 11px; border-radius: 6px;">
                🖥️ Desktop
            </button>
        </div>

        {{-- Actions: Save & Publish --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('invitations.public.show', $invitation->slug) }}" target="_blank" class="btn-secondary" style="padding: 7px 14px; font-size: 12px; text-decoration: none;">
                👁️ View Live Link
            </a>
            <a href="{{ route('invitations.checkout.index', $invitation->id) }}" class="btn-primary" style="padding: 7px 18px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 10px;">
                <span>Publish / Checkout 🚀</span>
            </a>
        </div>
    </header>

    {{-- Split Screen Workspace --}}
    <div class="builder-layout">

        {{-- LEFT SIDE CONFIGURATION PANEL --}}
        <aside class="builder-sidebar">
            
            {{-- Tabs Navigation --}}
            <nav class="builder-tabs-nav">
                <button type="button" class="builder-tab-btn active" onclick="switchBuilderTab('basics', this)">
                    <span>⚙️</span><span>Basics</span>
                </button>
                <button type="button" class="builder-tab-btn" onclick="switchBuilderTab('theme', this)">
                    <span>🎨</span><span>Design</span>
                </button>
                <button type="button" class="builder-tab-btn" onclick="switchBuilderTab('sections', this)">
                    <span>📑</span><span>Sections</span>
                </button>
                <button type="button" class="builder-tab-btn" onclick="switchBuilderTab('events', this)">
                    <span>📅</span><span>Events</span>
                </button>
                <button type="button" class="builder-tab-btn" onclick="switchBuilderTab('rsvp', this)">
                    <span>📝</span><span>RSVP</span>
                </button>
                <button type="button" class="builder-tab-btn" onclick="switchBuilderTab('media', this)">
                    <span>🎵</span><span>Media</span>
                </button>
                <button type="button" class="builder-tab-btn" onclick="switchBuilderTab('ai', this)">
                    <span>🪄</span><span>AI Studio</span>
                </button>
                <button type="button" class="builder-tab-btn" onclick="switchBuilderTab('publish', this)">
                    <span>💎</span><span>Pricing</span>
                </button>
            </nav>

            {{-- TAB 1: BASICS --}}
            <div class="builder-tab-pane active" id="tab-basics">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 16px;">General Information</h3>
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Invitation Title</label>
                    <input type="text" id="opt-title" value="{{ $invitation->title }}" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Custom Vanity Slug URL</label>
                    <div style="display: flex; align-items: center; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; overflow: hidden;">
                        <span style="padding: 10px 12px; font-size: 12px; color: #64748B; background: rgba(0,0,0,0.3);">{{ url('/i/') }}/</span>
                        <input type="text" id="opt-slug" value="{{ $invitation->slug }}" style="flex: 1; background: none; border: none; padding: 10px 12px; color: #FFF; font-size: 13px; outline: none;">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Main Event Date &amp; Time</label>
                    <input type="datetime-local" id="opt-event-date" value="{{ $invitation->event_date ? $invitation->event_date->format('Y-m-d\TH:i') : '' }}" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Cover Banner Image URL</label>
                    <input type="text" id="opt-cover-image" value="{{ $invitation->cover_image }}" placeholder="https://images.unsplash.com/..." class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <button type="button" onclick="saveBasics()" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                    <span>Save Basics 💾</span>
                </button>
            </div>

            {{-- TAB 2: THEME & STYLING --}}
            <div class="builder-tab-pane" id="tab-theme">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 16px;">Color Palette &amp; Typography</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Primary Gold/Accent</label>
                        <input type="color" id="opt-primary-color" value="{{ $invitation->primary_color ?? '#D4AF37' }}" onchange="updateThemeVar('--invite-primary', this.value)" style="width: 100%; height: 42px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Background Tone</label>
                        <input type="color" id="opt-secondary-color" value="{{ $invitation->secondary_color ?? '#0F172A' }}" onchange="updateThemeVar('--invite-secondary', this.value)" style="width: 100%; height: 42px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Heading Luxury Font</label>
                    <select id="opt-heading-font" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                        <option value="Cinzel Decorative" {{ $invitation->font_family_heading === 'Cinzel Decorative' ? 'selected' : '' }}>Cinzel Decorative (Royal Palace)</option>
                        <option value="Playfair Display" {{ $invitation->font_family_heading === 'Playfair Display' ? 'selected' : '' }}>Playfair Display (Romantic Floral)</option>
                        <option value="Cormorant Garamond" {{ $invitation->font_family_heading === 'Cormorant Garamond' ? 'selected' : '' }}>Cormorant Garamond (Timeless Classic)</option>
                        <option value="Outfit" {{ $invitation->font_family_heading === 'Outfit' ? 'selected' : '' }}>Outfit (Modern Sans)</option>
                    </select>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Ambient Particle Physics</label>
                    <select id="opt-animation-style" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                        <option value="sparkles_float" {{ $invitation->animation_style === 'sparkles_float' ? 'selected' : '' }}>✨ Floating Golden Sparkles</option>
                        <option value="petals_fall" {{ $invitation->animation_style === 'petals_fall' ? 'selected' : '' }}>🌸 Falling Rose Petals</option>
                        <option value="confetti" {{ $invitation->animation_style === 'confetti' ? 'selected' : '' }}>🎉 Party Confetti Burst</option>
                        <option value="golden_shimmer" {{ $invitation->animation_style === 'golden_shimmer' ? 'selected' : '' }}>🌟 Subtle Luxury Shimmer</option>
                    </select>
                </div>

                <button type="button" onclick="saveDesign()" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                    <span>Update Design ✨</span>
                </button>
            </div>

            {{-- TAB 3: SECTIONS & PARTICULARS MANAGER --}}
            <div class="builder-tab-pane" id="tab-sections">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0;">Sections &amp; Particulars</h3>
                    <span style="font-size: 11px; color: var(--gold-primary); font-weight: 600;">{{ $invitation->sections->count() }} Sections</span>
                </div>
                <p style="font-size: 12px; color: #94A3B8; margin-bottom: 16px;">Toggle visibility or expand any section to edit texts, sacred shlokas, names, and particulars.</p>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($invitation->sections as $sec)
                    @php
                        $c = $sec->content ?? [];
                    @endphp
                    <div class="glass-panel" style="background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; overflow: hidden; padding: 0;">
                        {{-- Section Row Header --}}
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px;">
                            <div style="cursor: pointer; flex: 1;" onclick="toggleSectionEditor({{ $sec->id }})">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 13px; font-weight: 800; color: #FFF; text-transform: capitalize;">
                                        {{ str_replace('_', ' ', $sec->section_type) }}
                                    </span>
                                    <span style="font-size: 10px; padding: 2px 6px; border-radius: 4px; background: rgba(212,175,55,0.15); color: #FDE68A; font-weight: 600;">
                                        ✏️ Edit
                                    </span>
                                </div>
                                <div style="font-size: 11px; color: #94A3B8; margin-top: 2px;">{{ Str::limit($sec->title ?: 'Default Section', 30) }}</div>
                            </div>
                            
                            <label class="section-toggle-switch" title="Toggle section visibility">
                                <input type="checkbox" id="sec-toggle-{{ $sec->id }}" {{ $sec->is_enabled ? 'checked' : '' }} onchange="toggleSectionVisibility({{ $invitation->id }}, {{ $sec->id }}, this.checked, '{{ $sec->section_type }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        {{-- Expandable Content Editor --}}
                        <div id="section-editor-{{ $sec->id }}" style="display: none; padding: 14px 16px; border-top: 1px solid rgba(255,255,255,0.08); background: rgba(0,0,0,0.35);">
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Section Header / Title</label>
                                <input type="text" id="sec-title-{{ $sec->id }}" value="{{ $sec->title }}" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>

                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Subtitle / Message / Invocations</label>
                                <textarea id="sec-subtitle-{{ $sec->id }}" rows="2" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px; line-height: 1.4;">{{ $sec->subtitle }}</textarea>
                            </div>

                            {{-- Specific Content Fields based on Section Type --}}
                            @if($sec->section_type === 'hero' || $sec->section_type === 'couple')
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 4px;">Groom's Name</label>
                                    <input type="text" id="sec-groom-{{ $sec->id }}" value="{{ $c['groom_name'] ?? 'Rahul' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 4px;">Bride's Name</label>
                                    <input type="text" id="sec-bride-{{ $sec->id }}" value="{{ $c['bride_name'] ?? 'Priya' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">City / Venue Display</label>
                                <input type="text" id="sec-city-{{ $sec->id }}" value="{{ $c['city_display'] ?? 'Mumbai, India' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @elseif($sec->section_type === 'venue')
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Venue Story / Description</label>
                                <input type="text" id="sec-venue-desc-{{ $sec->id }}" value="{{ $c['description'] ?? '' }}" placeholder="An idyllic palace setting..." class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Airport Distance</label>
                                    <input type="text" id="sec-airport-{{ $sec->id }}" value="{{ $c['airport_distance'] ?? '' }}" placeholder="25 km from Airport" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Railway Distance</label>
                                    <input type="text" id="sec-train-{{ $sec->id }}" value="{{ $c['train_distance'] ?? '' }}" placeholder="12 km from Station" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                            </div>
                            @elseif($sec->section_type === 'dress_code')
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Attire / Dress Guidelines</label>
                                <input type="text" id="sec-dress-{{ $sec->id }}" value="{{ $c['attire'] ?? 'Festive Traditional & Pastel Elegance' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @endif

                            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 10px;">
                                <button type="button" onclick="saveSectionParticulars({{ $sec->id }}, '{{ $sec->section_type }}')" class="btn-primary" style="padding: 6px 14px; font-size: 11px; font-weight: 700; border-radius: 6px;">
                                    <span>Save &amp; Update Live 💾</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- TAB 4: EVENTS & ITINERARY --}}
            <div class="builder-tab-pane" id="tab-events">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0;">Event Itinerary</h3>
                    <span style="font-size: 11px; color: var(--gold-primary); font-weight: 600;">{{ $invitation->events->count() }} Functions</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                    @foreach($invitation->events as $ev)
                    <div class="glass-panel" style="background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; overflow: hidden; padding: 0;">
                        {{-- Event Header Row --}}
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px;">
                            <div style="flex: 1; cursor: pointer;" onclick="toggleEventEditor({{ $ev->id }})">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="font-size: 15px;">{{ $ev->icon ?: '✨' }}</span>
                                    <strong style="color: #FFF; font-size: 13px;">{{ $ev->title }}</strong>
                                </div>
                                <div style="font-size: 11px; color: var(--gold-primary); margin-top: 2px;">
                                    📅 {{ $ev->event_date ? $ev->event_date->format('M d, Y') : 'Date TBA' }} • 🕒 {{ $ev->start_time ? substr($ev->start_time, 0, 5) : 'TBA' }}
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <button type="button" onclick="toggleEventEditor({{ $ev->id }})" class="btn-secondary" style="padding: 4px 8px; font-size: 11px;">✏️</button>
                                <button type="button" onclick="deleteEvent({{ $ev->id }})" class="btn-secondary" style="padding: 4px 8px; font-size: 11px; color: #F87171;">🗑️</button>
                            </div>
                        </div>

                        {{-- Expandable Event Editor Form --}}
                        <div id="event-editor-{{ $ev->id }}" style="display: none; padding: 14px; border-top: 1px solid rgba(255,255,255,0.08); background: rgba(0,0,0,0.35);">
                            <div style="margin-bottom: 8px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Function / Ceremony Title</label>
                                <input type="text" id="ev-title-{{ $ev->id }}" value="{{ $ev->title }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px;">
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Event Date</label>
                                    <input type="date" id="ev-date-{{ $ev->id }}" value="{{ $ev->event_date ? $ev->event_date->format('Y-m-d') : '' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Start Time</label>
                                    <input type="time" id="ev-start-{{ $ev->id }}" value="{{ $ev->start_time ? substr($ev->start_time, 0, 5) : '18:00' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                            </div>

                            <div style="margin-bottom: 8px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Venue Name</label>
                                <input type="text" id="ev-venue-{{ $ev->id }}" value="{{ $ev->venue_name }}" placeholder="Grand Ballroom, Palace Lawn" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Dress Code</label>
                                    <input type="text" id="ev-dress-{{ $ev->id }}" value="{{ $ev->dress_code }}" placeholder="Pastel Lehengas / Kurtas" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Emoji Icon</label>
                                    <input type="text" id="ev-icon-{{ $ev->id }}" value="{{ $ev->icon ?: '✨' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                            </div>

                            <button type="button" onclick="saveEventDetails({{ $ev->id }})" class="btn-primary" style="width: 100%; padding: 8px; font-size: 11px; font-weight: 700; border-radius: 8px;">
                                <span>Save Event Particulars 💾</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Add New Event Form --}}
                <div class="glass-panel" style="padding: 16px; border-radius: 14px; background: rgba(0,0,0,0.4);">
                    <h4 style="font-size: 13px; font-weight: 700; color: var(--gold-primary); margin-bottom: 12px;">+ Add New Event</h4>
                    <div style="margin-bottom: 10px;">
                        <input type="text" id="new-event-title" placeholder="Event Title (e.g. Sangeet Ceremony)" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                    </div>
                    <div style="margin-bottom: 10px;">
                        <input type="date" id="new-event-date" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                    </div>
                    <div style="margin-bottom: 10px;">
                        <input type="text" id="new-event-venue" placeholder="Venue Name & City" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                    </div>
                    <button type="button" onclick="addNewEvent()" class="btn-primary" style="width: 100%; padding: 8px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        <span>Add Event to Itinerary</span>
                    </button>
                </div>
            </div>

            {{-- TAB 5: RSVP BUILDER --}}
            <div class="builder-tab-pane" id="tab-rsvp">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 16px;">RSVP Form Settings</h3>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">RSVP Deadline Date</label>
                    <input type="date" id="opt-rsvp-deadline" value="{{ $invitation->rsvpForm?->deadline ? $invitation->rsvpForm->deadline->format('Y-m-d') : '' }}" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Max Party Size per Submission</label>
                    <input type="number" id="opt-rsvp-max-party" value="{{ $invitation->rsvpForm?->max_party_size ?? 5 }}" min="1" max="20" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="opt-rsvp-plus-one" {{ ($invitation->rsvpForm?->allow_guest_plus_one ?? true) ? 'checked' : '' }} style="accent-color: var(--gold-primary);">
                        <span style="font-size: 13px; color: #FFF; font-weight: 600;">Allow Guests to bring Plus-Ones</span>
                    </label>
                </div>

                <button type="button" onclick="saveRsvp()" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                    <span>Save RSVP Settings 📝</span>
                </button>
            </div>

            {{-- TAB 6: MEDIA & MUSIC --}}
            <div class="builder-tab-pane" id="tab-media">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 16px;">Audio &amp; Gallery Media</h3>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Background Audio MP3 Track URL</label>
                    <input type="text" id="opt-music-url" value="{{ $invitation->music_url }}" placeholder="https://example.com/song.mp3" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <button type="button" onclick="saveMedia()" class="btn-primary" style="width: 100%; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 10px;">
                    <span>Save Music &amp; Audio 🎵</span>
                </button>
            </div>

            {{-- TAB: AI STUDIO --}}
            <div class="builder-tab-pane" id="tab-ai">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <span style="font-size: 20px;">🪄</span>
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0;">AI Copywriter &amp; Assistant</h3>
                </div>
                <p style="font-size: 12px; color: #94A3B8; margin-bottom: 16px;">
                    Generate personalized love stories, spiritual invocations, and WhatsApp sharing messages in multiple tones.
                </p>

                {{-- Tone Switcher --}}
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 6px;">Choose Tone &amp; Style</label>
                    <select id="builder-ai-tone" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                        <option value="luxury">👑 Luxury &amp; Regal</option>
                        <option value="traditional">🕉️ Traditional &amp; Divine</option>
                        <option value="romantic">💖 Romantic &amp; Heartfelt</option>
                        <option value="emotional">🥺 Emotional &amp; Warm</option>
                        <option value="funny">😄 Funny &amp; Playful</option>
                        <option value="hinglish">🇮🇳 Desi Hinglish</option>
                    </select>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                    <button type="button" onclick="generateBuilderAiContent('welcome_message')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; text-align: left; display: flex; justify-content: space-between; align-items: center; border-radius: 10px;">
                        <span>✍️ Generate Welcome Invocation</span>
                        <span style="font-size: 10px; color: var(--gold-primary);">AI &rarr;</span>
                    </button>
                    <button type="button" onclick="generateBuilderAiContent('love_story')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; text-align: left; display: flex; justify-content: space-between; align-items: center; border-radius: 10px;">
                        <span>💕 Generate Couple Love Story</span>
                        <span style="font-size: 10px; color: var(--gold-primary);">AI &rarr;</span>
                    </button>
                    <button type="button" onclick="generateBuilderAiContent('whatsapp_invite')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; text-align: left; display: flex; justify-content: space-between; align-items: center; border-radius: 10px;">
                        <span>💬 Generate WhatsApp Share Message</span>
                        <span style="font-size: 10px; color: var(--gold-primary);">AI &rarr;</span>
                    </button>
                    <button type="button" onclick="generateBuilderAiContent('thank_you')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; text-align: left; display: flex; justify-content: space-between; align-items: center; border-radius: 10px;">
                        <span>🙏 Generate Post-Event Thank You Note</span>
                        <span style="font-size: 10px; color: var(--gold-primary);">AI &rarr;</span>
                    </button>
                </div>

                {{-- AI Result Box --}}
                <div id="builder-ai-result-box" style="display: none; background: rgba(0,0,0,0.5); border: 1px solid rgba(212,175,55,0.4); border-radius: 12px; padding: 14px;">
                    <div style="font-size: 11px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 6px;">Generated AI Copy</div>
                    <textarea id="builder-ai-result-text" rows="4" style="width: 100%; background: none; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; padding: 8px; color: #FFF; font-size: 12px; line-height: 1.5; outline: none; margin-bottom: 8px;"></textarea>
                    <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('builder-ai-result-text').value); alert('Copied to clipboard!');" class="btn-secondary" style="padding: 6px 12px; font-size: 11px; width: 100%;">
                        📋 Copy Text to Clipboard
                    </button>
                </div>
            </div>

            {{-- TAB 7: PRICING & PUBLISH --}}
            <div class="builder-tab-pane" id="tab-publish">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 12px;">Premium Features &amp; Add-ons</h3>

                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px;">
                    @foreach($features as $feat)
                    @php
                        $isChecked = $invitation->hasFeature($feat->code);
                        $featPrice = $feat->getPrice('INR');
                    @endphp
                    <label style="display: flex; align-items: flex-start; gap: 12px; padding: 12px 14px; border-radius: 12px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.08); cursor: pointer;">
                        <input type="checkbox" class="feature-checkbox" value="{{ $feat->code }}" {{ $isChecked ? 'checked' : '' }} style="margin-top: 4px; accent-color: var(--gold-primary);">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 13px; font-weight: 700; color: #FFF;">{{ $feat->name }}</span>
                                <span style="font-size: 12px; font-weight: 800; color: var(--gold-primary);">
                                    {{ $featPrice > 0 ? '+₹' . number_format($featPrice, 0) : 'Included' }}
                                </span>
                            </div>
                            <div style="font-size: 11px; color: #94A3B8; margin-top: 2px;">{{ $feat->description }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Pricing Box --}}
                <div class="glass-panel" id="pricing-summary-box" style="padding: 20px; border-radius: 16px; background: rgba(0,0,0,0.5); border: 1px solid rgba(212,175,55,0.3); margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #94A3B8; margin-bottom: 8px;">
                        <span>Template Subtotal</span>
                        <span id="pricing-subtotal" style="color: #FFF; font-weight: 700;">{{ $pricing['formatted_subtotal'] }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #10B981; margin-bottom: 12px; display: none;" id="pricing-discount-row">
                        <span>Coupon Discount</span>
                        <span id="pricing-discount" style="font-weight: 700;">-₹0.00</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px;">
                        <span style="font-size: 15px; font-weight: 800; color: #FFF;">Total Amount</span>
                        <span id="pricing-final-amount" style="font-size: 22px; font-weight: 900; color: var(--gold-primary);">{{ $pricing['formatted_final'] }}</span>
                    </div>
                </div>

                <a href="{{ route('invitations.checkout.index', $invitation->id) }}" class="btn-primary" style="width: 100%; padding: 14px; font-size: 14px; font-weight: 700; text-align: center; text-decoration: none; border-radius: 12px; display: block;">
                    <span>Proceed to Publish 🚀</span>
                </a>
            </div>

        </aside>

        {{-- RIGHT SIDE LIVE PREVIEW STAGE --}}
        <main class="builder-preview-stage">
            <div class="preview-device-frame mobile" id="preview-device-frame">
                <iframe src="{{ route('invitations.public.show', $invitation->slug) }}?no_curtain=1" class="preview-iframe" id="builder-preview-iframe"></iframe>
            </div>
        </main>

    </div>

    {{-- Scripts --}}
    <script src="{{ asset('js/invitations-builder.js') }}"></script>
    <script>
        function saveBasics() {
            const data = {
                title: document.getElementById('opt-title').value,
                slug: document.getElementById('opt-slug').value,
                event_date: document.getElementById('opt-event-date').value,
                cover_image: document.getElementById('opt-cover-image').value
            };

            fetch('{{ route("invitations.builder.update", $invitation->id, false) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(d => {
                if(d.success) alert('Basics saved!');
            });
        }

        function saveDesign() {
            const data = {
                primary_color: document.getElementById('opt-primary-color').value,
                secondary_color: document.getElementById('opt-secondary-color').value,
                font_family_heading: document.getElementById('opt-heading-font').value,
                animation_style: document.getElementById('opt-animation-style').value
            };

            fetch('{{ route("invitations.builder.update", $invitation->id, false) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(d => {
                if(d.success) {
                    alert('Design updated!');
                    document.getElementById('builder-preview-iframe').contentWindow.location.reload();
                }
            });
        }

        function addNewEvent() {
            const title = document.getElementById('new-event-title').value;
            const date = document.getElementById('new-event-date').value;
            const venue = document.getElementById('new-event-venue').value;

            if(!title) return alert('Please enter an event title.');

            fetch('{{ route("invitations.builder.event.add", $invitation->id, false) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ title: title, event_date: date, venue_name: venue })
            })
            .then(res => res.json())
            .then(d => {
                if(d.success) {
                    alert('Event added!');
                    window.location.reload();
                }
            });
        }

        function deleteEvent(eventId) {
            if(!confirm('Remove this event?')) return;

            fetch('/invitations/builder/{{ $invitation->id }}/event/' + eventId + '/delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(d => {
                if(d.success) window.location.reload();
            });
        }

        function saveRsvp() {
            const data = {
                deadline: document.getElementById('opt-rsvp-deadline').value,
                max_party_size: document.getElementById('opt-rsvp-max-party').value,
                allow_guest_plus_one: document.getElementById('opt-rsvp-plus-one').checked ? 1 : 0
            };

            fetch('{{ route("invitations.builder.rsvp.update", $invitation->id, false) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(d => {
                if(d.success) alert('RSVP settings saved!');
            });
        }

        function saveMedia() {
            const data = {
                music_url: document.getElementById('opt-music-url').value
            };

            fetch('{{ route("invitations.builder.update", $invitation->id, false) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(d => {
                if(d.success) alert('Music settings saved!');
            });
        }

        function toggleSectionEditor(sectionId) {
            const editor = document.getElementById('section-editor-' + sectionId);
            if (editor) {
                editor.style.display = editor.style.display === 'none' ? 'block' : 'none';
            }
        }

        function saveSectionParticulars(sectionId, sectionType) {
            const title = document.getElementById('sec-title-' + sectionId)?.value;
            const subtitle = document.getElementById('sec-subtitle-' + sectionId)?.value;
            const content = {};

            if (sectionType === 'hero' || sectionType === 'couple') {
                content.groom_name = document.getElementById('sec-groom-' + sectionId)?.value;
                content.bride_name = document.getElementById('sec-bride-' + sectionId)?.value;
                content.city_display = document.getElementById('sec-city-' + sectionId)?.value;
            } else if (sectionType === 'venue') {
                content.description = document.getElementById('sec-venue-desc-' + sectionId)?.value;
                content.airport_distance = document.getElementById('sec-airport-' + sectionId)?.value;
                content.train_distance = document.getElementById('sec-train-' + sectionId)?.value;
            } else if (sectionType === 'dress_code') {
                content.attire = document.getElementById('sec-dress-' + sectionId)?.value;
            }

            fetch('/invitations/builder/{{ $invitation->id }}/section/' + sectionId + '/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    title: title,
                    subtitle: subtitle,
                    content: content
                })
            })
            .then(res => res.json())
            .then(d => {
                if (d.success) {
                    alert('Section particulars updated!');
                    document.getElementById('builder-preview-iframe').contentWindow.location.reload();
                }
            })
            .catch(err => alert('Failed to update section.'));
        }

        function toggleEventEditor(eventId) {
            const editor = document.getElementById('event-editor-' + eventId);
            if (editor) {
                editor.style.display = editor.style.display === 'none' ? 'block' : 'none';
            }
        }

        function saveEventDetails(eventId) {
            const data = {
                title: document.getElementById('ev-title-' + eventId)?.value,
                event_date: document.getElementById('ev-date-' + eventId)?.value,
                start_time: document.getElementById('ev-start-' + eventId)?.value,
                venue_name: document.getElementById('ev-venue-' + eventId)?.value,
                dress_code: document.getElementById('ev-dress-' + eventId)?.value,
                icon: document.getElementById('ev-icon-' + eventId)?.value
            };

            fetch('/invitations/builder/{{ $invitation->id }}/event/' + eventId + '/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(d => {
                if (d.success) {
                    alert('Event particulars saved!');
                    document.getElementById('builder-preview-iframe').contentWindow.location.reload();
                }
            })
            .catch(err => alert('Failed to update event.'));
        }
    </script>
</body>
</html>
