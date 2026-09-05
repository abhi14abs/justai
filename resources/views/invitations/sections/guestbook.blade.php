{{-- Guestbook, Wishes & Photo Memories Pool Section --}}
@php
    $content = $section->content ?? [];
    $settings = $section->settings ?? [];

    // Section Custom Card Styling Overrides
    $cardStyleAttr = '';
    if (!empty($settings['card_bg_color'])) $cardStyleAttr .= 'background-color: ' . $settings['card_bg_color'] . ' !important; ';
    if (!empty($settings['card_border_color'])) $cardStyleAttr .= 'border-color: ' . $settings['card_border_color'] . ' !important; ';
    if (!empty($settings['card_text_color'])) $cardStyleAttr .= 'color: ' . $settings['card_text_color'] . ' !important; ';
    if (!empty($settings['bg_image'])) $cardStyleAttr .= 'background-image: url(' . $settings['bg_image'] . '); background-size: cover; background-position: center; ';
@endphp

<section class="invitation-section" id="memories-section" data-section-type="guestbook">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--gold-primary); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ <span class="sec-title-display">{{ $section->title ?? 'Celebration Memories & Wishes' }}</span> ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 24px; color: var(--invite-heading, #FFF); margin: 0 0 6px; font-weight: 700;">
            <span class="sec-subtitle-display">{{ $section->subtitle ?? 'Share Your Blessings & Snapshots' }}</span>
        </h2>
        <p style="color: var(--invite-text-muted, #94A3B8); font-size: 13px; margin: 0;">
            Captured a special moment? Upload your photo to our live celebration wall!
        </p>
    </div>

    {{-- Photo Memories Grid --}}
    @php
        $guestMemories = $invitation->assets->where('asset_type', 'guest_memory');
    @endphp

    @if($guestMemories->count() > 0)
    <div id="memories-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 24px;">
        @foreach($guestMemories as $memory)
        <div class="event-card {{ $settings['card_style'] ?? '' }}" style="padding: 8px; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; {{ $cardStyleAttr }}">
            <div style="position: relative; padding-top: 100%; border-radius: 8px; overflow: hidden; background: #000;">
                <img src="{{ $memory->file_path }}" alt="{{ $memory->name }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="padding: 8px 4px 4px;">
                <div style="font-size: 12px; font-weight: 700; color: #FFF; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $memory->name }}
                </div>
                @if($memory->caption)
                <div style="font-size: 11px; color: #CBD5E1; font-style: italic; line-height: 1.3; margin-top: 2px;">
                    "{{ $memory->caption }}"
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Memory Upload Box --}}
    <div class="glass-panel" style="padding: 20px; border-radius: 16px; background: rgba(15,23,42,0.7); border: 1px dashed rgba(212,175,55,0.4); text-align: center;">
        <h3 style="font-size: 15px; font-weight: 700; color: #FFF; margin: 0 0 6px;">📸 Upload Your Photo &amp; Wish</h3>
        <p style="font-size: 12px; color: #94A3B8; margin: 0 0 16px;">
            Join our digital album by uploading a candid photo from the festivities!
        </p>

        <form id="public-memory-upload-form" onsubmit="handleMemoryUpload(event)" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 10px; text-align: left;">
                <input type="text" name="guest_name" id="mem-guest-name" value="{{ $guest?->name ?? '' }}" required placeholder="Your Name *" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                <input type="text" name="caption" id="mem-caption" placeholder="A heartfelt wish or caption..." style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 13px;">
                
                <div>
                    <label style="display: block; font-size: 11px; color: var(--gold-primary); font-weight: 600; margin-bottom: 4px;">Choose Photo (JPG / PNG / WebP)</label>
                    <input type="file" name="photo" id="mem-photo" accept="image/*" required style="width: 100%; padding: 8px; border-radius: 8px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #CBD5E1; font-size: 12px;">
                </div>

                <button type="submit" id="mem-upload-btn" class="wax-seal-btn" style="width: 100%; padding: 12px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; margin-top: 6px;">
                    <span>✨ Post to Celebration Wall</span>
                </button>
            </div>
        </form>
        <div id="mem-upload-status" style="display: none; margin-top: 12px; font-size: 13px; font-weight: 600;"></div>
    </div>
</section>

<script>
function handleMemoryUpload(e) {
    e.preventDefault();
    const form = document.getElementById('public-memory-upload-form');
    const statusDiv = document.getElementById('mem-upload-status');
    const btn = document.getElementById('mem-upload-btn');
    const formData = new FormData(form);

    btn.disabled = true;
    btn.innerHTML = '<span>⏳ Uploading photo...</span>';
    statusDiv.style.display = 'block';
    statusDiv.style.color = '#FBBF24';
    statusDiv.innerText = 'Uploading your memory...';

    fetch('{{ route("invitations.public.memories.upload", $invitation->slug, false) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<span>✨ Post to Celebration Wall</span>';
        if (data.success) {
            statusDiv.style.color = '#34D399';
            statusDiv.innerText = '✅ ' + data.message;
            form.reset();
            setTimeout(() => { window.location.reload(); }, 1500);
        } else {
            statusDiv.style.color = '#F87171';
            statusDiv.innerText = '❌ ' + (data.message || 'Error uploading photo.');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<span>✨ Post to Celebration Wall</span>';
        statusDiv.style.color = '#F87171';
        statusDiv.innerText = '❌ Failed to upload. Please check file size & try again.';
    });
}
</script>

