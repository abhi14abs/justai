<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostryxController extends Controller
{
    /**
     * Complete Directory of 12 Programmatic SEO Tools with Comprehensive Keyword Clusters,
     * Deep-Dive Guides, LSI Search Terms, HowTo steps, and FAQ Structured Schema.
     */
    protected array $tools = [
        'linkedin-post-generator' => [
            'slug' => 'linkedin-post-generator',
            'api_type' => 'linkedin',
            'title' => 'Free AI LinkedIn Post & Carousel Generator',
            'h1' => 'Generate Viral LinkedIn Posts & Carousels with AI',
            'meta_title' => 'AI LinkedIn Post Generator - Create Viral Posts & Carousels | Postryx',
            'meta_description' => 'Free AI LinkedIn Post Generator. Create high-engagement thought leadership posts, formatted hooks, and carousel slides that generate 100k+ impressions.',
            'meta_keywords' => 'AI LinkedIn post generator, LinkedIn carousel generator, viral LinkedIn post creator, LinkedIn hook generator, LinkedIn thought leadership AI, B2B LinkedIn growth, LinkedIn formatting tool unicode, postryx.in',
            'badge' => 'LinkedIn Viral Engine',
            'icon' => 'linkedin',
            'color' => 'from-blue-600 to-indigo-600',
            'placeholder' => 'e.g. 5 counter-intuitive lessons learned scaling a SaaS to $50k MRR without ads',
            'default_prompt' => 'Why 90% of founders fail at organic content marketing (and how to fix it)',
            'category' => 'Social Media Growth',
            'lsi_keywords' => [
                'LinkedIn post generator AI free',
                'How to write viral LinkedIn posts',
                'LinkedIn carousel maker PDF',
                'LinkedIn formatting whitespace and bold text',
                'Thought leadership content creator',
                'B2B social selling post templates'
            ],
            'features' => [
                '5 Viral Hook Formats (Contrarian, Story, Data, How-To, Framework)',
                'Unicode Bold & Formatted Typography (✦, →, •)',
                'High-converting ending CTAs & low-friction questions',
                'One-click Social Card Mockup & PDF carousel slide exporter',
                'Optimized mobile whitespace to maximize Qualified Dwell Time'
            ],
            'guide_steps' => [
                ['title' => 'Input Your Core Topic or Insight', 'desc' => 'Enter a lesson, data point, or personal founder story you want to share with your professional audience.'],
                ['title' => 'Select Tone & Formatting Style', 'desc' => 'Choose Thought Leader, Contrarian, Step-by-Step Blueprint, or Personal Storyteller tone.'],
                ['title' => 'AI Crafts Structured Post & Hooks', 'desc' => 'Our algorithm formats line spacing, applies bold Unicode accents, and crafts a high-retention 3-line hook.'],
                ['title' => '1-Click Copy or Export Carousel', 'desc' => 'Copy directly into LinkedIn or export as an aesthetic multi-slide PDF carousel.']
            ],
            'deep_dive' => [
                'title' => 'How the 2026 LinkedIn Algorithm Rewards High-Dwell Content',
                'summary' => 'LinkedIn’s algorithm has evolved from basic engagement pods to measuring Qualified Dwell Time—the exact seconds a user spends with your post expanded on screen.',
                'sections' => [
                    [
                        'heading' => 'The Anatomy of the 3-Line "...see more" Click Trigger',
                        'content' => 'On mobile screens, LinkedIn truncates posts after approximately 210 characters. If your opening lines do not create an intense curiosity gap, readers scroll past and your dwell score plummets. Postryx AI constructs opening lines using proven contrarian and data-backed hooks that trigger the "...see more" click within 1.5 seconds.'
                    ],
                    [
                        'heading' => 'Mobile Skimmability: Spacing, Arrows & Unicode Typography',
                        'content' => 'Dense walls of text suffer an average 78% bounce rate. High-performing LinkedIn creators use single-sentence paragraphs, directional arrows (→), bullet points (•), and subtle Unicode bolding to guide the reader’s eye smoothly from hook to call-to-action.'
                    ],
                    [
                        'heading' => 'The Engagement Velocity Equation & Closing Questions',
                        'content' => 'Posts that generate meaningful comments within the first 60 minutes receive 3.8x broader algorithmic distribution. End your post with a low-friction, specific question rather than a generic "Thoughts?" to stimulate authentic B2B discussion.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'Is this AI LinkedIn Post Generator completely free to use?', 'a' => 'Yes! Postryx provides 5 free daily generation credits without requiring a credit card or registration.'],
                ['q' => 'How does Postryx optimize posts for the LinkedIn algorithm?', 'a' => 'Postryx incorporates 3-line curiosity hooks to trigger the "...see more" button, formats scannable mobile whitespace to maximize dwell time, and generates low-friction closing questions that boost comment velocity.'],
                ['q' => 'Can I create LinkedIn PDF Carousels with this tool?', 'a' => 'Yes. You can generate slide-by-slide outlines and export them directly into branded social card graphics and multi-page carousels.'],
                ['q' => 'What tones are available for LinkedIn posts?', 'a' => 'You can choose between Thought Leader & Viral, Contrarian & Direct, Personal Storyteller, Step-by-Step Blueprint, and Professional Authority.']
            ]
        ],

        'viral-tweet-thread-generator' => [
            'slug' => 'viral-tweet-thread-generator',
            'api_type' => 'twitter',
            'title' => 'Viral Twitter / X Thread Maker & Hook Creator',
            'h1' => 'Create High-Engagement Twitter / X Threads in Seconds',
            'meta_title' => 'Viral Twitter / X Thread Generator - AI Thread Maker | Postryx',
            'meta_description' => 'Generate viral Twitter/X threads, scroll-stopping hooks, and multi-tweet breakdowns with AI. Boost retweets and follower growth effortlessly.',
            'meta_keywords' => 'Twitter thread maker, viral tweet generator, X thread creator, AI Twitter hook generator, tweet unroll maker, convert blog to twitter thread, Twitter growth tool, postryx.in',
            'badge' => 'Twitter / X Growth',
            'icon' => 'twitter',
            'color' => 'from-sky-500 to-blue-600',
            'placeholder' => 'e.g. 10 free AI tools that will save you 20 hours a week in 2026',
            'default_prompt' => 'The ultimate 5-step framework for building a high-leverage digital business',
            'category' => 'Social Media Growth',
            'lsi_keywords' => [
                'Best AI tool for Twitter threads',
                'How to write viral threads on Twitter X',
                'Twitter thread scheduler and formatter',
                'X viral hook formulas and templates',
                'Automate Twitter content creation with AI'
            ],
            'features' => [
                'Strict 280-Character Tweet Splitting with 🧵 numbers',
                'Curiosity Gap Tweet #1 Opening Hook formulas',
                'Retweet & Bookmark CTA closing tweet with summary',
                '1-Click Tweet Unroll & Markdown Export',
                'Optimized character count counters for each individual tweet'
            ],
            'guide_steps' => [
                ['title' => 'Enter Your Topic or Link', 'desc' => 'State the core concept, listicle, breakdown, or paste a blog URL you want to unroll.'],
                ['title' => 'AI Generates Structured 5-7 Tweet Thread', 'desc' => 'The engine constructs a magnetic Tweet #1 hook followed by value-dense sub-tweets.'],
                ['title' => 'Review & Refine Character Limits', 'desc' => 'Each tweet is verified to stay strictly within Twitter/X’s 280-character boundary.'],
                ['title' => 'Copy Thread or Schedule', 'desc' => 'Copy the entire thread at once or copy tweet-by-tweet directly into X/Typefully/Hypefury.']
            ],
            'deep_dive' => [
                'title' => 'The Architecture of a 50k-Impression Twitter / X Thread',
                'summary' => 'On X (formerly Twitter), your first tweet is your headline, billboard, and filter. If Tweet #1 fails, Tweet #2 will never be seen.',
                'sections' => [
                    [
                        'heading' => 'The 5-Part Thread Anatomy',
                        'content' => 'A viral thread consists of: 1) The Magnetic Hook (bold claim + curiosity gap + thread emoji 🧵), 2) The Context Reframe, 3) 3-5 High-Value Core Insights, 4) The TL;DR Summary Tweet, and 5) The Call to Action (Follow + Retweet Tweet #1).'
                    ],
                    [
                        'heading' => 'Optimizing for Retweets and Bookmarks',
                        'content' => 'The X algorithm places high algorithmic weight on bookmarks and retweets. Summarizing complex frameworks into clean bulleted lists encourages users to bookmark your thread for future reference.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'Does this generate threads within Twitter character limits?', 'a' => 'Yes, every generated tweet is automatically formatted to stay strictly within 280 characters with sequential numbering (1/N, 2/N).'],
                ['q' => 'How do I convert a blog post into a Twitter thread?', 'a' => 'Simply paste the core takeaways or summary of your blog post into the prompt field, and the AI will extract the key insights into an unrolled 6-tweet thread.'],
                ['q' => 'How can I increase retweets and bookmarks on my threads?', 'a' => 'Use high-utility listicles, frameworks with concrete examples, and include a clear bookmark reminder in the penultimate tweet.']
            ]
        ],

        'ai-content-humanizer' => [
            'slug' => 'ai-content-humanizer',
            'api_type' => 'humanize',
            'title' => 'AI Content Humanizer & AI Detection Remover',
            'h1' => 'Humanize AI Text & Bypass AI Detectors (100% Human Score)',
            'meta_title' => 'AI Content Humanizer - Bypass GPTZero, Turnitin & CopyLeaks | Postryx',
            'meta_description' => 'Turn robotic ChatGPT and AI writing into authentic, human-like copy. Bypass AI detectors like GPTZero, Turnitin, Originality AI, and CopyLeaks with 99.4% authenticity.',
            'meta_keywords' => 'AI content humanizer, bypass AI detection, bypass GPTZero, bypass Turnitin, undetectable AI writer, humanize ChatGPT text free, AI text to human converter, sentence burstiness perplexity rewriter, postryx.in',
            'badge' => 'Undetectable AI (99.4% Score)',
            'icon' => 'user-check',
            'color' => 'from-amber-500 to-orange-600',
            'placeholder' => 'Paste your AI-generated text here (from ChatGPT, Claude, Gemini, etc.)...',
            'default_prompt' => 'In today\'s fast-paced digital realm, leveraging AI is paramount. It is a testament to technological advancement that businesses can seamlessly delve into comprehensive solutions.',
            'category' => 'AI Utilities & SEO',
            'lsi_keywords' => [
                'Bypass Turnitin AI detection 2026',
                'GPTZero bypass tool free',
                'Originality ai bypass humanizer',
                'How to make AI text undetectable',
                'AI to human text converter 100% free',
                'Remove ChatGPT writing cliches'
            ],
            'features' => [
                'Strips robotic AI clichés (delve into, tapestry, testament, beacon)',
                'Injects dynamic sentence variance (high burstiness & perplexity)',
                '100% authentic human flow, conversational phrasing & active voice',
                'Proven bypass rate across Turnitin, GPTZero, Originality.ai & CopyLeaks',
                'Preserves core factual accuracy and citations seamlessly'
            ],
            'guide_steps' => [
                ['title' => 'Paste AI-Generated Text', 'desc' => 'Paste any draft generated by ChatGPT, Claude, Gemini, or any large language model.'],
                ['title' => 'Select Humanization Tone', 'desc' => 'Choose Conversational, Professional Authority, Academic Natural, or Storyteller mode.'],
                ['title' => 'Proprietary Syntax Restructuring', 'desc' => 'The engine eliminates repetitive syntactic patterns and optimizes sentence burstiness.'],
                ['title' => 'Get Human-Grade Copy Ready to Publish', 'desc' => 'Receive humanized copy that passes AI detector scans with natural readability.']
            ],
            'deep_dive' => [
                'title' => 'The Linguistic Science Behind Bypassing AI Detectors',
                'summary' => 'AI detectors do not understand meaning—they measure mathematical probability across two core metrics: Perplexity and Burstiness.',
                'sections' => [
                    [
                        'heading' => 'Perplexity vs Burstiness Explained',
                        'content' => 'Perplexity measures the unpredictability of word choices. Standard LLMs consistently pick the most mathematically probable next word. Burstiness measures the variance in sentence length and structure. Humans naturally mix short punchy sentences with longer, compound thoughts. Postryx AI algorithmically elevates both metrics to mirror organic human writing.'
                    ],
                    [
                        'heading' => 'Eliminating Watermark AI Clichés',
                        'content' => 'Detectors flag content loaded with overused LLM clichés like "in today\'s fast-paced world", "it is paramount that", "delve into", and "a testament to". Postryx automatically detects and replaces these markers with authentic, colloquial idioms.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'How does the AI Humanizer bypass GPTZero and Turnitin?', 'a' => 'By restructuring uniform sentence lengths, eliminating recognizable AI transition words, and introducing natural vocabulary variance (perplexity and burstiness) that mirror authentic human cognition.'],
                ['q' => 'Does humanizing text change its meaning or factual accuracy?', 'a' => 'No. Postryx preserves your core arguments, data points, and facts while rewriting the syntactic rhythm and stylistic delivery.'],
                ['q' => 'Is this humanizer tool free?', 'a' => 'Yes! You can humanize up to 5 texts daily for free without needing an account.']
            ]
        ],

        'ai-seo-blog-writer' => [
            'slug' => 'ai-seo-blog-writer',
            'api_type' => 'seo_blog',
            'title' => 'Programmatic Long-Form SEO Article Writer',
            'h1' => 'Write 2,000+ Word SEO Articles That Rank #1 on Google',
            'meta_title' => 'AI SEO Blog Writer - Long-Form Articles & Schema Generator | Postryx',
            'meta_description' => 'Write in-depth, humanized SEO blog posts with H1/H2/H3 headers, keyword optimization, FAQ schema, and meta tags that rank on Google and AI search engines.',
            'meta_keywords' => 'AI SEO blog writer, programmatic SEO generator, long-form SEO article writer, rank #1 on Google AI SEO, automated SEO content hubs, AI article writer with FAQ schema, postryx.in',
            'badge' => 'Rank #1 on Google',
            'icon' => 'file-text',
            'color' => 'from-emerald-500 to-teal-700',
            'placeholder' => 'e.g. The definitive guide to programmatic SEO and automated content hubs in 2026',
            'default_prompt' => 'How to build and scale an automated AI content business in 2026',
            'category' => 'SEO & Writing',
            'lsi_keywords' => [
                'Programmatic SEO tool generator',
                'Write 2000 word article with AI free',
                'Helpful Content Update SEO writer',
                'AI article generator with H2 H3 hierarchy',
                'SEO content optimization for Google AI Overviews'
            ],
            'features' => [
                'Complete Semantic H1, H2, H3 Outline Architecture',
                'Key Takeaways Summary Box & Comparison Tables',
                'Built-in FAQ Section with Google FAQPage Schema Markup',
                'Pre-optimized Meta Title & Meta Description included',
                'E-E-A-T friendly case study and actionable data prompts'
            ],
            'guide_steps' => [
                ['title' => 'Enter Target Keyword & Search Intent', 'desc' => 'Provide your primary search query, target audience, and primary angle.'],
                ['title' => 'AI Generates Semantic Hierarchy', 'desc' => 'The engine drafts H2/H3 sections, comparison tables, and key takeaways.'],
                ['title' => 'Review Meta Data & FAQ Schema', 'desc' => 'Receive ready-to-use JSON-LD schema markup, meta titles, and descriptions.'],
                ['title' => 'Publish to CMS', 'desc' => 'Export formatted HTML or Markdown directly to WordPress, Webflow, Ghost, or Laravel.']
            ],
            'deep_dive' => [
                'title' => 'Ranking Long-Form Content in the Era of Google AI Overviews & GEO',
                'summary' => 'Generative Engine Optimization (GEO) requires content to satisfy search intent deeply, provide structured tables, and incorporate direct Q&A blocks.',
                'sections' => [
                    [
                        'heading' => 'The Power of Semantic H2 and H3 Clusters',
                        'content' => 'Search engines evaluate topic completeness by checking whether your article covers essential subtopics (LSI keywords). Postryx generates exhaustive outlines that leave zero gaps in search intent.'
                    ],
                    [
                        'heading' => 'JSON-LD FAQ Schema for Instant Rich Snippets',
                        'content' => 'Articles featuring structured FAQPage schema have a 40% higher probability of winning Google SERP rich snippets and being cited by AI search engines like Perplexity and ChatGPT.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'Does Google penalize AI-generated blog posts?', 'a' => 'No. Google’s official Helpful Content guidelines reward helpful, high-quality, intent-satisfying content regardless of how it was created. Postryx articles focus on depth, data, and structured formatting.'],
                ['q' => 'Does this generate HTML and Markdown?', 'a' => 'Yes, you can copy pure formatted Markdown or clean semantic HTML ready for any CMS.']
            ]
        ],

        'viral-headline-analyzer' => [
            'slug' => 'viral-headline-analyzer',
            'api_type' => 'analyze_hook',
            'title' => 'Viral Headline & Hook Score Analyzer (CTR Predictor)',
            'h1' => 'Analyze & Score Your Viral Hooks for Maximum Click-Throughs',
            'meta_title' => 'Viral Headline Analyzer & Hook Scorecard - Predict CTR | Postryx',
            'meta_description' => 'Free AI Headline Analyzer. Get real-time viral scores (0-100), emotional trigger counts, curiosity gap ratings, and instant AI-boosted variations.',
            'meta_keywords' => 'viral headline analyzer, hook scorecard, CTR predictor, emotional headline tester, AI title generator, curiosity gap score, YouTube title tester, postryx.in',
            'badge' => 'Hook Scorecard (CTR Predictor)',
            'icon' => 'zap',
            'color' => 'from-violet-600 to-fuchsia-600',
            'placeholder' => 'e.g. 5 deadly mistakes every first-time founder makes in year one',
            'default_prompt' => 'How I grew to 50k followers in 90 days without spending a dollar on ads',
            'category' => 'Analytics & CRO',
            'lsi_keywords' => [
                'Emotional headline analyzer free',
                'Social media hook strength test',
                'YouTube video title CTR score',
                'Curiosity gap headline generator',
                'Power words headline optimizer'
            ],
            'features' => [
                'Overall Viral Potential Score (0-100 Grade)',
                'Emotional Power Word & Curiosity Gap analysis',
                'Character Length & Scannability Assessment',
                '3 AI-Generated High-Performing Hook Alternatives'
            ],
            'guide_steps' => [
                ['title' => 'Type Your Headline or Hook', 'desc' => 'Enter any blog title, subject line, or video hook.'],
                ['title' => 'Instant Algorithmic Scorecard', 'desc' => 'See your emotional index, curiosity gap rating, and grade.'],
                ['title' => 'Pick an AI-Boosted Variation', 'desc' => 'Choose from 3 algorithmic high-converting alternatives.']
            ],
            'deep_dive' => [
                'title' => 'The Psychology of Click-Through Rate (CTR) Optimization',
                'summary' => 'Headlines that trigger emotional contrast, specificity, or urgency generate up to 300% more click-throughs across social and search feeds.',
                'sections' => [
                    [
                        'heading' => 'The 4 Power Word Categories',
                        'content' => 'High CTR headlines blend Intellectual (e.g., framework, blueprint), Emotional (e.g., deadly, painful), Sensory (e.g., explosive, ruthless), and Urgency (e.g., in 2026, instantly) triggers.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'What is a good viral headline score?', 'a' => 'A score of 75+ indicates strong emotional appeal and clarity. Scores above 85 possess high viral potential across social and email channels.']
            ]
        ],

        'instagram-caption-generator' => [
            'slug' => 'instagram-caption-generator',
            'api_type' => 'instagram',
            'title' => 'AI Instagram Captions & Reels Script Generator',
            'h1' => 'Generate High-Conversion Instagram Captions & Reels Scripts',
            'meta_title' => 'AI Instagram Caption Generator - Viral Hooks & Hashtags | Postryx',
            'meta_description' => 'Free AI Instagram Caption Generator. Create engaging carousel copy, Reels hooks, call-to-actions, and trending hashtags that drive saves and shares.',
            'meta_keywords' => 'Instagram caption generator AI, Instagram reels script generator, viral instagram captions, Instagram hashtag finder, Instagram carousel copy generator, postryx.in',
            'badge' => 'Instagram Growth',
            'icon' => 'instagram',
            'color' => 'from-pink-500 via-purple-500 to-rose-500',
            'placeholder' => 'e.g. 3 mindset shifts that will help you overcome creator burnout',
            'default_prompt' => 'How to build an aesthetic daily routine that boosts focus and creativity',
            'category' => 'Social Media Growth',
            'lsi_keywords' => [
                'Best captions for Instagram reels',
                'Instagram carousel slide copy generator',
                'Viral hooks for Instagram',
                'Instagram caption hashtags tier list'
            ],
            'features' => [
                'First-line attention grabbers before the "...more" truncate point',
                'Save & Share conversion triggers to boost algorithmic reach',
                'Categorized viral & niche hashtag clusters',
                'Carousel slide-by-slide copy outlines'
            ],
            'guide_steps' => [
                ['title' => 'Describe Your Photo or Video', 'desc' => 'State your post concept, reel topic, or carousel slides.'],
                ['title' => 'Generate Engaging Caption', 'desc' => 'Get a structured caption with emojis, spacing, and call to action.'],
                ['title' => 'Copy & Publish', 'desc' => 'Paste directly into Instagram along with hashtag clusters.']
            ],
            'deep_dive' => [
                'title' => 'Mastering Instagram Save & Share Algorithm Triggers',
                'summary' => 'In modern Instagram algorithms, Saves and Shares carry 5x more weight than simple double-tap likes.',
                'sections' => [
                    [
                        'heading' => 'Triggering the "...more" Expand Click',
                        'content' => 'Captions truncate at 125 characters on the Instagram feed. A punchy, incomplete thought forces the user to expand the caption, registering positive dwell time.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'How does this help my Instagram reach?', 'a' => 'By optimizing for first-line dwell clicks and providing explicit save/share reminders that trigger algorithmic recommendations.']
            ]
        ],

        'youtube-title-and-script-generator' => [
            'slug' => 'youtube-title-and-script-generator',
            'api_type' => 'youtube',
            'title' => 'YouTube Shorts & Video Script Writer',
            'h1' => 'Generate High CTR YouTube Titles, Descriptions & Scripts',
            'meta_title' => 'AI YouTube Title & Script Generator - 10x Your Views | Postryx',
            'meta_description' => 'Create click-worthy YouTube video titles, high-retention video scripts, timestamps, and SEO descriptions to rank in YouTube search and Google video results.',
            'meta_keywords' => 'YouTube title generator AI, YouTube script writer, YouTube description generator, YouTube timestamps SEO, YouTube Shorts script writer, postryx.in',
            'badge' => 'YouTube Studio',
            'icon' => 'youtube',
            'color' => 'from-red-600 to-rose-700',
            'placeholder' => 'e.g. Complete tutorial on building automated affiliate websites in 2026',
            'default_prompt' => 'How to use AI to generate passive income from home (step by step)',
            'category' => 'Video & Audio',
            'lsi_keywords' => [
                'High CTR YouTube titles with power brackets',
                'Full video script with timestamps for YouTube SEO',
                'YouTube Shorts script writer with visual cues'
            ],
            'features' => [
                '5 High-CTR Title Options with Power Brackets [Step-by-Step]',
                'Full Timestamps & Chapter Breakdown for Google Video SERP',
                'SEO-Optimized 300-word Video Description',
                'YouTube Search Tag Cloud'
            ],
            'guide_steps' => [
                ['title' => 'Enter Video Concept', 'desc' => 'Describe what your video, short, or tutorial covers.'],
                ['title' => 'AI Generates Title & Script', 'desc' => 'Get click-tested titles, description with timestamps, and full narration outline.'],
                ['title' => 'Upload & Rank', 'desc' => 'Paste directly into YouTube Studio metadata fields.']
            ],
            'deep_dive' => [
                'title' => 'YouTube SEO & Google Video Snippet Optimization',
                'summary' => 'Timestamped YouTube descriptions allow Google to show Key Moments directly on the main search results page.',
                'sections' => [
                    [
                        'heading' => 'The Value of Chapter Timestamps in Google Search',
                        'content' => 'Structured timestamps (00:00 Intro, 01:45 Framework...) allow Google search engine bots to index discrete video segments for long-tail search queries.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'How does this optimize for Google Video search?', 'a' => 'By creating structured descriptions with natural keyword density, chapter markers, and tags matching high search volume queries.']
            ]
        ],

        'tiktok-reels-script-generator' => [
            'slug' => 'tiktok-reels-script-generator',
            'api_type' => 'tiktok_reels',
            'title' => 'Viral TikTok & Reels 60s Script Engine',
            'h1' => 'Generate 60-Second Viral Short-Form Video Scripts',
            'meta_title' => 'TikTok & Reels Script Generator - Viral 60s Video Scripts | Postryx',
            'meta_description' => 'Generate viral 60-second video scripts for TikTok, Instagram Reels, and YouTube Shorts. Includes 3s hooks, visual cues, and retention loops.',
            'meta_keywords' => 'TikTok script generator, Reels video script writer, viral short form video script, TikTok hooks 3 seconds, pattern interrupt scripts, postryx.in',
            'badge' => 'Viral Video Scripts',
            'icon' => 'video',
            'color' => 'from-cyan-500 to-blue-600',
            'placeholder' => 'e.g. 3 hidden iPhone hacks that feel illegal to know',
            'default_prompt' => 'Why 99% of people are broke in their 20s and the 1 rule to flip it',
            'category' => 'Video & Audio',
            'lsi_keywords' => [
                'TikTok video script with b-roll directions',
                '60 second video script template',
                'Viral TikTok hooks with visual cues'
            ],
            'features' => [
                '0-3s Visual Pattern Interrupt Hooks',
                'Scene-by-scene Narration and B-Roll directions',
                'On-screen Text Cue markers',
                'High-converting Follow & Comment Retention Loop'
            ],
            'guide_steps' => [
                ['title' => 'Input Video Angle', 'desc' => 'Enter the hack, story, or lesson you want to present.'],
                ['title' => 'AI Builds 60s Script', 'desc' => 'Get camera directions, talking points, and on-screen overlays.'],
                ['title' => 'Record in 5 Minutes', 'desc' => 'Shoot directly following the visual cues.']
            ],
            'deep_dive' => [
                'title' => 'How to Master 3-Second Retention on TikTok and Reels',
                'summary' => 'Short-form algorithms test your video on an initial batch of 300 viewers. Average watch percentage over 80% unlocks wider virality.',
                'sections' => [
                    [
                        'heading' => 'The Visual Pattern Interrupt',
                        'content' => 'Combine an audio curiosity trigger with a visual movement (zoom in, prop reveal) in the first 2 seconds to freeze casual scrolling.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'What makes a TikTok script viral?', 'a' => 'A rapid visual hook, zero fluff, on-screen text anchors for silent viewing, and an open retention loop that makes viewers watch till the end.']
            ]
        ],

        'content-repurposer' => [
            'slug' => 'content-repurposer',
            'api_type' => 'repurpose',
            'title' => '1-Click Multi-Platform Content Repurposing Engine',
            'h1' => 'Turn 1 Idea into 5 Viral Posts Across Every Social Platform',
            'meta_title' => 'AI Content Repurposer - 1 Idea to 5 Social Posts | Postryx',
            'meta_description' => 'Repurpose any blog post, video idea, or insight into a LinkedIn post, Twitter thread, Instagram caption, newsletter, and Reel script simultaneously.',
            'meta_keywords' => 'AI content repurposer, content repurposing tool, turn 1 idea into 10 posts, cross platform social media repurposer, repurpose blog to linkedin carousel, postryx.in',
            'badge' => 'Omni-Channel Engine',
            'icon' => 'layers',
            'color' => 'from-purple-600 to-indigo-700',
            'placeholder' => 'e.g. The 80/20 rule of building organic search traffic using programmatic content hubs',
            'default_prompt' => 'How small teams can produce 50x more content without hiring an agency using AI workflows',
            'category' => 'Omni-Channel Distribution',
            'lsi_keywords' => [
                'Turn blog post into social media content',
                'Repurpose YouTube video to LinkedIn thread',
                'Multi-channel content automation SaaS'
            ],
            'features' => [
                '1-Click 5-Platform Generation (LinkedIn, Twitter/X, IG, Email, Reels)',
                'Tailored formatting and tone for each individual network',
                'Unified workspace with tabbed multi-post viewer',
                'Batch export to Markdown, Text, and Social Cards'
            ],
            'guide_steps' => [
                ['title' => 'Enter 1 Core Idea or URL', 'desc' => 'Paste a rough note, article link, or core insight.'],
                ['title' => 'Click Repurpose', 'desc' => 'The engine generates 5 unique platform-specific versions.'],
                ['title' => 'Distribute Everywhere', 'desc' => 'Publish across your entire social ecosystem in minutes.']
            ],
            'deep_dive' => [
                'title' => 'The 1-to-10 Content Repurposing Flywheel',
                'summary' => 'Top creators do not create 10 new ideas a day—they create 1 exceptional idea and format it for 10 distinct distribution channels.',
                'sections' => [
                    [
                        'heading' => 'Format Translation Without Quality Loss',
                        'content' => 'A tweet thread requires brevity; a LinkedIn post needs personal framing; a Reel script demands visual cues. Postryx adapts the voice for each platform automatically.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'Why is content repurposing better than creating from scratch?', 'a' => 'Repurposing maximizes the ROI of every strong insight, ensuring audience members across LinkedIn, Twitter, Instagram, and Email all experience your best work.']
            ]
        ],

        'ai-ad-copy-generator' => [
            'slug' => 'ai-ad-copy-generator',
            'api_type' => 'ad_copy',
            'title' => 'High-Converting Ad Copy Generator for Meta & Google',
            'h1' => 'Generate High-ROI Ad Copy for Facebook, Instagram & Google',
            'meta_title' => 'AI Ad Copy Generator - Create High-Converting Ads | Postryx',
            'meta_description' => 'Generate high-converting ad copy for Meta Ads, Google Ads, TikTok Ads, and Twitter. Boost ROAS and lower customer acquisition costs with AI.',
            'meta_keywords' => 'AI ad copy generator, Facebook ad copy generator, Google PPC ad copy AI, Meta ads headline generator, high converting ad copy tool, postryx.in',
            'badge' => 'High-ROI Ads',
            'icon' => 'target',
            'color' => 'from-rose-500 to-red-600',
            'placeholder' => 'e.g. Postryx AI - All-in-one viral content generator for creators and agencies',
            'default_prompt' => 'SaaS tool that automates social media content and SEO blog writing for marketing agencies',
            'category' => 'Marketing & Paid Ads',
            'lsi_keywords' => [
                'Meta Facebook primary text generator',
                'Google Ads responsive search ads generator',
                'High ROAS ad copywriting framework'
            ],
            'features' => [
                'Meta / Facebook Primary Text & 3 Headline Variations',
                'Google Search PPC Responsive Ad Assets',
                'TikTok Short-form Video Ad Script',
                'High-converting Call to Action options'
            ],
            'guide_steps' => [
                ['title' => 'Describe Product & Offer', 'desc' => 'Enter your value proposition, target audience, and offer.'],
                ['title' => 'Generate Multi-Platform Ads', 'desc' => 'Get tailored copy for Meta Ads Manager and Google Ads.'],
                ['title' => 'Launch & Scale', 'desc' => 'A/B test variations to identify winning creatives.']
            ],
            'deep_dive' => [
                'title' => 'The Direct-Response Ad Copywriting Blueprint',
                'summary' => 'Great ad copy addresses pain points in line 1, provides concrete social proof in line 2, and presents a risk-reversal offer in line 3.',
                'sections' => [
                    [
                        'heading' => 'Hooks vs Angles in Paid Acquisition',
                        'content' => 'Testing 5 ad copy angles against the same creative often yields a 2x difference in Customer Acquisition Cost (CAC).'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'Can I use this for both B2B and B2C ads?', 'a' => 'Yes, you can adjust tone and audience targeting to suit SaaS, e-commerce, coaching, agency, or local services.']
            ]
        ],

        'cold-email-generator' => [
            'slug' => 'cold-email-generator',
            'api_type' => 'cold_email',
            'title' => 'B2B Cold Outreach & Sales Pitch Generator',
            'h1' => 'Write High-Response B2B Cold Email Sequences with AI',
            'meta_title' => 'AI Cold Email Generator - High Response B2B Sequences | Postryx',
            'meta_description' => 'Generate high-converting 3-step B2B cold email sequences, personalized icebreakers, and sales follow-ups that get replies and book meetings.',
            'meta_keywords' => 'AI cold email generator, B2B sales sequence writer, cold outreach email generator, high open rate subject line generator, cold email icebreakers, postryx.in',
            'badge' => 'B2B Lead Gen',
            'icon' => 'mail',
            'color' => 'from-indigo-500 to-purple-600',
            'placeholder' => 'e.g. Offering SEO content automation services to B2B SaaS companies',
            'default_prompt' => 'Offering automated viral social media management to busy tech founders and CEOs',
            'category' => 'Marketing & Sales',
            'lsi_keywords' => [
                'Cold email sequence 3 steps',
                'B2B cold outreach templates AI',
                'Instantly Smartlead merge tag cold email'
            ],
            'features' => [
                '3-Step Sequence (Curiosity Hook, Case Study Proof, Breakup Email)',
                'High-Open-Rate Subject Line options',
                'Low-Friction Call-to-Actions (No hard sell)',
                'Merge tags ready for Instantly, Smartlead & Lemlist'
            ],
            'guide_steps' => [
                ['title' => 'Define Your Offer & Prospect', 'desc' => 'State what problem you solve and for whom.'],
                ['title' => 'AI Builds 3-Part Sequence', 'desc' => 'Get a magnetic opener, value follow-up, and graceful breakup email.'],
                ['title' => 'Send & Book Calls', 'desc' => 'Upload into your cold email sending software.']
            ],
            'deep_dive' => [
                'title' => 'Why Short, Low-Friction Cold Emails Get 4x More Replies',
                'summary' => 'Cold emails exceeding 100 words have a steep drop-off in response rates. Focus on one specific pain point and ask an interest-based question.',
                'sections' => [
                    [
                        'heading' => 'The Low-Friction CTA',
                        'content' => 'Instead of asking for a 30-minute meeting immediately, ask "Worth sending over a 2-minute video walkthrough?" to lower psychological friction.'
                    ]
                ]
            ],
            'faqs' => [
                ['q' => 'Why does this sequence get higher response rates?', 'a' => 'It avoids generic sales pitches, keeps word counts under 80 words per email, and asks a low-friction question rather than demanding a call.']
            ]
        ],

        'hashtag-generator' => [
            'slug' => 'hashtag-generator',
            'api_type' => 'hashtag',
            'title' => 'Viral Trending Hashtag & Keyword Density Finder',
            'h1' => 'Find High-Reach Trending Hashtags & Social Keywords',
            'meta_title' => 'AI Hashtag Generator - High-Reach & Niche Hashtags | Postryx',
            'meta_description' => 'Generate 30+ categorized high-volume and niche hashtags for Instagram, TikTok, LinkedIn, and YouTube to maximize organic discovery.',
            'meta_keywords' => 'AI hashtag generator, viral hashtag finder, Instagram hashtag clusters, TikTok trending hashtags, social media keyword density, postryx.in',
            'badge' => 'Organic Reach',
            'icon' => 'hash',
            'color' => 'from-emerald-500 to-cyan-600',
            'placeholder' => 'e.g. AI productivity tools and solopreneur lifestyle',
            'default_prompt' => 'Digital marketing strategies, AI content creation, and SEO ranking',
            'category' => 'Social Media Growth',
            'lsi_keywords' => [
                'Niche hashtag generator for Instagram',
                'Trending TikTok tags finder',
                'B2B LinkedIn hashtags'
            ],
            'features' => [
                '3-Tier Categorization (High Volume, Mid Tier, Niche)',
                'Spam filter & banned hashtag protection',
                '1-Click Copy all or selected hashtags',
                'Works for Instagram, TikTok, LinkedIn, and YouTube'
            ],
            'guide_steps' => [
                ['title' => 'Enter Niche or Keywords', 'desc' => 'Provide 2-3 words describing your post topic.'],
                ['title' => 'AI Generates Hashtag Sets', 'desc' => 'Get 30 balanced hashtags divided by reach tiers.'],
                ['title' => 'Copy & Paste', 'desc' => 'Add to your caption or first comment.']
            ],
            'deep_dive' => [
                'title' => 'The 3-Tier Hashtag Clustering Strategy',
                'summary' => 'Using only massive hashtags (1M+ posts) buries your content immediately. A balanced ratio gives you the highest organic reach.',
                'sections' => [
                    [
                        'heading' => 'The Ideal Reach Ratio',
                        'content' => 'Combine 5 High-Volume (Broad Discovery), 10 Mid-Volume (Competitive Ranking), and 15 Low-Competition Niche hashtags to sustain rank on explore pages.'
                    ]
                ]
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
        try {
            $posts = \App\Models\Blog::active()->latest()->paginate(9);
        } catch (\Throwable $e) {
            $posts = collect([]);
        }

        return view('blog.index', [
            'posts' => $posts,
            'staticPosts' => $this->blogPosts,
            'tools' => $this->tools
        ]);
    }

    /**
     * Blog Show Page (Only Active Blogs).
     */
    public function blogShow(string $slug)
    {
        $post = null;
        try {
            $post = \App\Models\Blog::where('slug', $slug)->active()->first();
            if ($post) {
                $post->increment('views_count');
            }
        } catch (\Throwable $e) {
            $post = null;
        }

        if (!$post && isset($this->blogPosts[$slug])) {
            $raw = $this->blogPosts[$slug];
            $post = new \App\Models\Blog([
                'title' => $raw['title'],
                'slug' => $raw['slug'],
                'excerpt' => $raw['excerpt'],
                'content' => $raw['content'] ?? ('<p>' . $raw['excerpt'] . '</p>'),
                'category' => $raw['category'],
                'author_name' => $raw['author'] ?? 'Postryx AI Growth Team',
                'read_time' => $raw['read_time'] ?? '7 min read',
                'meta_title' => $raw['title'] . ' | Postryx AI',
                'meta_description' => $raw['meta_description'],
                'is_active' => true,
                'views_count' => 1840,
                'featured_image' => 'images/postryx-hero-banner.png',
                'tags' => [$raw['category'], 'Viral Social', 'AI Growth']
            ]);
            $post->created_at = now();
            $post->updated_at = now();
        }

        if (!$post) {
            abort(404);
        }

        try {
            $recentPosts = \App\Models\Blog::active()
                ->where('slug', '!=', $slug)
                ->latest()
                ->take(3)
                ->get();
        } catch (\Throwable $e) {
            $recentPosts = collect([]);
        }

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
            ['loc' => $baseUrl . '/affiliate', 'priority' => '0.8', 'changefreq' => 'weekly', 'image' => $baseUrl . '/images/postryx-og-banner.png', 'title' => 'Postryx AI Affiliate Partner Program'],
            ['loc' => $baseUrl . '/blog', 'priority' => '0.8', 'changefreq' => 'daily', 'image' => $baseUrl . '/images/postryx-og-banner.png', 'title' => 'Postryx AI Viral Growth & SEO Resource Hub'],
            ['loc' => $baseUrl . '/terms', 'priority' => '0.3', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/privacy', 'priority' => '0.3', 'changefreq' => 'monthly'],
        ];

        // Add 12 Programmatic Tools
        foreach ($this->tools as $t) {
            $urls[] = [
                'loc' => $baseUrl . '/tools/' . $t['slug'],
                'priority' => '0.95',
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
                    'priority' => '0.85',
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
        $content .= "User-agent: DuckDuckBot\nAllow: /\n";
        $content .= "User-agent: YandexBot\nAllow: /\n\n";

        $content .= "# AI Search Engines & LLM Retrieval Crawlers (Allowed for Generative Engine Optimization)\n";
        $content .= "User-agent: GPTBot\nAllow: /\n";
        $content .= "User-agent: ChatGPT-User\nAllow: /\n";
        $content .= "User-agent: OAI-SearchBot\nAllow: /\n";
        $content .= "User-agent: ClaudeBot\nAllow: /\n";
        $content .= "User-agent: anthropic-ai\nAllow: /\n";
        $content .= "User-agent: PerplexityBot\nAllow: /\n";
        $content .= "User-agent: CCBot\nAllow: /\n";
        $content .= "User-agent: Google-Extended\nAllow: /\n\n";

        $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
