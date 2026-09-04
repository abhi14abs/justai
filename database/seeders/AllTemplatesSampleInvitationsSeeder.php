<?php

namespace Database\Seeders;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationEvent;
use App\Models\Invitations\InvitationForm;
use App\Models\Invitations\InvitationFormField;
use App\Models\Invitations\InvitationQrCode;
use App\Models\Invitations\InvitationSection;
use App\Models\Invitations\InvitationTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AllTemplatesSampleInvitationsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first() ?? User::factory()->create([
            'name' => 'Abhishek Admin',
            'email' => 'admin@justai.com',
            'password' => bcrypt('password'),
        ]);

        $templates = InvitationTemplate::with(['category', 'subcategory', 'sections'])->get();

        foreach ($templates as $template) {
            $sampleSlug = 'sample-' . $template->slug;
            
            // Special custom slug aliases if preferred
            if ($template->slug === 'royal-rajwada-palace') {
                $sampleSlug = 'priya-and-rahul-wedding';
            } elseif ($template->slug === 'saffron-aura-lalbaug-ganesha') {
                $sampleSlug = 'shree-ganeshotsav-2026';
            }

            $themeConfig = $template->theme_config ?? [];
            $primaryColor = $themeConfig['primary_color'] ?? '#D4AF37';
            $secondaryColor = $themeConfig['secondary_color'] ?? '#0F172A';
            $accentColor = $themeConfig['accent_color'] ?? '#F59E0B';
            $animationStyle = $themeConfig['animation_style'] ?? 'marigold_shower';

            $invitation = Invitation::updateOrCreate(
                ['slug' => $sampleSlug],
                [
                    'user_id' => $admin->id,
                    'template_id' => $template->id,
                    'title' => $template->name,
                    'event_date' => now()->addDays(3)->setTime(9, 30),
                    'status' => 'published',
                    'primary_color' => $primaryColor,
                    'secondary_color' => $secondaryColor,
                    'accent_color' => $accentColor,
                    'font_family_heading' => $themeConfig['font_family_heading'] ?? 'Cinzel Decorative',
                    'font_family_body' => $themeConfig['font_family_body'] ?? 'Outfit',
                    'animation_style' => $animationStyle,
                    'music_url' => 'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',
                    'cover_image' => $template->thumbnail_url,
                    'seo_title' => $template->name . ' — Digital Invitation Demo',
                    'seo_description' => $template->description,
                    'published_at' => now(),
                ]
            );

            // Clean existing sections & events to ensure crisp authentic content
            $invitation->sections()->delete();
            $invitation->events()->delete();

            // Populate template-specific sections
            $this->seedSectionsForTemplate($invitation, $template);
            $this->seedEventsForTemplate($invitation, $template);
            $this->seedRsvpForTemplate($invitation, $template);
        }

        echo "Successfully seeded authentic sample invitations for all 13 templates!\n";
    }

    private function seedSectionsForTemplate(Invitation $invitation, InvitationTemplate $template): void
    {
        $isGanesh = Str::contains($template->slug, ['ganesh', 'ganpati', 'lalbaug', 'peshwai-dhol', 'eco-friendly', 'marble-ganesha', 'bal-ganesha']);
        
        $sections = [
            [
                'section_type' => 'hero',
                'title' => $isGanesh ? '|| श्री गणेशाय नमः ||' : '✦ Shubh Vivah ✦',
                'subtitle' => $isGanesh 
                    ? 'You and your family are cordially invited to celebrate the auspicious Ganeshotsav and seek Bappa’s divine blessings.'
                    : 'Together with their families, we joyfully invite you to celebrate the grand celebration.',
                'content' => [
                    'event_type' => $isGanesh ? 'festival' : 'wedding',
                    'heading' => $invitation->title,
                    'date_display' => 'September 07 - 17, 2026',
                    'city_display' => $isGanesh ? 'Mumbai / Pune / Bengaluru' : 'Udaipur, Rajasthan',
                    'groom_name' => $isGanesh ? '' : 'Rahul Sharma',
                    'bride_name' => $isGanesh ? '' : 'Priya Patel',
                ],
                'sort_order' => 1,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'introduction',
                'title' => $isGanesh ? '|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||' : 'Divine Blessings & Welcome',
                'subtitle' => $isGanesh 
                    ? 'निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha illuminate our lives with boundless wisdom, prosperity, and peace.'
                    : 'With the blessings of our beloved elders, we invite you to be part of our sacred milestone.',
                'content' => [],
                'sort_order' => 2,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'countdown',
                'title' => $isGanesh ? 'Bappa Aagman Countdown' : 'Countdown to the Big Day',
                'subtitle' => $isGanesh ? 'Counting down the auspicious hours to Ganesh Chaturthi Sthapana' : 'Every moment brings us closer to celebration',
                'content' => [],
                'sort_order' => 3,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'events',
                'title' => $isGanesh ? 'Ganeshotsav Pooja & Aarti Schedule' : 'Celebration Schedule & Ceremonies',
                'subtitle' => $isGanesh ? 'Join us for sacred aartis, devotional bhajans and mahaprasad' : 'Please join us for all ceremonial festivities',
                'content' => [],
                'sort_order' => 4,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'venue',
                'title' => $isGanesh ? 'Mandap Location & Darshan Timings' : 'Venue & Hospitality Details',
                'subtitle' => $isGanesh ? 'Devotee guidelines, parking assistance and prasadam counters' : 'Taj Lake Palace, Pichola, Udaipur',
                'content' => [
                    'venue_name' => $isGanesh ? 'Shree Ganesh Krupa Mandap' : 'The Grand Palace Courtyard',
                    'address' => $isGanesh ? 'Lalbaug / Kasba Peth / Indiranagar' : 'Pichola, Udaipur, Rajasthan 313001',
                    'landmark' => $isGanesh ? 'Near Main Temple Gate' : 'Opposite Lake Palace Jetty',
                ],
                'sort_order' => 5,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'map',
                'title' => 'Location & Navigation',
                'subtitle' => 'Get 1-Tap Google Maps Driving Directions',
                'content' => [],
                'sort_order' => 6,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'dress_code',
                'title' => 'Festive Attire Guidelines',
                'subtitle' => $isGanesh ? 'Traditional Festive Wear: Kurta Pyjama, Dhoti, Silk Saree & Nauvari' : 'Royal Pastel Silk & Festive Kurtas',
                'content' => [
                    'guidelines' => $isGanesh ? 'Bright festive traditional colors (Saffron, Yellow, Magenta, Green). Avoid black attire during pooja rituals.' : 'Pastel festive lehengas and royal bandhgalas.',
                ],
                'sort_order' => 7,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'rsvp',
                'title' => $isGanesh ? 'Darshan & Mahaprasad RSVP' : 'Kindly Respond (RSVP)',
                'subtitle' => $isGanesh ? 'Please let us know your visiting slot and prasad box requirement' : 'Please confirm your attendance by November 01',
                'content' => [],
                'sort_order' => 8,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'guestbook',
                'title' => $isGanesh ? 'Bappa Blessings & Prayers Wall' : 'Wishes & Memories Wall',
                'subtitle' => $isGanesh ? 'Leave your Ganesh Chaturthi wishes and prayers for all devotees' : 'Leave your warm wishes and loving thoughts for the hosts',
                'content' => [],
                'sort_order' => 9,
                'is_enabled' => true,
            ],
            [
                'section_type' => 'footer',
                'title' => $isGanesh ? '|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||' : 'With Heartfelt Love & Gratitude',
                'subtitle' => $isGanesh ? 'The Parivar & Devotees Welfare Committee' : 'The Sharma & Patel Families',
                'content' => [],
                'sort_order' => 10,
                'is_enabled' => true,
            ],
        ];

        foreach ($sections as $s) {
            $invitation->sections()->create([
                'section_type' => $s['section_type'],
                'title' => $s['title'],
                'subtitle' => $s['subtitle'],
                'content' => $s['content'],
                'sort_order' => $s['sort_order'],
                'is_enabled' => $s['is_enabled'],
            ]);
        }
    }

    private function seedEventsForTemplate(Invitation $invitation, InvitationTemplate $template): void
    {
        if ($template->slug === 'saffron-aura-lalbaug-ganesha') {
            $events = [
                ['title' => 'Bappa Aagman & Pranpratishtha', 'icon' => '🌺', 'event_date' => now()->addDays(1)->setTime(9, 0), 'start_time' => '09:00:00', 'venue_name' => 'Shree Ganesh Krupa Pandal', 'venue_address' => 'Lalbaug Main Road, Mumbai', 'dress_code' => 'Kesariya Saffron & Traditional Yellow'],
                ['title' => 'Daily Atharvashirsha & Maha Aarti', 'icon' => '🪔', 'event_date' => now()->addDays(2)->setTime(19, 30), 'start_time' => '19:30:00', 'venue_name' => 'Main Sanctum Hall', 'venue_address' => 'Lalbaug, Mumbai', 'dress_code' => 'Ethnic Kurta & Paithani Silk'],
                ['title' => '56 Bhog Mahaprasad & Bhajan Sandhya', 'icon' => '🍯', 'event_date' => now()->addDays(5)->setTime(13, 0), 'start_time' => '13:00:00', 'venue_name' => 'Annakshetra Dining Hall', 'venue_address' => 'Lalbaug, Mumbai', 'dress_code' => 'Festive Indian Wear'],
                ['title' => 'Anant Chaturdashi Mahavisarjan', 'icon' => '🥁', 'event_date' => now()->addDays(10)->setTime(16, 0), 'start_time' => '16:00:00', 'venue_name' => 'Girgaon Chowpatty', 'venue_address' => 'Marine Drive, Mumbai', 'dress_code' => 'Traditional White & Saffron Dupatta'],
            ];
        } elseif ($template->slug === 'peshwai-dhol-tasha-ganpati') {
            $events = [
                ['title' => 'Shahi Aagman Miravand (Dhol-Tasha)', 'icon' => '🥁', 'event_date' => now()->addDays(1)->setTime(8, 30), 'start_time' => '08:30:00', 'venue_name' => 'Laxmi Road to Kasba Ganpati', 'venue_address' => 'Kasba Peth, Pune', 'dress_code' => 'Puneri Pheta & Paithani Magenta'],
                ['title' => 'Ganesh Yag & Atharvashirsha Avartan', 'icon' => '🕉️', 'event_date' => now()->addDays(3)->setTime(10, 0), 'start_time' => '10:00:00', 'venue_name' => 'Peshwai Darbar Sabhagruh', 'venue_address' => 'Shivajinagar, Pune', 'dress_code' => 'Traditional Dhoti & Silk Kurta'],
                ['title' => 'Haldi-Kunku & Bhajan Sandhya', 'icon' => '🌸', 'event_date' => now()->addDays(6)->setTime(17, 30), 'start_time' => '17:30:00', 'venue_name' => 'Kasba Sabhagruh', 'venue_address' => 'Pune, Maharashtra', 'dress_code' => 'Paithani Saree & Traditional Gold'],
                ['title' => 'Shahi Visarjan Miravand & Gulal Utsav', 'icon' => '🚩', 'event_date' => now()->addDays(10)->setTime(15, 0), 'start_time' => '15:00:00', 'venue_name' => 'Alka Talkies Chowk', 'venue_address' => 'Tilak Road, Pune', 'dress_code' => 'White Kurta with Saffron Stole'],
            ];
        } elseif ($template->slug === 'eco-friendly-clay-ganesha') {
            $events = [
                ['title' => 'Clay Bappa Sthapana & Durva Arpan', 'icon' => '🌱', 'event_date' => now()->addDays(1)->setTime(9, 30), 'start_time' => '09:30:00', 'venue_name' => 'Green Earth Eco-Homes Garden', 'venue_address' => 'Indiranagar 100ft Road, Bengaluru', 'dress_code' => 'Organic Cotton & Khadi Pastels'],
                ['title' => 'Satyanarayan Pooja & Tulsi Archana', 'icon' => '🍃', 'event_date' => now()->addDays(4)->setTime(11, 0), 'start_time' => '11:00:00', 'venue_name' => 'Terrace Garden Mandap', 'venue_address' => 'Bengaluru, Karnataka', 'dress_code' => 'Eco Green & Off-White Silk'],
                ['title' => 'Organic Ukadiche Modak & Bhojan', 'icon' => '🥥', 'event_date' => now()->addDays(6)->setTime(13, 30), 'start_time' => '13:30:00', 'venue_name' => 'Banana Leaf Dining Lawn', 'venue_address' => 'Indiranagar, Bengaluru', 'dress_code' => 'Festive Casuals'],
                ['title' => 'Eco Pot Visarjan & Tree Planting', 'icon' => '🌳', 'event_date' => now()->addDays(10)->setTime(17, 0), 'start_time' => '17:00:00', 'venue_name' => 'Lakeside Eco Pavilion', 'venue_address' => 'Bengaluru', 'dress_code' => 'Comfortable Nature Greens'],
            ];
        } elseif ($template->slug === 'temple-sanctum-marble-ganesha') {
            $events = [
                ['title' => 'Maha Sankalpam & Sanctum Sthapana', 'icon' => '🪔', 'event_date' => now()->addDays(1)->setTime(8, 0), 'start_time' => '08:00:00', 'venue_name' => 'Shree Siddhivinayak Temple Sanctum', 'venue_address' => 'Prabhadevi, Mumbai', 'dress_code' => 'Makrana Silk & Sanctum Gold'],
                ['title' => '1008 Modak Maha Yag & Veda Pathan', 'icon' => '🔥', 'event_date' => now()->addDays(3)->setTime(9, 30), 'start_time' => '09:30:00', 'venue_name' => 'Yagashala Mandapam', 'venue_address' => 'Prabhadevi, Mumbai', 'dress_code' => 'Traditional Silk Dhoti & Angavastram'],
                ['title' => 'Swarna Deepa Maha Aarti & Bhajans', 'icon' => '✨', 'event_date' => now()->addDays(7)->setTime(19, 0), 'start_time' => '19:00:00', 'venue_name' => 'Grand Marble Courtyard', 'venue_address' => 'Mumbai, Maharashtra', 'dress_code' => 'Rich Crimson & Gilded Gold'],
                ['title' => 'Shobha Yatra & Samudra Visarjan', 'icon' => '🌊', 'event_date' => now()->addDays(10)->setTime(16, 30), 'start_time' => '16:30:00', 'venue_name' => 'Dadar Chowpatty Beach', 'venue_address' => 'Dadar, Mumbai', 'dress_code' => 'Traditional Festive Attire'],
            ];
        } elseif ($template->slug === 'celestial-bal-ganesha-joy') {
            $events = [
                ['title' => 'Bal Bappa Joyful Aagman & Rangoli', 'icon' => '🎨', 'event_date' => now()->addDays(1)->setTime(10, 30), 'start_time' => '10:30:00', 'venue_name' => 'Anand Bhavan Courtyard', 'venue_address' => 'Jubilee Hills, Hyderabad', 'dress_code' => 'Tangerine Glow & Pastel Yellows'],
                ['title' => 'Kids Clay Modak Workshop & Magic Show', 'icon' => '🍬', 'event_date' => now()->addDays(2)->setTime(16, 0), 'start_time' => '16:00:00', 'venue_name' => 'Joy Kids Activity Hall', 'venue_address' => 'Hyderabad, Telangana', 'dress_code' => 'Bright Colorful Kids Festive Wear'],
                ['title' => 'Family Maha Aarti & Motichoor Laddoo Feast', 'icon' => '🪔', 'event_date' => now()->addDays(5)->setTime(19, 0), 'start_time' => '19:00:00', 'venue_name' => 'Family Pooja Hall', 'venue_address' => 'Hyderabad, Telangana', 'dress_code' => 'Festive Kurta & Ghagra'],
                ['title' => 'Joyful Rose Petal Visarjan Celebration', 'icon' => '🌸', 'event_date' => now()->addDays(10)->setTime(17, 30), 'start_time' => '17:30:00', 'venue_name' => 'Lotus Pond Club', 'venue_address' => 'Jubilee Hills, Hyderabad', 'dress_code' => 'Floral Prints & Pastels'],
            ];
        } else {
            // Standard Wedding / Event Itinerary
            $events = [
                ['title' => 'Haldi & Phoolon Ki Holi', 'icon' => '🌼', 'event_date' => now()->addDays(30)->setTime(10, 0), 'start_time' => '10:00:00', 'venue_name' => 'Poolside Gardens, Taj Lake Palace', 'venue_address' => 'Pichola, Udaipur, Rajasthan', 'dress_code' => 'Shades of Sunshine Yellow & Ochre'],
                ['title' => 'Mehendi & Sangeet Soirée', 'icon' => '🪕', 'event_date' => now()->addDays(30)->setTime(18, 30), 'start_time' => '18:30:00', 'venue_name' => 'Royal Courtyard, Taj Lake Palace', 'venue_address' => 'Pichola, Udaipur, Rajasthan', 'dress_code' => 'Bright Pastel Lehengas & Kurtas'],
                ['title' => 'Shubh Vivah & Varmala Ceremony', 'icon' => '👑', 'event_date' => now()->addDays(31)->setTime(17, 0), 'start_time' => '17:00:00', 'venue_name' => 'Grand Palace Amphitheater', 'venue_address' => 'Udaipur, Rajasthan', 'dress_code' => 'Royal Silk, Maroon & Gold'],
                ['title' => 'Grand Reception & Gala Dinner', 'icon' => '🥂', 'event_date' => now()->addDays(32)->setTime(19, 30), 'start_time' => '19:30:00', 'venue_name' => 'The Grand Ballroom', 'venue_address' => 'Udaipur, Rajasthan', 'dress_code' => 'Black Tie / Formal Evening Wear'],
            ];
        }

        foreach ($events as $e) {
            $invitation->events()->create($e);
        }
    }

    private function seedRsvpForTemplate(Invitation $invitation, InvitationTemplate $template): void
    {
        $isGanesh = Str::contains($template->slug, ['ganesh', 'ganpati', 'lalbaug', 'peshwai-dhol', 'eco-friendly', 'marble-ganesha', 'bal-ganesha']);

        $form = InvitationForm::create([
            'invitation_id' => $invitation->id,
            'title' => $isGanesh ? 'Darshan & Mahaprasad RSVP' : 'Ceremony RSVP Confirmation',
            'description' => $isGanesh ? 'Kindly let us know your visiting date and number of devotees for prasad arrangements' : 'Please confirm your attendance so we can reserve your royal stay and seating.',
            'is_active' => true,
        ]);

        InvitationFormField::create([
            'form_id' => $form->id,
            'label' => 'Full Name / Family Representative',
            'field_type' => 'text',
            'placeholder' => 'e.g. Rajesh Sharma & Family',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        InvitationFormField::create([
            'form_id' => $form->id,
            'label' => 'WhatsApp Contact Number',
            'field_type' => 'phone',
            'placeholder' => '+91 98765 43210',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        InvitationFormField::create([
            'form_id' => $form->id,
            'label' => 'Total Number of Devotees / Guests Attending',
            'field_type' => 'number',
            'placeholder' => '2',
            'is_required' => true,
            'sort_order' => 3,
        ]);

        InvitationFormField::create([
            'form_id' => $form->id,
            'label' => $isGanesh ? 'Will You Join for Daily Evening Maha Aarti & Mahaprasad?' : 'Will You Attend All Ceremonies?',
            'field_type' => 'select',
            'options' => $isGanesh ? ['Yes, Joyfully Attending', 'Visiting for Darshan Only', 'Sending Prayers Remotely'] : ['Yes, Attending with Joy', 'Regretfully Cannot Attend'],
            'is_required' => true,
            'sort_order' => 4,
        ]);
    }
}
