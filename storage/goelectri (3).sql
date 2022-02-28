-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2021 at 02:54 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goelectri`
--

-- --------------------------------------------------------

--
-- Table structure for table `charging_stations`
--

CREATE TABLE `charging_stations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `state_ary` text COLLATE utf8mb4_unicode_ci,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `city_ary` text COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `open_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `close_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_ary` text COLLATE utf8mb4_unicode_ci,
  `station_type` int(11) NOT NULL DEFAULT '0',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `charging_stations`
--

INSERT INTO `charging_stations` (`id`, `name`, `description`, `state_id`, `state_ary`, `city_id`, `city_ary`, `address`, `city`, `lat`, `lng`, `open_time`, `close_time`, `days`, `image`, `status`, `slug`, `user_id`, `user_ary`, `station_type`, `email`, `mobile`, `phone_no`, `deleted_at`, `created_at`, `updated_at`) VALUES
(10, 'sd1', 'To avoid SSL warnings during Plesk login, use https://affectionate-colden.77-68-122-147.plesk.page:8443 To avoid SSL warnings during Plesk login, use https://affectionate-colden.77-68-122-147.plesk.page:8443 To avoid SSL warnings during Plesk login, use https://affectionate-colden.77-68-122-147.plesk.page:8443 To avoid SSL warnings during Plesk login, use https://affectionate-colden.77-68-122-147.plesk.page:8443 To avoid SSL warnings during Plesk login, use https://affectionate-colden.77-68-122-147.plesk.page:8443 To avoid SSL warnings during Plesk login, use https://affectionate-colden.77-68-122-147.plesk.page:8443', 3, '{\"id\":3,\"name\":\"Haryana\",\"slug\":\"haryana\"}', 1, '{\"id\":1,\"name\":\"Sirsa\",\"slug\":\"sirsa-haryana\"}', 'Jaipur International Airport, Airport Road, Sanganer, Jaipur, Rajasthan, India', 'Jaipur', '26.8289443', '75.8056178', '12:59', '12:58', 6, NULL, 1, '14051595-sd1', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile_code\":null,\"mobile\":null}', 2, 'dasd@gmail.com', '7800000000', NULL, NULL, '2021-06-22 01:04:33', '2021-07-08 03:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `charging_station_connectors`
--

CREATE TABLE `charging_station_connectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `charging_station_id` bigint(20) UNSIGNED NOT NULL,
  `connector_id` bigint(20) UNSIGNED NOT NULL,
  `connector_ary` text COLLATE utf8mb4_unicode_ci,
  `qty` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `charging_station_connectors`
--

