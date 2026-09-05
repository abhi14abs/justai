@extends('layouts.app')

@section('title', 'Secure Checkout — Upgrade to ' . $planName . ' | Postryx AI')
@section('meta_description', 'Complete your secure checkout for Postryx AI. Pay securely with Razorpay (UPI, Cards, NetBanking, and Global Cards) with instant plan activation.')

@section('content')

<section style="padding: 50px 24px 80px; max-width: 1000px; margin: 0 auto;">
    
    {{-- Top Header --}}
    <div style="text-align: center; margin-bottom: 32px;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(99, 102, 241, 0.12); border: 1px solid rgba(99, 102, 241, 0.3); padding: 6px 16px; border-radius: 999px; font-size: 12px; font-weight: 700; color: #818CF8; margin-bottom: 12px;">
            <span>🔒 256-Bit SSL Encrypted Checkout</span>
            <span>•</span>
            <span>Razorpay Secure Gateway</span>
        </div>
        <h1 style="font-size: clamp(28px, 4.5vw, 42px); font-weight: 800; color: #fff; margin: 0 0 8px;">
            Upgrade to <span class="gradient-text">{{ $planName }}</span>
        </h1>
        <p style="color: var(--text-secondary); font-size: 15px; margin: 0;">Instant access to unlimited generations, AI humanizer, and priority model speeds.</p>
    </div>

    {{-- Currency / Origin Switcher Bar --}}
    <div class="glass-panel" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 14px 20px; border-radius: 16px; margin-bottom: 28px; border: 1px solid rgba(255,255,255,0.08);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 20px;">📍</span>
            <div>
                <div style="font-size: 13px; font-weight: 700; color: #FFF;">
                    Detected Origin &amp; Currency: 
                    <span style="color: #38BDF8;">{{ $currency === 'INR' ? '🇮🇳 India (INR ₹)' : '🌐 International (USD $)' }}</span>
                </div>
                <div style="font-size: 11px; color: #94A3B8;">
                    Pricing automatically adapted for your region. You can switch anytime.
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 8px; background: rgba(15,23,42,0.8); padding: 4px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
            <a href="{{ route('checkout', ['plan' => $plan, 'currency' => 'INR', 'billing' => $billing]) }}"
               style="padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $currency === 'INR' ? 'background: linear-gradient(135deg, #6366F1, #4F46E5); color: #FFF; box-shadow: 0 2px 10px rgba(99,102,241,0.4);' : 'color: #94A3B8;' }}">
                <span>🇮🇳</span>
                <span>INR (₹)</span>
            </a>
            <a href="{{ route('checkout', ['plan' => $plan, 'currency' => 'USD', 'billing' => $billing]) }}"
               style="padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ $currency === 'USD' ? 'background: linear-gradient(135deg, #6366F1, #4F46E5); color: #FFF; box-shadow: 0 2px 10px rgba(99,102,241,0.4);' : 'color: #94A3B8;' }}">
                <span>🌐</span>
                <span>USD ($)</span>
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 32px; align-items: flex-start;">
        
        {{-- Left Column: Customer & Payment Details --}}
        <div class="glass-panel" style="padding: 30px; border-radius: 20px;">
            <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px; display: flex; align-items: center; gap: 8px;">
                <span class="badge-pill" style="padding: 2px 8px; font-size: 11px;">1</span> Account &amp; Billing Info
            </h3>

            <form id="checkout-form" onsubmit="event.preventDefault(); initiateCheckout();" style="display: flex; flex-direction: column; gap: 18px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Your Full Name:</label>
                    <input type="text" id="cust-name" class="postryx-input" placeholder="e.g. Alex Johnson" value="{{ Auth::check() ? Auth::user()->name : '' }}" required style="padding: 12px 14px;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Email Address (For Account &amp; Receipt):</label>
                    <input type="email" id="cust-email" class="postryx-input" placeholder="e.g. name@company.com" value="{{ Auth::check() ? Auth::user()->email : '' }}" required style="padding: 12px 14px;">
                </div>

                <div style="margin-top: 4px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 10px;">
                        <span class="badge-pill" style="padding: 2px 8px; font-size: 11px; margin-right: 4px;">2</span> Payment Method:
                    </label>
                    
                    {{-- Razorpay Single Exclusive Gateway Box --}}
                    <div style="background: rgba(15, 23, 42, 0.85); border: 1.5px solid rgba(99, 102, 241, 0.5); padding: 18px; border-radius: 16px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: #0C2340; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #3399CC; font-size: 17px; border: 1px solid rgba(51, 153, 204, 0.4);">
                                    R
                                </div>
                                <div>
                                    <div style="font-weight: 800; color: #FFF; font-size: 15px;">Razorpay Gateway</div>
                                    <div style="font-size: 11px; color: #94A3B8;">Official Payment Partner</div>
                                </div>
                            </div>
                            <span style="background: rgba(16, 185, 129, 0.15); color: #34D399; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                                Active
                            </span>
                        </div>

                        <div style="font-size: 12px; color: #CBD5E1; line-height: 1.6; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.08);">
                            @if($currency === 'INR')
                                <strong>Accepted in India (INR):</strong> UPI (Google Pay, PhonePe, Paytm, BHIM), RuPay/Visa/Mastercard, NetBanking, &amp; Wallets.
                            @else
                                <strong>Accepted Internationally (USD):</strong> International Visa, MasterCard, American Express, &amp; Global Debit/Credit Cards.
                            @endif
                        </div>
                    </div>
                </div>

                {{-- General Pay Button --}}
                <button type="submit" id="pay-submit-btn" class="btn-primary" style="margin-top: 8px; padding: 15px; font-size: 16px; font-weight: 800; border-radius: 14px; width: 100%; box-shadow: 0 4px 20px rgba(99,102,241,0.35);">
                    <span>Pay {{ $currency === 'INR' ? '₹' : '$' }}{{ number_format($finalPrice, 2) }} with Razorpay 🔒</span>
                </button>
            </form>

            <div style="margin-top: 16px; text-align: center; font-size: 11px; color: #64748B;">
                🔒 Bank-grade 256-bit encryption. Instant plan activation.
            </div>
        </div>

        {{-- Right Column: Order Summary --}}
        <div class="glass-panel-glow" style="padding: 30px; border-radius: 20px;">
            <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px;">Order Summary</h3>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 14px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 14px;">
                <div>
                    <div style="font-weight: 800; color: #fff; font-size: 16px;">{{ $planName }}</div>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Billing: {{ ucfirst($billing) }}</div>
                </div>
                <div style="font-weight: 800; color: #fff; font-size: 17px;">
                    {{ $currency === 'INR' ? '₹' : '$' }}{{ number_format($basePrice, 2) }}
                </div>
            </div>

            {{-- Discount Row --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 14px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 14px; color: #10B981;">
                <div>
                    <div style="font-weight: 700; font-size: 13px;">Launch Promo Discount (50%)</div>
                    <div style="font-size: 11px; color: #6EE7B7;">Code: LAUNCH50 Applied</div>
                </div>
                <div style="font-weight: 800; font-size: 15px;">
                    -{{ $currency === 'INR' ? '₹' : '$' }}{{ number_format($discountAmount, 2) }}
                </div>
            </div>

            {{-- Affiliate Referral Notice --}}
            @if(!empty($refCode))
            <div style="background: rgba(99,102,241,0.12); border: 1px dashed rgba(99,102,241,0.4); border-radius: 10px; padding: 12px; font-size: 12px; color: #c7d2fe; margin-bottom: 16px;">
                🎁 Referred by <strong>{{ $refCode }}</strong> (30% partner tracking active)
            </div>
            @endif

            {{-- Total Amount Row --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 20px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 20px;">
                <div style="font-size: 16px; font-weight: 800; color: #fff;">Total Due Today:</div>
                <div style="font-size: 30px; font-weight: 900; color: #38BDF8;">
                    {{ $currency === 'INR' ? '₹' : '$' }}{{ number_format($finalPrice, 2) }}
                </div>
            </div>

            {{-- Guarantee Badges --}}
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: var(--text-secondary);">
                <li style="display: flex; gap: 10px; align-items: center;"><span style="color:#10B981; font-weight: 700;">✓</span> 14-Day 100% Money-Back Guarantee</li>
                <li style="display: flex; gap: 10px; align-items: center;"><span style="color:#10B981; font-weight: 700;">✓</span> Instant Plan Activation &amp; Unlimited API Access</li>
                <li style="display: flex; gap: 10px; align-items: center;"><span style="color:#10B981; font-weight: 700;">✓</span> Cancel Anytime with Zero Lock-in</li>
            </ul>
        </div>

    </div>

</section>

{{-- Payment Success Modal --}}
<div id="payment-success-modal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.88); backdrop-filter: blur(12px); display: none; align-items: center; justify-content: center; z-index: 999999; padding: 20px;">
    <div class="glass-panel" style="max-width: 480px; width: 100%; padding: 32px; border-radius: 24px; text-align: center; background: #0B111E; border: 1px solid rgba(16, 185, 129, 0.4); box-shadow: 0 25px 60px rgba(0,0,0,0.85);">
        <div style="font-size: 54px; margin-bottom: 16px;">🎉</div>
        <div style="font-size: 11px; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: #10B981; margin-bottom: 6px;">Payment Successful</div>
        <h2 style="font-size: 22px; font-weight: 800; color: #FFF; margin: 0 0 12px;">Welcome to {{ $planName }}!</h2>
        <p style="font-size: 13px; color: #94A3B8; line-height: 1.6; margin-bottom: 20px;">
            Thank you! Your payment has been verified by Razorpay and your plan is activated with full access.
        </p>

        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px; margin-bottom: 24px; text-align: left; font-size: 12px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <span style="color: #94A3B8;">Order Reference:</span>
                <strong id="success-order-num" style="color: #FFF;">--</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #94A3B8;">Transaction ID:</span>
                <strong id="success-tx-ref" style="color: #38BDF8;">--</strong>
            </div>
        </div>

        <a id="success-redirect-btn" href="{{ url('/dashboard') }}" class="btn-primary" style="display: block; padding: 13px; font-size: 14px; font-weight: 700; text-decoration: none; border-radius: 12px; text-align: center;">
            <span>Go to Your Dashboard 🚀</span>
        </a>
    </div>
</div>

{{-- Payment Failure / Cancellation Modal --}}
<div id="payment-failure-modal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.88); backdrop-filter: blur(12px); display: none; align-items: center; justify-content: center; z-index: 999999; padding: 20px;">
    <div class="glass-panel" style="max-width: 480px; width: 100%; padding: 32px; border-radius: 24px; text-align: center; background: #0B111E; border: 1px solid rgba(239, 68, 68, 0.4); box-shadow: 0 25px 60px rgba(0,0,0,0.85);">
        <div style="font-size: 50px; margin-bottom: 16px;">⚠️</div>
        <div style="font-size: 11px; font-weight: 800; letter-spacing: 0.15em; text-transform: uppercase; color: #F87171; margin-bottom: 6px;" id="failure-modal-tag">Payment Incomplete</div>
        <h2 style="font-size: 20px; font-weight: 800; color: #FFF; margin: 0 0 12px;" id="failure-modal-title">Payment Could Not Be Completed</h2>
        <p style="font-size: 13px; color: #CBD5E1; line-height: 1.6; margin-bottom: 20px;" id="failure-modal-desc">
            The payment transaction was not completed. If money was debited from your account, it will be automatically refunded by your bank.
        </p>

        <div id="failure-details-box" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 12px; padding: 12px; margin-bottom: 24px; text-align: left; font-size: 12px;">
            <div style="color: #FCA5A5;" id="failure-reason-text">Reason: Transaction was cancelled.</div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="button" onclick="closeFailureModal(); initiateCheckout();" class="btn-primary" style="flex: 1; padding: 12px; font-size: 13px; font-weight: 700; border-radius: 12px;">
                <span>Retry Payment ⚡</span>
            </button>
            <button type="button" onclick="closeFailureModal()" class="btn-secondary" style="padding: 12px 18px; font-size: 13px; border-radius: 12px;">
                Dismiss
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- Razorpay Standard Checkout Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    let currentOrderNumber = null;

    const plan = "{{ $plan }}";
    const currency = "{{ $currency }}";
    const billing = "{{ $billing }}";
    const finalAmount = {{ $finalPrice }};

    // Client-side Origin Check (if currency not explicitly passed in URL)
    (function checkBrowserOrigin() {
        const urlParams = new URLSearchParams(window.location.search);
        if (!urlParams.has('currency')) {
            try {
                const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
                const isIndia = tz.includes('Calcutta') || tz.includes('Kolkata') || tz.includes('India');
                const currentCurrency = '{{ $currency }}';
                if (!isIndia && currentCurrency === 'INR') {
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
        document.getElementById('success-redirect-btn').href = redirectUrl || '{{ url("/dashboard") }}';
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
        fetch('/api/checkout/payment/failed', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
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

    // Handle Form Submit for Razorpay
    async function initiateCheckout() {
        const name = document.getElementById('cust-name').value.trim();
        const email = document.getElementById('cust-email').value.trim();

        if (!email) {
            alert('Please enter your email address.');
            return;
        }

        const submitBtn = document.getElementById('pay-submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>⏳ Preparing Razorpay Checkout...</span>';

        const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';

        try {
            const res = await fetch('/api/checkout/create-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    plan,
                    currency,
                    billing,
                    gateway: 'razorpay',
                    name,
                    email,
                    coupon: 'LAUNCH50',
                    timezone: tz
                })
            });

            const orderData = await res.json();
            if (!orderData.success) {
                showFailureModal('Order Creation Failed', orderData.error || 'Failed to initialize payment gateway.');
                return;
            }

            currentOrderNumber = orderData.order_number;
            let isPaymentSuccessful = false;

            const options = {
                key: orderData.key_id,
                amount: orderData.amount_paise,
                currency: orderData.currency,
                name: 'Postryx AI',
                description: `${plan.toUpperCase()} Plan Subscription`,
                prefill: {
                    name: orderData.customer_name,
                    email: orderData.customer_email
                },
                theme: { color: '#6366F1' },
                modal: {
                    ondismiss: function() {
                        if (!isPaymentSuccessful) {
                            logPaymentFailure(currentOrderNumber, 'razorpay', 'MODAL_DISMISSED', 'Customer closed the Razorpay payment window');
                            showFailureModal('Payment Incomplete', 'You closed the payment window without completing the transaction.', 'Payment modal was dismissed by customer.');
                        }
                    }
                },
                handler: async function (response) {
                    isPaymentSuccessful = true;
                    closeFailureModal();
                    submitBtn.innerHTML = '<span>⏳ Verifying Transaction...</span>';

                    try {
                        const verifyRes = await fetch('/api/checkout/razorpay/verify', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                order_number: currentOrderNumber,
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id || orderData.razorpay_order_id || '',
                                razorpay_signature: response.razorpay_signature || ''
                            })
                        });
                        const verifyData = await verifyRes.json();
                        if (verifyData.success) {
                            if (typeof window.trackGAEvent === 'function') {
                                window.trackGAEvent('purchase', {
                                    transaction_id: currentOrderNumber,
                                    value: finalAmount,
                                    currency: currency,
                                    items: [{ item_name: '{{ $planName }}', item_category: 'SaaS Subscription' }]
                                });
                            }
                            showSuccessModal(verifyData.order_number, verifyData.transaction_ref, verifyData.redirect_url);
                        } else {
                            showFailureModal('Verification Failed', verifyData.error || 'Payment signature mismatch.', 'Verification rejected by server.');
                        }
                    } catch (err) {
                        console.error('Verification error:', err);
                        showFailureModal('Verification Error', 'Unable to complete verification on server. Please contact support.', err.message);
                    }
                }
            };

            if (orderData.razorpay_order_id) {
                options.order_id = orderData.razorpay_order_id;
            }

            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response) {
                if (!isPaymentSuccessful) {
                    const err = response.error || {};
                    logPaymentFailure(
                        currentOrderNumber,
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
        } catch (e) {
            console.error('Checkout error:', e);
            showFailureModal('Network / Server Error', 'Failed to connect to the payment server. Please check your internet connection.', e.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<span>Pay ${currency === 'INR' ? '₹' : '$'}${finalAmount.toFixed(2)} with Razorpay 🔒</span>`;
        }
    }
</script>
@endsection
