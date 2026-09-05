<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for the Digital Invitation Platform.
     */
    public function up(): void
    {
        // 1. Invitation Categories
        Schema::create('invitation_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // SVG icon or emoji
            $table->string('banner_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->index(['is_active', 'sort_order']);
        });

        // 2. Invitation Subcategories
        Schema::create('invitation_subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('invitation_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['category_id', 'slug']);
            $table->index(['category_id', 'is_active', 'sort_order']);
        });

        // 3. Invitation Templates
        Schema::create('invitation_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('invitation_categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('invitation_subcategories')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('preview_url')->nullable();
            $table->json('theme_config')->nullable(); // colors, fonts, default animations, background style
            $table->boolean('is_premium')->default(false);
            $table->decimal('base_price_inr', 10, 2)->default(0.00);
            $table->decimal('base_price_usd', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('use_count')->default(0);
            $table->json('tags')->nullable(); // e.g. ["luxury", "gold", "traditional", "minimalist"]
            $table->timestamps();
            $table->softDeletes();
            $table->index(['is_active', 'is_featured', 'sort_order' => 'created_at']);
        });

        // 4. Invitation Template Sections
        Schema::create('invitation_template_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('invitation_templates')->onDelete('cascade');
            $table->string('section_type'); // hero, couple, introduction, events, timeline, countdown, gallery, video, music, venue, map, family, dress_code, rsvp, guestbook, qr, contact, footer
            $table->string('default_title')->nullable();
            $table->string('default_subtitle')->nullable();
            $table->json('default_content')->nullable();
            $table->json('default_settings')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(false);
            $table->timestamps();
            $table->index(['template_id', 'sort_order']);
        });

        // 5. Invitation Template Assets
        Schema::create('invitation_template_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('invitation_templates')->onDelete('cascade');
            $table->string('asset_type'); // background, border, ornament, music, font, sticker
            $table->string('name');
            $table->string('file_url');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        // 6. Invitation Features
        Schema::create('invitation_features', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // rsvp_custom_form, guest_qr_checkin, background_music, photo_gallery_unlimited, custom_domain, export_pdf, ai_copywriter, multi_event_timeline
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 7. Invitation Feature Prices
        Schema::create('invitation_feature_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->constrained('invitation_features')->onDelete('cascade');
            $table->string('currency', 10)->default('INR'); // INR, USD
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('tier_capacity')->nullable(); // null or 50, 100, 500, unlimited guests
            $table->timestamps();
            $table->index(['feature_id', 'currency']);
        });

        // 8. Invitations (Customer Created)
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained('invitation_templates')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->string('status')->default('draft'); // draft, published, expired, archived
            $table->string('password_protected')->nullable(); // hashed access pin/password if private
            $table->string('music_url')->nullable();
            $table->boolean('music_autoplay')->default(false);
            $table->string('primary_color', 30)->default('#D4AF37');
            $table->string('secondary_color', 30)->default('#0F172A');
            $table->string('accent_color', 30)->default('#F59E0B');
            $table->string('font_family_heading', 100)->default('Playfair Display');
            $table->string('font_family_body', 100)->default('Outfit');
            $table->string('animation_style', 50)->default('luxury_fade'); // luxury_fade, petals_fall, sparkles_float, golden_shimmer, confetti, minimalist
            $table->string('custom_domain')->nullable();
            $table->longText('custom_css')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_image_url')->nullable();
            $table->json('selected_features')->nullable(); // array of enabled feature codes
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id', 'status']);
            $table->index('slug');
        });

        // 9. Invitation Sections
        Schema::create('invitation_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('section_type'); // hero, couple, introduction, events, timeline, countdown, gallery, video, music, venue, map, family, dress_code, rsvp, guestbook, qr, contact, footer
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->json('content')->nullable();
            $table->json('settings')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
            $table->index(['invitation_id', 'sort_order']);
        });

        // 10. Invitation Events
        Schema::create('invitation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('title');
            $table->date('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->decimal('map_latitude', 10, 8)->nullable();
            $table->decimal('map_longitude', 11, 8)->nullable();
            $table->string('dress_code')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['invitation_id', 'sort_order']);
        });

        // 11. Invitation Assets
        Schema::create('invitation_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('asset_type'); // gallery_image, video_url, background_music, attachment, cover_photo
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('file_size')->default(0);
            $table->timestamps();
            $table->index(['invitation_id', 'asset_type', 'sort_order']);
        });

        // 12. Invitation Forms (RSVP)
        Schema::create('invitation_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('title')->default('RSVP to Our Celebration');
            $table->text('description')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->integer('max_party_size')->default(5);
            $table->boolean('allow_guest_plus_one')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 13. Invitation Form Fields
        Schema::create('invitation_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('invitation_forms')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained('invitation_events')->onDelete('cascade');
            $table->string('field_type'); // text, textarea, number, email, phone, radio, checkbox, dropdown, yes_no, date, file_upload, rating
            $table->string('label');
            $table->string('placeholder')->nullable();
            $table->json('options')->nullable(); // For select, radio, checkboxes
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('conditional_rules')->nullable();
            $table->timestamps();
            $table->index(['form_id', 'sort_order']);
        });

        // 14. Invitation Form Responses
        Schema::create('invitation_form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('invitation_forms')->onDelete('cascade');
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->string('guest_name');
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('attending_status')->default('attending'); // attending, declined, maybe
            $table->integer('party_size')->default(1);
            $table->string('dietary_preferences')->nullable();
            $table->text('notes')->nullable();
            $table->json('answers')->nullable(); // Dynamic field responses
            $table->timestamp('submitted_at')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->index(['invitation_id', 'attending_status']);
        });

        // 15. Invitation Guests
        Schema::create('invitation_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('guest_code')->unique(); // e.g. GST-9X2Y7 for secure URLs
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('group_name')->nullable(); // Family, VIP, Friends, Colleagues
            $table->integer('allocated_seats')->default(1);
            $table->string('attending_status')->default('pending'); // pending, attending, declined, tentative
            $table->boolean('is_vip')->default(false);
            $table->boolean('check_in_status')->default(false);
            $table->timestamp('checked_in_at')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->text('custom_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['invitation_id', 'group_name']);
            $table->index(['invitation_id', 'attending_status']);
        });

        // 16. Invitation Guest Events (Specific Event Allocations)
        Schema::create('invitation_guest_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('invitation_guests')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('invitation_events')->onDelete('cascade');
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->boolean('is_invited')->default(true);
            $table->string('attending_status')->default('pending'); // pending, confirmed, declined
            $table->timestamps();
            $table->unique(['guest_id', 'event_id']);
        });

        // 17. Invitation Guest Responses
        Schema::create('invitation_guest_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('invitation_guests')->onDelete('cascade');
            $table->foreignId('form_field_id')->constrained('invitation_form_fields')->onDelete('cascade');
            $table->text('response_value')->nullable();
            $table->timestamps();
            $table->unique(['guest_id', 'form_field_id']);
        });

        // 18. Invitation QR Codes
        Schema::create('invitation_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('qr_type'); // invitation_link, rsvp_direct, guest_checkin, gallery_upload, wifi_access
            $table->text('target_url');
            $table->string('code_string');
            $table->string('foreground_color', 30)->default('#0F172A');
            $table->string('background_color', 30)->default('#FFFFFF');
            $table->string('logo_url')->nullable();
            $table->json('style_options')->nullable();
            $table->unsignedBigInteger('download_count')->default(0);
            $table->unsignedBigInteger('scan_count')->default(0);
            $table->timestamps();
            $table->index(['invitation_id', 'qr_type']);
        });

        // 19. Invitation Analytics
        Schema::create('invitation_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('event_type'); // page_view, rsvp_open, rsvp_submit, qr_scan, music_play, map_click, calendar_add, share_click
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 30)->default('mobile'); // mobile, tablet, desktop
            $table->text('referrer')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('city', 100)->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['invitation_id', 'event_type', 'created_at']);
        });

        // 20. Invitation Coupons
        Schema::create('invitation_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('discount_type')->default('percentage'); // percentage, fixed
            $table->decimal('discount_value', 10, 2);
            $table->decimal('min_order_amount', 10, 2)->default(0.00);
            $table->string('currency', 10)->default('INR');
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 21. Invitation Orders
        Schema::create('invitation_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('invitation_id')->nullable()->constrained('invitations')->onDelete('set null');
            $table->foreignId('template_id')->nullable()->constrained('invitation_templates')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('INR');
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->string('coupon_code')->nullable();
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('final_amount', 10, 2);
            $table->string('payment_gateway')->default('razorpay'); // razorpay, paypal, upi_qr
            $table->string('gateway_order_id')->nullable();
            $table->string('gateway_payment_id')->nullable();
            $table->string('status')->default('pending'); // pending, completed, failed, refunded
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
        });

        // 22. Invitation Order Items
        Schema::create('invitation_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('invitation_orders')->onDelete('cascade');
            $table->string('item_type'); // template, feature, guest_tier, duration_extension
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_name');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // 23. Invitation Payments
        Schema::create('invitation_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('invitation_orders')->onDelete('cascade');
            $table->string('transaction_ref')->nullable();
            $table->string('gateway');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('INR');
            $table->string('status')->default('pending');
            $table->json('raw_payload')->nullable();
            $table->timestamps();
        });

        // 24. Invitation Share Links
        Schema::create('invitation_share_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('channel'); // whatsapp, email, sms, instagram, facebook, copy_link
            $table->text('custom_message')->nullable();
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->unsignedBigInteger('shares_count')->default(0);
            $table->timestamps();
            $table->index(['invitation_id', 'channel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_share_links');
        Schema::dropIfExists('invitation_payments');
        Schema::dropIfExists('invitation_order_items');
        Schema::dropIfExists('invitation_orders');
        Schema::dropIfExists('invitation_coupons');
        Schema::dropIfExists('invitation_analytics');
        Schema::dropIfExists('invitation_qr_codes');
        Schema::dropIfExists('invitation_guest_responses');
        Schema::dropIfExists('invitation_guest_events');
        Schema::dropIfExists('invitation_guests');
        Schema::dropIfExists('invitation_form_responses');
        Schema::dropIfExists('invitation_form_fields');
        Schema::dropIfExists('invitation_forms');
        Schema::dropIfExists('invitation_assets');
        Schema::dropIfExists('invitation_events');
        Schema::dropIfExists('invitation_sections');
        Schema::dropIfExists('invitations');
        Schema::dropIfExists('invitation_feature_prices');
        Schema::dropIfExists('invitation_features');
        Schema::dropIfExists('invitation_template_assets');
        Schema::dropIfExists('invitation_template_sections');
        Schema::dropIfExists('invitation_templates');
        Schema::dropIfExists('invitation_subcategories');
        Schema::dropIfExists('invitation_categories');
    }
};
