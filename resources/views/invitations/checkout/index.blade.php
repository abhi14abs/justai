@extends('layouts.app')

@section('title', 'Publish Invitation Checkout | CelebrateAI')

@section('content')
<div style="max-width: 920px; margin: 0 auto; padding: 40px 20px 80px;">

    {{-- Top Header --}}
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(212, 175, 55, 0.12); border: 1px solid rgba(212, 175, 55, 0.3); padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 700; color: var(--gold-primary); margin-bottom: 12px;">
            <span>⚡ Secure Instant Publishing</span>
            <span>•</span>
            <span>Razorpay Gateway</span>
        </div>
        <h1 style="font-size: 28px; font-weight: 800; color: #FFF; margin: 0 0 8px;">
            Publish &amp; Activate Digital Invitation
        </h1>
        <p style="color: var(--text-secondary); font-size: 14px; margin: 0;">
            {{ $invitation->title }}
        </p>
    </div>

    {{-- Currency / Origin Switcher Bar --}}
    <div class="glass-panel" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 14px 20px; border-radius: 16px; margin-bottom: 28px; border: 1px solid rgba(255,255,255,0.08);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">📍</span>
            <div>
                <div style="font-size: 13px; font-weight: 700; color: #FFF;">
                    Origin &amp; Currency: 
                    <span style="color: var(--gold-primary);">{{ $currency === 'INR' ? '🇮🇳 India (INR ₹)' : '🌐 International (USD $)' }}</span>
                </div>
                <div style="font-size: 11px; color: #94A3B8;">
                    Auto-configured for your location. You can switch currency below anytime.
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 8px; background: rgba(15,23,42,0.8); padding: 4px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('invitations.checkout.index', ['id' => $invitation->id, 'currency' => 'INR', 'coupon' => request('coupon')]) }}"
               style="padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $currency === 'INR' ? 'background: linear-gradient(135deg, #D4AF37, #B38F26); color: #000; box-shadow: 0 2px 8px rgba(212,175,55,0.3);' : 'color: #94A3B8;' }}">
                <span>🇮🇳</span>
                <span>INR (₹)</span>
            </a>
            <a href="{{ route('invitations.checkout.index', ['id' => $invitation->id, 'currency' => 'USD', 'coupon' => request('coupon')]) }}"
               style="padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $currency === 'USD' ? 'background: linear-gradient(135deg, #D4AF37, #B38F26); color: #000; box-shadow: 0 2px 8px rgba(212,175,55,0.3);' : 'color: #94A3B8;' }}">
                <span>🌐</span>
                <span>USD ($)</span>
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 32px;">
        
        {{-- Order Breakdown Card --}}
        <div class="glass-panel" style="padding: 28px; border-radius: 20px; border: 1px solid rgba(212, 175, 55, 0.3);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 18px; font-weight: 800; color: #FFF; margin: 0;">
                    Order Summary
                </h2>
                <span style="font-size: 12px; font-weight: 700; color: var(--gold-primary); background: rgba(212,175,55,0.1); padding: 4px 10px; border-radius: 8px;">
                    {{ $currency }}
                </span>
            </div>

            {{-- Template Item --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 12px;">
                <div>
                    <div style="font-size: 14px; font-weight: 700; color: #FFF;">{{ $invitation->template->name ?? 'Digital Invitation Template' }}</div>
                    <div style="font-size: 12px; color: #94A3B8;">Full animated mobile &amp; desktop design</div>
                </div>
                <div style="font-size: 15px; font-weight: 800; color: #FFF;">
                    {{ $pricing['currency'] === 'INR' ? '₹' . number_format($pricing['template_price'], 2) : '$' . number_format($pricing['template_price'], 2) }}
                </div>
            </div>

            {{-- Features Addons --}}
            @if(!empty($pricing['features']))
                @foreach($pricing['features'] as $f)
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span>{{ $f['icon'] ?? '✨' }}</span>
                        <span style="font-size: 13px; color: #E2E8F0;">{{ $f['name'] }}</span>
                    </div>
                    <div style="font-size: 13px; font-weight: 700; color: var(--gold-primary);">
                        {{ $f['formatted_price'] }}
                    </div>
                </div>
                @endforeach
            @endif

            {{-- Coupon Input --}}
            <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 16px; margin-top: 16px; margin-bottom: 16px;">
                <form action="{{ route('invitations.checkout.index', $invitation->id) }}" method="GET" style="display: flex; gap: 8px;">
                    <input type="hidden" name="currency" value="{{ $currency }}">
                    <input type="text" name="coupon" value="{{ request('coupon') }}" placeholder="Coupon Code (e.g. CELEBRATE50)" style="flex: 1; padding: 10px 14px; border-radius: 10px; background: rgba(15,23,42,0.8); border: 1px solid rgba(255,255,255,0.15); color: #FFF; font-size: 12px; text-transform: uppercase;">
                    <button type="submit" class="btn-secondary" style="padding: 10px 16px; font-size: 12px; font-weight: 700; border-radius: 10px;">Apply</button>
                </form>
            </div>

            {{-- Discount row if applied --}}
            @if($pricing['discount_amount'] > 0)
            <div style="display: flex; justify-content: space-between; font-size: 14px; color: #34D399; margin-bottom: 10px; font-weight: 700;">
                <span>Coupon Discount ({{ $pricing['coupon']['code'] }})</span>
                <span>-{{ $pricing['formatted_discount'] }}</span>
            </div>
            @endif

            {{-- Final Payable --}}
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 2px solid rgba(212,175,55,0.4); padding-top: 16px; margin-top: 16px;">
                <div>
                    <span style="font-size: 16px; font-weight: 800; color: #FFF; display: block;">Total Payable</span>
                    <span style="font-size: 11px; color: #94A3B8;">All taxes included</span>
                </div>
                <span style="font-size: 26px; font-weight: 900; color: var(--gold-primary);">{{ $pricing['formatted_final'] }}</span>
            </div>
        </div>

        {{-- Single Gateway Checkout Card --}}
        <div class="glass-panel" style="padding: 28px; border-radius: 20px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h2 style="font-size: 18px; font-weight: 800; color: #FFF; margin: 0 0 16px;">
                    Payment Method
                </h2>

                @if($pricing['is_free'])
                    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); padding: 18px; border-radius: 14px; margin-bottom: 24px; text-align: center;">
                        <div style="font-size: 16px; font-weight: 800; color: #34D399; margin-bottom: 4px;">🎉 100% Free Invitation!</div>
                        <div style="font-size: 12px; color: #A7F3D0;">No charge applied. Click below to publish immediately.</div>
                    </div>
                @else
                    {{-- Razorpay Exclusive Provider Card --}}
                    <div style="background: rgba(15, 23, 42, 0.85); border: 1.5px solid rgba(212, 175, 55, 0.5); padding: 20px; border-radius: 16px; margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: #0C2340; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #3399CC; font-size: 16px; border: 1px solid rgba(51, 153, 204, 0.4);">
                                    R
                                </div>
                                <div>
                                    <div style="font-weight: 800; color: #FFF; font-size: 15px;">Razorpay Secure Gateway</div>
                                    <div style="font-size: 11px; color: #94A3B8;">Official Payment Partner</div>
                                </div>
                            </div>
                            <span style="background: rgba(16, 185, 129, 0.15); color: #34D399; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                                Active
                            </span>
                        </div>

                        <div style="font-size: 12px; color: #CBD5E1; line-height: 1.6; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.08);">
                            @if($currency === 'INR')
                                <strong>Accepted in India (INR):</strong> UPI (Google Pay, PhonePe, Paytm, BHIM), Credit/Debit Cards (RuPay, Visa, Mastercard), NetBanking, &amp; Wallets.
                            @else
                                <strong>Accepted Internationally (USD):</strong> International Visa, MasterCard, American Express, &amp; Global Debit/Credit Cards.
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div>
                @if($pricing['is_free'])
                    <button type="button" id="main-pay-btn" onclick="initiatePayment('free_publish')" class="btn-primary" style="width: 100%; padding: 15px; font-size: 16px; font-weight: 800; border-radius: 14px;">
                        <span>Publish Invitation Now ✨</span>
                    </button>
                @else
                    <button type="button" id="main-pay-btn" onclick="initiatePayment('razorpay')" class="btn-primary" style="width: 100%; padding: 15px; font-size: 16px; font-weight: 800; border-radius: 14px; box-shadow: 0 4px 20px rgba(212,175,55,0.35);">
                        <span>Pay {{ $pricing['formatted_final'] }} with Razorpay 🚀</span>
                    </button>
                @endif

                <div style="margin-top: 18px; text-align: center; font-size: 11px; color: #64748B; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <span>🔒 256-bit SSL Encrypted Checkout</span>
                    <span>•</span>
                    <span>Instant Live Activation</span>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- Payment Success Modal --}}
