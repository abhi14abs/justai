<?php

namespace Database\Seeders;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationEvent;
use App\Models\Invitations\InvitationForm;
use App\Models\Invitations\InvitationFormField;
use App\Models\Invitations\InvitationQrCode;
use App\Models\Invitations\InvitationSection;
use App\Models\Invitations\InvitationSubcategory;
use App\Models\Invitations\InvitationTemplate;
use App\Models\Invitations\InvitationTemplateSection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GaneshChaturthiTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds for Ganesh Chaturthi templates.
     */
    public function run(): void
    {
        // 1. Create or Update Festival Category
        $festivalCategory = InvitationCategory::updateOrCreate(['slug' => 'festivals-puja'], [
            'name' => 'Festivals, Puja & Ganesh Chaturthi',
            'description' => 'Auspicious Ganeshotsav, Diwali Pooja, Navratri and Satyanarayan spiritual invitations with aarti schedules, prasad RSVP, and live darshan.',
            'icon' => '🕉️',
            'banner_url' => '/images/invitations/ganesh/saffron_lalbaug.jpg',
            'sort_order' => 1,
            'meta_title' => 'Ganesh Chaturthi Digital Invitations & Puja E-Cards',
            'meta_description' => 'Create vibrant Ganesh Chaturthi invitations with aarti timings, prasad RSVP, bhajan music, and Google Maps.',
        ]);

        $subGanesh = InvitationSubcategory::updateOrCreate([
            'category_id' => $festivalCategory->id,
            'slug' => 'ganesh-chaturthi'
        ], [
            'name' => 'Ganesh Chaturthi & Ganeshotsav',
            'description' => 'Grand Sarvajanik and Home Ganeshotsav invitations with aagman to visarjan schedule',
            'sort_order' => 1
        ]);

        $subDiwali = InvitationSubcategory::updateOrCreate([
            'category_id' => $festivalCategory->id,
            'slug' => 'diwali-puja'
        ], [
            'name' => 'Diwali & Lakshmi Pooja',
            'description' => 'Auspicious Deepawali and Chopda Pujan invitations',
            'sort_order' => 2
        ]);

        $subSatya = InvitationSubcategory::updateOrCreate([
            'category_id' => $festivalCategory->id,
            'slug' => 'satyanarayan'
        ], [
            'name' => 'Satyanarayan & Griha Pravesh',
            'description' => 'Housewarming and spiritual blessings invitations',
            'sort_order' => 3
        ]);

        // 2. Define 5 Distinct, Authentic, Vibrant Non-Dark Ganesh Chaturthi Templates
        $templates = [
            // TEMPLATE 1: Saffron Aura & Lalbaugcha Raja
            [
                'category_id' => $festivalCategory->id,
                'subcategory_id' => $subGanesh->id,
                'name' => 'Saffron Aura & Lalbaugcha Raja — Divine Kesariya Ganeshotsav',
                'slug' => 'saffron-aura-lalbaug-ganesha',
                'description' => 'Radiant festive saffron kesariya silk backdrop, glowing golden aura, marigold shower particle physics, aagman to visarjan schedule, and prasad count RSVP.',
                'thumbnail_url' => '/images/invitations/ganesh/saffron_lalbaug.jpg',
                'preview_url' => '/invitations/preview/saffron-aura-lalbaug-ganesha',
                'theme_config' => [
                    'primary_color' => '#EA580C', // Saffron / Sindoor
                    'secondary_color' => '#FFF7ED', // Warm Sunlit Cream
                    'accent_color' => '#D97706', // Temple Gold
                    'bg_gradient' => 'linear-gradient(180deg, #FFF7ED 0%, #FFEDD5 100%)',
                    'font_family_heading' => 'Cinzel Decorative',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'marigold_shower',
                    'envelope_style' => 'wax_seal_royal',
                    'ornament' => 'gold_om',
                ],
                'is_premium' => true,
                'base_price_inr' => 899.00,
                'base_price_usd' => 11.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['ganesh-chaturthi', 'saffron', 'lalbaug', 'marigold', 'aarti', 'puja', 'traditional', 'kesariya'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => '|| श्री गणेशाय नमः ||', 'default_subtitle' => 'You and your family are cordially invited to celebrate the auspicious 10-day Ganeshotsav with us and seek the divine blessings of Lord Ganesha.', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||', 'default_subtitle' => 'निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha bestow immense joy, good health, peace and prosperity upon you and your family.', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Bappa Aagman Countdown', 'default_subtitle' => 'Counting down the auspicious hours to Ganesh Chaturthi Sthapana', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Ganeshotsav Itinerary & Aarti Schedule', 'default_subtitle' => 'Join us for the auspicious rituals, daily aartis and mahaprasad', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'Ganeshotsav Mandap & Pandal', 'default_subtitle' => 'Shree Ganesh Krupa Niwas, Lalbaug, Mumbai', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Mandap Location & Navigation', 'default_subtitle' => 'Get Google Maps directions to the Mandap', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'dress_code', 'default_title' => 'Festive Attire Guidelines', 'default_subtitle' => 'Festive Traditional Indian Wear (Kurta Pyjama / Silk Saree)', 'sort_order' => 7, 'is_required' => false],
                    ['section_type' => 'rsvp', 'default_title' => 'Darshan & Mahaprasad RSVP', 'default_subtitle' => 'Kindly let us know your visiting day and family count for Prasad arrangements', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Bappa Blessings & Prayer Wall', 'default_subtitle' => 'Leave your prayers and Ganesh Chaturthi greetings for all devotees', 'sort_order' => 9, 'is_required' => false],
                    ['section_type' => 'music', 'default_title' => 'Aarti & Devotional Stotram', 'default_subtitle' => 'Sukhkarta Dukhharta & Shendur Lal Chadhayo', 'sort_order' => 10, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => '|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||', 'default_subtitle' => 'Warm festive regards from our family to yours', 'sort_order' => 11, 'is_required' => true],
                ]
            ],

            // TEMPLATE 2: Peshwai Dhol-Tasha & Kasba Ganpati
            [
                'category_id' => $festivalCategory->id,
                'subcategory_id' => $subGanesh->id,
                'name' => 'Peshwai Dhol-Tasha & Kasba Ganpati — Royal Puneri Ganeshotsav',
                'slug' => 'peshwai-dhol-tasha-ganpati',
                'description' => 'Royal Maharashtrian Paithani magenta & warm mango gold, peacock feather accents, dhol-tasha pathak energy, floating brass diyas, and authentic Puneri traditions.',
                'thumbnail_url' => '/images/invitations/ganesh/peshwai_paithani.jpg',
                'preview_url' => '/invitations/preview/peshwai-dhol-tasha-ganpati',
                'theme_config' => [
                    'primary_color' => '#C026D3', // Paithani Magenta
                    'secondary_color' => '#FEF3C7', // Warm Mango Chiffon
                    'accent_color' => '#059669', // Peacock Emerald
                    'bg_gradient' => 'linear-gradient(180deg, #FEF3C7 0%, #FDE68A 100%)',
                    'font_family_heading' => 'Cinzel Decorative',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'diya_sparkle',
                    'envelope_style' => 'wax_seal_royal',
                    'ornament' => 'paithani_peacock',
                ],
                'is_premium' => true,
                'base_price_inr' => 999.00,
                'base_price_usd' => 13.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['peshwai', 'pune', 'maharashtrian', 'paithani', 'dhol-tasha', 'kasba-ganpati', 'marathi'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => '|| गणपती बाप्पा मोरया ||', 'default_subtitle' => 'आपणास व आपल्या परिवारास गणेशोत्सवाचे सस्नेह निमंत्रण! Join our grand Peshwai Ganeshotsav celebration.', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| सुखकर्ता दुखहर्ता वार्ता विघ्नाची ||', 'default_subtitle' => 'नुरवी पुरवी प्रेम कृपा जयाची ॥ सर्व विघ्नहर्ता गणरायाच्या आगमनानिमित्त आपले व आपल्या परिवाराचे सहर्ष स्वागत.', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'आगमन सोहळा Countdown', 'default_subtitle' => 'ढोल-ताशांच्या गजरात बाप्पाच्या आगमनाची घटिका समीप', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'कार्यक्रम पत्रिका (Schedule)', 'default_subtitle' => 'आगमन मिरवणूक, महाआरती, हळदी-कुंकू व मोदक महाप्रसाद', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'पेशवाई राजवाडा मंडप', 'default_subtitle' => 'Sadashiv Peth, Pune, Maharashtra', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'मंडप मार्गदर्शक (Google Map)', 'default_subtitle' => 'Click to open Google Maps navigation', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'dress_code', 'default_title' => 'पारंपरिक पोशाख', 'default_subtitle' => 'Traditional Nauvari / Paithani Saree & Dhoti Kurta with Puneri Feta', 'sort_order' => 7, 'is_required' => false],
                    ['section_type' => 'rsvp', 'default_title' => 'उपस्थिती नोंदणी (RSVP)', 'default_subtitle' => 'महाप्रसाद व दर्शनासाठी आपल्या परिवाराची उपस्थिती नोंदवा', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'बाप्पासाठी शुभेच्छा व संदेश', 'default_subtitle' => 'आपल्या शुभेच्छा डिजिटल भित्तीवर लिहा', 'sort_order' => 9, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => '|| मंगलमूर्ती मोरया ||', 'default_subtitle' => 'निमंत्रक: सकल देशपांडे व जोशी परिवार, पुणे', 'sort_order' => 10, 'is_required' => true],
                ]
            ],

            // TEMPLATE 3: Eco-Friendly Green & Clay Bappa
            [
                'category_id' => $festivalCategory->id,
                'subcategory_id' => $subGanesh->id,
                'name' => 'Eco-Friendly Green & Clay Bappa — Sustainable Nature Ganeshotsav',
                'slug' => 'eco-friendly-clay-ganesha',
                'description' => '100% natural Shadu Mati clay idol, fresh banana leaves, blooming marigolds, durva grass animations, terracotta deepaks, and home plant visarjan concept.',
                'thumbnail_url' => '/images/invitations/ganesh/eco_terracotta.jpg',
                'preview_url' => '/invitations/preview/eco-friendly-clay-ganesha',
                'theme_config' => [
                    'primary_color' => '#15803D', // Banana Leaf Emerald
                    'secondary_color' => '#F0FDF4', // Mint Cream
                    'accent_color' => '#D97706', // Terracotta Clay
                    'bg_gradient' => 'linear-gradient(180deg, #F0FDF4 0%, #DCFCE7 100%)',
                    'font_family_heading' => 'Playfair Display',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'durva_jasmine',
                    'envelope_style' => 'leaf_ribbon',
                    'ornament' => 'leaf_durva',
                ],
                'is_premium' => false,
                'base_price_inr' => 699.00,
                'base_price_usd' => 8.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['eco-friendly', 'green', 'shadu-mati', 'clay-ganesha', 'sustainable', 'nature', 'organic'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => '🌱 Green Ganeshotsav 🌱', 'default_subtitle' => 'Welcoming 100% natural clay Bappa into our home with organic flowers, durva grass, and love for Mother Earth.', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| ॐ गं गणपतये नमः ||', 'default_subtitle' => 'Celebrating in harmony with nature. Our clay idol contains indigenous flowering seeds that will blossom into plants after symbolic home immersion.', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Eco-Bappa Sthapana Countdown', 'default_subtitle' => 'Counting down to auspicious Ganesh Chaturthi Sthapana', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Eco-Celebration Schedule', 'default_subtitle' => 'Clay Welcome, 21 Durva Arpan, Organic Modak Feast, & Home Garden Visarjan', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'Eco Sanctuary & Garden Courtyard', 'default_subtitle' => 'Palm Grove Residency, Bengaluru', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Location & Navigation', 'default_subtitle' => 'Get directions via Google Maps', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'dress_code', 'default_title' => 'Eco-Chic Handloom Attire', 'default_subtitle' => 'Natural Handloom Cotton, Linen, and Khadi in Earthy Tones', 'sort_order' => 7, 'is_required' => false],
                    ['section_type' => 'rsvp', 'default_title' => 'Eco-Darshan RSVP', 'default_subtitle' => 'Confirm your attendance for the organic satvik Prasad and seed-pot distribution', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Green Pledges & Wishes', 'default_subtitle' => 'Plant an auspicious thought and share your eco-Ganesh wishes', 'sort_order' => 9, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => 'Nurture Nature • Seek Bappa Blessings', 'default_subtitle' => 'Warm wishes from our eco-conscious family', 'sort_order' => 10, 'is_required' => true],
                ]
            ],

            // TEMPLATE 4: Temple Sanctum & Golden Modak
            [
                'category_id' => $festivalCategory->id,
                'subcategory_id' => $subGanesh->id,
                'name' => 'Temple Sanctum & Golden Modak — Sacred Marble & Gilded Gold',
                'slug' => 'temple-sanctum-marble-ganesha',
                'description' => 'Opulent Makrana white marble temple architecture, hanging brass bells, glowing karpoor aarti, 21 modaks, Atharvashirsha chants, and divine halo animations.',
                'thumbnail_url' => '/images/invitations/ganesh/marble_temple.jpg',
                'preview_url' => '/invitations/preview/temple-sanctum-marble-ganesha',
                'theme_config' => [
                    'primary_color' => '#B45309', // Sanctum Gold / Brass
                    'secondary_color' => '#FAF8F5', // Pure Marble White
                    'accent_color' => '#DC2626', // Kumkum Red
                    'bg_gradient' => 'linear-gradient(180deg, #FAF8F5 0%, #F5EFEB 100%)',
                    'font_family_heading' => 'Cinzel Decorative',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'temple_bells_aura',
                    'envelope_style' => 'wax_seal_royal',
                    'ornament' => 'temple_bell',
                ],
                'is_premium' => true,
                'base_price_inr' => 1199.00,
                'base_price_usd' => 15.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['temple', 'marble', 'gold', 'siddhivinayak', 'modak', 'atharvashirsha', 'puja', 'sacred'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => '|| श्री सिद्धि विनायक नमः ||', 'default_subtitle' => 'You are cordially invited to the sacred 108 Times Atharvashirsha Avartan, Havan, and 21 Modak Mahanaivedya.', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| ॐ श्रीम गम सौभाग्य गणपतये वरवरद सर्वजनं मे वशमानय स्वाहा ||', 'default_subtitle' => 'May the divine lord Siddhivinayak eradicate all hurdles from your life and bless you with wisdom, prosperity, and spiritual fulfillment.', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Mahapooja Muhurtham Countdown', 'default_subtitle' => 'Counting down to the sacred Mahaganapati Homam & Havan', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Temple Rituals & Havan Schedule', 'default_subtitle' => 'Mahasankalpam, Atharvashirsha Pathan, 21 Modak Naivedya & Karpoor Aarti', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'Shri Siddhivinayak Temple Sanctum', 'default_subtitle' => 'Prabhadevi Temple Complex, Mumbai', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Sanctum Route Map', 'default_subtitle' => 'Access Google Maps directions and parking info', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'dress_code', 'default_title' => 'Temple Pavitra Dress Code', 'default_subtitle' => 'Traditional Silk Dhoti / Angavastram / Kanjeevaram Silk Saree', 'sort_order' => 7, 'is_required' => false],
                    ['section_type' => 'rsvp', 'default_title' => 'Havan Seva & Darshan Booking', 'default_subtitle' => 'Reserve your family slot for the sacred Havan Ahuti and Chhappan Bhog Prasad', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Offer Prayers & Sankalp', 'default_subtitle' => 'Submit your digital flower offering and prayers at Bappa feet', 'sort_order' => 9, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => '|| ॐ शांति शांति शांतिः ||', 'default_subtitle' => 'With the blessings of Almighty Lord Ganesha', 'sort_order' => 10, 'is_required' => true],
                ]
            ],

            // TEMPLATE 5: Celestial Bal Ganesha & Pastel Joy
            [
                'category_id' => $festivalCategory->id,
                'subcategory_id' => $subGanesh->id,
                'name' => 'Celestial Bal Ganesha & Pastel Joy — Whimsical Family Ganeshotsav',
                'slug' => 'celestial-bal-ganesha-joy',
                'description' => 'Cute Bal Ganesha eating laddoos with Mooshak, vibrant fairy lights, colorful torans, lively kids bhajan, festive modak shower, and sweet celebrations.',
                'thumbnail_url' => '/images/invitations/ganesh/bal_celebration.jpg',
                'preview_url' => '/invitations/preview/celestial-bal-ganesha-joy',
                'theme_config' => [
                    'primary_color' => '#EA580C', // Warm Tangerine
                    'secondary_color' => '#FFFBEB', // Warm Pastel Cream
                    'accent_color' => '#38BDF8', // Peacock Sky Blue
                    'bg_gradient' => 'linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%)',
                    'font_family_heading' => 'Playfair Display',
                    'font_family_body' => 'Outfit',
                    'animation_style' => 'marigold_shower',
                    'envelope_style' => 'silk_ribbon',
                    'ornament' => 'modak_star',
                ],
                'is_premium' => false,
                'base_price_inr' => 799.00,
                'base_price_usd' => 9.99,
                'is_active' => true,
                'is_featured' => true,
                'tags' => ['bal-ganesha', 'kids', 'family', 'pastel', 'modak', 'laddoo', 'joyful', 'festive'],
                'sections' => [
                    ['section_type' => 'hero', 'default_title' => '✨ Bal Ganesha Aagman ✨', 'default_subtitle' => 'Celebrate the sweetest and most joyful festival of the year with our family and adorable Little Bappa!', 'sort_order' => 1, 'is_required' => true],
                    ['section_type' => 'introduction', 'default_title' => '|| एकदन्ताय विद्महे वक्रतुण्डाय धीमहि तन्नो दन्तिः प्रचोदयात् ||', 'default_subtitle' => 'Sweet as Modak, bright as Diya, joyful as Bal Ganesha! Come sing, pray, eat modaks and celebrate with us.', 'sort_order' => 2, 'is_required' => true],
                    ['section_type' => 'countdown', 'default_title' => 'Modak Party & Aagman Countdown', 'default_subtitle' => 'Getting ready for laddoos, modaks and celebrations', 'sort_order' => 3, 'is_required' => true],
                    ['section_type' => 'events', 'default_title' => 'Celebration & Fun Itinerary', 'default_subtitle' => 'Bappa Welcoming Parade, Kids Bhajan, Modak Making Workshop & Evening Aarti', 'sort_order' => 4, 'is_required' => true],
                    ['section_type' => 'venue', 'default_title' => 'Anand Villa Courtyard & Lawn', 'default_subtitle' => 'Jubilee Hills, Hyderabad', 'sort_order' => 5, 'is_required' => true],
                    ['section_type' => 'map', 'default_title' => 'Directions & Venue Location', 'default_subtitle' => 'Click to open Google Maps navigation', 'sort_order' => 6, 'is_required' => true],
                    ['section_type' => 'dress_code', 'default_title' => 'Bright & Colorful Festive Wear', 'default_subtitle' => 'Sunny Yellows, Vibrant Oranges, Pinks & Festive Kurtas', 'sort_order' => 7, 'is_required' => false],
                    ['section_type' => 'rsvp', 'default_title' => 'Family & Modak RSVP', 'default_subtitle' => 'Let us know how many adults and kids are joining the fun!', 'sort_order' => 8, 'is_required' => true],
                    ['section_type' => 'guestbook', 'default_title' => 'Sweet Wishes for Bappa', 'default_subtitle' => 'Write your cheerful festive wishes and favorite modak memories', 'sort_order' => 9, 'is_required' => false],
                    ['section_type' => 'footer', 'default_title' => 'Ganpati Bappa Morya! ✨', 'default_subtitle' => 'Eagerly waiting to celebrate with you', 'sort_order' => 10, 'is_required' => true],
                ]
            ],
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

        // 3. Create a Showcase Live Demo Invitation for Ganesh Chaturthi
        $adminUser = User::where('role', 'admin')->first() ?? User::first();
        if ($adminUser) {
            $saffronTemplate = InvitationTemplate::where('slug', 'saffron-aura-lalbaug-ganesha')->first();
            
            $demoGanesh = Invitation::updateOrCreate([
                'slug' => 'shree-ganeshotsav-2026'
            ], [
                'uuid' => (string) Str::uuid(),
                'user_id' => $adminUser->id,
                'template_id' => $saffronTemplate?->id,
                'title' => 'Shree Ganeshotsav 2026 — Lalbaugcha Raja Aagman',
                'cover_image' => '/images/invitations/ganesh/saffron_lalbaug.jpg',
                'event_date' => now()->addDays(5)->setTime(10, 0),
                'status' => 'published',
                'primary_color' => '#EA580C',
                'secondary_color' => '#FFF7ED',
                'accent_color' => '#D97706',
                'font_family_heading' => 'Cinzel Decorative',
                'font_family_body' => 'Outfit',
                'animation_style' => 'marigold_shower',
                'music_url' => 'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',
                'music_autoplay' => false,
                'seo_title' => 'Shree Ganeshotsav 2026 Invitation — Bappa Aagman & Aarti Schedule',
                'seo_description' => 'You and your family are cordially invited to celebrate Shree Ganeshotsav with daily Mahamangal Aarti, Modak Mahaprasad and divine darshan.',
                'selected_features' => ['rsvp_custom_form', 'guest_qr_checkin', 'background_music', 'photo_gallery_unlimited', 'multi_event_timeline', 'ai_copywriter'],
                'expires_at' => now()->addMonths(6),
            ]);

            // Seed Events for Ganeshotsav
            $events = [
                [
                    'invitation_id' => $demoGanesh->id,
                    'title' => 'Bappa Aagman & Sthapana Mahapooja',
                    'event_date' => now()->addDays(5)->toDateString(),
                    'start_time' => '09:30:00',
                    'end_time' => '12:30:00',
                    'venue_name' => 'Shree Ganesh Krupa Mandap',
                    'venue_address' => 'Lalbaug Main Road, Parel, Mumbai 400012',
                    'dress_code' => 'Traditional Festive Kurta / Silk Saree',
                    'icon' => '🪔',
                    'sort_order' => 1
                ],
                [
                    'invitation_id' => $demoGanesh->id,
                    'title' => 'Daily Mahamangal Aarti & Dhol-Tasha',
                    'event_date' => now()->addDays(6)->toDateString(),
                    'start_time' => '19:30:00',
                    'end_time' => '21:00:00',
                    'venue_name' => 'Main Mandap Sanctuary',
                    'venue_address' => 'Lalbaug Main Road, Mumbai',
                    'dress_code' => 'Festive Saffron & Marigold Attire',
                    'icon' => '🥁',
                    'sort_order' => 2
                ],
                [
                    'invitation_id' => $demoGanesh->id,
                    'title' => 'Satyanarayan Mahapooja & 56 Bhog Mahaprasad',
                    'event_date' => now()->addDays(8)->toDateString(),
                    'start_time' => '16:00:00',
                    'end_time' => '21:30:00',
                    'venue_name' => 'Grand Dining Hall & Lawn',
                    'venue_address' => 'Lalbaug Sanctuary Lawn, Mumbai',
                    'dress_code' => 'Traditional Formals',
                    'icon' => '🥥',
                    'sort_order' => 3
                ],
                [
                    'invitation_id' => $demoGanesh->id,
                    'title' => 'Anant Chaturdashi Grand Visarjan Miravnuk',
                    'event_date' => now()->addDays(15)->toDateString(),
                    'start_time' => '15:00:00',
                    'end_time' => '22:00:00',
                    'venue_name' => 'Girgaon Chowpatty Seafront',
                    'venue_address' => 'Girgaon Chowpatty, Marine Drive, Mumbai',
                    'dress_code' => 'Gulal & Festive Whites/Saffron',
                    'icon' => '🌊',
                    'sort_order' => 4
                ],
            ];

            $demoGanesh->events()->delete();
            foreach ($events as $e) {
                InvitationEvent::create($e);
            }

            // Seed Sections for Demo
            $demoGanesh->sections()->delete();
            foreach ($saffronTemplate->sections as $sec) {
                InvitationSection::create([
                    'invitation_id' => $demoGanesh->id,
                    'section_type' => $sec->section_type,
                    'title' => $sec->default_title,
                    'subtitle' => $sec->default_subtitle,
                    'content' => [
                        'groom_name' => 'Lalbaugcha Raja Aagman',
                        'bride_name' => 'Shree Ganeshotsav',
                        'city_display' => 'Lalbaug, Mumbai',
                        'description' => 'A sacred 10-day spiritual celebration welcoming Vignaharta Lord Ganesha into our home with traditional Vedic rituals, daily aartis, and community Mahaprasad.',
                        'airport_distance' => '14 km from Mumbai International Airport',
                        'train_distance' => '2 km from Dadar Central Station',
                        'attire' => 'Vibrant Traditional Festive Indian Wear (Kurta Pyjama, Nauvari / Paithani Saree)',
                    ],
                    'sort_order' => $sec->sort_order,
                    'is_enabled' => true,
                ]);
            }

            // Seed RSVP Form
            $form = InvitationForm::updateOrCreate([
                'invitation_id' => $demoGanesh->id,
            ], [
                'title' => 'Darshan & Mahaprasad Confirmation',
                'description' => 'Kindly confirm your visiting date and number of family members for Prasad arrangements',
                'deadline' => now()->addDays(10),
                'max_party_size' => 10,
                'allow_guest_plus_one' => true,
                'is_active' => true,
            ]);

            $form->fields()->delete();
            InvitationFormField::create([
                'form_id' => $form->id,
                'field_type' => 'radio',
                'label' => 'Will you be visiting for Darshan & Aarti?',
                'options' => ['Yes, Attending with Family', 'Will join for Visarjan Miravnuk', 'Unable to attend in person'],
                'is_required' => true,
                'sort_order' => 1,
            ]);

            InvitationFormField::create([
                'form_id' => $form->id,
                'field_type' => 'number',
                'label' => 'Total number of family members attending',
                'placeholder' => '1',
                'is_required' => true,
                'sort_order' => 2,
            ]);

            InvitationFormField::create([
                'form_id' => $form->id,
                'field_type' => 'dropdown',
                'label' => 'Preferred Darshan Time Slot',
                'options' => ['Morning Aarti (09:00 AM - 12:00 PM)', 'Evening Mahamangal Aarti (07:00 PM - 09:30 PM)', 'Mahaprasad Feast (01:00 PM - 04:00 PM)'],
                'is_required' => false,
                'sort_order' => 3,
            ]);

            // Seed QR Code
            InvitationQrCode::updateOrCreate([
                'invitation_id' => $demoGanesh->id,
                'qr_type' => 'invitation_link',
            ], [
                'target_url' => url('/i/' . $demoGanesh->slug),
                'code_string' => 'INV-BAPPA2026',
                'foreground_color' => '#EA580C',
                'background_color' => '#FFFFFF',
            ]);
        }
    }
}
