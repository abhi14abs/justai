<?php

namespace App\Services\Invitations;

use App\Models\Invitations\InvitationCoupon;
use App\Models\Invitations\InvitationFeature;
use App\Models\Invitations\InvitationTemplate;

class InvitationPricingService
{
    /**
     * Calculate dynamic pricing breakdown for a template and selected features.
     */
    public function calculate(
        ?InvitationTemplate $template,
        array $selectedFeatureCodes = [],
        string $currency = 'INR',
        ?int $guestCapacity = null,
        ?string $couponCode = null
    ): array {
        $currency = in_array(strtoupper($currency), ['INR', 'USD']) ? strtoupper($currency) : 'INR';

        // 1. Base Template Price
        $templatePrice = 0.00;
        if ($template) {
            $templatePrice = $template->getPrice($currency);
        }

        // 2. Feature Add-ons Breakdown
        $featuresBreakdown = [];
        $featuresTotal = 0.00;

        if (!empty($selectedFeatureCodes)) {
            $features = InvitationFeature::whereIn('code', $selectedFeatureCodes)
                ->where('is_active', true)
                ->with(['prices' => function ($q) use ($currency) {
                    $q->where('currency', $currency);
                }])
                ->get();

            foreach ($features as $f) {
                $fPrice = $f->getPrice($currency, $guestCapacity);
                $featuresTotal += $fPrice;
                $featuresBreakdown[] = [
                    'code' => $f->code,
                    'name' => $f->name,
                    'icon' => $f->icon,
                    'price' => $fPrice,
                    'formatted_price' => $currency === 'INR' ? '₹' . number_format($fPrice, 2) : '$' . number_format($fPrice, 2),
                ];
            }
        }

        // 3. Subtotal before discount
        $subtotal = round($templatePrice + $featuresTotal, 2);

        // 4. Coupon Discount Calculation
        $discountAmount = 0.00;
        $appliedCoupon = null;

        if (!empty($couponCode)) {
            $coupon = InvitationCoupon::where('code', strtoupper(trim($couponCode)))
                ->where('is_active', true)
                ->first();

            if ($coupon && $coupon->isValid($subtotal)) {
                $discountAmount = $coupon->calculateDiscount($subtotal);
                $appliedCoupon = [
                    'code' => $coupon->code,
                    'discount_type' => $coupon->discount_type,
                    'discount_value' => (float) $coupon->discount_value,
                    'discount_amount' => $discountAmount,
                ];
            }
        }

        // 5. Taxes (e.g. 0% launch promo or 18% GST if applicable)
        $taxRate = 0.00; // 0% special launch fee
        $taxAmount = round(($subtotal - $discountAmount) * $taxRate, 2);

        // 6. Final Payable Amount (minimum 0.00)
        $finalAmount = max(round(($subtotal - $discountAmount) + $taxAmount, 2), 0.00);

        return [
            'currency' => $currency,
            'template_price' => $templatePrice,
            'features_total' => $featuresTotal,
            'features' => $featuresBreakdown,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'coupon' => $appliedCoupon,
            'tax_amount' => $taxAmount,
            'final_amount' => $finalAmount,
            'is_free' => $finalAmount <= 0.00,
            'formatted_subtotal' => $currency === 'INR' ? '₹' . number_format($subtotal, 2) : '$' . number_format($subtotal, 2),
            'formatted_discount' => $currency === 'INR' ? '₹' . number_format($discountAmount, 2) : '$' . number_format($discountAmount, 2),
            'formatted_final' => $currency === 'INR' ? '₹' . number_format($finalAmount, 2) : '$' . number_format($finalAmount, 2),
        ];
    }
}
