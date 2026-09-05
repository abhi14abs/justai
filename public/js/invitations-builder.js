/**
 * CELEBRATEAI / DIGITAL INVITATION PLATFORM — MASTER BUILDER SCRIPT
 * Real-time Split-Screen Customizer, Live postMessage Sync, Location & Card Styling, Toast Feedback
 */

(function () {
    'use strict';

    // 1. Toast Notification System
    window.showToast = function (message, type = 'success') {
        let container = document.getElementById('builder-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'builder-toast-container';
            container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.style.cssText = `
            pointer-events: auto;
            background: ${type === 'error' ? 'rgba(239, 68, 68, 0.95)' : (type === 'warning' ? 'rgba(245, 158, 11, 0.95)' : 'rgba(16, 185, 129, 0.95)')};
            color: #FFFFFF;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateX(50px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
        `;

        const icon = type === 'error' ? '❌' : (type === 'warning' ? '⚠️' : '✨');
        toast.innerHTML = `<span>${icon}</span><span>${message}</span>`;
        container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
            toast.style.opacity = '1';
        });

        setTimeout(() => {
            toast.style.transform = 'translateX(50px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 350);
        }, 3500);
    };

    // Builder 9-Step Sequential Structure
    const BUILDER_STEPS = [
        { id: 'basics', num: 1, title: 'General Information' },
        { id: 'theme', num: 2, title: 'Design, Colors & Presets' },
        { id: 'location', num: 3, title: 'Venue & Location Details' },
        { id: 'sections', num: 4, title: 'Sections & Particulars' },
        { id: 'events', num: 5, title: 'Event Itinerary' },
        { id: 'rsvp', num: 6, title: 'RSVP Form Settings' },
        { id: 'media', num: 7, title: 'Audio & Gallery Media' },
        { id: 'ai', num: 8, title: 'AI Studio & Copywriter' },
        { id: 'publish', num: 9, title: 'Premium Features & Publish' }
    ];

    // 2. Tab Switching & Step Progress Sync
    window.switchBuilderTab = function (tabId, btn) {
        document.querySelectorAll('.builder-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.builder-tab-pane').forEach(p => p.classList.remove('active'));

        const targetBtn = btn || document.getElementById('tab-btn-' + tabId);
        if (targetBtn) {
            targetBtn.classList.add('active');
            targetBtn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }

        const targetPane = document.getElementById('tab-' + tabId);
        if (targetPane) targetPane.classList.add('active');

        // Update Step Badge, Title & Progress Bar
        const step = BUILDER_STEPS.find(s => s.id === tabId);
        if (step) {
            const badge = document.getElementById('builder-step-badge');
            const title = document.getElementById('builder-step-title');
            const fill = document.getElementById('builder-progress-fill');
            if (badge) badge.innerText = `Step ${step.num} of 9`;
            if (title) title.innerText = step.title;
            if (fill) fill.style.width = `${(step.num / 9) * 100}%`;
        }

        // Live smooth-scroll the preview iframe to corresponding section
        sendPreviewMessage({
            type: 'SCROLL_TO_TAB_SECTION',
            tabId: tabId
        });
    };

    // Scroll tabs navigation bar left/right
    window.scrollTabNav = function (direction) {
        const nav = document.getElementById('builder-tabs-nav');
        if (nav) {
            nav.scrollBy({ left: direction * 180, behavior: 'smooth' });
        }
    };

    // Quick jump to tab
    window.goToTab = function (tabId) {
        const btn = document.getElementById('tab-btn-' + tabId);
        window.switchBuilderTab(tabId, btn);
    };

    // 3. Device Frame Switcher
    window.setPreviewDevice = function (deviceType, btn) {
        document.querySelectorAll('.device-switch-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');

        const frame = document.getElementById('preview-device-frame');
        if (frame) {
            frame.className = 'preview-device-frame ' + deviceType;
        }
    };

    // 4. Live Cross-Window PostMessage Dispatchers
    function sendPreviewMessage(data) {
        const previewIframe = document.getElementById('builder-preview-iframe');
        if (previewIframe && previewIframe.contentWindow) {
            previewIframe.contentWindow.postMessage(data, '*');
        }
    }

    // Live CSS Custom Property Update
    window.updateThemeVar = function (varName, value) {
        sendPreviewMessage({
            type: 'UPDATE_STYLE',
            variable: varName,
            value: value
        });
    };

    // Normalize Image URLs (e.g. Unsplash webpage URLs, Google Drive, Dropbox)
    window.normalizeImageUrl = function (url) {
        if (!url) return '';
        url = url.trim();

        // Unsplash Webpage URL (e.g. https://unsplash.com/photos/ganesha-statue-with-golden-crown-aTPeCFMdv88 or https://unsplash.com/photos/aTPeCFMdv88)
        const unsplashMatch = url.match(/unsplash\.com\/photos\/(?:[\w-]+-)?([a-zA-Z0-9_-]+)/i);
        if (unsplashMatch && unsplashMatch[1] && !url.includes('images.unsplash.com')) {
            return `https://unsplash.com/photos/${unsplashMatch[1]}/download?force=true&w=1600`;
        }

        // Google Drive Share Link
        const gDriveMatch = url.match(/drive\.google\.com\/(?:file\/d\/|open\?id=)([a-zA-Z0-9_-]+)/i);
        if (gDriveMatch && gDriveMatch[1]) {
            return `https://drive.google.com/uc?export=download&id=${gDriveMatch[1]}`;
        }

        // Dropbox share link
        if (url.includes('dropbox.com') && url.includes('dl=0')) {
            return url.replace('dl=0', 'raw=1');
        }

        return url;
    };

    // Live Page Background & Texture Update
    window.updatePageBg = function (color, imageUrl, opacity) {
        const normalizedUrl = imageUrl ? window.normalizeImageUrl(imageUrl) : '';
        sendPreviewMessage({
            type: 'UPDATE_PAGE_BG',
            color: color,
            imageUrl: normalizedUrl,
            opacity: opacity !== undefined ? opacity : 0.45
        });
    };

    // Handle Opacity Slider Drag & Sync across UI
    window.handleBgOpacityChange = function (val) {
        const percent = parseInt(val, 10);
        const floatVal = percent / 100;

        const s1 = document.getElementById('opt-bg-opacity');
        const s2 = document.getElementById('opt-bg-opacity-design');
        const t1 = document.getElementById('val-bg-opacity');
        const t2 = document.getElementById('val-bg-opacity-design');

        if (s1 && s1.value != percent) s1.value = percent;
        if (s2 && s2.value != percent) s2.value = percent;
        if (t1) t1.innerText = percent + '%';
        if (t2) t2.innerText = percent + '%';

        const secColor = document.getElementById('opt-secondary-color')?.value || '#0F172A';
        const coverImg = document.getElementById('opt-cover-image')?.value || '';
        window.updatePageBg(secColor, coverImg, floatVal);
    };

    // Handle Cover Image Input (Auto-normalize on paste or typing & Server Fetch)
    let _coverIngestTimer = null;
    window.handleCoverImageInput = function (input) {
        const raw = input.value.trim();
        const secColor = document.getElementById('opt-secondary-color')?.value || '#0F172A';
        const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 45) / 100;

        if (!raw) {
            window.updatePageBg(secColor, '', opacityVal);
            return;
        }

        const normalized = window.normalizeImageUrl(raw);
        window.updatePageBg(secColor, normalized, opacityVal);

        // If it's a remote URL that needs server downloading & caching
        if ((raw.startsWith('http://') || raw.startsWith('https://')) && !raw.includes('/uploads/invitations/')) {
            clearTimeout(_coverIngestTimer);
            _coverIngestTimer = setTimeout(() => {
                const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
                if (!invId) return;

                window.showToast('Fetching and caching image... ⏳', 'info');

                fetch(`/invitations/builder/${invId}/ingest-remote-url`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ url: raw, type: 'cover' })
                })
                .then(res => res.json())
                .then(d => {
                    if (d.success && d.url) {
                        input.value = d.url;
                        window.updatePageBg(secColor, d.url, opacityVal);
                        window.showToast('Remote image loaded & applied! ✨', 'success');
                    }
                })
                .catch(err => {
                    console.error('Remote image ingestion error:', err);
                });
            }, 600);
        }
    };

    // Handle Local Image File Upload via AJAX
    window.handleCoverImageUpload = function (fileInput) {
        if (!fileInput.files || !fileInput.files[0]) return;
        const file = fileInput.files[0];
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('type', 'cover');

        window.showToast('Uploading image... ⏳', 'info');

        fetch(`/invitations/builder/${invId}/upload-asset`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(d => {
            if (d.success && d.url) {
                const coverInput = document.getElementById('opt-cover-image');
                if (coverInput) coverInput.value = d.url;

                const secColor = document.getElementById('opt-secondary-color')?.value || '#0F172A';
                const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 50) / 100;
                window.updatePageBg(secColor, d.url, opacityVal);

                window.showToast('Background image uploaded & applied! ✨', 'success');
            } else {
                window.showToast(d.message || 'Image upload failed', 'error');
            }
        })
        .catch(err => {
            console.error('Upload error:', err);
            window.showToast('Failed to upload image', 'error');
        });
    };

    // Trigger Per-Section Card Image File Upload
    window.triggerSectionImageUpload = function (sectionId) {
        let input = document.getElementById(`sec-file-upload-${sectionId}`);
        if (!input) {
            input = document.createElement('input');
            input.type = 'file';
            input.id = `sec-file-upload-${sectionId}`;
            input.accept = 'image/*';
            input.style.display = 'none';
            input.onchange = function () { window.handleSectionImageUpload(this, sectionId); };
            document.body.appendChild(input);
        }
        input.click();
    };

    // Handle Per-Section Card Image File Upload via AJAX
    window.handleSectionImageUpload = function (fileInput, sectionId) {
        if (!fileInput.files || !fileInput.files[0]) return;
        const file = fileInput.files[0];
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('type', 'card');

        window.showToast('Uploading section card image... ⏳', 'info');

        fetch(`/invitations/builder/${invId}/upload-asset`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(d => {
            if (d.success && d.url) {
                const bgInput = document.getElementById(`sec-bg-image-${sectionId}`);
                if (bgInput) bgInput.value = d.url;

                const cardBg = document.getElementById(`sec-card-bg-${sectionId}`)?.value || '#0F172A';
                const cardBorder = document.getElementById(`sec-card-border-${sectionId}`)?.value || '#D4AF37';
                const cardText = document.getElementById(`sec-card-text-${sectionId}`)?.value || '#E2E8F0';

                window.updateSectionStyle(sectionId, '', cardBg, cardBorder, cardText, d.url);
                window.showToast('Section card image uploaded! ✨', 'success');
            } else {
                window.showToast(d.message || 'Image upload failed', 'error');
            }
        })
        .catch(err => {
            console.error('Section upload error:', err);
            window.showToast('Failed to upload image', 'error');
        });
    };

    // Live Global Card Styling Update
    window.updateCardStyle = function (cardBg, cardBorder, cardText, cardRadius) {
        sendPreviewMessage({
            type: 'UPDATE_CARD_STYLE',
            cardBg: cardBg,
            cardBorder: cardBorder,
            cardText: cardText,
            cardRadius: cardRadius
        });
    };

    // Live Per-Section Card Styling Update
    window.updateSectionStyle = function (sectionId, sectionType, cardBg, cardBorder, cardText, bgImage) {
        sendPreviewMessage({
            type: 'UPDATE_SECTION_STYLE',
            sectionId: sectionId,
            sectionType: sectionType,
            cardBg: cardBg,
            cardBorder: cardBorder,
            cardText: cardText,
            bgImage: bgImage
        });
    };

    // Live Location Details Update
    window.updateLocationPreview = function (venueName, venueAddress, cityDisplay, googleMapsUrl) {
        sendPreviewMessage({
            type: 'UPDATE_LOCATION',
            venueName: venueName,
            venueAddress: venueAddress,
            cityDisplay: cityDisplay,
            googleMapsUrl: googleMapsUrl
        });
    };

    // Live Text Synchronization
    window.syncLiveText = function (elementId, value) {
        sendPreviewMessage({
            type: 'UPDATE_TEXT',
            elementId: elementId,
            value: value
        });
    };

    // Live Section Content Title/Subtitle Sync
    window.syncLiveSectionText = function (sectionId, sectionType, title, subtitle) {
        sendPreviewMessage({
            type: 'UPDATE_SECTION_CONTENT',
            sectionId: sectionId,
            sectionType: sectionType,
            title: title,
            subtitle: subtitle
        });
    };

    // Soft-refresh the iframe preview without reloading builder page
    window.refreshPreviewIframe = function () {
        sendPreviewMessage({ type: 'REFRESH_PREVIEW' });
    };

    // 5. Section Toggle & Persistence
    window.toggleSectionVisibility = function (invitationId, sectionId, isEnabled, sectionType) {
        if (typeof isEnabled === 'undefined') {
            isEnabled = sectionId;
            sectionId = invitationId;
            invitationId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        }

        // Instant Live Preview Animation
        sendPreviewMessage({
            type: 'TOGGLE_SECTION',
            sectionId: sectionId,
            sectionType: sectionType,
            enabled: isEnabled
        });

        // Persist to Database via AJAX
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
                if (data.success) {
                    window.showToast(`${sectionType ? sectionType.replace('_', ' ') : 'Section'} ${isEnabled ? 'enabled' : 'hidden'}`, 'success');
                }
            })
            .catch(err => {
                console.error('Error saving section visibility:', err);
                window.showToast('Failed to save section status', 'error');
            });
        }
    };

    // 6. Save Basics
    window.saveBasics = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-save-basics');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 45) / 100;
        const data = {
            title: document.getElementById('opt-title')?.value,
            slug: document.getElementById('opt-slug')?.value,
            event_date: document.getElementById('opt-event-date')?.value,
            cover_image: document.getElementById('opt-cover-image')?.value,
            bg_opacity: opacityVal
        };

        fetch(`/invitations/builder/${invId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('General basics saved successfully! ✨', 'success');
                // Live sync title
                if (data.title) {
                    window.syncLiveText('hero-title', data.title);
                    const titleInput = document.getElementById('builder-title-input');
                    if (titleInput) titleInput.value = data.title;
                }
            } else {
                window.showToast(d.message || 'Error saving basics', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Network error while saving basics', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // Save & Continue Step 1 -> Step 2
    window.saveBasicsAndNext = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-next-basics') || document.getElementById('btn-save-basics');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 45) / 100;
        const data = {
            title: document.getElementById('opt-title')?.value,
            slug: document.getElementById('opt-slug')?.value,
            event_date: document.getElementById('opt-event-date')?.value,
            cover_image: document.getElementById('opt-cover-image')?.value,
            bg_opacity: opacityVal
        };

        fetch(`/invitations/builder/${invId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Basics saved! Moving to Design 🎨', 'success');
                if (data.title) {
                    window.syncLiveText('hero-title', data.title);
                    const titleInput = document.getElementById('builder-title-input');
                    if (titleInput) titleInput.value = data.title;
                }
                window.goToTab('theme');
            } else {
                window.showToast(d.message || 'Error saving basics', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Network error while saving basics', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // 7. Save Theme & Design
    window.saveDesign = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-save-design');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Updating Design... ⏳</span>'; }

        const primaryColor = document.getElementById('opt-primary-color')?.value;
        const secondaryColor = document.getElementById('opt-secondary-color')?.value;
        const headingFont = document.getElementById('opt-heading-font')?.value;
        const animationStyle = document.getElementById('opt-animation-style')?.value;
        const coverImage = document.getElementById('opt-cover-image')?.value;
        const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 45) / 100;

        const data = {
            primary_color: primaryColor,
            secondary_color: secondaryColor,
            font_family_heading: headingFont,
            animation_style: animationStyle,
            cover_image: coverImage,
            bg_opacity: opacityVal
        };

        fetch(`/invitations/builder/${invId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Design & Colors updated! ✨', 'success');
                // Live sync to preview
                window.updateThemeVar('--invite-primary', primaryColor);
                window.updateThemeVar('--gold-primary', primaryColor);
                window.updatePageBg(secondaryColor, coverImage);
                window.refreshPreviewIframe();
            } else {
                window.showToast(d.message || 'Error updating design', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to update design', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // Save & Continue Step 2 -> Step 3
    window.saveDesignAndNext = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-next-design') || document.getElementById('btn-save-design');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const primaryColor = document.getElementById('opt-primary-color')?.value;
        const secondaryColor = document.getElementById('opt-secondary-color')?.value;
        const headingFont = document.getElementById('opt-heading-font')?.value;
        const animationStyle = document.getElementById('opt-animation-style')?.value;
        const coverImage = document.getElementById('opt-cover-image')?.value;
        const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 45) / 100;

        const data = {
            primary_color: primaryColor,
            secondary_color: secondaryColor,
            font_family_heading: headingFont,
            animation_style: animationStyle,
            cover_image: coverImage,
            bg_opacity: opacityVal
        };

        fetch(`/invitations/builder/${invId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Design updated! Moving to Location 📍', 'success');
                window.updateThemeVar('--invite-primary', primaryColor);
                window.updateThemeVar('--gold-primary', primaryColor);
                window.updatePageBg(secondaryColor, coverImage);
                window.refreshPreviewIframe();
                window.goToTab('location');
            } else {
                window.showToast(d.message || 'Error updating design', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to update design', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // 8. Save Location & Venue
    window.saveLocationDetails = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-save-location');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving Location... ⏳</span>'; }

        const venueName = document.getElementById('loc-venue-name')?.value;
        const venueAddress = document.getElementById('loc-venue-address')?.value;
        const cityDisplay = document.getElementById('loc-city-display')?.value;
        const googleMapsUrl = document.getElementById('loc-maps-url')?.value;
        const mapEmbedUrl = document.getElementById('loc-map-embed')?.value;
        const airportDist = document.getElementById('loc-airport')?.value;
        const trainDist = document.getElementById('loc-train')?.value;
        const landmark = document.getElementById('loc-landmark')?.value;
        const description = document.getElementById('loc-description')?.value;
        const directionsNotes = document.getElementById('loc-notes')?.value;

        const data = {
            venue_name: venueName,
            venue_address: venueAddress,
            city_display: cityDisplay,
            google_maps_url: googleMapsUrl,
            map_embed_url: mapEmbedUrl,
            airport_distance: airportDist,
            train_distance: trainDist,
            landmark: landmark,
            description: description,
            directions_notes: directionsNotes
        };

        fetch(`/invitations/builder/${invId}/location/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Location & Venue details saved! 📍', 'success');
                window.updateLocationPreview(venueName, venueAddress, cityDisplay, d.location?.google_maps_url || googleMapsUrl);
                window.refreshPreviewIframe();
            } else {
                window.showToast(d.message || 'Failed to save location', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Network error while saving location', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // Save & Continue Step 3 -> Step 4
    window.saveLocationAndNext = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-next-location') || document.getElementById('btn-save-location');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const venueName = document.getElementById('loc-venue-name')?.value;
        const venueAddress = document.getElementById('loc-venue-address')?.value;
        const cityDisplay = document.getElementById('loc-city-display')?.value;
        const googleMapsUrl = document.getElementById('loc-maps-url')?.value;
        const mapEmbedUrl = document.getElementById('loc-map-embed')?.value;
        const airportDist = document.getElementById('loc-airport')?.value;
        const trainDist = document.getElementById('loc-train')?.value;
        const landmark = document.getElementById('loc-landmark')?.value;
        const description = document.getElementById('loc-description')?.value;
        const directionsNotes = document.getElementById('loc-notes')?.value;

        const data = {
            venue_name: venueName,
            venue_address: venueAddress,
            city_display: cityDisplay,
            google_maps_url: googleMapsUrl,
            map_embed_url: mapEmbedUrl,
            airport_distance: airportDist,
            train_distance: trainDist,
            landmark: landmark,
            description: description,
            directions_notes: directionsNotes
        };

        fetch(`/invitations/builder/${invId}/location/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Location saved! Moving to Sections 📑', 'success');
                window.updateLocationPreview(venueName, venueAddress, cityDisplay, d.location?.google_maps_url || googleMapsUrl);
                window.refreshPreviewIframe();
                window.goToTab('sections');
            } else {
                window.showToast(d.message || 'Failed to save location', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Network error while saving location', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // 9. Save Section Particulars & Custom Card Styling
    window.saveSectionParticulars = function (sectionId, sectionType) {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById(`btn-save-sec-${sectionId}`);
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const title = document.getElementById('sec-title-' + sectionId)?.value;
        const subtitle = document.getElementById('sec-subtitle-' + sectionId)?.value;
        const content = {};
        const settings = {};

        // Custom Card Styles
        const cardBg = document.getElementById('sec-card-bg-' + sectionId)?.value;
        const cardBorder = document.getElementById('sec-card-border-' + sectionId)?.value;
        const cardText = document.getElementById('sec-card-text-' + sectionId)?.value;
        const bgImage = document.getElementById('sec-bg-image-' + sectionId)?.value;
        const cardStyle = document.getElementById('sec-card-style-' + sectionId)?.value;

        if (cardBg) settings.card_bg_color = cardBg;
        if (cardBorder) settings.card_border_color = cardBorder;
        if (cardText) settings.card_text_color = cardText;
        if (bgImage) settings.bg_image = bgImage;
        if (cardStyle) settings.card_style = cardStyle;

        // Section-specific content mapping
        if (sectionType === 'hero' || sectionType === 'couple') {
            content.groom_name = document.getElementById('sec-groom-' + sectionId)?.value;
            content.bride_name = document.getElementById('sec-bride-' + sectionId)?.value;
            content.city_display = document.getElementById('sec-city-' + sectionId)?.value;
            content.groom_bio = document.getElementById('sec-groom-bio-' + sectionId)?.value;
            content.bride_bio = document.getElementById('sec-bride-bio-' + sectionId)?.value;
            content.story = document.getElementById('sec-story-' + sectionId)?.value;
        } else if (sectionType === 'venue') {
            content.venue_name = document.getElementById('sec-venue-name-' + sectionId)?.value;
            content.venue_address = document.getElementById('sec-venue-address-' + sectionId)?.value;
            content.description = document.getElementById('sec-venue-desc-' + sectionId)?.value;
            content.airport_distance = document.getElementById('sec-airport-' + sectionId)?.value;
            content.train_distance = document.getElementById('sec-train-' + sectionId)?.value;
            content.google_maps_url = document.getElementById('sec-maps-url-' + sectionId)?.value;
        } else if (sectionType === 'map') {
            content.venue_name = document.getElementById('sec-map-venue-' + sectionId)?.value;
            content.venue_address = document.getElementById('sec-map-address-' + sectionId)?.value;
            content.google_maps_url = document.getElementById('sec-map-link-' + sectionId)?.value;
            content.map_embed_url = document.getElementById('sec-map-embed-' + sectionId)?.value;
        } else if (sectionType === 'dress_code') {
            content.mehendi = document.getElementById('sec-dress-mehendi-' + sectionId)?.value;
            content.haldi = document.getElementById('sec-dress-haldi-' + sectionId)?.value;
            content.wedding = document.getElementById('sec-dress-wedding-' + sectionId)?.value;
        } else if (sectionType === 'family') {
            content.parents_bride = document.getElementById('sec-fam-bride-' + sectionId)?.value;
            content.parents_groom = document.getElementById('sec-fam-groom-' + sectionId)?.value;
        } else if (sectionType === 'video') {
            content.video_url = document.getElementById('sec-video-url-' + sectionId)?.value;
        }

        fetch(`/invitations/builder/${invId}/section/${sectionId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                title: title,
                subtitle: subtitle,
                content: content,
                settings: settings
            })
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast(`${sectionType ? sectionType.replace('_', ' ') : 'Section'} saved! ✨`, 'success');
                // Live broadcast style & text updates
                window.updateSectionStyle(sectionId, sectionType, cardBg, cardBorder, cardText, bgImage);
                window.syncLiveSectionText(sectionId, sectionType, title, subtitle);
                window.refreshPreviewIframe();
            } else {
                window.showToast(d.message || 'Failed to update section', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to save section', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // 10. Save Event Particulars
    window.saveEventDetails = function (eventId) {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById(`btn-save-event-${eventId}`);
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const data = {
            title: document.getElementById('ev-title-' + eventId)?.value,
            event_date: document.getElementById('ev-date-' + eventId)?.value,
            start_time: document.getElementById('ev-start-' + eventId)?.value,
            end_time: document.getElementById('ev-end-' + eventId)?.value,
            venue_name: document.getElementById('ev-venue-' + eventId)?.value,
            venue_address: document.getElementById('ev-address-' + eventId)?.value,
            dress_code: document.getElementById('ev-dress-' + eventId)?.value,
            icon: document.getElementById('ev-icon-' + eventId)?.value
        };

        fetch(`/invitations/builder/${invId}/event/${eventId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Event particulars saved! 📅', 'success');
                window.refreshPreviewIframe();
            } else {
                window.showToast(d.message || 'Failed to update event', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Network error saving event', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // 11. Add New Event
    window.addNewEvent = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const title = document.getElementById('new-event-title')?.value;
        const date = document.getElementById('new-event-date')?.value;
        const venue = document.getElementById('new-event-venue')?.value;

        if (!title) return window.showToast('Please enter an event title', 'warning');

        fetch(`/invitations/builder/${invId}/event/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ title: title, event_date: date, venue_name: venue })
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Event added! ✨', 'success');
                window.refreshPreviewIframe();
                setTimeout(() => window.location.reload(), 600);
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to add event', 'error');
        });
    };

    // 12. Delete Event
    window.deleteEvent = function (eventId) {
        if (!confirm('Remove this event from your itinerary?')) return;
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;

        fetch(`/invitations/builder/${invId}/event/${eventId}/delete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Event removed', 'info');
                window.refreshPreviewIframe();
                const card = document.getElementById(`event-panel-${eventId}`);
                if (card) card.remove();
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to delete event', 'error');
        });
    };

    // 13. Save RSVP Settings
    window.saveRsvp = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-save-rsvp');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const data = {
            deadline: document.getElementById('opt-rsvp-deadline')?.value,
            max_party_size: document.getElementById('opt-rsvp-max-party')?.value,
            allow_guest_plus_one: document.getElementById('opt-rsvp-plus-one')?.checked ? 1 : 0
        };

        fetch(`/invitations/builder/${invId}/rsvp/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('RSVP settings saved! 📝', 'success');
                window.refreshPreviewIframe();
            } else {
                window.showToast(d.message || 'Error saving RSVP', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to save RSVP', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // Save & Continue Step 6 -> Step 7
    window.saveRsvpAndNext = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-next-rsvp') || document.getElementById('btn-save-rsvp');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const data = {
            deadline: document.getElementById('opt-rsvp-deadline')?.value,
            max_party_size: document.getElementById('opt-rsvp-max-party')?.value,
            allow_guest_plus_one: document.getElementById('opt-rsvp-plus-one')?.checked ? 1 : 0
        };

        fetch(`/invitations/builder/${invId}/rsvp/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('RSVP saved! Moving to Media 🎵', 'success');
                window.refreshPreviewIframe();
                window.goToTab('media');
            } else {
                window.showToast(d.message || 'Error saving RSVP', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to save RSVP', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // 14. Save Media & Audio
    window.saveMedia = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-save-media');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const data = {
            music_url: document.getElementById('opt-music-url')?.value
        };

        fetch(`/invitations/builder/${invId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Music & Media saved! 🎵', 'success');
                window.refreshPreviewIframe();
            } else {
                window.showToast(d.message || 'Error saving media', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to save media', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // Save & Continue Step 7 -> Step 8
    window.saveMediaAndNext = function () {
        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const btn = document.getElementById('btn-next-media') || document.getElementById('btn-save-media');
        const oldText = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<span>Saving... ⏳</span>'; }

        const data = {
            music_url: document.getElementById('opt-music-url')?.value
        };

        fetch(`/invitations/builder/${invId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Media saved! Moving to AI Studio 🪄', 'success');
                window.refreshPreviewIframe();
                window.goToTab('ai');
            } else {
                window.showToast(d.message || 'Error saving media', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to save media', 'error');
        })
        .finally(() => {
            if (btn) { btn.disabled = false; btn.innerHTML = oldText; }
        });
    };

    // 15. Master Top-Bar Save Draft Button
    window.saveMasterDraft = function () {
        const topBtn = document.getElementById('btn-top-save-draft');
        const oldHtml = topBtn ? topBtn.innerHTML : '';
        if (topBtn) {
            topBtn.disabled = true;
            topBtn.innerHTML = '<span>Saving Draft... ⏳</span>';
        }

        const invId = document.getElementById('builder-invitation-id')?.value || window.BUILDER_INVITATION_ID;
        const title = document.getElementById('builder-title-input')?.value || document.getElementById('opt-title')?.value;
        const slug = document.getElementById('opt-slug')?.value;
        const eventDate = document.getElementById('opt-event-date')?.value;
        const coverImage = document.getElementById('opt-cover-image')?.value;
        const primaryColor = document.getElementById('opt-primary-color')?.value;
        const secondaryColor = document.getElementById('opt-secondary-color')?.value;
        const headingFont = document.getElementById('opt-heading-font')?.value;
        const animationStyle = document.getElementById('opt-animation-style')?.value;
        const musicUrl = document.getElementById('opt-music-url')?.value;
        const opacityVal = (document.getElementById('opt-bg-opacity')?.value || 45) / 100;

        const data = {
            title: title,
            slug: slug,
            event_date: eventDate,
            cover_image: coverImage,
            bg_opacity: opacityVal,
            primary_color: primaryColor,
            secondary_color: secondaryColor,
            font_family_heading: headingFont,
            animation_style: animationStyle,
            music_url: musicUrl
        };

        fetch(`/invitations/builder/${invId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(d => {
            if (d.success) {
                window.showToast('Full Draft Saved Successfully! 💾✨', 'success');
                window.refreshPreviewIframe();
            } else {
                window.showToast(d.message || 'Error saving draft', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Network error saving draft', 'error');
        })
        .finally(() => {
            if (topBtn) {
                topBtn.disabled = false;
                topBtn.innerHTML = oldHtml;
            }
        });
    };

    // 16. Dynamic Pricing Calculator
    window.recalculatePricing = function () {
        const templateId = document.getElementById('builder-template-id')?.value;
        const currency = document.getElementById('pricing-currency')?.value || 'INR';
        const coupon = document.getElementById('pricing-coupon-input')?.value || '';

        const selectedFeatures = [];
        document.querySelectorAll('.feature-checkbox:checked').forEach(cb => {
            selectedFeatures.push(cb.value);
        });

        const pricingSummary = document.getElementById('pricing-summary-box');
        if (pricingSummary) pricingSummary.style.opacity = '0.6';

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

    // 17. Section Editor Accordion Toggle
    window.toggleSectionEditor = function (sectionId) {
        const editor = document.getElementById('section-editor-' + sectionId);
        if (editor) {
            editor.style.display = editor.style.display === 'none' ? 'block' : 'none';
        }
    };

    // 18. Event Editor Accordion Toggle
    window.toggleEventEditor = function (eventId) {
        const editor = document.getElementById('event-editor-' + eventId);
        if (editor) {
            editor.style.display = editor.style.display === 'none' ? 'block' : 'none';
        }
    };

    // 19. AI Copywriter Trigger
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

    // Initialize listeners on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.feature-checkbox').forEach(cb => {
            cb.addEventListener('change', window.recalculatePricing);
        });
    });

})();
