<?php

namespace App\Services\Invitations;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationGuest;
use App\Models\Invitations\InvitationGuestEvent;
use Illuminate\Support\Str;

class InvitationGuestService
{
    /**
     * Import guests from CSV string or array.
     */
    public function importCsv(Invitation $invitation, string $csvContent): array
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($csvContent));
        if (empty($lines)) {
            return ['imported' => 0, 'errors' => ['CSV is empty']];
        }

        $headers = str_getcsv(array_shift($lines));
        $headers = array_map(fn($h) => strtolower(trim($h)), $headers);

        $imported = 0;
        $errors = [];

        foreach ($lines as $lineIndex => $line) {
            if (empty(trim($line))) continue;
            $row = str_getcsv($line);
            if (count($row) === 0) continue;

            $data = [];
            foreach ($headers as $colIdx => $colName) {
                $data[$colName] = $row[$colIdx] ?? null;
            }

            $name = $data['name'] ?? $data['guest_name'] ?? $data['full_name'] ?? null;
            if (empty($name)) {
                $errors[] = "Row " . ($lineIndex + 2) . ": Name is missing.";
                continue;
            }

            $email = $data['email'] ?? $data['guest_email'] ?? null;
            $phone = $data['phone'] ?? $data['mobile'] ?? $data['phone_number'] ?? null;
            $group = $data['group'] ?? $data['group_name'] ?? 'General';
            $seats = intval($data['seats'] ?? $data['allocated_seats'] ?? $data['party_size'] ?? 1);
            $isVip = in_array(strtolower(trim($data['vip'] ?? $data['is_vip'] ?? '')), ['1', 'true', 'yes', 'y']);

            InvitationGuest::create([
                'invitation_id' => $invitation->id,
                'guest_code' => 'GST-' . strtoupper(Str::random(6)),
                'name' => trim($name),
                'email' => !empty($email) ? trim($email) : null,
                'phone' => !empty($phone) ? trim($phone) : null,
                'group_name' => trim($group),
                'allocated_seats' => max($seats, 1),
                'is_vip' => $isVip,
                'attending_status' => 'pending',
            ]);

            $imported++;
        }

        return ['imported' => $imported, 'errors' => $errors];
    }

    /**
     * Check in guest via QR code or guest token.
     */
    public function checkIn(Invitation $invitation, string $guestCode): array
    {
        $guest = InvitationGuest::where('invitation_id', $invitation->id)
            ->where('guest_code', strtoupper(trim($guestCode)))
            ->first();

        if (!$guest) {
            return [
                'success' => false,
                'message' => 'Invalid guest code or invitation pass.',
            ];
        }

        $alreadyCheckedIn = $guest->check_in_status;
        $guest->check_in_status = true;
        if (!$guest->checked_in_at) {
            $guest->checked_in_at = now();
        }
        $guest->save();

        return [
            'success' => true,
            'already_checked_in' => $alreadyCheckedIn,
            'guest' => [
                'name' => $guest->name,
                'group_name' => $guest->group_name,
                'allocated_seats' => $guest->allocated_seats,
                'is_vip' => $guest->is_vip,
                'checked_in_at' => $guest->checked_in_at->format('h:i A, M d'),
            ],
            'message' => $alreadyCheckedIn ? 'Guest was already checked in earlier.' : 'Welcome! Check-in successful.',
        ];
    }
}