<div id="payment-success-modal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.88); backdrop-filter: blur(12px); display: none; align-items: center; justify-content: center; z-index: 999999; padding: 20px;">
    <div class="glass-panel" style="max-width: 480px; width: 100%; padding: 32px; border-radius: 24px; text-align: center; background: #0B111E; border: 1px solid rgba(16, 185, 129, 0.4); box-shadow: 0 25px 60px rgba(0,0,0,0.85);">
        <div style="font-size: 54px; margin-bottom: 16px;">🎉</div>
        <div style="font-size: 11px; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: #10B981; margin-bottom: 6px;">Payment Successful</div>
        <h2 style="font-size: 22px; font-weight: 800; color: #FFF; margin: 0 0 12px;">Your Invitation is Now Live!</h2>
        <p style="font-size: 13px; color: #94A3B8; line-height: 1.6; margin-bottom: 20px;">
            Thank you! Your payment has been securely verified and your custom digital invitation is published to the web.
        </p>

        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px; margin-bottom: 24px; text-align: left; font-size: 12px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <span style="color: #94A3B8;">Order Reference:</span>
                <strong id="success-order-num" style="color: #FFF;">--</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #94A3B8;">Transaction ID:</span>
                <strong id="success-tx-ref" style="color: #D4AF37;">--</strong>
            </div>
        </div>

        <div style="display: flex; gap: 10px; flex-direction: column;">
            <a id="success-view-btn" href="#" class="btn-primary" style="padding: 13px; font-size: 14px; font-weight: 700; text-decoration: none; border-radius: 12px; text-align: center;">
                <span>View Live Invitation 🚀</span>
            </a>
            <a href="{{ route('invitations.dashboard.index') }}" class="btn-secondary" style="padding: 10px; font-size: 13px; text-decoration: none; border-radius: 10px; text-align: center;">
                Go to Invitations Dashboard
            </a>
        </div>
    </div>
