<?php

namespace Database\Seeders;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationAsset;
use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationCoupon;
use App\Models\Invitations\InvitationEvent;
use App\Models\Invitations\InvitationFeature;
use App\Models\Invitations\InvitationFeaturePrice;
use App\Models\Invitations\InvitationForm;
use App\Models\Invitations\InvitationFormField;
use App\Models\Invitations\InvitationGuest;
use App\Models\Invitations\InvitationGuestEvent;
use App\Models\Invitations\InvitationQrCode;
use App\Models\Invitations\InvitationSection;
use App\Models\Invitations\InvitationSubcategory;
use App\Models\Invitations\InvitationTemplate;
use App\Models\Invitations\InvitationTemplateSection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvitationPlatformSeeder extends Seeder
{
    /**
     * Seed initial invitation platform data.
     */
    public function run(): void
    {
        // 1. Seed Categories & Subcategories
        $categoriesData = [
            [
                'name' => 'Royal & Indian Weddings',
                'slug' => 'weddings',
                'description' => 'Opulent royal palaces, floral mandaps, gold foil calligraphy and animated multi-day wedding celebration invitations.',
                'icon' => '👑',
                'banner_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 1,
                'meta_title' => 'Luxury Digital Wedding Invitations & Multi-Day E-Invites',
                'meta_description' => 'Create stunning mobile-first wedding invitations with RSVP, guest QR codes, Google Maps, countdown, and music.',
                'subcategories' => [
                    ['name' => 'Royal Heritage & Gold Foil', 'slug' => 'royal-heritage'],
                    ['name' => 'Destination & Beach Vows', 'slug' => 'beach-destination'],
                    ['name' => 'Pastel Floral Botanical', 'slug' => 'pastel-floral'],
                    ['name' => 'Modern Minimalist Luxury', 'slug' => 'modern-minimalist'],
                ]
            ],
            [
                'name' => 'Birthday Celebrations',
                'slug' => 'birthdays',
                'description' => 'Fun, animated, vibrant birthday party invites for 1st birthdays, milestone 18th/21st/50th, kids themes and neon DJ nights.',
                'icon' => '🎂',
                'banner_url' => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 2,
                'meta_title' => 'Digital Birthday Party Invitations & Animated E-Cards',
                'meta_description' => 'Interactive animated birthday invitations with RSVP, gift registry, music, and location maps.',
                'subcategories' => [
                    ['name' => '1st Birthday Milestones', 'slug' => 'first-birthday'],
                    ['name' => 'Sweet 16 & 21st Bash', 'slug' => 'sweet-sixteen'],
                    ['name' => 'Neon Glow & Cocktail Party', 'slug' => 'cocktail-party'],
                    ['name' => 'Golden 50th & Jubilees', 'slug' => 'golden-jubilee'],
                ]
            ],
            [
                'name' => 'Engagements & Ring Ceremonies',
                'slug' => 'engagements',
                'description' => 'Romantic save-the-date invites, ring ceremony announcements, and cocktail party invitations.',
                'icon' => '💍',
                'banner_url' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 3,
                'meta_title' => 'Digital Engagement Invitations & Save The Date',
                'meta_description' => 'Celebrate your proposal and ring ceremony with interactive couple timelines and RSVP tracking.',
                'subcategories' => [
                    ['name' => 'Save The Date Teasers', 'slug' => 'save-the-date'],
                    ['name' => 'Sangeet & Ring Ceremony', 'slug' => 'ring-ceremony'],
                    ['name' => 'Rooftop & Sunset Soirée', 'slug' => 'rooftop-soiree'],
                ]
            ],
            [
                'name' => 'Baby Shower & Gender Reveal',
                'slug' => 'baby-showers',
                'description' => 'Adorable pastel clouds, teddy bears, golden stars and interactive wish-book baby shower invites.',
                'icon' => '🍼',
                'banner_url' => 'https://images.unsplash.com/photo-1519689680058-324335c77eba?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 4,
                'meta_title' => 'Digital Baby Shower Invitations & Gender Reveal Cards',
                'meta_description' => 'Cute and interactive baby shower digital invites with guest book wishes and RSVP.',
                'subcategories' => [
                    ['name' => 'Pastel Dreams & Clouds', 'slug' => 'pastel-dreams'],
                    ['name' => 'Gender Reveal Countdown', 'slug' => 'gender-reveal'],
                    ['name' => 'Godh Bharai / Traditional', 'slug' => 'traditional-baby'],
                ]
            ],
            [
                'name' => 'Anniversaries & Jubilees',
                'slug' => 'anniversaries',
                'description' => 'Silver 25th, Golden 50th and milestone love celebrations with nostalgic photo timelines.',
                'icon' => '🥂',
                'banner_url' => 'https://images.unsplash.com/photo-1532712938310-34cb3982ef74?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 5,
                'meta_title' => 'Digital Anniversary Invitations & Milestone Celebrations',
                'meta_description' => 'Honor decades of love with custom music, photo albums, and digital RSVP cards.',
                'subcategories' => [
                    ['name' => 'Silver Jubilee (25 Years)', 'slug' => 'silver-25th'],
                    ['name' => 'Golden Jubilee (50 Years)', 'slug' => 'golden-50th'],
                ]
            ],
            [
                'name' => 'Corporate & Gala Events',
                'slug' => 'corporate',
                'description' => 'Executive summits, product launches, charity galas, and annual award nights with QR pass check-in.',
                'icon' => '🏛️',
                'banner_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 6,
                'meta_title' => 'Corporate Digital Event Invitations & VIP QR Passes',
                'meta_description' => 'Professional conference and gala invitations with attendee registration, schedule, and QR ticketing.',
                'subcategories' => [
                    ['name' => 'Annual Gala & Awards', 'slug' => 'annual-gala'],
                    ['name' => 'Tech Summit & Keynote', 'slug' => 'tech-summit'],
                    ['name' => 'Product Launch Party', 'slug' => 'product-launch'],
                ]
            ]
        ];

        $createdCategories = [];
        $createdSubcategories = [];

        foreach ($categoriesData as $catData) {
            $subs = $catData['subcategories'] ?? [];
            unset($catData['subcategories']);

            $cat = InvitationCategory::updateOrCreate(['slug' => $catData['slug']], $catData);
            $createdCategories[$cat->slug] = $cat;

            foreach ($subs as $sIdx => $sData) {
                $sub = InvitationSubcategory::updateOrCreate([
                    'category_id' => $cat->id,
                    'slug' => $sData['slug']
                ], [
                    'name' => $sData['name'],
                    'sort_order' => $sIdx + 1,
                    'is_active' => true
                ]);
                $createdSubcategories[$cat->slug . '/' . $sub->slug] = $sub;
            }
        }

        // 2. Seed Features & Feature Pricing
        $featuresData = [
            [
                'code' => 'rsvp_custom_form',
                'name' => 'Dynamic RSVP Form Builder',
                'description' => 'Custom questions, dietary preferences, multi-guest attendance tracking, plus-one controls.',
                'icon' => '📝',
                'sort_order' => 1,
                'prices' => [
                    ['currency' => 'INR', 'price' => 0.00, 'tier_capacity' => 50],
                    ['currency' => 'INR', 'price' => 299.00, 'tier_capacity' => 200],
                    ['currency' => 'INR', 'price' => 599.00, 'tier_capacity' => null],
                    ['currency' => 'USD', 'price' => 0.00, 'tier_capacity' => 50],
                    ['currency' => 'USD', 'price' => 4.99, 'tier_capacity' => 200],
                    ['currency' => 'USD', 'price' => 9.99, 'tier_capacity' => null],
                ]
            ],
            [
                'code' => 'guest_qr_checkin',
                'name' => 'Guest QR Codes & Door Check-In',
                'description' => 'Generate individual QR passes for each guest and scan at venue door with mobile camera.',
                'icon' => '📱',
                'sort_order' => 2,
                'prices' => [
                    ['currency' => 'INR', 'price' => 499.00, 'tier_capacity' => null],
                    ['currency' => 'USD', 'price' => 7.99, 'tier_capacity' => null],
                ]
            ],
            [
                'code' => 'background_music',
                'name' => 'Background Ambient Music & Audio',
                'description' => 'Upload romantic melodies or party anthems with floating music player FAB & auto-play prompt.',
                'icon' => '🎵',
                'sort_order' => 3,
                'prices' => [
                    ['currency' => 'INR', 'price' => 199.00, 'tier_capacity' => null],
                    ['currency' => 'USD', 'price' => 2.99, 'tier_capacity' => null],
                ]
            ],
            [
                'code' => 'photo_gallery_unlimited',
                'name' => 'High-Res Photo Gallery & Lightbox',
                'description' => 'Showcase pre-wedding shoots, milestone moments, and interactive photo sliders.',
                'icon' => '🖼️',
                'sort_order' => 4,
                'prices' => [
                    ['currency' => 'INR', 'price' => 299.00, 'tier_capacity' => null],
                    ['currency' => 'USD', 'price' => 4.99, 'tier_capacity' => null],
                ]
            ],
            [
                'code' => 'custom_domain',
                'name' => 'Custom Vanity Domain & White-Label',
                'description' => 'Host on your personal wedding domain (e.g., priyawedsrahul.com) with SSL and no platform branding.',
                'icon' => '🌐',
                'sort_order' => 5,
                'prices' => [
                    ['currency' => 'INR', 'price' => 999.00, 'tier_capacity' => null],
                    ['currency' => 'USD', 'price' => 14.99, 'tier_capacity' => null],
                ]
            ],
            [
                'code' => 'multi_event_timeline',
                'name' => 'Multi-Event Itinerary & Map Directions',
                'description' => 'Schedule Haldi, Mehendi, Sangeet, Wedding, and Reception with individual Google Maps & Cal sync.',
                'icon' => '🗺️',
                'sort_order' => 6,
                'prices' => [
                    ['currency' => 'INR', 'price' => 0.00, 'tier_capacity' => null],
                    ['currency' => 'USD', 'price' => 0.00, 'tier_capacity' => null],
                ]
            ],
            [
                'code' => 'ai_copywriter',
                'name' => 'AI Love Story & Itinerary Writer',
                'description' => 'Generate poetic wedding vows, personalized love stories, and itinerary descriptions in seconds.',
                'icon' => '✨',
                'sort_order' => 7,
                'prices' => [
                    ['currency' => 'INR', 'price' => 149.00, 'tier_capacity' => null],
                    ['currency' => 'USD', 'price' => 1.99, 'tier_capacity' => null],
                ]
            ],
        ];

        foreach ($featuresData as $fData) {
            $prices = $fData['prices'];
            unset($fData['prices']);

            $feature = InvitationFeature::updateOrCreate(['code' => $fData['code']], $fData);
            
            foreach ($prices as $p) {
                InvitationFeaturePrice::updateOrCreate([
                    'feature_id' => $feature->id,
                    'currency' => $p['currency'],
                    'tier_capacity' => $p['tier_capacity']
                ], [
                    'price' => $p['price']
                ]);
            }
        }

        // 3. Seed Invitation Coupons
        $coupons = [
            ['code' => 'CELEBRATE50', 'discount_type' => 'percentage', 'discount_value' => 50.00, 'min_order_amount' => 0, 'currency' => 'INR', 'is_active' => true],
            ['code' => 'WEDDING20', 'discount_type' => 'percentage', 'discount_value' => 20.00, 'min_order_amount' => 500, 'currency' => 'INR', 'is_active' => true],
            ['code' => 'LAUNCH50', 'discount_type' => 'percentage', 'discount_value' => 50.00, 'min_order_amount' => 0, 'currency' => 'INR', 'is_active' => true],
            ['code' => 'ROYALPASS', 'discount_type' => 'fixed', 'discount_value' => 300.00, 'min_order_amount' => 999, 'currency' => 'INR', 'is_active' => true],
        ];

        foreach ($coupons as $c) {
            InvitationCoupon::updateOrCreate(['code' => $c['code']], $c);
        }

        // 4. Seed Curated Templates
        $weddingCat = $createdCategories['weddings'] ?? null;
        $birthdayCat = $createdCategories['birthdays'] ?? null;
        $engagementCat = $createdCategories['engagements'] ?? null;
        $corpCat = $createdCategories['corporate'] ?? null;

        $templates = [
            [
                'category_id' => $weddingCat?->id,
                'subcategory_id' => $createdSubcategories['weddings/royal-heritage']?->id ?? null,
                'name' => 'The Royal Rajwada — Opulent Gold & Emerald Palace',
                'slug' => 'royal-rajwada-palace',
                'description' => 'Regal traditional Indian wedding invitation featuring majestic palace arches, golden wax seal entrance curtain, peacock motifs, and multi-day itinerary.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/royal-rajwada-palace',
                'theme_config' => [
                    'primary_color' => '#D4AF37',
                    'secondary_color' => '#064E3B',
                    'accent_color' => '#F59E0B',
                    'bg_gradient' => 'linear-gradient(180deg, #09121d 0%, #064E3B 100%)',
                    'font_family_heading' => 'Cinzel Decorative',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'sparkles_float',
                    'envelope_style' => 'wax_seal_royal',
                    'ornament' => 'gold_mandala',
                ],
                'is_premium' => true,
                'base_price_inr' => 1499.00,
                'base_price_usd' => 19.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['royal', 'luxury', 'gold', 'indian-wedding', 'traditional', 'palace'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => 'Shubh Vivah', 'default_subtitle' => 'Together with our families, we invite you to celebrate the union of', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'couple', 'default_title' => 'The Couple', 'default_subtitle' => 'Two souls, one sacred journey', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| Shree Ganeshay Namah ||', 'default_subtitle' => 'With the divine blessings of our ancestors & almighty', 'sort_order' => 3, 'is_required' => false],
                    ['section_type' => 'events', 'default_title' => 'Celebration Itinerary', 'default_subtitle' => 'Join us across three days of joyous festivities', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'timeline', 'default_title' => 'Sacred Milestones', 'default_subtitle' => 'The timeline of events', 'sort_order' => 5, 'is_required' => false],
                    ['section_type' => 'countdown', 'default_title' => 'Counting Down to the Big Day', 'default_subtitle' => 'Every second brings us closer to forever', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'gallery', 'default_title' => 'Moments of Love', 'default_subtitle' => 'Our pre-wedding memories captured in frames', 'sort_order' => 7, 'is_required' => false],
                    ['section_type' => 'music', 'default_title' => 'Ambient Melody', 'default_subtitle' => 'Play Background Shehnai & Sitar Music', 'sort_order' => 8, 'is_required' => false],
                    ['section_type' => 'venue', 'default_title' => 'Royal Venue & Stay', 'default_subtitle' => 'Taj Lake Palace, Udaipur', 'sort_order' => 9, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Directions & Navigation', 'default_subtitle' => 'Get directions via Google Maps', 'sort_order' => 10, 'is_required' => true],
                    ['section_type' => 'dress_code', 'default_title' => 'Attire & Palette Guidelines', 'default_subtitle' => 'Royal Heritage & Traditional Indian Attire', 'sort_order' => 11, 'is_required' => false],
                    ['section_type' => 'rsvp', 'default_title' => 'Kindly RSVP', 'default_subtitle' => 'Please confirm your gracious presence by November 15', 'sort_order' => 12, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Warm Blessings & Wishes', 'default_subtitle' => 'Leave your blessings for the newlyweds', 'sort_order' => 13, 'is_required' => false],
                    ['section_type' => 'qr', 'default_title' => 'Instant Digital Pass', 'default_subtitle' => 'Scan at the welcome lounge for expedited check-in', 'sort_order' => 14, 'is_required' => false],
                    ['section_type' => 'contact', 'default_title' => 'Event Coordinators', 'default_subtitle' => 'Reach out to the family hosts for any assistance', 'sort_order' => 15, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => '#PriyaWedsRahul2026', 'default_subtitle' => 'We eagerly await your gracious presence', 'sort_order' => 16, 'is_required' => true],
                ]
            ],
            [
                'category_id' => $weddingCat?->id,
                'subcategory_id' => $createdSubcategories['weddings/pastel-floral']?->id ?? null,
                'name' => 'Elysian Bloom — Pastel Lavender & Rose Gold',
                'slug' => 'elysian-bloom-floral',
                'description' => 'Dreamy watercolor pastel blossoms, floating rose petals, soft romantic serif typography, and an interactive love story timeline.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/elysian-bloom-floral',
                'theme_config' => [
                    'primary_color' => '#E0A96D',
                    'secondary_color' => '#201A23',
                    'accent_color' => '#F472B6',
                    'bg_gradient' => 'linear-gradient(180deg, #181124 0%, #2e1a38 100%)',
                    'font_family_heading' => 'Playfair Display',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'petals_fall',
                    'envelope_style' => 'silk_ribbon',
                    'ornament' => 'floral_rose',
                ],
                'is_premium' => true,
                'base_price_inr' => 1199.00,
                'base_price_usd' => 14.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['floral', 'romantic', 'pastel', 'rose-gold', 'minimalist', 'garden-wedding'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => 'Forever Begins Today', 'default_subtitle' => 'You are cordially invited to celebrate the wedding of', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'couple', 'default_title' => 'Our Love Story', 'default_subtitle' => 'From college sweethearts to soulmates forever', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Save The Date', 'default_subtitle' => 'Counting down every magical moment', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Order of Events', 'default_subtitle' => 'The ceremony & twilight garden reception', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'gallery', 'default_title' => 'A Glimpse of Us', 'default_subtitle' => 'Our cherished memories and sunset moments', 'sort_order' => 5, 'is_required' => false],
                    ['section_type' => 'music', 'default_title' => 'Acoustic Serenade', 'default_subtitle' => 'Soft piano & strings soundtrack', 'sort_order' => 6, 'is_required' => false],
                    ['section_type' => 'venue', 'default_title' => 'The Glasshouse Botanical Resort', 'default_subtitle' => 'Bangalore, India', 'sort_order' => 7, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Google Map Directions', 'default_subtitle' => 'Click to open in Google Maps / Apple Maps', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'rsvp', 'default_title' => 'Will You Join Us?', 'default_subtitle' => 'Kindly respond before December 1st', 'sort_order' => 9, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Leave a Wish', 'default_subtitle' => 'Write a love note in our digital guestbook', 'sort_order' => 10, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => '#AaravAndTara2026', 'default_subtitle' => 'With love and gratitude', 'sort_order' => 11, 'is_required' => true],
                ]
            ],
            [
                'category_id' => $birthdayCat?->id,
                'subcategory_id' => $createdSubcategories['birthdays/first-birthday']?->id ?? null,
                'name' => 'Little Astronaut — 1st Birthday Galaxy Bash',
                'slug' => 'little-astronaut-first-birthday',
                'description' => 'Magical space adventure themed first birthday invitation with floating rockets, glowing stars, interactive milestone cards and RSVP party count.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/little-astronaut-first-birthday',
                'theme_config' => [
                    'primary_color' => '#38BDF8',
                    'secondary_color' => '#0F172A',
                    'accent_color' => '#FBBF24',
                    'bg_gradient' => 'linear-gradient(180deg, #090d16 0%, #1e1b4b 100%)',
                    'font_family_heading' => 'Outfit',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'confetti',
                    'envelope_style' => 'space_badge',
                    'ornament' => 'stars_planets',
                ],
                'is_premium' => false,
                'base_price_inr' => 499.00,
                'base_price_usd' => 6.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['birthday', '1st-birthday', 'kids', 'space', 'fun', 'colorful', 'confetti'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => "Vivaan is Turning ONE!", 'default_subtitle' => '3.. 2.. 1.. Blast off to our little astronaut’s first orbital birthday!', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Countdown to Launch', 'default_subtitle' => 'Get ready for cake, balloons and interstellar fun', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Mission Itinerary', 'default_subtitle' => 'Cake cutting, magic show, bouncy castle & dinner', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'gallery', 'default_title' => '365 Days of Cuteness', 'default_subtitle' => 'From birth to his first steps', 'sort_order' => 4, 'is_required' => false],
                    ['section_type' => 'venue', 'default_title' => 'Sky Lounge Playhouse', 'default_subtitle' => 'Indiranagar, Bangalore', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Navigation Coordinates', 'default_subtitle' => 'Map link & parking instructions', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'rsvp', 'default_title' => 'Confirm Attendance', 'default_subtitle' => 'Let us know how many mini-astronauts are coming!', 'sort_order' => 7, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Wishes for Vivaan', 'default_subtitle' => 'Leave a blessing for the birthday star', 'sort_order' => 8, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => 'Hosted with love by Rohit & Ananya', 'default_subtitle' => 'See you at the launchpad!', 'sort_order' => 9, 'is_required' => true],
                ]
            ],
            [
                'category_id' => $corpCat?->id,
                'subcategory_id' => $createdSubcategories['corporate/annual-gala']?->id ?? null,
                'name' => 'Obsidian Zenith — VIP Corporate Gala & Awards',
                'slug' => 'obsidian-zenith-corporate-gala',
                'description' => 'Ultra-sleek modern dark glassmorphism invite with golden luxury neon accents, keynote speakers, agenda, and instant QR door passes.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/obsidian-zenith-corporate-gala',
                'theme_config' => [
                    'primary_color' => '#6366F1',
                    'secondary_color' => '#030712',
                    'accent_color' => '#38BDF8',
                    'bg_gradient' => 'linear-gradient(180deg, #030712 0%, #0f172a 100%)',
                    'font_family_heading' => 'Outfit',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'golden_shimmer',
                    'envelope_style' => 'executive_metal',
                    'ornament' => 'geometric_lines',
                ],
                'is_premium' => true,
                'base_price_inr' => 2499.00,
                'base_price_usd' => 29.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['corporate', 'vip', 'gala', 'awards', 'summit', 'conference', 'qr-pass'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => 'Apex Global Summit & Awards 2026', 'default_subtitle' => 'Celebrating leadership, innovation & breakthrough AI engineering', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => 'Executive Welcome', 'default_subtitle' => 'An exclusive evening with 500+ industry pioneers', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'timeline', 'default_title' => 'Evening Agenda', 'default_subtitle' => 'Keynote, panel discussions, awards ceremony & cocktail gala', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'The St. Regis Grand Ballroom', 'default_subtitle' => 'Mumbai, India', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Venue Location', 'default_subtitle' => 'Valet parking provided at Main Gate 2', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'dress_code', 'default_title' => 'Attire Protocol', 'default_subtitle' => 'Black Tie / Formal Evening Wear', 'sort_order' => 6, 'is_required' => false],
                    ['section_type' => 'rsvp', 'default_title' => 'Delegate Registration', 'default_subtitle' => 'Confirm your seat by October 10 to receive your VIP QR Pass', 'sort_order' => 7, 'is_required' => true],
                    ['section_type' => 'qr', 'default_title' => 'Digital Entry Pass', 'default_subtitle' => 'Present this dynamic QR code at the registration desk for instant badging', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'footer', 'default_title' => 'Apex Innovation Council', 'default_subtitle' => 'All rights reserved 2026', 'sort_order' => 9, 'is_required' => true],
                ]
            ],
            [
                'category_id' => $weddingCat?->id,
                'subcategory_id' => $createdSubcategories['weddings/royal-heritage']?->id ?? null,
                'name' => 'The Peshwai Heritage — Crimson Velvet & Royal Maratha Gold',
                'slug' => 'peshwai-royal-vivah',
                'description' => 'Auspicious traditional Marathi wedding invitation with authentic Paithani border designs, Shubh Vivah calligraphy, Shehnai audio, and multi-day Saptapadi festivities.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/peshwai-royal-vivah',
                'theme_config' => [
                    'primary_color' => '#D4AF37',
                    'secondary_color' => '#580A15',
                    'accent_color' => '#E11D48',
                    'bg_gradient' => 'linear-gradient(180deg, #180306 0%, #580A15 100%)',
                    'font_family_heading' => 'Cinzel Decorative',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'golden_shimmer',
                    'envelope_style' => 'wax_seal_royal',
                    'ornament' => 'gold_mandala',
                ],
                'is_premium' => true,
                'base_price_inr' => 1299.00,
                'base_price_usd' => 16.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['marathi', 'royal', 'traditional', 'shubh-vivah', 'gold', 'paithani'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => '|| शुभ विवाह ||', 'default_subtitle' => 'सहकुटुंब सहपरिवार आपले सहर्ष स्वागत असो', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| श्री गणेशाय नमः ||', 'default_subtitle' => 'कुलदैवत व पूर्वजांच्या आशीर्वादाने', 'sort_order' => 2, 'is_required' => false],
                    ['section_type' => 'couple', 'default_title' => 'वधू आणि वर', 'default_subtitle' => 'Two lives united in sacred vows', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'विवाह सोहळा कार्यक्रम', 'default_subtitle' => 'हळदी, संगीत, साखरपुडा व सप्तपदी विवाह विधी', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'लग्नघडीची प्रतीक्षा', 'default_subtitle' => 'Counting down to the auspicious Muhurtham', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'मंगल कार्यालय व स्थळ', 'default_subtitle' => 'Grand Heritage Lawns, Pune', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Google Map लोकेशन', 'default_subtitle' => 'Click to navigate to the venue', 'sort_order' => 7, 'is_required' => true],
                    ['section_type' => 'rsvp', 'default_title' => 'उपस्थितीची नोंद (RSVP)', 'default_subtitle' => 'आपल्या उपस्थितीची आगाऊ नोंद करावी ही नम्र विनंती', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'आशीर्वाद व शुभेच्छा', 'default_subtitle' => 'वधू-वरांना आपल्या शुभाशीर्वाद संदेश द्या', 'sort_order' => 9, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => 'निमंत्रक: समस्त परिवार', 'default_subtitle' => 'आपल्या आगमनाची वाट पाहत आहोत', 'sort_order' => 10, 'is_required' => true],
                ]
            ],
            [
                'category_id' => $weddingCat?->id,
                'subcategory_id' => $createdSubcategories['weddings/royal-heritage']?->id ?? null,
                'name' => 'Nikaah Mubarak — Emerald & Ivory Crescent',
                'slug' => 'nikaah-mubarak-crescent',
                'description' => 'Exquisite Islamic wedding invitation with Mughal arch patterns, Bismillah calligraphy, soft Sufi instrumental audio, and multi-function Walima schedule.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/nikaah-mubarak-crescent',
                'theme_config' => [
                    'primary_color' => '#D4AF37',
                    'secondary_color' => '#022C22',
                    'accent_color' => '#34D399',
                    'bg_gradient' => 'linear-gradient(180deg, #022018 0%, #064E3B 100%)',
                    'font_family_heading' => 'Playfair Display',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'sparkles_float',
                    'envelope_style' => 'wax_seal_royal',
                    'ornament' => 'islamic_arch',
                ],
                'is_premium' => true,
                'base_price_inr' => 1399.00,
                'base_price_usd' => 17.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['muslim', 'nikah', 'walima', 'islamic', 'emerald', 'gold', 'mughal'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => 'Nikaah Mubarak', 'default_subtitle' => 'In the name of Allah, the Most Gracious, the Most Merciful', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| Bismillah-ir-Rahman-ir-Rahim ||', 'default_subtitle' => 'And We created you in pairs (Surah An-Naba 78:8)', 'sort_order' => 2, 'is_required' => false],
                    ['section_type' => 'couple', 'default_title' => 'The Bride & Groom', 'default_subtitle' => 'Two hearts united in faith, love, and prayer', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Wedding Itinerary', 'default_subtitle' => 'Mehndi, Nikaah Ceremony & Grand Walima Dawat', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Countdown to the Sacred Vows', 'default_subtitle' => 'Counting down every moment of blessings', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'Banquet & Venue', 'default_subtitle' => 'The Royal Palm Manor, Hyderabad', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Venue Directions', 'default_subtitle' => 'Google Map Navigation link', 'sort_order' => 7, 'is_required' => true],
                    ['section_type' => 'rsvp', 'default_title' => 'Kindly RSVP', 'default_subtitle' => 'Please confirm your gracious presence for the Walima Feast', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Duas & Warm Wishes', 'default_subtitle' => 'Share your heartfelt prayers for the couple', 'sort_order' => 9, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => 'With Best Compliments from Family', 'default_subtitle' => 'JazakAllah Khair for being with us', 'sort_order' => 10, 'is_required' => true],
                ]
            ],
            [
                'category_id' => $weddingCat?->id,
                'subcategory_id' => $createdSubcategories['weddings/royal-heritage']?->id ?? null,
                'name' => 'Temple Kalyanam — Kanjeevaram Gold & Jasmine',
                'slug' => 'temple-kalyanam-silk',
                'description' => 'Authentic South Indian wedding invitation inspired by Dravidian temple architecture, golden Kanjeevaram silks, traditional Nadaswaram tunes, and banana leaf feast itinerary.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/temple-kalyanam-silk',
                'theme_config' => [
                    'primary_color' => '#EAB308',
                    'secondary_color' => '#7C2D12',
                    'accent_color' => '#F97316',
                    'bg_gradient' => 'linear-gradient(180deg, #1C0F08 0%, #451A03 100%)',
                    'font_family_heading' => 'Cinzel Decorative',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'sparkles_float',
                    'envelope_style' => 'wax_seal_royal',
                    'ornament' => 'temple_gopuram',
                ],
                'is_premium' => true,
                'base_price_inr' => 1299.00,
                'base_price_usd' => 16.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['south-indian', 'tamil', 'telugu', 'kalyanam', 'temple', 'gold', 'traditional'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => 'Subha Muhurtham', 'default_subtitle' => 'With the blessings of our elders and the divine grace of the Almighty', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'couple', 'default_title' => 'The Bride & Groom', 'default_subtitle' => 'United in holy matrimony and eternal companionship', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Wedding Festivities', 'default_subtitle' => 'Vratham, Janavasam, Muhurtham & Grand Kalyana Virundhu', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Muhurtham Countdown', 'default_subtitle' => 'Auspicious hours approaching', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'Kalyana Mandapam', 'default_subtitle' => 'Mayor Ramanathan Chettiar Hall, Chennai', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Location & Navigation', 'default_subtitle' => 'Direct Google Maps directions', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'rsvp', 'default_title' => 'RSVP & Guest Count', 'default_subtitle' => 'Please let us know your attendance for the traditional feast', 'sort_order' => 7, 'is_required' => true],
                    ['section_type' => 'footer', 'default_title' => 'In Divine Celebration', 'default_subtitle' => 'With warm regards from both families', 'sort_order' => 8, 'is_required' => true],
                ]
            ],
            [
                'category_id' => $weddingCat?->id,
                'subcategory_id' => $createdSubcategories['weddings/modern-minimalist']?->id ?? null,
                'name' => 'The Minimalist — Champagne Silk & Editorial Chic',
                'slug' => 'modern-minimalist-vows',
                'description' => 'Ultra-chic contemporary editorial invitation with clean Swiss typography, subtle silk reveal animations, and interactive RSVP.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=800&q=80',
                'preview_url' => '/invitations/preview/modern-minimalist-vows',
                'theme_config' => [
                    'primary_color' => '#E2E8F0',
                    'secondary_color' => '#0F172A',
                    'accent_color' => '#94A3B8',
                    'bg_gradient' => 'linear-gradient(180deg, #090D16 0%, #1E293B 100%)',
                    'font_family_heading' => 'Outfit',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'luxury_fade',
                    'envelope_style' => 'silk_ribbon',
                    'ornament' => 'geometric_lines',
                ],
                'is_premium' => false,
                'base_price_inr' => 499.00,
                'base_price_usd' => 6.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['minimalist', 'modern', 'editorial', 'chic', 'clean', 'destination'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => 'Together Forever', 'default_subtitle' => 'Request the pleasure of your company at our celebration', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'couple', 'default_title' => 'Our Journey', 'default_subtitle' => 'Two paths merging into one horizon', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Schedule', 'default_subtitle' => 'Ceremony, Cocktails & Dinner Party', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'The Glasshouse', 'default_subtitle' => 'Goa Beachfront Resort, India', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'rsvp', 'default_title' => 'RSVP', 'default_subtitle' => 'Kindly respond before November 20', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'footer', 'default_title' => '#LoveInMinimal', 'default_subtitle' => 'See you there', 'sort_order' => 6, 'is_required' => true],
                ]
            ]
        ];


        foreach ($templates as $tData) {
            $sections = $tData['sections'] ?? [];
            unset($tData['sections']);

            $template = InvitationTemplate::updateOrCreate(['slug' => $tData['slug']], $tData);

            foreach ($sections as $sIdx => $sData) {
                InvitationTemplateSection::updateOrCreate([
                    'template_id' => $template->id,
                    'section_type' => $sData['section_type']
                ], [
                    'default_title' => $sData['default_title'],
                    'default_subtitle' => $sData['default_subtitle'],
                    'sort_order' => $sData['sort_order'],
                    'is_required' => $sData['is_required']
                ]);
            }
        }

        // 5. Seed a Sample Live Demo Invitation with Events, Sections, Form, and Guests
        $adminUser = User::where('role', 'admin')->first() ?? User::first();
        if ($adminUser) {
            $rajwadaTemplate = InvitationTemplate::where('slug', 'royal-rajwada-palace')->first();
            
            $demoInvite = Invitation::updateOrCreate([
                'slug' => 'priya-and-rahul-wedding'
            ], [
                'uuid' => (string) Str::uuid(),
                'user_id' => $adminUser->id,
                'template_id' => $rajwadaTemplate?->id,
                'title' => 'Priya & Rahul Royal Palace Wedding',
                'cover_image' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=1200&q=80',
                'event_date' => now()->addMonths(2)->setTime(18, 30),
                'status' => 'published',
                'primary_color' => '#D4AF37',
                'secondary_color' => '#064E3B',
                'accent_color' => '#F59E0B',
                'font_family_heading' => 'Cinzel Decorative',
                'font_family_body' => 'Outfit',
                'animation_style' => 'sparkles_float',
                'music_url' => 'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',
                'music_autoplay' => false,
                'seo_title' => 'Priya & Rahul Wedding Celebration — Grand Udaipur Palace',
                'seo_description' => 'You are cordially invited to celebrate the grand wedding ceremonies of Priya & Rahul at Taj Lake Palace, Udaipur.',
                'selected_features' => ['rsvp_custom_form', 'guest_qr_checkin', 'background_music', 'photo_gallery_unlimited', 'multi_event_timeline', 'ai_copywriter'],
                'expires_at' => now()->addMonths(6),
            ]);

            // Seed Invitation Events
            $events = [
                [
                    'invitation_id' => $demoInvite->id,
                    'title' => 'Mehendi & Sangeet Soirée',
                    'event_date' => now()->addMonths(2)->subDays(1)->toDateString(),
                    'start_time' => '16:00:00',
                    'end_time' => '22:00:00',
                    'venue_name' => 'The Royal Courtyard, Taj Lake Palace',
                    'venue_address' => 'Pichola, Udaipur, Rajasthan 313001',
                    'dress_code' => 'Bright & Festive Pastel Lehengas & Kurtas',
                    'icon' => '🪕',
                    'sort_order' => 1
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'title' => 'Haldi & Phoolon Ki Holi',
                    'event_date' => now()->addMonths(2)->toDateString(),
                    'start_time' => '10:00:00',
                    'end_time' => '13:00:00',
                    'venue_name' => 'Garden Lawns & Poolside',
                    'venue_address' => 'Taj Lake Palace, Udaipur, Rajasthan',
                    'dress_code' => 'Shades of Sunshine Yellow & Ochre',
                    'icon' => '🌼',
                    'sort_order' => 2
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'title' => 'Varmala, Pheras & Royal Reception',
                    'event_date' => now()->addMonths(2)->toDateString(),
                    'start_time' => '18:30:00',
                    'end_time' => '23:30:00',
                    'venue_name' => 'The Grand Durbar Banquet',
                    'venue_address' => 'Taj Lake Palace, Pichola, Udaipur',
                    'dress_code' => 'Traditional Royal Heritage & Evening Formals',
                    'icon' => '👑',
                    'sort_order' => 3
                ],
            ];

            foreach ($events as $eData) {
                InvitationEvent::updateOrCreate([
                    'invitation_id' => $demoInvite->id,
                    'title' => $eData['title']
                ], $eData);
            }

            // Seed Invitation Sections
            $sections = [
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'hero',
                    'title' => 'Shubh Vivah',
                    'subtitle' => 'Together with their families, Priya Sharma & Rahul Verma invite you to share in the joy of their wedding celebration',
                    'content' => [
                        'groom_name' => 'Rahul Verma',
                        'bride_name' => 'Priya Sharma',
                        'parents_bride' => 'Mr. Suresh & Mrs. Sunita Sharma',
                        'parents_groom' => 'Mr. Ramesh & Mrs. Kavita Verma',
                        'date_display' => now()->addMonths(2)->format('F d, Y'),
                        'city_display' => 'Udaipur, Rajasthan, India'
                    ],
                    'sort_order' => 1,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'couple',
                    'title' => 'The Bride & Groom',
                    'subtitle' => 'Two hearts, one lifelong promise under the Udaipur starlight',
                    'content' => [
                        'bride_bio' => 'An architect of spaces and dreamer of adventures, who found her home in his warm laughter.',
                        'groom_bio' => 'A tech entrepreneur and classical music lover, who found his melody in her radiant smile.',
                        'story' => 'From our first meeting over rainy evening chai in Bangalore to watching sunset over Lake Pichola, our journey has been an extraordinary tapestry of laughter, quiet understanding, and boundless love.'
                    ],
                    'sort_order' => 2,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'events',
                    'title' => 'Three Days of Royal Celebrations',
                    'subtitle' => 'Immerse in the traditions, music, and flavors of Rajasthan',
                    'content' => [],
                    'sort_order' => 3,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'countdown',
                    'title' => 'The Royal Countdown',
                    'subtitle' => 'Counting down every magical moment until we say "I Do"',
                    'content' => ['target_date' => now()->addMonths(2)->toIso8601String()],
                    'sort_order' => 4,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'gallery',
                    'title' => 'Glimpses of Our Journey',
                    'subtitle' => 'Moments etched in time before the sacred pheras',
                    'content' => [
                        'images' => [
                            ['url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80', 'caption' => 'The Proposal at Udaipur'],
                            ['url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80', 'caption' => 'Traditional Pre-Wedding Shoot'],
                            ['url' => 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80', 'caption' => 'Golden Hour by the Lake'],
                            ['url' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=800&q=80', 'caption' => 'Ring Exchange Moments'],
                        ]
                    ],
                    'sort_order' => 5,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'venue',
                    'title' => 'The Royal Palace Venue',
                    'subtitle' => 'Taj Lake Palace, Pichola, Udaipur',
                    'content' => [
                        'description' => 'Built between 1743 and 1746 on the island of Jag Niwas in Lake Pichola, the marble palace provides an idyllic fairytale backdrop for our sacred union.',
                        'airport_distance' => '25 km from Maharana Pratap Airport (UDR)',
                        'train_distance' => '4 km from Udaipur City Railway Station'
                    ],
                    'sort_order' => 6,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'dress_code',
                    'title' => 'Royal Attire & Color Palette',
                    'subtitle' => 'Dress inspiration for the celebrations',
                    'content' => [
                        'mehendi' => 'Peacock Blue, Mint Green, Parrot Green & Floral Pastels',
                        'haldi' => 'Marigold Yellow, Mustard, Amber & Ivory',
                        'wedding' => 'Regal Emerald, Gold, Ruby Red, Bandhani & Royal Sherwanis'
                    ],
                    'sort_order' => 7,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'rsvp',
                    'title' => 'Kindly Confirm Your Presence',
                    'subtitle' => 'Your gracious presence is the greatest gift. Please RSVP by November 15',
                    'content' => [],
                    'sort_order' => 8,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'guestbook',
                    'title' => 'Blessings & Warm Wishes',
                    'subtitle' => 'Share your heartfelt wishes for the couple',
                    'content' => [],
                    'sort_order' => 9,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'contact',
                    'title' => 'Hospitality & Travel Desk',
                    'subtitle' => 'For airport pick-up, room allocation & inquiries',
                    'content' => [
                        'contacts' => [
                            ['name' => 'Vikram Sharma (Bride’s Brother)', 'phone' => '+91 98765 43210', 'role' => 'Guest Hospitality'],
                            ['name' => 'Aakash Verma (Groom’s Brother)', 'phone' => '+91 98765 12345', 'role' => 'Logistics & Transport'],
                        ]
                    ],
                    'sort_order' => 10,
                    'is_enabled' => true
                ],
                [
                    'invitation_id' => $demoInvite->id,
                    'section_type' => 'footer',
                    'title' => '#PriyaRahulKiShadi2026',
                    'subtitle' => 'With the warmest regards from Sharma & Verma families',
                    'content' => [],
                    'sort_order' => 11,
                    'is_enabled' => true
                ],
            ];

            foreach ($sections as $sec) {
                InvitationSection::updateOrCreate([
                    'invitation_id' => $demoInvite->id,
                    'section_type' => $sec['section_type']
                ], $sec);
            }

            // Seed RSVP Form & Fields
            $form = InvitationForm::updateOrCreate([
                'invitation_id' => $demoInvite->id
            ], [
                'title' => 'Wedding RSVP & Accommodation Form',
                'description' => 'Please let us know your travel schedule and food preferences to help us prepare the best royal hospitality.',
                'deadline' => now()->addMonths(1)->addDays(15),
                'max_party_size' => 6,
                'allow_guest_plus_one' => true,
                'is_active' => true
            ]);

            $fields = [
                ['label' => 'Will you be attending?', 'field_type' => 'radio', 'options' => ['Joyfully Attending', 'Regretfully Declining', 'Tentative / Confirm Later'], 'is_required' => true, 'sort_order' => 1],
                ['label' => 'Total number of guests in your party', 'field_type' => 'number', 'placeholder' => '1', 'is_required' => true, 'sort_order' => 2],
                ['label' => 'Which events will you attend?', 'field_type' => 'checkbox', 'options' => ['Mehendi & Sangeet (Day 1)', 'Haldi Celebration (Day 2 Morning)', 'Wedding & Grand Reception (Day 2 Evening)'], 'is_required' => true, 'sort_order' => 3],
                ['label' => 'Dietary Preferences', 'field_type' => 'dropdown', 'options' => ['Pure Vegetarian', 'Jain Vegetarian (No Onion/Garlic)', 'Non-Vegetarian', 'Vegan / Gluten-Free'], 'is_required' => false, 'sort_order' => 4],
                ['label' => 'Do you require airport/station pickup in Udaipur?', 'field_type' => 'yes_no', 'options' => ['Yes', 'No'], 'is_required' => false, 'sort_order' => 5],
                ['label' => 'Song Request for the Sangeet DJ Night 🎵', 'field_type' => 'text', 'placeholder' => 'Your favorite Bollywood / Punjabi dance track...', 'is_required' => false, 'sort_order' => 6],
                ['label' => 'Special notes or room requirements for the family', 'field_type' => 'textarea', 'placeholder' => 'Any special assistance or elders accommodation...', 'is_required' => false, 'sort_order' => 7],
            ];

            foreach ($fields as $fIdx => $fData) {
                InvitationFormField::updateOrCreate([
                    'form_id' => $form->id,
                    'label' => $fData['label']
                ], array_merge($fData, ['sort_order' => $fIdx + 1]));
            }

            // Seed Sample Guests
            $guests = [
                ['name' => 'Dr. Arvind Mehra & Family', 'email' => 'arvind.mehra@example.com', 'phone' => '+91 98200 11223', 'group_name' => 'VIP Guests', 'allocated_seats' => 4, 'is_vip' => true, 'attending_status' => 'attending', 'guest_code' => 'GST-MEHRA99'],
                ['name' => 'Mrs. Sunita Kapoor', 'email' => 'sunita.kapoor@example.com', 'phone' => '+91 98111 22334', 'group_name' => 'Bride Family', 'allocated_seats' => 2, 'is_vip' => false, 'attending_status' => 'attending', 'guest_code' => 'GST-KAPOOR21'],
                ['name' => 'Vikram Singhania', 'email' => 'vikram.s@example.com', 'phone' => '+91 99000 88776', 'group_name' => 'Groom Friends', 'allocated_seats' => 1, 'is_vip' => false, 'attending_status' => 'pending', 'guest_code' => 'GST-SINGH44'],
            ];

            foreach ($guests as $gData) {
                InvitationGuest::updateOrCreate([
                    'invitation_id' => $demoInvite->id,
                    'guest_code' => $gData['guest_code']
                ], $gData);
            }

            // Seed QR Code for Invitation
            InvitationQrCode::updateOrCreate([
                'invitation_id' => $demoInvite->id,
                'qr_type' => 'invitation_link'
            ], [
                'target_url' => url('/i/' . $demoInvite->slug),
                'code_string' => 'INV-' . strtoupper(substr(md5($demoInvite->slug), 0, 8)),
                'foreground_color' => '#064E3B',
                'background_color' => '#FFFFFF',
                'download_count' => 12,
                'scan_count' => 48
            ]);
        }
    }
}
