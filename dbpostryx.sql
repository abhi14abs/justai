/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 8.4.7 : Database - abhsin4722_postryx
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`abhsin4722_postryx` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `abhsin4722_postryx`;

/*Table structure for table `affiliate_payouts` */

DROP TABLE IF EXISTS `affiliate_payouts`;

CREATE TABLE `affiliate_payouts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upi',
  `payout_details` text COLLATE utf8mb4_unicode_ci,
  `transaction_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliate_payouts_affiliate_id_foreign` (`affiliate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `affiliate_payouts` */

/*Table structure for table `affiliates` */

DROP TABLE IF EXISTS `affiliates`;

CREATE TABLE `affiliates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `affiliate_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payout_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upi',
  `payout_details` text COLLATE utf8mb4_unicode_ci,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT '30.00',
  `total_clicks` int unsigned NOT NULL DEFAULT '0',
  `total_referrals` int unsigned NOT NULL DEFAULT '0',
  `total_earnings` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pending_payout` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paid_payout` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `affiliates_affiliate_code_unique` (`affiliate_code`),
  KEY `affiliates_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `affiliates` */

insert  into `affiliates`(`id`,`user_id`,`affiliate_code`,`payout_method`,`payout_details`,`commission_rate`,`total_clicks`,`total_referrals`,`total_earnings`,`pending_payout`,`paid_payout`,`created_at`,`updated_at`) values 
(1,2,'creator','upi','creator@okhdfcbank',30.00,342,14,14392.80,4310.00,10082.80,'2026-08-24 09:03:24','2026-08-24 09:03:24'),
(2,3,'abhishek-singh-kkfj','upi',NULL,30.00,0,0,0.00,0.00,0.00,'2026-08-24 09:22:31','2026-08-24 09:22:31');

/*Table structure for table `blogs` */

DROP TABLE IF EXISTS `blogs`;

CREATE TABLE `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Growth Strategy',
  `tags` json DEFAULT NULL,
  `author_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Postryx AI Team',
  `read_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '5 min read',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `blogs` */

insert  into `blogs`(`id`,`title`,`slug`,`excerpt`,`content`,`featured_image`,`category`,`tags`,`author_name`,`read_time`,`meta_title`,`meta_description`,`is_active`,`views_count`,`created_at`,`updated_at`) values 
(1,'The 2026 LinkedIn Algorithm Playbook: How to Write Posts That Reach 100k+ Impressions','linkedin-algorithm-playbook-2026','LinkedIn has shifted from corporate resumes to the #1 thought leadership platform in the world. Here is how to exploit the new dwell-time algorithm.','<h2>The Dwell-Time Revolution on LinkedIn</h2>\n<p>LinkedIn’s feed algorithm in 2026 is no longer prioritizing simple like-for-like engagement pods. Instead, the platform ranks content based on a metric called <strong>Qualified Dwell Time</strong>—the duration a user spends with your post expanded on screen reading through your copy.</p>\n\n<h3>1. The 3-Line \"See More\" Hook Formula</h3>\n<p>Your first 210 characters dictate 90% of your post performance. If you fail to trigger the <em>\"...see more\"</em> click, the algorithm flags your content as low-retention.</p>\n<ul>\n    <li><strong>The Contrarian Shift:</strong> \"Most advice about scaling SaaS is dead wrong. Here is what actually worked for our team:\"</li>\n    <li><strong>The Data Proof:</strong> \"We analyzed 4,800 viral LinkedIn posts over the last 90 days. 3 patterns emerged:\"</li>\n    <li><strong>The Vulnerability Opening:</strong> \"6 months ago, our organic reach plummeted to zero. Today, we average 250k monthly impressions.\"</li>\n</ul>\n\n<h3>2. The Clean Visual Rhythm (Skimmable Spacing)</h3>\n<p>Wall-of-text posts have a 78% higher bounce rate on mobile. Ensure every paragraph is limited to 1–2 sentences with clear bullet lists and directional arrows.</p>\n\n<h3>3. Postryx AI Carousel Automation</h3>\n<p>PDF Carousels generate 3.4x higher comment depth than standard text posts. Use Postryx AI to automatically convert long-form guides into 7-slide actionable carousels in one click.</p>','images/postryx-hero-banner.png','Viral Social','[\"LinkedIn\", \"Viral Hooks\", \"B2B Growth\", \"Algorithm\"]','Aarav Sharma','7 min read','The 2026 LinkedIn Algorithm Playbook — Reach 100k+ Impressions | Postryx','Discover the exact 7 hook formulas, formatting secrets, and algorithmic signals that drive viral LinkedIn impressions in 2026.',1,1420,'2026-08-24 11:07:01','2026-08-24 11:07:01'),
(2,'Programmatic SEO Mastery: How We Built 500+ Ranking Pages in 30 Days','programmatic-seo-guide-rank-1','Manual keyword targeting is slow. Learn how programmatic SEO allows you to dominate search engine results pages at massive scale.','<h2>Why Traditional Keyword Research Is Obsolete</h2>\n<p>If you are writing one 1,500-word blog post per week manually, you are competing at a 50x disadvantage against programmatic creators. Programmatic SEO (pSEO) is the art of building scalable page templates populated by structured datasets.</p>\n\n<h3>The 3 Pillars of a High-Ranking pSEO Architecture</h3>\n<ol>\n    <li><strong>Intent Satisfying Templates:</strong> Pages designed with unique schema metadata, rich FAQ sections, and dynamic calculators.</li>\n    <li><strong>Internal Link Velocity:</strong> Automatic cross-linking between related search clusters to maximize crawl efficiency.</li>\n    <li><strong>Humanized Content Quality:</strong> Incorporating real-world data and structured comparisons so your programmatic pages avoid Google’s unhelpful content filters.</li>\n</ol>','images/postryx-hero-banner.png','SEO Strategies','[\"SEO\", \"Programmatic SEO\", \"Google Rank\", \"Growth Engine\"]','Priya Mehta','10 min read','Programmatic SEO Mastery — 500+ Ranking Pages in 30 Days | Postryx','A step-by-step guide to programmatic SEO, database-driven landing pages, and capturing millions in organic search traffic.',1,2890,'2026-08-24 11:07:01','2026-08-24 11:07:01'),
(3,'How to Bypass AI Detectors: The Science Behind Undetectable Humanized Copy','bypass-ai-detectors-humanize-content','Why rigid AI text gets flagged by detectors, and how adjusting burstiness and perplexity produces authentic, human-grade writing.','<h2>Understanding Perplexity and Burstiness</h2>\n<p>AI detectors like GPTZero, Turnitin, and Originality.ai do not understand meaning—they measure mathematical probability across two metrics: <strong>Perplexity</strong> (vocabulary unpredictability) and <strong>Burstiness</strong> (sentence length variance).</p>\n\n<h3>Eliminating AI Watermark Clichés</h3>\n<p>Standard LLMs overuse recognizable filler phrases like <em>\"delve into\"</em>, <em>\"a testament to\"</em>, <em>\"paramount importance\"</em>, and <em>\"in conclusion\"</em>. Postryx AI strips out robotic clichés and rewrites sentences with natural human cadence, varied rhythm, and authentic conversational phrasing.</p>','images/postryx-hero-banner.png','AI Growth','[\"AI Humanizer\", \"GPTZero\", \"Turnitin\", \"Copywriting\"]','Vikram Patel','6 min read','How to Bypass AI Detectors — 99.4% Human Authenticity | Postryx','Learn how AI detectors like Turnitin and GPTZero work, and the exact linguistic methods to achieve 100% human authenticity scores.',1,3120,'2026-08-24 11:07:01','2026-08-24 11:07:01'),
(4,'The X / Twitter Growth Blueprint: Building a 50K Audience with AI Threads','x-twitter-growth-blueprint-2026','Twitter rewards velocity and retention. Master the 5-part thread architecture that turns casual scrollers into loyal followers.','<h2>The Anatomy of a Viral 7-Tweet Thread</h2>\n<p>On X/Twitter, the first tweet is your billboard. If tweet #1 does not stop the doomscroll within 1.5 seconds, the rest of your thread will never be read.</p>\n<p>Structure your threads with an emotional opener, 4 high-value insights, and a concluding bookmark-worthy takeaway with a clear call-to-action.</p>','images/postryx-hero-banner.png','Viral Social','[\"Twitter\", \"X Growth\", \"Viral Threads\", \"Social Media\"]','Rohan Sen','8 min read','The X / Twitter Growth Blueprint — Build a 50k Audience | Postryx','The definitive guide to viral X/Twitter growth. Learn how top creators leverage curiosity hooks, thread unrolling, and algorithmic momentum.',1,1980,'2026-08-24 11:07:01','2026-08-24 11:07:01'),
(5,'The Multi-Platform Repurposing Formula: Turn 1 Idea into 15 Viral Assets','multi-platform-repurposing-formula','How the world’s most prolific creators publish daily on 5 platforms simultaneously while only spending 2 hours a week on ideation.','<h2>The 1-to-10 Content Cascade</h2>\n<p>Never write for a single platform in isolation. When you discover a high-performing concept, run it through the Postryx Repurposing Engine to instantly distribute across LinkedIn, Twitter/X, Instagram Reels scripts, newsletters, and SEO blog posts.</p>','images/postryx-hero-banner.png','Case Studies','[\"Repurposing\", \"Content Scaling\", \"Omni-Channel\", \"Productivity\"]','Ananya Verma','5 min read','The Multi-Platform Repurposing Formula | Postryx AI','Stop burning out creating content from scratch. Discover the omni-channel distribution machine that multiplies your reach 10x.',1,2450,'2026-08-24 11:07:01','2026-08-24 11:07:01'),
(6,'Viral Hook Secrets of Top 1% Creators','viral-hook-secrets-of-top-1-creators','The 1% Hook RuleHooks determine 90% of your engagement on social media.','<h2>The 1% Hook Rule</h2><p>Hooks determine 90% of your engagement on social media.</p>','images/postryx-hero-banner.png','Viral Social','[\"Hooks\", \"LinkedIn\", \"Twitter\"]','Postryx Admin','1 min read','Viral Hook Secrets of Top 1% Creators','The 1% Hook RuleHooks determine 90% of your engagement on social media.',1,1,'2026-08-24 11:15:59','2026-08-24 11:17:46');

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `generations` */

DROP TABLE IF EXISTS `generations`;

CREATE TABLE `generations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tool` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `word_count` int unsigned NOT NULL DEFAULT '0',
  `char_count` int unsigned NOT NULL DEFAULT '0',
  `provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'heuristic',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `generations_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `generations` */

insert  into `generations`(`id`,`user_id`,`ip_address`,`tool`,`topic`,`tone`,`content`,`word_count`,`char_count`,`provider`,`created_at`,`updated_at`) values 
(1,NULL,'127.0.0.1','linkedin','My name is Abhishek Singh what to be a Developer Generate a Caption','engaging','99% of people are approaching My name is Abhishek Singh what to be a Developer Generate a Caption completely backward.\n\nHere is what the top 1% know (that most never realize):\n\n---\n\n✦ 1. Velocity Beats Perfection\nDon\'t wait until everything is flawless. The market rewards those who ship, iterate, and adapt in real time.\n\n✦ 2. Build High-Leverage Systems\nIf you are repeating the same manual task twice, you are leaving 80% of your growth on the table. Automate the baseline; master the edge.\n\n✦ 3. The 80/20 of Audience Retention\nPeople don\'t buy information; they buy clarity and speed. Strip away the fluff and deliver the core outcome upfront.\n\n✦ 4. Distribution > Creation\nThe best product with zero reach loses to an average product with relentless distribution. Master the hooks.\n\n✦ 5. Compound Consistency\n1% improvements daily don\'t feel like much on day 10. By day 100, you are in a completely different tier.\n\n---\n\n? The takeaway:\nStop overcomplicating My name is Abhishek Singh what to be a Developer Generate a Caption. Focus on execution, clear messaging, and relentless consistency.\n\nWhat is the biggest challenge holding you back in this area? Let me know below ?\n\n#Growth #Leadership #Productivity #AI #Entrepreneurship',185,1253,'postryx-engine-v2','2026-08-28 09:52:44','2026-08-28 09:52:44'),
(2,NULL,'127.0.0.1','instagram','php artisan config:clear','actionable','? Read this before you spend another dollar on php artisan config:clear...\n\nMost people make this 1 crucial mistake: They focus on vanity metrics instead of real conversion leverage.\n\nSwipe through for the full 4-part breakdown ➡️\n\n? Slide 1: Why conventional methods stop working in 2026.\n? Slide 2: The 3 leverage points you must master today.\n? Slide 3: Real case study: Turning attention into revenue.\n? Slide 4: The 5-minute daily checklist.\n\n? PRO TIP: Save this post right now so you can reference the framework when you build your next campaign.\n\n? Drop a \"GROWTH\" in the comments and I will DM you the free cheat sheet!\n\n.\n.\n#DigitalMarketing #GrowthHacks #CreatorEconomy #SocialMediaStrategy #BusinessMindset #ContentCreation #Automation #EntrepreneurLife #Postryx',106,799,'postryx-engine-v2','2026-08-28 09:53:18','2026-08-28 09:53:18');

/*Table structure for table `invitation_analytics` */

DROP TABLE IF EXISTS `invitation_analytics`;

