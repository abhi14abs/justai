<?php

namespace Tests\Feature;

use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationPlatformTest extends TestCase
{
    /**
     * Test Existing Postryx Application is unaffected (No regression).
     */
    public function test_existing_application_home_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test Digital Invitations Marketplace Catalog loads.
     */
    public function test_invitation_marketplace_loads(): void
    {
        $response = $this->get('/invitations');
        $response->assertStatus(200);
        $response->assertSee('Celebrate Life’s Grandest Milestones');
    }

    /**
     * Test Interactive Template Preview.
     */
    public function test_template_preview_loads(): void
    {
        $response = $this->get('/invitations/preview/royal-rajwada-palace');
        $response->assertStatus(200);
        $response->assertSee('royal-rajwada-palace');
    }

    /**
     * Test Public Digital Invitation URL.
     */
    public function test_public_invitation_loads(): void
    {
        $response = $this->get('/i/priya-and-rahul-wedding');
        $response->assertStatus(200);
        $response->assertSee('Shubh Vivah');
        $response->assertSee('Rahul Verma');
        $response->assertSee('Priya Sharma');
    }

    /**
     * Test Personalized Guest Link.
     */
    public function test_personalized_guest_invitation_loads(): void
    {
        $response = $this->get('/i/priya-and-rahul-wedding?g=GST-MEHRA99');
        $response->assertStatus(200);
        $response->assertSee('Dr. Arvind Mehra');
    }

    /**
     * Test Dynamic Pricing Calculation API.
     */
    public function test_pricing_calculation_api(): void
    {
        $template = InvitationTemplate::where('slug', 'royal-rajwada-palace')->first();
        $response = $this->postJson('/api/invitations/pricing/calculate', [
            'template_id' => $template?->id,
            'features' => ['guest_qr_checkin', 'background_music'],
            'currency' => 'INR',
            'coupon' => 'CELEBRATE50',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure([
            'success',
            'pricing' => [
                'currency',
                'template_price',
                'features_total',
                'subtotal',
                'discount_amount',
                'final_amount',
            ]
        ]);
    }

    /**
     * Test RSVP Submission.
     */
    public function test_rsvp_submission(): void
    {
        $response = $this->postJson('/i/priya-and-rahul-wedding/rsvp', [
            'guest_name' => 'Karan Johar',
            'guest_email' => 'karan@example.com',
            'guest_phone' => '+91 98000 11111',
            'attending_status' => 'attending',
            'party_size' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
    }

    /**
     * Test AI Love Story Copywriter API.
     */
    public function test_ai_love_story_generator_api(): void
    {
        $response = $this->postJson('/api/invitations/ai/love-story', [
            'couple_names' => 'Rohan & Simran',
            'how_they_met' => 'Euro rail journey across Switzerland',
            'tone' => 'romantic',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertNotEmpty($response->json('content'));
    }

    /**
     * Test AI Natural Language Prompt Parser.
     */
    public function test_ai_natural_language_parser(): void
    {
        $response = $this->postJson('/api/invitations/ai/parse-prompt', [
            'prompt' => 'Royal Marathi wedding for Rahul and Priya in Mumbai on 15 December with Haldi, Mehendi, Sangeet and Reception, red and gold colors, 300 guests',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('event_type', 'Wedding');
        $response->assertJsonPath('culture', 'marathi');
        $this->assertNotEmpty($response->json('events'));
        $this->assertNotEmpty($response->json('palette'));
    }

    /**
     * Test AI Multi-Tone Copywriter.
     */
    public function test_ai_tone_copywriter(): void
    {
        $response = $this->postJson('/api/invitations/ai/tone-copy', [
            'content_type' => 'welcome_message',
            'details' => [
                'names' => 'Rahul & Priya',
                'date' => '15 December 2026',
                'city' => 'Mumbai',
                'event_type' => 'Wedding'
            ],
            'tone' => 'traditional',
            'language' => 'en'
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertNotEmpty($response->json('content'));
    }

    /**
     * Test AI 1-Click Provisioning from Natural Language.
     */
    public function test_ai_create_from_prompt(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->postJson('/api/invitations/ai/create-from-prompt', [
            'prompt' => 'Dreamy pastel garden wedding for Aarav & Tara in Bangalore on Jan 20 with Sangeet and Twilight Vows, 200 guests',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertNotEmpty($response->json('redirect_url'));
    }

    /**
     * Test Post-Event Memories & Photo Pool.
     */
    public function test_guest_memories_listing(): void
    {
        $response = $this->get('/i/priya-and-rahul-wedding/memories');
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
    }

    /**
     * Test WhatsApp Personalized Message Generator.
     */
    public function test_whatsapp_message_generator(): void
    {
        $user = User::first();
        $invitation = Invitation::where('slug', 'priya-and-rahul-wedding')->first();

        $response = $this->actingAs($user)->postJson("/dashboard/invitations/{$invitation->id}/whatsapp/generate", [
            'guest_name' => 'Anand Mahindra',
            'guest_code' => 'GST-MEHRA99',
            'tone' => 'royal'
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertStringContainsString('Anand Mahindra', $response->json('message'));
        $this->assertStringContainsString('GST-MEHRA99', $response->json('direct_url'));
    }

    /**
     * Test Admin Digital Invitations Dashboard.
     */
    public function test_admin_invitations_dashboard_accessible_by_admin(): void
    {
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $response = $this->actingAs($admin)->get('/admin/invitations');
            $response->assertStatus(200);
            $response->assertSee('Digital Invitations Management Center');
        }
    }
}

