<?php

namespace App\Services\Invitations;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvitationAnalyticsService
{
    /**
     * Record an analytics event.
     */
    public function recordEvent(Invitation $invitation, string $eventType, ?Request $request = null, ?int $guestId = null, array $meta = []): void
    {
        try {
            $ip = $request ? $request->ip() : request()->ip();
            $userAgent = $request ? $request->userAgent() : request()->userAgent();
            $ipHash = $ip ? hash('sha256', $ip . date('Y-m-d')) : null;

            $deviceType = 'desktop';
            if ($userAgent) {
                if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
                    $deviceType = 'tablet';
                } elseif (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile|iphone)/i', $userAgent)) {
                    $deviceType = 'mobile';
                }
            }

            InvitationAnalytics::create([
                'invitation_id' => $invitation->id,
                'event_type' => $eventType,
                'guest_id' => $guestId,
                'ip_hash' => $ipHash,
                'user_agent' => substr($userAgent ?? '', 0, 500),
                'device_type' => $deviceType,
                'referrer' => substr($request?->header('referer') ?? '', 0, 500),
                'meta' => $meta,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Non-blocking background analytics
        }
    }

    /**
     * Get aggregated analytics metrics for an invitation dashboard.
     */
    public function getMetrics(Invitation $invitation): array
    {
        $totalViews = InvitationAnalytics::where('invitation_id', $invitation->id)
            ->where('event_type', 'page_view')
            ->count();

        $uniqueVisitors = InvitationAnalytics::where('invitation_id', $invitation->id)
            ->where('event_type', 'page_view')
            ->distinct('ip_hash')
            ->count('ip_hash');

        $totalRsvps = $invitation->formResponses()->count();
        $attendingCount = $invitation->formResponses()->where('attending_status', 'attending')->sum('party_size');
        $declinedCount = $invitation->formResponses()->where('attending_status', 'declined')->count();

        $qrScans = InvitationAnalytics::where('invitation_id', $invitation->id)
            ->where('event_type', 'qr_scan')
            ->count();

        $conversionRate = $uniqueVisitors > 0 ? round(($totalRsvps / $uniqueVisitors) * 100, 1) : 0;

        // Device breakdown
        $deviceBreakdown = InvitationAnalytics::where('invitation_id', $invitation->id)
            ->where('event_type', 'page_view')
            ->select('device_type', DB::raw('count(*) as total'))
            ->groupBy('device_type')
            ->pluck('total', 'device_type')
            ->toArray();

        // Recent 7 days timeline
        $timeline = InvitationAnalytics::where('invitation_id', $invitation->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'total_rsvps' => $totalRsvps,
            'attending_guests' => $attendingCount,
            'declined_guests' => $declinedCount,
            'conversion_rate' => $conversionRate,
            'qr_scans' => $qrScans,
            'device_breakdown' => [
                'mobile' => $deviceBreakdown['mobile'] ?? 0,
                'desktop' => $deviceBreakdown['desktop'] ?? 0,
                'tablet' => $deviceBreakdown['tablet'] ?? 0,
            ],
            'timeline' => $timeline,
        ];
    }
}
