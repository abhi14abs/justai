@extends('layouts.app')

@section('title', 'Secure Checkout — Upgrade to ' . $planName . ' | Postryx AI')
@section('meta_description', 'Complete your secure checkout for Postryx AI. Pay securely with PayPal, Razorpay UPI/Cards, or Direct UPI with instant activation.')

@section('content')

<section style="padding: 60px 24px 80px; max-width: 1040px; margin: 0 auto;">
    
    <div style="text-align: center; margin-bottom: 40px;">
        <span class="badge-pill-emerald" style="margin-bottom: 12px;">🔒 256-Bit SSL Encrypted &amp; PCI-DSS Compliant</span>
        <h1 style="font-size: clamp(28px, 4.5vw, 44px); font-weight: 800; color: #fff; margin-top: 8px;">
            Upgrade to <span class="gradient-text">{{ $planName }}</span>
        </h1>
        <p style="color: var(--text-secondary); font-size: 16px; margin-top: 6px;">Instant access to unlimited generations, AI humanizer, and priority model speeds.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 32px; align-items: flex-start;">
        
        {{-- Left Column: Customer & Payment Details --}}
        <div class="glass-panel" style="padding: 32px;">
            <h3 style="font-size: 18px; color: #fff; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <span class="badge-pill" style="padding: 2px 8px; font-size: 11px;">1</span> Account &amp; Billing Info
            </h3>

            <form id="checkout-form" onsubmit="event.preventDefault(); initiateCheckout();" style="display: flex; flex-direction: column; gap: 18px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Your Full Name:</label>
                    <input type="text" id="cust-name" class="postryx-input" placeholder="e.g. Alex Johnson" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Email Address (For Account &amp; Receipt):</label>
                    <input type="email" id="cust-email" class="postryx-input" placeholder="e.g. name@company.com" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 12px;">
                        <span class="badge-pill" style="padding: 2px 8px; font-size: 11px; margin-right: 4px;">2</span> Select Payment Method:
                    </label>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px;" id="gateway-options-list">
                        
                        {{-- PayPal Option --}}
                        <label id="label-gw-paypal" onclick="switchGateway('paypal')" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border: 1px solid var(--border-active); border-radius: 14px; background: rgba(0, 112, 186, 0.12); cursor: pointer; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_gateway" value="paypal" checked style="accent-color: #0070ba; width: 18px; height: 18px;">
                                <div>
                                    <div style="font-weight: 700; color: #fff; font-size: 15px;">PayPal &amp; International Cards</div>
                                    <div style="font-size: 12px; color: #94a3b8;">PayPal Wallet, Visa, Mastercard, Amex (Global USD/EUR)</div>
                                </div>
                            </div>
                            <span style="font-size: 22px;">🌐</span>
                        </label>

                        {{-- Razorpay Option --}}
                        <label id="label-gw-razorpay" onclick="switchGateway('razorpay')" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border: 1px solid var(--border-subtle); border-radius: 14px; background: rgba(15, 23, 42, 0.6); cursor: pointer; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_gateway" value="razorpay" style="accent-color: #6366f1; width: 18px; height: 18px;">
                                <div>
                                    <div style="font-weight: 700; color: #fff; font-size: 15px;">UPI &amp; Indian Netbanking / Cards (Razorpay)</div>
                                    <div style="font-size: 12px; color: #94a3b8;">GPay, PhonePe, Paytm, BHIM, Debit/Credit Cards</div>
                                </div>
                            </div>
                            <span style="font-size: 22px;">🇮🇳</span>
                        </label>

                        {{-- Direct UPI QR Option --}}
                        <label id="label-gw-upi_qr" onclick="switchGateway('upi_qr')" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border: 1px solid var(--border-subtle); border-radius: 14px; background: rgba(15, 23, 42, 0.6); cursor: pointer; transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_gateway" value="upi_qr" style="accent-color: #10b981; width: 18px; height: 18px;">
                                <div>
                                    <div style="font-weight: 700; color: #fff; font-size: 15px;">Direct UPI QR / Instant Scan &amp; Pay</div>
                                    <div style="font-size: 12px; color: #94a3b8;">Scan with any UPI App and enter UTR to activate</div>
                                </div>
                            </div>
                            <span style="font-size: 22px;">⚡</span>
                        </label>

                    </div>
                </div>

                {{-- PayPal Buttons Container --}}
                <div id="paypal-button-container" style="margin-top: 12px;"></div>

                {{-- General Pay Button --}}
                <button type="submit" id="pay-submit-btn" class="btn-primary" style="display: none; padding: 14px; font-size: 16px; font-weight: 700; width: 100%;">
                    <span>Proceed to Pay {{ $currency === 'INR' ? '₹' : '$' }}{{ number_format($finalPrice, 2) }} 🔒</span>
                </button>
            </form>

            {{-- Direct UPI QR Modal --}}
            <div id="upi-qr-box" style="display: none; margin-top: 20px; background: rgba(0,0,0,0.5); border: 1px solid var(--border-active); border-radius: 14px; padding: 22px; text-align: center;">
                <h4 style="color: #fff; font-size: 16px; margin-bottom: 8px;">Scan with Any UPI App (GPay / PhonePe / Paytm):</h4>
                <div id="upi-qr-image" style="background: #fff; padding: 12px; border-radius: 12px; display: inline-block; margin: 12px 0;">
                    <img id="qr-img-tag" src="" alt="UPI QR Code" style="width: 180px; height: 180px; display: block;">
                </div>
                <div style="font-size: 13px; color: var(--text-secondary); margin-bottom: 14px;">
                    UPI ID: <strong style="color:#38bdf8;">postryx@upi</strong> • Amount: <strong>₹{{ number_format($finalPrice, 2) }}</strong>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 6px;">Enter 12-digit UPI Reference / UTR Number:</label>
                    <input type="text" id="upi-utr-input" class="postryx-input" placeholder="e.g. 423512345678" style="padding: 10px 14px; font-size: 14px; text-align: center; margin-bottom: 12px;">
                    <button onclick="submitUpiUtr()" class="btn-glow-cyan btn-primary" style="width: 100%; padding: 12px; font-size: 14px; font-weight: 700;">Confirm &amp; Activate Plan 🚀</button>
                </div>
            </div>

        </div>

        {{-- Right Column: Order Summary --}}
        <div class="glass-panel-glow" style="padding: 32px;">
            <h3 style="font-size: 18px; color: #fff; margin-bottom: 20px;">Order Summary</h3>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 16px;">
                <div>
                    <div style="font-weight: 800; color: #fff; font-size: 17px;">{{ $planName }}</div>
                    <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Billing: {{ ucfirst($billing) }}</div>
                </div>
                <div style="font-weight: 800; color: #fff; font-size: 18px;">
                    {{ $currency === 'INR' ? '₹' : '$' }}{{ number_format($basePrice, 2) }}
                </div>
            </div>

            {{-- Discount Row --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 16px; color: #10b981;">
                <div>
                    <div style="font-weight: 700; font-size: 14px;">Launch Promo Discount (50%)</div>
                    <div style="font-size: 11px; color: #6ee7b7;">Code: LAUNCH50 Applied</div>
                </div>
                <div style="font-weight: 800; font-size: 16px;">
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
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 22px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 22px;">
                <div style="font-size: 16px; font-weight: 700; color: #fff;">Total Due Today:</div>
                <div style="font-size: 32px; font-weight: 900; color: #38bdf8;">
                    {{ $currency === 'INR' ? '₹' : '$' }}{{ number_format($finalPrice, 2) }}
                </div>
            </div>

            {{-- Guarantee Badges --}}
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: var(--text-secondary);">
                <li style="display: flex; gap: 10px; align-items: center;"><span style="color:#10b981; font-weight: 700;">✓</span> 14-Day 100% Money-Back Guarantee</li>
                <li style="display: flex; gap: 10px; align-items: center;"><span style="color:#10b981; font-weight: 700;">✓</span> Instant Plan Activation &amp; Unlimited API Access</li>
                <li style="display: flex; gap: 10px; align-items: center;"><span style="color:#10b981; font-weight: 700;">✓</span> Cancel Anytime with Zero Lock-in</li>
            </ul>
        </div>

    </div>

</section>

@endsection

@section('scripts')
{{-- PayPal SDK Integration with User's Client ID --}}
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency={{ $currency === 'INR' ? 'USD' : $currency }}"></script>

{{-- Razorpay Standard Checkout Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    let currentOrderNumber = null;

    const plan = "{{ $plan }}";
    const currency = "{{ $currency }}";
    const billing = "{{ $billing }}";
    const finalAmount = {{ $finalPrice }};

    function switchGateway(gateway) {
        document.querySelectorAll('#gateway-options-list label').forEach(l => {
            l.style.borderColor = 'var(--border-subtle)';
            l.style.background = 'rgba(15, 23, 42, 0.6)';
        });

        const activeLabel = document.getElementById(`label-gw-${gateway}`);
        if (activeLabel) {
            activeLabel.style.borderColor = gateway === 'paypal' ? '#0070ba' : (gateway === 'upi_qr' ? '#10b981' : '#6366f1');
            activeLabel.style.background = gateway === 'paypal' ? 'rgba(0, 112, 186, 0.15)' : (gateway === 'upi_qr' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(99, 102, 241, 0.15)');
        }

        const paypalContainer = document.getElementById('paypal-button-container');
        const submitBtn = document.getElementById('pay-submit-btn');
        const upiBox = document.getElementById('upi-qr-box');

        if (gateway === 'paypal') {
            paypalContainer.style.display = 'block';
            submitBtn.style.display = 'none';
            upiBox.style.display = 'none';
        } else {
            paypalContainer.style.display = 'none';
            submitBtn.style.display = 'block';
            if (gateway !== 'upi_qr') upiBox.style.display = 'none';
        }
    }

    // Render PayPal Button
    if (window.paypal) {
        paypal.Buttons({
            createOrder: async function(data, actions) {
                const name = document.getElementById('cust-name').value || 'Customer';
                const email = document.getElementById('cust-email').value;

                if (!email) {
                    Postryx.showToast('Please enter your email address first.', 'error');
                    throw new Error('Email required');
                }

                // Create Order on Postryx Server
                const res = await fetch('/api/checkout/create-order', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        plan,
                        currency,
                        billing,
                        gateway: 'paypal',
                        name,
                        email,
                        coupon: 'LAUNCH50'
                    })
                });

                const orderData = await res.json();
                if (orderData.success && orderData.paypal_order_id) {
                    currentOrderNumber = orderData.order_number;
                    return orderData.paypal_order_id;
                } else {
                    throw new Error(orderData.error || 'PayPal order creation failed');
                }
            },
            onApprove: async function(data, actions) {
                Postryx.showToast('Capturing PayPal payment...');
                
                const captureRes = await fetch('/api/checkout/paypal/capture', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        paypal_order_id: data.orderID,
                        order_number: currentOrderNumber
                    })
                });

                const captureData = await captureRes.json();
                if (captureData.success) {
                    if (typeof window.trackGAEvent === 'function') {
                        window.trackGAEvent('purchase', {
                            transaction_id: currentOrderNumber,
                            value: {{ $finalPrice }},
                            currency: '{{ $currency }}',
                            items: [{ item_name: '{{ $planName }}', item_category: 'SaaS Subscription' }]
                        });
                    }
                    window.location.href = captureData.redirect_url;
                } else {
                    alert('Payment capture failed: ' + (captureData.error || 'Please contact support.'));
                }
            },
            onError: function(err) {
                console.error('PayPal Error:', err);
                Postryx.showToast('PayPal payment was cancelled or failed.', 'error');
            }
        }).render('#paypal-button-container');
    }

    // Handle Form Submit for Razorpay or UPI QR
    async function initiateCheckout() {
        const name = document.getElementById('cust-name').value;
        const email = document.getElementById('cust-email').value;
        const gateway = document.querySelector('input[name="payment_gateway"]:checked').value;

        if (!email) {
            Postryx.showToast('Please enter your email address.', 'error');
            return;
        }

        if (gateway === 'paypal') {
            Postryx.showToast('Please click the yellow PayPal button above to pay securely.', 'info');
            return;
        }

        const submitBtn = document.getElementById('pay-submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Initializing Gateway...';

        try {
            const res = await fetch('/api/checkout/create-order', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    plan,
                    currency,
                    billing,
                    gateway,
                    name,
                    email,
                    coupon: 'LAUNCH50'
                })
            });

            const orderData = await res.json();
            currentOrderNumber = orderData.order_number;

            if (gateway === 'razorpay') {
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
                    theme: { color: '#6366f1' },
                    modal: {
                        ondismiss: function() {
                            Postryx.showToast('Payment window closed.', 'info');
                        }
                    },
                    handler: async function (response) {
                        Postryx.showToast('Verifying payment signature...');
                        try {
                            const verifyRes = await fetch('/api/checkout/razorpay/verify', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    order_number: currentOrderNumber,
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id || orderData.razorpay_order_id || '',
                                    razorpay_signature: response.razorpay_signature || ''
                                })
                            });
                            const verifyData = await verifyRes.json();
                            if (verifyData.success) {
                                Postryx.showToast('Payment successful! Redirecting...', 'success');
                                if (typeof window.trackGAEvent === 'function') {
                                    window.trackGAEvent('purchase', {
                                        transaction_id: currentOrderNumber,
                                        value: {{ $finalPrice }},
                                        currency: '{{ $currency }}',
                                        items: [{ item_name: '{{ $planName }}', item_category: 'SaaS Subscription' }]
                                    });
                                }
                                window.location.href = verifyData.redirect_url;
                            } else {
                                Postryx.showToast(verifyData.error || 'Payment verification failed', 'error');
                            }
                        } catch (err) {
                            console.error('Verification error:', err);
                            Postryx.showToast('Verification failed. Please contact support.', 'error');
                        }
                    }
                };

                if (orderData.razorpay_order_id) {
                    options.order_id = orderData.razorpay_order_id;
                }

                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response) {
                    Postryx.showToast(response.error.description || 'Payment Failed', 'error');
                });
                rzp.open();
            } else if (gateway === 'upi_qr') {
                document.getElementById('upi-qr-box').style.display = 'block';
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(orderData.upi_string)}`;
                document.getElementById('qr-img-tag').src = qrUrl;
                Postryx.showToast('UPI QR Generated! Scan to pay.');
            }
        } catch (e) {
            console.error('Checkout error:', e);
            Postryx.showToast('An error occurred. Please try again.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `Proceed to Pay 🔒`;
        }
    }

    async function submitUpiUtr() {
        const utr = document.getElementById('upi-utr-input').value.trim();
        if (!utr || utr.length < 6) {
            Postryx.showToast('Please enter a valid 12-digit UPI UTR / Reference number.', 'error');
            return;
        }

        const res = await fetch('/api/checkout/upi/submit', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                order_number: currentOrderNumber,
                utr: utr
            })
        });

        const data = await res.json();
        if (data.success) {
            if (typeof window.trackGAEvent === 'function') {
                window.trackGAEvent('purchase', {
                    transaction_id: currentOrderNumber,
                    value: {{ $finalPrice }},
                    currency: '{{ $currency }}',
                    items: [{ item_name: '{{ $planName }}', item_category: 'SaaS Subscription' }]
                });
            }
            window.location.href = data.redirect_url;
        }
    }
</script>
@endsection