</div>

{{-- Payment Failure / Cancellation Modal --}}
<div id="payment-failure-modal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.88); backdrop-filter: blur(12px); display: none; align-items: center; justify-content: center; z-index: 999999; padding: 20px;">
    <div class="glass-panel" style="max-width: 480px; width: 100%; padding: 32px; border-radius: 24px; text-align: center; background: #0B111E; border: 1px solid rgba(239, 68, 68, 0.4); box-shadow: 0 25px 60px rgba(0,0,0,0.85);">
        <div style="font-size: 50px; margin-bottom: 16px;">⚠️</div>
        <div style="font-size: 11px; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: #F87171; margin-bottom: 6px;" id="failure-modal-tag">Payment Incomplete</div>
        <h2 style="font-size: 20px; font-weight: 800; color: #FFF; margin: 0 0 12px;" id="failure-modal-title">Payment Could Not Be Completed</h2>
        <p style="font-size: 13px; color: #CBD5E1; line-height: 1.6; margin-bottom: 20px;" id="failure-modal-desc">
            The payment attempt was not completed. If your account was debited, your bank will automatically refund it within 24-48 hours.
        </p>

        <div id="failure-details-box" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 12px; padding: 12px; margin-bottom: 24px; text-align: left; font-size: 12px;">
            <div style="color: #FCA5A5;" id="failure-reason-text">Reason: Transaction was cancelled.</div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="button" onclick="closeFailureModal(); initiatePayment('razorpay');" class="btn-primary" style="flex: 1; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 12px;">
                <span>Retry Payment ⚡</span>
            </button>
            <button type="button" onclick="closeFailureModal()" class="btn-secondary" style="padding: 12px 18px; font-size: 13px; border-radius: 12px;">
                Dismiss
            </button>
        </div>
    </div>
</div>