CREATE TABLE `invitation_analytics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `event_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_id` bigint unsigned DEFAULT NULL,
  `ip_hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `device_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mobile',
  `referrer` text COLLATE utf8mb4_unicode_ci,
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `invitation_analytics_invitation_id_event_type_created_at_index` (`invitation_id`,`event_type`,`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_analytics` */

insert  into `invitation_analytics`(`id`,`invitation_id`,`event_type`,`guest_id`,`ip_hash`,`user_agent`,`device_type`,`referrer`,`country_code`,`city`,`meta`,`created_at`) values 
(1,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 07:31:25'),
(2,1,'page_view',1,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 07:31:26'),
(3,1,'rsvp_submit',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'{\"status\": \"attending\", \"party_size\": 2}','2026-09-04 07:31:26'),
(4,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 07:32:05'),
(5,1,'page_view',1,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 07:32:05'),
(6,1,'rsvp_submit',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'{\"status\": \"attending\", \"party_size\": 2}','2026-09-04 07:32:05'),
(7,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/preview/royal-rajwada-palace',NULL,NULL,'[]','2026-09-04 07:34:24'),
(8,2,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/2',NULL,NULL,'[]','2026-09-04 07:37:31'),
(9,2,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/dashboard/invitations',NULL,NULL,'[]','2026-09-04 07:40:08'),
(10,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 07:57:36'),
(11,1,'page_view',1,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 07:57:36'),
(12,1,'rsvp_submit',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'{\"status\": \"attending\", \"party_size\": 2}','2026-09-04 07:57:36'),
(13,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 08:00:17'),
(14,1,'page_view',1,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'[]','2026-09-04 08:00:17'),
(15,1,'rsvp_submit',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Symfony','desktop','',NULL,NULL,'{\"status\": \"attending\", \"party_size\": 2}','2026-09-04 08:00:17'),
(16,1,'page_view',NULL,'635ef0f5ac3a6871027aafd312cd13571b5a3d60f6031fa689e1f700f93bb130','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://172.16.1.225/justai/public/invitations/preview/obsidian-zenith-corporate-gala',NULL,NULL,'[]','2026-09-04 08:57:57'),
(17,1,'page_view',NULL,'635ef0f5ac3a6871027aafd312cd13571b5a3d60f6031fa689e1f700f93bb130','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://172.16.1.225/justai/public/invitations/preview/modern-minimalist-vows',NULL,NULL,'[]','2026-09-04 08:59:49'),
(18,1,'page_view',NULL,'635ef0f5ac3a6871027aafd312cd13571b5a3d60f6031fa689e1f700f93bb130','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://172.16.1.225/justai/public/invitations/preview/little-astronaut-first-birthday',NULL,NULL,'[]','2026-09-04 09:01:32'),
(19,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:18:48'),
(20,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:19:30'),
(21,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:20:17'),
(22,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:20:25'),
(23,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:20:43'),
(24,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:20:48'),
(25,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:20:53'),
(26,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:20:57'),
(27,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:21:07'),
(28,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:21:13'),
(29,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:21:20'),
(30,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob?no_curtain=1',NULL,NULL,'[]','2026-09-04 09:21:30'),
(31,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:27:01'),
(32,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:29:30'),
(33,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:29:44'),
(34,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:37:38'),
(35,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:39:05'),
(36,3,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/builder/3',NULL,NULL,'[]','2026-09-04 09:47:38'),
(37,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/preview/celestial-bal-ganesha-joy',NULL,NULL,'[]','2026-09-04 10:09:45'),
(38,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/preview/celestial-bal-ganesha-joy',NULL,NULL,'[]','2026-09-04 10:10:34'),
(39,1,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/preview/celestial-bal-ganesha-joy',NULL,NULL,'[]','2026-09-04 10:16:25'),
(40,16,'page_view',NULL,'aff417e6a9fee1fadba423ec8e109cefa6112486436c30229e58436da98b155f','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','desktop','http://127.0.0.1:8000/invitations/preview/celestial-bal-ganesha-joy',NULL,NULL,'[]','2026-09-04 10:52:25');

/*Table structure for table `invitation_assets` */

DROP TABLE IF EXISTS `invitation_assets`;

CREATE TABLE `invitation_assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `asset_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `file_size` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_assets_invitation_id_asset_type_sort_order_index` (`invitation_id`,`asset_type`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_assets` */

insert  into `invitation_assets`(`id`,`invitation_id`,`asset_type`,`file_path`,`thumbnail_path`,`caption`,`sort_order`,`file_size`,`created_at`,`updated_at`) values 
(1,1,'guest_memory','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',NULL,'What a magical Sangeet night! Congratulations to the couple!',0,102400,'2026-09-04 08:04:48','2026-09-04 08:04:48'),
(2,1,'guest_memory','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',NULL,'What a magical Sangeet night! Congratulations to the couple!',0,102400,'2026-09-04 09:16:30','2026-09-04 09:16:30'),
(3,1,'guest_memory','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',NULL,'What a magical Sangeet night! Congratulations to the couple!',0,102400,'2026-09-04 09:23:08','2026-09-04 09:23:08'),
(4,1,'guest_memory','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',NULL,'What a magical Sangeet night! Congratulations to the couple!',0,102400,'2026-09-04 09:26:48','2026-09-04 09:26:48'),
(5,1,'guest_memory','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',NULL,'What a magical Sangeet night! Congratulations to the couple!',0,102400,'2026-09-04 09:37:06','2026-09-04 09:37:06');

/*Table structure for table `invitation_categories` */

DROP TABLE IF EXISTS `invitation_categories`;

CREATE TABLE `invitation_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_categories_slug_unique` (`slug`),
  KEY `invitation_categories_is_active_sort_order_index` (`is_active`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_categories` */

insert  into `invitation_categories`(`id`,`name`,`slug`,`description`,`icon`,`banner_url`,`sort_order`,`is_active`,`meta_title`,`meta_description`,`created_at`,`updated_at`) values 
(1,'Royal & Indian Weddings','weddings','Opulent royal palaces, floral mandaps, gold foil calligraphy and animated multi-day wedding celebration invitations.','?','https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=1200&q=80',1,1,'Luxury Digital Wedding Invitations & Multi-Day E-Invites','Create stunning mobile-first wedding invitations with RSVP, guest QR codes, Google Maps, countdown, and music.','2026-09-04 07:18:08','2026-09-04 07:18:08'),
(2,'Birthday Celebrations','birthdays','Fun, animated, vibrant birthday party invites for 1st birthdays, milestone 18th/21st/50th, kids themes and neon DJ nights.','?','https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?auto=format&fit=crop&w=1200&q=80',2,1,'Digital Birthday Party Invitations & Animated E-Cards','Interactive animated birthday invitations with RSVP, gift registry, music, and location maps.','2026-09-04 07:18:08','2026-09-04 07:18:08'),
(3,'Engagements & Ring Ceremonies','engagements','Romantic save-the-date invites, ring ceremony announcements, and cocktail party invitations.','?','https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=1200&q=80',3,1,'Digital Engagement Invitations & Save The Date','Celebrate your proposal and ring ceremony with interactive couple timelines and RSVP tracking.','2026-09-04 07:18:08','2026-09-04 07:18:08'),
(4,'Baby Shower & Gender Reveal','baby-showers','Adorable pastel clouds, teddy bears, golden stars and interactive wish-book baby shower invites.','?','https://images.unsplash.com/photo-1519689680058-324335c77eba?auto=format&fit=crop&w=1200&q=80',4,1,'Digital Baby Shower Invitations & Gender Reveal Cards','Cute and interactive baby shower digital invites with guest book wishes and RSVP.','2026-09-04 07:18:08','2026-09-04 07:18:08'),
(5,'Anniversaries & Jubilees','anniversaries','Silver 25th, Golden 50th and milestone love celebrations with nostalgic photo timelines.','?','https://images.unsplash.com/photo-1532712938310-34cb3982ef74?auto=format&fit=crop&w=1200&q=80',5,1,'Digital Anniversary Invitations & Milestone Celebrations','Honor decades of love with custom music, photo albums, and digital RSVP cards.','2026-09-04 07:18:08','2026-09-04 07:18:08'),
(6,'Corporate & Gala Events','corporate','Executive summits, product launches, charity galas, and annual award nights with QR pass check-in.','?️','https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',6,1,'Corporate Digital Event Invitations & VIP QR Passes','Professional conference and gala invitations with attendee registration, schedule, and QR ticketing.','2026-09-04 07:18:08','2026-09-04 07:18:08'),
(7,'Festivals, Puja & Ganesh Chaturthi','festivals-puja','Auspicious Ganeshotsav, Diwali Pooja, Navratri and Satyanarayan spiritual invitations with aarti schedules, prasad RSVP, and live darshan.','?️','/images/invitations/ganesh/saffron_lalbaug.jpg',1,1,'Ganesh Chaturthi Digital Invitations & Puja E-Cards','Create vibrant Ganesh Chaturthi invitations with aarti timings, prasad RSVP, bhajan music, and Google Maps.','2026-09-04 09:58:53','2026-09-04 09:58:53');

/*Table structure for table `invitation_coupons` */

DROP TABLE IF EXISTS `invitation_coupons`;

CREATE TABLE `invitation_coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `usage_limit` int unsigned DEFAULT NULL,
  `used_count` int unsigned NOT NULL DEFAULT '0',
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_coupons_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_coupons` */

insert  into `invitation_coupons`(`id`,`code`,`discount_type`,`discount_value`,`min_order_amount`,`currency`,`usage_limit`,`used_count`,`expires_at`,`is_active`,`created_at`,`updated_at`) values 
(1,'CELEBRATE50','percentage',50.00,0.00,'INR',NULL,0,NULL,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(2,'WEDDING20','percentage',20.00,500.00,'INR',NULL,0,NULL,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(3,'LAUNCH50','percentage',50.00,0.00,'INR',NULL,0,NULL,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(4,'ROYALPASS','fixed',300.00,999.00,'INR',NULL,0,NULL,1,'2026-09-04 07:18:08','2026-09-04 07:18:08');

/*Table structure for table `invitation_events` */

DROP TABLE IF EXISTS `invitation_events`;

CREATE TABLE `invitation_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `venue_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venue_address` text COLLATE utf8mb4_unicode_ci,
  `map_embed_url` text COLLATE utf8mb4_unicode_ci,
  `map_latitude` decimal(10,8) DEFAULT NULL,
  `map_longitude` decimal(11,8) DEFAULT NULL,
  `dress_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_events_invitation_id_sort_order_index` (`invitation_id`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_events` */

insert  into `invitation_events`(`id`,`invitation_id`,`title`,`event_date`,`start_time`,`end_time`,`venue_name`,`venue_address`,`map_embed_url`,`map_latitude`,`map_longitude`,`dress_code`,`icon`,`sort_order`,`created_at`,`updated_at`) values 
(25,1,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(24,1,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(23,1,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(4,2,'Grand Celebration & Ceremony','2026-11-04','18:00:00','23:00:00','The Grand Ballroom & Lawn','Palace Road, City Center',NULL,NULL,NULL,'Traditional / Festive Elegance','✨',1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(6,3,'Mehendi & Sangeet Soirée','2026-11-03','16:30:00',NULL,'The Grand Ballroom & Poolside, Mumbai',NULL,NULL,NULL,NULL,'Pastel Lehengas & Festive Kurtas','?',1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(8,3,'Varmala, Pheras & Royal Reception','2026-11-04','18:30:00',NULL,'Royal Heritage Palace, Mumbai',NULL,NULL,NULL,NULL,'Royal Traditional Formals','?',3,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(10,4,'Grand Sangeet & Musical Night','2026-12-17','19:30:00',NULL,'The Oberoi Udaivilas, Lake Pichola',NULL,NULL,NULL,NULL,'Sparkling Festive & Indo-Western','?',1,'2026-09-04 09:22:53','2026-09-04 09:36:59'),
(11,4,'Haldi & Phoolon Ki Holi','2026-12-15','10:00:00',NULL,'Garden Courtyard, Mumbai',NULL,NULL,NULL,NULL,'Sunshine Yellow & Ivory','?',2,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(12,4,'Varmala, Pheras & Royal Reception','2026-12-15','18:30:00',NULL,'Royal Heritage Palace, Mumbai',NULL,NULL,NULL,NULL,'Royal Traditional Formals','?',3,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(13,3,'wedfc','2026-09-11',NULL,NULL,'fgb',NULL,NULL,NULL,NULL,NULL,NULL,4,'2026-09-04 09:29:28','2026-09-04 09:29:28'),
(57,5,'Anant Chaturdashi Mahavisarjan','2026-09-14','16:00:00',NULL,'Girgaon Chowpatty','Marine Drive, Mumbai',NULL,NULL,NULL,'Traditional White & Saffron Dupatta','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(56,5,'56 Bhog Mahaprasad & Bhajan Sandhya','2026-09-09','13:00:00',NULL,'Annakshetra Dining Hall','Lalbaug, Mumbai',NULL,NULL,NULL,'Festive Indian Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(55,5,'Daily Atharvashirsha & Maha Aarti','2026-09-06','19:30:00',NULL,'Main Sanctum Hall','Lalbaug, Mumbai',NULL,NULL,NULL,'Ethnic Kurta & Paithani Silk','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(54,5,'Bappa Aagman & Pranpratishtha','2026-09-05','09:00:00',NULL,'Shree Ganesh Krupa Pandal','Lalbaug Main Road, Mumbai',NULL,NULL,NULL,'Kesariya Saffron & Traditional Yellow','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(22,1,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(26,6,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(27,6,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(28,6,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(29,6,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(30,7,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(31,7,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(32,7,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(33,7,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(34,8,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(35,8,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(36,8,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(37,8,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(38,9,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(39,9,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(40,9,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(41,9,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(42,10,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(43,10,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(44,10,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(45,10,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(46,11,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(47,11,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(48,11,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(49,11,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(50,12,'Haldi & Phoolon Ki Holi','2026-10-04','10:00:00',NULL,'Poolside Gardens, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Shades of Sunshine Yellow & Ochre','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(51,12,'Mehendi & Sangeet Soirée','2026-10-04','18:30:00',NULL,'Royal Courtyard, Taj Lake Palace','Pichola, Udaipur, Rajasthan',NULL,NULL,NULL,'Bright Pastel Lehengas & Kurtas','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(52,12,'Shubh Vivah & Varmala Ceremony','2026-10-05','17:00:00',NULL,'Grand Palace Amphitheater','Udaipur, Rajasthan',NULL,NULL,NULL,'Royal Silk, Maroon & Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(53,12,'Grand Reception & Gala Dinner','2026-10-06','19:30:00',NULL,'The Grand Ballroom','Udaipur, Rajasthan',NULL,NULL,NULL,'Black Tie / Formal Evening Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(58,13,'Shahi Aagman Miravand (Dhol-Tasha)','2026-09-05','08:30:00',NULL,'Laxmi Road to Kasba Ganpati','Kasba Peth, Pune',NULL,NULL,NULL,'Puneri Pheta & Paithani Magenta','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(59,13,'Ganesh Yag & Atharvashirsha Avartan','2026-09-07','10:00:00',NULL,'Peshwai Darbar Sabhagruh','Shivajinagar, Pune',NULL,NULL,NULL,'Traditional Dhoti & Silk Kurta','?️',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(60,13,'Haldi-Kunku & Bhajan Sandhya','2026-09-10','17:30:00',NULL,'Kasba Sabhagruh','Pune, Maharashtra',NULL,NULL,NULL,'Paithani Saree & Traditional Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(61,13,'Shahi Visarjan Miravand & Gulal Utsav','2026-09-14','15:00:00',NULL,'Alka Talkies Chowk','Tilak Road, Pune',NULL,NULL,NULL,'White Kurta with Saffron Stole','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(62,14,'Clay Bappa Sthapana & Durva Arpan','2026-09-05','09:30:00',NULL,'Green Earth Eco-Homes Garden','Indiranagar 100ft Road, Bengaluru',NULL,NULL,NULL,'Organic Cotton & Khadi Pastels','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(63,14,'Satyanarayan Pooja & Tulsi Archana','2026-09-08','11:00:00',NULL,'Terrace Garden Mandap','Bengaluru, Karnataka',NULL,NULL,NULL,'Eco Green & Off-White Silk','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(64,14,'Organic Ukadiche Modak & Bhojan','2026-09-10','13:30:00',NULL,'Banana Leaf Dining Lawn','Indiranagar, Bengaluru',NULL,NULL,NULL,'Festive Casuals','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(65,14,'Eco Pot Visarjan & Tree Planting','2026-09-14','17:00:00',NULL,'Lakeside Eco Pavilion','Bengaluru',NULL,NULL,NULL,'Comfortable Nature Greens','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(66,15,'Maha Sankalpam & Sanctum Sthapana','2026-09-05','08:00:00',NULL,'Shree Siddhivinayak Temple Sanctum','Prabhadevi, Mumbai',NULL,NULL,NULL,'Makrana Silk & Sanctum Gold','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(67,15,'1008 Modak Maha Yag & Veda Pathan','2026-09-07','09:30:00',NULL,'Yagashala Mandapam','Prabhadevi, Mumbai',NULL,NULL,NULL,'Traditional Silk Dhoti & Angavastram','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(68,15,'Swarna Deepa Maha Aarti & Bhajans','2026-09-11','19:00:00',NULL,'Grand Marble Courtyard','Mumbai, Maharashtra',NULL,NULL,NULL,'Rich Crimson & Gilded Gold','✨',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(69,15,'Shobha Yatra & Samudra Visarjan','2026-09-14','16:30:00',NULL,'Dadar Chowpatty Beach','Dadar, Mumbai',NULL,NULL,NULL,'Traditional Festive Attire','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(70,16,'Bal Bappa Joyful Aagman & Rangoli','2026-09-05','10:30:00',NULL,'Anand Bhavan Courtyard','Jubilee Hills, Hyderabad',NULL,NULL,NULL,'Tangerine Glow & Pastel Yellows','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(71,16,'Kids Clay Modak Workshop & Magic Show','2026-09-06','16:00:00',NULL,'Joy Kids Activity Hall','Hyderabad, Telangana',NULL,NULL,NULL,'Bright Colorful Kids Festive Wear','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(72,16,'Family Maha Aarti & Motichoor Laddoo Feast','2026-09-09','19:00:00',NULL,'Family Pooja Hall','Hyderabad, Telangana',NULL,NULL,NULL,'Festive Kurta & Ghagra','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(73,16,'Joyful Rose Petal Visarjan Celebration','2026-09-14','17:30:00',NULL,'Lotus Pond Club','Jubilee Hills, Hyderabad',NULL,NULL,NULL,'Floral Prints & Pastels','?',0,'2026-09-04 10:15:28','2026-09-04 10:15:28');

/*Table structure for table `invitation_feature_prices` */

DROP TABLE IF EXISTS `invitation_feature_prices`;

CREATE TABLE `invitation_feature_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` bigint unsigned NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tier_capacity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_feature_prices_feature_id_currency_index` (`feature_id`,`currency`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_feature_prices` */

insert  into `invitation_feature_prices`(`id`,`feature_id`,`currency`,`price`,`tier_capacity`,`created_at`,`updated_at`) values 
(1,1,'INR',0.00,50,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(2,1,'INR',299.00,200,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(3,1,'INR',599.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(4,1,'USD',0.00,50,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(5,1,'USD',4.99,200,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(6,1,'USD',9.99,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(7,2,'INR',499.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(8,2,'USD',7.99,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(9,3,'INR',199.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(10,3,'USD',2.99,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(11,4,'INR',299.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(12,4,'USD',4.99,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(13,5,'INR',999.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(14,5,'USD',14.99,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(15,6,'INR',0.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(16,6,'USD',0.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(17,7,'INR',149.00,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(18,7,'USD',1.99,NULL,'2026-09-04 07:18:08','2026-09-04 07:18:08');

/*Table structure for table `invitation_features` */

DROP TABLE IF EXISTS `invitation_features`;

CREATE TABLE `invitation_features` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_features_code_unique` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_features` */

insert  into `invitation_features`(`id`,`code`,`name`,`description`,`icon`,`is_active`,`sort_order`,`created_at`,`updated_at`) values 
(1,'rsvp_custom_form','Dynamic RSVP Form Builder','Custom questions, dietary preferences, multi-guest attendance tracking, plus-one controls.','?',1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(2,'guest_qr_checkin','Guest QR Codes & Door Check-In','Generate individual QR passes for each guest and scan at venue door with mobile camera.','?',1,2,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(3,'background_music','Background Ambient Music & Audio','Upload romantic melodies or party anthems with floating music player FAB & auto-play prompt.','?',1,3,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(4,'photo_gallery_unlimited','High-Res Photo Gallery & Lightbox','Showcase pre-wedding shoots, milestone moments, and interactive photo sliders.','?️',1,4,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(5,'custom_domain','Custom Vanity Domain & White-Label','Host on your personal wedding domain (e.g., priyawedsrahul.com) with SSL and no platform branding.','?',1,5,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(6,'multi_event_timeline','Multi-Event Itinerary & Map Directions','Schedule Haldi, Mehendi, Sangeet, Wedding, and Reception with individual Google Maps & Cal sync.','?️',1,6,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(7,'ai_copywriter','AI Love Story & Itinerary Writer','Generate poetic wedding vows, personalized love stories, and itinerary descriptions in seconds.','✨',1,7,'2026-09-04 07:18:08','2026-09-04 07:18:08');

/*Table structure for table `invitation_form_fields` */

DROP TABLE IF EXISTS `invitation_form_fields`;

CREATE TABLE `invitation_form_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint unsigned NOT NULL,
  `event_id` bigint unsigned DEFAULT NULL,
  `field_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeholder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` json DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `conditional_rules` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_form_fields_event_id_foreign` (`event_id`),
  KEY `invitation_form_fields_form_id_sort_order_index` (`form_id`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_form_fields` */

insert  into `invitation_form_fields`(`id`,`form_id`,`event_id`,`field_type`,`label`,`placeholder`,`options`,`is_required`,`sort_order`,`conditional_rules`,`created_at`,`updated_at`) values 
(1,1,NULL,'radio','Will you be attending?',NULL,'[\"Joyfully Attending\", \"Regretfully Declining\", \"Tentative / Confirm Later\"]',1,1,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(2,1,NULL,'number','Total number of guests in your party','1',NULL,1,2,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(3,1,NULL,'checkbox','Which events will you attend?',NULL,'[\"Mehendi & Sangeet (Day 1)\", \"Haldi Celebration (Day 2 Morning)\", \"Wedding & Grand Reception (Day 2 Evening)\"]',1,3,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(4,1,NULL,'dropdown','Dietary Preferences',NULL,'[\"Pure Vegetarian\", \"Jain Vegetarian (No Onion/Garlic)\", \"Non-Vegetarian\", \"Vegan / Gluten-Free\"]',0,4,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(5,1,NULL,'yes_no','Do you require airport/station pickup in Udaipur?',NULL,'[\"Yes\", \"No\"]',0,5,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(6,1,NULL,'text','Song Request for the Sangeet DJ Night ?','Your favorite Bollywood / Punjabi dance track...',NULL,0,6,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(7,1,NULL,'textarea','Special notes or room requirements for the family','Any special assistance or elders accommodation...',NULL,0,7,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(8,2,NULL,'radio','Will you be attending?',NULL,'[\"Accepts with Pleasure\", \"Declines with Regret\"]',1,1,NULL,'2026-09-04 07:37:31','2026-09-04 07:37:31'),
(9,2,NULL,'number','Number of guests attending','1',NULL,1,2,NULL,'2026-09-04 07:37:31','2026-09-04 07:37:31'),
(10,2,NULL,'dropdown','Dietary preference',NULL,'[\"Vegetarian\", \"Non-Vegetarian\", \"Jain / No Onion Garlic\", \"Vegan\"]',0,3,NULL,'2026-09-04 07:37:31','2026-09-04 07:37:31'),
(11,3,NULL,'radio','Will you be attending?',NULL,'[\"Accepts with Pleasure\", \"Declines with Regret\"]',1,1,NULL,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(12,3,NULL,'number','Number of guests attending','1',NULL,1,2,NULL,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(13,3,NULL,'dropdown','Dietary preference',NULL,'[\"Vegetarian\", \"Non-Vegetarian\", \"Jain / No Onion Garlic\", \"Vegan\"]',0,3,NULL,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(14,4,NULL,'radio','Will you be attending?',NULL,'[\"Accepts with Pleasure\", \"Declines with Regret\"]',1,1,NULL,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(15,4,NULL,'number','Number of guests attending','1',NULL,1,2,NULL,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(16,4,NULL,'dropdown','Dietary preference',NULL,'[\"Vegetarian\", \"Non-Vegetarian\", \"Jain / No Onion Garlic\", \"Vegan\"]',0,3,NULL,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(17,5,NULL,'radio','Will you be visiting for Darshan & Aarti?',NULL,'[\"Yes, Attending with Family\", \"Will join for Visarjan Miravnuk\", \"Unable to attend in person\"]',1,1,NULL,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(18,5,NULL,'number','Total number of family members attending','1',NULL,1,2,NULL,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(19,5,NULL,'dropdown','Preferred Darshan Time Slot',NULL,'[\"Morning Aarti (09:00 AM - 12:00 PM)\", \"Evening Mahamangal Aarti (07:00 PM - 09:30 PM)\", \"Mahaprasad Feast (01:00 PM - 04:00 PM)\"]',0,3,NULL,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(20,7,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(21,7,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(22,7,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(23,7,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(24,8,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(25,8,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(26,8,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(27,8,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(28,9,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(29,9,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(30,9,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(31,9,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(32,10,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(33,10,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(34,10,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(35,10,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(36,11,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(37,11,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(38,11,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(39,11,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(40,12,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(41,12,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(42,12,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(43,12,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(44,13,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(45,13,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(46,13,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(47,13,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(48,14,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(49,14,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(50,14,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(51,14,NULL,'select','Will You Attend All Ceremonies?',NULL,'[\"Yes, Attending with Joy\", \"Regretfully Cannot Attend\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(52,15,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(53,15,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(54,15,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(55,15,NULL,'select','Will You Join for Daily Evening Maha Aarti & Mahaprasad?',NULL,'[\"Yes, Joyfully Attending\", \"Visiting for Darshan Only\", \"Sending Prayers Remotely\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(56,16,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(57,16,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(58,16,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(59,16,NULL,'select','Will You Join for Daily Evening Maha Aarti & Mahaprasad?',NULL,'[\"Yes, Joyfully Attending\", \"Visiting for Darshan Only\", \"Sending Prayers Remotely\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(60,17,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(61,17,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(62,17,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(63,17,NULL,'select','Will You Join for Daily Evening Maha Aarti & Mahaprasad?',NULL,'[\"Yes, Joyfully Attending\", \"Visiting for Darshan Only\", \"Sending Prayers Remotely\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(64,18,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(65,18,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(66,18,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(67,18,NULL,'select','Will You Join for Daily Evening Maha Aarti & Mahaprasad?',NULL,'[\"Yes, Joyfully Attending\", \"Visiting for Darshan Only\", \"Sending Prayers Remotely\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(68,19,NULL,'text','Full Name / Family Representative','e.g. Rajesh Sharma & Family',NULL,1,1,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(69,19,NULL,'phone','WhatsApp Contact Number','+91 98765 43210',NULL,1,2,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(70,19,NULL,'number','Total Number of Devotees / Guests Attending','2',NULL,1,3,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(71,19,NULL,'select','Will You Join for Daily Evening Maha Aarti & Mahaprasad?',NULL,'[\"Yes, Joyfully Attending\", \"Visiting for Darshan Only\", \"Sending Prayers Remotely\"]',1,4,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28');

/*Table structure for table `invitation_form_responses` */

DROP TABLE IF EXISTS `invitation_form_responses`;

CREATE TABLE `invitation_form_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint unsigned NOT NULL,
  `invitation_id` bigint unsigned NOT NULL,
  `guest_id` bigint unsigned DEFAULT NULL,
  `guest_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attending_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'attending',
  `party_size` int NOT NULL DEFAULT '1',
  `dietary_preferences` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `answers` json DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_form_responses_form_id_foreign` (`form_id`),
  KEY `invitation_form_responses_invitation_id_attending_status_index` (`invitation_id`,`attending_status`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_form_responses` */

insert  into `invitation_form_responses`(`id`,`form_id`,`invitation_id`,`guest_id`,`guest_name`,`guest_email`,`guest_phone`,`attending_status`,`party_size`,`dietary_preferences`,`notes`,`answers`,`submitted_at`,`ip_address`,`created_at`,`updated_at`) values 
(1,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 13:00:20','127.0.0.1','2026-09-04 07:30:20','2026-09-04 07:30:20'),
(2,1,1,5,'Karan Johar','karan@example.com','+91 98000 11111','attending',2,NULL,NULL,'[]','2026-09-04 13:01:26','127.0.0.1','2026-09-04 07:31:26','2026-09-04 07:31:26'),
(3,1,1,5,'Karan Johar','karan@example.com','+91 98000 11111','attending',2,NULL,NULL,'[]','2026-09-04 13:02:05','127.0.0.1','2026-09-04 07:32:05','2026-09-04 07:32:05'),
(4,1,1,5,'Karan Johar','karan@example.com','+91 98000 11111','attending',2,NULL,NULL,'[]','2026-09-04 13:27:36','127.0.0.1','2026-09-04 07:57:36','2026-09-04 07:57:36'),
(5,1,1,5,'Karan Johar','karan@example.com','+91 98000 11111','attending',2,NULL,NULL,'[]','2026-09-04 13:30:17','127.0.0.1','2026-09-04 08:00:17','2026-09-04 08:00:17'),
(6,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 13:30:51','127.0.0.1','2026-09-04 08:00:51','2026-09-04 08:00:51'),
(7,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 13:33:59','127.0.0.1','2026-09-04 08:03:59','2026-09-04 08:03:59'),
(8,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 13:34:48','127.0.0.1','2026-09-04 08:04:48','2026-09-04 08:04:48'),
(9,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 14:46:30','127.0.0.1','2026-09-04 09:16:30','2026-09-04 09:16:30'),
(10,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 14:53:08','127.0.0.1','2026-09-04 09:23:08','2026-09-04 09:23:08'),
(11,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 14:56:48','127.0.0.1','2026-09-04 09:26:48','2026-09-04 09:26:48'),
(12,1,1,4,'Aditya Roy & Family','aditya@example.com','+91 99887 76655','attending',3,'Vegetarian','Excited to attend the royal celebrations in Udaipur!','[]','2026-09-04 15:07:06','127.0.0.1','2026-09-04 09:37:06','2026-09-04 09:37:06');

/*Table structure for table `invitation_forms` */

DROP TABLE IF EXISTS `invitation_forms`;

CREATE TABLE `invitation_forms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'RSVP to Our Celebration',
  `description` text COLLATE utf8mb4_unicode_ci,
  `deadline` datetime DEFAULT NULL,
  `max_party_size` int NOT NULL DEFAULT '5',
  `allow_guest_plus_one` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_forms_invitation_id_foreign` (`invitation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_forms` */

insert  into `invitation_forms`(`id`,`invitation_id`,`title`,`description`,`deadline`,`max_party_size`,`allow_guest_plus_one`,`is_active`,`created_at`,`updated_at`) values 
(1,1,'Wedding RSVP & Accommodation Form','Please let us know your travel schedule and food preferences to help us prepare the best royal hospitality.','2026-10-19 07:53:38',6,1,1,'2026-09-04 07:18:09','2026-09-04 07:53:38'),
(2,2,'Kindly RSVP to Our Celebration','Please confirm your attendance by October 04, 2026','2026-10-04 23:59:00',5,1,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(3,3,'Kindly RSVP to Our Celebration','Please confirm your attendance by October 04, 2026','2026-10-04 23:59:00',5,1,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(4,4,'Kindly RSVP to Our Celebration','Please confirm your attendance by October 04, 2026','2026-11-20 00:00:00',6,1,1,'2026-09-04 09:22:53','2026-09-04 09:26:41'),
(5,5,'Darshan & Mahaprasad Confirmation','Kindly confirm your visiting date and number of family members for Prasad arrangements','2026-09-14 09:58:53',10,1,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(6,1,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:10','2026-09-04 10:15:10'),
(7,1,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(8,6,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(9,7,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(10,8,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(11,9,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(12,10,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(13,11,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(14,12,'Ceremony RSVP Confirmation','Please confirm your attendance so we can reserve your royal stay and seating.',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(15,5,'Darshan & Mahaprasad RSVP','Kindly let us know your visiting date and number of devotees for prasad arrangements',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(16,13,'Darshan & Mahaprasad RSVP','Kindly let us know your visiting date and number of devotees for prasad arrangements',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(17,14,'Darshan & Mahaprasad RSVP','Kindly let us know your visiting date and number of devotees for prasad arrangements',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(18,15,'Darshan & Mahaprasad RSVP','Kindly let us know your visiting date and number of devotees for prasad arrangements',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(19,16,'Darshan & Mahaprasad RSVP','Kindly let us know your visiting date and number of devotees for prasad arrangements',NULL,5,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28');

/*Table structure for table `invitation_guest_events` */

DROP TABLE IF EXISTS `invitation_guest_events`;

CREATE TABLE `invitation_guest_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guest_id` bigint unsigned NOT NULL,
  `event_id` bigint unsigned NOT NULL,
  `invitation_id` bigint unsigned NOT NULL,
  `is_invited` tinyint(1) NOT NULL DEFAULT '1',
  `attending_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_guest_events_guest_id_event_id_unique` (`guest_id`,`event_id`),
  KEY `invitation_guest_events_event_id_foreign` (`event_id`),
  KEY `invitation_guest_events_invitation_id_foreign` (`invitation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_guest_events` */

/*Table structure for table `invitation_guest_responses` */

DROP TABLE IF EXISTS `invitation_guest_responses`;

CREATE TABLE `invitation_guest_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `guest_id` bigint unsigned NOT NULL,
  `form_field_id` bigint unsigned NOT NULL,
  `response_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_guest_responses_guest_id_form_field_id_unique` (`guest_id`,`form_field_id`),
  KEY `invitation_guest_responses_form_field_id_foreign` (`form_field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_guest_responses` */

/*Table structure for table `invitation_guests` */

DROP TABLE IF EXISTS `invitation_guests`;

CREATE TABLE `invitation_guests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `guest_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allocated_seats` int NOT NULL DEFAULT '1',
  `attending_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_vip` tinyint(1) NOT NULL DEFAULT '0',
  `check_in_status` tinyint(1) NOT NULL DEFAULT '0',
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `qr_code_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_guests_guest_code_unique` (`guest_code`),
  KEY `invitation_guests_invitation_id_group_name_index` (`invitation_id`,`group_name`),
  KEY `invitation_guests_invitation_id_attending_status_index` (`invitation_id`,`attending_status`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_guests` */

insert  into `invitation_guests`(`id`,`invitation_id`,`guest_code`,`name`,`email`,`phone`,`group_name`,`allocated_seats`,`attending_status`,`is_vip`,`check_in_status`,`checked_in_at`,`qr_code_path`,`custom_notes`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,'GST-MEHRA99','Dr. Arvind Mehra & Family','arvind.mehra@example.com','+91 98200 11223','VIP Guests',4,'attending',1,0,NULL,NULL,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09',NULL),
(2,1,'GST-KAPOOR21','Mrs. Sunita Kapoor','sunita.kapoor@example.com','+91 98111 22334','Bride Family',2,'attending',0,0,NULL,NULL,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09',NULL),
(3,1,'GST-SINGH44','Vikram Singhania','vikram.s@example.com','+91 99000 88776','Groom Friends',1,'pending',0,0,NULL,NULL,NULL,'2026-09-04 07:18:09','2026-09-04 07:18:09',NULL),
(4,1,'GST-ZQKLCG','Aditya Roy & Family','aditya@example.com','+91 99887 76655','Online RSVPs',3,'attending',0,0,NULL,NULL,NULL,'2026-09-04 07:30:20','2026-09-04 07:30:20',NULL),
(5,1,'GST-U87UOM','Karan Johar','karan@example.com','+91 98000 11111','Online RSVPs',2,'attending',0,0,NULL,NULL,NULL,'2026-09-04 07:31:26','2026-09-04 07:31:26',NULL);

/*Table structure for table `invitation_order_items` */

DROP TABLE IF EXISTS `invitation_order_items`;

CREATE TABLE `invitation_order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` bigint unsigned DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_order_items_order_id_foreign` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_order_items` */

/*Table structure for table `invitation_orders` */

DROP TABLE IF EXISTS `invitation_orders`;

CREATE TABLE `invitation_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `invitation_id` bigint unsigned DEFAULT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `final_amount` decimal(10,2) NOT NULL,
  `payment_gateway` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'razorpay',
  `gateway_order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_payment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_orders_order_number_unique` (`order_number`),
  KEY `invitation_orders_invitation_id_foreign` (`invitation_id`),
  KEY `invitation_orders_template_id_foreign` (`template_id`),
  KEY `invitation_orders_user_id_status_index` (`user_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_orders` */

/*Table structure for table `invitation_payments` */

DROP TABLE IF EXISTS `invitation_payments`;

CREATE TABLE `invitation_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `transaction_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `raw_payload` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_payments_order_id_foreign` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_payments` */

/*Table structure for table `invitation_qr_codes` */

DROP TABLE IF EXISTS `invitation_qr_codes`;

CREATE TABLE `invitation_qr_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `qr_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_string` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreground_color` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0F172A',
  `background_color` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#FFFFFF',
  `logo_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style_options` json DEFAULT NULL,
  `download_count` bigint unsigned NOT NULL DEFAULT '0',
  `scan_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_qr_codes_invitation_id_qr_type_index` (`invitation_id`,`qr_type`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_qr_codes` */

insert  into `invitation_qr_codes`(`id`,`invitation_id`,`qr_type`,`target_url`,`code_string`,`foreground_color`,`background_color`,`logo_url`,`style_options`,`download_count`,`scan_count`,`created_at`,`updated_at`) values 
(1,1,'invitation_link','http://localhost:8000/i/priya-and-rahul-wedding','INV-EC08B1B4','#064E3B','#FFFFFF',NULL,NULL,12,48,'2026-09-04 07:18:09','2026-09-04 07:18:09'),
(2,2,'invitation_link','http://127.0.0.1:8000/i/the-royal-rajwada-opulent-gold-emerald-palace-h93xuo','INV-5B7TRH9R','#D4AF37','#FFFFFF',NULL,NULL,0,0,'2026-09-04 07:37:31','2026-09-04 07:37:31'),
(3,3,'invitation_link','http://127.0.0.1:8000/i/abhishek-abhi-wedding-celebration-adhrob','INV-COBHLYFS','#D4AF37','#FFFFFF',NULL,NULL,0,0,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(4,4,'invitation_link','http://localhost:8000/i/rahul-priya-wedding-celebration-yxtrf4','INV-PI216OB3','#D4AF37','#FFFFFF',NULL,NULL,0,0,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(5,5,'invitation_link','http://localhost:8000/i/shree-ganeshotsav-2026','INV-BAPPA2026','#EA580C','#FFFFFF',NULL,NULL,0,0,'2026-09-04 09:58:53','2026-09-04 09:58:53');

/*Table structure for table `invitation_sections` */

DROP TABLE IF EXISTS `invitation_sections`;

CREATE TABLE `invitation_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `section_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` json DEFAULT NULL,
  `settings` json DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_sections_invitation_id_sort_order_index` (`invitation_id`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_sections` */

insert  into `invitation_sections`(`id`,`invitation_id`,`section_type`,`title`,`subtitle`,`content`,`settings`,`sort_order`,`is_enabled`,`created_at`,`updated_at`) values 
(96,6,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(97,6,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(98,6,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(93,6,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(94,6,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(95,6,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(92,6,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(83,1,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(82,1,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(81,1,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"The Royal Rajwada — Opulent Gold & Emerald Palace\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(84,1,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(85,1,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(86,1,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(87,1,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(88,1,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(89,1,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(90,1,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(91,6,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"Elysian Bloom — Pastel Lavender & Rose Gold\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(12,2,'hero','Shubh Vivah','Together with our families, we invite you to celebrate the union of','[]','[]',1,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(13,2,'couple','The Couple','Two souls, one sacred journey','[]','[]',2,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(14,2,'introduction','|| Shree Ganeshay Namah ||','With the divine blessings of our ancestors & almighty','[]','[]',3,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(15,2,'events','Celebration Itinerary','Join us across three days of joyous festivities','[]','[]',4,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(16,2,'timeline','Sacred Milestones','The timeline of events','[]','[]',5,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(17,2,'countdown','Counting Down to the Big Day','Every second brings us closer to forever','[]','[]',6,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(18,2,'gallery','Moments of Love','Our pre-wedding memories captured in frames','[]','[]',7,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(19,2,'music','Ambient Melody','Play Background Shehnai & Sitar Music','[]','[]',8,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(20,2,'venue','Royal Venue & Stay','Taj Lake Palace, Udaipur','[]','[]',9,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(21,2,'map','Directions & Navigation','Get directions via Google Maps','[]','[]',10,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(22,2,'dress_code','Attire & Palette Guidelines','Royal Heritage & Traditional Indian Attire','[]','[]',11,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(23,2,'rsvp','Kindly RSVP','Please confirm your gracious presence by November 15','[]','[]',12,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(24,2,'guestbook','Warm Blessings & Wishes','Leave your blessings for the newlyweds','[]','[]',13,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(25,2,'qr','Instant Digital Pass','Scan at the welcome lounge for expedited check-in','[]','[]',14,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(26,2,'contact','Event Coordinators','Reach out to the family hosts for any assistance','[]','[]',15,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(27,2,'footer','#PriyaWedsRahul2026','We eagerly await your gracious presence','[]','[]',16,1,'2026-09-04 07:37:30','2026-09-04 07:37:30'),
(28,3,'hero','Shubh Vivah','Together with our families, we joyfully invite you to celebrate the auspicious union and wedding festivities of Abhishek & Abhi in Mumbai.','{\"bride_name\": \"Abhi\", \"groom_name\": \"Abhishek\", \"city_display\": \"Mumbai\"}','[]',1,1,'2026-09-04 09:18:48','2026-09-04 09:27:14'),
(29,3,'couple','The Couple','Two souls, one sacred journey','[]','[]',2,1,'2026-09-04 09:18:48','2026-09-04 09:27:28'),
(30,3,'introduction','|| Shree Ganeshay Namah ||','With the divine blessings of our ancestors & almighty','[]','[]',3,1,'2026-09-04 09:18:48','2026-09-04 09:27:32'),
(31,3,'events','Celebration Itinerary','Join us across three days of joyous festivities','[]','[]',4,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(32,3,'timeline','Sacred Milestones','The timeline of events','[]','[]',5,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(33,3,'countdown','Counting Down to the Big Day','Every second brings us closer to forever','[]','[]',6,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(34,3,'gallery','Moments of Love','Our pre-wedding memories captured in frames','[]','[]',7,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(35,3,'music','Ambient Melody','Play Background Shehnai & Sitar Music','[]','[]',8,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(36,3,'venue','Royal Venue & Stay','Taj Lake Palace, Udaipur','[]','[]',9,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(37,3,'map','Directions & Navigation','Get directions via Google Maps','[]','[]',10,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(38,3,'dress_code','Attire & Palette Guidelines','Royal Heritage & Traditional Indian Attire','[]','[]',11,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(39,3,'rsvp','Kindly RSVP','Please confirm your gracious presence by November 15','[]','[]',12,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(40,3,'guestbook','Warm Blessings & Wishes','Leave your blessings for the newlyweds','[]','[]',13,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(41,3,'qr','Instant Digital Pass','Scan at the welcome lounge for expedited check-in','[]','[]',14,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(42,3,'contact','Event Coordinators','Reach out to the family hosts for any assistance','[]','[]',15,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(43,3,'footer','#PriyaWedsRahul2026','We eagerly await your gracious presence','[]','[]',16,1,'2026-09-04 09:18:48','2026-09-04 09:18:48'),
(44,4,'hero','Shubh Mangal Vivah','With the divine blessings of our families, we invite you.','{\"bride_name\": \"Priya\", \"groom_name\": \"Abhishek\", \"city_display\": \"Udaipur, Rajasthan\"}','[]',1,1,'2026-09-04 09:22:53','2026-09-04 09:36:59'),
(45,4,'couple','The Couple','Two souls, one sacred journey','[]','[]',2,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(46,4,'introduction','|| Shree Ganeshay Namah ||','With the divine blessings of our ancestors & almighty','[]','[]',3,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(47,4,'events','Celebration Itinerary','Join us across three days of joyous festivities','[]','[]',4,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(48,4,'timeline','Sacred Milestones','The timeline of events','[]','[]',5,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(49,4,'countdown','Counting Down to the Big Day','Every second brings us closer to forever','[]','[]',6,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(50,4,'gallery','Moments of Love','Our pre-wedding memories captured in frames','[]','[]',7,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(51,4,'music','Ambient Melody','Play Background Shehnai & Sitar Music','[]','[]',8,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(52,4,'venue','Royal Venue & Stay','Taj Lake Palace, Udaipur','[]','[]',9,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(53,4,'map','Directions & Navigation','Get directions via Google Maps','[]','[]',10,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(54,4,'dress_code','Attire & Palette Guidelines','Royal Heritage & Traditional Indian Attire','[]','[]',11,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(55,4,'rsvp','Kindly RSVP','Please confirm your gracious presence by November 15','[]','[]',12,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(56,4,'guestbook','Warm Blessings & Wishes','Leave your blessings for the newlyweds','[]','[]',13,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(57,4,'qr','Instant Digital Pass','Scan at the welcome lounge for expedited check-in','[]','[]',14,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(58,4,'contact','Event Coordinators','Reach out to the family hosts for any assistance','[]','[]',15,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(59,4,'footer','#PriyaWedsRahul2026','We eagerly await your gracious presence','[]','[]',16,1,'2026-09-04 09:22:53','2026-09-04 09:22:53'),
(188,14,'rsvp','Darshan & Mahaprasad RSVP','Please let us know your visiting slot and prasad box requirement','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(189,14,'guestbook','Bappa Blessings & Prayers Wall','Leave your Ganesh Chaturthi wishes and prayers for all devotees','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(190,14,'footer','|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||','The Parivar & Devotees Welfare Committee','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(191,15,'hero','|| श्री गणेशाय नमः ||','You and your family are cordially invited to celebrate the auspicious Ganeshotsav and seek Bappa’s divine blessings.','{\"heading\": \"Temple Sanctum & Golden Modak — Sacred Marble & Gilded Gold\", \"bride_name\": \"\", \"event_type\": \"festival\", \"groom_name\": \"\", \"city_display\": \"Mumbai / Pune / Bengaluru\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(184,14,'events','Ganeshotsav Pooja & Aarti Schedule','Join us for sacred aartis, devotional bhajans and mahaprasad','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(185,14,'venue','Mandap Location & Darshan Timings','Devotee guidelines, parking assistance and prasadam counters','{\"address\": \"Lalbaug / Kasba Peth / Indiranagar\", \"landmark\": \"Near Main Temple Gate\", \"venue_name\": \"Shree Ganesh Krupa Mandap\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(186,14,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(187,14,'dress_code','Festive Attire Guidelines','Traditional Festive Wear: Kurta Pyjama, Dhoti, Silk Saree & Nauvari','{\"guidelines\": \"Bright festive traditional colors (Saffron, Yellow, Magenta, Green). Avoid black attire during pooja rituals.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(182,14,'introduction','|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||','निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha illuminate our lives with boundless wisdom, prosperity, and peace.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(183,14,'countdown','Bappa Aagman Countdown','Counting down the auspicious hours to Ganesh Chaturthi Sthapana','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(180,13,'footer','|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||','The Parivar & Devotees Welfare Committee','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(181,14,'hero','|| श्री गणेशाय नमः ||','You and your family are cordially invited to celebrate the auspicious Ganeshotsav and seek Bappa’s divine blessings.','{\"heading\": \"Eco-Friendly Green & Clay Bappa — Sustainable Nature Ganeshotsav\", \"bride_name\": \"\", \"event_type\": \"festival\", \"groom_name\": \"\", \"city_display\": \"Mumbai / Pune / Bengaluru\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(176,13,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(177,13,'dress_code','Festive Attire Guidelines','Traditional Festive Wear: Kurta Pyjama, Dhoti, Silk Saree & Nauvari','{\"guidelines\": \"Bright festive traditional colors (Saffron, Yellow, Magenta, Green). Avoid black attire during pooja rituals.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(178,13,'rsvp','Darshan & Mahaprasad RSVP','Please let us know your visiting slot and prasad box requirement','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(179,13,'guestbook','Bappa Blessings & Prayers Wall','Leave your Ganesh Chaturthi wishes and prayers for all devotees','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(173,13,'countdown','Bappa Aagman Countdown','Counting down the auspicious hours to Ganesh Chaturthi Sthapana','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(174,13,'events','Ganeshotsav Pooja & Aarti Schedule','Join us for sacred aartis, devotional bhajans and mahaprasad','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(175,13,'venue','Mandap Location & Darshan Timings','Devotee guidelines, parking assistance and prasadam counters','{\"address\": \"Lalbaug / Kasba Peth / Indiranagar\", \"landmark\": \"Near Main Temple Gate\", \"venue_name\": \"Shree Ganesh Krupa Mandap\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(172,13,'introduction','|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||','निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha illuminate our lives with boundless wisdom, prosperity, and peace.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(169,5,'guestbook','Bappa Blessings & Prayers Wall','Leave your Ganesh Chaturthi wishes and prayers for all devotees','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(170,5,'footer','|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||','The Parivar & Devotees Welfare Committee','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(171,13,'hero','|| श्री गणेशाय नमः ||','You and your family are cordially invited to celebrate the auspicious Ganeshotsav and seek Bappa’s divine blessings.','{\"heading\": \"Peshwai Dhol-Tasha & Kasba Ganpati — Royal Puneri Ganeshotsav\", \"bride_name\": \"\", \"event_type\": \"festival\", \"groom_name\": \"\", \"city_display\": \"Mumbai / Pune / Bengaluru\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(166,5,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(167,5,'dress_code','Festive Attire Guidelines','Traditional Festive Wear: Kurta Pyjama, Dhoti, Silk Saree & Nauvari','{\"guidelines\": \"Bright festive traditional colors (Saffron, Yellow, Magenta, Green). Avoid black attire during pooja rituals.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(168,5,'rsvp','Darshan & Mahaprasad RSVP','Please let us know your visiting slot and prasad box requirement','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(163,5,'countdown','Bappa Aagman Countdown','Counting down the auspicious hours to Ganesh Chaturthi Sthapana','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(164,5,'events','Ganeshotsav Pooja & Aarti Schedule','Join us for sacred aartis, devotional bhajans and mahaprasad','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(165,5,'venue','Mandap Location & Darshan Timings','Devotee guidelines, parking assistance and prasadam counters','{\"address\": \"Lalbaug / Kasba Peth / Indiranagar\", \"landmark\": \"Near Main Temple Gate\", \"venue_name\": \"Shree Ganesh Krupa Mandap\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(161,5,'hero','|| श्री गणेशाय नमः ||','You and your family are cordially invited to celebrate the auspicious Ganeshotsav and seek Bappa’s divine blessings.','{\"heading\": \"Saffron Aura & Lalbaugcha Raja — Divine Kesariya Ganeshotsav\", \"bride_name\": \"\", \"event_type\": \"festival\", \"groom_name\": \"\", \"city_display\": \"Mumbai / Pune / Bengaluru\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(162,5,'introduction','|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||','निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha illuminate our lives with boundless wisdom, prosperity, and peace.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(99,6,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(100,6,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(101,7,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"Little Astronaut — 1st Birthday Galaxy Bash\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(102,7,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(103,7,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(104,7,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(105,7,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(106,7,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(107,7,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(108,7,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(109,7,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(110,7,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(111,8,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"Obsidian Zenith — VIP Corporate Gala & Awards\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(112,8,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(113,8,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(114,8,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(115,8,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(116,8,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(117,8,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(118,8,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(119,8,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(120,8,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(121,9,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"The Peshwai Heritage — Crimson Velvet & Royal Maratha Gold\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(122,9,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(123,9,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(124,9,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(125,9,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(126,9,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(127,9,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(128,9,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(129,9,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(130,9,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(131,10,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"Nikaah Mubarak — Emerald & Ivory Crescent\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(132,10,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(133,10,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(134,10,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(135,10,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(136,10,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(137,10,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(138,10,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(139,10,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(140,10,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(141,11,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"Temple Kalyanam — Kanjeevaram Gold & Jasmine\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(142,11,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(143,11,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(144,11,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(145,11,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(146,11,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(147,11,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(148,11,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(149,11,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(150,11,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(151,12,'hero','✦ Shubh Vivah ✦','Together with their families, we joyfully invite you to celebrate the grand celebration.','{\"heading\": \"The Minimalist — Champagne Silk & Editorial Chic\", \"bride_name\": \"Priya Patel\", \"event_type\": \"wedding\", \"groom_name\": \"Rahul Sharma\", \"city_display\": \"Udaipur, Rajasthan\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(152,12,'introduction','Divine Blessings & Welcome','With the blessings of our beloved elders, we invite you to be part of our sacred milestone.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(153,12,'countdown','Countdown to the Big Day','Every moment brings us closer to celebration','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(154,12,'events','Celebration Schedule & Ceremonies','Please join us for all ceremonial festivities','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(155,12,'venue','Venue & Hospitality Details','Taj Lake Palace, Pichola, Udaipur','{\"address\": \"Pichola, Udaipur, Rajasthan 313001\", \"landmark\": \"Opposite Lake Palace Jetty\", \"venue_name\": \"The Grand Palace Courtyard\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(156,12,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(157,12,'dress_code','Festive Attire Guidelines','Royal Pastel Silk & Festive Kurtas','{\"guidelines\": \"Pastel festive lehengas and royal bandhgalas.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(158,12,'rsvp','Kindly Respond (RSVP)','Please confirm your attendance by November 01','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(159,12,'guestbook','Wishes & Memories Wall','Leave your warm wishes and loving thoughts for the hosts','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(160,12,'footer','With Heartfelt Love & Gratitude','The Sharma & Patel Families','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(192,15,'introduction','|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||','निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha illuminate our lives with boundless wisdom, prosperity, and peace.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(193,15,'countdown','Bappa Aagman Countdown','Counting down the auspicious hours to Ganesh Chaturthi Sthapana','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(194,15,'events','Ganeshotsav Pooja & Aarti Schedule','Join us for sacred aartis, devotional bhajans and mahaprasad','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(195,15,'venue','Mandap Location & Darshan Timings','Devotee guidelines, parking assistance and prasadam counters','{\"address\": \"Lalbaug / Kasba Peth / Indiranagar\", \"landmark\": \"Near Main Temple Gate\", \"venue_name\": \"Shree Ganesh Krupa Mandap\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(196,15,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(197,15,'dress_code','Festive Attire Guidelines','Traditional Festive Wear: Kurta Pyjama, Dhoti, Silk Saree & Nauvari','{\"guidelines\": \"Bright festive traditional colors (Saffron, Yellow, Magenta, Green). Avoid black attire during pooja rituals.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(198,15,'rsvp','Darshan & Mahaprasad RSVP','Please let us know your visiting slot and prasad box requirement','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(199,15,'guestbook','Bappa Blessings & Prayers Wall','Leave your Ganesh Chaturthi wishes and prayers for all devotees','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(200,15,'footer','|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||','The Parivar & Devotees Welfare Committee','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(201,16,'hero','|| श्री गणेशाय नमः ||','You and your family are cordially invited to celebrate the auspicious Ganeshotsav and seek Bappa’s divine blessings.','{\"heading\": \"Celestial Bal Ganesha & Pastel Joy — Whimsical Family Ganeshotsav\", \"bride_name\": \"\", \"event_type\": \"festival\", \"groom_name\": \"\", \"city_display\": \"Mumbai / Pune / Bengaluru\", \"date_display\": \"September 07 - 17, 2026\"}',NULL,1,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(202,16,'introduction','|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||','निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha illuminate our lives with boundless wisdom, prosperity, and peace.','[]',NULL,2,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(203,16,'countdown','Bappa Aagman Countdown','Counting down the auspicious hours to Ganesh Chaturthi Sthapana','[]',NULL,3,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(204,16,'events','Ganeshotsav Pooja & Aarti Schedule','Join us for sacred aartis, devotional bhajans and mahaprasad','[]',NULL,4,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(205,16,'venue','Mandap Location & Darshan Timings','Devotee guidelines, parking assistance and prasadam counters','{\"address\": \"Lalbaug / Kasba Peth / Indiranagar\", \"landmark\": \"Near Main Temple Gate\", \"venue_name\": \"Shree Ganesh Krupa Mandap\"}',NULL,5,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(206,16,'map','Location & Navigation','Get 1-Tap Google Maps Driving Directions','[]',NULL,6,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(207,16,'dress_code','Festive Attire Guidelines','Traditional Festive Wear: Kurta Pyjama, Dhoti, Silk Saree & Nauvari','{\"guidelines\": \"Bright festive traditional colors (Saffron, Yellow, Magenta, Green). Avoid black attire during pooja rituals.\"}',NULL,7,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(208,16,'rsvp','Darshan & Mahaprasad RSVP','Please let us know your visiting slot and prasad box requirement','[]',NULL,8,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(209,16,'guestbook','Bappa Blessings & Prayers Wall','Leave your Ganesh Chaturthi wishes and prayers for all devotees','[]',NULL,9,1,'2026-09-04 10:15:28','2026-09-04 10:15:28'),
(210,16,'footer','|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||','The Parivar & Devotees Welfare Committee','[]',NULL,10,1,'2026-09-04 10:15:28','2026-09-04 10:15:28');

/*Table structure for table `invitation_share_links` */

DROP TABLE IF EXISTS `invitation_share_links`;

CREATE TABLE `invitation_share_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invitation_id` bigint unsigned NOT NULL,
  `channel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_message` text COLLATE utf8mb4_unicode_ci,
  `clicks_count` bigint unsigned NOT NULL DEFAULT '0',
  `shares_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_share_links_invitation_id_channel_index` (`invitation_id`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_share_links` */

/*Table structure for table `invitation_subcategories` */

DROP TABLE IF EXISTS `invitation_subcategories`;

CREATE TABLE `invitation_subcategories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_subcategories_category_id_slug_unique` (`category_id`,`slug`),
  KEY `invitation_subcategories_category_id_is_active_sort_order_index` (`category_id`,`is_active`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_subcategories` */

insert  into `invitation_subcategories`(`id`,`category_id`,`name`,`slug`,`description`,`sort_order`,`is_active`,`created_at`,`updated_at`) values 
(1,1,'Royal Heritage & Gold Foil','royal-heritage',NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(2,1,'Destination & Beach Vows','beach-destination',NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(3,1,'Pastel Floral Botanical','pastel-floral',NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(4,1,'Modern Minimalist Luxury','modern-minimalist',NULL,4,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(5,2,'1st Birthday Milestones','first-birthday',NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(6,2,'Sweet 16 & 21st Bash','sweet-sixteen',NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(7,2,'Neon Glow & Cocktail Party','cocktail-party',NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(8,2,'Golden 50th & Jubilees','golden-jubilee',NULL,4,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(9,3,'Save The Date Teasers','save-the-date',NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(10,3,'Sangeet & Ring Ceremony','ring-ceremony',NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(11,3,'Rooftop & Sunset Soirée','rooftop-soiree',NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(12,4,'Pastel Dreams & Clouds','pastel-dreams',NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(13,4,'Gender Reveal Countdown','gender-reveal',NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(14,4,'Godh Bharai / Traditional','traditional-baby',NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(15,5,'Silver Jubilee (25 Years)','silver-25th',NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(16,5,'Golden Jubilee (50 Years)','golden-50th',NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(17,6,'Annual Gala & Awards','annual-gala',NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(18,6,'Tech Summit & Keynote','tech-summit',NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(19,6,'Product Launch Party','product-launch',NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(20,7,'Ganesh Chaturthi & Ganeshotsav','ganesh-chaturthi','Grand Sarvajanik and Home Ganeshotsav invitations with aagman to visarjan schedule',1,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(21,7,'Diwali & Lakshmi Pooja','diwali-puja','Auspicious Deepawali and Chopda Pujan invitations',2,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(22,7,'Satyanarayan & Griha Pravesh','satyanarayan','Housewarming and spiritual blessings invitations',3,1,'2026-09-04 09:58:53','2026-09-04 09:58:53');

/*Table structure for table `invitation_template_assets` */

DROP TABLE IF EXISTS `invitation_template_assets`;

CREATE TABLE `invitation_template_assets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `template_id` bigint unsigned NOT NULL,
  `asset_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_template_assets_template_id_foreign` (`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_template_assets` */

/*Table structure for table `invitation_template_sections` */

DROP TABLE IF EXISTS `invitation_template_sections`;

CREATE TABLE `invitation_template_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `template_id` bigint unsigned NOT NULL,
  `section_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_subtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_content` json DEFAULT NULL,
  `default_settings` json DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitation_template_sections_template_id_sort_order_index` (`template_id`,`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_template_sections` */

insert  into `invitation_template_sections`(`id`,`template_id`,`section_type`,`default_title`,`default_subtitle`,`default_content`,`default_settings`,`sort_order`,`is_required`,`created_at`,`updated_at`) values 
(1,1,'hero','Shubh Vivah','Together with our families, we invite you to celebrate the union of',NULL,NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(2,1,'couple','The Couple','Two souls, one sacred journey',NULL,NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(3,1,'introduction','|| Shree Ganeshay Namah ||','With the divine blessings of our ancestors & almighty',NULL,NULL,3,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(4,1,'events','Celebration Itinerary','Join us across three days of joyous festivities',NULL,NULL,4,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(5,1,'timeline','Sacred Milestones','The timeline of events',NULL,NULL,5,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(6,1,'countdown','Counting Down to the Big Day','Every second brings us closer to forever',NULL,NULL,6,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(7,1,'gallery','Moments of Love','Our pre-wedding memories captured in frames',NULL,NULL,7,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(8,1,'music','Ambient Melody','Play Background Shehnai & Sitar Music',NULL,NULL,8,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(9,1,'venue','Royal Venue & Stay','Taj Lake Palace, Udaipur',NULL,NULL,9,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(10,1,'map','Directions & Navigation','Get directions via Google Maps',NULL,NULL,10,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(11,1,'dress_code','Attire & Palette Guidelines','Royal Heritage & Traditional Indian Attire',NULL,NULL,11,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(12,1,'rsvp','Kindly RSVP','Please confirm your gracious presence by November 15',NULL,NULL,12,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(13,1,'guestbook','Warm Blessings & Wishes','Leave your blessings for the newlyweds',NULL,NULL,13,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(14,1,'qr','Instant Digital Pass','Scan at the welcome lounge for expedited check-in',NULL,NULL,14,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(15,1,'contact','Event Coordinators','Reach out to the family hosts for any assistance',NULL,NULL,15,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(16,1,'footer','#PriyaWedsRahul2026','We eagerly await your gracious presence',NULL,NULL,16,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(17,2,'hero','Forever Begins Today','You are cordially invited to celebrate the wedding of',NULL,NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(18,2,'couple','Our Love Story','From college sweethearts to soulmates forever',NULL,NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(19,2,'countdown','Save The Date','Counting down every magical moment',NULL,NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(20,2,'events','Order of Events','The ceremony & twilight garden reception',NULL,NULL,4,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(21,2,'gallery','A Glimpse of Us','Our cherished memories and sunset moments',NULL,NULL,5,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(22,2,'music','Acoustic Serenade','Soft piano & strings soundtrack',NULL,NULL,6,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(23,2,'venue','The Glasshouse Botanical Resort','Bangalore, India',NULL,NULL,7,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(24,2,'map','Google Map Directions','Click to open in Google Maps / Apple Maps',NULL,NULL,8,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(25,2,'rsvp','Will You Join Us?','Kindly respond before December 1st',NULL,NULL,9,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(26,2,'guestbook','Leave a Wish','Write a love note in our digital guestbook',NULL,NULL,10,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(27,2,'footer','#AaravAndTara2026','With love and gratitude',NULL,NULL,11,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(28,3,'hero','Vivaan is Turning ONE!','3.. 2.. 1.. Blast off to our little astronaut’s first orbital birthday!',NULL,NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(29,3,'countdown','Countdown to Launch','Get ready for cake, balloons and interstellar fun',NULL,NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(30,3,'events','Mission Itinerary','Cake cutting, magic show, bouncy castle & dinner',NULL,NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(31,3,'gallery','365 Days of Cuteness','From birth to his first steps',NULL,NULL,4,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(32,3,'venue','Sky Lounge Playhouse','Indiranagar, Bangalore',NULL,NULL,5,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(33,3,'map','Navigation Coordinates','Map link & parking instructions',NULL,NULL,6,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(34,3,'rsvp','Confirm Attendance','Let us know how many mini-astronauts are coming!',NULL,NULL,7,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(35,3,'guestbook','Wishes for Vivaan','Leave a blessing for the birthday star',NULL,NULL,8,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(36,3,'footer','Hosted with love by Rohit & Ananya','See you at the launchpad!',NULL,NULL,9,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(37,4,'hero','Apex Global Summit & Awards 2026','Celebrating leadership, innovation & breakthrough AI engineering',NULL,NULL,1,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(38,4,'introduction','Executive Welcome','An exclusive evening with 500+ industry pioneers',NULL,NULL,2,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(39,4,'timeline','Evening Agenda','Keynote, panel discussions, awards ceremony & cocktail gala',NULL,NULL,3,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(40,4,'venue','The St. Regis Grand Ballroom','Mumbai, India',NULL,NULL,4,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(41,4,'map','Venue Location','Valet parking provided at Main Gate 2',NULL,NULL,5,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(42,4,'dress_code','Attire Protocol','Black Tie / Formal Evening Wear',NULL,NULL,6,0,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(43,4,'rsvp','Delegate Registration','Confirm your seat by October 10 to receive your VIP QR Pass',NULL,NULL,7,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(44,4,'qr','Digital Entry Pass','Present this dynamic QR code at the registration desk for instant badging',NULL,NULL,8,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(45,4,'footer','Apex Innovation Council','All rights reserved 2026',NULL,NULL,9,1,'2026-09-04 07:18:08','2026-09-04 07:18:08'),
(46,5,'hero','|| शुभ विवाह ||','सहकुटुंब सहपरिवार आपले सहर्ष स्वागत असो',NULL,NULL,1,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(47,5,'introduction','|| श्री गणेशाय नमः ||','कुलदैवत व पूर्वजांच्या आशीर्वादाने',NULL,NULL,2,0,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(48,5,'couple','वधू आणि वर','Two lives united in sacred vows',NULL,NULL,3,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(49,5,'events','विवाह सोहळा कार्यक्रम','हळदी, संगीत, साखरपुडा व सप्तपदी विवाह विधी',NULL,NULL,4,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(50,5,'countdown','लग्नघडीची प्रतीक्षा','Counting down to the auspicious Muhurtham',NULL,NULL,5,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(51,5,'venue','मंगल कार्यालय व स्थळ','Grand Heritage Lawns, Pune',NULL,NULL,6,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(52,5,'map','Google Map लोकेशन','Click to navigate to the venue',NULL,NULL,7,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(53,5,'rsvp','उपस्थितीची नोंद (RSVP)','आपल्या उपस्थितीची आगाऊ नोंद करावी ही नम्र विनंती',NULL,NULL,8,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(54,5,'guestbook','आशीर्वाद व शुभेच्छा','वधू-वरांना आपल्या शुभाशीर्वाद संदेश द्या',NULL,NULL,9,0,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(55,5,'footer','निमंत्रक: समस्त परिवार','आपल्या आगमनाची वाट पाहत आहोत',NULL,NULL,10,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(56,6,'hero','Nikaah Mubarak','In the name of Allah, the Most Gracious, the Most Merciful',NULL,NULL,1,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(57,6,'introduction','|| Bismillah-ir-Rahman-ir-Rahim ||','And We created you in pairs (Surah An-Naba 78:8)',NULL,NULL,2,0,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(58,6,'couple','The Bride & Groom','Two hearts united in faith, love, and prayer',NULL,NULL,3,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(59,6,'events','Wedding Itinerary','Mehndi, Nikaah Ceremony & Grand Walima Dawat',NULL,NULL,4,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(60,6,'countdown','Countdown to the Sacred Vows','Counting down every moment of blessings',NULL,NULL,5,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(61,6,'venue','Banquet & Venue','The Royal Palm Manor, Hyderabad',NULL,NULL,6,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(62,6,'map','Venue Directions','Google Map Navigation link',NULL,NULL,7,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(63,6,'rsvp','Kindly RSVP','Please confirm your gracious presence for the Walima Feast',NULL,NULL,8,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(64,6,'guestbook','Duas & Warm Wishes','Share your heartfelt prayers for the couple',NULL,NULL,9,0,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(65,6,'footer','With Best Compliments from Family','JazakAllah Khair for being with us',NULL,NULL,10,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(66,7,'hero','Subha Muhurtham','With the blessings of our elders and the divine grace of the Almighty',NULL,NULL,1,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(67,7,'couple','The Bride & Groom','United in holy matrimony and eternal companionship',NULL,NULL,2,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(68,7,'events','Wedding Festivities','Vratham, Janavasam, Muhurtham & Grand Kalyana Virundhu',NULL,NULL,3,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(69,7,'countdown','Muhurtham Countdown','Auspicious hours approaching',NULL,NULL,4,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(70,7,'venue','Kalyana Mandapam','Mayor Ramanathan Chettiar Hall, Chennai',NULL,NULL,5,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(71,7,'map','Location & Navigation','Direct Google Maps directions',NULL,NULL,6,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(72,7,'rsvp','RSVP & Guest Count','Please let us know your attendance for the traditional feast',NULL,NULL,7,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(73,7,'footer','In Divine Celebration','With warm regards from both families',NULL,NULL,8,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(74,8,'hero','Together Forever','Request the pleasure of your company at our celebration',NULL,NULL,1,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(75,8,'couple','Our Journey','Two paths merging into one horizon',NULL,NULL,2,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(76,8,'events','Schedule','Ceremony, Cocktails & Dinner Party',NULL,NULL,3,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(77,8,'venue','The Glasshouse','Goa Beachfront Resort, India',NULL,NULL,4,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(78,8,'rsvp','RSVP','Kindly respond before November 20',NULL,NULL,5,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(79,8,'footer','#LoveInMinimal','See you there',NULL,NULL,6,1,'2026-09-04 07:53:38','2026-09-04 07:53:38'),
(80,9,'hero','|| श्री गणेशाय नमः ||','You and your family are cordially invited to celebrate the auspicious 10-day Ganeshotsav with us and seek the divine blessings of Lord Ganesha.',NULL,NULL,1,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(81,9,'introduction','|| वक्रतुण्ड महाकाय सूर्यकोटि समप्रभ ||','निर्विघ्नं कुरु मे देव सर्वकार्येषु सर्वदा ॥ May Lord Ganesha bestow immense joy, good health, peace and prosperity upon you and your family.',NULL,NULL,2,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(82,9,'countdown','Bappa Aagman Countdown','Counting down the auspicious hours to Ganesh Chaturthi Sthapana',NULL,NULL,3,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(83,9,'events','Ganeshotsav Itinerary & Aarti Schedule','Join us for the auspicious rituals, daily aartis and mahaprasad',NULL,NULL,4,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(84,9,'venue','Ganeshotsav Mandap & Pandal','Shree Ganesh Krupa Niwas, Lalbaug, Mumbai',NULL,NULL,5,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(85,9,'map','Mandap Location & Navigation','Get Google Maps directions to the Mandap',NULL,NULL,6,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(86,9,'dress_code','Festive Attire Guidelines','Festive Traditional Indian Wear (Kurta Pyjama / Silk Saree)',NULL,NULL,7,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(87,9,'rsvp','Darshan & Mahaprasad RSVP','Kindly let us know your visiting day and family count for Prasad arrangements',NULL,NULL,8,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(88,9,'guestbook','Bappa Blessings & Prayer Wall','Leave your prayers and Ganesh Chaturthi greetings for all devotees',NULL,NULL,9,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(89,9,'music','Aarti & Devotional Stotram','Sukhkarta Dukhharta & Shendur Lal Chadhayo',NULL,NULL,10,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(90,9,'footer','|| गणपती बाप्पा मोरया, पुढच्या वर्षी लवकर या ||','Warm festive regards from our family to yours',NULL,NULL,11,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(91,10,'hero','|| गणपती बाप्पा मोरया ||','आपणास व आपल्या परिवारास गणेशोत्सवाचे सस्नेह निमंत्रण! Join our grand Peshwai Ganeshotsav celebration.',NULL,NULL,1,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(92,10,'introduction','|| सुखकर्ता दुखहर्ता वार्ता विघ्नाची ||','नुरवी पुरवी प्रेम कृपा जयाची ॥ सर्व विघ्नहर्ता गणरायाच्या आगमनानिमित्त आपले व आपल्या परिवाराचे सहर्ष स्वागत.',NULL,NULL,2,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(93,10,'countdown','आगमन सोहळा Countdown','ढोल-ताशांच्या गजरात बाप्पाच्या आगमनाची घटिका समीप',NULL,NULL,3,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(94,10,'events','कार्यक्रम पत्रिका (Schedule)','आगमन मिरवणूक, महाआरती, हळदी-कुंकू व मोदक महाप्रसाद',NULL,NULL,4,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(95,10,'venue','पेशवाई राजवाडा मंडप','Sadashiv Peth, Pune, Maharashtra',NULL,NULL,5,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(96,10,'map','मंडप मार्गदर्शक (Google Map)','Click to open Google Maps navigation',NULL,NULL,6,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(97,10,'dress_code','पारंपरिक पोशाख','Traditional Nauvari / Paithani Saree & Dhoti Kurta with Puneri Feta',NULL,NULL,7,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(98,10,'rsvp','उपस्थिती नोंदणी (RSVP)','महाप्रसाद व दर्शनासाठी आपल्या परिवाराची उपस्थिती नोंदवा',NULL,NULL,8,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(99,10,'guestbook','बाप्पासाठी शुभेच्छा व संदेश','आपल्या शुभेच्छा डिजिटल भित्तीवर लिहा',NULL,NULL,9,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(100,10,'footer','|| मंगलमूर्ती मोरया ||','निमंत्रक: सकल देशपांडे व जोशी परिवार, पुणे',NULL,NULL,10,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(101,11,'hero','? Green Ganeshotsav ?','Welcoming 100% natural clay Bappa into our home with organic flowers, durva grass, and love for Mother Earth.',NULL,NULL,1,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(102,11,'introduction','|| ॐ गं गणपतये नमः ||','Celebrating in harmony with nature. Our clay idol contains indigenous flowering seeds that will blossom into plants after symbolic home immersion.',NULL,NULL,2,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(103,11,'countdown','Eco-Bappa Sthapana Countdown','Counting down to auspicious Ganesh Chaturthi Sthapana',NULL,NULL,3,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(104,11,'events','Eco-Celebration Schedule','Clay Welcome, 21 Durva Arpan, Organic Modak Feast, & Home Garden Visarjan',NULL,NULL,4,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(105,11,'venue','Eco Sanctuary & Garden Courtyard','Palm Grove Residency, Bengaluru',NULL,NULL,5,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(106,11,'map','Location & Navigation','Get directions via Google Maps',NULL,NULL,6,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(107,11,'dress_code','Eco-Chic Handloom Attire','Natural Handloom Cotton, Linen, and Khadi in Earthy Tones',NULL,NULL,7,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(108,11,'rsvp','Eco-Darshan RSVP','Confirm your attendance for the organic satvik Prasad and seed-pot distribution',NULL,NULL,8,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(109,11,'guestbook','Green Pledges & Wishes','Plant an auspicious thought and share your eco-Ganesh wishes',NULL,NULL,9,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(110,11,'footer','Nurture Nature • Seek Bappa Blessings','Warm wishes from our eco-conscious family',NULL,NULL,10,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(111,12,'hero','|| श्री सिद्धि विनायक नमः ||','You are cordially invited to the sacred 108 Times Atharvashirsha Avartan, Havan, and 21 Modak Mahanaivedya.',NULL,NULL,1,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(112,12,'introduction','|| ॐ श्रीम गम सौभाग्य गणपतये वरवरद सर्वजनं मे वशमानय स्वाहा ||','May the divine lord Siddhivinayak eradicate all hurdles from your life and bless you with wisdom, prosperity, and spiritual fulfillment.',NULL,NULL,2,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(113,12,'countdown','Mahapooja Muhurtham Countdown','Counting down to the sacred Mahaganapati Homam & Havan',NULL,NULL,3,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(114,12,'events','Temple Rituals & Havan Schedule','Mahasankalpam, Atharvashirsha Pathan, 21 Modak Naivedya & Karpoor Aarti',NULL,NULL,4,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(115,12,'venue','Shri Siddhivinayak Temple Sanctum','Prabhadevi Temple Complex, Mumbai',NULL,NULL,5,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(116,12,'map','Sanctum Route Map','Access Google Maps directions and parking info',NULL,NULL,6,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(117,12,'dress_code','Temple Pavitra Dress Code','Traditional Silk Dhoti / Angavastram / Kanjeevaram Silk Saree',NULL,NULL,7,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(118,12,'rsvp','Havan Seva & Darshan Booking','Reserve your family slot for the sacred Havan Ahuti and Chhappan Bhog Prasad',NULL,NULL,8,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(119,12,'guestbook','Offer Prayers & Sankalp','Submit your digital flower offering and prayers at Bappa feet',NULL,NULL,9,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(120,12,'footer','|| ॐ शांति शांति शांतिः ||','With the blessings of Almighty Lord Ganesha',NULL,NULL,10,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(121,13,'hero','✨ Bal Ganesha Aagman ✨','Celebrate the sweetest and most joyful festival of the year with our family and adorable Little Bappa!',NULL,NULL,1,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(122,13,'introduction','|| एकदन्ताय विद्महे वक्रतुण्डाय धीमहि तन्नो दन्तिः प्रचोदयात् ||','Sweet as Modak, bright as Diya, joyful as Bal Ganesha! Come sing, pray, eat modaks and celebrate with us.',NULL,NULL,2,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(123,13,'countdown','Modak Party & Aagman Countdown','Getting ready for laddoos, modaks and celebrations',NULL,NULL,3,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(124,13,'events','Celebration & Fun Itinerary','Bappa Welcoming Parade, Kids Bhajan, Modak Making Workshop & Evening Aarti',NULL,NULL,4,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(125,13,'venue','Anand Villa Courtyard & Lawn','Jubilee Hills, Hyderabad',NULL,NULL,5,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(126,13,'map','Directions & Venue Location','Click to open Google Maps navigation',NULL,NULL,6,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(127,13,'dress_code','Bright & Colorful Festive Wear','Sunny Yellows, Vibrant Oranges, Pinks & Festive Kurtas',NULL,NULL,7,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(128,13,'rsvp','Family & Modak RSVP','Let us know how many adults and kids are joining the fun!',NULL,NULL,8,1,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(129,13,'guestbook','Sweet Wishes for Bappa','Write your cheerful festive wishes and favorite modak memories',NULL,NULL,9,0,'2026-09-04 09:58:53','2026-09-04 09:58:53'),
(130,13,'footer','Ganpati Bappa Morya! ✨','Eagerly waiting to celebrate with you',NULL,NULL,10,1,'2026-09-04 09:58:53','2026-09-04 09:58:53');

/*Table structure for table `invitation_templates` */

DROP TABLE IF EXISTS `invitation_templates`;

CREATE TABLE `invitation_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `subcategory_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `thumbnail_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme_config` json DEFAULT NULL,
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `base_price_inr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `base_price_usd` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `view_count` bigint unsigned NOT NULL DEFAULT '0',
  `use_count` bigint unsigned NOT NULL DEFAULT '0',
  `tags` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_templates_slug_unique` (`slug`),
  KEY `invitation_templates_category_id_foreign` (`category_id`),
  KEY `invitation_templates_subcategory_id_foreign` (`subcategory_id`),
  KEY `invitation_templates_is_active_is_featured_created_at_index` (`is_active`,`is_featured`,`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitation_templates` */

insert  into `invitation_templates`(`id`,`category_id`,`subcategory_id`,`name`,`slug`,`description`,`thumbnail_url`,`preview_url`,`theme_config`,`is_premium`,`base_price_inr`,`base_price_usd`,`is_active`,`is_featured`,`view_count`,`use_count`,`tags`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,1,'The Royal Rajwada — Opulent Gold & Emerald Palace','royal-rajwada-palace','Regal traditional Indian wedding invitation featuring majestic palace arches, golden wax seal entrance curtain, peacock motifs, and multi-day itinerary.','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80','/invitations/preview/royal-rajwada-palace','{\"ornament\": \"gold_mandala\", \"bg_gradient\": \"linear-gradient(180deg, #09121d 0%, #064E3B 100%)\", \"accent_color\": \"#F59E0B\", \"primary_color\": \"#D4AF37\", \"envelope_style\": \"wax_seal_royal\", \"animation_style\": \"sparkles_float\", \"secondary_color\": \"#064E3B\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Cinzel Decorative\"}',1,1499.00,19.99,1,1,5,3,'[\"royal\", \"luxury\", \"gold\", \"indian-wedding\", \"traditional\", \"palace\"]','2026-09-04 07:18:08','2026-09-04 09:22:53',NULL),
(2,1,3,'Elysian Bloom — Pastel Lavender & Rose Gold','elysian-bloom-floral','Dreamy watercolor pastel blossoms, floating rose petals, soft romantic serif typography, and an interactive love story timeline.','https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80','/invitations/preview/elysian-bloom-floral','{\"ornament\": \"floral_rose\", \"bg_gradient\": \"linear-gradient(180deg, #181124 0%, #2e1a38 100%)\", \"accent_color\": \"#F472B6\", \"primary_color\": \"#E0A96D\", \"envelope_style\": \"silk_ribbon\", \"animation_style\": \"petals_fall\", \"secondary_color\": \"#201A23\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Playfair Display\"}',1,1199.00,14.99,1,1,0,0,'[\"floral\", \"romantic\", \"pastel\", \"rose-gold\", \"minimalist\", \"garden-wedding\"]','2026-09-04 07:18:08','2026-09-04 07:53:38',NULL),
(3,2,5,'Little Astronaut — 1st Birthday Galaxy Bash','little-astronaut-first-birthday','Magical space adventure themed first birthday invitation with floating rockets, glowing stars, interactive milestone cards and RSVP party count.','https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=800&q=80','/invitations/preview/little-astronaut-first-birthday','{\"ornament\": \"stars_planets\", \"bg_gradient\": \"linear-gradient(180deg, #090d16 0%, #1e1b4b 100%)\", \"accent_color\": \"#FBBF24\", \"primary_color\": \"#38BDF8\", \"envelope_style\": \"space_badge\", \"animation_style\": \"confetti\", \"secondary_color\": \"#0F172A\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Outfit\"}',0,499.00,6.99,1,1,1,0,'[\"birthday\", \"1st-birthday\", \"kids\", \"space\", \"fun\", \"colorful\", \"confetti\"]','2026-09-04 07:18:08','2026-09-04 09:01:32',NULL),
(4,6,17,'Obsidian Zenith — VIP Corporate Gala & Awards','obsidian-zenith-corporate-gala','Ultra-sleek modern dark glassmorphism invite with golden luxury neon accents, keynote speakers, agenda, and instant QR door passes.','https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=800&q=80','/invitations/preview/obsidian-zenith-corporate-gala','{\"ornament\": \"geometric_lines\", \"bg_gradient\": \"linear-gradient(180deg, #030712 0%, #0f172a 100%)\", \"accent_color\": \"#38BDF8\", \"primary_color\": \"#6366F1\", \"envelope_style\": \"executive_metal\", \"animation_style\": \"golden_shimmer\", \"secondary_color\": \"#030712\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Outfit\"}',1,2499.00,29.99,1,1,1,0,'[\"corporate\", \"vip\", \"gala\", \"awards\", \"summit\", \"conference\", \"qr-pass\"]','2026-09-04 07:18:08','2026-09-04 08:57:57',NULL),
(5,1,1,'The Peshwai Heritage — Crimson Velvet & Royal Maratha Gold','peshwai-royal-vivah','Auspicious traditional Marathi wedding invitation with authentic Paithani border designs, Shubh Vivah calligraphy, Shehnai audio, and multi-day Saptapadi festivities.','https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80','/invitations/preview/peshwai-royal-vivah','{\"ornament\": \"gold_mandala\", \"bg_gradient\": \"linear-gradient(180deg, #180306 0%, #580A15 100%)\", \"accent_color\": \"#E11D48\", \"primary_color\": \"#D4AF37\", \"envelope_style\": \"wax_seal_royal\", \"animation_style\": \"golden_shimmer\", \"secondary_color\": \"#580A15\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Cinzel Decorative\"}',1,1299.00,16.99,1,1,0,0,'[\"marathi\", \"royal\", \"traditional\", \"shubh-vivah\", \"gold\", \"paithani\"]','2026-09-04 07:53:38','2026-09-04 07:53:38',NULL),
(6,1,1,'Nikaah Mubarak — Emerald & Ivory Crescent','nikaah-mubarak-crescent','Exquisite Islamic wedding invitation with Mughal arch patterns, Bismillah calligraphy, soft Sufi instrumental audio, and multi-function Walima schedule.','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80','/invitations/preview/nikaah-mubarak-crescent','{\"ornament\": \"islamic_arch\", \"bg_gradient\": \"linear-gradient(180deg, #022018 0%, #064E3B 100%)\", \"accent_color\": \"#34D399\", \"primary_color\": \"#D4AF37\", \"envelope_style\": \"wax_seal_royal\", \"animation_style\": \"sparkles_float\", \"secondary_color\": \"#022C22\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Playfair Display\"}',1,1399.00,17.99,1,1,0,0,'[\"muslim\", \"nikah\", \"walima\", \"islamic\", \"emerald\", \"gold\", \"mughal\"]','2026-09-04 07:53:38','2026-09-04 07:53:38',NULL),
(7,1,1,'Temple Kalyanam — Kanjeevaram Gold & Jasmine','temple-kalyanam-silk','Authentic South Indian wedding invitation inspired by Dravidian temple architecture, golden Kanjeevaram silks, traditional Nadaswaram tunes, and banana leaf feast itinerary.','https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80','/invitations/preview/temple-kalyanam-silk','{\"ornament\": \"temple_gopuram\", \"bg_gradient\": \"linear-gradient(180deg, #1C0F08 0%, #451A03 100%)\", \"accent_color\": \"#F97316\", \"primary_color\": \"#EAB308\", \"envelope_style\": \"wax_seal_royal\", \"animation_style\": \"sparkles_float\", \"secondary_color\": \"#7C2D12\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Cinzel Decorative\"}',1,1299.00,16.99,1,1,0,0,'[\"south-indian\", \"tamil\", \"telugu\", \"kalyanam\", \"temple\", \"gold\", \"traditional\"]','2026-09-04 07:53:38','2026-09-04 07:53:38',NULL),
(8,1,4,'The Minimalist — Champagne Silk & Editorial Chic','modern-minimalist-vows','Ultra-chic contemporary editorial invitation with clean Swiss typography, subtle silk reveal animations, and interactive RSVP.','https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=800&q=80','/invitations/preview/modern-minimalist-vows','{\"ornament\": \"geometric_lines\", \"bg_gradient\": \"linear-gradient(180deg, #090D16 0%, #1E293B 100%)\", \"accent_color\": \"#94A3B8\", \"primary_color\": \"#E2E8F0\", \"envelope_style\": \"silk_ribbon\", \"animation_style\": \"luxury_fade\", \"secondary_color\": \"#0F172A\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Outfit\"}',0,499.00,6.99,1,1,1,0,'[\"minimalist\", \"modern\", \"editorial\", \"chic\", \"clean\", \"destination\"]','2026-09-04 07:53:38','2026-09-04 08:59:49',NULL),
(9,7,20,'Saffron Aura & Lalbaugcha Raja — Divine Kesariya Ganeshotsav','saffron-aura-lalbaug-ganesha','Radiant festive saffron kesariya silk backdrop, glowing golden aura, marigold shower particle physics, aagman to visarjan schedule, and prasad count RSVP.','/images/invitations/ganesh/saffron_lalbaug.jpg','/invitations/preview/saffron-aura-lalbaug-ganesha','{\"ornament\": \"gold_om\", \"bg_gradient\": \"linear-gradient(180deg, #FFF7ED 0%, #FFEDD5 100%)\", \"accent_color\": \"#D97706\", \"primary_color\": \"#EA580C\", \"envelope_style\": \"wax_seal_royal\", \"animation_style\": \"marigold_shower\", \"secondary_color\": \"#FFF7ED\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Cinzel Decorative\"}',1,499.00,11.99,1,1,0,0,'[\"ganesh-chaturthi\", \"saffron\", \"lalbaug\", \"marigold\", \"aarti\", \"puja\", \"traditional\", \"kesariya\"]','2026-09-04 09:58:53','2026-09-04 09:58:53',NULL),
(10,7,20,'Peshwai Dhol-Tasha & Kasba Ganpati — Royal Puneri Ganeshotsav','peshwai-dhol-tasha-ganpati','Royal Maharashtrian Paithani magenta & warm mango gold, peacock feather accents, dhol-tasha pathak energy, floating brass diyas, and authentic Puneri traditions.','/images/invitations/ganesh/peshwai_paithani.jpg','/invitations/preview/peshwai-dhol-tasha-ganpati','{\"ornament\": \"paithani_peacock\", \"bg_gradient\": \"linear-gradient(180deg, #FEF3C7 0%, #FDE68A 100%)\", \"accent_color\": \"#059669\", \"primary_color\": \"#C026D3\", \"envelope_style\": \"wax_seal_royal\", \"animation_style\": \"diya_sparkle\", \"secondary_color\": \"#FEF3C7\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Cinzel Decorative\"}',1,599.00,13.99,1,1,0,0,'[\"peshwai\", \"pune\", \"maharashtrian\", \"paithani\", \"dhol-tasha\", \"kasba-ganpati\", \"marathi\"]','2026-09-04 09:58:53','2026-09-04 09:58:53',NULL),
(11,7,20,'Eco-Friendly Green & Clay Bappa — Sustainable Nature Ganeshotsav','eco-friendly-clay-ganesha','100% natural Shadu Mati clay idol, fresh banana leaves, blooming marigolds, durva grass animations, terracotta deepaks, and home plant visarjan concept.','/images/invitations/ganesh/eco_terracotta.jpg','/invitations/preview/eco-friendly-clay-ganesha','{\"ornament\": \"leaf_durva\", \"bg_gradient\": \"linear-gradient(180deg, #F0FDF4 0%, #DCFCE7 100%)\", \"accent_color\": \"#D97706\", \"primary_color\": \"#15803D\", \"envelope_style\": \"leaf_ribbon\", \"animation_style\": \"durva_jasmine\", \"secondary_color\": \"#F0FDF4\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Playfair Display\"}',0,399.00,8.99,1,1,0,0,'[\"eco-friendly\", \"green\", \"shadu-mati\", \"clay-ganesha\", \"sustainable\", \"nature\", \"organic\"]','2026-09-04 09:58:53','2026-09-04 09:58:53',NULL),
(12,7,20,'Temple Sanctum & Golden Modak — Sacred Marble & Gilded Gold','temple-sanctum-marble-ganesha','Opulent Makrana white marble temple architecture, hanging brass bells, glowing karpoor aarti, 21 modaks, Atharvashirsha chants, and divine halo animations.','/images/invitations/ganesh/marble_temple.jpg','/invitations/preview/temple-sanctum-marble-ganesha','{\"ornament\": \"temple_bell\", \"bg_gradient\": \"linear-gradient(180deg, #FAF8F5 0%, #F5EFEB 100%)\", \"accent_color\": \"#DC2626\", \"primary_color\": \"#B45309\", \"envelope_style\": \"wax_seal_royal\", \"animation_style\": \"temple_bells_aura\", \"secondary_color\": \"#FAF8F5\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Cinzel Decorative\"}',1,699.00,15.99,1,1,0,0,'[\"temple\", \"marble\", \"gold\", \"siddhivinayak\", \"modak\", \"atharvashirsha\", \"puja\", \"sacred\"]','2026-09-04 09:58:53','2026-09-04 09:58:53',NULL),
(13,7,20,'Celestial Bal Ganesha & Pastel Joy — Whimsical Family Ganeshotsav','celestial-bal-ganesha-joy','Cute Bal Ganesha eating laddoos with Mooshak, vibrant fairy lights, colorful torans, lively kids bhajan, festive modak shower, and sweet celebrations.','/images/invitations/ganesh/bal_celebration.jpg','/invitations/preview/celestial-bal-ganesha-joy','{\"ornament\": \"modak_star\", \"bg_gradient\": \"linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%)\", \"accent_color\": \"#38BDF8\", \"primary_color\": \"#EA580C\", \"envelope_style\": \"silk_ribbon\", \"animation_style\": \"marigold_shower\", \"secondary_color\": \"#FFFBEB\", \"font_family_body\": \"Outfit\", \"font_family_heading\": \"Playfair Display\"}',0,399.00,9.99,1,1,4,0,'[\"bal-ganesha\", \"kids\", \"family\", \"pastel\", \"modak\", \"laddoo\", \"joyful\", \"festive\"]','2026-09-04 09:58:53','2026-09-04 10:52:25',NULL);

/*Table structure for table `invitations` */

DROP TABLE IF EXISTS `invitations`;

CREATE TABLE `invitations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `password_protected` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `music_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `music_autoplay` tinyint(1) NOT NULL DEFAULT '0',
  `primary_color` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#D4AF37',
  `secondary_color` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0F172A',
  `accent_color` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#F59E0B',
  `font_family_heading` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Playfair Display',
  `font_family_body` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Outfit',
  `animation_style` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'luxury_fade',
  `custom_domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_css` longtext COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8mb4_unicode_ci,
  `og_image_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selected_features` json DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitations_uuid_unique` (`uuid`),
  UNIQUE KEY `invitations_slug_unique` (`slug`),
  KEY `invitations_template_id_foreign` (`template_id`),
  KEY `invitations_user_id_status_index` (`user_id`,`status`),
  KEY `invitations_slug_index` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invitations` */

insert  into `invitations`(`id`,`uuid`,`user_id`,`template_id`,`title`,`slug`,`cover_image`,`event_date`,`status`,`published_at`,`password_protected`,`music_url`,`music_autoplay`,`primary_color`,`secondary_color`,`accent_color`,`font_family_heading`,`font_family_body`,`animation_style`,`custom_domain`,`custom_css`,`seo_title`,`seo_description`,`og_image_url`,`selected_features`,`expires_at`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'777f55f7-4ae2-4fd5-97db-9afea9c86901',1,1,'The Royal Rajwada — Opulent Gold & Emerald Palace','priya-and-rahul-wedding','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published','2026-09-05 12:17:32',NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#D4AF37','#064E3B','#F59E0B','Cinzel Decorative','Outfit','sparkles_float',NULL,NULL,'The Royal Rajwada — Opulent Gold & Emerald Palace — Digital Invitation Demo','Regal traditional Indian wedding invitation featuring majestic palace arches, golden wax seal entrance curtain, peacock motifs, and multi-day itinerary.',NULL,'[\"rsvp_custom_form\", \"guest_qr_checkin\", \"background_music\", \"photo_gallery_unlimited\", \"multi_event_timeline\", \"ai_copywriter\"]','2027-03-04 07:53:38','2026-09-04 07:18:08','2026-09-05 12:17:32',NULL),
(2,'00293be3-0999-4fbb-bd21-db7dd75f8105',3,1,'The Royal Rajwada — Opulent Gold & Emerald Palace Celebration','the-royal-rajwada-opulent-gold-emerald-palace-h93xuo','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80','2026-11-04 18:00:00','draft',NULL,NULL,NULL,0,'#D4AF37','#064E3B','#F59E0B','Cinzel Decorative','Outfit','sparkles_float',NULL,NULL,NULL,NULL,NULL,'[\"rsvp_custom_form\", \"multi_event_timeline\"]',NULL,'2026-09-04 07:37:30','2026-09-04 07:37:30',NULL),
(3,'8c3439c7-89a9-41d2-a04a-5c063f705d4d',3,1,'Abhishek & Abhi Wedding Celebration','abhishek-abhi-wedding-celebration-adhrob','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80','2026-12-20 18:00:00','draft',NULL,NULL,NULL,0,'#f0bb0f','#07a278','#F59E0B','Cinzel Decorative','Outfit','confetti',NULL,NULL,NULL,NULL,NULL,'[\"rsvp_custom_form\", \"multi_event_timeline\"]',NULL,'2026-09-04 09:18:48','2026-09-04 09:21:19',NULL),
(4,'cdac843b-9c86-40eb-8e16-31c120259fc2',1,1,'Abhishek & Priya Grand Royal Wedding','rahul-priya-wedding-celebration-yxtrf4','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80','2026-12-18 19:00:00','draft',NULL,NULL,NULL,0,'#D4AF37','#580A15','#E11D48','Cinzel Decorative','Outfit','golden_shimmer',NULL,NULL,NULL,NULL,NULL,'[\"rsvp_custom_form\", \"guest_qr_checkin\", \"background_music\", \"photo_gallery_unlimited\", \"multi_event_timeline\", \"ai_copywriter\"]',NULL,'2026-09-04 09:22:53','2026-09-04 09:36:59',NULL),
(5,'a4e7168e-20a2-475e-b5db-7a08e9f472ca',1,9,'Saffron Aura & Lalbaugcha Raja — Divine Kesariya Ganeshotsav','shree-ganeshotsav-2026','/images/invitations/ganesh/saffron_lalbaug.jpg','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#EA580C','#FFF7ED','#D97706','Cinzel Decorative','Outfit','marigold_shower',NULL,NULL,'Saffron Aura & Lalbaugcha Raja — Divine Kesariya Ganeshotsav — Digital Invitation Demo','Radiant festive saffron kesariya silk backdrop, glowing golden aura, marigold shower particle physics, aagman to visarjan schedule, and prasad count RSVP.',NULL,'[\"rsvp_custom_form\", \"guest_qr_checkin\", \"background_music\", \"photo_gallery_unlimited\", \"multi_event_timeline\", \"ai_copywriter\"]','2027-03-04 09:58:53','2026-09-04 09:58:53','2026-09-04 10:15:28',NULL),
(6,'071463c6-b727-4ddb-849d-aeead973a8fe',1,2,'Elysian Bloom — Pastel Lavender & Rose Gold','sample-elysian-bloom-floral','https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#E0A96D','#201A23','#F472B6','Playfair Display','Outfit','petals_fall',NULL,NULL,'Elysian Bloom — Pastel Lavender & Rose Gold — Digital Invitation Demo','Dreamy watercolor pastel blossoms, floating rose petals, soft romantic serif typography, and an interactive love story timeline.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(7,'2b5ca91e-3fe6-4979-bf8a-07cc4202a61a',1,3,'Little Astronaut — 1st Birthday Galaxy Bash','sample-little-astronaut-first-birthday','https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#38BDF8','#0F172A','#FBBF24','Outfit','Outfit','confetti',NULL,NULL,'Little Astronaut — 1st Birthday Galaxy Bash — Digital Invitation Demo','Magical space adventure themed first birthday invitation with floating rockets, glowing stars, interactive milestone cards and RSVP party count.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(8,'65657a72-e426-4298-820f-e64ca136c471',1,4,'Obsidian Zenith — VIP Corporate Gala & Awards','sample-obsidian-zenith-corporate-gala','https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#6366F1','#030712','#38BDF8','Outfit','Outfit','golden_shimmer',NULL,NULL,'Obsidian Zenith — VIP Corporate Gala & Awards — Digital Invitation Demo','Ultra-sleek modern dark glassmorphism invite with golden luxury neon accents, keynote speakers, agenda, and instant QR door passes.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(9,'4f69f9a8-d89f-4353-8d7d-6f739f4f8dd4',1,5,'The Peshwai Heritage — Crimson Velvet & Royal Maratha Gold','sample-peshwai-royal-vivah','https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#D4AF37','#580A15','#E11D48','Cinzel Decorative','Outfit','golden_shimmer',NULL,NULL,'The Peshwai Heritage — Crimson Velvet & Royal Maratha Gold — Digital Invitation Demo','Auspicious traditional Marathi wedding invitation with authentic Paithani border designs, Shubh Vivah calligraphy, Shehnai audio, and multi-day Saptapadi festivities.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(10,'eb83d0b4-ebe2-4223-a23f-d9f4668dd03f',1,6,'Nikaah Mubarak — Emerald & Ivory Crescent','sample-nikaah-mubarak-crescent','https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#D4AF37','#022C22','#34D399','Playfair Display','Outfit','sparkles_float',NULL,NULL,'Nikaah Mubarak — Emerald & Ivory Crescent — Digital Invitation Demo','Exquisite Islamic wedding invitation with Mughal arch patterns, Bismillah calligraphy, soft Sufi instrumental audio, and multi-function Walima schedule.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(11,'337c0ad2-b929-4edc-bb1e-32caf9cd9746',1,7,'Temple Kalyanam — Kanjeevaram Gold & Jasmine','sample-temple-kalyanam-silk','https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#EAB308','#7C2D12','#F97316','Cinzel Decorative','Outfit','sparkles_float',NULL,NULL,'Temple Kalyanam — Kanjeevaram Gold & Jasmine — Digital Invitation Demo','Authentic South Indian wedding invitation inspired by Dravidian temple architecture, golden Kanjeevaram silks, traditional Nadaswaram tunes, and banana leaf feast itinerary.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(12,'16e1bb52-758c-4612-a471-4a4098fc91da',1,8,'The Minimalist — Champagne Silk & Editorial Chic','sample-modern-minimalist-vows','https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=800&q=80','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#E2E8F0','#0F172A','#94A3B8','Outfit','Outfit','luxury_fade',NULL,NULL,'The Minimalist — Champagne Silk & Editorial Chic — Digital Invitation Demo','Ultra-chic contemporary editorial invitation with clean Swiss typography, subtle silk reveal animations, and interactive RSVP.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(13,'2f89d5ae-618f-450f-836a-e91843531378',1,10,'Peshwai Dhol-Tasha & Kasba Ganpati — Royal Puneri Ganeshotsav','sample-peshwai-dhol-tasha-ganpati','/images/invitations/ganesh/peshwai_paithani.jpg','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#C026D3','#FEF3C7','#059669','Cinzel Decorative','Outfit','diya_sparkle',NULL,NULL,'Peshwai Dhol-Tasha & Kasba Ganpati — Royal Puneri Ganeshotsav — Digital Invitation Demo','Royal Maharashtrian Paithani magenta & warm mango gold, peacock feather accents, dhol-tasha pathak energy, floating brass diyas, and authentic Puneri traditions.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(14,'eec9d3ff-fbf5-47ab-9087-cf0f25fc8cf3',1,11,'Eco-Friendly Green & Clay Bappa — Sustainable Nature Ganeshotsav','sample-eco-friendly-clay-ganesha','/images/invitations/ganesh/eco_terracotta.jpg','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#15803D','#F0FDF4','#D97706','Playfair Display','Outfit','durva_jasmine',NULL,NULL,'Eco-Friendly Green & Clay Bappa — Sustainable Nature Ganeshotsav — Digital Invitation Demo','100% natural Shadu Mati clay idol, fresh banana leaves, blooming marigolds, durva grass animations, terracotta deepaks, and home plant visarjan concept.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(15,'ccefe0b2-438a-4727-b570-06c52017a1c3',1,12,'Temple Sanctum & Golden Modak — Sacred Marble & Gilded Gold','sample-temple-sanctum-marble-ganesha','/images/invitations/ganesh/marble_temple.jpg','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#B45309','#FAF8F5','#DC2626','Cinzel Decorative','Outfit','temple_bells_aura',NULL,NULL,'Temple Sanctum & Golden Modak — Sacred Marble & Gilded Gold — Digital Invitation Demo','Opulent Makrana white marble temple architecture, hanging brass bells, glowing karpoor aarti, 21 modaks, Atharvashirsha chants, and divine halo animations.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL),
(16,'e38a349c-4dd0-43b8-a2ff-1061816121ff',1,13,'Celestial Bal Ganesha & Pastel Joy — Whimsical Family Ganeshotsav','sample-celestial-bal-ganesha-joy','/images/invitations/ganesh/bal_celebration.jpg','2026-09-07 09:30:00','published',NULL,NULL,'https://assets.mixkit.co/music/preview/mixkit-serene-view-443.mp3',0,'#EA580C','#FFFBEB','#38BDF8','Playfair Display','Outfit','marigold_shower',NULL,NULL,'Celestial Bal Ganesha & Pastel Joy — Whimsical Family Ganeshotsav — Digital Invitation Demo','Cute Bal Ganesha eating laddoos with Mooshak, vibrant fairy lights, colorful torans, lively kids bhajan, festive modak shower, and sweet celebrations.',NULL,NULL,NULL,'2026-09-04 10:15:28','2026-09-04 10:15:28',NULL);

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_08_24_000001_create_postryx_tables',1),
(5,'2026_08_24_000002_add_agency_features_to_users_table',2),
(6,'2026_08_24_000003_create_blogs_table',3),
(7,'2026_09_04_000001_create_invitation_platform_tables',4),
(8,'2026_09_05_000001_add_published_at_to_invitations_table',5);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `affiliate_id` bigint unsigned DEFAULT NULL,
  `plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_cycle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_gateway` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'razorpay',
  `gateway_order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_payment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_signature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `affiliate_commission_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_commission_credited` tinyint(1) NOT NULL DEFAULT '0',
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_affiliate_id_foreign` (`affiliate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `orders` */

insert  into `orders`(`id`,`order_number`,`user_id`,`affiliate_id`,`plan`,`billing_cycle`,`amount`,`currency`,`discount_amount`,`coupon_code`,`payment_gateway`,`gateway_order_id`,`gateway_payment_id`,`gateway_signature`,`status`,`affiliate_commission_amount`,`is_commission_credited`,`customer_email`,`customer_name`,`customer_phone`,`metadata`,`created_at`,`updated_at`) values 
(1,'ORD-20260824-AKGI9H',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','upi_qr',NULL,NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-24 09:23:21','2026-08-24 09:23:21'),
(2,'ORD-20260824-RTOKVC',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','razorpay','order_277b3c5f90527b8f',NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-24 09:24:13','2026-08-24 09:24:13'),
(3,'ORD-20260824-J2IF27',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','razorpay','order_27e5e068fe49b4d1',NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-24 09:24:16','2026-08-24 09:24:16'),
(4,'ORD-20260824-LBIPOP',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','paypal','0V919405KC831635D',NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-24 09:24:19','2026-08-24 09:24:22'),
(5,'ORD-20260825-FV4LYR',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','razorpay','order_22d2569c5fe21950',NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-25 05:50:15','2026-08-25 05:50:17'),
(6,'ORD-20260825-BIVU4R',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','razorpay','order_04313f1ee56a1fb6',NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-25 05:50:22','2026-08-25 05:50:22'),
(7,'ORD-20260825-AJKTQ4',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','razorpay','order_057050918964cf3b',NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-25 05:50:54','2026-08-25 05:50:54'),
(8,'ORD-20260825-HBD0IU',3,NULL,'pro','monthly',999.50,'INR',999.50,'LAUNCH50','razorpay','order_TTtWGMOIvrzbc2',NULL,NULL,'pending',0.00,0,'abhi14abs@gmail.com','Abhishek Singh',NULL,NULL,'2026-08-25 05:54:53','2026-08-25 05:54:53');

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `referral_clicks` */

DROP TABLE IF EXISTS `referral_clicks`;

CREATE TABLE `referral_clicks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `affiliate_id` bigint unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referrer_url` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `referral_clicks_affiliate_id_foreign` (`affiliate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `referral_clicks` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
  `plan_expires_at` timestamp NULL DEFAULT NULL,
  `credits_remaining` int NOT NULL DEFAULT '5',
  `referred_by_id` bigint unsigned DEFAULT NULL,
  `affiliate_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `brand_workspaces` json DEFAULT NULL,
  `team_members` json DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_affiliate_code_unique` (`affiliate_code`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`role`,`plan`,`plan_expires_at`,`credits_remaining`,`referred_by_id`,`affiliate_code`,`api_token`,`owner_id`,`brand_workspaces`,`team_members`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Postryx Admin','admin@postryx.in',NULL,'$2y$12$rJX6jn09lgPfRt7Yzq8jheMKAPlzlcxJlQSMmtQP2686L4CBtvbKi','admin','lifetime',NULL,999999,NULL,'admin','pst_uSvG26kU0Hc8PioXCQ5nDnWwmf4sHL3Z',NULL,'[{\"id\": \"ws_1\", \"industry\": \"Cloud AI\", \"brand_name\": \"Acme Tech SaaS\", \"created_at\": \"Aug 24, 2026\", \"tone_guidelines\": \"Bold & Technical\"}]','[{\"id\": \"seat_1\", \"name\": \"Sarah Writer\", \"role\": \"creator\", \"email\": \"sarah@agency.com\", \"added_at\": \"Aug 24, 2026\"}]',NULL,'2026-08-24 09:03:24','2026-08-24 09:34:59'),
(2,'Aarav Creator','creator@postryx.in',NULL,'$2y$12$VEoo2pLgTMPxxt0E94Dod.PpVK4Ka5sXS4LSRUTYMbSGUw6LzYqGC','user','pro',NULL,999999,NULL,'creator',NULL,NULL,NULL,NULL,NULL,'2026-08-24 09:03:24','2026-08-24 09:03:24'),
(3,'Abhishek Singh','abhi14abs@gmail.com',NULL,'$2y$12$JFLHGWW8d5Xy4OiGiJLLSOci.ip6U.u69K79ooDswfLvwQU2RUoHG','user','free',NULL,5,NULL,'abhishek-singh-kkfj',NULL,NULL,NULL,NULL,NULL,'2026-08-24 09:22:31','2026-08-24 09:22:31');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
