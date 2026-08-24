<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'The 2026 LinkedIn Algorithm Playbook: How to Write Posts That Reach 100k+ Impressions',
                'slug' => 'linkedin-algorithm-playbook-2026',
                'category' => 'Viral Social',
                'tags' => ['LinkedIn', 'Viral Hooks', 'B2B Growth', 'Algorithm'],
                'author_name' => 'Aarav Sharma',
                'read_time' => '7 min read',
                'featured_image' => 'images/postryx-hero-banner.png',
                'excerpt' => 'LinkedIn has shifted from corporate resumes to the #1 thought leadership platform in the world. Here is how to exploit the new dwell-time algorithm.',
                'meta_title' => 'The 2026 LinkedIn Algorithm Playbook — Reach 100k+ Impressions | Postryx',
                'meta_description' => 'Discover the exact 7 hook formulas, formatting secrets, and algorithmic signals that drive viral LinkedIn impressions in 2026.',
                'is_active' => true,
                'views_count' => 1420,
                'content' => '<h2>The Dwell-Time Revolution on LinkedIn</h2>
<p>LinkedIn’s feed algorithm in 2026 is no longer prioritizing simple like-for-like engagement pods. Instead, the platform ranks content based on a metric called <strong>Qualified Dwell Time</strong>—the duration a user spends with your post expanded on screen reading through your copy.</p>

<h3>1. The 3-Line "See More" Hook Formula</h3>
<p>Your first 210 characters dictate 90% of your post performance. If you fail to trigger the <em>"...see more"</em> click, the algorithm flags your content as low-retention.</p>
<ul>
    <li><strong>The Contrarian Shift:</strong> "Most advice about scaling SaaS is dead wrong. Here is what actually worked for our team:"</li>
    <li><strong>The Data Proof:</strong> "We analyzed 4,800 viral LinkedIn posts over the last 90 days. 3 patterns emerged:"</li>
    <li><strong>The Vulnerability Opening:</strong> "6 months ago, our organic reach plummeted to zero. Today, we average 250k monthly impressions."</li>
</ul>

<h3>2. The Clean Visual Rhythm (Skimmable Spacing)</h3>
<p>Wall-of-text posts have a 78% higher bounce rate on mobile. Ensure every paragraph is limited to 1–2 sentences with clear bullet lists and directional arrows.</p>

