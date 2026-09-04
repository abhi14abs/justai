/**
 * CELEBRATEAI / DIGITAL INVITATION PLATFORM — LIVE BUILDER SCRIPT
 * Split-screen real-time editor, dynamic pricing sync & device frame switchers
 */

(function () {
    'use strict';

    // 1. Tab Switching
    window.switchBuilderTab = function (tabId, btn) {
        document.querySelectorAll('.builder-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.builder-tab-pane').forEach(p => p.classList.remove('active'));

        if (btn) btn.classList.add('active');
        const targetPane = document.getElementById('tab-' + tabId);
        if (targetPane) targetPane.classList.add('active');
    };

    // 2. Device Frame Switcher
    window.setPreviewDevice = function (deviceType, btn) {
        document.querySelectorAll('.device-switch-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        const frame = document.getElementById('preview-device-frame');
        if (frame) {
            frame.className = 'preview-device-frame ' + deviceType;
        }
    };

    // 3. Live Color / Theme Variable Update
    window.updateThemeVar = function (varName, value) {
        const previewIframe = document.getElementById('builder-preview-iframe');
        if (previewIframe && previewIframe.contentWindow) {
            previewIframe.contentWindow.postMessage({
                type: 'UPDATE_STYLE',
                variable: varName,
                value: value
            }, '*');
        }
    };

    // 4. Live Text Synchronization
    window.syncLiveText = function (elementId, value) {
        const previewIframe = document.getElementById('builder-preview-iframe');
        if (previewIframe && previewIframe.contentWindow) {
            previewIframe.contentWindow.postMessage({
                type: 'UPDATE_TEXT',
                elementId: elementId,
                value: value
            }, '*');
        }
    };

    // 5. Dynamic Pricing Calculator
    window.recalculatePricing = function () {
        const templateId = document.getElementById('builder-template-id')?.value;
        const currency = document.getElementById('pricing-currency')?.value || 'INR';
        const coupon = document.getElementById('pricing-coupon-input')?.value || '';

        const selectedFeatures = [];
        document.querySelectorAll('.feature-checkbox:checked').forEach(cb => {
            selectedFeatures.push(cb.value);
        });

        const pricingSummary = document.getElementById('pricing-summary-box');
        if (pricingSummary) {
            pricingSummary.style.opacity = '0.6';
        }

        fetch('/api/invitations/pricing/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                template_id: templateId,
                features: selectedFeatures,
                currency: currency,
                coupon: coupon
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.pricing) {
                const p = data.pricing;
                const totalElem = document.getElementById('pricing-final-amount');
                const subtotalElem = document.getElementById('pricing-subtotal');
                const discountElem = document.getElementById('pricing-discount');
                const discountRow = document.getElementById('pricing-discount-row');

                if (totalElem) totalElem.innerText = p.formatted_final;
                if (subtotalElem) subtotalElem.innerText = p.formatted_subtotal;
                if (discountElem && discountRow) {
                    if (p.discount_amount > 0) {
                        discountRow.style.display = 'flex';
                        discountElem.innerText = '-' + p.formatted_discount;
                    } else {
                        discountRow.style.display = 'none';
                    }
                }
            }
        })
        .catch(err => console.error('Pricing calculation error:', err))
        .finally(() => {
            if (pricingSummary) pricingSummary.style.opacity = '1';
        });
    };

    // 6. Section Toggle & Persistence
    window.toggleSectionVisibility = function (invitationId, sectionId, isEnabled, sectionType) {
        // If invitationId was omitted and called as (sectionId, isEnabled)
        if (typeof isEnabled === 'undefined') {
            isEnabled = sectionId;
            sectionId = invitationId;
            invitationId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        }

        // 1. Instant Live Preview Sync via postMessage
        const previewIframe = document.getElementById('builder-preview-iframe');
        if (previewIframe && previewIframe.contentWindow) {
            previewIframe.contentWindow.postMessage({
                type: 'TOGGLE_SECTION',
                sectionId: sectionId,
                sectionType: sectionType,
                enabled: isEnabled
            }, '*');
        }

        // 2. Persist to Backend Database
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const invId = invitationId || document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        
        if (invId && sectionId) {
            fetch(`/invitations/builder/${invId}/section/${sectionId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ is_enabled: isEnabled ? 1 : 0 })
            })
            .then(res => res.json())
            .then(data => {
                console.log('Section visibility saved successfully:', data);
            })
            .catch(err => {
                console.error('Error saving section visibility:', err);
            });
        }
    };

    // 7. AI Copywriter Trigger
    window.generateBuilderAiContent = function (contentType) {
        const tone = document.getElementById('builder-ai-tone')?.value || 'luxury';
        const title = document.getElementById('opt-title')?.value || 'Our Celebration';
        const eventDate = document.getElementById('opt-event-date')?.value || '';
        const resultBox = document.getElementById('builder-ai-result-box');
        const resultText = document.getElementById('builder-ai-result-text');

        if (resultBox && resultText) {
            resultBox.style.display = 'block';
            resultText.value = '⏳ AI is crafting your message...';
        }

        fetch('/api/invitations/ai/tone-copy', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                content_type: contentType,
                details: {
                    names: title,
                    date: eventDate,
                    city: 'Celebration Venue',
                    event_type: 'Wedding'
                },
                tone: tone,
                language: 'en'
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.content && resultText) {
                resultText.value = data.content;
            }
        })
        .catch(err => {
            if (resultText) resultText.value = 'Failed to generate copy. Please try again.';
        });
    };

    // Initialize listeners
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.feature-checkbox').forEach(cb => {
            cb.addEventListener('change', window.recalculatePricing);
        });
    });

})();

