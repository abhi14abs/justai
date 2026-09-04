<?php

namespace App\Services\Invitations;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationEvent;
use App\Models\Invitations\InvitationForm;
use App\Models\Invitations\InvitationFormField;
use App\Models\Invitations\InvitationQrCode;
use App\Models\Invitations\InvitationSection;
use App\Models\Invitations\InvitationTemplate;
use Illuminate\Support\Str;

class InvitationTemplateService
{
    /**
     * Initialize a new invitation from a template with default sections and forms.
     */
    public function createFromTemplate(InvitationTemplate $template, int $userId, array $overrides = []): Invitation
    {
        return $this->createInvitationFromTemplate($template, $userId, $overrides);
    }

    /**
     * Alias for createFromTemplate.
     */
    public function createInvitationFromTemplate(InvitationTemplate $template, int $userId, array $overrides = []): Invitation
    {
        $themeConfig = $template->theme_config ?? [];

        $invitation = Invitation::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $userId,
            'template_id' => $template->id,
            'title' => $overrides['title'] ?? ($template->name . ' Celebration'),
            'slug' => Str::slug($overrides['title'] ?? $template->name) . '-' . Str::lower(Str::random(6)),
            'cover_image' => $overrides['cover_image'] ?? $template->thumbnail_url,
            'event_date' => $overrides['event_date'] ?? now()->addMonths(2)->setTime(18, 0),
            'status' => 'draft',
            'primary_color' => $overrides['primary_color'] ?? ($themeConfig['primary_color'] ?? '#D4AF37'),
            'secondary_color' => $overrides['secondary_color'] ?? ($themeConfig['secondary_color'] ?? '#0F172A'),
            'accent_color' => $overrides['accent_color'] ?? ($themeConfig['accent_color'] ?? '#F59E0B'),
            'font_family_heading' => $overrides['font_family_heading'] ?? ($themeConfig['font_family_heading'] ?? 'Playfair Display'),
            'font_family_body' => $overrides['font_family_body'] ?? ($themeConfig['font_family_body'] ?? 'Outfit'),
            'animation_style' => $overrides['animation_style'] ?? ($themeConfig['animation_style'] ?? 'luxury_fade'),
            'selected_features' => $overrides['selected_features'] ?? ($template->features_included ?? ['rsvp_custom_form', 'multi_event_timeline']),
        ]);

        // 1. Create Sections from Template Sections
        $templateSections = $template->sections;
        foreach ($templateSections as $tSec) {
            InvitationSection::create([
                'invitation_id' => $invitation->id,
                'section_type' => $tSec->section_type,
                'title' => $tSec->default_title,
                'subtitle' => $tSec->default_subtitle,
                'content' => $tSec->default_content ?? [],
                'settings' => $tSec->default_settings ?? [],
                'sort_order' => $tSec->sort_order,
                'is_enabled' => true,
            ]);
        }

        // 2. Create Events (from Sample Invitation if available or Default)
        $sampleInvite = Invitation::where('template_id', $template->id)->where('status', 'published')->first();
        if ($sampleInvite && $sampleInvite->events->count() > 0) {
            foreach ($sampleInvite->events as $sEvt) {
                InvitationEvent::create([
                    'invitation_id' => $invitation->id,
                    'title' => $sEvt->title,
                    'event_date' => $sEvt->event_date,
                    'start_time' => $sEvt->start_time,
                    'end_time' => $sEvt->end_time,
                    'venue_name' => $sEvt->venue_name,
                    'venue_address' => $sEvt->venue_address,
                    'dress_code' => $sEvt->dress_code,
                    'icon' => $sEvt->icon,
                    'sort_order' => $sEvt->sort_order,
                ]);
            }
        } else {
            InvitationEvent::create([
                'invitation_id' => $invitation->id,
                'title' => 'Grand Celebration & Ceremony',
                'event_date' => now()->addMonths(2)->toDateString(),
                'start_time' => '18:00:00',
                'end_time' => '23:00:00',
                'venue_name' => 'The Grand Ballroom & Lawn',
                'venue_address' => 'Palace Road, City Center',
                'dress_code' => 'Traditional / Festive Elegance',
                'icon' => '✨',
                'sort_order' => 1,
            ]);
        }

        // 3. Create Default RSVP Form
        $form = InvitationForm::create([
            'invitation_id' => $invitation->id,
            'title' => $sampleInvite?->rsvpForm?->title ?? 'Kindly RSVP to Our Celebration',
            'description' => $sampleInvite?->rsvpForm?->description ?? ('Please confirm your attendance by ' . now()->addMonths(1)->format('F d, Y')),
            'deadline' => now()->addMonths(1)->setTime(23, 59),
            'max_party_size' => 5,
            'allow_guest_plus_one' => true,
            'is_active' => true,
        ]);

        if ($sampleInvite && $sampleInvite->rsvpForm && $sampleInvite->rsvpForm->fields->count() > 0) {
            foreach ($sampleInvite->rsvpForm->fields as $sFld) {
                InvitationFormField::create([
                    'form_id' => $form->id,
                    'field_type' => $sFld->field_type,
                    'label' => $sFld->label,
                    'placeholder' => $sFld->placeholder,
                    'options' => $sFld->options,
                    'is_required' => $sFld->is_required,
                    'sort_order' => $sFld->sort_order,
                ]);
            }
        } else {
            InvitationFormField::create([
                'form_id' => $form->id,
                'field_type' => 'radio',
                'label' => 'Will you be attending?',
                'options' => ['Accepts with Pleasure', 'Declines with Regret'],
                'is_required' => true,
                'sort_order' => 1,
            ]);

            InvitationFormField::create([
                'form_id' => $form->id,
                'field_type' => 'number',
                'label' => 'Number of guests attending',
                'placeholder' => '1',
                'is_required' => true,
                'sort_order' => 2,
            ]);
        }

        // 4. Create Initial QR Code
        InvitationQrCode::create([
            'invitation_id' => $invitation->id,
            'qr_type' => 'invitation_link',
            'target_url' => url('/i/' . $invitation->slug),
            'code_string' => 'INV-' . strtoupper(Str::random(8)),
            'foreground_color' => $invitation->primary_color,
            'background_color' => '#FFFFFF',
        ]);

        // Increment use_count
        $template->increment('use_count');

        return $invitation;
    }

    /**
     * Duplicate an existing invitation.
     */
    public function duplicate(Invitation $original, int $userId): Invitation
    {
        $clone = $original->replicate(['uuid', 'slug', 'status']);
        $clone->uuid = (string) Str::uuid();
        $clone->user_id = $userId;
        $clone->title = $original->title . ' (Copy)';
        $clone->slug = Str::slug($clone->title) . '-' . Str::lower(Str::random(6));
        $clone->status = 'draft';
        $clone->save();

        // Duplicate sections
        foreach ($original->sections as $sec) {
            $newSec = $sec->replicate();
            $newSec->invitation_id = $clone->id;
            $newSec->save();
        }

        // Duplicate events
        foreach ($original->events as $ev) {
            $newEv = $ev->replicate();
            $newEv->invitation_id = $clone->id;
            $newEv->save();
        }

        // Duplicate RSVP form & fields
        if ($original->rsvpForm) {
            $newForm = $original->rsvpForm->replicate();
            $newForm->invitation_id = $clone->id;
            $newForm->save();

            foreach ($original->rsvpForm->fields as $f) {
                $newF = $f->replicate();
                $newF->form_id = $newForm->id;
                $newF->save();
            }
        }

        return $clone;
    }
}
