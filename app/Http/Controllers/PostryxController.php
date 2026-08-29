<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostryxController extends Controller
{
    /**
     * Complete Directory of 12 Programmatic SEO Tools.
     */
    protected array $tools = [
        'linkedin-post-generator' => [
            'slug' => 'linkedin-post-generator',
            'api_type' => 'linkedin',
            'title' => 'Free AI LinkedIn Post & Carousel Generator',
            'h1' => 'Generate Viral LinkedIn Posts & Carousels with AI',
            'meta_title' => 'AI LinkedIn Post Generator - Create Viral Posts & Carousels | Postryx',
            'meta_description' => 'Free AI LinkedIn Post Generator. Create high-engagement thought leadership posts, formatted hooks, and carousel slides that generate 100k+ impressions.',
            'badge' => 'LinkedIn Viral Engine',
            'icon' => 'linkedin',
            'color' => 'from-blue-600 to-indigo-600',
            'placeholder' => 'e.g. 5 counter-intuitive lessons learned scaling a SaaS to $50k MRR without ads',
            'default_prompt' => 'Why 90% of founders fail at organic content marketing (and how to fix it)',
            'category' => 'Social Media',
            'features' => [
                '5 Viral Hook Formats (Contrarian, Story, Data, How-To, Framework)',
                'Unicode Bold & Formatted Typography (✦, →, •)',
                'High-converting ending CTAs & low-friction questions',
                'One-click Social Card Mockup & PDF export'
            ],
            'guide_steps' => [
                ['title' => 'Input Your Core Topic', 'desc' => 'Enter a core insight, lesson, or story you want to share with your professional network.'],
                ['title' => 'Select Tone & Format', 'desc' => 'Choose Thought Leader, Contrarian, Actionable, or Storyteller tone.'],
                ['title' => 'Generate & Refine', 'desc' => 'Our algorithm formats line spacing, bold key phrases, and inserts high-engagement bullet points.'],
                ['title' => '1-Click Copy & Publish', 'desc' => 'Copy directly to LinkedIn or export as an aesthetic carousel slide graphic.']
            ],
            'faqs' => [
                ['q' => 'Is this AI LinkedIn Post Generator free to use?', 'a' => 'Yes! Postryx offers 5 free generations every day without requiring a credit card or registration.'],
                ['q' => 'How does this tool help LinkedIn posts go viral?', 'a' => 'The engine employs high-retention hook velocity, optimized paragraph spacing for mobile dwell-time, and engagement-focused closing questions.'],
                ['q' => 'Can I use this for LinkedIn carousels?', 'a' => 'Yes, you can generate slide-by-slide breakdowns and use our built-in canvas exporter.']
            ]
        ],

        'viral-tweet-thread-generator' => [
            'slug' => 'viral-tweet-thread-generator',
            'api_type' => 'twitter',
            'title' => 'Viral Twitter / X Thread Maker & Hook Creator',
            'h1' => 'Create High-Engagement Twitter / X Threads in Seconds',
            'meta_title' => 'Viral Twitter / X Thread Generator - AI Thread Maker | Postryx',
            'meta_description' => 'Generate viral Twitter/X threads, scroll-stopping hooks, and multi-tweet breakdowns with AI. Boost retweets and follower growth effortlessly.',
            'badge' => 'Twitter / X Growth',
            'icon' => 'twitter',
            'color' => 'from-sky-500 to-blue-600',
            'placeholder' => 'e.g. 10 free AI tools that will save you 20 hours a week in 2026',
            'default_prompt' => 'The ultimate 5-step framework for building a high-leverage digital business',
            'category' => 'Social Media',
            'features' => [
                'Optimized 280-Character Tweet Splitting with 🧵 numbers',
                'Curiosity Gap Opening Hook formulas',
                'Retweet & Follow call-to-action closing tweet',
                'Instant Unroll & Markdown Export'
            ],
            'guide_steps' => [
                ['title' => 'Enter Thread Topic', 'desc' => 'State the core concept, listicle, or breakdown you want to unroll.'],
                ['title' => 'AI Generates 5-6 Tweets', 'desc' => 'The engine constructs a magnetic hook tweet followed by structured value tweets.'],
                ['title' => 'Review & Copy', 'desc' => 'Copy the entire thread at once or copy tweet-by-tweet directly into Twitter/X.']
            ],
            'faqs' => [
                ['q' => 'Does this generate threads within Twitter character limits?', 'a' => 'Yes, every tweet is structured to stay strictly within 280 characters with proper numbering (1/N, 2/N).'],
                ['q' => 'How do I get more retweets on my threads?', 'a' => 'Thread virality is 90% driven by Tweet #1. Use our Viral Headline Analyzer to score your hook before publishing.']
            ]
        ],

        'instagram-caption-generator' => [
            'slug' => 'instagram-caption-generator',
            'api_type' => 'instagram',
            'title' => 'AI Instagram Captions & Reels Script Generator',
            'h1' => 'Generate High-Conversion Instagram Captions & Reels Scripts',
            'meta_title' => 'AI Instagram Caption Generator - Viral Hooks & Hashtags | Postryx',
            'meta_description' => 'Free AI Instagram Caption Generator. Create engaging carousel copy, Reels hooks, call-to-actions, and trending hashtags that drive saves and shares.',
            'badge' => 'Instagram Growth',
            'icon' => 'instagram',
            'color' => 'from-pink-500 via-purple-500 to-rose-500',
            'placeholder' => 'e.g. 3 mindset shifts that will help you overcome creator burnout',
            'default_prompt' => 'How to build an aesthetic daily routine that boosts focus and creativity',
            'category' => 'Social Media',
            'features' => [
                'First-line attention grabbers (Before the "More" button)',
                'Save & Share conversion triggers',
                'Categorized viral & niche hashtag clusters',
                'Carousel slide-by-slide copy outlines'
            ],
            'guide_steps' => [
                ['title' => 'Type Your Photo or Video Idea', 'desc' => 'Describe your post, reel, or carousel subject.'],
                ['title' => 'Generate Engaging Caption', 'desc' => 'Receive a formatted caption with emojis, spacing, and CTA.'],
                ['title' => 'Paste to Instagram', 'desc' => 'Copy into Instagram along with generated hashtag sets.']
            ],
            'faqs' => [
                ['q' => 'Why are first-line hooks crucial for Instagram captions?', 'a' => 'Instagram truncates captions after 125 characters. A punchy hook encourages users to click "...more", triggering the algorithm for higher reach.']
            ]
        ],

        'youtube-title-and-script-generator' => [
            'slug' => 'youtube-title-and-script-generator',
            'api_type' => 'youtube',
            'title' => 'YouTube Shorts & Video Script Writer',
            'h1' => 'Generate High CTR YouTube Titles, Descriptions & Scripts',
            'meta_title' => 'AI YouTube Title & Script Generator - 10x Your Views | Postryx',
            'meta_description' => 'Create click-worthy YouTube video titles, high-retention video scripts, timestamps, and SEO descriptions to rank in YouTube search.',
            'badge' => 'YouTube Studio',
            'icon' => 'youtube',
            'color' => 'from-red-600 to-rose-700',
            'placeholder' => 'e.g. Complete tutorial on building automated affiliate websites in 2026',
            'default_prompt' => 'How to use AI to generate passive income from home (step by step)',
            'category' => 'Video & Audio',
            'features' => [
                '5 High-CTR Title Options with Power Brackets',
                'Full Timestamps & Chapter Breakdown',
                'SEO-Optimized 300-word Video Description',
                'YouTube Search Tag Cloud'
            ],
            'guide_steps' => [
                ['title' => 'Enter Video Concept', 'desc' => 'Describe what your YouTube video or short covers.'],
                ['title' => 'Receive Title & Script', 'desc' => 'Get click-tested titles, description with timestamps, and full narration outline.'],
                ['title' => 'Upload & Rank', 'desc' => 'Paste directly into YouTube Studio metadata fields.']
            ],
            'faqs' => [
                ['q' => 'How does this help my YouTube SEO?', 'a' => 'It creates structured descriptions with natural keyword density, chapter markers, and tags matching high search volume queries.']
            ]
        ],

        'ai-seo-blog-writer' => [
            'slug' => 'ai-seo-blog-writer',
            'api_type' => 'seo_blog',
            'title' => 'Programmatic Long-Form SEO Article Writer',
            'h1' => 'Write 2,000+ Word SEO Articles That Rank #1 on Google',
            'meta_title' => 'AI SEO Blog Writer - Long-Form Articles & Schema Generator | Postryx',
            'meta_description' => 'Write in-depth, humanized SEO blog posts with H1/H2/H3 headers, keyword optimization, FAQ schema, and meta tags that rank on Google.',
            'badge' => 'Rank #1 on Google',
            'icon' => 'file-text',
            'color' => 'from-emerald-500 to-teal-700',
            'placeholder' => 'e.g. The definitive guide to programmatic SEO and automated content hubs',
            'default_prompt' => 'How to build and scale an automated AI content business in 2026',
            'category' => 'SEO & Writing',
            'features' => [
                'Full H1, H2, H3 Semantic Hierarchy',
                'Key Takeaways Summary Table',
                'Built-in FAQ Section with Schema Markup',
                'Optimized Meta Title & Description'
            ],
            'guide_steps' => [
                ['title' => 'Enter Target Keyword', 'desc' => 'Provide your primary search query and core topic.'],
                ['title' => 'Generate Deep-Dive Article', 'desc' => 'The engine generates a structured 2,000+ word pillar article.'],
                ['title' => 'Publish & Index', 'desc' => 'Copy HTML or Markdown directly to WordPress, Webflow, or your CMS.']
            ],
            'faqs' => [
                ['q' => 'Does Google penalize AI-generated blog posts?', 'a' => 'Google explicitly states in its Helpful Content guidelines that it rewards high-quality, helpful content regardless of how it was produced. Postryx articles focus on depth and intent satisfaction.']
            ]
        ],

        'ai-content-humanizer' => [
            'slug' => 'ai-content-humanizer',
            'api_type' => 'humanize',
            'title' => 'AI Content Humanizer & AI Detection Remover',
            'h1' => 'Humanize AI Text & Bypass AI Detectors (100% Human Score)',
            'meta_title' => 'AI Content Humanizer - Bypass GPTZero, Turnitin & CopyLeaks | Postryx',
            'meta_description' => 'Turn robotic ChatGPT and AI writing into authentic, human-like copy. Bypass AI detectors like GPTZero, Turnitin, Originality AI, and CopyLeaks.',
            'badge' => 'Undetectable AI',
            'icon' => 'user-check',
            'color' => 'from-amber-500 to-orange-600',
            'placeholder' => 'Paste your AI-generated text here (from ChatGPT, Claude, Gemini, etc.)...',
            'default_prompt' => 'In today\'s fast-paced digital realm, leveraging AI is paramount. It is a testament to technological advancement that businesses can seamlessly delve into comprehensive solutions.',
            'category' => 'AI Utilities',
            'features' => [
                'Removes robotic AI clichés (delve into, tapestry, testament)',
                'Injects natural sentence variance (burstiness & perplexity)',
                '100% authentic human flow & conversational tone',
                'Guaranteed pass on Turnitin, GPTZero & Originality AI'
            ],
            'guide_steps' => [
                ['title' => 'Paste AI Text', 'desc' => 'Paste any text generated by ChatGPT, Claude, or other LLMs.'],
                ['title' => 'Click Humanize', 'desc' => 'Our proprietary engine restructures phrasing, syntax, and rhythm.'],
                ['title' => 'Get Human-Grade Copy', 'desc' => 'Receive humanized text ready for publishing or submission.']
            ],
            'faqs' => [
                ['q' => 'How does the AI Humanizer bypass detection?', 'a' => 'AI detectors look for uniform sentence lengths (low burstiness) and predictable word choices (low perplexity). Postryx rewrites sentences with natural human rhythm and varied phrasing.']
            ]
        ],

        'viral-headline-analyzer' => [
            'slug' => 'viral-headline-analyzer',
            'api_type' => 'analyze_hook',
            'title' => 'Viral Headline & Hook Score Analyzer (CTR Predictor)',
            'h1' => 'Analyze & Score Your Viral Hooks for Maximum Click-Throughs',
            'meta_title' => 'Viral Headline Analyzer & Hook Scorecard - Predict CTR | Postryx',
            'meta_description' => 'Free AI Headline Analyzer. Get real-time viral scores (0-100), emotional trigger counts, curiosity gap ratings, and instant AI-boosted variations.',
            'badge' => 'Hook Scorecard',
            'icon' => 'zap',
            'color' => 'from-violet-600 to-fuchsia-600',
            'placeholder' => 'e.g. 5 deadly mistakes every first-time founder makes in year one',
            'default_prompt' => 'How I grew to 50k followers in 90 days without spending a dollar on ads',
            'category' => 'Analytics & CRO',
            'features' => [
                'Overall Viral Potential Score (0-100)',
                'Emotional Power & Curiosity Gap breakdown',
                'Power Words & Character Length counter',
                '3 AI-Generated High-Performing Hook Alternatives'
            ],
            'guide_steps' => [
                ['title' => 'Enter Headline or Hook', 'desc' => 'Type any title, subject line, or opening sentence.'],
                ['title' => 'Get Real-Time Scorecard', 'desc' => 'See a breakdown of emotional triggers, length, and viral grade.'],
                ['title' => 'Pick a Winning Variation', 'desc' => 'Choose from 3 algorithmic high-converting variations.']
            ],
            'faqs' => [
                ['q' => 'What is a good viral headline score?', 'a' => 'A score above 75 indicates strong emotional curiosity and scannability. Scores 85+ have viral potential.']
            ]
        ],

        'ai-ad-copy-generator' => [
            'slug' => 'ai-ad-copy-generator',
            'api_type' => 'ad_copy',
            'title' => 'High-Converting Ad Copy Generator for Meta & Google',
            'h1' => 'Generate High-ROI Ad Copy for Facebook, Instagram & Google',
            'meta_title' => 'AI Ad Copy Generator - Create High-Converting Ads | Postryx',
            'meta_description' => 'Generate high-converting ad copy for Meta Ads, Google Ads, TikTok Ads, and Twitter. Boost ROAS and lower customer acquisition costs with AI.',
            'badge' => 'High-ROI Ads',
            'icon' => 'target',
            'color' => 'from-rose-500 to-red-600',
            'placeholder' => 'e.g. Postryx AI - All-in-one viral content generator for creators and agencies',
            'default_prompt' => 'SaaS tool that automates social media content and SEO blog writing for marketing agencies',
            'category' => 'Marketing & Sales',
            'features' => [
                'Meta / Facebook Primary Text & Headlines',
                'Google Search PPC Responsive Ad Assets',
                'TikTok Short-form Video Ad Script',
                'High-converting Call to Action options'
            ],
            'guide_steps' => [
                ['title' => 'Describe Product or Offer', 'desc' => 'Enter your value proposition, target audience, and offer.'],
                ['title' => 'Generate Multi-Platform Ads', 'desc' => 'Get tailored ads for Meta Ads Manager and Google Ads.'],
                ['title' => 'Launch & Scale', 'desc' => 'A/B test variations to find winning creatives.']
            ],
            'faqs' => [
                ['q' => 'Can I use this for both B2B and B2C ads?', 'a' => 'Yes, you can adjust tone and audience targeting to suit SaaS, e-commerce, coaching, or local services.']
            ]
        ],

        'cold-email-generator' => [
            'slug' => 'cold-email-generator',
            'api_type' => 'cold_email',
            'title' => 'B2B Cold Outreach & Sales Pitch Generator',
            'h1' => 'Write High-Response B2B Cold Email Sequences with AI',
            'meta_title' => 'AI Cold Email Generator - High Response B2B Sequences | Postryx',
            'meta_description' => 'Generate high-converting 3-step B2B cold email sequences, personalized icebreakers, and sales follow-ups that get replies and book meetings.',
            'badge' => 'B2B Lead Gen',
            'icon' => 'mail',
            'color' => 'from-indigo-500 to-purple-600',
            'placeholder' => 'e.g. Offering SEO content automation services to B2B SaaS companies',
            'default_prompt' => 'Offering automated viral social media management to busy tech founders and CEOs',
            'category' => 'Marketing & Sales',
            'features' => [
                '3-Step Sequence (Curiosity Hook, Case Study Proof, Breakup)',
                'High-Open-Rate Subject Line options',
                'Low-Friction Call-to-Actions (No hard sell)',
                'Merge tags ready for Instantly, Smartlead & Lemlist'
            ],
            'guide_steps' => [
                ['title' => 'Define Your Offer', 'desc' => 'State what problem you solve and for whom.'],
                ['title' => 'Generate Sequence', 'desc' => 'Get a 3-part email campaign with follow-ups.'],
                ['title' => 'Send & Book Calls', 'desc' => 'Upload into your cold email sending software.']
            ],
            'faqs' => [
                ['q' => 'Why does this sequence get higher response rates?', 'a' => 'It avoids generic sales pitches, keeps word counts under 80 words per email, and asks a low-friction question rather than demanding a 30-minute call.']
            ]
        ],

        'tiktok-reels-script-generator' => [
            'slug' => 'tiktok-reels-script-generator',
            'api_type' => 'tiktok_reels',
            'title' => 'Viral TikTok & Reels 60s Script Engine',
            'h1' => 'Generate 60-Second Viral Short-Form Video Scripts',
            'meta_title' => 'TikTok & Reels Script Generator - Viral 60s Video Scripts | Postryx',
            'meta_description' => 'Generate viral 60-second video scripts for TikTok, Instagram Reels, and YouTube Shorts. Includes 3s hooks, visual cues, and retention loops.',
            'badge' => 'Viral Video Scripts',
            'icon' => 'video',
            'color' => 'from-cyan-500 to-blue-600',
            'placeholder' => 'e.g. 3 hidden iPhone hacks that feel illegal to know',
            'default_prompt' => 'Why 99% of people are broke in their 20s and the 1 rule to flip it',
            'category' => 'Video & Audio',
            'features' => [
                '0-3s Visual Pattern Interrupt Hooks',
                'Scene-by-scene Narration and B-Roll directions',
                'On-screen Text Cue markers',
                'High-converting Follow/Comment CTA'
            ],
            'guide_steps' => [
                ['title' => 'Input Video Angle', 'desc' => 'Enter what hack, story, or tip you want to present.'],
                ['title' => 'Generate 60s Script', 'desc' => 'Get full camera directions, talking points, and text overlays.'],
                ['title' => 'Record & Post', 'desc' => 'Shoot in 5 minutes following the visual script cues.']
            ],
            'faqs' => [
                ['q' => 'What makes a TikTok or Reel hook successful?', 'a' => 'A successful hook combines a visual movement (zoom or pattern interrupt) with a bold statement that opens an immediate loop within the first 2 seconds.']
            ]
        ],

        'content-repurposer' => [
            'slug' => 'content-repurposer',
            'api_type' => 'repurpose',
            'title' => '1-Click Multi-Platform Content Repurposing Engine',
            'h1' => 'Turn 1 Idea into 5 Viral Posts Across Every Social Platform',
            'meta_title' => 'AI Content Repurposer - 1 Idea to 5 Social Posts | Postryx',
            'meta_description' => 'Repurpose any blog post, video idea, or insight into a LinkedIn post, Twitter thread, Instagram caption, newsletter, and Reel script simultaneously.',
            'badge' => 'Omni-Channel Engine',
            'icon' => 'layers',
            'color' => 'from-purple-600 to-indigo-700',
            'placeholder' => 'e.g. The 80/20 rule of building organic search traffic using programmatic content hubs',
            'default_prompt' => 'How small teams can produce 50x more content without hiring an agency using AI workflows',
            'category' => 'Omni-Channel',
            'features' => [
                '1-Click 5-Platform Generation (LinkedIn, Twitter, IG, Email, Reels)',
                'Tailored formatting and tone for each individual network',
                'Unified workspace with tabbed multi-post viewer',
                'Batch export to Markdown, Text, and Social Cards'
            ],
            'guide_steps' => [
                ['title' => 'Enter 1 Core Idea', 'desc' => 'Paste a rough note, article link, or core insight.'],
                ['title' => 'Click Repurpose', 'desc' => 'The engine generates 5 unique platform-specific versions.'],
                ['title' => 'Distribute Everywhere', 'desc' => 'Publish across your entire social ecosystem in minutes.']
            ],
            'faqs' => [
                ['q' => 'Why is content repurposing better than creating from scratch?', 'a' => 'Repurposing allows you to maximize the ROI of every strong idea, ensuring audience members across LinkedIn, Twitter, Instagram, and Email all experience your best work.']
            ]
        ],

        'hashtag-generator' => [
            'slug' => 'hashtag-generator',
            'api_type' => 'hashtag',
            'title' => 'Viral Trending Hashtag & Keyword Density Finder',
            'h1' => 'Find High-Reach Trending Hashtags & Social Keywords',
            'meta_title' => 'AI Hashtag Generator - High-Reach & Niche Hashtags | Postryx',
            'meta_description' => 'Generate 30+ categorized high-volume and niche hashtags for Instagram, TikTok, LinkedIn, and YouTube to maximize organic discovery.',
            'badge' => 'Organic Reach',
            'icon' => 'hash',
            'color' => 'from-emerald-500 to-cyan-600',
            'placeholder' => 'e.g. AI productivity tools and solopreneur lifestyle',
            'default_prompt' => 'Digital marketing strategies, AI content creation, and SEO ranking',
            'category' => 'Social Media',
            'features' => [
                '3-Tier Categorization (High Volume, Mid Tier, Niche)',
                'Spam filter & banned hashtag protection',
                '1-Click Copy all or selected hashtags',
                'Works for Instagram, TikTok, LinkedIn, and YouTube'
            ],
            'guide_steps' => [
                ['title' => 'Enter Niche or Keywords', 'desc' => 'Provide 2-3 words about your post topic.'],
                ['title' => 'Generate Hashtag Sets', 'desc' => 'Get 30 balanced hashtags divided by reach tiers.'],
                ['title' => 'Copy & Paste', 'desc' => 'Add to your post caption or first comment.']
            ],
            'faqs' => [
                ['q' => 'How many hashtags should I use on Instagram?', 'a' => 'A balanced mix of 5-8 niche-specific hashtags and 3-5 high-volume hashtags currently achieves the highest reach on modern algorithms.']
            ]
        ],
    ];

    /**
     * Pillar Blog Guides for High-Volume SEO Rankings.
     */
    protected array $blogPosts = [
        'linkedin-algorithm-playbook-2026' => [
            'slug' => 'linkedin-algorithm-playbook-2026',
            'title' => 'The 2026 LinkedIn Algorithm Playbook: How to Write Posts That Reach 100k+ Impressions',
            'meta_description' => 'Discover the exact 7 hook formulas, formatting secrets, and algorithmic signals that drive viral LinkedIn impressions in 2026.',
            'category' => 'Viral Social',
            'read_time' => '7 min read',
            'author' => 'Aarav Sharma',
            'author_role' => 'Head of Growth at Postryx',
            'date' => 'August 2026',
            'excerpt' => 'LinkedIn has shifted from corporate resumes to the #1 thought leadership platform in the world. Here is how to exploit the new dwell-time algorithm.',
            'content' => 'linkedin_guide'
        ],
        'programmatic-seo-guide-rank-1' => [
            'slug' => 'programmatic-seo-guide-rank-1',
            'title' => 'Programmatic SEO Mastery: How We Built 500+ Ranking Pages in 30 Days',
            'meta_description' => 'A step-by-step guide to programmatic SEO, database-driven landing pages, and capturing millions in organic search traffic.',
            'category' => 'SEO Strategies',
            'read_time' => '10 min read',
            'author' => 'Priya Mehta',
            'author_role' => 'SEO Architect',
            'date' => 'August 2026',
            'excerpt' => 'Manual keyword targeting is slow. Learn how programmatic SEO allows you to dominate search engine results pages at massive scale.',
            'content' => 'pseo_guide'
        ],
        'bypass-ai-detectors-humanize-content' => [
            'slug' => 'bypass-ai-detectors-humanize-content',
            'title' => 'How to Bypass AI Detectors: The Science Behind Undetectable Humanized Copy',
            'meta_description' => 'Learn how AI detectors like Turnitin and GPTZero work, and the exact linguistic methods to achieve 100% human authenticity scores.',
            'category' => 'AI Growth',
            'read_time' => '6 min read',
            'author' => 'Vikram Patel',
            'author_role' => 'AI Research Lead',
            'date' => 'August 2026',
            'excerpt' => 'Why rigid AI text gets flagged by detectors, and how adjusting burstiness and perplexity produces authentic, human-grade writing.',
            'content' => 'humanizer_guide'
        ],
        'x-twitter-growth-blueprint-2026' => [
            'slug' => 'x-twitter-growth-blueprint-2026',
            'title' => 'The X / Twitter Growth Blueprint: Building a 50K Audience with AI Threads',
            'meta_description' => 'The definitive guide to viral X/Twitter growth. Learn how top creators leverage curiosity hooks, thread unrolling, and algorithmic momentum.',
            'category' => 'Viral Social',
            'read_time' => '8 min read',
            'author' => 'Rohan Sen',
            'author_role' => 'Viral Strategist',
            'date' => 'August 2026',
            'excerpt' => 'Twitter rewards velocity and retention. Master the 5-part thread architecture that turns casual scrollers into loyal followers.',
            'content' => 'twitter_guide'
        ],
        'multi-platform-repurposing-formula' => [
            'slug' => 'multi-platform-repurposing-formula',
            'title' => 'The Multi-Platform Repurposing Formula: Turn 1 Idea into 15 Viral Assets',
            'meta_description' => 'Stop burning out creating content from scratch. Discover the omni-channel distribution machine that multiplies your reach 10x.',
            'category' => 'Case Studies',
            'read_time' => '5 min read',
            'author' => 'Ananya Verma',
            'author_role' => 'Content Director',
            'date' => 'August 2026',
            'excerpt' => 'How the world’s most prolific creators publish daily on 5 platforms simultaneously while only spending 2 hours a week on ideation.',
            'content' => 'repurpose_guide'
        ],
    ];

    /**
     * Homepage.
     */
    public function home()
    {
        return view('home', [
            'tools' => $this->tools,
            'blogPosts' => $this->blogPosts,
            'stats' => [
                'posts_generated' => '1,482,930',
                'active_creators' => '42,500+',
                'average_reach_boost' => '4.8x',
                'time_saved_hours' => '120k+'
            ]
        ]);
    }

    /**
     * Dedicated Programmatic Tool Page.
     */
    public function tool(string $slug)
    {
        if (!isset($this->tools[$slug])) {
            abort(404);
        }

        $tool = $this->tools[$slug];
        $otherTools = array_filter($this->tools, fn($k) => $k !== $slug, ARRAY_FILTER_USE_KEY);

        return view('tool', [
            'tool' => $tool,
            'otherTools' => array_slice($otherTools, 0, 4),
            'allTools' => $this->tools
        ]);
    }

    /**
     * Pricing Page.
     */
    public function pricing()
    {
        return view('pricing', [
            'tools' => $this->tools
        ]);
    }

    /**
     * Blog Index (Only Active Blogs from Database).
     */
    public function blog()
    {
        $posts = \App\Models\Blog::active()->latest()->paginate(9);

        return view('blog.index', [
            'posts' => $posts,
            'tools' => $this->tools
        ]);
    }

    /**
     * Blog Show Page (Only Active Blogs).
     */
    public function blogShow(string $slug)
    {
        $post = \App\Models\Blog::where('slug', $slug)->active()->firstOrFail();
        
        // Increment live views count
        $post->increment('views_count');

        $recentPosts = \App\Models\Blog::active()
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('blog.show', [
            'post' => $post,
            'recentPosts' => $recentPosts,
            'tools' => $this->tools
        ]);
    }

    /**
     * Affiliate Portal.
     */
    public function affiliate()
    {
        return view('affiliate', [
            'tools' => $this->tools
        ]);
    }

    /**
     * Legal Terms of Service.
     */
    public function terms()
    {
        return view('legal.terms', ['tools' => $this->tools]);
    }

    /**
     * Legal Privacy Policy.
     */
    public function privacy()
    {
        return view('legal.privacy', ['tools' => $this->tools]);
    }

    /**
     * Dynamic SEO Sitemap.xml with Image Namespace & Priorities.
     */
    public function sitemap()
    {
        $baseUrl = rtrim(config('app.url', 'https://postryx.in'), '/');
        $date = date('Y-m-d');
        $urls = [
            ['loc' => $baseUrl . '/', 'priority' => '1.0', 'changefreq' => 'daily', 'image' => $baseUrl . '/images/postryx-og-banner.png', 'title' => 'Postryx AI Autonomous Viral Engine'],
            ['loc' => $baseUrl . '/pricing', 'priority' => '0.9', 'changefreq' => 'weekly', 'image' => $baseUrl . '/images/postryx-og-banner.png', 'title' => 'Postryx AI Pricing & Plans'],
            ['loc' => $baseUrl . '/affiliate', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/blog', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/terms', 'priority' => '0.3', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/privacy', 'priority' => '0.3', 'changefreq' => 'monthly'],
        ];

        // Add 12 Programmatic Tools
        foreach ($this->tools as $t) {
            $urls[] = [
                'loc' => $baseUrl . '/tools/' . $t['slug'],
                'priority' => '0.9',
                'changefreq' => 'daily',
                'lastmod' => $date,
                'image' => $baseUrl . '/images/postryx-og-banner.png',
                'title' => $t['title']
            ];
        }

        // Add Dynamic Active Blog Posts from Database
        try {
            $activeBlogs = \App\Models\Blog::active()->get();
            foreach ($activeBlogs as $b) {
                $urls[] = [
                    'loc' => $baseUrl . '/blog/' . $b->slug,
                    'priority' => '0.8',
                    'changefreq' => 'weekly',
                    'lastmod' => $b->updated_at->format('Y-m-d'),
                    'image' => $b->featured_image ? (str_starts_with($b->featured_image, 'http') ? $b->featured_image : $baseUrl . '/' . ltrim($b->featured_image, '/')) : ($baseUrl . '/images/postryx-og-banner.png'),
                    'title' => $b->title
                ];
            }
        } catch (\Throwable $e) {
            // In case database is temporarily unmigrated
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        foreach ($urls as $u) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . ($u['lastmod'] ?? $date) . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $u['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $u['priority'] . '</priority>' . "\n";
            if (!empty($u['image'])) {
                $xml .= '    <image:image>' . "\n";
                $xml .= '      <image:loc>' . htmlspecialchars($u['image']) . '</image:loc>' . "\n";
                if (!empty($u['title'])) {
                    $xml .= '      <image:title>' . htmlspecialchars($u['title']) . '</image:title>' . "\n";
                }
                $xml .= '    </image:image>' . "\n";
            }
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Custom SEO & AI Search Crawler robots.txt Generator.
     */
    public function robots()
    {
        $baseUrl = rtrim(config('app.url', 'https://postryx.in'), '/');
        
        $content = "# Postryx AI Autonomous Robots Configuration\n";
        $content .= "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /dashboard/\n";
        $content .= "Disallow: /affiliate/dashboard\n\n";

        $content .= "# Search Engine Web & Image Crawlers\n";
        $content .= "User-agent: Googlebot\nAllow: /\n";
        $content .= "User-agent: Googlebot-Image\nAllow: /\n";
        $content .= "User-agent: Bingbot\nAllow: /\n";
        $content .= "User-agent: Applebot\nAllow: /\n";
        $content .= "User-agent: DuckDuckBot\nAllow: /\n\n";

        $content .= "# AI Search Engines & LLM Crawlers (Allowed for High-Intent Indexing)\n";
        $content .= "User-agent: GPTBot\nAllow: /\n";
        $content .= "User-agent: ChatGPT-User\nAllow: /\n";
        $content .= "User-agent: OAI-SearchBot\nAllow: /\n";
        $content .= "User-agent: ClaudeBot\nAllow: /\n";
        $content .= "User-agent: anthropic-ai\nAllow: /\n";
        $content .= "User-agent: PerplexityBot\nAllow: /\n";
        $content .= "User-agent: CCBot\nAllow: /\n\n";

        $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
