<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Builder — {{ $invitation->title }} | CelebrateAI</title>

    <link rel="stylesheet" href="{{ asset('css/postryx-theme.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/invitations-market.css') }}?v={{ time() }}">
    <script>window.BUILDER_INVITATION_ID = {{ $invitation->id }};</script>
    <script src="{{ asset('js/invitations-builder.js') }}?v={{ time() }}"></script>
    
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

        {{-- Actions: Save Draft & Publish --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" id="btn-top-save-draft" onclick="saveMasterDraft()" class="btn-secondary" style="padding: 7px 16px; font-size: 12px; font-weight: 700; background: rgba(212,175,55,0.15); border: 1px solid rgba(212,175,55,0.4); color: #FDE68A;">
                <span>💾 Save Draft</span>
            </button>
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
            
            {{-- Step Indicator & Progress --}}
            <div class="builder-step-header">
                <div class="builder-step-info">
                    <span class="builder-step-badge" id="builder-step-badge">Step 1 of 9</span>
                    <span class="builder-step-title" id="builder-step-title">General Information</span>
                </div>
                <div class="builder-progress-track">
                    <div class="builder-progress-fill" id="builder-progress-fill" style="width: 11.11%;"></div>
                </div>
            </div>

            {{-- Tabs Navigation Bar with Scroll Buttons --}}
            <div class="builder-tabs-wrapper">
                <button type="button" class="builder-tab-scroll-btn" onclick="scrollTabNav(-1)" title="Scroll Left">‹</button>
                <nav class="builder-tabs-nav" id="builder-tabs-nav">
                    <button type="button" class="builder-tab-btn active" id="tab-btn-basics" onclick="switchBuilderTab('basics', this)">
                        <span class="builder-tab-num">1</span>
                        <span>⚙️ Basics</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-theme" onclick="switchBuilderTab('theme', this)">
                        <span class="builder-tab-num">2</span>
                        <span>🎨 Design</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-location" onclick="switchBuilderTab('location', this)">
                        <span class="builder-tab-num">3</span>
                        <span>📍 Location</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-sections" onclick="switchBuilderTab('sections', this)">
                        <span class="builder-tab-num">4</span>
                        <span>📑 Sections</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-events" onclick="switchBuilderTab('events', this)">
                        <span class="builder-tab-num">5</span>
                        <span>📅 Events</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-rsvp" onclick="switchBuilderTab('rsvp', this)">
                        <span class="builder-tab-num">6</span>
                        <span>📝 RSVP</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-media" onclick="switchBuilderTab('media', this)">
                        <span class="builder-tab-num">7</span>
                        <span>🎵 Media</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-ai" onclick="switchBuilderTab('ai', this)">
                        <span class="builder-tab-num">8</span>
                        <span>🪄 AI Studio</span>
                    </button>
                    <button type="button" class="builder-tab-btn" id="tab-btn-publish" onclick="switchBuilderTab('publish', this)">
                        <span class="builder-tab-num">9</span>
                        <span>💎 Pricing</span>
                    </button>
                </nav>
                <button type="button" class="builder-tab-scroll-btn" onclick="scrollTabNav(1)" title="Scroll Right">›</button>
            </div>

            {{-- TAB 1: BASICS --}}
            <div class="builder-tab-pane active" id="tab-basics">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 16px;">General Information</h3>
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Invitation Title</label>
                    <input type="text" id="opt-title" value="{{ $invitation->title }}" class="form-control" oninput="syncLiveText('hero-title', this.value)" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
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
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label style="font-size: 12px; font-weight: 600; color: #94A3B8;">Cover / Background Image</label>
                        <span style="font-size: 11px; color: var(--gold-primary);">Auto-converts Unsplash &amp; Drive links</span>
                    </div>

                    {{-- Local File Upload Button --}}
                    <input type="file" id="cover-image-file-input" accept="image/*" style="display: none;" onchange="handleCoverImageUpload(this)">
                    <button type="button" onclick="document.getElementById('cover-image-file-input').click()" class="btn-secondary" style="width: 100%; padding: 9px 14px; font-size: 12px; font-weight: 700; margin-bottom: 8px; border-radius: 10px; border: 1px dashed rgba(212,175,55,0.5); background: rgba(212,175,55,0.08); color: var(--gold-primary); display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <span>📁 Upload Photo from Device</span>
                    </button>

                    {{-- Image URL Input with Auto-Normalizer --}}
                    <input type="text" id="opt-cover-image" value="{{ $invitation->cover_image }}" placeholder="Paste any image URL or Unsplash link..." class="form-control" oninput="handleCoverImageInput(this)" onchange="handleCoverImageInput(this)" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">

                    {{-- Background Opacity Slider --}}
                    @php
                        $curOpacityPercent = $invitation->bg_opacity_percent ?? 45;
                    @endphp
                    <div style="margin-top: 12px; background: rgba(0,0,0,0.25); padding: 10px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08);">
                        <div style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; color: #94A3B8; margin-bottom: 4px;">
                            <span>Background Image Visibility</span>
                            <span id="val-bg-opacity" style="color: var(--gold-primary); font-weight: 700;">{{ $curOpacityPercent }}%</span>
                        </div>
                        <input type="range" id="opt-bg-opacity" min="0" max="100" value="{{ $curOpacityPercent }}" oninput="handleBgOpacityChange(this.value)" style="width: 100%; accent-color: var(--gold-primary); cursor: pointer;">
                    </div>
                </div>

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <div></div>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" id="btn-save-basics" onclick="saveBasics()" class="btn-secondary" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                            💾 Save Basics
                        </button>
                        <button type="button" id="btn-next-basics" onclick="saveBasicsAndNext()" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                            Save &amp; Continue: Design 🎨 &rarr;
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 2: THEME, BACKGROUND & CARD STYLING --}}
            <div class="builder-tab-pane" id="tab-theme">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 16px;">Design, Colors &amp; Backgrounds</h3>

                {{-- Primary Colors --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Primary Gold/Accent</label>
                        <input type="color" id="opt-primary-color" value="{{ $invitation->primary_color ?? '#D4AF37' }}" oninput="updateThemeVar('--invite-primary', this.value); updateThemeVar('--gold-primary', this.value);" style="width: 100%; height: 42px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Page Background Color</label>
                        <input type="color" id="opt-secondary-color" value="{{ $invitation->secondary_color ?? '#0F172A' }}" oninput="updatePageBg(this.value, document.getElementById('opt-cover-image').value, (document.getElementById('opt-bg-opacity')?.value || 45) / 100);" style="width: 100%; height: 42px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                    </div>
                </div>

                {{-- Luxury Texture Presets --}}
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label style="font-size: 12px; font-weight: 600; color: #94A3B8;">Luxury Texture Presets</label>
                        <button type="button" onclick="document.getElementById('cover-image-file-input').click()" style="background: none; border: none; font-size: 11px; color: var(--gold-primary); cursor: pointer; text-decoration: underline;">
                            + Upload Custom
                        </button>
                    </div>
                    <div class="bg-preset-grid">
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=300&q=80') center/cover;" onclick="setBgTexture('https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1200&q=80')">✨ Gold Silk</button>
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=300&q=80') center/cover;" onclick="setBgTexture('https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=1200&q=80')">🌸 Petals</button>
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=300&q=80') center/cover;" onclick="setBgTexture('https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=1200&q=80')">🌌 Midnight</button>
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=300&q=80') center/cover;" onclick="setBgTexture('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80')">🏛️ Palace</button>
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=300&q=80') center/cover;" onclick="setBgTexture('https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1200&q=80')">👑 Regal Dark</button>
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=300&q=80') center/cover;" onclick="setBgTexture('https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=1200&q=80')">🌿 Botanical</button>
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=300&q=80') center/cover;" onclick="setBgTexture('https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=1200&q=80')">🎨 Damask</button>
                        <button type="button" class="bg-preset-item" style="background: linear-gradient(135deg, #1E293B, #0F172A);" onclick="setBgTexture('')">🚫 Clear BG</button>
                    </div>
                </div>

                {{-- Background Opacity Slider (Synced in Design Tab) --}}
                <div style="margin-bottom: 16px; background: rgba(0,0,0,0.25); padding: 10px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08);">
                    <div style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; color: #94A3B8; margin-bottom: 4px;">
                        <span>Background Image Visibility</span>
                        <span id="val-bg-opacity-design" style="color: var(--gold-primary); font-weight: 700;">{{ $curOpacityPercent }}%</span>
                    </div>
                    <input type="range" id="opt-bg-opacity-design" min="0" max="100" value="{{ $curOpacityPercent }}" oninput="handleBgOpacityChange(this.value)" style="width: 100%; accent-color: var(--gold-primary); cursor: pointer;">
                </div>

                {{-- Global Card Styling --}}
                <div class="glass-panel" style="padding: 16px; border-radius: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); margin-bottom: 16px;">
                    <div style="font-size: 12px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 10px;">Global Cards Customization</div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                        <div>
                            <label style="display: block; font-size: 11px; color: #94A3B8; margin-bottom: 4px;">Card Background Color</label>
                            <input type="color" id="opt-card-bg-color" value="#0F172A" oninput="updateCardStyle(this.value, document.getElementById('opt-card-border-color').value, document.getElementById('opt-card-text-color').value, document.getElementById('opt-card-radius').value)" style="width: 100%; height: 38px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; color: #94A3B8; margin-bottom: 4px;">Card Border Color</label>
                            <input type="color" id="opt-card-border-color" value="#D4AF37" oninput="updateCardStyle(document.getElementById('opt-card-bg-color').value, this.value, document.getElementById('opt-card-text-color').value, document.getElementById('opt-card-radius').value)" style="width: 100%; height: 38px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="display: block; font-size: 11px; color: #94A3B8; margin-bottom: 4px;">Card Text Color</label>
                            <input type="color" id="opt-card-text-color" value="#E2E8F0" oninput="updateCardStyle(document.getElementById('opt-card-bg-color').value, document.getElementById('opt-card-border-color').value, this.value, document.getElementById('opt-card-radius').value)" style="width: 100%; height: 38px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; color: #94A3B8; margin-bottom: 4px;">Corner Radius (px)</label>
                            <input type="number" id="opt-card-radius" value="20" min="0" max="40" oninput="updateCardStyle(document.getElementById('opt-card-bg-color').value, document.getElementById('opt-card-border-color').value, document.getElementById('opt-card-text-color').value, this.value)" style="width: 100%; padding: 8px 10px; border-radius: 6px; background: #0F172A; border: 1px solid rgba(255,255,255,0.2); color: #FFF; font-size: 12px;">
                        </div>
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
                        <option value="marigold_shower" {{ $invitation->animation_style === 'marigold_shower' ? 'selected' : '' }}>🌼 Auspicious Marigold Shower</option>
                        <option value="diya_sparkle" {{ $invitation->animation_style === 'diya_sparkle' ? 'selected' : '' }}>🪔 Divine Glowing Diyas</option>
                        <option value="confetti" {{ $invitation->animation_style === 'confetti' ? 'selected' : '' }}>🎉 Party Confetti Burst</option>
                        <option value="golden_shimmer" {{ $invitation->animation_style === 'golden_shimmer' ? 'selected' : '' }}>🌟 Subtle Luxury Shimmer</option>
                    </select>
                </div>

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('basics')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to Basics
                    </button>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" id="btn-save-design" onclick="saveDesign()" class="btn-secondary" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                            💾 Save Design
                        </button>
                        <button type="button" id="btn-next-design" onclick="saveDesignAndNext()" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                            Save &amp; Continue: Location 📍 &rarr;
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 3: LOCATION & VENUE DETAILS --}}
            @php
                $venueSection = $invitation->sections->where('section_type', 'venue')->first();
                $vContent = $venueSection?->content ?? [];
                $firstEvent = $invitation->events->first();
                $defVenueName = $vContent['venue_name'] ?? ($firstEvent?->venue_name ?? 'The Grand Palace & Resort');
                $defVenueAddress = $vContent['venue_address'] ?? ($firstEvent?->venue_address ?? 'Palace Road, City Center, Rajasthan 313001');
                $defCityDisplay = $vContent['city_display'] ?? 'Udaipur, Rajasthan';
                $defMapsUrl = $vContent['google_maps_url'] ?? '';
                $defMapEmbed = $vContent['map_embed_url'] ?? '';
                $defAirport = $vContent['airport_distance'] ?? '25 km from Maharana Pratap Airport (UDR)';
                $defTrain = $vContent['train_distance'] ?? '8 km from Udaipur City Railway Station';
                $defLandmark = $vContent['landmark'] ?? 'Near Gate 2, Lake Pichola Waterfront';
                $defNotes = $vContent['directions_notes'] ?? 'Valet parking available for all guests at the North Lawn entrance.';
            @endphp
            <div class="builder-tab-pane" id="tab-location">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <span style="font-size: 20px;">📍</span>
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0;">Venue &amp; Location Details</h3>
                </div>
                <p style="font-size: 12px; color: #94A3B8; margin-bottom: 16px;">Configure your event venue name, full address, Google Maps links, and arrival notes for your guests.</p>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 4px;">Primary Venue Name *</label>
                    <input type="text" id="loc-venue-name" value="{{ $defVenueName }}" placeholder="e.g. The Leela Palace, Udaipur" class="form-control" oninput="updateLocationPreview(this.value, document.getElementById('loc-venue-address').value, document.getElementById('loc-city-display').value, document.getElementById('loc-maps-url').value)" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Full Address &amp; Street</label>
                    <textarea id="loc-venue-address" rows="2" placeholder="e.g. Lake Pichola, City Palace Complex, Udaipur, Rajasthan 313001" class="form-control" oninput="updateLocationPreview(document.getElementById('loc-venue-name').value, this.value, document.getElementById('loc-city-display').value, document.getElementById('loc-maps-url').value)" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px; line-height: 1.4;">{{ $defVenueAddress }}</textarea>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">City / State (Short Badge Display)</label>
                    <input type="text" id="loc-city-display" value="{{ $defCityDisplay }}" placeholder="e.g. Udaipur, Rajasthan" class="form-control" oninput="updateLocationPreview(document.getElementById('loc-venue-name').value, document.getElementById('loc-venue-address').value, this.value, document.getElementById('loc-maps-url').value)" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Custom Google Maps URL (Optional)</label>
                    <input type="text" id="loc-maps-url" value="{{ $defMapsUrl }}" placeholder="https://maps.app.goo.gl/..." class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Google Map Embed Iframe URL (Optional)</label>
                    <input type="text" id="loc-map-embed" value="{{ $defMapEmbed }}" placeholder="https://www.google.com/maps/embed?pb=..." class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px;">
                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Airport Distance</label>
                        <input type="text" id="loc-airport" value="{{ $defAirport }}" placeholder="25 km from Airport" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Railway Distance</label>
                        <input type="text" id="loc-train" value="{{ $defTrain }}" placeholder="12 km from Station" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Landmark &amp; Proximity</label>
                    <input type="text" id="loc-landmark" value="{{ $defLandmark }}" placeholder="Opposite City Palace, Waterfront" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Guest Parking &amp; Arrival Notes</label>
                    <input type="text" id="loc-notes" value="{{ $defNotes }}" placeholder="Valet parking available at North Lawn..." class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                </div>

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('theme')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to Design
                    </button>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" id="btn-save-location" onclick="saveLocationDetails()" class="btn-secondary" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                            💾 Save Location
                        </button>
                        <button type="button" id="btn-next-location" onclick="saveLocationAndNext()" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                            Save &amp; Continue: Sections 📑 &rarr;
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 4: SECTIONS & CARD CUSTOMIZATION --}}
            <div class="builder-tab-pane" id="tab-sections">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0;">Sections &amp; Particulars</h3>
                    <span style="font-size: 11px; color: var(--gold-primary); font-weight: 600;">{{ $invitation->sections->count() }} Sections</span>
                </div>
                <p style="font-size: 12px; color: #94A3B8; margin-bottom: 16px;">Customize texts, sacred shlokas, names, and individual card colors for any section.</p>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($invitation->sections as $sec)
                    @php
                        $c = $sec->content ?? [];
                        $s = $sec->settings ?? [];
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
                                        ✏️ Customize
                                    </span>
                                </div>
                                <div style="font-size: 11px; color: #94A3B8; margin-top: 2px;">{{ Str::limit($sec->title ?: 'Default Section', 30) }}</div>
                            </div>
                            
                            <label class="section-toggle-switch" title="Toggle section visibility">
                                <input type="checkbox" id="sec-toggle-{{ $sec->id }}" {{ $sec->is_enabled ? 'checked' : '' }} onchange="toggleSectionVisibility({{ $invitation->id }}, {{ $sec->id }}, this.checked, '{{ $sec->section_type }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        {{-- Expandable Content & Styling Editor --}}
                        <div id="section-editor-{{ $sec->id }}" style="display: none; padding: 14px 16px; border-top: 1px solid rgba(255,255,255,0.08); background: rgba(0,0,0,0.35);">
                            
                            {{-- Header & Subtitle --}}
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Section Header / Title</label>
                                <input type="text" id="sec-title-{{ $sec->id }}" value="{{ $sec->title }}" oninput="syncLiveSectionText({{ $sec->id }}, '{{ $sec->section_type }}', this.value, document.getElementById('sec-subtitle-{{ $sec->id }}').value)" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>

                            <div style="margin-bottom: 12px;">
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Subtitle / Message / Invocations</label>
                                <textarea id="sec-subtitle-{{ $sec->id }}" rows="2" oninput="syncLiveSectionText({{ $sec->id }}, '{{ $sec->section_type }}', document.getElementById('sec-title-{{ $sec->id }}').value, this.value)" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px; line-height: 1.4;">{{ $sec->subtitle }}</textarea>
                            </div>

                            {{-- Specific Content Fields based on Section Type --}}
                            @if($sec->section_type === 'hero' || $sec->section_type === 'couple')
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px;">
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 4px;">Groom's Name</label>
                                    <input type="text" id="sec-groom-{{ $sec->id }}" value="{{ $c['groom_name'] ?? 'Rahul' }}" oninput="syncLiveText('groom-name-display', this.value)" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 4px;">Bride's Name</label>
                                    <input type="text" id="sec-bride-{{ $sec->id }}" value="{{ $c['bride_name'] ?? 'Priya' }}" oninput="syncLiveText('bride-name-display', this.value)" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                                </div>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">City / Venue Display</label>
                                <input type="text" id="sec-city-{{ $sec->id }}" value="{{ $c['city_display'] ?? 'Mumbai, India' }}" oninput="syncLiveText('hero-city-display', '📍 ' + this.value)" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @if($sec->section_type === 'couple')
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Love Story Narrative</label>
                                <textarea id="sec-story-{{ $sec->id }}" rows="2" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">{{ $c['story'] ?? '' }}</textarea>
                            </div>
                            @endif
                            @elseif($sec->section_type === 'venue')
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 4px;">Venue Name</label>
                                <input type="text" id="sec-venue-name-{{ $sec->id }}" value="{{ $c['venue_name'] ?? '' }}" placeholder="The Leela Palace" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Venue Address</label>
                                <input type="text" id="sec-venue-address-{{ $sec->id }}" value="{{ $c['venue_address'] ?? '' }}" placeholder="Lake Pichola, Udaipur" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
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
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Google Maps Link</label>
                                <input type="text" id="sec-maps-url-{{ $sec->id }}" value="{{ $c['google_maps_url'] ?? '' }}" placeholder="https://maps.google.com/?q=..." class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @elseif($sec->section_type === 'map')
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 4px;">Venue Name Display</label>
                                <input type="text" id="sec-map-venue-{{ $sec->id }}" value="{{ $c['venue_name'] ?? '' }}" placeholder="Taj Lake Palace, Udaipur" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Address Display</label>
                                <input type="text" id="sec-map-address-{{ $sec->id }}" value="{{ $c['venue_address'] ?? '' }}" placeholder="Pichola, Udaipur, Rajasthan 313001" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Google Maps URL</label>
                                <input type="text" id="sec-map-link-{{ $sec->id }}" value="{{ $c['google_maps_url'] ?? '' }}" placeholder="https://maps.google.com/?q=..." class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @elseif($sec->section_type === 'dress_code')
                            <div style="margin-bottom: 8px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Mehendi &amp; Sangeet Attire</label>
                                <input type="text" id="sec-dress-mehendi-{{ $sec->id }}" value="{{ $c['mehendi'] ?? 'Pastels & Bright Floral Lehengas' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            <div style="margin-bottom: 8px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Haldi Attire</label>
                                <input type="text" id="sec-dress-haldi-{{ $sec->id }}" value="{{ $c['haldi'] ?? 'Sunshine Yellow & Mustard Kurtas' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Wedding / Reception Attire</label>
                                <input type="text" id="sec-dress-wedding-{{ $sec->id }}" value="{{ $c['wedding'] ?? 'Traditional Royal Heritage & Sherwanis' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @elseif($sec->section_type === 'family')
                            <div style="margin-bottom: 8px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Bride's Parents &amp; Hosts</label>
                                <input type="text" id="sec-fam-bride-{{ $sec->id }}" value="{{ $c['parents_bride'] ?? 'Mr. Suresh & Mrs. Sunita Sharma' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Groom's Parents &amp; Hosts</label>
                                <input type="text" id="sec-fam-groom-{{ $sec->id }}" value="{{ $c['parents_groom'] ?? 'Mr. Ramesh & Mrs. Kavita Verma' }}" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @elseif($sec->section_type === 'video')
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">YouTube or MP4 Video URL</label>
                                <input type="text" id="sec-video-url-{{ $sec->id }}" value="{{ $c['video_url'] ?? '' }}" placeholder="https://www.youtube.com/watch?v=..." class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
                            </div>
                            @endif

                            {{-- Card & Section Styling Overrides --}}
                            <div style="background: rgba(0,0,0,0.3); border: 1px dashed rgba(212,175,55,0.3); border-radius: 10px; padding: 12px; margin-top: 12px; margin-bottom: 12px;">
                                <div style="font-size: 11px; font-weight: 700; color: #D4AF37; text-transform: uppercase; margin-bottom: 8px;">🎨 Card Color &amp; Background Customization</div>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px;">
                                    <div>
                                        <label style="display: block; font-size: 10px; color: #94A3B8; margin-bottom: 4px;">Card Background Color</label>
                                        <input type="color" id="sec-card-bg-{{ $sec->id }}" value="{{ $s['card_bg_color'] ?? '#0F172A' }}" oninput="updateSectionStyle({{ $sec->id }}, '{{ $sec->section_type }}', this.value, document.getElementById('sec-card-border-{{ $sec->id }}').value, document.getElementById('sec-card-text-{{ $sec->id }}').value, document.getElementById('sec-bg-image-{{ $sec->id }}').value)" style="width: 100%; height: 34px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 10px; color: #94A3B8; margin-bottom: 4px;">Card Border Color</label>
                                        <input type="color" id="sec-card-border-{{ $sec->id }}" value="{{ $s['card_border_color'] ?? '#D4AF37' }}" oninput="updateSectionStyle({{ $sec->id }}, '{{ $sec->section_type }}', document.getElementById('sec-card-bg-{{ $sec->id }}').value, this.value, document.getElementById('sec-card-text-{{ $sec->id }}').value, document.getElementById('sec-bg-image-{{ $sec->id }}').value)" style="width: 100%; height: 34px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 8px;">
                                    <div>
                                        <label style="display: block; font-size: 10px; color: #94A3B8; margin-bottom: 4px;">Card Text Color</label>
                                        <input type="color" id="sec-card-text-{{ $sec->id }}" value="{{ $s['card_text_color'] ?? '#E2E8F0' }}" oninput="updateSectionStyle({{ $sec->id }}, '{{ $sec->section_type }}', document.getElementById('sec-card-bg-{{ $sec->id }}').value, document.getElementById('sec-card-border-{{ $sec->id }}').value, this.value, document.getElementById('sec-bg-image-{{ $sec->id }}').value)" style="width: 100%; height: 34px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); background: none; cursor: pointer;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 10px; color: #94A3B8; margin-bottom: 4px;">Card Style Preset</label>
                                        <select id="sec-card-style-{{ $sec->id }}" class="form-control" style="width: 100%; padding: 6px 8px; border-radius: 6px; background: #0F172A; border: 1px solid rgba(255,255,255,0.2); color: #FFF; font-size: 11px;">
                                            <option value="">Default Theme Card</option>
                                            <option value="gold-foil-border" {{ ($s['card_style'] ?? '') === 'gold-foil-border' ? 'selected' : '' }}>✨ Gold Foil Shimmer</option>
                                            <option value="glass-panel" {{ ($s['card_style'] ?? '') === 'glass-panel' ? 'selected' : '' }}>💎 Frosted Glass</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                        <label style="font-size: 10px; color: #94A3B8;">Section Card Background Image</label>
                                        <button type="button" onclick="triggerSectionImageUpload({{ $sec->id }})" style="background: none; border: none; font-size: 10px; color: var(--gold-primary); cursor: pointer; text-decoration: underline;">
                                            📁 Upload Card Photo
                                        </button>
                                    </div>
                                    <input type="text" id="sec-bg-image-{{ $sec->id }}" value="{{ $s['bg_image'] ?? '' }}" placeholder="Paste image URL or upload above..." class="form-control" oninput="updateSectionStyle({{ $sec->id }}, '{{ $sec->section_type }}', document.getElementById('sec-card-bg-{{ $sec->id }}').value, document.getElementById('sec-card-border-{{ $sec->id }}').value, document.getElementById('sec-card-text-{{ $sec->id }}').value, this.value)" style="width: 100%; padding: 6px 10px; border-radius: 6px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 11px;">
                                </div>
                            </div>

                            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 10px;">
                                <button type="button" id="btn-save-sec-{{ $sec->id }}" onclick="saveSectionParticulars({{ $sec->id }}, '{{ $sec->section_type }}')" class="btn-primary" style="padding: 7px 16px; font-size: 11px; font-weight: 700; border-radius: 6px;">
                                    <span>Save &amp; Update Live 💾</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('location')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to Location
                    </button>
                    <button type="button" onclick="goToTab('events')" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                        Continue: Events 📅 &rarr;
                    </button>
                </div>
            </div>

            {{-- TAB 5: EVENTS & ITINERARY --}}
            <div class="builder-tab-pane" id="tab-events">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin: 0;">Event Itinerary</h3>
                    <span style="font-size: 11px; color: var(--gold-primary); font-weight: 600;">{{ $invitation->events->count() }} Functions</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                    @foreach($invitation->events as $ev)
                    <div class="glass-panel" id="event-panel-{{ $ev->id }}" style="background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; overflow: hidden; padding: 0;">
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

                            <div style="margin-bottom: 8px;">
                                <label style="display: block; font-size: 10px; font-weight: 700; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">Venue Address</label>
                                <input type="text" id="ev-address-{{ $ev->id }}" value="{{ $ev->venue_address }}" placeholder="Street Address, City" class="form-control" style="width: 100%; padding: 7px 10px; border-radius: 8px; background: #0F172A; border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px;">
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

                            <button type="button" id="btn-save-event-{{ $ev->id }}" onclick="saveEventDetails({{ $ev->id }})" class="btn-primary" style="width: 100%; padding: 8px; font-size: 11px; font-weight: 700; border-radius: 8px;">
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

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('sections')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to Sections
                    </button>
                    <button type="button" onclick="goToTab('rsvp')" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                        Continue: RSVP 📝 &rarr;
                    </button>
                </div>
            </div>

            {{-- TAB 6: RSVP BUILDER --}}
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

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('events')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to Events
                    </button>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" id="btn-save-rsvp" onclick="saveRsvp()" class="btn-secondary" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                            💾 Save RSVP
                        </button>
                        <button type="button" id="btn-next-rsvp" onclick="saveRsvpAndNext()" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                            Save &amp; Continue: Media 🎵 &rarr;
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 7: MEDIA & MUSIC --}}
            <div class="builder-tab-pane" id="tab-media">
                <h3 style="font-size: 16px; font-weight: 700; color: #FFF; margin-bottom: 16px;">Audio &amp; Gallery Media</h3>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #94A3B8; margin-bottom: 6px;">Background Audio MP3 Track URL</label>
                    <input type="text" id="opt-music-url" value="{{ $invitation->music_url }}" placeholder="https://example.com/song.mp3" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                </div>

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('rsvp')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to RSVP
                    </button>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" id="btn-save-media" onclick="saveMedia()" class="btn-secondary" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                            💾 Save Media
                        </button>
                        <button type="button" id="btn-next-media" onclick="saveMediaAndNext()" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                            Save &amp; Continue: AI Studio 🪄 &rarr;
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 8: AI STUDIO --}}
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
                    <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('builder-ai-result-text').value); showToast('Copied to clipboard! 📋', 'success');" class="btn-secondary" style="padding: 6px 12px; font-size: 11px; width: 100%;">
                        📋 Copy Text to Clipboard
                    </button>
                </div>

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('media')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to Media
                    </button>
                    <button type="button" onclick="goToTab('publish')" class="btn-primary" style="padding: 10px 20px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                        Continue: Pricing &amp; Publish 💎 &rarr;
                    </button>
                </div>
            </div>

            {{-- TAB 9: PRICING & PUBLISH --}}
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

                {{-- Action Footer with Next Step --}}
                <div class="tab-action-footer">
                    <button type="button" onclick="goToTab('ai')" class="btn-secondary" style="padding: 10px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;">
                        &larr; Back to AI Studio
                    </button>
                    <a href="{{ route('invitations.checkout.index', $invitation->id) }}" class="btn-primary" style="padding: 10px 24px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                        <span>Proceed to Publish 🚀</span>
                    </a>
                </div>
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
    <script src="{{ asset('js/invitations-builder.js') }}?v={{ time() }}"></script>
    <script>
        function setBgTexture(url) {
            document.getElementById('opt-cover-image').value = url;
            const secColor = document.getElementById('opt-secondary-color')?.value || '#0F172A';
            const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 45) / 100;
            window.updatePageBg(secColor, url, opacityVal);
        }
    </script>
</body>
</html>