INSERT INTO `charging_station_connectors` (`id`, `charging_station_id`, `connector_id`, `connector_ary`, `qty`, `created_at`, `updated_at`) VALUES
(65, 10, 2, '{\"id\":2,\"name\":\"BEVC-AC001\",\"description\":null,\"slug\":\"bevc-ac001\",\"qty\":0}', 0, '2021-07-08 03:03:25', '2021-07-08 03:03:25'),
(66, 10, 5, '{\"id\":5,\"name\":\"AC-Type-2\",\"description\":null,\"slug\":\"ac-type-2\",\"qty\":\"15\"}', 15, '2021-07-08 03:03:25', '2021-07-08 03:03:25'),
(67, 10, 6, '{\"id\":6,\"name\":\"CCS-1\",\"description\":null,\"slug\":\"ccs-1\",\"qty\":\"17\"}', 17, '2021-07-08 03:03:25', '2021-07-08 03:03:25'),
(68, 10, 7, '{\"id\":7,\"name\":\"CCS-2\",\"description\":null,\"slug\":\"ccs-2\",\"qty\":\"20\"}', 20, '2021-07-08 03:03:25', '2021-07-08 03:03:25'),
(69, 10, 9, '{\"id\":9,\"name\":\"BEVC-DC-001GB\\/T\",\"description\":null,\"slug\":\"bevc-dc-001gbt\",\"qty\":\"16\"}', 16, '2021-07-08 03:03:25', '2021-07-08 03:03:25'),
(70, 10, 10, '{\"id\":10,\"name\":\"TESLA\",\"description\":null,\"slug\":\"tesla\",\"qty\":0}', 0, '2021-07-08 03:03:25', '2021-07-08 03:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `charging_station_images`
--

CREATE TABLE `charging_station_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `charging_station_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sirsa', 3, NULL, NULL, 1, 'sirsa-haryana', NULL, '2021-06-15 02:06:13', '2021-06-15 02:10:30'),
(2, 'Jaipur', 2, NULL, NULL, 1, 'jaipur-rajasthan', NULL, '2021-06-15 02:07:31', '2021-06-15 02:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Tata', NULL, 'upload/company/1624444491.png', 1, 'tata', NULL, '2021-06-14 05:17:57', '2021-06-23 06:04:51'),
(2, 'Honda', NULL, 'upload/company/1624444482.jpeg', 1, 'honda', NULL, '2021-06-14 05:18:06', '2021-06-23 06:04:42'),
(4, 'Hyundai', NULL, 'upload/company/1624444472.jpeg', 1, 'hyundai', NULL, '2021-06-14 05:19:31', '2021-06-23 06:04:32'),
(5, 'Mahindra', '2021-07-15 06:57:45', 'upload/company/1624444463.png', 1, 'mahindra', NULL, '2021-06-14 05:19:40', '2021-06-23 06:04:23'),
(6, 'Kia', NULL, 'upload/company/1624444453.jpeg', 1, 'kia', NULL, '2021-06-14 05:19:46', '2021-06-23 06:04:13'),
(7, 'MG', '2021-07-16 07:16:45', 'upload/company/1624444433.jpeg', 1, 'mg', NULL, '2021-06-14 05:19:51', '2021-06-23 06:03:54'),
(8, 'test', '2021-07-16 06:57:45', NULL, 1, 'test', NULL, '2021-07-16 01:27:45', '2021-07-16 01:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `company_models`
--

CREATE TABLE `company_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_models`
--

INSERT INTO `company_models` (`id`, `name`, `company_id`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'City', 2, NULL, NULL, 1, 'city-honda', '2021-06-14 07:34:00', '2021-06-14 07:31:10', '2021-06-14 07:34:00'),
(5, 'Creta', 4, NULL, NULL, 1, 'creta-hyundai', NULL, '2021-06-14 07:31:20', '2021-06-14 08:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `connectors`
--

CREATE TABLE `connectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `connectors`
--

INSERT INTO `connectors` (`id`, `name`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'BEVC-AC001', NULL, 'upload/connector/1623753083.png', 1, 'bevc-ac001', NULL, '2021-06-15 06:01:23', '2021-06-16 01:37:18'),
(3, 'AC-Plug-Point', NULL, 'upload/connector/1623753105.png', 1, 'ac-plug-point', NULL, '2021-06-15 06:01:45', '2021-06-15 06:01:45'),
(4, 'AC-Type-1', NULL, 'upload/connector/1623753122.png', 1, 'ac-type-1', NULL, '2021-06-15 06:02:02', '2021-06-15 06:02:02'),
(5, 'AC-Type-2', NULL, 'upload/connector/1623753136.png', 1, 'ac-type-2', NULL, '2021-06-15 06:02:16', '2021-06-15 06:02:16'),
(6, 'CCS-1', NULL, 'upload/connector/1623753151.png', 1, 'ccs-1', NULL, '2021-06-15 06:02:31', '2021-06-15 06:02:31'),
(7, 'CCS-2', NULL, 'upload/connector/1623753161.png', 1, 'ccs-2', NULL, '2021-06-15 06:02:41', '2021-06-15 06:02:41'),
(8, 'CHAmeDo', NULL, 'upload/connector/1623753195.png', 1, 'chamedo', NULL, '2021-06-15 06:03:15', '2021-06-15 06:03:15'),
(9, 'BEVC-DC-001GB/T', NULL, 'upload/connector/1623753216.png', 1, 'bevc-dc-001gbt', NULL, '2021-06-15 06:03:36', '2021-06-16 01:36:59'),
(10, 'TESLA', NULL, 'upload/connector/1623753227.png', 1, 'tesla', NULL, '2021-06-15 06:03:47', '2021-06-15 06:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_06_14_101641_create_settings_table', 2),
(5, '2021_06_14_103315_create_companies_table', 3),
(6, '2021_06_14_105124_create_company_models_table', 4),
(7, '2021_06_14_132741_create_states_table', 5),
(8, '2021_06_15_065731_create_cities_table', 6),
(9, '2021_06_15_103559_create_connectors_table', 7),
(19, '2021_06_16_060212_create_charging_stations_table', 8),
(20, '2021_06_16_074013_create_charging_station_images_table', 8),
(21, '2021_06_16_074111_create_charging_station_connectors_table', 8),
(22, '2021_07_16_062639_add_column_fcm_to_users_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dark_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `light_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon_icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pin_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_link` text COLLATE utf8mb4_unicode_ci,
  `download_link` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `email`, `mobile`, `phone`, `dark_logo`, `light_logo`, `favicon_icon`, `address`, `city`, `pin_code`, `country`, `social_link`, `download_link`, `created_at`, `updated_at`) VALUES
(1, 'Go Electri', 'goelectri@gmail.com', '+41 (0) 44 525 11 00', '+41 (0) 78 693 33 73', 'setting/1623739325.png', 'setting/16237393254987.png', 'setting/16237393259465.png', 'Jaipur', 'Jaipur', '8002', 'India', '[null,null,null,null]', '[null,null,null]', '2021-01-22 06:12:02', '2021-06-15 02:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Rajasthan', NULL, NULL, 1, 'rajasthan', NULL, '2021-06-14 08:14:32', '2021-06-14 08:27:16'),
(3, 'Haryana', NULL, NULL, 1, 'haryana', NULL, '2021-06-15 02:01:40', '2021-06-15 02:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '2',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for deactivate',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fcm_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_valid_time` timestamp NULL DEFAULT NULL COMMENT 'added otp valid time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_admin`, `password`, `original_password`, `status`, `image`, `mobile_code`, `mobile`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `fcm_id`, `device_id`, `otp`, `otp_valid_time`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, 1, '$2y$10$B.rnsr7ddjid7Ro54NPude19.6wnGfB6cp.qo3rmcpylKe7dUFAcS', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'user1', 'user@gmail.com', NULL, 2, '$2y$10$B.rnsr7ddjid7Ro54NPude19.6wnGfB6cp.qo3rmcpylKe7dUFAcS', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'amitu', 'a1@gmail.com', NULL, 2, '$2y$10$eL1t4d6URzLqyO8MHOXHKuTLl0Qtngfd.9rgPqC6XzOwxbT4x3pF6', '123456', 1, NULL, NULL, NULL, NULL, '2021-07-02 06:53:08', '2021-07-16 08:21:03', NULL, NULL, NULL, NULL, NULL),
(4, 'amitu', 'a12@gmail.com', NULL, 2, '$2y$10$RI3Zdjd4DXA.BtX8pAkVzOFAbYIjQwSI.gbGR1gV81jlEXiCOgoK6', '123456', 1, NULL, NULL, NULL, NULL, '2021-07-02 06:56:08', '2021-07-02 06:56:08', NULL, NULL, NULL, NULL, NULL),
(5, 'amitu', 'a124@gmail.com', NULL, 2, '$2y$10$n3TIDRNFLav/PUDw6H7Ue.d3iajgLpDUHc.sRL5d/ypaD1Xv3D86q', '123456', 1, NULL, NULL, NULL, NULL, '2021-07-02 06:56:33', '2021-07-02 06:56:33', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charging_stations`
--
ALTER TABLE `charging_stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charging_stations_state_id_foreign` (`state_id`),
  ADD KEY `charging_stations_city_id_foreign` (`city_id`),
  ADD KEY `charging_stations_user_id_foreign` (`user_id`);

--
-- Indexes for table `charging_station_connectors`
--
ALTER TABLE `charging_station_connectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charging_station_connectors_charging_station_id_foreign` (`charging_station_id`),
  ADD KEY `charging_station_connectors_connector_id_foreign` (`connector_id`);

--
-- Indexes for table `charging_station_images`
--
ALTER TABLE `charging_station_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charging_station_images_charging_station_id_foreign` (`charging_station_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_models`
--
ALTER TABLE `company_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_models_company_id_foreign` (`company_id`);

--
-- Indexes for table `connectors`
--
ALTER TABLE `connectors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charging_stations`
--
ALTER TABLE `charging_stations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `charging_station_connectors`
--
ALTER TABLE `charging_station_connectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `charging_station_images`
--
ALTER TABLE `charging_station_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company_models`
--
ALTER TABLE `company_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `connectors`
--
ALTER TABLE `connectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charging_stations`
--
ALTER TABLE `charging_stations`
  ADD CONSTRAINT `charging_stations_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `charging_stations_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `charging_stations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `charging_station_connectors`
--
ALTER TABLE `charging_station_connectors`
  ADD CONSTRAINT `charging_station_connectors_charging_station_id_foreign` FOREIGN KEY (`charging_station_id`) REFERENCES `charging_stations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `charging_station_connectors_connector_id_foreign` FOREIGN KEY (`connector_id`) REFERENCES `connectors` (`id`);

--
-- Constraints for table `charging_station_images`
--
ALTER TABLE `charging_station_images`
  ADD CONSTRAINT `charging_station_images_charging_station_id_foreign` FOREIGN KEY (`charging_station_id`) REFERENCES `charging_stations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_models`
--
ALTER TABLE `company_models`
  ADD CONSTRAINT `company_models_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
