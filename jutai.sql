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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `generations` */

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_08_24_000001_create_postryx_tables',1),
(5,'2026_08_24_000002_add_agency_features_to_users_table',2),
(6,'2026_08_24_000003_create_blogs_table',3);

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
