{{-- RSVP Form Section --}}
@php
    $form = $invitation->rsvpForm;
    $guest = $guest ?? null;
@endphp

<section class="invitation-section" id="section-rsvp">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="font-size: 11px; letter-spacing: 0.18em; color: var(--invite-primary, #D4AF37); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">
            ✦ {{ $section->title ?? 'Kindly Respond' }} ✦
        </div>
        <h2 style="font-family: var(--font-serif-lux); font-size: 26px; color: var(--invite-heading, #FFFFFF); margin: 0; font-weight: 700;">
            {{ $section->subtitle ?? 'Please Confirm Your Attendance' }}
        </h2>
    </div>

    @if($form && $form->is_active)
    <div id="rsvp-form-container" class="glass-panel gold-foil-border" style="padding: 28px 24px; border-radius: 24px; background: var(--invite-card-bg, rgba(11, 17, 30, 0.85)); border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.3)); box-shadow: 0 15px 35px rgba(0,0,0,0.12);">
        
        @if($guest)
        <div style="background: var(--invite-pill-bg, rgba(212, 175, 55, 0.15)); border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.4)); padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; color: var(--invite-heading, #FFF); display: flex; align-items: center; gap: 8px;">
            <span>👋</span>
            <span>Welcome, <strong>{{ $guest->name }}</strong>! (Allocated seats: <strong>{{ $guest->allocated_seats }}</strong>)</span>
        </div>
        @endif

        <form action="{{ route('invitations.public.rsvp', $invitation->slug) }}" method="POST" onsubmit="handleRsvpSubmit(event, this)">
            @csrf
            <input type="hidden" name="guest_code" value="{{ $guest?->guest_code ?? request('g') }}">

            {{-- Guest Full Name --}}
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--invite-heading, #E2E8F0); margin-bottom: 6px;">
                    Your Full Name <span style="color: #F87171;">*</span>
                </label>
                <input type="text" name="guest_name" value="{{ $guest?->name ?? '' }}" required placeholder="e.g. Rajesh Sharma & Family" class="form-control" style="width: 100%; padding: 12px 16px; border-radius: 12px; background: var(--invite-input-bg, rgba(15, 23, 42, 0.8)); border: 1px solid var(--invite-input-border, rgba(255, 255, 255, 0.15)); color: var(--invite-input-text, #FFF); font-size: 14px;">
            </div>

            {{-- Guest Email / Phone --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 18px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--invite-text-muted, #94A3B8); margin-bottom: 6px;">Email Address</label>
                    <input type="email" name="guest_email" value="{{ $guest?->email ?? '' }}" placeholder="vikram@example.com" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 12px; background: var(--invite-input-bg, rgba(15, 23, 42, 0.8)); border: 1px solid var(--invite-input-border, rgba(255, 255, 255, 0.15)); color: var(--invite-input-text, #FFF); font-size: 13px;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--invite-text-muted, #94A3B8); margin-bottom: 6px;">Phone / WhatsApp</label>
                    <input type="tel" name="guest_phone" value="{{ $guest?->phone ?? '' }}" placeholder="+91 98765 43210" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 12px; background: var(--invite-input-bg, rgba(15, 23, 42, 0.8)); border: 1px solid var(--invite-input-border, rgba(255, 255, 255, 0.15)); color: var(--invite-input-text, #FFF); font-size: 13px;">
                </div>
            </div>

            {{-- Attendance Status Radios --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--invite-heading, #E2E8F0); margin-bottom: 8px;">
                    Will you be joining the celebration? <span style="color: #F87171;">*</span>
                </label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; background: var(--invite-pill-bg, rgba(15, 23, 42, 0.6)); border: 1px solid var(--invite-card-border, rgba(212, 175, 55, 0.3)); cursor: pointer; color: var(--invite-heading, #FFF); font-size: 13px;">
                        <input type="radio" name="attending_status" value="attending" checked style="accent-color: var(--invite-primary, #D4AF37);">
                        <span>🎉 Joyfully Accept (Attending)</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; background: var(--invite-pill-bg, rgba(15, 23, 42, 0.6)); border: 1px solid var(--invite-card-border, rgba(255, 255, 255, 0.1)); cursor: pointer; color: var(--invite-text-muted, #CBD5E1); font-size: 13px;">
                        <input type="radio" name="attending_status" value="declined" style="accent-color: var(--invite-primary, #D4AF37);">
                        <span>💌 Regretfully Decline</span>
                    </label>
                </div>
            </div>

            {{-- Party Size --}}
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--invite-heading, #E2E8F0); margin-bottom: 6px;">Total Guests Attending</label>
                <input type="number" name="party_size" value="{{ $guest?->allocated_seats ?? 1 }}" min="1" max="{{ $form->max_party_size ?? 10 }}" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 12px; background: var(--invite-input-bg, rgba(15, 23, 42, 0.8)); border: 1px solid var(--invite-input-border, rgba(255, 255, 255, 0.15)); color: var(--invite-input-text, #FFF); font-size: 14px;">
            </div>

            {{-- Dynamic Form Fields --}}
            @foreach($form->fields as $field)
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--invite-heading, #E2E8F0); margin-bottom: 6px;">
                    {{ $field->label }} @if($field->is_required)<span style="color: #F87171;">*</span>@endif
                </label>

                @if($field->field_type === 'text')
                    <input type="text" name="answers[{{ $field->id }}]" placeholder="{{ $field->placeholder }}" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 12px; background: var(--invite-input-bg, rgba(15, 23, 42, 0.8)); border: 1px solid var(--invite-input-border, rgba(255, 255, 255, 0.15)); color: var(--invite-input-text, #FFF); font-size: 13px;" @if($field->is_required) required @endif>
                @elseif($field->field_type === 'textarea')
                    <textarea name="answers[{{ $field->id }}]" rows="2" placeholder="{{ $field->placeholder }}" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 12px; background: var(--invite-input-bg, rgba(15, 23, 42, 0.8)); border: 1px solid var(--invite-input-border, rgba(255, 255, 255, 0.15)); color: var(--invite-input-text, #FFF); font-size: 13px;" @if($field->is_required) required @endif></textarea>
                @elseif($field->field_type === 'dropdown' && is_array($field->options))
                    <select name="answers[{{ $field->id }}]" class="form-control" style="width: 100%; padding: 10px 14px; border-radius: 12px; background: var(--invite-input-bg, #0F172A); border: 1px solid var(--invite-input-border, rgba(255, 255, 255, 0.15)); color: var(--invite-input-text, #FFF); font-size: 13px;" @if($field->is_required) required @endif>
                        <option value="">-- Please Select --</option>
                        @foreach($field->options as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                @elseif($field->field_type === 'checkbox' && is_array($field->options))
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        @foreach($field->options as $opt)
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--invite-text, #CBD5E1); cursor: pointer;">
                            <input type="checkbox" name="answers[{{ $field->id }}][]" value="{{ $opt }}" style="accent-color: var(--invite-primary, #D4AF37);">
                            <span>{{ $opt }}</span>
                        </label>
                        @endforeach
                    </div>
                @endif
            </div>
            @endforeach

            {{-- Submit Button --}}
            <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; font-size: 15px; font-weight: 700; border-radius: 14px; cursor: pointer; margin-top: 8px;">
                <span>Confirm RSVP ✨</span>
            </button>
        </form>

    </div>

    {{-- RSVP Success State --}}
    <div id="rsvp-success-container" class="glass-panel" style="display: none; padding: 36px 24px; border-radius: 24px; text-align: center; border: 1px solid rgba(16, 185, 129, 0.4); background: rgba(6, 78, 59, 0.4);">
        <div style="font-size: 48px; margin-bottom: 16px;">🎉</div>
        <h3 style="font-family: var(--font-serif-lux); font-size: 22px; color: #FFF; margin-bottom: 8px; font-weight: 700;">
            RSVP Confirmed!
        </h3>
        <p id="rsvp-success-msg" style="font-size: 14px; color: #A7F3D0; line-height: 1.6; margin-bottom: 20px;">
            Thank you! Your response has been recorded. We eagerly look forward to welcoming you!
        </p>
        <button type="button" onclick="shareInvitation('whatsapp')" class="btn-secondary" style="padding: 10px 20px; font-size: 13px; border-radius: 10px;">
            <span>Share on WhatsApp 💬</span>
        </button>
    </div>
    @else
    <div style="text-align: center; color: var(--invite-text-muted, #94A3B8); font-size: 14px; padding: 24px;">
        RSVP is currently closed.
    </div>
    @endif
</section>