<h3>3. Postryx AI Carousel Automation</h3>
<p>PDF Carousels generate 3.4x higher comment depth than standard text posts. Use Postryx AI to automatically convert long-form guides into 7-slide actionable carousels in one click.</p>'
            ],
            [
                'title' => 'Programmatic SEO Mastery: How We Built 500+ Ranking Pages in 30 Days',
                'slug' => 'programmatic-seo-guide-rank-1',
                'category' => 'SEO Strategies',
                'tags' => ['SEO', 'Programmatic SEO', 'Google Rank', 'Growth Engine'],
                'author_name' => 'Priya Mehta',
                'read_time' => '10 min read',
                'featured_image' => 'images/postryx-hero-banner.png',
                'excerpt' => 'Manual keyword targeting is slow. Learn how programmatic SEO allows you to dominate search engine results pages at massive scale.',
                'meta_title' => 'Programmatic SEO Mastery — 500+ Ranking Pages in 30 Days | Postryx',
                'meta_description' => 'A step-by-step guide to programmatic SEO, database-driven landing pages, and capturing millions in organic search traffic.',
                'is_active' => true,
                'views_count' => 2890,
                'content' => '<h2>Why Traditional Keyword Research Is Obsolete</h2>
<p>If you are writing one 1,500-word blog post per week manually, you are competing at a 50x disadvantage against programmatic creators. Programmatic SEO (pSEO) is the art of building scalable page templates populated by structured datasets.</p>

<h3>The 3 Pillars of a High-Ranking pSEO Architecture</h3>
<ol>
    <li><strong>Intent Satisfying Templates:</strong> Pages designed with unique schema metadata, rich FAQ sections, and dynamic calculators.</li>
    <li><strong>Internal Link Velocity:</strong> Automatic cross-linking between related search clusters to maximize crawl efficiency.</li>
    <li><strong>Humanized Content Quality:</strong> Incorporating real-world data and structured comparisons so your programmatic pages avoid Google’s unhelpful content filters.</li>
</ol>'
            ],
            [
                'title' => 'How to Bypass AI Detectors: The Science Behind Undetectable Humanized Copy',
                'slug' => 'bypass-ai-detectors-humanize-content',
                'category' => 'AI Growth',
                'tags' => ['AI Humanizer', 'GPTZero', 'Turnitin', 'Copywriting'],
                'author_name' => 'Vikram Patel',
                'read_time' => '6 min read',
                'featured_image' => 'images/postryx-hero-banner.png',
                'excerpt' => 'Why rigid AI text gets flagged by detectors, and how adjusting burstiness and perplexity produces authentic, human-grade writing.',
                'meta_title' => 'How to Bypass AI Detectors — 99.4% Human Authenticity | Postryx',
                'meta_description' => 'Learn how AI detectors like Turnitin and GPTZero work, and the exact linguistic methods to achieve 100% human authenticity scores.',
                'is_active' => true,
                'views_count' => 3120,
                'content' => '<h2>Understanding Perplexity and Burstiness</h2>
<p>AI detectors like GPTZero, Turnitin, and Originality.ai do not understand meaning—they measure mathematical probability across two metrics: <strong>Perplexity</strong> (vocabulary unpredictability) and <strong>Burstiness</strong> (sentence length variance).</p>

<h3>Eliminating AI Watermark Clichés</h3>
<p>Standard LLMs overuse recognizable filler phrases like <em>"delve into"</em>, <em>"a testament to"</em>, <em>"paramount importance"</em>, and <em>"in conclusion"</em>. Postryx AI strips out robotic clichés and rewrites sentences with natural human cadence, varied rhythm, and authentic conversational phrasing.</p>'
            ],
            [
                'title' => 'The X / Twitter Growth Blueprint: Building a 50K Audience with AI Threads',
                'slug' => 'x-twitter-growth-blueprint-2026',
                'category' => 'Viral Social',
                'tags' => ['Twitter', 'X Growth', 'Viral Threads', 'Social Media'],
                'author_name' => 'Rohan Sen',
                'read_time' => '8 min read',
                'featured_image' => 'images/postryx-hero-banner.png',
                'excerpt' => 'Twitter rewards velocity and retention. Master the 5-part thread architecture that turns casual scrollers into loyal followers.',
                'meta_title' => 'The X / Twitter Growth Blueprint — Build a 50k Audience | Postryx',
                'meta_description' => 'The definitive guide to viral X/Twitter growth. Learn how top creators leverage curiosity hooks, thread unrolling, and algorithmic momentum.',
                'is_active' => true,
                'views_count' => 1980,
                'content' => '<h2>The Anatomy of a Viral 7-Tweet Thread</h2>
<p>On X/Twitter, the first tweet is your billboard. If tweet #1 does not stop the doomscroll within 1.5 seconds, the rest of your thread will never be read.</p>
<p>Structure your threads with an emotional opener, 4 high-value insights, and a concluding bookmark-worthy takeaway with a clear call-to-action.</p>'
            ],
            [
                'title' => 'The Multi-Platform Repurposing Formula: Turn 1 Idea into 15 Viral Assets',
                'slug' => 'multi-platform-repurposing-formula',
                'category' => 'Case Studies',
                'tags' => ['Repurposing', 'Content Scaling', 'Omni-Channel', 'Productivity'],
                'author_name' => 'Ananya Verma',
                'read_time' => '5 min read',
                'featured_image' => 'images/postryx-hero-banner.png',
                'excerpt' => 'How the world’s most prolific creators publish daily on 5 platforms simultaneously while only spending 2 hours a week on ideation.',
                'meta_title' => 'The Multi-Platform Repurposing Formula | Postryx AI',
                'meta_description' => 'Stop burning out creating content from scratch. Discover the omni-channel distribution machine that multiplies your reach 10x.',
                'is_active' => true,
                'views_count' => 2450,
                'content' => '<h2>The 1-to-10 Content Cascade</h2>
<p>Never write for a single platform in isolation. When you discover a high-performing concept, run it through the Postryx Repurposing Engine to instantly distribute across LinkedIn, Twitter/X, Instagram Reels scripts, newsletters, and SEO blog posts.</p>'
            ]
        ];

        foreach ($articles as $art) {
            Blog::updateOrCreate(['slug' => $art['slug']], $art);
        }
    }
}
