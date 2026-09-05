/**
 * CELEBRATEAI / DIGITAL INVITATION PLATFORM — CLIENT SCRIPTS
 * Envelope Opening, Ambient Particles, Live Countdown, Music Player, RSVP & Sharing
 */

(function () {
    'use strict';

    // 1. Interactive Wax Seal Envelope Opening
    window.openEnvelope = function () {
        const overlay = document.getElementById('envelope-overlay');
        if (overlay) {
            overlay.classList.add('opened');
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 1200);
        }

        // Try playing audio if enabled
        const audio = document.getElementById('bg-music-audio');
        const fab = document.getElementById('music-fab');
        if (audio && fab) {
            audio.play().then(() => {
                fab.classList.add('playing');
            }).catch(() => {
                console.log('Audio autoplay prevented by browser policy');
            });
        }

        // Trigger confetti on open
        if (typeof window.triggerConfetti === 'function') {
            window.triggerConfetti();
        }
    };

    // 2. Ambient Particles (Sparkles / Petals / Marigold / Diya / Temple Aura)
    function initParticles() {
        const canvas = document.getElementById('particles-canvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let width = canvas.width = window.innerWidth;
        let height = canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        });

        const particles = [];
        const count = window.innerWidth < 768 ? 28 : 50;
        const style = canvas.getAttribute('data-style') || 'sparkles_float';

        for (let i = 0; i < count; i++) {
            let pColor = '#D4AF37';
            if (style === 'marigold_shower') {
                pColor = ['#FF9800', '#F59E0B', '#EF4444', '#FBBF24', '#D97706'][i % 5];
            } else if (style === 'diya_sparkle') {
                pColor = ['#F59E0B', '#F97316', '#FDE047', '#EA580C'][i % 4];
            } else if (style === 'durva_jasmine') {
                pColor = ['#16A34A', '#22C55E', '#FFFFFF', '#FEF08A'][i % 4];
            } else if (style === 'temple_bells_aura') {
                pColor = ['#F59E0B', '#D4AF37', '#FEF3C7', '#DC2626'][i % 4];
            } else if (style === 'petals_fall') {
                pColor = '#F472B6';
            } else if (style === 'confetti') {
                pColor = ['#F59E0B', '#EC4899', '#38BDF8', '#10B981'][i % 4];
            }

            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                size: (style === 'marigold_shower' || style === 'diya_sparkle') ? Math.random() * 6 + 4 : Math.random() * 4 + 1.5,
                speedX: (Math.random() - 0.5) * (style === 'marigold_shower' ? 1.2 : 0.8),
                speedY: (style === 'marigold_shower' || style === 'durva_jasmine' || style === 'petals_fall') 
                    ? Math.random() * 1.6 + 0.6 
                    : (style === 'diya_sparkle' ? -(Math.random() * 1.0 + 0.3) : (Math.random() - 0.5) * 0.8 - 0.2),
                opacity: Math.random() * 0.7 + 0.3,
                rotation: Math.random() * 360,
                rotSpeed: (Math.random() - 0.5) * 2.5,
                color: pColor,
                type: (style === 'marigold_shower' && i % 4 === 0) ? 'modak' : ((style === 'diya_sparkle' && i % 3 === 0) ? 'diya' : 'standard')
            });
        }

        function render() {
            ctx.clearRect(0, 0, width, height);

            particles.forEach(p => {
                p.x += p.speedX;
                p.y += p.speedY;
                p.rotation += p.rotSpeed;

                if (p.y > height + 20) { p.y = -20; p.x = Math.random() * width; }
                if (p.y < -20) { p.y = height + 20; p.x = Math.random() * width; }
                if (p.x > width + 20) p.x = -20;
                if (p.x < -20) p.x = width + 20;

                ctx.save();
                ctx.translate(p.x, p.y);
                ctx.rotate((p.rotation * Math.PI) / 180);
                ctx.globalAlpha = p.opacity;

                if (style === 'marigold_shower') {
                    if (p.type === 'modak') {
                        // Draw small golden Modak
                        ctx.fillStyle = '#FDE047';
                        ctx.shadowBlur = 6;
                        ctx.shadowColor = '#F59E0B';
                        ctx.beginPath();
                        ctx.moveTo(0, -p.size);
                        ctx.quadraticCurveTo(p.size, 0, p.size * 0.7, p.size);
                        ctx.lineTo(-p.size * 0.7, p.size);
                        ctx.quadraticCurveTo(-p.size, 0, 0, -p.size);
                        ctx.fill();
                    } else {
                        // Draw 5-petal Marigold flower
                        ctx.fillStyle = p.color;
                        ctx.shadowBlur = 8;
                        ctx.shadowColor = p.color;
                        for (let petal = 0; petal < 5; petal++) {
                            ctx.beginPath();
                            ctx.ellipse(0, p.size * 0.6, p.size * 0.5, p.size * 0.8, (petal * 72 * Math.PI) / 180, 0, Math.PI * 2);
                            ctx.fill();
                        }
                        // Center dot
                        ctx.fillStyle = '#EF4444';
                        ctx.beginPath();
                        ctx.arc(0, 0, p.size * 0.3, 0, Math.PI * 2);
                        ctx.fill();
                    }
                } else if (style === 'diya_sparkle') {
                    // Draw glowing Diya lamp with rising flame
                    ctx.fillStyle = '#D97706';
                    ctx.beginPath();
                    ctx.ellipse(0, 0, p.size, p.size * 0.4, 0, 0, Math.PI);
                    ctx.fill();
                    // Diya flame
                    ctx.fillStyle = '#FEF08A';
                    ctx.shadowBlur = 12;
                    ctx.shadowColor = '#F59E0B';
                    ctx.beginPath();
                    ctx.moveTo(-p.size * 0.3, -p.size * 0.2);
                    ctx.quadraticCurveTo(0, -p.size * 1.4, p.size * 0.3, -p.size * 0.2);
                    ctx.fill();
                } else if (style === 'durva_jasmine') {
                    // Draw durva blade or jasmine star
                    ctx.fillStyle = p.color;
                    ctx.shadowBlur = 6;
                    ctx.shadowColor = p.color;
                    ctx.beginPath();
                    ctx.ellipse(0, 0, p.size * 2, p.size * 0.6, 0, 0, Math.PI * 2);
                    ctx.fill();
                } else if (style === 'temple_bells_aura') {
                    // Radiating aura ring with center star
                    ctx.strokeStyle = p.color;
                    ctx.lineWidth = 1.5;
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = p.color;
                    ctx.beginPath();
                    ctx.arc(0, 0, p.size * 1.5, 0, Math.PI * 2);
                    ctx.stroke();

                    ctx.fillStyle = p.color;
                    ctx.beginPath();
                    ctx.arc(0, 0, p.size * 0.5, 0, Math.PI * 2);
                    ctx.fill();
                } else if (style === 'petals_fall') {
                    ctx.fillStyle = p.color;
                    ctx.beginPath();
                    ctx.ellipse(0, 0, p.size * 2, p.size, 0, 0, Math.PI * 2);
                    ctx.fill();
                } else {
                    ctx.fillStyle = p.color;
                    ctx.shadowBlur = 8;
                    ctx.shadowColor = p.color;
                    ctx.beginPath();
                    ctx.arc(0, 0, p.size, 0, Math.PI * 2);
                    ctx.fill();
                }

                ctx.restore();
            });

            requestAnimationFrame(render);
        }

        render();
    }

    // 3. Live Countdown Timer
    function initCountdown() {
        const countdownElem = document.getElementById('invitation-countdown');
        if (!countdownElem) return;

        const targetDateStr = countdownElem.getAttribute('data-target-date');
        if (!targetDateStr) return;

        const targetTime = new Date(targetDateStr).getTime();

        const daysElem = document.getElementById('count-days');
        const hoursElem = document.getElementById('count-hours');
        const minsElem = document.getElementById('count-mins');
        const secsElem = document.getElementById('count-secs');

        function updateClock() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance < 0) {
                if (daysElem) daysElem.innerText = '00';
                if (hoursElem) hoursElem.innerText = '00';
                if (minsElem) minsElem.innerText = '00';
                if (secsElem) secsElem.innerText = '00';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const secs = Math.floor((distance % (1000 * 60)) / 1000);

            if (daysElem) daysElem.innerText = days < 10 ? '0' + days : days;
            if (hoursElem) hoursElem.innerText = hours < 10 ? '0' + hours : hours;
            if (minsElem) minsElem.innerText = mins < 10 ? '0' + mins : mins;
            if (secsElem) secsElem.innerText = secs < 10 ? '0' + secs : secs;
        }

        updateClock();
        setInterval(updateClock, 1000);
    }

    // 4. Music Player Toggle
    window.toggleMusic = function () {
        const audio = document.getElementById('bg-music-audio');
        const fab = document.getElementById('music-fab');
        if (!audio || !fab) return;

        if (audio.paused) {
            audio.play();
            fab.classList.add('playing');
        } else {
            audio.pause();
            fab.classList.remove('playing');
        }
    };

    // 5. AJAX RSVP Submission Handler
    window.handleRsvpSubmit = function (event, formElem) {
        event.preventDefault();
        const submitBtn = formElem.querySelector('button[type="submit"]');
        const originalBtnHtml = submitBtn ? submitBtn.innerHTML : 'Submit RSVP';

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="animate-spin">⏳</span> Confirming...';
        }

        const formData = new FormData(formElem);
        const submitUrl = formElem.getAttribute('action') || window.location.href + '/rsvp';

        fetch(submitUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const formCard = document.getElementById('rsvp-form-container');
                const successCard = document.getElementById('rsvp-success-container');
                if (formCard && successCard) {
                    formCard.style.display = 'none';
                    successCard.style.display = 'block';
                    const msgElem = document.getElementById('rsvp-success-msg');
                    if (msgElem && data.message) {
                        msgElem.innerText = data.message;
                    }
                }
                if (typeof window.triggerConfetti === 'function') {
                    window.triggerConfetti();
                }
            } else {
                alert(data.error || 'Failed to submit RSVP. Please check your information.');
            }
        })
        .catch(err => {
            console.error('RSVP submission error:', err);
            alert('An error occurred. Please try submitting again.');
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        });
    };

    // 6. 1-Click WhatsApp & Web Share
    window.shareInvitation = function (channel, url, title) {
        url = url || window.location.href;
        title = title || document.title;

        if (channel === 'whatsapp') {
            const text = encodeURIComponent(`✨ You're cordially invited to celebrate: ${title}\n\nTap to view the digital invitation, event schedule & RSVP:\n${url}`);
            window.open(`https://api.whatsapp.com/send?text=${text}`, '_blank');
        } else if (channel === 'native' && navigator.share) {
            navigator.share({
                title: title,
                text: `You are cordially invited: ${title}`,
                url: url
            }).catch(console.error);
        } else {
            navigator.clipboard.writeText(url).then(() => {
                alert('Invitation link copied to clipboard!');
            });
        }
    };

    // 7. Confetti celebration trigger
    window.triggerConfetti = function () {
        const count = 60;
        for (let i = 0; i < count; i++) {
            const conf = document.createElement('div');
            conf.style.position = 'fixed';
            conf.style.zIndex = '99999';
            conf.style.width = Math.random() * 10 + 6 + 'px';
            conf.style.height = Math.random() * 6 + 4 + 'px';
            conf.style.backgroundColor = ['#D4AF37', '#F59E0B', '#EC4899', '#38BDF8', '#10B981'][Math.floor(Math.random() * 5)];
            conf.style.top = '-20px';
            conf.style.left = Math.random() * 100 + 'vw';
            conf.style.transform = `rotate(${Math.random() * 360}deg)`;
            conf.style.transition = `all ${Math.random() * 2 + 1.5}s ease-out`;
            conf.style.pointerEvents = 'none';
            document.body.appendChild(conf);

            setTimeout(() => {
                conf.style.top = '105vh';
                conf.style.transform = `rotate(${Math.random() * 720}deg) scale(0.6)`;
                conf.style.opacity = '0';
            }, 50);

            setTimeout(() => {
                conf.remove();
            }, 3500);
        }
    };

    // 8. Cross-window Message Listener for Real-time Builder Preview
    window.addEventListener('message', function (event) {
        if (!event.data || typeof event.data !== 'object') return;

        const data = event.data;

        // Toggle Section Visibility
        if (data.type === 'TOGGLE_SECTION') {
            const sectionEl = document.getElementById('section-wrapper-' + data.sectionId) ||
                              document.querySelector(`[data-section-id="${data.sectionId}"]`) ||
                              document.querySelector(`[data-section-type="${data.sectionType}"]`);
            if (sectionEl) {
                if (data.enabled) {
                    sectionEl.style.display = 'block';
                    sectionEl.style.opacity = '0';
                    sectionEl.style.transform = 'translateY(10px)';
                    sectionEl.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    requestAnimationFrame(() => {
                        sectionEl.style.opacity = '1';
                        sectionEl.style.transform = 'translateY(0)';
                    });
                } else {
                    sectionEl.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                    sectionEl.style.opacity = '0';
                    sectionEl.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        sectionEl.style.display = 'none';
                    }, 200);
                }
            }
        } 
        // Update CSS Custom Properties
        else if (data.type === 'UPDATE_STYLE') {
            if (data.variable && data.value !== undefined) {
                document.documentElement.style.setProperty(data.variable, data.value);
            }
        }
        // Update Page Background & Texture
        else if (data.type === 'UPDATE_PAGE_BG') {
            if (data.color) {
                document.documentElement.style.setProperty('--invite-bg', data.color);
                document.documentElement.style.setProperty('--invite-secondary', data.color);
                document.body.style.backgroundColor = data.color;
            }
            if (data.imageUrl !== undefined) {
                let imgUrl = data.imageUrl ? data.imageUrl.trim() : '';
                if (imgUrl) {
                    const unsplashMatch = imgUrl.match(/unsplash\.com\/photos\/(?:[\w-]+-)?([a-zA-Z0-9_-]+)/i);
                    if (unsplashMatch && unsplashMatch[1] && !imgUrl.includes('images.unsplash.com')) {
                        imgUrl = `https://unsplash.com/photos/${unsplashMatch[1]}/download?force=true&w=1600`;
                    } else if (imgUrl.includes('drive.google.com/')) {
                        const dMatch = imgUrl.match(/drive\.google\.com\/(?:file\/d\/|open\?id=)([a-zA-Z0-9_-]+)/i);
                        if (dMatch && dMatch[1]) imgUrl = `https://drive.google.com/uc?export=download&id=${dMatch[1]}`;
                    }
                }
                const bgLayer = document.getElementById('invitation-bg-layer');
                if (bgLayer) {
                    bgLayer.style.backgroundImage = imgUrl ? `url('${imgUrl}')` : 'none';
                }
            }
            if (data.opacity !== undefined) {
                const op = parseFloat(data.opacity);
                document.documentElement.style.setProperty('--invite-bg-opacity', op);
                const bgLayer = document.getElementById('invitation-bg-layer');
                if (bgLayer) {
                    bgLayer.style.setProperty('opacity', op, 'important');
                }
            }
        }
        // Update Global Card Styling
        else if (data.type === 'UPDATE_CARD_STYLE') {
            if (data.cardBg) {
                document.documentElement.style.setProperty('--invite-card-bg', data.cardBg);
            }
            if (data.cardBorder) {
                document.documentElement.style.setProperty('--invite-card-border', data.cardBorder);
            }
            if (data.cardText) {
                document.documentElement.style.setProperty('--invite-card-text', data.cardText);
            }
            if (data.cardRadius) {
                document.documentElement.style.setProperty('--invite-card-radius', data.cardRadius + 'px');
            }
        }
        // Update Specific Section / Card Custom Styling
        else if (data.type === 'UPDATE_SECTION_STYLE') {
            const secWrapper = document.getElementById('section-wrapper-' + data.sectionId) ||
                              document.querySelector(`[data-section-id="${data.sectionId}"]`) ||
                              document.querySelector(`[data-section-type="${data.sectionType}"]`);
            if (secWrapper) {
                const cards = secWrapper.querySelectorAll('.event-card, .glass-panel, .venue-card-box, .map-card-box, .intro-card-box');
                cards.forEach(card => {
                    if (data.cardBg) card.style.setProperty('background-color', data.cardBg, 'important');
                    if (data.cardBorder) card.style.setProperty('border-color', data.cardBorder, 'important');
                    if (data.cardText) card.style.setProperty('color', data.cardText, 'important');
                    if (data.bgImage !== undefined) {
                        card.style.backgroundImage = data.bgImage ? `url('${data.bgImage}')` : 'none';
                        card.style.backgroundSize = 'cover';
                    }
                });
            }
        }
        // Update Live Location Details
        else if (data.type === 'UPDATE_LOCATION') {
            if (data.venueName) {
                document.querySelectorAll('.venue-name-display, .map-venue-name-display').forEach(el => el.innerText = data.venueName);
            }
            if (data.venueAddress) {
                document.querySelectorAll('.venue-address-display, .map-venue-address-display').forEach(el => el.innerText = '📍 ' + data.venueAddress);
            }
            if (data.cityDisplay) {
                document.querySelectorAll('.hero-city-display').forEach(el => el.innerText = '📍 ' + data.cityDisplay);
            }
            if (data.googleMapsUrl) {
                document.querySelectorAll('.venue-maps-link, .map-btn-link').forEach(el => el.href = data.googleMapsUrl);
            }
        }
        // Update Live Element Text
        else if (data.type === 'UPDATE_TEXT') {
            if (data.elementId && data.value !== undefined) {
                const targetEls = document.querySelectorAll('#' + data.elementId + ', .' + data.elementId);
                targetEls.forEach(el => el.innerText = data.value);
            }
        }
        // Update Section Content
        else if (data.type === 'UPDATE_SECTION_CONTENT') {
            const secWrapper = document.getElementById('section-wrapper-' + data.sectionId) ||
                              document.querySelector(`[data-section-id="${data.sectionId}"]`) ||
                              document.querySelector(`[data-section-type="${data.sectionType}"]`);
            if (secWrapper) {
                if (data.title !== undefined) {
                    const titleEl = secWrapper.querySelector('.sec-title-display');
                    if (titleEl) titleEl.innerText = data.title;
                }
                if (data.subtitle !== undefined) {
                    const subEl = secWrapper.querySelector('.sec-subtitle-display');
                    if (subEl) subEl.innerText = data.subtitle;
                }
            }
        }
        // Smooth scroll to relevant preview section when builder tab is clicked
        else if (data.type === 'SCROLL_TO_TAB_SECTION') {
            const tabId = data.tabId;
            let targetEl = null;
            if (tabId === 'basics' || tabId === 'theme') {
                targetEl = document.getElementById('invitation-hero') || document.querySelector('.hero-invitation-container') || document.body;
            } else if (tabId === 'location') {
                targetEl = document.querySelector('[data-section-type="venue"]') || document.querySelector('[data-section-type="map"]') || document.getElementById('section-venue');
            } else if (tabId === 'sections') {
                targetEl = document.querySelector('[data-section-type="couple"]') || document.querySelector('[data-section-type="family"]') || document.querySelector('.invitation-section-wrapper');
            } else if (tabId === 'events') {
                targetEl = document.querySelector('[data-section-type="events"]') || document.getElementById('section-events');
            } else if (tabId === 'rsvp') {
                targetEl = document.querySelector('[data-section-type="rsvp"]') || document.getElementById('section-rsvp');
            } else if (tabId === 'media') {
                targetEl = document.querySelector('[data-section-type="gallery"]') || document.querySelector('[data-section-type="video"]') || document.getElementById('section-gallery');
            }
            if (targetEl) {
                if (targetEl === document.body) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }
        // Soft Reload Preview with Scroll Preservation
        else if (data.type === 'REFRESH_PREVIEW') {
            const scrollY = window.scrollY;
            sessionStorage.setItem('builder_preview_scroll', scrollY);
            window.location.reload();
        }
    });

    // Restore scroll position after soft reload
    const savedScroll = sessionStorage.getItem('builder_preview_scroll');
    if (savedScroll !== null) {
        sessionStorage.removeItem('builder_preview_scroll');
        window.addEventListener('load', () => {
            window.scrollTo(0, parseInt(savedScroll, 10));
        });
    }

    // Initialize on DOM Ready
    document.addEventListener('DOMContentLoaded', () => {
        initParticles();
        initCountdown();
    });

})();
