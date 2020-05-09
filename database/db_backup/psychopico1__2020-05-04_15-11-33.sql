-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 04, 2020 at 03:11 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psychopico1`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 2),
(4, '2020_04_27_081222_add_username_to_table_user', 2),
(5, '2020_04_27_081222_add_isactive_to_table_user', 3),
(6, '2020_04_28_051334_create_permission_tables', 4),
(7, '2020_04_28_051400_create_products_table', 5),
(8, '2020_05_02_095700_create_preferences_table', 6),
(9, '2020_05_03_122959_create_paginations_table', 7),
(10, '2020_05_03_122959_create_registeredpages_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 2),
(1, 'App\\User', 3),
(1, 'App\\User', 24),
(1, 'App\\User', 25),
(1, 'App\\User', 26),
(1, 'App\\User', 29),
(2, 'App\\User', 2),
(2, 'App\\User', 22),
(2, 'App\\User', 24),
(2, 'App\\User', 28),
(2, 'App\\User', 30),
(2, 'App\\User', 31),
(4, 'App\\User', 2),
(4, 'App\\User', 23),
(4, 'App\\User', 24),
(4, 'App\\User', 26),
(4, 'App\\User', 27),
(5, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `paginations`
--

DROP TABLE IF EXISTS `paginations`;
CREATE TABLE IF NOT EXISTS `paginations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `per_page` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paginations`
--

INSERT INTO `paginations` (`id`, `per_page`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 10, '2020-05-03 05:51:41', '2020-05-03 05:51:41', NULL),
(2, 50, '2020-05-03 05:51:55', '2020-05-03 05:51:55', NULL),
(3, 100, '2020-05-03 05:52:02', '2020-05-03 05:52:02', NULL),
(4, 20, '2020-05-03 05:52:28', '2020-05-03 05:52:28', NULL),
(10, 200, '2020-05-03 17:15:16', '2020-05-03 17:25:28', '2020-05-03 17:25:28'),
(11, 300, '2020-05-03 17:15:32', '2020-05-03 17:25:24', '2020-05-03 17:25:24'),
(12, 400, '2020-05-03 17:15:37', '2020-05-04 13:21:44', '2020-05-04 13:21:44'),
(13, 500, '2020-05-03 17:15:44', '2020-05-03 17:25:15', '2020-05-03 17:25:15'),
(14, 600, '2020-05-03 17:15:48', '2020-05-03 17:25:11', '2020-05-03 17:25:11'),
(15, 700, '2020-05-03 17:15:52', '2020-05-03 17:25:06', '2020-05-03 17:25:06'),
(16, 800, '2020-05-03 17:15:58', '2020-05-03 17:24:28', '2020-05-03 17:24:28'),
(17, 901, '2020-05-03 17:16:06', '2020-05-03 17:16:40', '2020-05-03 17:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('yohanes.pajero@gmail.com', '$2y$10$DNdN7PEadEFW/bhn8K14b.SNkcQ5X4FRiLChDTUO9t/C0lHY.4LVm', '2020-04-27 01:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'config-view', 'web', '2020-04-28 00:16:09', '2020-04-28 06:33:05', NULL),
(2, 'config-create', 'web', '2020-04-28 00:16:09', '2020-04-28 06:44:39', NULL),
(3, 'config-edit', 'web', '2020-04-28 00:16:09', '2020-04-28 06:32:50', NULL),
(4, 'config-delete', 'web', '2020-04-28 00:16:09', '2020-04-28 06:32:41', NULL),
(13, 'content-view', 'web', '2020-04-28 07:07:38', '2020-04-28 07:07:38', NULL),
(12, 'ref-view', 'web', '2020-04-28 07:03:48', '2020-04-28 07:03:48', NULL),
(14, 'core-setting-view', 'web', '2020-04-28 07:12:58', '2020-04-28 07:12:58', NULL),
(15, 'deleted-view', 'web', '2020-04-29 00:46:19', '2020-04-30 17:17:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

DROP TABLE IF EXISTS `preferences`;
CREATE TABLE IF NOT EXISTS `preferences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `search_panel_collapsed` tinyint(1) DEFAULT NULL,
  `sidebar_toggled` tinyint(1) DEFAULT NULL,
  `sidebar_item_collapsed` tinyint(1) DEFAULT NULL,
  `sidebar_item_collapsed_index` int(1) DEFAULT NULL,
  `table_row_per_page` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preferences_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `user_id`, `search_panel_collapsed`, `sidebar_toggled`, `sidebar_item_collapsed`, `sidebar_item_collapsed_index`, `table_row_per_page`, `created_at`, `updated_at`) VALUES
(6, 2, 1, 0, 0, 0, 50, '2020-05-04 10:18:29', '2020-05-04 13:22:32');

-- --------------------------------------------------------

--
-- Table structure for table `registeredpages`
--

