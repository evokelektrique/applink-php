-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 23, 2021 at 07:35 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `applink`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `expires` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_persian_ci NOT NULL,
  `word` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM AUTO_INCREMENT=640 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(639, 1624433664, '::1', '314392');

-- --------------------------------------------------------

--
-- Table structure for table `clicks`
--

DROP TABLE IF EXISTS `clicks`;
CREATE TABLE IF NOT EXISTS `clicks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `link_id` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('direct','ptc') COLLATE utf8_persian_ci NOT NULL COMMENT 'ptc = Pay to Click | direct = instant redirect',
  `mode` enum('link','text') COLLATE utf8_persian_ci NOT NULL DEFAULT 'link',
  `amount` int(255) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=193 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

DROP TABLE IF EXISTS `forgot_password`;
CREATE TABLE IF NOT EXISTS `forgot_password` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `status` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `short` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `qrcode` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 = BAD | 1 = OK',
  `type` enum('ptc','direct') COLLATE utf8_persian_ci NOT NULL DEFAULT 'direct' COMMENT 'ptc = Pay to Click | direct = instant redirect',
  `private_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = BAD | 1 = OK',
  `private_password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `button` varchar(255) COLLATE utf8_persian_ci NOT NULL DEFAULT 'مشاهده لینک',
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `text` text COLLATE utf8_persian_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `text` text COLLATE utf8_persian_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = not read | 1 = read',
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `site_description` text COLLATE utf8_persian_ci NOT NULL,
  `site_logo_address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `site_social` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `site_location` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `site_phone_number` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `site_ptc_link_amount` int(10) UNSIGNED NOT NULL,
  `site_ptc_text_amount` int(10) NOT NULL,
  `site_ptc_mode` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = BAD | 1 = OK',
  `site_template` enum('default_template') COLLATE utf8_persian_ci NOT NULL,
  `site_tags` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_description`, `site_logo_address`, `site_social`, `site_location`, `site_phone_number`, `site_ptc_link_amount`, `site_ptc_text_amount`, `site_ptc_mode`, `site_template`, `site_tags`) VALUES
(1, 'اپلینک 2', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد. 2', '666e86c9964d71527727dbcfaeb58da2.png', '@evoke 2', 'ایران - تهران 2', '0987654321 2', 1012, 1533, 1, 'default_template', 'لورم, لورم اپیزوم 2');

-- --------------------------------------------------------

--
-- Table structure for table `shorts`
--

DROP TABLE IF EXISTS `shorts`;
CREATE TABLE IF NOT EXISTS `shorts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `linked_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('link','text') COLLATE utf8_persian_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `texts`
--

DROP TABLE IF EXISTS `texts`;
CREATE TABLE IF NOT EXISTS `texts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `text` text COLLATE utf8_persian_ci NOT NULL,
  `short` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `qrcode` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0 = BAD | 1 = OK	',
  `type` enum('ptc','direct') COLLATE utf8_persian_ci NOT NULL DEFAULT 'direct' COMMENT '	ptc = Pay to Click | direct = instant redirect',
  `private_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 = BAD | 1 = OK	',
  `private_password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `button` varchar(255) COLLATE utf8_persian_ci NOT NULL DEFAULT 'مشاهده متن',
  `text_mode` enum('plain','code') COLLATE utf8_persian_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1005 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` bigint(20) UNSIGNED NOT NULL,
  `user_ip` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `pay_status` int(10) UNSIGNED NOT NULL COMMENT '0 = BAD | 1 = OK',
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `bankaddress` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `verified_email` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `role` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 = normal user | 1 = admin',
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='Membership';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `phone`, `bankaddress`, `verified_email`, `status`, `role`, `created_at`, `modified_at`) VALUES
(1, 'evoke', 'email@gmail.com', 'e38836201c359983688241adc6398a5e79a177342718bb2ae3185c2b718a8f0e35f3794b61af6ea0d8e6cd09c5482fd9447dec6020250a9ce743259cdca998a6qlgZgqDqqbghcQslzj0qj7pU4Zgzad3O4AM9eSil7Lo=', 'آزمایش نام', '09000000000', 'IR01 1234 5678 0123 4567 8901 23', 0, 1, 1, '2021-06-22 23:19:41', '');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

DROP TABLE IF EXISTS `wallet`;
CREATE TABLE IF NOT EXISTS `wallet` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `modified_at` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `user_id`, `amount`, `created_at`, `modified_at`) VALUES
(1, 1, 0, '2021-06-22 23:19:41', '2021-06-22 23:19:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
