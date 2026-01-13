-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2026 at 04:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tipsapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_codes`
--

CREATE TABLE `access_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `tip_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `used_by` bigint(20) UNSIGNED DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `access_codes`
--

INSERT INTO `access_codes` (`id`, `code`, `tip_id`, `created_by`, `is_used`, `used_by`, `used_at`, `created_at`, `updated_at`) VALUES
(1, 'rgFzQvG6wlma', 3, 7, 1, 3, '2026-01-12 19:32:05', '2026-01-12 19:27:55', '2026-01-12 19:32:05'),
(2, 'r6oFS4RFWvB9', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(3, 'S2xVieqWX7Or', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(4, 'iWdbCKkkwB3t', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(5, '4BEPVpsESH4C', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(6, 'tOBl62247zHS', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(7, 'gFvZYMDo4fVu', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(8, 'PVFlrW7ewP09', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(9, 'aJBCfV7O7Ku4', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55'),
(10, 'pz43wxOZhLo5', 3, 7, 0, NULL, NULL, '2026-01-12 19:27:55', '2026-01-12 19:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `title`, `body`, `link`, `image_path`, `is_active`, `starts_at`, `ends_at`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'see', NULL, NULL, 'ads/KU0U9i0jsiLc4xY6egt5si1rEtcGhsSlvQGJ8nDD.png', 1, NULL, NULL, 1, '2026-01-04 15:00:17', '2026-01-04 15:00:17'),
(4, 'see', NULL, NULL, 'ads/MuhIxutLNBXY0krr3UKnxLtHwVYcaJ7mbBwjCj9O.png', 1, NULL, NULL, 1, '2026-01-04 15:00:38', '2026-01-04 15:00:38'),
(5, 'see', NULL, NULL, 'ads/f5kF97jZpLiyiubjJ0sHhjKpQv3BGgInbLXBkF1b.png', 1, NULL, NULL, 1, '2026-01-04 15:01:00', '2026-01-04 15:01:00'),
(6, 'see', NULL, NULL, 'ads/ci8mwt4h7h92Y8X9A83YBBSub70KyyyV3YwdQbHy.mp4', 1, NULL, NULL, 1, '2026-01-04 16:39:42', '2026-01-04 16:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_04_000001_add_phone_and_role_to_users_table', 2),
(5, '2026_01_04_000002_create_ads_table', 3),
(6, '2026_01_04_000003_create_role_changes_table', 4),
(7, '2026_01_04_222115_create_tips_table', 5),
(8, '2026_01_04_223938_add_additional_fields_to_tips_table', 6),
(9, '2026_01_04_232501_add_validity_time_to_tips_table', 7),
(10, '2026_01_05_091439_create_user_follows_and_ratings_tables', 8),
(11, '2026_01_05_100810_add_profile_picture_to_users_table', 9),
(12, '2026_01_09_153906_create_notifications_table', 10),
(13, '2026_01_09_153926_create_notification_user_table', 10),
(14, '2026_01_12_215431_create_access_codes_table', 11),
(15, '2026_01_13_145316_create_tipster_applications_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'all pepople your anoused to be cool', 'wapendwa mnakaribushwa kwnye iddy mossi keshoo mjinishule b dskxcnz mlvfbjckxiugvjkdbsclkx.mv nk,smdbcxzjvn kdlmzcbxv lkkmbkldz,nxc vkjhnmbsd lkxzbv  sdxkjvb kmsd;lk.bx zvkhjbnwdsjzxv,bndkslmbznlJVM ;dls,nzLXV:kb sdhcZbxn', 1, '2026-01-09 13:15:42', '2026-01-09 13:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `notification_user`
--

CREATE TABLE `notification_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_user`
--

INSERT INTO `notification_user` (`id`, `notification_id`, `user_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-01-09 13:15:42', '2026-01-09 13:19:50'),
(2, 1, 2, 0, '2026-01-09 13:15:42', '2026-01-09 13:15:42'),
(3, 1, 3, 0, '2026-01-09 13:15:42', '2026-01-09 13:15:42'),
(4, 1, 4, 1, '2026-01-09 13:15:42', '2026-01-13 11:39:38'),
(5, 1, 5, 1, '2026-01-09 13:15:42', '2026-01-12 15:16:21'),
(6, 1, 6, 0, '2026-01-09 13:15:42', '2026-01-09 13:15:42'),
(7, 1, 7, 1, '2026-01-09 13:15:42', '2026-01-13 11:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('fbenson373@gmail.com', '$2y$12$0eAzuiZOoMX8PVNsIrS6FugzgZJCMEh20An.gFm5vYI49oX7S21Nq', '2026-01-04 13:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `role_changes`
--

CREATE TABLE `role_changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `actor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_role` varchar(255) DEFAULT NULL,
  `new_role` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_changes`
--

INSERT INTO `role_changes` (`id`, `user_id`, `actor_id`, `old_role`, `new_role`, `reason`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'user', 'tipster', NULL, '2026-01-04 16:22:06', '2026-01-04 16:22:06'),
(2, 5, 1, 'user', 'tipster', NULL, '2026-01-06 13:42:01', '2026-01-06 13:42:01'),
(3, 7, 1, 'user', 'tipster', NULL, '2026-01-06 13:42:10', '2026-01-06 13:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qNEz69Xe5td176seV783ME5mbXP7sGcCgPXQy4BC', 6, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/17.5 Mobile/15A5370a Safari/602.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVndmYXJlYlBSQmNiWWJTcnljMXllamMzMjU3bWxZWlB3dnU1SU1BSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90aXBzIjtzOjU6InJvdXRlIjtzOjEwOiJ0aXBzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1768316995);

-- --------------------------------------------------------

--
-- Table structure for table `tips`
--

CREATE TABLE `tips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `bet_code` varchar(255) DEFAULT NULL,
  `odds` decimal(8,2) DEFAULT NULL,
  `stake` int(11) DEFAULT NULL,
  `tip_type` enum('free','locked','premium') NOT NULL DEFAULT 'free',
  `price` decimal(10,2) DEFAULT NULL,
  `validity_time` int(11) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tips`
--

INSERT INTO `tips` (`id`, `title`, `company`, `bet_code`, `odds`, `stake`, `tip_type`, `price`, `validity_time`, `body`, `link`, `image_path`, `is_active`, `starts_at`, `ends_at`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'sure ODDS', 'helabet', 'HQGRU', 4.60, 1, 'free', NULL, NULL, 'BEST ANY TIME', NULL, 'tips/MMgMMIEEOrLIlWPrQvSOmz8qvfZVPHoHcJUpgLG8.jpg', 1, '2026-01-05 12:48:00', NULL, 2, '2026-01-04 19:49:00', '2026-01-04 19:49:00'),
(2, 'weekend special', 'sportpesa', 'SPKDKHNS', 9.80, 1, 'premium', 5000.00, 1767966618, 'KILA wakati ni bingotu guys', NULL, 'tips/nloEaYOvfuDLooEnrMaSH83mtkbc4JZYcRjtiNuC.jpg', 1, '2026-01-23 19:50:00', NULL, 2, '2026-01-09 10:49:51', '2026-01-09 10:49:51'),
(3, 'january special', 'sportpesa', 'ewfrtry', 8.10, 4, 'premium', 580.00, 1768257234, 'be homber', NULL, 'tips/odAzJKxFgw5Q6mfnhDFviPnXHWxJObGkrS5HilU6.jpg', 1, '2026-01-22 14:30:00', NULL, 7, '2026-01-12 19:27:54', '2026-01-12 19:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `tipster_applications`
--

CREATE TABLE `tipster_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bio` text NOT NULL,
  `contact` varchar(255) NOT NULL,
  `experience` int(11) NOT NULL,
  `sports` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tipster_applications`
--

INSERT INTO `tipster_applications` (`id`, `user_id`, `bio`, `contact`, `experience`, `sports`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'ETRFSYDGFHGH;M. MMVCGVHB NJYGHJNMFV  FHDXYKCGLVHBJKNLM;\'BHVG', '0762184101', 3, 'other', 'rejected', '2026-01-13 12:03:38', '2026-01-13 12:05:29'),
(2, 4, 'UGHJGBJNDFCGVHBIDFGHBJNKMLEXTCYVGBUHJNIKM', '0762184101', 4, 'other', 'approved', '2026-01-13 12:06:05', '2026-01-13 12:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `tip_ratings`
--

CREATE TABLE `tip_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tip_id` bigint(20) UNSIGNED NOT NULL,
  `rating` enum('win','loss','pending') NOT NULL DEFAULT 'pending',
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `role`, `profile_picture`) VALUES
(1, 'Frank Benson', 'fbenson373@gmail.com', NULL, '$2y$12$C8RwPnytp746FkgrMGqdEuZJDoEl/vTPpYqB6GkGHTZT/JjmSD3Mq', NULL, '2026-01-04 13:00:20', '2026-01-04 13:00:20', NULL, 'admin', NULL),
(2, 'Benson Frank', 'fbenson374@gmail.com', NULL, '$2y$12$CJlJDIOzC9xRgdkl4SJLP.WajXYltUdMNqzoF3DJI2A2eDXALesLS', NULL, '2026-01-04 13:27:33', '2026-01-04 16:22:06', '0742610845', 'tipster', NULL),
(3, 'France Benson', 'fbenson375@gmail.com', NULL, '$2y$12$EfwwwKji2yAeU7tLM48/2O7Rp9fCkQesxkrJ11OcmCEUMbjiGaI2u', NULL, '2026-01-04 14:16:36', '2026-01-04 14:16:36', '0616588114', 'user', NULL),
(4, 'sura', 'fbenson376@gmail.com', NULL, '$2y$12$DOKZXwVHeyGqfVyxxlEiMONIzt3WstzMs6N6FnHtEYU3.CeNQdo.G', NULL, '2026-01-06 13:36:01', '2026-01-13 12:06:28', '0762184101', 'tipster', 'profile_pictures/KeYDMRfPw21vxuWcQbxwGVqYx5wIIdzFzjklr9b6.jpg'),
(5, 'brayan roland', 'fbenson377@gmail.com', NULL, '$2y$12$blawxoLBTYPanZdtUqXijOqGpVVBjyyrLe7ourZYhuAhW8sjYHpoi', NULL, '2026-01-06 13:37:56', '2026-01-06 13:42:00', '0757866939', 'tipster', 'profile_pictures/QjCbYfW56sBj8RpeENQsJZRqQH5vzSHM70oFe2NT.jpg'),
(6, 'david makuri', 'fbenson378@gmail.com', NULL, '$2y$12$q6u5Vp5VlHvr5Hetd2RyTO2/EFJnL3nBp4wjmwNSBmd7TT5SYTjjy', NULL, '2026-01-06 13:39:10', '2026-01-06 13:39:26', '2356789009', 'user', 'profile_pictures/ndPQbHkPg8bm7f0eK5pXFAOhZe6sJR3q3nyTKEVq.png'),
(7, 'dar store', 'fbenson379@gmail.com', NULL, '$2y$12$RdburggzGU6BmxNxTZR3XO/mVLIkriEFi9nHbdQIv0p875U8fR4oC', NULL, '2026-01-06 13:40:13', '2026-01-06 13:42:10', '255658297159', 'tipster', 'profile_pictures/gFxqvPm9m7ErSoFdwFlhUomm3k0qzCNYvrCjcYL4.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_follows`
--

CREATE TABLE `user_follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `followed_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_follows`
--

INSERT INTO `user_follows` (`id`, `follower_id`, `followed_id`, `created_at`, `updated_at`) VALUES
(1, 6, 7, '2026-01-09 13:28:18', '2026-01-09 13:28:18'),
(2, 6, 5, '2026-01-09 13:28:22', '2026-01-09 13:28:22'),
(3, 6, 2, '2026-01-09 13:28:24', '2026-01-09 13:28:24'),
(4, 7, 2, '2026-01-13 09:39:04', '2026-01-13 09:39:04'),
(5, 7, 5, '2026-01-13 09:39:18', '2026-01-13 09:39:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_codes`
--
ALTER TABLE `access_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `access_codes_code_unique` (`code`),
  ADD KEY `access_codes_tip_id_foreign` (`tip_id`),
  ADD KEY `access_codes_created_by_foreign` (`created_by`),
  ADD KEY `access_codes_used_by_foreign` (`used_by`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ads_created_by_foreign` (`created_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_created_by_foreign` (`created_by`);

--
-- Indexes for table `notification_user`
--
ALTER TABLE `notification_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notification_user_notification_id_user_id_unique` (`notification_id`,`user_id`),
  ADD KEY `notification_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `role_changes`
--
ALTER TABLE `role_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_changes_user_id_foreign` (`user_id`),
  ADD KEY `role_changes_actor_id_foreign` (`actor_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tips`
--
ALTER TABLE `tips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tips_created_by_foreign` (`created_by`);

--
-- Indexes for table `tipster_applications`
--
ALTER TABLE `tipster_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipster_applications_user_id_foreign` (`user_id`);

--
-- Indexes for table `tip_ratings`
--
ALTER TABLE `tip_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tip_ratings_user_id_tip_id_unique` (`user_id`,`tip_id`),
  ADD KEY `tip_ratings_tip_id_foreign` (`tip_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_follows_follower_id_followed_id_unique` (`follower_id`,`followed_id`),
  ADD KEY `user_follows_followed_id_foreign` (`followed_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_codes`
--
ALTER TABLE `access_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification_user`
--
ALTER TABLE `notification_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_changes`
--
ALTER TABLE `role_changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tips`
--
ALTER TABLE `tips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipster_applications`
--
ALTER TABLE `tipster_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tip_ratings`
--
ALTER TABLE `tip_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_follows`
--
ALTER TABLE `user_follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_codes`
--
ALTER TABLE `access_codes`
  ADD CONSTRAINT `access_codes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `access_codes_tip_id_foreign` FOREIGN KEY (`tip_id`) REFERENCES `tips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `access_codes_used_by_foreign` FOREIGN KEY (`used_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_user`
--
ALTER TABLE `notification_user`
  ADD CONSTRAINT `notification_user_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_changes`
--
ALTER TABLE `role_changes`
  ADD CONSTRAINT `role_changes_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `role_changes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tips`
--
ALTER TABLE `tips`
  ADD CONSTRAINT `tips_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tipster_applications`
--
ALTER TABLE `tipster_applications`
  ADD CONSTRAINT `tipster_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tip_ratings`
--
ALTER TABLE `tip_ratings`
  ADD CONSTRAINT `tip_ratings_tip_id_foreign` FOREIGN KEY (`tip_id`) REFERENCES `tips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tip_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD CONSTRAINT `user_follows_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