DROP TABLE IF EXISTS `registeredpages`;
CREATE TABLE IF NOT EXISTS `registeredpages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SA', 'web', '2020-04-27 17:00:00', NULL),
(2, 'Admin', 'web', '2020-04-28 00:36:19', '2020-04-28 00:36:19'),
(4, 'MA', 'web', '2020-04-28 07:08:25', '2020-04-28 07:08:25'),
(5, 'Content Creator', 'web', '2020-04-28 07:09:40', '2020-04-28 07:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 1),
(2, 4),
(3, 1),
(3, 4),
(4, 1),
(4, 4),
(12, 1),
(12, 2),
(12, 4),
(13, 1),
(13, 2),
(13, 4),
(13, 5),
(14, 4),
(15, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `is_active`) VALUES
(2, 'Yohan', 'yohanes.pajero', 'yohanes.pajero@gmail.com', NULL, '$2y$10$6McPxSY/HV6GgNQ8mYjxNuLOo/c4oTvjyY2Eo81k0fn6DPQAdK83q', 'xqe8HdB8dPRMltqdOapJxQ3VC0fopsc8R453yDgyfJqZvheSgo7RWY3Datkn', '2020-04-27 01:22:44', '2020-04-29 21:59:16', NULL, 1),
(3, 'Elisabeth WK', 'ibeth', 'elisabeth.widati@gmail.com', NULL, '$2y$10$Ax35GvFwCF73mQIegZgvvejJBxlm00ypf9qgQ7R3f.Gfbp62ss1Yq', 'KzRmWKF5tg9HP2rSJRp45DKD1s46DM647cakG8bIjIYxi5INBq7sSK9HOXlE', '2020-04-27 01:37:51', '2020-05-02 16:05:26', NULL, 1),
(26, 'parto', '444', '444@gmail.com', NULL, '$2y$10$ld6ALhKdDNDt2HzdxLFMCu3ixyKP5/Ff2vizNpH.9EJwYjxGQoqp6', NULL, '2020-05-01 17:13:40', '2020-05-02 11:32:55', NULL, 1),
(24, 'becak', '222', '222@gmail.com', NULL, '$2y$10$BQqTX/qnasp9rb5EI/6aTey.BZsrO4uO/1yOnGCkI/KkKlQkCQ0lS', NULL, '2020-05-01 17:09:38', '2020-05-03 06:38:28', '2020-05-03 06:38:28', 1),
(25, 'gading', '333', '333@gmail.com', NULL, '$2y$10$1w/oGSMP4r6lN93nwa60yeHT4TYd97/bknxmiyNgZykzj8Hdzz4NK', NULL, '2020-05-01 17:13:15', '2020-05-02 11:33:05', NULL, 1),
(22, '555', '555', '555@gmail.com', NULL, '$2y$10$f6gloI9JMtnNNJvHM5bsK.AX4C7jH7vdhny9BWszWd3uL8ht7DpDq', NULL, '2020-05-01 09:30:19', '2020-05-01 10:36:30', '2020-05-01 10:36:30', 0),
(23, '111', '111', '111@gmail.com', NULL, '$2y$10$p7vaYTXNwyLV3/sZTYYkquWncpBsC8MYOk1lTnqUZML5ntYhANy8u', NULL, '2020-05-01 15:41:12', '2020-05-01 15:43:38', '2020-05-01 15:43:38', 0),
(27, 'saiten', '666', '666@gmail.com', NULL, '$2y$10$TetvM2Dh7Aph6A5S1ibklOiRq9tBIITo/Msk/0h1ApzqS2QcsMegO', NULL, '2020-05-01 17:14:09', '2020-05-02 11:32:48', NULL, 1),
(28, 'jumi', '777', '777@gmail.com', NULL, '$2y$10$bEmsgcomgBctGE7FtqsYAeJX/yU1ouYDD.YlxXNtquPRF/nw56GIK', NULL, '2020-05-01 17:14:39', '2020-05-02 11:32:41', NULL, 1),
(29, 'Yohanes Pajero Hadi', '888', '888@gmail.com', NULL, '$2y$10$qBJD5tsP/9ZfZVRW7aLFwOiY9C5nIxgEWTMcPQIjlanjWDL74RU8q', NULL, '2020-05-01 17:15:00', '2020-05-01 17:15:00', NULL, 1),
(30, 'gugun', '999', '999@gmail.com', NULL, '$2y$10$MBMb9zNIgwGhCP54tKDoT.U/e6AzrmF9ab9zBgrUaSR/kwQ2pPlLS', NULL, '2020-05-01 17:15:18', '2020-05-02 12:19:51', NULL, 0),
(31, 'ggg', 'ggg', 'ggg@ggg.com', NULL, '$2y$10$cJexiOxKSMiOdJohZxmHn.oSpJ.QXNg3yhT//qBwO4PsXaGK.XM.C', NULL, '2020-05-02 10:17:24', '2020-05-02 19:39:34', '2020-05-02 19:39:34', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