{{-- Razorpay Standard Checkout Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    let currentOrderNumber = null;

    // Client-side Origin Check (if currency not explicitly set in URL)
    (function checkBrowserOrigin() {
        const urlParams = new URLSearchParams(window.location.search);
        if (!urlParams.has('currency')) {
            try {
                const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
                const isIndia = tz.includes('Calcutta') || tz.includes('Kolkata') || tz.includes('India');
                const currentCurrency = '{{ $currency }}';
                if (!isIndia && currentCurrency === 'INR') {
                    // Switch to USD for international browser timezone
                    urlParams.set('currency', 'USD');
                    window.location.search = urlParams.toString();
                }
            } catch (e) {
                // Ignore if timezone cannot be inspected
            }
        }
    })();

    function showSuccessModal(orderNumber, txRef, redirectUrl) {
        document.getElementById('success-order-num').innerText = orderNumber || '--';
        document.getElementById('success-tx-ref').innerText = txRef || '--';
        document.getElementById('success-view-btn').href = redirectUrl || '#';
        const modal = document.getElementById('payment-success-modal');
        if (modal) modal.style.display = 'flex';
    }

    function showFailureModal(title, description, reason) {
        document.getElementById('failure-modal-title').innerText = title || 'Payment Failed';
        document.getElementById('failure-modal-desc').innerText = description || 'The payment could not be completed.';
        document.getElementById('failure-reason-text').innerText = 'Reason: ' + (reason || 'Cancelled by user or bank decline');
        const modal = document.getElementById('payment-failure-modal');
        if (modal) modal.style.display = 'flex';
    }

    function closeFailureModal() {
        const modal = document.getElementById('payment-failure-modal');
        if (modal) modal.style.display = 'none';
    }

    function logPaymentFailure(orderNum, gateway, errCode, errDesc, paymentId) {
        fetch('{{ route("invitations.checkout.payment.failed", $invitation->id, false) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                order_number: orderNum,
                gateway: gateway,
                error_code: errCode,
                error_description: errDesc,
                payment_id: paymentId
            })
        }).catch(e => console.warn('Failure logging error:', e));
    }

    function initiatePayment(gateway = 'razorpay') {
        const payBtn = document.getElementById('main-pay-btn');
        if (payBtn) {
            payBtn.disabled = true;
            payBtn.innerHTML = '<span>⏳ Preparing Razorpay Checkout...</span>';
        }

        const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';

        fetch('{{ route("invitations.checkout.order.create", $invitation->id, false) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                gateway: gateway,
                currency: '{{ $currency }}',
                coupon: '{{ request("coupon") }}',
                timezone: tz
            })
        })
        .then(res => res.json())
        .then(data => {
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.innerHTML = '<span>Pay {{ $pricing["formatted_final"] }} with Razorpay 🚀</span>';
            }

            if (!data.success) {
                showFailureModal('Order Creation Failed', data.error || 'Failed to initialize payment gateway.');
                return;
            }

            currentOrderNumber = data.order_number;

            if (data.is_free) {
                showSuccessModal(data.order_number, 'FREE_PUBLISH', data.redirect_url);
                return;
            }

            if (data.gateway === 'razorpay') {
                let isPaymentSuccessful = false;

                const options = {
                    key: data.key_id,
                    amount: data.amount_paise,
                    currency: data.currency,
                    name: 'CelebrateAI Digital Invites',
                    description: 'Publish: {{ addslashes($invitation->title) }}',
                    handler: function(response) {
                        isPaymentSuccessful = true;
                        closeFailureModal();
                        verifyPayment(
                            'razorpay',
                            data.order_number,
                            response.razorpay_payment_id,
                            response.razorpay_signature,
                            response.razorpay_order_id || data.razorpay_order_id
                        );
                    },
                    modal: {
                        ondismiss: function() {
                            if (!isPaymentSuccessful) {
                                logPaymentFailure(data.order_number, 'razorpay', 'MODAL_DISMISSED', 'Customer closed the Razorpay payment window');
                                showFailureModal('Payment Incomplete', 'You closed the payment window without completing the transaction.', 'Payment modal was dismissed by customer.');
                            }
                        }
                    },
                    prefill: {
                        name: data.customer_name,
                        email: data.customer_email
                    },
                    theme: { color: '#D4AF37' }
                };

                if (data.razorpay_order_id) {
                    options.order_id = data.razorpay_order_id;
                }

                const rzp = new Razorpay(options);

                rzp.on('payment.failed', function (response) {
                    if (!isPaymentSuccessful) {
                        const err = response.error || {};
                        logPaymentFailure(
                            data.order_number,
                            'razorpay',
                            err.code || 'PAYMENT_FAILED',
                            err.description || 'Transaction failed',
                            err.metadata ? err.metadata.payment_id : null
                        );
                        showFailureModal(
                            'Payment Declined',
                            err.description || 'Your payment was declined by the bank or card issuer.',
                            (err.reason || err.code || 'Bank declined / invalid credentials')
                        );
                    }
                });

                rzp.open();
            }
        })
        .catch(err => {
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.innerHTML = '<span>Pay {{ $pricing["formatted_final"] }} with Razorpay 🚀</span>';
            }
            showFailureModal('Network / Server Error', 'Failed to connect to the payment server. Please check your internet connection.', err.message);
        });
    }

    function verifyPayment(gateway, orderNumber, paymentId, signature, orderId) {
        const payBtn = document.getElementById('main-pay-btn');
        if (payBtn) {
            payBtn.disabled = true;
            payBtn.innerHTML = '<span>⏳ Verifying Transaction with Razorpay...</span>';
        }

        fetch('{{ route("invitations.checkout.payment.verify", $invitation->id, false) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                gateway: gateway,
                order_number: orderNumber,
                gateway_payment_id: paymentId,
                gateway_signature: signature,
                gateway_order_id: orderId
            })
        })
        .then(res => res.json())
        .then(d => {
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.innerHTML = '<span>Pay {{ $pricing["formatted_final"] }} with Razorpay 🚀</span>';
            }
            if (d.success) {
                closeFailureModal();
                showSuccessModal(d.order_number, d.transaction_ref, d.redirect_url);
            } else {
                showFailureModal('Verification Failed', d.error || 'Payment signature mismatch.', 'Verification rejected by server.');
            }
        })
        .catch(err => {
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.innerHTML = '<span>Pay {{ $pricing["formatted_final"] }} with Razorpay 🚀</span>';
            }
            showFailureModal('Verification Error', 'Unable to complete verification on server. Please contact support.', err.message);
        });
    }
</script>
@endsection
