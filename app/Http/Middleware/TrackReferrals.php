<?php

namespace App\Http\Middleware;

use App\Models\Affiliate;
use App\Models\ReferralClick;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class TrackReferrals
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $refCode = $request->query('ref');

        if (!empty($refCode)) {
            $cleanCode = strtolower(trim($refCode));
            
            // Check if affiliate exists
            $affiliate = Affiliate::whereRaw('LOWER(affiliate_code) = ?', [$cleanCode])->first();

            if ($affiliate) {
                // Increment click counter
                $affiliate->increment('total_clicks');

                // Log click
                try {
                    ReferralClick::create([
                        'affiliate_id' => $affiliate->id,
                        'ip_address' => $request->ip(),
                        'referrer_url' => $request->header('referer'),
                        'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                    ]);
                } catch (\Throwable $e) {
                    // Ignore duplicate or logging errors
                }

                // Set 60-day cookie (60 days * 24 hrs * 60 mins = 86400 mins)
                Cookie::queue('postryx_ref_code', $affiliate->affiliate_code, 86400);
            }
        }

        return $next($request);
    }
}
