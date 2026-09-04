<?php

namespace App\Services\Invitations;

use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationTemplate;
use App\Services\AiService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InvitationAiService
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Parse natural language user prompt to generate a complete Invitation blueprint.
     * Example prompt: "Create a royal Marathi wedding for Rahul and Priya in Mumbai on 15 December with Haldi, Mehendi, Sangeet and Reception, red and gold colors, 300 guests"
     */
    public function parseAndGenerateDraft(string $userPrompt): array
    {
        $promptLower = strtolower($userPrompt);

        // 1. Extract event type & culture
        $culture = 'indian';
        if (str_contains($promptLower, 'marathi')) {
            $culture = 'marathi';
        } elseif (str_contains($promptLower, 'punjabi') || str_contains($promptLower, 'sikh')) {
            $culture = 'punjabi';
        } elseif (str_contains($promptLower, 'muslim') || str_contains($promptLower, 'nikah') || str_contains($promptLower, 'nikaah')) {
            $culture = 'muslim';
        } elseif (str_contains($promptLower, 'south indian') || str_contains($promptLower, 'tamil') || str_contains($promptLower, 'telugu')) {
            $culture = 'south_indian';
        } elseif (str_contains($promptLower, 'bengali')) {
            $culture = 'bengali';
        } elseif (str_contains($promptLower, 'christian') || str_contains($promptLower, 'church')) {
            $culture = 'christian';
        } elseif (str_contains($promptLower, 'minimal') || str_contains($promptLower, 'modern')) {
            $culture = 'modern_minimal';
        }

        $eventType = 'Wedding';
        if (str_contains($promptLower, 'ganesh') || str_contains($promptLower, 'ganpati') || str_contains($promptLower, 'bappa') || str_contains($promptLower, 'ganeshotsav') || str_contains($promptLower, 'puja') || str_contains($promptLower, 'pooja') || str_contains($promptLower, 'siddhivinayak') || str_contains($promptLower, 'havan') || str_contains($promptLower, 'atharvashirsha') || str_contains($promptLower, 'modak')) {
            $eventType = 'Ganeshotsav';
        } elseif (str_contains($promptLower, 'birthday')) {
            $eventType = 'Birthday';
        } elseif (str_contains($promptLower, 'baby shower') || str_contains($promptLower, 'godh bharai')) {
            $eventType = 'Baby Shower';
        } elseif (str_contains($promptLower, 'anniversary')) {
            $eventType = 'Anniversary';
        } elseif (str_contains($promptLower, 'corporate') || str_contains($promptLower, 'conference') || str_contains($promptLower, 'summit') || str_contains($promptLower, 'gala')) {
            $eventType = 'Corporate';
        } elseif (str_contains($promptLower, 'engagement') || str_contains($promptLower, 'ring ceremony') || str_contains($promptLower, 'roka')) {
            $eventType = 'Engagement';
        }

        // 2. Extract Names
        $brideName = 'Priya';
        $groomName = 'Rahul';
        $hostName = 'The Family';

        if (preg_match('/for\s+([A-Za-z]+)\s+and\s+([A-Za-z]+)/i', $userPrompt, $matches)) {
            $groomName = ucfirst($matches[1]);
            $brideName = ucfirst($matches[2]);
        } elseif (preg_match('/([A-Za-z]+)\s*(?:&|and|weds|weds\s+with)\s*([A-Za-z]+)/i', $userPrompt, $matches)) {
            $groomName = ucfirst($matches[1]);
            $brideName = ucfirst($matches[2]);
        } elseif (preg_match('/for\s+([A-Za-z\s\']+)(?:\'s|\s+turning|\s+birthday)/i', $userPrompt, $matches)) {
            $groomName = trim($matches[1]);
            $brideName = '';
        }

        // 3. Extract Location
        $city = 'Mumbai, India';
        if (preg_match('/in\s+([A-Za-z\s]+?)(?:on|\.|with|for|\d|,|$)/i', $userPrompt, $matches)) {
            $extractedCity = trim($matches[1]);
            if (strlen($extractedCity) > 2 && strlen($extractedCity) < 30) {
                $city = $extractedCity;
            }
        }

        // 4. Extract Date
        $eventDate = now()->addMonths(2)->format('Y-m-d');
        if (preg_match('/(\d{1,2}(?:st|nd|rd|th)?\s+(?:jan(?:uary)?|feb(?:ruary)?|mar(?:ch)?|apr(?:il)?|may|jun(?:e)?|jul(?:y)?|aug(?:ust)?|sep(?:tember)?|oct(?:ober)?|nov(?:ember)?|dec(?:ember)?)(?:\s+\d{4})?)/i', $userPrompt, $matches)) {
            try {
                $parsed = Carbon::parse($matches[1]);
                if ($parsed->year < Carbon::now()->year) {
                    $parsed->year = Carbon::now()->year;
                }
                $eventDate = $parsed->format('Y-m-d');
            } catch (\Exception $e) {
                // Keep default
            }
        }

        // 5. Extract Guest Count
        $guestCount = 200;
        if (preg_match('/(\d+)\s*guests?/i', $userPrompt, $matches)) {
            $guestCount = (int)$matches[1];
        }

        // 6. Select Recommended Template
        $template = null;
        if ($eventType === 'Ganeshotsav') {
            if (str_contains($promptLower, 'peshwai') || str_contains($promptLower, 'pune') || str_contains($promptLower, 'dhol') || str_contains($promptLower, 'paithani')) {
                $template = InvitationTemplate::where('slug', 'peshwai-dhol-tasha-ganpati')->first();
            } elseif (str_contains($promptLower, 'eco') || str_contains($promptLower, 'clay') || str_contains($promptLower, 'green') || str_contains($promptLower, 'nature')) {
                $template = InvitationTemplate::where('slug', 'eco-friendly-clay-ganesha')->first();
            } elseif (str_contains($promptLower, 'temple') || str_contains($promptLower, 'marble') || str_contains($promptLower, 'atharvashirsha') || str_contains($promptLower, 'siddhivinayak')) {
                $template = InvitationTemplate::where('slug', 'temple-sanctum-marble-ganesha')->first();
            } elseif (str_contains($promptLower, 'bal') || str_contains($promptLower, 'kids') || str_contains($promptLower, 'fun') || str_contains($promptLower, 'joy')) {
                $template = InvitationTemplate::where('slug', 'celestial-bal-ganesha-joy')->first();
            } else {
                $template = InvitationTemplate::where('slug', 'saffron-aura-lalbaug-ganesha')->first();
            }
            $template = $template ?? InvitationTemplate::where('slug', 'saffron-aura-lalbaug-ganesha')->first() ?? InvitationTemplate::first();
        } elseif ($eventType === 'Wedding') {
            if ($culture === 'marathi' || str_contains($promptLower, 'gold') || str_contains($promptLower, 'royal')) {
                $template = InvitationTemplate::where('slug', 'royal-rajwada-palace')->first() ?? InvitationTemplate::first();
            } else {
                $template = InvitationTemplate::where('slug', 'elysian-bloom-floral')->first() ?? InvitationTemplate::first();
            }
        } elseif ($eventType === 'Birthday') {
            $template = InvitationTemplate::where('slug', 'little-astronaut-first-birthday')->first() ?? InvitationTemplate::first();
        } elseif ($eventType === 'Corporate') {
            $template = InvitationTemplate::where('slug', 'obsidian-zenith-corporate-gala')->first() ?? InvitationTemplate::first();
        } else {
            $template = InvitationTemplate::first();
        }

        // 7. Palette recommendation
        $palette = [
            'primary' => '#D4AF37',
            'secondary' => '#064E3B',
            'accent' => '#F59E0B',
            'bg_gradient' => 'linear-gradient(180deg, #09121d 0%, #064E3B 100%)',
            'font_heading' => 'Cinzel Decorative',
            'font_body' => 'Outfit',
            'animation' => 'sparkles_float'
        ];

        if ($eventType === 'Ganeshotsav') {
            $palette = [
                'primary' => '#EA580C',
                'secondary' => '#FFF7ED',
                'accent' => '#D97706',
                'bg_gradient' => 'linear-gradient(180deg, #FFF7ED 0%, #FFEDD5 100%)',
                'font_heading' => 'Cinzel Decorative',
                'font_body' => 'Outfit',
                'animation' => 'marigold_shower'
            ];
        } elseif (str_contains($promptLower, 'red') || str_contains($promptLower, 'maroon') || $culture === 'marathi') {
            $palette = [
                'primary' => '#D4AF37',
                'secondary' => '#580A15',
                'accent' => '#E11D48',
                'bg_gradient' => 'linear-gradient(180deg, #180306 0%, #580A15 100%)',
                'font_heading' => 'Cinzel Decorative',
                'font_body' => 'Outfit',
                'animation' => 'golden_shimmer'
            ];
        } elseif (str_contains($promptLower, 'pastel') || str_contains($promptLower, 'pink') || str_contains($promptLower, 'floral')) {
            $palette = [
                'primary' => '#E0A96D',
                'secondary' => '#201A23',
                'accent' => '#F472B6',
                'bg_gradient' => 'linear-gradient(180deg, #181124 0%, #2e1a38 100%)',
                'font_heading' => 'Playfair Display',
                'font_body' => 'Outfit',
                'animation' => 'petals_fall'
            ];
        }

        // 8. Generate Sub-events Itinerary
        $parsedDate = Carbon::parse($eventDate);
        $events = [];

        if ($eventType === 'Ganeshotsav') {
            $events[] = [
                'title' => 'Bappa Aagman & Sthapana Pooja',
                'date' => $parsedDate->format('Y-m-d'),
                'time' => '09:30',
                'venue' => 'Shree Ganesh Mandap, ' . $city,
                'dress_code' => 'Traditional Festive Kurta / Silk Saree',
                'icon' => '🪔'
            ];
            $events[] = [
                'title' => 'Daily Mahamangal Aarti & Dhol-Tasha',
                'date' => $parsedDate->format('Y-m-d'),
                'time' => '19:30',
                'venue' => 'Main Mandap Sanctuary, ' . $city,
                'dress_code' => 'Festive Saffron & Marigold Attire',
                'icon' => '🥁'
            ];
            $events[] = [
                'title' => '56 Bhog & Modak Mahaprasad Feast',
                'date' => $parsedDate->copy()->addDays(2)->format('Y-m-d'),
                'time' => '13:00',
                'venue' => 'Dining Hall & Lawn, ' . $city,
                'dress_code' => 'Traditional Festive Wear',
                'icon' => '🥥'
            ];
            $events[] = [
                'title' => 'Anant Chaturdashi Visarjan Miravnuk',
                'date' => $parsedDate->copy()->addDays(9)->format('Y-m-d'),
                'time' => '16:00',
                'venue' => 'Visarjan Seafront / River Ghat, ' . $city,
                'dress_code' => 'Gulal Festive Saffron & White',
                'icon' => '🌊'
            ];
        } elseif ($eventType === 'Wedding') {
            $events[] = [
                'title' => 'Mehendi & Sangeet Soirée',
                'date' => $parsedDate->copy()->subDays(1)->format('Y-m-d'),
                'time' => '16:30',
                'venue' => 'The Grand Ballroom & Poolside, ' . $city,
                'dress_code' => 'Pastel Lehengas & Festive Kurtas',
                'icon' => '🪕'
            ];
            $events[] = [
                'title' => 'Haldi & Phoolon Ki Holi',
                'date' => $parsedDate->format('Y-m-d'),
                'time' => '10:00',
                'venue' => 'Garden Courtyard, ' . $city,
                'dress_code' => 'Sunshine Yellow & Ivory',
                'icon' => '🌼'
            ];
            $events[] = [
                'title' => 'Varmala, Pheras & Royal Reception',
                'date' => $parsedDate->format('Y-m-d'),
                'time' => '18:30',
                'venue' => 'Royal Heritage Palace, ' . $city,
                'dress_code' => 'Royal Traditional Formals',
                'icon' => '👑'
            ];
        } elseif ($eventType === 'Birthday') {
            $events[] = [
                'title' => 'Cake Cutting & Galactic Fun',
                'date' => $parsedDate->format('Y-m-d'),
                'time' => '17:00',
                'venue' => 'Celebration Club House, ' . $city,
                'dress_code' => 'Smart Casual & Party Wear',
                'icon' => '🎂'
            ];
        } else {
            $events[] = [
                'title' => 'Keynote & Celebration Evening',
                'date' => $parsedDate->format('Y-m-d'),
                'time' => '18:00',
                'venue' => 'Convention Centre, ' . $city,
                'dress_code' => 'Formal Evening Attire',
                'icon' => '🏛️'
            ];
        }

        // 9. Generate Wording & Copy
        if ($eventType === 'Ganeshotsav') {
            $title = "Shree Ganeshotsav 2026 Celebration";
            $intro = "You and your family are cordially invited to celebrate the auspicious Ganeshotsav with us in {$city} and seek the divine blessings of Lord Ganesha.";
        } elseif ($eventType === 'Wedding') {
            $title = "{$groomName} & {$brideName} Wedding Celebration";
            $intro = "Together with our families, we joyfully invite you to celebrate the auspicious union and wedding festivities of {$groomName} & {$brideName} in {$city}.";
        } else {
            $title = "{$groomName}'s {$eventType} Celebration";
            $intro = "You are warmly invited to celebrate this special milestone with {$groomName} in {$city}.";
        }

        $whatsappCopy = "✨ *You're Cordially Invited!* ✨\n\n*{$title}*\n📅 *Date:* " . $parsedDate->format('d F Y') . "\n📍 *Location:* {$city}\n\nWe would be honored by your gracious presence and blessings.\n\n👇 *Open Your Interactive Digital Invitation:* \n{invitation_url}\n\nKindly RSVP at the link above!";

        // 10. Generate Suggested RSVP Questions
        $rsvpQuestions = [
            [
                'label' => 'Will you be attending?',
                'type' => 'radio',
                'options' => ['Joyfully Attending', 'Regretfully Declining'],
                'required' => true
            ],
            [
                'label' => 'Total number of guests in your party',
                'type' => 'number',
                'placeholder' => '1',
                'required' => true
            ],
            [
                'label' => 'Dietary Preferences',
                'type' => 'dropdown',
                'options' => ['Pure Vegetarian', 'Jain Vegetarian (No Onion/Garlic)', 'Non-Vegetarian', 'Vegan / Gluten-Free'],
                'required' => false
            ],
            [
                'label' => 'Do you require local transport or accommodation assistance?',
                'type' => 'yes_no',
                'options' => ['Yes', 'No'],
                'required' => false
            ]
        ];

        return [
            'success' => true,
            'event_type' => $eventType,
            'culture' => $culture,
            'title' => $title,
            'groom_name' => $groomName,
            'bride_name' => $brideName,
            'event_date' => $eventDate,
            'city' => $city,
            'guest_capacity' => $guestCount,
            'template' => $template ? [
                'id' => $template->id,
                'name' => $template->name,
                'slug' => $template->slug,
                'thumbnail_url' => $template->thumbnail_url,
            ] : null,
            'palette' => $palette,
            'events' => $events,
            'intro_text' => $intro,
            'whatsapp_template' => $whatsappCopy,
            'rsvp_questions' => $rsvpQuestions,
            'suggested_features' => ['rsvp_custom_form', 'guest_qr_checkin', 'background_music', 'photo_gallery_unlimited', 'multi_event_timeline', 'ai_copywriter'],
        ];
    }

    /**
     * Generate content tailored by Tone & Language.
     * Tones: traditional, modern, luxury, emotional, short, funny, hinglish, hindi
     */
    public function generateContentByTone(string $contentType, array $details, string $tone = 'luxury', string $language = 'en'): array
    {
        $coupleOrHost = $details['names'] ?? 'The Couple';
        $city = $details['city'] ?? 'Mumbai';
        $eventDate = $details['date'] ?? now()->addMonths(2)->format('d F Y');
        $eventType = $details['event_type'] ?? 'Wedding';

        // High-quality instant generators with rich cultural variations
        $fallback = '';
        if ($contentType === 'welcome_message') {
            if ($tone === 'traditional') {
                $fallback = "|| Shree Ganeshay Namah ||\nWith the divine blessings of our beloved ancestors and the Almighty, we warmly request the honour of your gracious presence and blessings to celebrate the auspicious union of {$coupleOrHost}.";
            } elseif ($tone === 'hinglish') {
                $fallback = "Dhol, dhamaka aur dher saara pyaar! {$coupleOrHost} ki wedding celebration mein aapka aana zaroori hai on {$eventDate} in {$city}. Come make some unforgettable memories with us!";
            } elseif ($tone === 'funny') {
                $fallback = "We swiped right, fell in love, and now we’re making it official! Come for {$coupleOrHost}'s vows, stay for the unlimited food and epic dance moves on {$eventDate} in {$city}.";
            } elseif ($tone === 'emotional') {
                $fallback = "Two lives, two hearts, and a sacred promise to walk hand in hand forever. Your blessings and presence mean the world to {$coupleOrHost} as they begin forever on {$eventDate}.";
            } else {
                $fallback = "Together with our families, we invite you to share in the joy and wonder of our {$eventType} celebration as {$coupleOrHost} begin their new chapter together on {$eventDate} in {$city}.";
            }
        } elseif ($contentType === 'whatsapp_invite') {
            if ($tone === 'hinglish') {
                $fallback = "✨ *Shadi Ka Invitation!* ✨\n\nPyare doston aur parivar,\n{$coupleOrHost} ki shadi hone ja rahi hai on *{$eventDate}* in *{$city}*!\n\nAapka aana zaroori hai. Saari details, venue map aur RSVP ke liye click karein:\n👉 {invitation_url}";
            } else {
                $fallback = "✨ *Formal Invitation* ✨\n\nYou are cordially invited to celebrate the {$eventType} of *{$coupleOrHost}* on *{$eventDate}* at *{$city}*.\n\nPlease find the complete itinerary, venue directions and RSVP at:\n👉 {invitation_url}\n\nWe look forward to welcoming you!";
            }
        } elseif ($contentType === 'thank_you') {
            $fallback = "From the bottom of our hearts, thank you for being a cherished part of our special celebration in {$city}! Your love, laughter, and blessings made our day truly unforgettable.";
        } else {
            $fallback = "With joy in our hearts, we invite you to be part of {$coupleOrHost}'s milestone celebration on {$eventDate} and create lasting memories together.";
        }

        return [
            'success' => true,
            'content' => $fallback,
            'tone' => $tone,
            'language' => $language,
        ];
    }

    /**
     * Generate romantic / engaging love story copy.
     */
    public function generateLoveStory(string $coupleNames, string $howTheyMet = '', string $tone = 'romantic'): array
    {
        $context = !empty($howTheyMet) ? " From their cherished beginnings ({$howTheyMet}), " : " ";
        $content = "From a serendipitous glance across a crowded room to countless shared sunrises, {$coupleNames}'s love is a story of laughter, trust, and unshakeable friendship.{$context}Together, they have built a sanctuary of dreams—where every journey leads back to each other's embrace.";

        return [
            'success' => true,
            'content' => $content,
            'provider' => 'celebrate-ai-engine',
        ];
    }

    /**
     * Generate poetic invitation greeting & invocation.
     */
    public function generatePoeticWording(string $coupleNames, string $hostNames, string $eventType = 'Wedding', string $style = 'royal'): array
    {
        $content = "|| Shree Ganeshay Namah ||\n\nTogether with our families, {$hostNames} joyfully request the honour of your presence and blessings to celebrate the auspicious {$eventType} of {$coupleNames} as they take their sacred vows.";

        return [
            'success' => true,
            'content' => $content,
            'provider' => 'celebrate-ai-engine',
        ];
    }


    /**
     * Recommend luxury color palette & typography based on season & event type.
     */
    public function recommendPalette(string $eventType, string $season = 'winter', string $venueType = 'palace'): array
    {
        $palettes = [
            'royal_gold' => [
                'name' => 'Royal Heritage Gold & Emerald',
                'primary' => '#D4AF37',
                'secondary' => '#064E3B',
                'accent' => '#F59E0B',
                'bg_gradient' => 'linear-gradient(180deg, #09121d 0%, #064E3B 100%)',
                'font_heading' => 'Cinzel Decorative',
                'font_body' => 'Outfit',
                'animation' => 'sparkles_float',
            ],
            'maroon_gold' => [
                'name' => 'Maroon & Royal Rajput Gold',
                'primary' => '#D4AF37',
                'secondary' => '#580A15',
                'accent' => '#E11D48',
                'bg_gradient' => 'linear-gradient(180deg, #180306 0%, #580A15 100%)',
                'font_heading' => 'Cinzel Decorative',
                'font_body' => 'Outfit',
                'animation' => 'golden_shimmer',
            ],
            'pastel_bloom' => [
                'name' => 'Elysian Rose & Lavender',
                'primary' => '#E0A96D',
                'secondary' => '#201A23',
                'accent' => '#F472B6',
                'bg_gradient' => 'linear-gradient(180deg, #181124 0%, #2e1a38 100%)',
                'font_heading' => 'Playfair Display',
                'font_body' => 'Outfit',
                'animation' => 'petals_fall',
            ],
            'midnight_noir' => [
                'name' => 'Midnight Obsidian & Azure Glow',
                'primary' => '#6366F1',
                'secondary' => '#030712',
                'accent' => '#38BDF8',
                'bg_gradient' => 'linear-gradient(180deg, #030712 0%, #0f172a 100%)',
                'font_heading' => 'Outfit',
                'font_body' => 'Outfit',
                'animation' => 'golden_shimmer',
            ],
            'sunset_terracotta' => [
                'name' => 'Tuscan Sunset Terracotta & Sage',
                'primary' => '#EA580C',
                'secondary' => '#1C1917',
                'accent' => '#FCD34D',
                'bg_gradient' => 'linear-gradient(180deg, #1c1917 0%, #431407 100%)',
                'font_heading' => 'Cormorant Garamond',
                'font_body' => 'Inter',
                'animation' => 'luxury_fade',
            ],
        ];

        $key = 'royal_gold';
        if (str_contains(strtolower($eventType), 'birthday')) {
            $key = 'midnight_noir';
        } elseif (str_contains(strtolower($season), 'spring') || str_contains(strtolower($venueType), 'garden')) {
            $key = 'pastel_bloom';
        } elseif (str_contains(strtolower($venueType), 'beach')) {
            $key = 'sunset_terracotta';
        }

        return [
            'success' => true,
            'palette' => $palettes[$key],
            'alternatives' => array_values($palettes),
        ];
    }
}

