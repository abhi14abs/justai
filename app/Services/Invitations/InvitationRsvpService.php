<?php

namespace App\Services\Invitations;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationForm;
use App\Models\Invitations\InvitationFormResponse;
use App\Models\Invitations\InvitationGuest;
use App\Models\Invitations\InvitationGuestEvent;
use App\Models\Invitations\InvitationGuestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvitationRsvpService
{
    /**
     * Submit an RSVP response for a public invitation.
     */
    public function submitRsvp(Invitation $invitation, array $data, ?string $ipAddress = null): array
    {
        $form = $invitation->rsvpForm;
        if (!$form || !$form->is_active) {
            throw ValidationException::withMessages(['form' => 'RSVP is currently not accepting submissions for this invitation.']);
        }

        if ($form->deadline && $form->deadline->isPast()) {
            throw ValidationException::withMessages(['deadline' => 'The RSVP deadline for this celebration has passed.']);
        }

        return DB::transaction(function () use ($invitation, $form, $data, $ipAddress) {
            $guestName = trim($data['guest_name'] ?? '');
            $guestEmail = !empty($data['guest_email']) ? trim($data['guest_email']) : null;
            $guestPhone = !empty($data['guest_phone']) ? trim($data['guest_phone']) : null;
            $attendingStatus = $data['attending_status'] ?? 'attending';
            $partySize = max(intval($data['party_size'] ?? 1), 1);
            $dietary = $data['dietary_preferences'] ?? null;
            $notes = $data['notes'] ?? null;
            $answers = $data['answers'] ?? [];

            // Check if guest token provided (personalized guest invite)
            $guest = null;
            if (!empty($data['guest_code'])) {
                $guest = InvitationGuest::where('invitation_id', $invitation->id)
                    ->where('guest_code', $data['guest_code'])
                    ->first();
            }

            if (!$guest && !empty($guestEmail)) {
                $guest = InvitationGuest::where('invitation_id', $invitation->id)
                    ->where('email', $guestEmail)
                    ->first();
            }

            // Create or update guest
            if ($guest) {
                $guest->attending_status = $attendingStatus;
                $guest->allocated_seats = max($guest->allocated_seats, $partySize);
                if (!empty($guestPhone)) $guest->phone = $guestPhone;
                $guest->save();
            } else {
                $guest = InvitationGuest::create([
                    'invitation_id' => $invitation->id,
                    'name' => $guestName,
                    'email' => $guestEmail,
                    'phone' => $guestPhone,
                    'group_name' => 'Online RSVPs',
                    'allocated_seats' => $partySize,
                    'attending_status' => $attendingStatus,
                ]);
            }

            // Record Form Response
            $response = InvitationFormResponse::create([
                'form_id' => $form->id,
                'invitation_id' => $invitation->id,
                'guest_id' => $guest->id,
                'guest_name' => $guestName,
                'guest_email' => $guestEmail,
                'guest_phone' => $guestPhone,
                'attending_status' => $attendingStatus,
                'party_size' => $partySize,
                'dietary_preferences' => $dietary,
                'notes' => $notes,
                'answers' => $answers,
                'ip_address' => $ipAddress,
            ]);

            // Save answers to guest responses
            foreach ($answers as $fieldId => $ansVal) {
                InvitationGuestResponse::updateOrCreate([
                    'guest_id' => $guest->id,
                    'form_field_id' => $fieldId,
                ], [
                    'response_value' => is_array($ansVal) ? json_encode($ansVal) : (string) $ansVal,
                ]);
            }

            // Handle event specific selections if passed
            if (!empty($data['selected_events']) && is_array($data['selected_events'])) {
                foreach ($data['selected_events'] as $eventId) {
                    InvitationGuestEvent::updateOrCreate([
                        'guest_id' => $guest->id,
                        'event_id' => $eventId,
                        'invitation_id' => $invitation->id,
                    ], [
                        'is_invited' => true,
                        'attending_status' => 'confirmed',
                    ]);
                }
            }

            return [
                'success' => true,
                'response_id' => $response->id,
                'guest_code' => $guest->guest_code,
                'message' => $attendingStatus === 'attending'
                    ? 'Thank you! Your RSVP has been confirmed. We look forward to celebrating with you!'
                    : 'Thank you for letting us know. You will be warmly missed!',
            ];
        });
    }
}
