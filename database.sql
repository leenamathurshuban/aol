-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2022 at 12:44 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pur_order_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `apexes`
--

CREATE TABLE `apexes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apexes`
--

INSERT INTO `apexes` (`id`, `name`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Head Office', 1, 'head-office', NULL, '2021-10-27 00:36:40', '2021-10-27 00:36:40'),
(2, 'Haryana', 1, 'haryana', NULL, '2021-10-27 00:36:47', '2021-10-27 00:36:47'),
(3, 'Gujrat', 1, 'gujrat', NULL, '2021-10-27 00:36:54', '2021-10-27 00:36:54'),
(4, 'Punjab', 1, 'punjab', NULL, '2021-10-27 00:37:00', '2021-10-27 00:37:00'),
(5, 'Rajasthan', 1, 'rajasthan', NULL, '2021-10-27 00:36:40', '2021-10-27 00:36:40'),
(6, 'Karnataka', 1, 'karnataka', NULL, '2022-01-24 06:34:11', '2022-01-24 06:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `assign_processes`
--

CREATE TABLE `assign_processes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_processes`
--

INSERT INTO `assign_processes` (`id`, `name`, `status`, `slug`, `created_at`, `updated_at`) VALUES
(2, 'Employee / Contingent  Pay', 1, 'employee-contingent-pay', '2021-08-30 06:04:50', '2021-08-30 06:04:50'),
(3, 'Vendor Pay', 1, 'vendor-pay', '2021-08-30 06:06:44', '2021-08-30 06:06:44'),
(5, 'Bulk Pay', 1, 'bulk-pay', '2021-08-30 06:11:09', '2021-08-30 06:11:09'),
(6, 'Transfers', 1, 'transfers', '2021-08-30 06:11:16', '2021-08-30 06:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_holder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `apexe_id` int(11) NOT NULL DEFAULT 0,
  `apexe_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `bank_name`, `bank_account_number`, `branch_address`, `branch_code`, `bank_account_holder`, `ifsc`, `slug`, `status`, `created_at`, `updated_at`, `deleted_at`, `apexe_id`, `apexe_ary`) VALUES
(3, 'CITI', '1214454545466', 'Jayanager', '1221145', 'Head Office', '11225533', '1214454545466', 1, '2022-01-05 05:29:17', '2022-01-07 12:03:32', NULL, 5, '{\"id\":5,\"name\":\"Head Office\",\"slug\":\"head-office\"}'),
(4, 'CITI', '122556640011', 'Bangalore', '103366', 'Head Office', '2321456585', '122556640011', 1, '2022-01-05 05:34:37', '2022-01-07 12:03:25', NULL, 2, '{\"id\":2,\"name\":\"Haryana\",\"slug\":\"haryana\"}'),
(5, 'ICICI', '222192971222', 'slkfhslkf', '123332', 'Karnataka', '123322111', '222192971222', 1, '2022-01-05 06:48:10', '2022-01-07 12:03:17', NULL, 5, '{\"id\":5,\"name\":\"Head Office\",\"slug\":\"head-office\"}'),
(6, 'IOB', '99999999', '?LKHFlk', 'H002', 'Harayana', 'IOB22222', '99999999', 1, '2022-01-24 06:32:34', '2022-01-24 06:33:42', NULL, 2, '{\"id\":2,\"name\":\"Haryana\",\"slug\":\"haryana\"}');

-- --------------------------------------------------------

--
-- Table structure for table `bulk_attachments`
--

CREATE TABLE `bulk_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulk_csv_uploads`
--

CREATE TABLE `bulk_csv_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bulk_upload_id` bigint(20) UNSIGNED NOT NULL,
  `bulk_upload_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amt_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dr_amount` int(11) NOT NULL DEFAULT 0,
  `cr_amount` int(11) NOT NULL DEFAULT 0,
  `refrence` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `output_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beneficiary_account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beneficiary_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `remarks_for_client` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks_for_beneficiary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_payment` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulk_uploads`
--

CREATE TABLE `bulk_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(11) NOT NULL DEFAULT 0,
  `specify_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_formate` int(11) NOT NULL DEFAULT 0,
  `payment_type` int(11) NOT NULL DEFAULT 0,
  `payment_type_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specified_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_date` date DEFAULT NULL,
  `manager_id` int(11) NOT NULL DEFAULT 0,
  `manager_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_date` date DEFAULT NULL,
  `account_dept_id` int(11) NOT NULL DEFAULT 0,
  `account_dept_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_dept_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountant_date` date DEFAULT NULL,
  `trust_ofc_id` int(11) NOT NULL DEFAULT 0,
  `trust_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_date` date DEFAULT NULL,
  `payment_ofc_id` int(11) NOT NULL DEFAULT 0,
  `payment_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `item_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bulk_attachment_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulk_attachment_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulk_attachment_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_ofc_id` int(11) NOT NULL DEFAULT 0,
  `tds_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_date` date DEFAULT NULL,
  `apexe_id` int(11) NOT NULL DEFAULT 0,
  `apexe_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_by_account` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulk_upload_files`
--

CREATE TABLE `bulk_upload_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bulk_upload_id` bigint(20) UNSIGNED NOT NULL,
  `bulk_upload_file_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulk_upload_file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulk_upload_file_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'Stationary', 1, 'stationary', NULL, '2022-01-07 11:01:45', '2022-01-07 11:01:45'),
(4, 'HouseKeeping', 1, 'housekeeping', NULL, '2022-01-07 11:01:52', '2022-01-07 11:01:52');

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
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Adilabad', 5, NULL, NULL, 1, 'adilabad-andhra-pradesh-ap', NULL, '2021-09-02 01:17:21', '2021-09-02 01:17:21'),
(3, 'Anantapur', 5, NULL, NULL, 1, 'anantapur-andhra-pradesh-ap', NULL, '2021-09-02 01:17:21', '2021-09-02 01:17:21'),
(4, 'Chittoor', 5, NULL, NULL, 1, 'chittoor-andhra-pradesh-ap', NULL, '2021-09-02 01:17:21', '2021-09-02 01:17:21'),
(5, 'Kakinada', 5, NULL, NULL, 1, 'kakinada-andhra-pradesh-ap', NULL, '2021-09-02 01:17:21', '2021-09-02 01:17:21'),
(6, 'Guntur', 5, NULL, NULL, 1, 'guntur-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(7, 'Hyderabad', 5, NULL, NULL, 1, 'hyderabad-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(8, 'Karimnagar', 5, NULL, NULL, 1, 'karimnagar-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(9, 'Khammam', 5, NULL, NULL, 1, 'khammam-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(10, 'Krishna', 5, NULL, NULL, 1, 'krishna-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(11, 'Kurnool', 5, NULL, NULL, 1, 'kurnool-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(12, 'Mahbubnagar', 5, NULL, NULL, 1, 'mahbubnagar-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(13, 'Medak', 5, NULL, NULL, 1, 'medak-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(14, 'Nalgonda', 5, NULL, NULL, 1, 'nalgonda-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(15, 'Nizamabad', 5, NULL, NULL, 1, 'nizamabad-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(16, 'Ongole', 5, NULL, NULL, 1, 'ongole-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(17, 'Hyderabad', 5, NULL, NULL, 1, 'hyderabad-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(18, 'Srikakulam', 5, NULL, NULL, 1, 'srikakulam-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(19, 'Nellore', 5, NULL, NULL, 1, 'nellore-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(20, 'Visakhapatnam', 5, NULL, NULL, 1, 'visakhapatnam-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(21, 'Vizianagaram', 5, NULL, NULL, 1, 'vizianagaram-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(22, 'Warangal', 5, NULL, NULL, 1, 'warangal-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(23, 'Eluru', 5, NULL, NULL, 1, 'eluru-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(24, 'Kadapa', 5, NULL, NULL, 1, 'kadapa-andhra-pradesh-ap', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(25, 'Anjaw', 6, NULL, NULL, 1, 'anjaw-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(26, 'Changlang', 6, NULL, NULL, 1, 'changlang-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(27, 'East Siang', 6, NULL, NULL, 1, 'east-siang-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(28, 'Kurung Kumey', 6, NULL, NULL, 1, 'kurung-kumey-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(29, 'Lohit', 6, NULL, NULL, 1, 'lohit-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(30, 'Lower Dibang Valley', 6, NULL, NULL, 1, 'lower-dibang-valley-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(31, 'Lower Subansiri', 6, NULL, NULL, 1, 'lower-subansiri-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(32, 'Papum Pare', 6, NULL, NULL, 1, 'papum-pare-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(33, 'Tawang', 6, NULL, NULL, 1, 'tawang-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(34, 'Tirap', 6, NULL, NULL, 1, 'tirap-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(35, 'Dibang Valley', 6, NULL, NULL, 1, 'dibang-valley-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(36, 'Upper Siang', 6, NULL, NULL, 1, 'upper-siang-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(37, 'Upper Subansiri', 6, NULL, NULL, 1, 'upper-subansiri-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(38, 'West Kameng', 6, NULL, NULL, 1, 'west-kameng-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(39, 'West Siang', 6, NULL, NULL, 1, 'west-siang-arunachal-pradesh-ar', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(40, 'Baksa', 7, NULL, NULL, 1, 'baksa-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(41, 'Barpeta', 7, NULL, NULL, 1, 'barpeta-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(42, 'Bongaigaon', 7, NULL, NULL, 1, 'bongaigaon-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(43, 'Cachar', 7, NULL, NULL, 1, 'cachar-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(44, 'Chirang', 7, NULL, NULL, 1, 'chirang-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(45, 'Darrang', 7, NULL, NULL, 1, 'darrang-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(46, 'Dhemaji', 7, NULL, NULL, 1, 'dhemaji-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(47, 'Dima Hasao', 7, NULL, NULL, 1, 'dima-hasao-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(48, 'Dhubri', 7, NULL, NULL, 1, 'dhubri-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(49, 'Dibrugarh', 7, NULL, NULL, 1, 'dibrugarh-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(50, 'Goalpara', 7, NULL, NULL, 1, 'goalpara-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(51, 'Golaghat', 7, NULL, NULL, 1, 'golaghat-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(52, 'Hailakandi', 7, NULL, NULL, 1, 'hailakandi-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(53, 'Jorhat', 7, NULL, NULL, 1, 'jorhat-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(54, 'Kamrup', 7, NULL, NULL, 1, 'kamrup-assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(55, 'Kamrup Metropolitan', 7, NULL, NULL, 1, 'kamrup-metropolitan-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(56, 'Karbi Anglong', 7, NULL, NULL, 1, 'karbi-anglong-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(57, 'Karimganj', 7, NULL, NULL, 1, 'karimganj-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(58, 'Kokrajhar', 7, NULL, NULL, 1, 'kokrajhar-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(59, 'Lakhimpur', 7, NULL, NULL, 1, 'lakhimpur-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(60, 'Marigaon', 7, NULL, NULL, 1, 'marigaon-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(61, 'Nagaon', 7, NULL, NULL, 1, 'nagaon-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(62, 'Nalbari', 7, NULL, NULL, 1, 'nalbari-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(63, 'Sibsagar', 7, NULL, NULL, 1, 'sibsagar-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(64, 'Sonitpur', 7, NULL, NULL, 1, 'sonitpur-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(65, 'Tinsukia', 7, NULL, NULL, 1, 'tinsukia-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(66, 'Udalguri', 7, NULL, NULL, 1, 'udalguri-assam-as', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(67, 'Araria', 8, NULL, NULL, 1, 'araria-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(68, 'Arwal', 8, NULL, NULL, 1, 'arwal-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(69, 'Aurangabad', 8, NULL, NULL, 1, 'aurangabad-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(70, 'Banka', 8, NULL, NULL, 1, 'banka-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(71, 'Begusarai', 8, NULL, NULL, 1, 'begusarai-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(72, 'Bhagalpur', 8, NULL, NULL, 1, 'bhagalpur-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(73, 'Bhojpur', 8, NULL, NULL, 1, 'bhojpur-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(74, 'Buxar', 8, NULL, NULL, 1, 'buxar-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(75, 'Darbhanga', 8, NULL, NULL, 1, 'darbhanga-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(76, 'East Champaran', 8, NULL, NULL, 1, 'east-champaran-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(77, 'Gaya', 8, NULL, NULL, 1, 'gaya-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(78, 'Gopalganj', 8, NULL, NULL, 1, 'gopalganj-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(79, 'Jamui', 8, NULL, NULL, 1, 'jamui-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(80, 'Jehanabad', 8, NULL, NULL, 1, 'jehanabad-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(81, 'Kaimur', 8, NULL, NULL, 1, 'kaimur-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(82, 'Katihar', 8, NULL, NULL, 1, 'katihar-bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(83, 'Khagaria', 8, NULL, NULL, 1, 'khagaria-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(84, 'Kishanganj', 8, NULL, NULL, 1, 'kishanganj-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(85, 'Lakhisarai', 8, NULL, NULL, 1, 'lakhisarai-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(86, 'Madhepura', 8, NULL, NULL, 1, 'madhepura-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(87, 'Madhubani', 8, NULL, NULL, 1, 'madhubani-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(88, 'Munger', 8, NULL, NULL, 1, 'munger-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(89, 'Muzaffarpur', 8, NULL, NULL, 1, 'muzaffarpur-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(90, 'Nalanda', 8, NULL, NULL, 1, 'nalanda-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(91, 'Nawada', 8, NULL, NULL, 1, 'nawada-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(92, 'Patna', 8, NULL, NULL, 1, 'patna-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(93, 'Purnia', 8, NULL, NULL, 1, 'purnia-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(94, 'Rohtas', 8, NULL, NULL, 1, 'rohtas-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(95, 'Saharsa', 8, NULL, NULL, 1, 'saharsa-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(96, 'Samastipur', 8, NULL, NULL, 1, 'samastipur-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(97, 'Saran', 8, NULL, NULL, 1, 'saran-bihar-br', NULL, '2021-09-02 01:17:25', '2021-09-02 01:17:25'),
(98, 'Sheikhpura', 8, NULL, NULL, 1, 'sheikhpura-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(99, 'Sheohar', 8, NULL, NULL, 1, 'sheohar-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(100, 'Sitamarhi', 8, NULL, NULL, 1, 'sitamarhi-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(101, 'Siwan', 8, NULL, NULL, 1, 'siwan-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(102, 'Supaul', 8, NULL, NULL, 1, 'supaul-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(103, 'Vaishali', 8, NULL, NULL, 1, 'vaishali-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(104, 'West Champaran', 8, NULL, NULL, 1, 'west-champaran-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(105, 'Chandigarh', 8, NULL, NULL, 1, 'chandigarh-bihar-br', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(106, 'Bastar', 9, NULL, NULL, 1, 'bastar-chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(107, 'Bijapur', 9, NULL, NULL, 1, 'bijapur-chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(108, 'Bilaspur', 9, NULL, NULL, 1, 'bilaspur-chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(109, 'Dantewada', 9, NULL, NULL, 1, 'dantewada-chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(110, 'Dhamtari', 9, NULL, NULL, 1, 'dhamtari-chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(111, 'Durg', 9, NULL, NULL, 1, 'durg-chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(112, 'Jashpur', 9, NULL, NULL, 1, 'jashpur-chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(113, 'Janjgir-Champa', 9, NULL, NULL, 1, 'janjgir-champa-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(114, 'Korba', 9, NULL, NULL, 1, 'korba-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(115, 'Koriya', 9, NULL, NULL, 1, 'koriya-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(116, 'Kanker', 9, NULL, NULL, 1, 'kanker-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(117, 'Kabirdham (Kawardha)', 9, NULL, NULL, 1, 'kabirdham-kawardha-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(118, 'Mahasamund', 9, NULL, NULL, 1, 'mahasamund-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(119, 'Narayanpur', 9, NULL, NULL, 1, 'narayanpur-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(120, 'Raigarh', 9, NULL, NULL, 1, 'raigarh-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(121, 'Rajnandgaon', 9, NULL, NULL, 1, 'rajnandgaon-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(122, 'Raipur', 9, NULL, NULL, 1, 'raipur-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(123, 'Surguja', 9, NULL, NULL, 1, 'surguja-chhattisgarh-cg', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(124, 'Dadra and Nagar Haveli', 10, NULL, NULL, 1, 'dadra-and-nagar-haveli-dadra-and-nagar-haveli-dn', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(125, 'Daman', 11, NULL, NULL, 1, 'daman-daman-and-diu-dd', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(126, 'Diu', 11, NULL, NULL, 1, 'diu-daman-and-diu-dd', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(127, 'Central Delhi', 12, NULL, NULL, 1, 'central-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(128, 'East Delhi', 12, NULL, NULL, 1, 'east-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(129, 'New Delhi', 12, NULL, NULL, 1, 'new-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(130, 'North Delhi', 12, NULL, NULL, 1, 'north-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(131, 'North East Delhi', 12, NULL, NULL, 1, 'north-east-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(132, 'North West Delhi', 12, NULL, NULL, 1, 'north-west-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(133, 'South Delhi', 12, NULL, NULL, 1, 'south-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(134, 'South West Delhi', 12, NULL, NULL, 1, 'south-west-delhi-delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(135, 'West Delhi', 12, NULL, NULL, 1, 'west-delhi-delhi-dl', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(136, 'North Goa', 13, NULL, NULL, 1, 'north-goa-goa-ga', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(137, 'South Goa', 13, NULL, NULL, 1, 'south-goa-goa-ga', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(138, 'Ahmedabad', 14, NULL, NULL, 1, 'ahmedabad-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(139, 'Amreli district', 14, NULL, NULL, 1, 'amreli-district-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(140, 'Anand', 14, NULL, NULL, 1, 'anand-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(141, 'Banaskantha', 14, NULL, NULL, 1, 'banaskantha-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(142, 'Bharuch', 14, NULL, NULL, 1, 'bharuch-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(143, 'Bhavnagar', 14, NULL, NULL, 1, 'bhavnagar-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(144, 'Dahod', 14, NULL, NULL, 1, 'dahod-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(145, 'The Dangs', 14, NULL, NULL, 1, 'the-dangs-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(146, 'Gandhinagar', 14, NULL, NULL, 1, 'gandhinagar-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(147, 'Jamnagar', 14, NULL, NULL, 1, 'jamnagar-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(148, 'Junagadh', 14, NULL, NULL, 1, 'junagadh-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(149, 'Kutch', 14, NULL, NULL, 1, 'kutch-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(150, 'Kheda', 14, NULL, NULL, 1, 'kheda-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(151, 'Mehsana', 14, NULL, NULL, 1, 'mehsana-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(152, 'Narmada', 14, NULL, NULL, 1, 'narmada-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(153, 'Navsari', 14, NULL, NULL, 1, 'navsari-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(154, 'Patan', 14, NULL, NULL, 1, 'patan-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(155, 'Panchmahal', 14, NULL, NULL, 1, 'panchmahal-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(156, 'Porbandar', 14, NULL, NULL, 1, 'porbandar-gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(157, 'Rajkot', 14, NULL, NULL, 1, 'rajkot-gujarat-gj', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(158, 'Sabarkantha', 14, NULL, NULL, 1, 'sabarkantha-gujarat-gj', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(159, 'Surendranagar', 14, NULL, NULL, 1, 'surendranagar-gujarat-gj', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(160, 'Surat', 14, NULL, NULL, 1, 'surat-gujarat-gj', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(161, 'Vyara', 14, NULL, NULL, 1, 'vyara-gujarat-gj', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(162, 'Vadodara', 14, NULL, NULL, 1, 'vadodara-gujarat-gj', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(163, 'Valsad', 14, NULL, NULL, 1, 'valsad-gujarat-gj', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(164, 'Ambala', 15, NULL, NULL, 1, 'ambala-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(165, 'Bhiwani', 15, NULL, NULL, 1, 'bhiwani-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(166, 'Faridabad', 15, NULL, NULL, 1, 'faridabad-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(167, 'Fatehabad', 15, NULL, NULL, 1, 'fatehabad-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(168, 'Gurgaon', 15, NULL, NULL, 1, 'gurgaon-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(169, 'Hissar', 15, NULL, NULL, 1, 'hissar-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(170, 'Jhajjar', 15, NULL, NULL, 1, 'jhajjar-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(171, 'Jind', 15, NULL, NULL, 1, 'jind-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(172, 'Karnal', 15, NULL, NULL, 1, 'karnal-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(173, 'Kaithal', 15, NULL, NULL, 1, 'kaithal-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(174, 'Kurukshetra', 15, NULL, NULL, 1, 'kurukshetra-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(175, 'Mahendragarh', 15, NULL, NULL, 1, 'mahendragarh-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(176, 'Mewat', 15, NULL, NULL, 1, 'mewat-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(177, 'Palwal', 15, NULL, NULL, 1, 'palwal-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(178, 'Panchkula', 15, NULL, NULL, 1, 'panchkula-haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(179, 'Panipat', 15, NULL, NULL, 1, 'panipat-haryana-hr', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(180, 'Rewari', 15, NULL, NULL, 1, 'rewari-haryana-hr', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(181, 'Rohtak', 15, NULL, NULL, 1, 'rohtak-haryana-hr', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(182, 'Sirsa', 15, NULL, NULL, 1, 'sirsa-haryana-hr', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(183, 'Sonipat', 15, NULL, NULL, 1, 'sonipat-haryana-hr', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(184, 'Yamuna Nagar', 15, NULL, NULL, 1, 'yamuna-nagar-haryana-hr', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(185, 'Bilaspur', 16, NULL, NULL, 1, 'bilaspur-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(186, 'Chamba', 16, NULL, NULL, 1, 'chamba-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(187, 'Hamirpur', 16, NULL, NULL, 1, 'hamirpur-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(188, 'Kangra', 16, NULL, NULL, 1, 'kangra-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(189, 'Kinnaur', 16, NULL, NULL, 1, 'kinnaur-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(190, 'Kullu', 16, NULL, NULL, 1, 'kullu-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(191, 'Lahaul and Spiti', 16, NULL, NULL, 1, 'lahaul-and-spiti-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(192, 'Mandi', 16, NULL, NULL, 1, 'mandi-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(193, 'Shimla', 16, NULL, NULL, 1, 'shimla-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(194, 'Sirmaur', 16, NULL, NULL, 1, 'sirmaur-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(195, 'Solan', 16, NULL, NULL, 1, 'solan-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(196, 'Una', 16, NULL, NULL, 1, 'una-himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(197, 'Anantnag', 17, NULL, NULL, 1, 'anantnag-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(198, 'Badgam', 17, NULL, NULL, 1, 'badgam-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(199, 'Bandipora', 17, NULL, NULL, 1, 'bandipora-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(200, 'Baramulla', 17, NULL, NULL, 1, 'baramulla-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(201, 'Doda', 17, NULL, NULL, 1, 'doda-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(202, 'Ganderbal', 17, NULL, NULL, 1, 'ganderbal-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(203, 'Jammu', 17, NULL, NULL, 1, 'jammu-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(204, 'Kargil', 17, NULL, NULL, 1, 'kargil-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(205, 'Kathua', 17, NULL, NULL, 1, 'kathua-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(206, 'Kishtwar', 17, NULL, NULL, 1, 'kishtwar-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(207, 'Kupwara', 17, NULL, NULL, 1, 'kupwara-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(208, 'Kulgam', 17, NULL, NULL, 1, 'kulgam-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(209, 'Leh', 17, NULL, NULL, 1, 'leh-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(210, 'Poonch', 17, NULL, NULL, 1, 'poonch-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(211, 'Pulwama', 17, NULL, NULL, 1, 'pulwama-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(212, 'Rajauri', 17, NULL, NULL, 1, 'rajauri-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(213, 'Ramban', 17, NULL, NULL, 1, 'ramban-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(214, 'Reasi', 17, NULL, NULL, 1, 'reasi-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(215, 'Samba', 17, NULL, NULL, 1, 'samba-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(216, 'Shopian', 17, NULL, NULL, 1, 'shopian-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(217, 'Srinagar', 17, NULL, NULL, 1, 'srinagar-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(218, 'Udhampur', 17, NULL, NULL, 1, 'udhampur-jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:31', '2021-09-02 01:17:31'),
(219, 'Bokaro', 18, NULL, NULL, 1, 'bokaro-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(220, 'Chatra', 18, NULL, NULL, 1, 'chatra-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(221, 'Deoghar', 18, NULL, NULL, 1, 'deoghar-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(222, 'Dhanbad', 18, NULL, NULL, 1, 'dhanbad-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(223, 'Dumka', 18, NULL, NULL, 1, 'dumka-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(224, 'East Singhbhum', 18, NULL, NULL, 1, 'east-singhbhum-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(225, 'Garhwa', 18, NULL, NULL, 1, 'garhwa-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(226, 'Giridih', 18, NULL, NULL, 1, 'giridih-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(227, 'Godda', 18, NULL, NULL, 1, 'godda-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(228, 'Gumla', 18, NULL, NULL, 1, 'gumla-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(229, 'Hazaribag', 18, NULL, NULL, 1, 'hazaribag-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(230, 'Jamtara', 18, NULL, NULL, 1, 'jamtara-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(231, 'Khunti', 18, NULL, NULL, 1, 'khunti-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(232, 'Koderma', 18, NULL, NULL, 1, 'koderma-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(233, 'Latehar', 18, NULL, NULL, 1, 'latehar-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(234, 'Lohardaga', 18, NULL, NULL, 1, 'lohardaga-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(235, 'Pakur', 18, NULL, NULL, 1, 'pakur-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(236, 'Palamu', 18, NULL, NULL, 1, 'palamu-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(237, 'Ramgarh', 18, NULL, NULL, 1, 'ramgarh-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(238, 'Ranchi', 18, NULL, NULL, 1, 'ranchi-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(239, 'Sahibganj', 18, NULL, NULL, 1, 'sahibganj-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(240, 'Seraikela Kharsawan', 18, NULL, NULL, 1, 'seraikela-kharsawan-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(241, 'Simdega', 18, NULL, NULL, 1, 'simdega-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(242, 'West Singhbhum', 18, NULL, NULL, 1, 'west-singhbhum-jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(243, 'Bagalkot', 19, NULL, NULL, 1, 'bagalkot-karnataka-ka', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(244, 'Bangalore Rural', 19, NULL, NULL, 1, 'bangalore-rural-karnataka-ka', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(245, 'Bangalore Urban', 19, NULL, NULL, 1, 'bangalore-urban-karnataka-ka', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(246, 'Belgaum', 19, NULL, NULL, 1, 'belgaum-karnataka-ka', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(247, 'Bellary', 19, NULL, NULL, 1, 'bellary-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(248, 'Bidar', 19, NULL, NULL, 1, 'bidar-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(249, 'Bijapur', 19, NULL, NULL, 1, 'bijapur-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(250, 'Chamarajnagar', 19, NULL, NULL, 1, 'chamarajnagar-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(251, 'Chikkamagaluru', 19, NULL, NULL, 1, 'chikkamagaluru-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(252, 'Chikkaballapur', 19, NULL, NULL, 1, 'chikkaballapur-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(253, 'Chitradurga', 19, NULL, NULL, 1, 'chitradurga-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(254, 'Davanagere', 19, NULL, NULL, 1, 'davanagere-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(255, 'Dharwad', 19, NULL, NULL, 1, 'dharwad-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(256, 'Dakshina Kannada', 19, NULL, NULL, 1, 'dakshina-kannada-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(257, 'Gadag', 19, NULL, NULL, 1, 'gadag-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(258, 'Gulbarga', 19, NULL, NULL, 1, 'gulbarga-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(259, 'Hassan', 19, NULL, NULL, 1, 'hassan-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(260, 'Haveri district', 19, NULL, NULL, 1, 'haveri-district-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(261, 'Kodagu', 19, NULL, NULL, 1, 'kodagu-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(262, 'Kolar', 19, NULL, NULL, 1, 'kolar-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(263, 'Koppal', 19, NULL, NULL, 1, 'koppal-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(264, 'Mandya', 19, NULL, NULL, 1, 'mandya-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(265, 'Mysore', 19, NULL, NULL, 1, 'mysore-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(266, 'Raichur', 19, NULL, NULL, 1, 'raichur-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(267, 'Shimoga', 19, NULL, NULL, 1, 'shimoga-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(268, 'Tumkur', 19, NULL, NULL, 1, 'tumkur-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(269, 'Udupi', 19, NULL, NULL, 1, 'udupi-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(270, 'Uttara Kannada', 19, NULL, NULL, 1, 'uttara-kannada-karnataka-ka', NULL, '2021-09-02 01:17:33', '2021-09-02 01:17:33'),
(271, 'Ramanagara', 19, NULL, NULL, 1, 'ramanagara-karnataka-ka', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(272, 'Yadgir', 19, NULL, NULL, 1, 'yadgir-karnataka-ka', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(273, 'Alappuzha', 20, NULL, NULL, 1, 'alappuzha-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(274, 'Ernakulam', 20, NULL, NULL, 1, 'ernakulam-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(275, 'Idukki', 20, NULL, NULL, 1, 'idukki-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(276, 'Kannur', 20, NULL, NULL, 1, 'kannur-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(277, 'Kasaragod', 20, NULL, NULL, 1, 'kasaragod-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(278, 'Kollam', 20, NULL, NULL, 1, 'kollam-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(279, 'Kottayam', 20, NULL, NULL, 1, 'kottayam-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(280, 'Kozhikode', 20, NULL, NULL, 1, 'kozhikode-kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(281, 'Malappuram', 20, NULL, NULL, 1, 'malappuram-kerala-kl', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(282, 'Palakkad', 20, NULL, NULL, 1, 'palakkad-kerala-kl', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(283, 'Pathanamthitta', 20, NULL, NULL, 1, 'pathanamthitta-kerala-kl', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(284, 'Thrissur', 20, NULL, NULL, 1, 'thrissur-kerala-kl', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(285, 'Thiruvananthapuram', 20, NULL, NULL, 1, 'thiruvananthapuram-kerala-kl', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(286, 'Wayanad', 20, NULL, NULL, 1, 'wayanad-kerala-kl', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(287, 'Alirajpur', 21, NULL, NULL, 1, 'alirajpur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(288, 'Anuppur', 21, NULL, NULL, 1, 'anuppur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(289, 'Ashok Nagar', 21, NULL, NULL, 1, 'ashok-nagar-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(290, 'Balaghat', 21, NULL, NULL, 1, 'balaghat-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(291, 'Barwani', 21, NULL, NULL, 1, 'barwani-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(292, 'Betul', 21, NULL, NULL, 1, 'betul-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(293, 'Bhind', 21, NULL, NULL, 1, 'bhind-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(294, 'Bhopal', 21, NULL, NULL, 1, 'bhopal-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(295, 'Burhanpur', 21, NULL, NULL, 1, 'burhanpur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(296, 'Chhatarpur', 21, NULL, NULL, 1, 'chhatarpur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(297, 'Chhindwara', 21, NULL, NULL, 1, 'chhindwara-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(298, 'Damoh', 21, NULL, NULL, 1, 'damoh-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(299, 'Datia', 21, NULL, NULL, 1, 'datia-madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(300, 'Dewas', 21, NULL, NULL, 1, 'dewas-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(301, 'Dhar', 21, NULL, NULL, 1, 'dhar-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(302, 'Dindori', 21, NULL, NULL, 1, 'dindori-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(303, 'Guna', 21, NULL, NULL, 1, 'guna-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(304, 'Gwalior', 21, NULL, NULL, 1, 'gwalior-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(305, 'Harda', 21, NULL, NULL, 1, 'harda-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(306, 'Hoshangabad', 21, NULL, NULL, 1, 'hoshangabad-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(307, 'Indore', 21, NULL, NULL, 1, 'indore-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(308, 'Jabalpur', 21, NULL, NULL, 1, 'jabalpur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(309, 'Jhabua', 21, NULL, NULL, 1, 'jhabua-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(310, 'Katni', 21, NULL, NULL, 1, 'katni-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(311, 'Khandwa (East Nimar)', 21, NULL, NULL, 1, 'khandwa-east-nimar-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(312, 'Khargone (West Nimar)', 21, NULL, NULL, 1, 'khargone-west-nimar-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(313, 'Mandla', 21, NULL, NULL, 1, 'mandla-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(314, 'Mandsaur', 21, NULL, NULL, 1, 'mandsaur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(315, 'Morena', 21, NULL, NULL, 1, 'morena-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(316, 'Narsinghpur', 21, NULL, NULL, 1, 'narsinghpur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(317, 'Neemuch', 21, NULL, NULL, 1, 'neemuch-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(318, 'Panna', 21, NULL, NULL, 1, 'panna-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(319, 'Rewa', 21, NULL, NULL, 1, 'rewa-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(320, 'Rajgarh', 21, NULL, NULL, 1, 'rajgarh-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(321, 'Ratlam', 21, NULL, NULL, 1, 'ratlam-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(322, 'Raisen', 21, NULL, NULL, 1, 'raisen-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(323, 'Sagar', 21, NULL, NULL, 1, 'sagar-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(324, 'Satna', 21, NULL, NULL, 1, 'satna-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(325, 'Sehore', 21, NULL, NULL, 1, 'sehore-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(326, 'Seoni', 21, NULL, NULL, 1, 'seoni-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(327, 'Shahdol', 21, NULL, NULL, 1, 'shahdol-madhya-pradesh-mp', NULL, '2021-09-02 01:17:36', '2021-09-02 01:17:36'),
(328, 'Shajapur', 21, NULL, NULL, 1, 'shajapur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(329, 'Sheopur', 21, NULL, NULL, 1, 'sheopur-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(330, 'Shivpuri', 21, NULL, NULL, 1, 'shivpuri-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(331, 'Sidhi', 21, NULL, NULL, 1, 'sidhi-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(332, 'Singrauli', 21, NULL, NULL, 1, 'singrauli-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(333, 'Tikamgarh', 21, NULL, NULL, 1, 'tikamgarh-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(334, 'Ujjain', 21, NULL, NULL, 1, 'ujjain-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(335, 'Umaria', 21, NULL, NULL, 1, 'umaria-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(336, 'Vidisha', 21, NULL, NULL, 1, 'vidisha-madhya-pradesh-mp', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(337, 'Ahmednagar', 22, NULL, NULL, 1, 'ahmednagar-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(338, 'Akola', 22, NULL, NULL, 1, 'akola-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(339, 'Amravati', 22, NULL, NULL, 1, 'amravati-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(340, 'Aurangabad', 22, NULL, NULL, 1, 'aurangabad-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(341, 'Bhandara', 22, NULL, NULL, 1, 'bhandara-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(342, 'Beed', 22, NULL, NULL, 1, 'beed-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(343, 'Buldhana', 22, NULL, NULL, 1, 'buldhana-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(344, 'Chandrapur', 22, NULL, NULL, 1, 'chandrapur-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(345, 'Dhule', 22, NULL, NULL, 1, 'dhule-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(346, 'Gadchiroli', 22, NULL, NULL, 1, 'gadchiroli-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(347, 'Gondia', 22, NULL, NULL, 1, 'gondia-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(348, 'Hingoli', 22, NULL, NULL, 1, 'hingoli-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(349, 'Jalgaon', 22, NULL, NULL, 1, 'jalgaon-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(350, 'Jalna', 22, NULL, NULL, 1, 'jalna-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(351, 'Kolhapur', 22, NULL, NULL, 1, 'kolhapur-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(352, 'Latur', 22, NULL, NULL, 1, 'latur-maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(353, 'Mumbai City', 22, NULL, NULL, 1, 'mumbai-city-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(354, 'Mumbai suburban', 22, NULL, NULL, 1, 'mumbai-suburban-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(355, 'Nandurbar', 22, NULL, NULL, 1, 'nandurbar-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(356, 'Nanded', 22, NULL, NULL, 1, 'nanded-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(357, 'Nagpur', 22, NULL, NULL, 1, 'nagpur-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(358, 'Nashik', 22, NULL, NULL, 1, 'nashik-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(359, 'Osmanabad', 22, NULL, NULL, 1, 'osmanabad-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(360, 'Parbhani', 22, NULL, NULL, 1, 'parbhani-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(361, 'Pune', 22, NULL, NULL, 1, 'pune-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(362, 'Raigad', 22, NULL, NULL, 1, 'raigad-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(363, 'Ratnagiri', 22, NULL, NULL, 1, 'ratnagiri-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(364, 'Sindhudurg', 22, NULL, NULL, 1, 'sindhudurg-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(365, 'Sangli', 22, NULL, NULL, 1, 'sangli-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(366, 'Solapur', 22, NULL, NULL, 1, 'solapur-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(367, 'Satara', 22, NULL, NULL, 1, 'satara-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(368, 'Thane', 22, NULL, NULL, 1, 'thane-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(369, 'Wardha', 22, NULL, NULL, 1, 'wardha-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(370, 'Washim', 22, NULL, NULL, 1, 'washim-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(371, 'Yavatmal', 22, NULL, NULL, 1, 'yavatmal-maharashtra-mh', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(372, 'Bishnupur', 23, NULL, NULL, 1, 'bishnupur-manipur-mn', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(373, 'Churachandpur', 23, NULL, NULL, 1, 'churachandpur-manipur-mn', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(374, 'Chandel', 23, NULL, NULL, 1, 'chandel-manipur-mn', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(375, 'Imphal East', 23, NULL, NULL, 1, 'imphal-east-manipur-mn', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(376, 'Senapati', 23, NULL, NULL, 1, 'senapati-manipur-mn', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(377, 'Tamenglong', 23, NULL, NULL, 1, 'tamenglong-manipur-mn', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(378, 'Thoubal', 23, NULL, NULL, 1, 'thoubal-manipur-mn', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(379, 'Ukhrul', 23, NULL, NULL, 1, 'ukhrul-manipur-mn', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(380, 'Imphal West', 23, NULL, NULL, 1, 'imphal-west-manipur-mn', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(381, 'East Garo Hills', 24, NULL, NULL, 1, 'east-garo-hills-meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(382, 'East Khasi Hills', 24, NULL, NULL, 1, 'east-khasi-hills-meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(383, 'Jaintia Hills', 24, NULL, NULL, 1, 'jaintia-hills-meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(384, 'Ri Bhoi', 24, NULL, NULL, 1, 'ri-bhoi-meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(385, 'South Garo Hills', 24, NULL, NULL, 1, 'south-garo-hills-meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(386, 'West Garo Hills', 24, NULL, NULL, 1, 'west-garo-hills-meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(387, 'West Khasi Hills', 24, NULL, NULL, 1, 'west-khasi-hills-meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(388, 'Aizawl', 25, NULL, NULL, 1, 'aizawl-mizoram-mz', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(389, 'Champhai', 25, NULL, NULL, 1, 'champhai-mizoram-mz', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(390, 'Kolasib', 25, NULL, NULL, 1, 'kolasib-mizoram-mz', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(391, 'Lawngtlai', 25, NULL, NULL, 1, 'lawngtlai-mizoram-mz', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(392, 'Lunglei', 25, NULL, NULL, 1, 'lunglei-mizoram-mz', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(393, 'Mamit', 25, NULL, NULL, 1, 'mamit-mizoram-mz', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(394, 'Saiha', 25, NULL, NULL, 1, 'saiha-mizoram-mz', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(395, 'Serchhip', 25, NULL, NULL, 1, 'serchhip-mizoram-mz', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(396, 'Dimapur', 26, NULL, NULL, 1, 'dimapur-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(397, 'Kohima', 26, NULL, NULL, 1, 'kohima-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(398, 'Mokokchung', 26, NULL, NULL, 1, 'mokokchung-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(399, 'Mon', 26, NULL, NULL, 1, 'mon-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(400, 'Phek', 26, NULL, NULL, 1, 'phek-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(401, 'Tuensang', 26, NULL, NULL, 1, 'tuensang-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(402, 'Wokha', 26, NULL, NULL, 1, 'wokha-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(403, 'Zunheboto', 26, NULL, NULL, 1, 'zunheboto-nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(404, 'Angul', 27, NULL, NULL, 1, 'angul-orissa-or', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(405, 'Boudh (Bauda)', 27, NULL, NULL, 1, 'boudh-bauda-orissa-or', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(406, 'Bhadrak', 27, NULL, NULL, 1, 'bhadrak-orissa-or', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(407, 'Balangir', 27, NULL, NULL, 1, 'balangir-orissa-or', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(408, 'Bargarh (Baragarh)', 27, NULL, NULL, 1, 'bargarh-baragarh-orissa-or', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(409, 'Balasore', 27, NULL, NULL, 1, 'balasore-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(410, 'Cuttack', 27, NULL, NULL, 1, 'cuttack-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(411, 'Debagarh (Deogarh)', 27, NULL, NULL, 1, 'debagarh-deogarh-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(412, 'Dhenkanal', 27, NULL, NULL, 1, 'dhenkanal-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(413, 'Ganjam', 27, NULL, NULL, 1, 'ganjam-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(414, 'Gajapati', 27, NULL, NULL, 1, 'gajapati-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(415, 'Jharsuguda', 27, NULL, NULL, 1, 'jharsuguda-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(416, 'Jajpur', 27, NULL, NULL, 1, 'jajpur-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(417, 'Jagatsinghpur', 27, NULL, NULL, 1, 'jagatsinghpur-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(418, 'Khordha', 27, NULL, NULL, 1, 'khordha-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(419, 'Kendujhar (Keonjhar)', 27, NULL, NULL, 1, 'kendujhar-keonjhar-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(420, 'Kalahandi', 27, NULL, NULL, 1, 'kalahandi-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(421, 'Kandhamal', 27, NULL, NULL, 1, 'kandhamal-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(422, 'Koraput', 27, NULL, NULL, 1, 'koraput-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(423, 'Kendrapara', 27, NULL, NULL, 1, 'kendrapara-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(424, 'Malkangiri', 27, NULL, NULL, 1, 'malkangiri-orissa-or', NULL, '2021-09-02 01:17:41', '2021-09-02 01:17:41'),
(425, 'Mayurbhanj', 27, NULL, NULL, 1, 'mayurbhanj-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(426, 'Nabarangpur', 27, NULL, NULL, 1, 'nabarangpur-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(427, 'Nuapada', 27, NULL, NULL, 1, 'nuapada-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(428, 'Nayagarh', 27, NULL, NULL, 1, 'nayagarh-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(429, 'Puri', 27, NULL, NULL, 1, 'puri-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(430, 'Rayagada', 27, NULL, NULL, 1, 'rayagada-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(431, 'Sambalpur', 27, NULL, NULL, 1, 'sambalpur-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(432, 'Subarnapur (Sonepur)', 27, NULL, NULL, 1, 'subarnapur-sonepur-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(433, 'Sundergarh', 27, NULL, NULL, 1, 'sundergarh-orissa-or', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(434, 'Karaikal', 28, NULL, NULL, 1, 'karaikal-pondicherry-puducherry-py', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(435, 'Mahe', 28, NULL, NULL, 1, 'mahe-pondicherry-puducherry-py', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(436, 'Pondicherry', 28, NULL, NULL, 1, 'pondicherry-pondicherry-puducherry-py', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(437, 'Yanam', 28, NULL, NULL, 1, 'yanam-pondicherry-puducherry-py', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(438, 'Amritsar', 29, NULL, NULL, 1, 'amritsar-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(439, 'Barnala', 29, NULL, NULL, 1, 'barnala-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42');
INSERT INTO `cities` (`id`, `name`, `state_id`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(440, 'Bathinda', 29, NULL, NULL, 1, 'bathinda-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(441, 'Firozpur', 29, NULL, NULL, 1, 'firozpur-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(442, 'Faridkot', 29, NULL, NULL, 1, 'faridkot-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(443, 'Fatehgarh Sahib', 29, NULL, NULL, 1, 'fatehgarh-sahib-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(444, 'Fazilka', 29, NULL, NULL, 1, 'fazilka-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(445, 'Gurdaspur', 29, NULL, NULL, 1, 'gurdaspur-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(446, 'Hoshiarpur', 29, NULL, NULL, 1, 'hoshiarpur-punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(447, 'Jalandhar', 29, NULL, NULL, 1, 'jalandhar-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(448, 'Kapurthala', 29, NULL, NULL, 1, 'kapurthala-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(449, 'Ludhiana', 29, NULL, NULL, 1, 'ludhiana-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(450, 'Mansa', 29, NULL, NULL, 1, 'mansa-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(451, 'Moga', 29, NULL, NULL, 1, 'moga-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(452, 'Sri Muktsar Sahib', 29, NULL, NULL, 1, 'sri-muktsar-sahib-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(453, 'Pathankot', 29, NULL, NULL, 1, 'pathankot-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(454, 'Patiala', 29, NULL, NULL, 1, 'patiala-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(455, 'Rupnagar', 29, NULL, NULL, 1, 'rupnagar-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(456, 'Ajitgarh (Mohali)', 29, NULL, NULL, 1, 'ajitgarh-mohali-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(457, 'Sangrur', 29, NULL, NULL, 1, 'sangrur-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(458, 'Nawanshahr', 29, NULL, NULL, 1, 'nawanshahr-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(459, 'Tarn Taran', 29, NULL, NULL, 1, 'tarn-taran-punjab-pb', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(460, 'Ajmer', 30, NULL, NULL, 1, 'ajmer-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(461, 'Alwar', 30, NULL, NULL, 1, 'alwar-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(462, 'Bikaner', 30, NULL, NULL, 1, 'bikaner-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(463, 'Barmer', 30, NULL, NULL, 1, 'barmer-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(464, 'Banswara', 30, NULL, NULL, 1, 'banswara-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(465, 'Bharatpur', 30, NULL, NULL, 1, 'bharatpur-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(466, 'Baran', 30, NULL, NULL, 1, 'baran-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(467, 'Bundi', 30, NULL, NULL, 1, 'bundi-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(468, 'Bhilwara', 30, NULL, NULL, 1, 'bhilwara-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(469, 'Churu', 30, NULL, NULL, 1, 'churu-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(470, 'Chittorgarh', 30, NULL, NULL, 1, 'chittorgarh-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(471, 'Dausa', 30, NULL, NULL, 1, 'dausa-rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(472, 'Dholpur', 30, NULL, NULL, 1, 'dholpur-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(473, 'Dungapur', 30, NULL, NULL, 1, 'dungapur-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(474, 'Ganganagar', 30, NULL, NULL, 1, 'ganganagar-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(475, 'Hanumangarh', 30, NULL, NULL, 1, 'hanumangarh-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(476, 'Jhunjhunu', 30, NULL, NULL, 1, 'jhunjhunu-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(477, 'Jalore', 30, NULL, NULL, 1, 'jalore-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(478, 'Jodhpur', 30, NULL, NULL, 1, 'jodhpur-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(479, 'Jaipur', 30, NULL, NULL, 1, 'jaipur-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(480, 'Jaisalmer', 30, NULL, NULL, 1, 'jaisalmer-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(481, 'Jhalawar', 30, NULL, NULL, 1, 'jhalawar-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(482, 'Karauli', 30, NULL, NULL, 1, 'karauli-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(483, 'Kota', 30, NULL, NULL, 1, 'kota-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(484, 'Nagaur', 30, NULL, NULL, 1, 'nagaur-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(485, 'Pali', 30, NULL, NULL, 1, 'pali-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(486, 'Pratapgarh', 30, NULL, NULL, 1, 'pratapgarh-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(487, 'Rajsamand', 30, NULL, NULL, 1, 'rajsamand-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(488, 'Sikar', 30, NULL, NULL, 1, 'sikar-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(489, 'Sawai Madhopur', 30, NULL, NULL, 1, 'sawai-madhopur-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(490, 'Sirohi', 30, NULL, NULL, 1, 'sirohi-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(491, 'Tonk', 30, NULL, NULL, 1, 'tonk-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(492, 'Udaipur', 30, NULL, NULL, 1, 'udaipur-rajasthan-rj', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(493, 'East Sikkim', 31, NULL, NULL, 1, 'east-sikkim-sikkim-sk', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(494, 'North Sikkim', 31, NULL, NULL, 1, 'north-sikkim-sikkim-sk', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(495, 'South Sikkim', 31, NULL, NULL, 1, 'south-sikkim-sikkim-sk', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(496, 'West Sikkim', 31, NULL, NULL, 1, 'west-sikkim-sikkim-sk', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(497, 'Ariyalur', 32, NULL, NULL, 1, 'ariyalur-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(498, 'Chennai', 32, NULL, NULL, 1, 'chennai-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(499, 'Coimbatore', 32, NULL, NULL, 1, 'coimbatore-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(500, 'Cuddalore', 32, NULL, NULL, 1, 'cuddalore-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(501, 'Dharmapuri', 32, NULL, NULL, 1, 'dharmapuri-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(502, 'Dindigul', 32, NULL, NULL, 1, 'dindigul-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(503, 'Erode', 32, NULL, NULL, 1, 'erode-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(504, 'Kanchipuram', 32, NULL, NULL, 1, 'kanchipuram-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(505, 'Kanyakumari', 32, NULL, NULL, 1, 'kanyakumari-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(506, 'Karur', 32, NULL, NULL, 1, 'karur-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(507, 'Madurai', 32, NULL, NULL, 1, 'madurai-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(508, 'Nagapattinam', 32, NULL, NULL, 1, 'nagapattinam-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(509, 'Nilgiris', 32, NULL, NULL, 1, 'nilgiris-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(510, 'Namakkal', 32, NULL, NULL, 1, 'namakkal-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(511, 'Perambalur', 32, NULL, NULL, 1, 'perambalur-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(512, 'Pudukkottai', 32, NULL, NULL, 1, 'pudukkottai-tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(513, 'Ramanathapuram', 32, NULL, NULL, 1, 'ramanathapuram-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(514, 'Salem', 32, NULL, NULL, 1, 'salem-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(515, 'Sivaganga', 32, NULL, NULL, 1, 'sivaganga-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(516, 'Tirupur', 32, NULL, NULL, 1, 'tirupur-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(517, 'Tiruchirappalli', 32, NULL, NULL, 1, 'tiruchirappalli-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(518, 'Theni', 32, NULL, NULL, 1, 'theni-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(519, 'Tirunelveli', 32, NULL, NULL, 1, 'tirunelveli-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(520, 'Thanjavur', 32, NULL, NULL, 1, 'thanjavur-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(521, 'Thoothukudi', 32, NULL, NULL, 1, 'thoothukudi-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(522, 'Tiruvallur', 32, NULL, NULL, 1, 'tiruvallur-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(523, 'Tiruvarur', 32, NULL, NULL, 1, 'tiruvarur-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(524, 'Tiruvannamalai', 32, NULL, NULL, 1, 'tiruvannamalai-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(525, 'Vellore', 32, NULL, NULL, 1, 'vellore-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(526, 'Viluppuram', 32, NULL, NULL, 1, 'viluppuram-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(527, 'Virudhunagar', 32, NULL, NULL, 1, 'virudhunagar-tamil-nadu-tn', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(528, 'Dhalai', 33, NULL, NULL, 1, 'dhalai-tripura-tr', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(529, 'North Tripura', 33, NULL, NULL, 1, 'north-tripura-tripura-tr', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(530, 'South Tripura', 33, NULL, NULL, 1, 'south-tripura-tripura-tr', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(531, 'Khowai', 33, NULL, NULL, 1, 'khowai-tripura-tr', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(532, 'West Tripura', 33, NULL, NULL, 1, 'west-tripura-tripura-tr', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(533, 'Agra', 34, NULL, NULL, 1, 'agra-uttar-pradesh-up', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(534, 'Allahabad', 34, NULL, NULL, 1, 'allahabad-uttar-pradesh-up', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(535, 'Aligarh', 34, NULL, NULL, 1, 'aligarh-uttar-pradesh-up', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(536, 'Ambedkar Nagar', 34, NULL, NULL, 1, 'ambedkar-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(537, 'Auraiya', 34, NULL, NULL, 1, 'auraiya-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(538, 'Azamgarh', 34, NULL, NULL, 1, 'azamgarh-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(539, 'Barabanki', 34, NULL, NULL, 1, 'barabanki-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(540, 'Budaun', 34, NULL, NULL, 1, 'budaun-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(541, 'Bagpat', 34, NULL, NULL, 1, 'bagpat-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(542, 'Bahraich', 34, NULL, NULL, 1, 'bahraich-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(543, 'Bijnor', 34, NULL, NULL, 1, 'bijnor-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(544, 'Ballia', 34, NULL, NULL, 1, 'ballia-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(545, 'Banda', 34, NULL, NULL, 1, 'banda-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(546, 'Balrampur', 34, NULL, NULL, 1, 'balrampur-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(547, 'Bareilly', 34, NULL, NULL, 1, 'bareilly-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(548, 'Basti', 34, NULL, NULL, 1, 'basti-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(549, 'Bulandshahr', 34, NULL, NULL, 1, 'bulandshahr-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(550, 'Chandauli', 34, NULL, NULL, 1, 'chandauli-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(551, 'Chhatrapati Shahuji Maharaj Nagar', 34, NULL, NULL, 1, 'chhatrapati-shahuji-maharaj-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(552, 'Chitrakoot', 34, NULL, NULL, 1, 'chitrakoot-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(553, 'Deoria', 34, NULL, NULL, 1, 'deoria-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(554, 'Etah', 34, NULL, NULL, 1, 'etah-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(555, 'Kanshi Ram Nagar', 34, NULL, NULL, 1, 'kanshi-ram-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(556, 'Etawah', 34, NULL, NULL, 1, 'etawah-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(557, 'Firozabad', 34, NULL, NULL, 1, 'firozabad-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(558, 'Farrukhabad', 34, NULL, NULL, 1, 'farrukhabad-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(559, 'Fatehpur', 34, NULL, NULL, 1, 'fatehpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:47', '2021-09-02 01:17:47'),
(560, 'Faizabad', 34, NULL, NULL, 1, 'faizabad-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(561, 'Gautam Buddh Nagar', 34, NULL, NULL, 1, 'gautam-buddh-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(562, 'Gonda', 34, NULL, NULL, 1, 'gonda-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(563, 'Ghazipur', 34, NULL, NULL, 1, 'ghazipur-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(564, 'Gorakhpur', 34, NULL, NULL, 1, 'gorakhpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(565, 'Ghaziabad', 34, NULL, NULL, 1, 'ghaziabad-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(566, 'Hamirpur', 34, NULL, NULL, 1, 'hamirpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(567, 'Hardoi', 34, NULL, NULL, 1, 'hardoi-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(568, 'Mahamaya Nagar', 34, NULL, NULL, 1, 'mahamaya-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(569, 'Jhansi', 34, NULL, NULL, 1, 'jhansi-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(570, 'Jalaun', 34, NULL, NULL, 1, 'jalaun-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(571, 'Jyotiba Phule Nagar', 34, NULL, NULL, 1, 'jyotiba-phule-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(572, 'Jaunpur district', 34, NULL, NULL, 1, 'jaunpur-district-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(573, 'Ramabai Nagar (Kanpur Dehat)', 34, NULL, NULL, 1, 'ramabai-nagar-kanpur-dehat-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(574, 'Kannauj', 34, NULL, NULL, 1, 'kannauj-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(575, 'Kanpur', 34, NULL, NULL, 1, 'kanpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:48', '2021-09-02 01:17:48'),
(576, 'Kaushambi', 34, NULL, NULL, 1, 'kaushambi-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(577, 'Kushinagar', 34, NULL, NULL, 1, 'kushinagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(578, 'Lalitpur', 34, NULL, NULL, 1, 'lalitpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(579, 'Lakhimpur Kheri', 34, NULL, NULL, 1, 'lakhimpur-kheri-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(580, 'Lucknow', 34, NULL, NULL, 1, 'lucknow-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(581, 'Mau', 34, NULL, NULL, 1, 'mau-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(582, 'Meerut', 34, NULL, NULL, 1, 'meerut-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(583, 'Maharajganj', 34, NULL, NULL, 1, 'maharajganj-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(584, 'Mahoba', 34, NULL, NULL, 1, 'mahoba-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(585, 'Mirzapur', 34, NULL, NULL, 1, 'mirzapur-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(586, 'Moradabad', 34, NULL, NULL, 1, 'moradabad-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(587, 'Mainpuri', 34, NULL, NULL, 1, 'mainpuri-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(588, 'Mathura', 34, NULL, NULL, 1, 'mathura-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(589, 'Muzaffarnagar', 34, NULL, NULL, 1, 'muzaffarnagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(590, 'Panchsheel Nagar district (Hapur)', 34, NULL, NULL, 1, 'panchsheel-nagar-district-hapur-uttar-pradesh-up', NULL, '2021-09-02 01:17:49', '2021-09-02 01:17:49'),
(591, 'Pilibhit', 34, NULL, NULL, 1, 'pilibhit-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(592, 'Shamli', 34, NULL, NULL, 1, 'shamli-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(593, 'Pratapgarh', 34, NULL, NULL, 1, 'pratapgarh-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(594, 'Rampur', 34, NULL, NULL, 1, 'rampur-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(595, 'Raebareli', 34, NULL, NULL, 1, 'raebareli-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(596, 'Saharanpur', 34, NULL, NULL, 1, 'saharanpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(597, 'Sitapur', 34, NULL, NULL, 1, 'sitapur-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(598, 'Shahjahanpur', 34, NULL, NULL, 1, 'shahjahanpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(599, 'Sant Kabir Nagar', 34, NULL, NULL, 1, 'sant-kabir-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(600, 'Siddharthnagar', 34, NULL, NULL, 1, 'siddharthnagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(601, 'Sonbhadra', 34, NULL, NULL, 1, 'sonbhadra-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(602, 'Sant Ravidas Nagar', 34, NULL, NULL, 1, 'sant-ravidas-nagar-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(603, 'Sultanpur', 34, NULL, NULL, 1, 'sultanpur-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(604, 'Shravasti', 34, NULL, NULL, 1, 'shravasti-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(605, 'Unnao', 34, NULL, NULL, 1, 'unnao-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(606, 'Varanasi', 34, NULL, NULL, 1, 'varanasi-uttar-pradesh-up', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(607, 'Almora', 35, NULL, NULL, 1, 'almora-uttarakhand-uk', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(608, 'Bageshwar', 35, NULL, NULL, 1, 'bageshwar-uttarakhand-uk', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(609, 'Chamoli', 35, NULL, NULL, 1, 'chamoli-uttarakhand-uk', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(610, 'Champawat', 35, NULL, NULL, 1, 'champawat-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(611, 'Dehradun', 35, NULL, NULL, 1, 'dehradun-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(612, 'Haridwar', 35, NULL, NULL, 1, 'haridwar-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(613, 'Nainital', 35, NULL, NULL, 1, 'nainital-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(614, 'Pauri Garhwal', 35, NULL, NULL, 1, 'pauri-garhwal-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(615, 'Pithoragarh', 35, NULL, NULL, 1, 'pithoragarh-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(616, 'Rudraprayag', 35, NULL, NULL, 1, 'rudraprayag-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(617, 'Tehri Garhwal', 35, NULL, NULL, 1, 'tehri-garhwal-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(618, 'Udham Singh Nagar', 35, NULL, NULL, 1, 'udham-singh-nagar-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(619, 'Uttarkashi', 35, NULL, NULL, 1, 'uttarkashi-uttarakhand-uk', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(620, 'Birbhum', 36, NULL, NULL, 1, 'birbhum-west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(621, 'Bankura', 36, NULL, NULL, 1, 'bankura-west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(622, 'Bardhaman', 36, NULL, NULL, 1, 'bardhaman-west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(623, 'Darjeeling', 36, NULL, NULL, 1, 'darjeeling-west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(624, 'Dakshin Dinajpur', 36, NULL, NULL, 1, 'dakshin-dinajpur-west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(625, 'Hooghly', 36, NULL, NULL, 1, 'hooghly-west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(626, 'Howrah', 36, NULL, NULL, 1, 'howrah-west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51'),
(627, 'Jalpaiguri', 36, NULL, NULL, 1, 'jalpaiguri-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(628, 'Cooch Behar', 36, NULL, NULL, 1, 'cooch-behar-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(629, 'Kolkata', 36, NULL, NULL, 1, 'kolkata-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(630, 'Maldah', 36, NULL, NULL, 1, 'maldah-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(631, 'Paschim Medinipur', 36, NULL, NULL, 1, 'paschim-medinipur-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(632, 'Purba Medinipur', 36, NULL, NULL, 1, 'purba-medinipur-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(633, 'Murshidabad', 36, NULL, NULL, 1, 'murshidabad-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(634, 'Nadia', 36, NULL, NULL, 1, 'nadia-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(635, 'North 24 Parganas', 36, NULL, NULL, 1, 'north-24-parganas-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(636, 'South 24 Parganas', 36, NULL, NULL, 1, 'south-24-parganas-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(637, 'Purulia', 36, NULL, NULL, 1, 'purulia-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52'),
(638, 'Uttar Dinajpur', 36, NULL, NULL, 1, 'uttar-dinajpur-west-bengal-wb', NULL, '2021-09-02 01:17:52', '2021-09-02 01:17:52');

-- --------------------------------------------------------

--
-- Table structure for table `claim_types`
--

CREATE TABLE `claim_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `claim_types`
--

INSERT INTO `claim_types` (`id`, `name`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`, `category`) VALUES
(1, 'Other expenditure', 1, 'other-expenditure', NULL, '2021-09-14 21:28:02', '2021-10-27 05:03:30', '[\"Food\",\"Telephone\",\"Rent\",\"Repairs\"]'),
(2, 'Travel', 1, 'travel', NULL, '2021-09-14 21:28:10', '2021-10-27 05:05:29', '[\"Self\",\"Auto\",\"Taxi\",\"Bus\",\"Train\",\"Flight\",\"Others\"]'),
(3, 'Employee Relief', 1, 'employee-relief', NULL, '2021-10-26 07:11:33', '2021-11-30 05:16:58', '[\"Advance\",\"Medical welfare\",\"Education Assitance\",\"Others\"]');

-- --------------------------------------------------------

--
-- Table structure for table `cost_centers`
--

CREATE TABLE `cost_centers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cost_centers`
--

INSERT INTO `cost_centers` (`id`, `name`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'Special programs', 1, 'special-programs', NULL, '2022-01-07 11:02:30', '2022-01-07 11:02:30'),
(5, 'Advance Course', 1, 'advance-course', NULL, '2022-01-07 11:02:37', '2022-01-07 11:02:37');

-- --------------------------------------------------------

--
-- Table structure for table `debit_accounts`
--

CREATE TABLE `debit_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `debit_accounts`
--

INSERT INTO `debit_accounts` (`id`, `name`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(6, '560000212212', 1, '560000212212', NULL, '2022-01-07 11:02:05', '2022-01-07 11:02:05'),
(7, '133300007800', 1, '133300007800', NULL, '2022-01-07 11:02:11', '2022-01-07 11:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specified_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `state_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `city_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `role_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver_manager` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `medical_welfare` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `original_password`, `mobile_code`, `mobile`, `phone`, `status`, `image`, `employee_code`, `tag`, `bank_account_type`, `bank_account_number`, `ifsc`, `pan`, `specified_person`, `address`, `location`, `zip`, `state_id`, `state_ary`, `city_id`, `city_ary`, `role_id`, `role_ary`, `user_id`, `user_ary`, `approver_manager`, `created_at`, `updated_at`, `medical_welfare`) VALUES
(1, 'Rahul', 'rahul@gmail.com', '$2y$10$zKMj7PDh/ZkIxubi5AhGfOGhYn.Cc5W1PLOaeJ9MiWIXCRyG28Io6', '123456', NULL, NULL, '9898989898', 1, NULL, 'R147', NULL, 'Saving', '98798798465456', '4TGE5R456', 'AQDS4654', 'Yes', 'JAIPUR', 'MANSROVAR', '303030', 8, '{\"id\":8,\"name\":\"Bihar (BR)\",\"slug\":\"bihar-br\"}', 69, '{\"id\":69,\"name\":\"Aurangabad\",\"slug\":\"aurangabad-bihar-br\"}', 4, '{\"id\":4,\"name\":\"Employee\",\"slug\":\"employee\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 4, '2021-09-15 02:05:42', '2022-02-22 10:59:18', 'Yes'),
(2, 'amit', 'amit@gmail.com', '$2y$10$ovarWq78.S6p7Lxqj3NDWOPWnyFFjOeZ.hYbfx2RZWAB4ByCRKJtS', '123456', NULL, NULL, '9898989898', 1, NULL, 'A0001', NULL, 'Saving', '98798798656516', 'SD2323', NULL, 'Yes', 'Jaipur', 'Mansrovar', '303030', 9, '{\"id\":9,\"name\":\"Chhattisgarh (CG)\",\"slug\":\"chhattisgarh-cg\"}', 110, '{\"id\":110,\"name\":\"Dhamtari\",\"slug\":\"dhamtari-chhattisgarh-cg\"}', 8, '{\"id\":8,\"name\":\"Vendor Approval Manager\",\"slug\":\"vendor-approval-manager\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2021-09-15 02:15:39', '2022-02-22 05:14:27', 'No'),
(3, 'dp', 'dp@gmail.com', '$2y$10$/uiFpTRn1yHL5CvwbqyF5OVs8lIRRmvppQf3MRNoonM6CGe8oJmB6', '123456', NULL, NULL, '3214569875', 1, NULL, 'D717', NULL, 'Saving', '4365141654654654', '4SD6A465465', NULL, 'Yes', 'jaipur', 'mans', '102020', 5, '{\"id\":5,\"name\":\"Andhra Pradesh (AP)\",\"slug\":\"andhra-pradesh-ap\"}', 3, '{\"id\":3,\"name\":\"Anantapur\",\"slug\":\"anantapur-andhra-pradesh-ap\"}', 9, '{\"id\":9,\"name\":\"Account office\",\"slug\":\"account-office\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2021-09-15 02:19:24', '2021-10-07 04:34:15', NULL),
(4, 'pawan', 'pawan@gmail.com', '$2y$10$/DRVgNoPOlxgqhh78m.T6ethYJXtisqCULZzxIcRAK3TEvUPWQ22a', '123456', NULL, NULL, '9898989898', 1, NULL, 'PW123', NULL, 'Saving', '98798798465456', '4TGE5R456', NULL, 'Yes', 'JAIPUR', 'MANSROVAR', '303030', 8, '{\"id\":8,\"name\":\"Bihar (BR)\",\"slug\":\"bihar-br\"}', 69, '{\"id\":69,\"name\":\"Aurangabad\",\"slug\":\"aurangabad-bihar-br\"}', 5, '{\"id\":5,\"name\":\"Employee Manager\",\"slug\":\"employee-manager\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2021-09-15 02:55:28', '2022-02-03 11:37:17', 'Yes'),
(5, 'ARG', 'arg@gmail.com', '$2y$10$doNixDLj2Le0zITk17wqCO0xk9NUZcvGXgsXUjYDcxf5wUh5772Qa', '123456', NULL, NULL, '9898989898', 1, NULL, 'ARG123', 'SFDFD', 'Saving', '98798798465456', '4TGE5R456', 'ASFSF5448', 'Yes', 'JAIPUR', 'MANSROVAR', '303030', 8, '{\"id\":8,\"name\":\"Bihar (BR)\",\"slug\":\"bihar-br\"}', 69, '{\"id\":69,\"name\":\"Aurangabad\",\"slug\":\"aurangabad-bihar-br\"}', 7, '{\"id\":7,\"name\":\"Trust Office\",\"slug\":\"trust-office\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2021-09-15 02:55:28', '2021-11-19 11:33:59', NULL),
(7, 'pay', 'pay@gmail.com', '$2y$10$S778eyOwKTuJUZnTljM6J.oCzoR5HrLQ5UNOXnAP.gDFXjsJWGOGm', '123456', NULL, NULL, '9874563210', 1, NULL, '123556546', 'JGHHG', 'Saving', '987986545645645', '65d4f6545', '654654', 'Yes', 'jaipur', 'mansrovar', '30220', 7, '{\"id\":7,\"name\":\"Assam (AS)\",\"slug\":\"assam-as\"}', 42, '{\"id\":42,\"name\":\"Bongaigaon\",\"slug\":\"bongaigaon-assam-as\"}', 10, '{\"id\":10,\"name\":\"Payments Office\",\"slug\":\"payments-office\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2021-10-19 02:48:26', '2021-10-19 02:51:31', NULL),
(8, 'TDS office', 'tds@gmail.com', '$2y$10$NlbGB.qfXsPLiju8A2y/COflOPEicQi54GQ7zC2S9xjrKHM0hCzxi', '123456', NULL, NULL, '9874563210', 1, NULL, 'TDS132132', 'DWRWRRDFD', 'Saving', '9879846553', 'SAD323', 'ADS3213AED', 'Yes', 'Jaipur', 'Mansrovar', '203030', 9, '{\"id\":9,\"name\":\"Chhattisgarh (CG)\",\"slug\":\"chhattisgarh-cg\"}', 109, '{\"id\":109,\"name\":\"Dantewada\",\"slug\":\"dantewada-chhattisgarh-cg\"}', 11, '{\"id\":11,\"name\":\"TDS Office\",\"slug\":\"tds-office\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2021-10-19 02:54:37', '2021-10-19 02:54:37', NULL),
(9, 'EMPLOYEE 2', 'employee@gmail.com', '$2y$10$hrQgoQ2ipxNXKwG7Mgzxeu2L.LZARF9z4EKS2TNi4T/jweTNIYiAa', '123456', NULL, NULL, '3214569875', 1, NULL, 'eaaed', 'EMPLOYEE', 'Saving', NULL, NULL, 'ASADS2315A', 'Yes', 'dzsfds', 'da', 'r342424', 8, '{\"id\":8,\"name\":\"Bihar (BR)\",\"slug\":\"bihar-br\"}', 67, '{\"id\":67,\"name\":\"Araria\",\"slug\":\"araria-bihar-br\"}', 4, '{\"id\":4,\"name\":\"Employee\",\"slug\":\"employee\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 11, '2021-12-23 07:24:24', '2022-01-25 09:08:40', 'Yes'),
(11, 'MANAGER', 'manager@gmail.com', '$2y$10$BitGdd0vrVTyhS8t9obuC.1CtKTynGEL9eQa/ZdePTddUbTr83CZq', '123456', NULL, NULL, '9880014935', 1, NULL, 'EMP456', 'EMPLOYEE', 'Saving', NULL, NULL, 'VEDPN2376D', 'No', 'LKDJLKR', ':WLDJ', '562111', 19, '{\"id\":19,\"name\":\"Karnataka (KA)\",\"slug\":\"karnataka-ka\"}', 244, '{\"id\":244,\"name\":\"Bangalore Rural\",\"slug\":\"bangalore-rural-karnataka-ka\"}', 5, '{\"id\":5,\"name\":\"Employee Manager\",\"slug\":\"employee-manager\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2022-01-24 06:12:01', '2022-01-25 09:09:10', 'Yes'),
(12, 'PRASANTH NAIR', 'trustee@gmail.com', '$2y$10$iyHhHUBUjeNkP68ZqqC78.pc.3qVqufXjbDTuk867Id/xcaPr9ulK', '123456', NULL, NULL, '8877112233', 1, NULL, 'TRUSTEE1', 'EMPLOYEE', 'Saving', NULL, NULL, 'FHHHSSLKLPP', 'No', 'LAFKJHFLKJ', 'LSFJ', '560002', 19, '{\"id\":19,\"name\":\"Karnataka (KA)\",\"slug\":\"karnataka-ka\"}', 244, '{\"id\":244,\"name\":\"Bangalore Rural\",\"slug\":\"bangalore-rural-karnataka-ka\"}', 7, '{\"id\":7,\"name\":\"Trust Office\",\"slug\":\"trust-office\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 0, '2022-01-24 06:29:14', '2022-01-24 06:30:33', 'Yes'),
(13, 'EMPLOYEE 3', 'employee3@gmail.com', '$2y$10$naD9DqPS/MsD2vlDNuhROOXKtPdaIV5gtPOJtaCVOXmkCcV.9Lz66', '123456', NULL, NULL, '9889966771', 1, NULL, 'EMP001', 'EMPLOYEE', 'Saving', NULL, NULL, 'SDCJPN237F', 'No', 'LAKFDJ ADLKH FLK', 'LWKF', '566662', 7, '{\"id\":7,\"name\":\"Assam (AS)\",\"slug\":\"assam-as\"}', 42, '{\"id\":42,\"name\":\"Bongaigaon\",\"slug\":\"bongaigaon-assam-as\"}', 4, '{\"id\":4,\"name\":\"Employee\",\"slug\":\"employee\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 11, '2022-01-25 09:11:15', '2022-02-03 11:35:16', 'No'),
(14, 'Employee3 Medical', 'employee4@gmail.com', '$2y$10$vh2Pga8.qQtEPlky2L.uaub079IhpNpoEsykaO0HwuAkLIWFNT8Ga', '12345678', NULL, NULL, '9880014935', 1, NULL, 'EMP001-MED', 'Employee', 'Saving', NULL, NULL, 'ERDDFFCCJJ', 'No', 'slfj', 'lAKF', '560082', 5, '{\"id\":5,\"name\":\"Andhra Pradesh (AP)\",\"slug\":\"andhra-pradesh-ap\"}', 4, '{\"id\":4,\"name\":\"Chittoor\",\"slug\":\"chittoor-andhra-pradesh-ap\"}', 4, '{\"id\":4,\"name\":\"Employee\",\"slug\":\"employee\"}', 1, '{\"id\":1,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"mobile\":null}', 4, '2022-02-03 11:32:42', '2022-02-03 11:34:54', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `employee_assign_processes`
--

CREATE TABLE `employee_assign_processes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employees_id` bigint(20) UNSIGNED NOT NULL,
  `assign_processes_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_assign_processes`
--

INSERT INTO `employee_assign_processes` (`id`, `employees_id`, `assign_processes_id`, `created_at`, `updated_at`) VALUES
(480, 3, 2, '2021-10-07 04:34:15', '2021-10-07 04:34:15'),
(481, 3, 3, '2021-10-07 04:34:15', '2021-10-07 04:34:15'),
(482, 3, 5, '2021-10-07 04:34:15', '2021-10-07 04:34:15'),
(483, 3, 6, '2021-10-07 04:34:15', '2021-10-07 04:34:15'),
(492, 7, 2, '2021-10-19 02:51:31', '2021-10-19 02:51:31'),
(493, 7, 3, '2021-10-19 02:51:31', '2021-10-19 02:51:31'),
(494, 7, 5, '2021-10-19 02:51:32', '2021-10-19 02:51:32'),
(495, 7, 6, '2021-10-19 02:51:32', '2021-10-19 02:51:32'),
(496, 8, 2, '2021-10-19 02:54:38', '2021-10-19 02:54:38'),
(497, 8, 3, '2021-10-19 02:54:38', '2021-10-19 02:54:38'),
(498, 8, 5, '2021-10-19 02:54:38', '2021-10-19 02:54:38'),
(499, 8, 6, '2021-10-19 02:54:38', '2021-10-19 02:54:38'),
(536, 5, 2, '2021-11-19 11:33:59', '2021-11-19 11:33:59'),
(537, 5, 3, '2021-11-19 11:33:59', '2021-11-19 11:33:59'),
(538, 5, 5, '2021-11-19 11:33:59', '2021-11-19 11:33:59'),
(539, 5, 6, '2021-11-19 11:33:59', '2021-11-19 11:33:59'),
(583, 12, 2, '2022-01-24 06:30:33', '2022-01-24 06:30:33'),
(584, 12, 3, '2022-01-24 06:30:33', '2022-01-24 06:30:33'),
(585, 12, 5, '2022-01-24 06:30:33', '2022-01-24 06:30:33'),
(586, 12, 6, '2022-01-24 06:30:33', '2022-01-24 06:30:33'),
(589, 9, 3, '2022-01-25 09:08:40', '2022-01-25 09:08:40'),
(590, 9, 5, '2022-01-25 09:08:40', '2022-01-25 09:08:40'),
(591, 9, 6, '2022-01-25 09:08:40', '2022-01-25 09:08:40'),
(592, 11, 2, '2022-01-25 09:09:10', '2022-01-25 09:09:10'),
(593, 11, 3, '2022-01-25 09:09:10', '2022-01-25 09:09:10'),
(606, 14, 2, '2022-02-03 11:34:54', '2022-02-03 11:34:54'),
(607, 13, 2, '2022-02-03 11:35:16', '2022-02-03 11:35:16'),
(608, 13, 3, '2022-02-03 11:35:16', '2022-02-03 11:35:16'),
(609, 13, 5, '2022-02-03 11:35:16', '2022-02-03 11:35:16'),
(610, 4, 2, '2022-02-03 11:37:17', '2022-02-03 11:37:17'),
(611, 4, 3, '2022-02-03 11:37:17', '2022-02-03 11:37:17'),
(612, 4, 5, '2022-02-03 11:37:17', '2022-02-03 11:37:17'),
(613, 4, 6, '2022-02-03 11:37:17', '2022-02-03 11:37:17'),
(626, 2, 2, '2022-02-22 05:14:27', '2022-02-22 05:14:27'),
(627, 2, 3, '2022-02-22 05:14:27', '2022-02-22 05:14:27'),
(628, 2, 5, '2022-02-22 05:14:27', '2022-02-22 05:14:27'),
(629, 2, 6, '2022-02-22 05:14:27', '2022-02-22 05:14:27'),
(630, 1, 2, '2022-02-22 05:14:34', '2022-02-22 05:14:34'),
(631, 1, 3, '2022-02-22 05:14:34', '2022-02-22 05:14:34'),
(632, 1, 5, '2022-02-22 05:14:34', '2022-02-22 05:14:34'),
(633, 1, 6, '2022-02-22 05:14:34', '2022-02-22 05:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `employee_bank_accounts`
--

CREATE TABLE `employee_bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employees_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_holder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_bank_accounts`
--

INSERT INTO `employee_bank_accounts` (`id`, `employees_id`, `bank_name`, `bank_account_number`, `branch_address`, `branch_code`, `bank_account_holder`, `ifsc`, `created_at`, `updated_at`) VALUES
(15, 12, 'DUMMY', 'DUMMY', NULL, 'DUMMY', NULL, 'DUMMY', '2022-01-24 06:30:33', '2022-01-24 06:30:33'),
(17, 9, 'rwfeas', '32432424', NULL, 'dfas', NULL, 'dsfw45', '2022-01-25 09:08:40', '2022-01-25 09:08:40'),
(18, 9, 'sdft', '345353535', NULL, 'ert', NULL, 'sdf', '2022-01-25 09:08:40', '2022-01-25 09:08:40'),
(19, 11, 'HDFC', '44558899', NULL, 'BR333', NULL, 'HDFC2222', '2022-01-25 09:09:10', '2022-01-25 09:09:10'),
(25, 14, 'IFSC', '2000300040', NULL, 'B21', NULL, 'IFSC001', '2022-02-03 11:34:54', '2022-02-03 11:34:54'),
(26, 13, 'IFSC', '2000300040', NULL, 'IFS', NULL, 'IFSC001', '2022-02-03 11:35:16', '2022-02-03 11:35:16'),
(27, 4, 'ICICI', '4567897890', NULL, 'IC9879', NULL, 'ICIC56767', '2022-02-03 11:37:17', '2022-02-03 11:37:17'),
(34, 2, 'rtyrte', 'erwe', NULL, 'tyrty', NULL, 'werer', '2022-02-22 05:14:27', '2022-02-22 05:14:27'),
(35, 1, 'a9sd', '987894679875', NULL, '987s9', NULL, '9ad97', '2022-02-22 05:14:34', '2022-02-22 05:14:34'),
(36, 1, '98sd798a', '987894679875', NULL, '9898', NULL, '9ad97', '2022-02-22 05:14:34', '2022-02-22 05:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `employee_pays`
--

CREATE TABLE `employee_pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_for_employee_id` bigint(20) UNSIGNED NOT NULL,
  `pay_for_employee_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specified_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nature_of_claim_id` bigint(20) UNSIGNED NOT NULL,
  `nature_of_claim_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apexe_id` bigint(20) UNSIGNED NOT NULL,
  `apexe_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_requested` int(11) NOT NULL DEFAULT 0,
  `amount_approved` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds` int(11) NOT NULL DEFAULT 0,
  `tds_amount` int(11) NOT NULL DEFAULT 0,
  `tds_month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `project_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_center` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int(11) NOT NULL DEFAULT 0,
  `manager_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_dept_id` int(11) NOT NULL DEFAULT 0,
  `account_dept_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_dept_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_ofc_id` int(11) NOT NULL DEFAULT 0,
  `trust_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_ofc_id` int(11) NOT NULL DEFAULT 0,
  `payment_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_ofc_id` int(11) NOT NULL DEFAULT 0,
  `tds_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `item_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `required_tds` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Yes or No',
  `sub_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_by_account` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_payable` int(11) NOT NULL DEFAULT 0,
  `date_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_date` date DEFAULT NULL,
  `account_date` date DEFAULT NULL,
  `trust_date` date DEFAULT NULL,
  `tds_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_pays`
--

INSERT INTO `employee_pays` (`id`, `order_id`, `pay_for`, `pay_for_employee_id`, `pay_for_employee_ary`, `address`, `bank_account_number`, `ifsc`, `pan`, `specified_person`, `nature_of_claim_id`, `nature_of_claim_ary`, `apexe_id`, `apexe_ary`, `amount_requested`, `amount_approved`, `description`, `tds`, `tds_amount`, `tds_month`, `project_id`, `cost_center`, `employee_id`, `employee_ary`, `manager_id`, `manager_ary`, `manager_comment`, `account_dept_id`, `account_dept_ary`, `account_dept_comment`, `trust_ofc_id`, `trust_ofc_ary`, `trust_ofc_comment`, `payment_ofc_id`, `payment_ofc_ary`, `payment_ofc_comment`, `tds_ofc_id`, `tds_ofc_ary`, `tds_ofc_comment`, `status`, `item_detail`, `created_at`, `updated_at`, `required_tds`, `sub_category`, `form_by_account`, `transaction_id`, `transaction_date`, `tds_payable`, `date_of_payment`, `manager_date`, `account_date`, `trust_date`, `tds_date`) VALUES
(20, 'A000020', 'self', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 'JAIPUR', '98798798789777', 'dc9a8', 'AQDS4654', 'No', 2, '{\"id\":2,\"name\":\"Travel\",\"slug\":\"travel\"}', 3, '{\"id\":3,\"name\":\"Gujrat\",\"slug\":\"gujrat\"}', 350, 350, 'DWDD', 60, 210, 'sererse', 'adsfrewsfwsf', 'fsfrsef', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'MNBADSVJRBJ', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'we2', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', NULL, 0, NULL, NULL, 0, NULL, NULL, 2, '{\"itemDetail\":[{\"date\":\"2022-01-08\",\"from_location\":\"JPR\",\"to_location\":\"ODISA\",\"distance\":\"1250\",\"category\":\"Auto\",\"bill_number\":\"98ASA\",\"amount\":\"150\",\"sub_category\":\"\"},{\"date\":\"2022-01-06\",\"from_location\":\"ASA\",\"to_location\":\"DFW\",\"distance\":\"350\",\"category\":\"Auto\",\"bill_number\":\"ADDA\",\"amount\":\"200\",\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-01-08 11:28:30', '2022-01-18 03:43:44', 'No', '', '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"200\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"},{\"debit_account\":\"133300007800\",\"amount\":\"150\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(21, 'A000021', 'self', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 'JAIPUR', '98798798789777', 'dc9a8', 'AQDS4654', 'No', 2, '{\"id\":2,\"name\":\"Travel\",\"slug\":\"travel\"}', 4, '{\"id\":4,\"name\":\"Punjab\",\"slug\":\"punjab\"}', 1200, 1200, 'wssxa', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'okkcx', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'ggj', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'tess', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-16\",\"from_location\":\"blr\",\"to_location\":\"jpr\",\"distance\":null,\"category\":\"Bus\",\"bill_number\":\"bj23t\",\"amount\":\"1200\",\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-01-18 08:34:00', '2022-01-18 08:49:07', 'No', '', '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"1200\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'ICICI1801', '2022-01-18', 0, '2022-01-18', NULL, NULL, NULL, NULL),
(22, 'A000022', 'other', 9, '{\"id\":9,\"name\":\"ade\",\"email\":\"eq@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 'dzsfds', '345353535', 'sdf', 'ASADS2315A', 'No', 1, '{\"id\":1,\"name\":\"Other expenditure\",\"slug\":\"other-expenditure\"}', 3, '{\"id\":3,\"name\":\"Gujrat\",\"slug\":\"gujrat\"}', 1740, 1740, 'ddxx', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'ered', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'bdas', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'dsfedsd', 0, NULL, NULL, 0, NULL, NULL, 2, '{\"itemDetail\":[{\"date\":\"2022-01-16\",\"location\":\"gj\",\"category\":\"Food\",\"quantity\":\"2\",\"rate\":\"120\",\"bill_number\":\"ss11s\",\"amount\":240,\"sub_category\":\"\"},{\"date\":\"2022-01-16\",\"location\":\"gj\",\"category\":\"Rent\",\"quantity\":\"1\",\"rate\":\"1500\",\"bill_number\":\"ewdx\",\"amount\":1500,\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-01-18 09:03:28', '2022-01-18 09:07:53', 'No', '', '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"240\",\"cost_center\":\"Advance Course\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"1500\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(23, 'A000023', 'other', 9, '{\"id\":9,\"name\":\"ade\",\"email\":\"eq@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 'dzsfds', '32432424', 'dsfw45', 'ASADS2315A', 'No', 3, '{\"id\":3,\"name\":\"Employee Relief\",\"slug\":\"employee-relief\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 34170, 34170, 'wwsce3e3', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'DFDFSD', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'DWDWSDSW', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'FEREE2221', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-01\",\"category\":\"Hospitalization\",\"bill_number\":\"363gbnnn\",\"amount\":\"34170\",\"sub_category\":\"Medical welfare\"}],\"medical\":{\"pay_to\":\"Pay to Hospital\",\"bank_name\":\"SBI\",\"bank_account_number\":\"372363372819\",\"branch_address\":\"shimo\",\"hsptl_name\":\"SSHRC\",\"bank_account_holder\":\"SSREWWML\",\"ifsc\":\"SBIN0023enn\",\"pan\":\"AARDS1234R\"}}', '2022-01-18 09:12:53', '2022-01-20 09:40:57', 'No', 'Medical welfare', '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"34170\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'REEWq2425', '2022-01-20', 0, '2022-01-20', NULL, NULL, NULL, NULL),
(24, 'A000024', 'self', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 'JAIPUR', '98798798789777', 'dc9a8', 'AQDS4654', 'No', 3, '{\"id\":3,\"name\":\"Employee Relief\",\"slug\":\"employee-relief\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 10000, 10000, 'slkfj LFKJ aSFLKj fLAJ', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'approved', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'erere', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'ree', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-19\",\"category\":\"Hospitalization\",\"bill_number\":\"H001\",\"amount\":\"10000\",\"sub_category\":\"Medical welfare\"}],\"medical\":{\"pay_to\":\"Pay to Hospital\",\"bank_name\":\"HDFC\",\"bank_account_number\":\"5555555555\",\"branch_address\":\"Bangalore\",\"hsptl_name\":\"SSY\",\"bank_account_holder\":\"SSY\",\"ifsc\":\"HDFC01220\",\"pan\":\"AJCRN21120\"}}', '2022-01-20 09:19:07', '2022-01-20 09:26:38', 'No', 'Medical welfare', '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"10000\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'REEWq2425', '2022-01-20', 0, '2022-01-20', NULL, NULL, NULL, NULL),
(25, 'A000025', 'other', 9, '{\"id\":9,\"name\":\"ade\",\"email\":\"eq@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 'dzsfds', '32432424', 'dsfw45', 'ASADS2315A', 'Yes', 1, '{\"id\":1,\"name\":\"Other expenditure\",\"slug\":\"other-expenditure\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 1500, 1500, 'SDSSD SSW zvgg', 10, 150, 'SCDSD', '54654dg654gdg46', 'SDFDSFS', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', NULL, 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', NULL, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-22\",\"location\":\"JPT\",\"category\":\"Repairs\",\"quantity\":\"15\",\"rate\":\"100\",\"bill_number\":\"1345468FD\",\"amount\":1500,\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-01-22 06:48:21', '2022-02-03 09:27:16', 'Yes', '', '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"1500\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'BSHH01', '2022-01-22', 0, '2022-01-22', NULL, NULL, NULL, NULL),
(26, 'A000026', 'other', 9, '{\"id\":9,\"name\":\"EMPLOYEE 2\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 'dzsfds', '32432424', 'dsfw45', 'ASADS2315A', 'No', 3, '{\"id\":3,\"name\":\"Employee Relief\",\"slug\":\"employee-relief\"}', 3, '{\"id\":3,\"name\":\"Gujrat\",\"slug\":\"gujrat\"}', 1000, 1000, 'a;fljf', 0, 0, '0', NULL, NULL, 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'eeded', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'DFSAS', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-11\",\"category\":\"fee\",\"bill_number\":\"F200\",\"amount\":\"1000\",\"sub_category\":\"Education Assitance\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-01-25 09:38:14', '2022-02-03 09:27:16', 'No', 'Education Assitance', '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"1000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'BSHH02', '2022-01-25', 0, '2022-01-25', NULL, NULL, NULL, NULL),
(27, 'A000027', 'self', 13, '{\"id\":13,\"name\":\"EMPLOYEE 2\",\"email\":\"employee2@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP001\"}', 'LAKFDJ ADLKH FLK', '2000300040', 'IFSC001', 'SDCJPN237F', 'No', 2, '{\"id\":2,\"name\":\"Travel\",\"slug\":\"travel\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 1000, 1000, 'SLFJFR', 0, 0, '0', NULL, NULL, 13, '{\"id\":13,\"name\":\"EMPLOYEE 2\",\"email\":\"employee2@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP001\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'feeee', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'DFEW', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-17\",\"from_location\":\"aslfkJ\",\"to_location\":\"askfd\",\"distance\":\"100\",\"category\":\"Taxi\",\"bill_number\":\"999\",\"amount\":\"1000\",\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-01-25 09:43:17', '2022-02-03 09:27:16', 'No', '', '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"1000\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'BSHH03', '2022-01-25', 0, '2022-01-25', NULL, NULL, NULL, NULL),
(28, 'A000028', 'self', 13, '{\"id\":13,\"name\":\"EMPLOYEE 3\",\"email\":\"employee3@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP001\"}', 'LAKFDJ ADLKH FLK', '2000300040', 'IFSC001', 'SDCJPN237F', 'No', 2, '{\"id\":2,\"name\":\"Travel\",\"slug\":\"travel\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 500, 500, 'fdj', 0, 0, '0', NULL, NULL, 13, '{\"id\":13,\"name\":\"EMPLOYEE 3\",\"email\":\"employee3@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP001\"}', 11, '{\"id\":11,\"name\":\"MANAGER\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', 'asldj', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'faa', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'HGFDSA', 0, NULL, NULL, 0, NULL, NULL, 2, '{\"itemDetail\":[{\"date\":\"2022-01-17\",\"from_location\":\"djfd\",\"to_location\":\"djdj\",\"distance\":\"10\",\"category\":\"Taxi\",\"bill_number\":\"B1\",\"amount\":\"500\",\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-01-25 09:46:58', '2022-01-25 09:52:48', 'No', '', '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"500\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(29, 'A000029', 'other', 13, '{\"id\":13,\"name\":\"EMPLOYEE 3\",\"email\":\"employee3@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP001\"}', 'LAKFDJ ADLKH FLK', '2000300040', 'IFSC001', 'SDCJPN237F', 'No', 3, '{\"id\":3,\"name\":\"Employee Relief\",\"slug\":\"employee-relief\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 35000, 35000, 'SJHJHJWJWJ', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'rtereewe', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'oiuytre', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'ytrew', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-18\",\"category\":\"Hospitalization\",\"bill_number\":\"HEIWJ22\",\"amount\":\"35000\",\"sub_category\":\"Medical welfare\"}],\"medical\":{\"pay_to\":\"Pay to Hospital\",\"bank_name\":\"IDBI\",\"bank_account_number\":\"384437432402\",\"branch_address\":\"BLRerkwerowekr\",\"hsptl_name\":\"SSHEREGWH\",\"bank_account_holder\":\"SGWGWJWB\",\"ifsc\":\"IDBI00e2e2\",\"pan\":\"RRRRERWW2\"}}', '2022-01-26 04:26:40', '2022-02-03 09:27:16', 'No', 'Medical welfare', '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"35000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'SSSU001', '2022-01-26', 0, '2022-01-26', NULL, NULL, NULL, NULL),
(30, 'U020222-30', 'self', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 'JAIPUR', '98798798789777', 'dc9a8', 'AQDS4654', 'No', 3, '{\"id\":3,\"name\":\"Employee Relief\",\"slug\":\"employee-relief\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 343440, 343440, 'wrrrffx', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'UYTR', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'TREEEASQWQW', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'WQWQWQW', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-15\",\"category\":\"Hospitalization\",\"bill_number\":\"ertrt22\",\"amount\":\"343440\",\"sub_category\":\"Medical welfare\"}],\"medical\":{\"pay_to\":\"Pay to Hospital\",\"bank_name\":\"HDFC\",\"bank_account_number\":\"2325251611781819\",\"branch_address\":\"RTREWBWB\",\"hsptl_name\":\"DHOSPITAL\",\"bank_account_holder\":\"DEWTWGWHHHOSPITAL\",\"ifsc\":\"HDFC232424\",\"pan\":\"ryuiioo\"}}', '2022-02-02 15:30:49', '2022-02-03 09:27:16', 'No', 'Medical welfare', '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"343440\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', 'HWYW1', '2022-02-02', 0, '2022-02-02', NULL, NULL, NULL, NULL),
(31, 'U020222-31', 'other', 13, '{\"id\":13,\"name\":\"EMPLOYEE 3\",\"email\":\"employee3@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP001\"}', 'LAKFDJ ADLKH FLK', '2000300040', 'IFSC001', 'SDCJPN237F', 'No', 2, '{\"id\":2,\"name\":\"Travel\",\"slug\":\"travel\"}', 3, '{\"id\":3,\"name\":\"Gujrat\",\"slug\":\"gujrat\"}', 1558, 1558, 'TREWEW', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'EW', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'TREEEW', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'YTRE', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-01-13\",\"from_location\":\"GJ\",\"to_location\":\"BLR\",\"distance\":\"546\",\"category\":\"Train\",\"bill_number\":\"44543\",\"amount\":\"1235\",\"sub_category\":\"\"},{\"date\":\"2022-01-14\",\"from_location\":\"BLR\",\"to_location\":\"ASH\",\"distance\":\"35\",\"category\":\"Taxi\",\"bill_number\":\"5644\",\"amount\":\"323\",\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-02-02 15:35:13', '2022-02-03 09:27:16', 'No', '', '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"1235\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"323\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'HWYW2', '2022-02-02', 0, '2022-02-02', NULL, NULL, NULL, NULL),
(32, 'EP030222-32', 'self', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile_code\":null,\"mobile\":null,\"phone\":\"9898989898\",\"employee_code\":\"R147\",\"bank_account_type\":\"Saving\",\"bank_account_number\":\"98798798465456\",\"ifsc\":\"4TGE5R456\",\"pan\":\"AQDS4654\",\"specified_person\":\"Yes\",\"address\":\"JAIPUR\",\"location\":\"MANSROVAR\",\"zip\":\"303030\",\"medical_welfare\":\"Yes\"}', 'JAIPUR', '98798798789777', 'dc9a8', 'AQDS4654', 'No', 1, '{\"id\":1,\"name\":\"Other expenditure\",\"slug\":\"other-expenditure\"}', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 1000, 1000, 'alkdj', 0, 0, '0', NULL, NULL, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile_code\":null,\"mobile\":null,\"phone\":\"9898989898\",\"employee_code\":\"R147\",\"bank_account_type\":\"Saving\",\"bank_account_number\":\"98798798465456\",\"ifsc\":\"4TGE5R456\",\"pan\":\"AQDS4654\",\"specified_person\":\"Yes\",\"address\":\"JAIPUR\",\"location\":\"MANSROVAR\",\"zip\":\"303030\",\"medical_welfare\":\"Yes\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'yrew322022', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'rew', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, 0, NULL, NULL, 6, '{\"itemDetail\":[{\"date\":\"2022-02-02\",\"location\":\"Bangalore\",\"category\":\"Food\",\"quantity\":\"1\",\"rate\":\"1000\",\"bill_number\":\"BILL01\",\"amount\":1000,\"sub_category\":\"\"}],\"medical\":{\"pay_to\":\"\",\"bank_name\":\"\",\"bank_account_number\":\"\",\"branch_address\":\"\",\"hsptl_name\":\"\",\"bank_account_holder\":\"\",\"ifsc\":\"\",\"pan\":\"\"}}', '2022-02-03 11:16:50', '2022-02-11 10:10:13', 'No', '', '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"1000\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'rewq', '2022-02-03', 0, '2022-02-03', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_pay_files`
--

CREATE TABLE `employee_pay_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_req_id` bigint(20) UNSIGNED NOT NULL,
  `emp_req_file_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_req_file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_req_file_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_pay_files`
--

INSERT INTO `employee_pay_files` (`id`, `emp_req_id`, `emp_req_file_type`, `emp_req_file_path`, `emp_req_file_description`, `created_at`, `updated_at`) VALUES
(1, 21, 'jpg', 'EmployeePay/1642494840537065021.jpg', 'rereded', '2022-01-18 08:34:00', '2022-01-18 08:34:00'),
(2, 22, 'pdf', 'EmployeePay/1642496608154890022.pdf', 'fd', '2022-01-18 09:03:28', '2022-01-18 09:03:28'),
(3, 22, 'jpg', 'EmployeePay/1642496608154890122.jpg', 'rt', '2022-01-18 09:03:29', '2022-01-18 09:03:29'),
(4, 23, 'jpg', 'EmployeePay/1642497173390031023.jpg', 'ddw2hrereQQQ', '2022-01-18 09:12:53', '2022-01-18 09:12:53'),
(5, 24, 'pdf', 'EmployeePay/1642670346316413024.pdf', 'slfj', '2022-01-20 09:19:07', '2022-01-20 09:19:07'),
(6, 26, 'jpg', 'EmployeePay/1643103494442255026.jpg', 'lfkj', '2022-01-25 09:38:14', '2022-01-25 09:38:14'),
(7, 27, 'jpg', 'EmployeePay/1643103797948882027.jpg', NULL, '2022-01-25 09:43:17', '2022-01-25 09:43:17'),
(8, 29, 'pdf', 'EmployeePay/1643171200956270029.pdf', 'GWHW', '2022-01-26 04:26:40', '2022-01-26 04:26:40'),
(9, 30, 'jpg', 'EmployeePay/1643815849399735030.jpg', 'rtt', '2022-02-02 15:30:49', '2022-02-02 15:30:49'),
(10, 31, 'jpg', 'EmployeePay/1643816113307752031.jpg', 'YTREW', '2022-02-02 15:35:13', '2022-02-02 15:35:13'),
(11, 32, 'pdf', 'EmployeePay/1643887010266047032.pdf', NULL, '2022-02-03 11:16:50', '2022-02-03 11:16:50');

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_transfers`
--

CREATE TABLE `internal_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nature_of_request` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apex_id` int(11) NOT NULL DEFAULT 0,
  `apex_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_bank_id` int(11) NOT NULL DEFAULT 0,
  `state_bank_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_holder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_center` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_from` int(11) NOT NULL DEFAULT 0,
  `transfer_from_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transfer_to` int(11) NOT NULL DEFAULT 0,
  `transfer_to_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_date` date DEFAULT NULL,
  `account_dept_id` int(11) NOT NULL DEFAULT 0,
  `account_dept_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_dept_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountant_date` date DEFAULT NULL,
  `trust_ofc_id` int(11) NOT NULL DEFAULT 0,
  `trust_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_date` date DEFAULT NULL,
  `payment_ofc_id` int(11) NOT NULL DEFAULT 0,
  `payment_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `apexe_id` int(11) NOT NULL DEFAULT 0,
  `apexe_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_by_account` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internal_transfers`
--

INSERT INTO `internal_transfers` (`id`, `order_id`, `nature_of_request`, `apex_id`, `apex_ary`, `state_bank_id`, `state_bank_ary`, `bank_name`, `bank_account_number`, `branch_address`, `branch_code`, `bank_account_holder`, `ifsc`, `project_name`, `reason`, `project_id`, `cost_center`, `transfer_from`, `transfer_from_ary`, `transfer_to`, `transfer_to_ary`, `amount`, `employee_id`, `employee_ary`, `employee_date`, `account_dept_id`, `account_dept_ary`, `account_dept_comment`, `accountant_date`, `trust_ofc_id`, `trust_ofc_ary`, `trust_ofc_comment`, `trust_date`, `payment_ofc_id`, `payment_ofc_ary`, `payment_ofc_comment`, `payment_date`, `description`, `status`, `created_at`, `updated_at`, `apexe_id`, `apexe_ary`, `form_by_account`, `transaction_id`, `transaction_date`, `date_of_payment`) VALUES
(6, 'A000006', 'State requesting funds', 5, '{\"id\":5,\"name\":\"Rajasthan\",\"status\":1,\"slug\":\"rajasthan\",\"deleted_at\":null,\"created_at\":\"2021-10-27T00:36:40.000000Z\",\"updated_at\":\"2021-10-27T00:36:40.000000Z\"}', 3, '{\"id\":3,\"bank_name\":\"CITI\",\"bank_account_number\":\"1214454545466\",\"branch_address\":\"Jayanager\",\"branch_code\":\"1221145\",\"bank_account_holder\":\"Head Office\",\"ifsc\":\"11225533\",\"slug\":\"1214454545466\",\"status\":1,\"created_at\":\"2022-01-05T05:29:17.000000Z\",\"updated_at\":\"2022-01-07T12:03:32.000000Z\",\"deleted_at\":null,\"apexe_id\":5,\"apexe_ary\":\"{\\\"id\\\":5,\\\"name\\\":\\\"Head Office\\\",\\\"slug\\\":\\\"head-office\\\"}\"}', NULL, NULL, NULL, NULL, NULL, '11225533', 'DSSDFW4534564', 'adsfasf', 'DSRVRRRerw5654645', 'Special programs', 0, NULL, 0, NULL, 345, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', '2022-01-13', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'DWED', NULL, 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'DWSDW WERWE WEWEWE W', NULL, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-10', NULL, 5, '2022-01-10 06:03:12', '2022-01-21 04:01:29', 5, '{\"id\":5,\"name\":\"Rajasthan\",\"slug\":\"rajasthan\"}', '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"200\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"145\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"\",\"ifsc\":\"\",\"bank_name\":\"\"}', 'EEEERRRR', '2022-01-10', '2022-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `internal_transfer_files`
--

CREATE TABLE `internal_transfer_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `internal_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `internal_transfer_file_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internal_transfer_file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internal_transfer_file_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_id` bigint(20) UNSIGNED NOT NULL,
  `po_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_status` int(11) NOT NULL DEFAULT 1,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) NOT NULL DEFAULT 0,
  `tax_amount` int(11) NOT NULL DEFAULT 0,
  `invoice_amount` int(11) NOT NULL DEFAULT 0,
  `po_file_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver_manager` int(11) NOT NULL DEFAULT 0,
  `manager_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver_financer` int(11) NOT NULL DEFAULT 0,
  `financer_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financer_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver_trust` int(11) NOT NULL DEFAULT 0,
  `approver_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_approval_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_by_account` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advance_payment_mode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specified_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Yes or No',
  `tds` int(11) NOT NULL DEFAULT 0,
  `tds_amount` int(11) NOT NULL DEFAULT 0,
  `tds_payable` int(11) NOT NULL DEFAULT 0,
  `payment_ofc_id` int(11) NOT NULL DEFAULT 0,
  `payment_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `tds_ofc_id` int(11) NOT NULL DEFAULT 0,
  `tds_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_date` date DEFAULT NULL,
  `apexe_id` int(11) NOT NULL DEFAULT 0,
  `apexe_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_month` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_date` date DEFAULT NULL,
  `financer_date` date DEFAULT NULL,
  `account_date` date DEFAULT NULL,
  `trust_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `vendor_id`, `vendor_ary`, `po_id`, `po_ary`, `invoice_status`, `invoice_number`, `invoice_date`, `amount`, `tax`, `tax_amount`, `invoice_amount`, `po_file_type`, `invoice_file_path`, `employee_id`, `employee_ary`, `approver_manager`, `manager_ary`, `manager_comment`, `approver_financer`, `financer_ary`, `financer_comment`, `approver_trust`, `approver_ary`, `trust_comment`, `invoice_approval_date`, `form_by_account`, `advance_payment_mode`, `item_detail`, `created_at`, `updated_at`, `order_id`, `specified_person`, `tds`, `tds_amount`, `tds_payable`, `payment_ofc_id`, `payment_ofc_ary`, `payment_ofc_comment`, `payment_date`, `tds_ofc_id`, `tds_ofc_ary`, `tds_ofc_comment`, `tds_date`, `apexe_id`, `apexe_ary`, `tds_month`, `transaction_id`, `transaction_date`, `date_of_payment`, `manager_date`, `financer_date`, `account_date`, `trust_date`) VALUES
(1, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\"}', 11, '{\"id\":11,\"order_id\":\"A000011\",\"po_start_date\":\"2022-01-01\",\"po_end_date\":\"2022-01-08\",\"item_detail\":\"[{\\\"item_name\\\":\\\"ASNDVJGVjn\\\",\\\"quantity\\\":\\\"150\\\",\\\"unit\\\":\\\"DDS\\\",\\\"rate\\\":\\\"15\\\",\\\"total\\\":2700,\\\"price_unit\\\":\\\"adfas\\\",\\\"tax\\\":\\\"20\\\",\\\"tax_amt\\\":450},{\\\"item_name\\\":\\\"DEWF\\\",\\\"quantity\\\":\\\"100\\\",\\\"unit\\\":\\\"ASDW\\\",\\\"rate\\\":\\\"10\\\",\\\"total\\\":1100,\\\"price_unit\\\":\\\"asdasd\\\",\\\"tax\\\":\\\"10\\\",\\\"tax_amt\\\":100}]\",\"total\":3800,\"discount\":200,\"net_payable\":3600,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 2, '123456', '2022-01-07', 900, 10, 90, 990, 'jpg', 'invoice/1641537173847320.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'wqeww', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'FDEFEF', 0, NULL, NULL, NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"500\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"400\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', 'Yes', '[{\"item_name\":\"t1\",\"quantity\":\"10\",\"unit\":\"KG\",\"rate\":\"80\",\"total\":880,\"price_unit\":\"CommentCommentCo men tCo mment\",\"tax\":\"10\",\"tax_amt\":80},{\"item_name\":\"t2\",\"quantity\":\"1\",\"unit\":\"LTR\",\"rate\":\"100\",\"total\":110,\"price_unit\":\"Com me nt Co mment\",\"tax\":\"10\",\"tax_amt\":10}]', '2022-01-07 06:32:53', '2022-01-25 08:49:47', 'A000001', 'Yes', 10, 90, 900, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2, '{\"id\":2,\"name\":\"Haryana\",\"slug\":\"haryana\"}', 'dcasfs', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\"}', 11, '{\"id\":11,\"order_id\":\"A000011\",\"po_start_date\":\"2022-01-01\",\"po_end_date\":\"2022-01-08\",\"item_detail\":\"[{\\\"item_name\\\":\\\"ASNDVJGVjn\\\",\\\"quantity\\\":\\\"150\\\",\\\"unit\\\":\\\"DDS\\\",\\\"rate\\\":\\\"15\\\",\\\"total\\\":2700,\\\"price_unit\\\":\\\"adfas\\\",\\\"tax\\\":\\\"20\\\",\\\"tax_amt\\\":450},{\\\"item_name\\\":\\\"DEWF\\\",\\\"quantity\\\":\\\"100\\\",\\\"unit\\\":\\\"ASDW\\\",\\\"rate\\\":\\\"10\\\",\\\"total\\\":1100,\\\"price_unit\\\":\\\"asdasd\\\",\\\"tax\\\":\\\"10\\\",\\\"tax_amt\\\":100}]\",\"total\":3800,\"discount\":200,\"net_payable\":3600,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, '12345678', '2022-01-05', 1200, 10, 120, 1320, 'jpg', 'invoice/1641541527695109.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'tesdsds', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'errww', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"800\",\"cost_center\":\"Advance Course\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"520\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'No', '[{\"item_name\":\"T1\",\"quantity\":\"13\",\"unit\":\"LT\",\"rate\":\"100\",\"total\":1300,\"price_unit\":\"HGWDgJVFWGj\",\"tax\":\"0\",\"tax_amt\":0}]', '2022-01-07 07:45:27', '2022-01-14 04:39:55', 'A000002', 'No', 5, 60, 1260, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-13', 0, NULL, NULL, NULL, 2, '{\"id\":2,\"name\":\"Haryana\",\"slug\":\"haryana\"}', 'DSS94', 'SBIN1130122', '2022-01-13', '2022-01-13', NULL, NULL, NULL, NULL),
(3, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\"}', 11, '{\"id\":11,\"order_id\":\"A000011\",\"po_start_date\":\"2022-01-01\",\"po_end_date\":\"2022-01-08\",\"item_detail\":\"[{\\\"item_name\\\":\\\"ASNDVJGVjn\\\",\\\"quantity\\\":\\\"150\\\",\\\"unit\\\":\\\"DDS\\\",\\\"rate\\\":\\\"15\\\",\\\"total\\\":2700,\\\"price_unit\\\":\\\"adfas\\\",\\\"tax\\\":\\\"20\\\",\\\"tax_amt\\\":450},{\\\"item_name\\\":\\\"DEWF\\\",\\\"quantity\\\":\\\"100\\\",\\\"unit\\\":\\\"ASDW\\\",\\\"rate\\\":\\\"10\\\",\\\"total\\\":1100,\\\"price_unit\\\":\\\"asdasd\\\",\\\"tax\\\":\\\"10\\\",\\\"tax_amt\\\":100}]\",\"total\":3800,\"discount\":200,\"net_payable\":3600,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'adsfs4654465', '2022-01-08', 1000, 25, 250, 1250, 'jpg', 'invoice/1642069255235228.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'rerere444', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'dfgdfe', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"750\",\"cost_center\":\"Advance Course\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"200\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"},{\"debit_account\":\"133300007800\",\"amount\":\"300\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'No', NULL, '2022-01-13 10:20:55', '2022-01-14 04:39:55', 'A000003', 'No', 10, 100, 1150, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-14', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 'sfffffdf', 'SBIN2130122', '2022-01-13', '2022-01-14', NULL, NULL, NULL, NULL),
(4, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', 12, '{\"id\":12,\"order_id\":\"P000012\",\"po_start_date\":\"2022-01-01\",\"po_end_date\":\"2022-01-30\",\"item_detail\":\"[{\\\"item_name\\\":\\\"Bankwidh\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"MB\\\",\\\"rate\\\":\\\"250\\\",\\\"total\\\":295,\\\"price_unit\\\":null,\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":45}]\",\"total\":295,\"discount\":0,\"net_payable\":295,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'TEL/4/21-22', '2022-01-20', 270, 18, 49, 319, 'jpg', 'invoice/1642738604197556.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'weq', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', '544ccff', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'uytrewq', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"319\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', 'No', NULL, '2022-01-21 04:16:44', '2022-02-09 09:27:16', 'A000004', 'No', 0, 0, 319, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-02-09', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, '45344545ic', '2022-02-09', '2022-02-09', NULL, NULL, NULL, NULL),
(5, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', 13, '{\"id\":13,\"order_id\":\"P000013\",\"po_start_date\":\"2022-01-03\",\"po_end_date\":\"2022-01-28\",\"item_detail\":\"[{\\\"item_name\\\":\\\"Mobile\\\",\\\"quantity\\\":\\\"10\\\",\\\"unit\\\":\\\"handset\\\",\\\"rate\\\":\\\"10000\\\",\\\"total\\\":118000,\\\"price_unit\\\":\\\"handsets\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":18000}]\",\"total\":118000,\"discount\":0,\"net_payable\":118000,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'INV1919', '2022-01-03', 50000, 18, 9000, 59000, 'pdf', 'invoice/1642761935640550.pdf', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'fchgvjhkj', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'hgchgj', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'RFDFD', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"49000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"10000\",\"cost_center\":\"Advance Course\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'Yes', NULL, '2022-01-21 10:45:36', '2022-01-21 11:05:43', 'A000005', 'Yes', 10, 5000, 54000, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-25', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 'ETDtg', '54566465', '2022-01-25', '2022-01-25', NULL, NULL, NULL, NULL),
(6, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', 14, '{\"id\":14,\"order_id\":\"P000014\",\"po_start_date\":\"2022-01-01\",\"po_end_date\":\"2022-03-12\",\"item_detail\":\"[{\\\"item_name\\\":\\\"telephone\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"phone\\\",\\\"rate\\\":\\\"100000\\\",\\\"total\\\":118000,\\\"price_unit\\\":\\\"month 1 bills\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":18000}]\",\"total\":118000,\"discount\":0,\"net_payable\":118000,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'inv00001', '2022-01-01', 100, 10, 10, 110, 'jpg', 'invoice/1643002524875124.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'rewew', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'testwwew', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'aSLFKJSAFKL', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"110\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', 'Yes', NULL, '2022-01-24 05:35:24', '2022-01-24 05:42:27', 'A000006', 'No', 5, 5, 105, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-25', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', '94C', 'S200031', '2022-01-24', '2022-01-25', NULL, NULL, NULL, NULL),
(7, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', 14, '{\"id\":14,\"order_id\":\"P000014\",\"po_start_date\":\"2022-01-01\",\"po_end_date\":\"2022-03-12\",\"item_detail\":\"[{\\\"item_name\\\":\\\"telephone\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"phone\\\",\\\"rate\\\":\\\"100000\\\",\\\"total\\\":118000,\\\"price_unit\\\":\\\"month 1 bills\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":18000}]\",\"total\":118000,\"discount\":0,\"net_payable\":118000,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'INVB333', '2022-01-05', 129580, 0, 0, 129580, 'pdf', 'invoice/1643003427487110.pdf', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'tessde', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'rwerrr', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'slfkjsf', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"50000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"79580\",\"cost_center\":\"Advance Course\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'No', NULL, '2022-01-24 05:50:28', '2022-01-24 05:59:55', 'A000007', NULL, 0, 0, 129580, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-24', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, 'S-2229333', '2022-01-24', '2022-01-24', NULL, NULL, NULL, NULL),
(8, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', 14, '{\"id\":14,\"order_id\":\"P000014\",\"po_start_date\":\"2022-01-01\",\"po_end_date\":\"2022-03-12\",\"item_detail\":\"[{\\\"item_name\\\":\\\"telephone\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"phone\\\",\\\"rate\\\":\\\"100000\\\",\\\"total\\\":118000,\\\"price_unit\\\":\\\"month 1 bills\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":18000}]\",\"total\":118000,\"discount\":0,\"net_payable\":118000,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'Vb999', '2022-01-17', 110, 0, 0, 110, 'pdf', 'invoice/1643004207836518.pdf', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'finalpo balance', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'fifms', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', NULL, NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"110\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'No', NULL, '2022-01-24 06:03:27', '2022-01-24 06:07:16', 'A000008', 'No', 10, 11, 99, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-24', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', '94C', 'Srrrr1', '2022-01-24', '2022-01-24', NULL, NULL, NULL, NULL),
(9, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\",\"bank_account_number\":\"32432455453\",\"ifsc\":\"3453f45\",\"pan\":\"aads4587fg\",\"specified_person\":null,\"address\":\"sdff\",\"location\":\"sdfg\",\"zip\":\"dfsgre\"}', 15, '{\"id\":15,\"order_id\":\"P000015\",\"po_start_date\":\"2022-01-04\",\"po_end_date\":\"2022-02-04\",\"item_detail\":\"[{\\\"item_name\\\":\\\"Stationary\\\",\\\"quantity\\\":\\\"100\\\",\\\"unit\\\":\\\"pens\\\",\\\"rate\\\":\\\"100\\\",\\\"total\\\":11000,\\\"price_unit\\\":\\\"gel pen\\\",\\\"tax\\\":\\\"10\\\",\\\"tax_amt\\\":1000}]\",\"total\":11000,\"discount\":0,\"net_payable\":11000,\"advance_tds\":null,\"user_id\":9,\"user_ary\":\"{\\\"id\\\":9,\\\"name\\\":\\\"ade\\\",\\\"email\\\":\\\"employee@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"eaaed\\\"}\",\"account_status\":4,\"level2_user_id\":11,\"approved_user_id\":5}', 6, 'INVVV01', '2022-01-05', 10000, 21, 2100, 12100, 'jpg', 'invoice/1643005333409175.jpg', 9, '{\"id\":9,\"name\":\"ade\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 11, '{\"id\":11,\"name\":\"HO\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', 'sa:FLJF', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'teserwem', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'sALFJF', NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"12100\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'No', NULL, '2022-01-24 06:22:13', '2022-01-24 06:26:29', 'A000009', 'No', 10, 1000, 11100, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-24', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', '94C', 'FE2222', '2022-01-24', '2022-01-24', NULL, NULL, NULL, NULL),
(10, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', 13, '{\"id\":13,\"order_id\":\"P000013\",\"po_start_date\":\"2022-01-03\",\"po_end_date\":\"2022-01-28\",\"item_detail\":\"[{\\\"item_name\\\":\\\"Mobile\\\",\\\"quantity\\\":\\\"10\\\",\\\"unit\\\":\\\"handset\\\",\\\"rate\\\":\\\"10000\\\",\\\"total\\\":118000,\\\"price_unit\\\":\\\"handsets\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":18000}]\",\"total\":118000,\"discount\":0,\"net_payable\":118000,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'TEL/554/21-22', '2022-01-10', 15000, 18, 2700, 17700, 'jpg', 'invoice/1643170558929764.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'dwwq', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'ehjk', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'rewq', NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"17700\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', 'No', NULL, '2022-01-26 04:15:58', '2022-02-09 09:27:16', 'A000010', 'No', 10, 1500, 16200, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-02-09', 0, NULL, NULL, NULL, 3, '{\"id\":3,\"name\":\"Gujrat\",\"slug\":\"gujrat\"}', '94J', '55344545ic', '2022-02-09', '2022-02-09', NULL, NULL, NULL, NULL),
(11, 8, '{\"id\":8,\"name\":\"DIGICOM\",\"email\":\"sureshpnambiar@gmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"U290122-08\",\"bank_account_number\":\"DBS\",\"ifsc\":\"DBS10005\",\"pan\":\"ACHNO2376D\",\"specified_person\":null,\"address\":\"sLKFJ\",\"location\":\"SLKfj\",\"zip\":\"560082\"}', 16, '{\"id\":16,\"order_id\":\"U290122-16\",\"po_start_date\":\"2022-01-05\",\"po_end_date\":\"2022-03-31\",\"item_detail\":\"[{\\\"item_name\\\":\\\"Laptop\\\",\\\"quantity\\\":\\\"10\\\",\\\"unit\\\":\\\"laptop\\\",\\\"rate\\\":\\\"50000\\\",\\\"total\\\":590000,\\\"price_unit\\\":\\\"purchase Dell\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":90000},{\\\"item_name\\\":\\\"Printer\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"printer\\\",\\\"rate\\\":\\\"10000\\\",\\\"total\\\":11800,\\\"price_unit\\\":\\\"HP\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":1800}]\",\"total\":601800,\"discount\":0,\"net_payable\":601800,\"advance_tds\":null,\"user_id\":9,\"user_ary\":\"{\\\"id\\\":9,\\\"name\\\":\\\"EMPLOYEE 2\\\",\\\"email\\\":\\\"employee@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"eaaed\\\"}\",\"account_status\":4,\"level2_user_id\":11,\"approved_user_id\":5}', 6, 'BV100', '2022-01-10', 10000, 18, 1800, 11800, 'jpg', 'invoice/1643445863201220.jpg', 9, '{\"id\":9,\"name\":\"EMPLOYEE 2\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 11, '{\"id\":11,\"name\":\"MANAGER\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', 'lkch', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'terewwq', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'teewqq', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"11800\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', 'No', NULL, '2022-01-29 08:44:23', '2022-01-29 08:57:58', 'U290122-11', 'No', 2, 200, 11600, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-29', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', '94J', 'T100', '2022-01-29', '2022-01-29', NULL, NULL, NULL, NULL),
(12, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', 17, '{\"id\":17,\"order_id\":\"U290122-17\",\"po_start_date\":\"2022-01-04\",\"po_end_date\":\"2022-01-25\",\"item_detail\":\"[{\\\"item_name\\\":\\\"develop app\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"app\\\",\\\"rate\\\":\\\"10000\\\",\\\"total\\\":11000,\\\"price_unit\\\":\\\"dev\\\",\\\"tax\\\":\\\"10\\\",\\\"tax_amt\\\":1000}]\",\"total\":11000,\"discount\":0,\"net_payable\":11000,\"advance_tds\":null,\"user_id\":9,\"user_ary\":\"{\\\"id\\\":9,\\\"name\\\":\\\"EMPLOYEE 2\\\",\\\"email\\\":\\\"employee@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"eaaed\\\"}\",\"account_status\":4,\"level2_user_id\":11,\"approved_user_id\":5}', 6, 'd20009', '2022-01-25', 1000, 10, 100, 1100, 'pdf', 'invoice/1643446241471549.pdf', 9, '{\"id\":9,\"name\":\"EMPLOYEE 2\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 11, '{\"id\":11,\"name\":\"MANAGER\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'etwqq', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', NULL, NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"1100\",\"cost_center\":\"Advance Course\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'No', NULL, '2022-01-29 08:50:41', '2022-02-09 09:27:16', 'U290122-12', 'No', 10, 100, 1000, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-02-09', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', '94J', '65344545ic', '2022-02-09', '2022-02-09', NULL, NULL, NULL, NULL),
(13, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', 18, '{\"id\":18,\"order_id\":\"U020222-18\",\"po_start_date\":\"2022-02-01\",\"po_end_date\":\"2022-02-28\",\"item_detail\":\"[{\\\"item_name\\\":\\\"Desktop\\\",\\\"quantity\\\":\\\"2\\\",\\\"unit\\\":\\\"No\\\",\\\"rate\\\":\\\"34500\\\",\\\"total\\\":81420,\\\"price_unit\\\":\\\"TTP\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":12420},{\\\"item_name\\\":\\\"Printer\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"No\\\",\\\"rate\\\":\\\"12000\\\",\\\"total\\\":14160,\\\"price_unit\\\":\\\"TTP\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":2160}]\",\"total\":95580,\"discount\":0,\"net_payable\":95580,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'TELB12/2022', '2022-02-01', 81000, 18, 14580, 95580, 'pdf', 'invoice/1643818342679820.pdf', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'trew', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'iuytrea', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'poiuy', NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"95580\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', 'No', NULL, '2022-02-02 16:12:22', '2022-02-09 09:27:16', 'U020222-13', 'No', 2, 1620, 93960, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-02-09', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', '94C', '75344545ic', '2022-02-09', '2022-02-09', NULL, NULL, NULL, NULL),
(14, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', 19, '{\"id\":19,\"order_id\":\"U020222-19\",\"po_start_date\":\"2021-12-26\",\"po_end_date\":\"2022-02-19\",\"item_detail\":\"[{\\\"item_name\\\":\\\"Laptop Top panel\\\",\\\"quantity\\\":\\\"1\\\",\\\"unit\\\":\\\"No\\\",\\\"rate\\\":\\\"3444\\\",\\\"total\\\":4063.920000000000072759576141834259033203125,\\\"price_unit\\\":\\\"NTC\\\",\\\"tax\\\":\\\"18\\\",\\\"tax_amt\\\":619.9199999999999590727384202182292938232421875}]\",\"total\":4063.920000000000072759576141834259033203125,\"discount\":0,\"net_payable\":4063.920000000000072759576141834259033203125,\"advance_tds\":null,\"user_id\":1,\"user_ary\":\"{\\\"id\\\":1,\\\"name\\\":\\\"Rahul\\\",\\\"email\\\":\\\"rahul@gmail.com\\\",\\\"mobile\\\":null,\\\"employee_code\\\":\\\"R147\\\"}\",\"account_status\":4,\"level2_user_id\":4,\"approved_user_id\":5}', 6, 'Bsnl/34/21-22', '2022-02-02', 3500, 18, 630, 4130, 'jpg', 'invoice/1643818520436170.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'ewewwd', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'tyew', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', NULL, NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"4130\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', 'No', NULL, '2022-02-02 16:15:20', '2022-02-09 09:27:16', 'U020222-14', 'No', 0, 0, 4130, 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-02-09', 0, NULL, NULL, NULL, 2, '{\"id\":2,\"name\":\"Haryana\",\"slug\":\"haryana\"}', NULL, '85344545ic', '2022-02-09', '2022-02-09', NULL, NULL, NULL, NULL);

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
(4, '2021_06_14_101641_create_settings_table', 1),
(5, '2021_06_14_132741_create_states_table', 1),
(6, '2021_06_15_065731_create_cities_table', 1),
(7, '2021_08_26_124945_create_roles_table', 1),
(9, '2021_08_30_105922_create_assign_processes_table', 2),
(30, '2021_08_30_110029_create_employees_table', 3),
(31, '2021_08_30_111521_create_employee_assign_processes_table', 3),
(57, '2021_08_31_130024_create_vendors_table', 4),
(58, '2021_09_09_070846_create_claim_types_table', 4),
(61, '2021_09_17_105404_create_purchase_orders_table', 5),
(62, '2021_09_17_132309_create_purchase_order_files_table', 5),
(89, '2021_09_28_062249_create_invoices_table', 6),
(90, '2021_10_07_071458_create_without_po_invoices_table', 6),
(91, '2021_10_16_112910_create_apexes_table', 6),
(92, '2021_10_16_113729_create_employee_pays_table', 6),
(93, '2021_10_19_130610_create_employee_pay_files_table', 6),
(95, '2021_10_27_081814_add_category_to_claim_types_table', 7),
(98, '2021_10_30_164123_create_bank_accounts_table', 8),
(105, '2021_10_30_173646_create_internal_transfers_table', 9),
(106, '2021_10_30_173729_create_internal_transfer_files_table', 9),
(108, '2021_11_13_163047_add_column_required_tds_to_employee_pays_table', 10),
(113, '2021_11_16_104621_create_bulk_uploads_table', 11),
(114, '2021_11_16_132501_create_bulk_upload_files_table', 11),
(117, '2021_11_18_122127_add_order_id_to_invoices_table', 12),
(118, '2021_11_18_122551_add_order_id_to_without_po_invoices_table', 12),
(119, '2021_11_19_165100_add_tds_to_bulk_uploads_table', 13),
(120, '2021_11_19_173823_add_payment_to_invoices_table', 14),
(121, '2021_11_19_173855_add_payment_to_without_po_invoices_table', 14),
(122, '2021_11_30_154417_add_cat_to_employees_table', 15),
(123, '2021_12_01_122252_add_apex_to_purchase_orders_table', 16),
(124, '2021_12_01_122339_add_apex_to_invoices_table', 16),
(125, '2021_12_01_122400_add_apex_to_without_po_invoices_table', 16),
(128, '2021_12_01_122452_add_apex_to_bulk_uploads_table', 17),
(129, '2021_12_01_122517_add_apex_to_internal_transfers_table', 17),
(130, '2021_12_03_131220_add_form_to_employee_pays_table', 18),
(131, '2021_12_13_161048_create_bulk_attachments_table', 19),
(132, '2021_12_14_174534_add_tds_month_to_invoices_table', 19),
(134, '2021_12_14_181342_add_tds_month_to_without_po_invoices_table', 20),
(143, '2021_12_15_161210_add_transaction_to_employee_pays_table', 21),
(144, '2021_12_15_161237_add_transaction_to_without_po_invoices_table', 21),
(145, '2021_12_15_161254_add_transaction_to_invoices_table', 21),
(146, '2021_12_15_161310_add_transaction_to_internal_transfers_table', 21),
(147, '2021_12_16_120403_add_trns_to_bulk_uploads_table', 22),
(153, '2021_12_16_165415_create_bulk_csv_uploads_table', 23),
(155, '2021_12_17_113057_change_column_to_invoices_table', 24),
(156, '2021_12_17_175534_change_column_to_without_po_invoices_table', 25),
(157, '2021_12_18_110521_create_cost_centers_table', 26),
(158, '2021_12_18_112208_create_debit_accounts_table', 27),
(159, '2021_12_18_114742_create_categories_table', 28),
(160, '2021_12_22_131020_add_trns_to_bulk_csv_uploads_table', 29),
(161, '2021_12_23_120439_create_employee_bank_accounts_table', 30),
(162, '2021_12_24_131655_add_order_id_to_bulk_csv_uploads_table', 31),
(164, '2022_01_07_164429_add_apex_to_bank_accounts_table', 32),
(165, '2022_01_08_173101_add_tds_payable_to_employee_pays_table', 33),
(166, '2022_01_10_153102_add_payment_date_to_purchase_orders_table', 34),
(167, '2022_01_10_153153_add_payment_date_to_invoices_table', 34),
(168, '2022_01_10_153219_add_payment_date_to_without_po_invoices_table', 34),
(169, '2022_01_10_153247_add_payment_date_to_internal_transfers_table', 34),
(170, '2022_01_10_153307_add_payment_date_to_employee_pays_table', 34),
(171, '2022_01_10_153325_add_payment_date_to_bulk_uploads_table', 34),
(172, '2022_02_18_100404_add_app_date_to_employee_pays_table', 35),
(173, '2022_02_18_110834_add_app_date_to_purchase_orders_table', 36),
(174, '2022_02_18_113958_add_app_date_to_invoices_table', 37),
(175, '2022_02_18_120311_add_app_date_to_without_po_invoices_table', 38);

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
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp_order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_start_date` date DEFAULT NULL,
  `po_end_date` date DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `nature_of_service` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` double(10,2) NOT NULL DEFAULT 0.00,
  `discount` double(10,2) NOT NULL DEFAULT 0.00,
  `net_payable` double(10,2) NOT NULL DEFAULT 0.00,
  `advance_tds` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_status` int(11) NOT NULL DEFAULT 1,
  `level2_user_id` int(11) NOT NULL DEFAULT 0,
  `level2_user_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_status_level2_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_user_id` int(11) NOT NULL DEFAULT 0,
  `approved_user_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_status_level3_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `po_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apexe_id` int(11) NOT NULL DEFAULT 0,
  `apexe_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_two_date` date DEFAULT NULL,
  `level_three_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `order_id`, `temp_order_id`, `vendor_id`, `vendor_ary`, `po_start_date`, `po_end_date`, `payment_method`, `nature_of_service`, `item_detail`, `total`, `discount`, `net_payable`, `advance_tds`, `service_detail`, `status`, `user_id`, `user_ary`, `account_status`, `level2_user_id`, `level2_user_ary`, `account_status_level2_comment`, `approved_user_id`, `approved_user_ary`, `account_status_level3_comment`, `created_at`, `updated_at`, `po_description`, `apexe_id`, `apexe_ary`, `date_of_payment`, `level_two_date`, `level_three_date`) VALUES
(11, 'A000011', NULL, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\"}', '2022-01-01', '2022-01-08', 1, 'Services', '[{\"item_name\":\"ASNDVJGVjn\",\"quantity\":\"150\",\"unit\":\"DDS\",\"rate\":\"15\",\"total\":2700,\"price_unit\":\"adfas\",\"tax\":\"20\",\"tax_amt\":450},{\"item_name\":\"DEWF\",\"quantity\":\"100\",\"unit\":\"ASDW\",\"rate\":\"10\",\"total\":1100,\"price_unit\":\"asdasd\",\"tax\":\"10\",\"tax_amt\":100}]', 3800.00, 200.00, 3600.00, NULL, NULL, 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'sdsadad', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'dsfsdf', '2022-01-06 10:09:08', '2022-01-06 10:47:05', NULL, 1, '{\"id\":1,\"name\":\"Rajasthan\",\"slug\":\"rajasthan\"}', NULL, NULL, NULL),
(12, 'P000012', NULL, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', '2022-01-01', '2022-01-30', 1, 'Services', '[{\"item_name\":\"Bankwidh\",\"quantity\":\"1\",\"unit\":\"MB\",\"rate\":\"250\",\"total\":295,\"price_unit\":null,\"tax\":\"18\",\"tax_amt\":45}]', 295.00, 0.00, 295.00, NULL, 'DTAAA A A', 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'sdeeedmb', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'feeee', '2022-01-21 04:09:58', '2022-01-21 04:14:05', 'rddtest', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL),
(13, 'P000013', NULL, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', '2022-01-03', '2022-01-28', 2, 'Goods', '[{\"item_name\":\"Mobile\",\"quantity\":\"10\",\"unit\":\"handset\",\"rate\":\"10000\",\"total\":118000,\"price_unit\":\"handsets\",\"tax\":\"18\",\"tax_amt\":18000}]', 118000.00, 0.00, 118000.00, NULL, NULL, 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'LDKJDF SLFKJF', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'rttrr', '2022-01-21 10:42:50', '2022-01-21 10:44:05', 'SLDKFJ QLDKJF SLFKJSf lKSJFLKSf', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL),
(14, 'P000014', NULL, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', '2022-01-01', '2022-03-12', 2, 'Services', '[{\"item_name\":\"telephone\",\"quantity\":\"1\",\"unit\":\"phone\",\"rate\":\"100000\",\"total\":118000,\"price_unit\":\"month 1 bills\",\"tax\":\"18\",\"tax_amt\":18000}]', 118000.00, 0.00, 118000.00, NULL, 'LKFHaslkFJ ASLK?FJlksfj ASL?KFJfg', 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'ereefwtel', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'aldkJ', '2022-01-24 05:33:27', '2022-01-24 05:34:29', 'SKFH SKFJHSf SKFHSf', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL),
(15, 'P000015', NULL, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\",\"bank_account_number\":\"32432455453\",\"ifsc\":\"3453f45\",\"pan\":\"aads4587fg\",\"specified_person\":null,\"address\":\"sdff\",\"location\":\"sdfg\",\"zip\":\"dfsgre\"}', '2022-01-04', '2022-02-04', 2, 'Both', '[{\"item_name\":\"Stationary\",\"quantity\":\"100\",\"unit\":\"pens\",\"rate\":\"100\",\"total\":11000,\"price_unit\":\"gel pen\",\"tax\":\"10\",\"tax_amt\":1000}]', 11000.00, 0.00, 11000.00, NULL, 'sLFJASF S:LFJ:FL', 1, 9, '{\"id\":9,\"name\":\"ade\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 4, 11, '{\"id\":11,\"name\":\"HO\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', 'LSFKJFL', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'emptest', '2022-01-24 06:15:44', '2022-01-24 06:21:17', 'SLKFJSF :FLJF', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL),
(16, 'U290122-16', NULL, 8, '{\"id\":8,\"name\":\"DIGICOM\",\"email\":\"sureshpnambiar@gmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"U290122-08\",\"bank_account_number\":\"DBS\",\"ifsc\":\"DBS10005\",\"pan\":\"ACHNO2376D\",\"specified_person\":null,\"address\":\"sLKFJ\",\"location\":\"SLKfj\",\"zip\":\"560082\"}', '2022-01-05', '2022-03-31', 2, 'Goods', '[{\"item_name\":\"Laptop\",\"quantity\":\"10\",\"unit\":\"laptop\",\"rate\":\"50000\",\"total\":590000,\"price_unit\":\"purchase Dell\",\"tax\":\"18\",\"tax_amt\":90000},{\"item_name\":\"Printer\",\"quantity\":\"1\",\"unit\":\"printer\",\"rate\":\"10000\",\"total\":11800,\"price_unit\":\"HP\",\"tax\":\"18\",\"tax_amt\":1800}]', 601800.00, 0.00, 601800.00, NULL, NULL, 1, 9, '{\"id\":9,\"name\":\"EMPLOYEE 2\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 4, 11, '{\"id\":11,\"name\":\"MANAGER\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', 'ASLKFj', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', '213333', '2022-01-29 08:41:26', '2022-01-29 08:43:32', 'slkfj sflkj ASFlkj', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL),
(17, 'U290122-17', NULL, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', '2022-01-04', '2022-01-25', 1, 'Services', '[{\"item_name\":\"develop app\",\"quantity\":\"1\",\"unit\":\"app\",\"rate\":\"10000\",\"total\":11000,\"price_unit\":\"dev\",\"tax\":\"10\",\"tax_amt\":1000}]', 11000.00, 0.00, 11000.00, NULL, 'software', 1, 9, '{\"id\":9,\"name\":\"EMPLOYEE 2\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 4, 11, '{\"id\":11,\"name\":\"MANAGER\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', NULL, 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'eeqq', '2022-01-29 08:48:53', '2022-01-29 08:49:24', 'SLKf', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL),
(18, 'U020222-18', NULL, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', '2022-02-01', '2022-02-28', 1, 'Goods', '[{\"item_name\":\"Desktop\",\"quantity\":\"2\",\"unit\":\"No\",\"rate\":\"34500\",\"total\":81420,\"price_unit\":\"TTP\",\"tax\":\"18\",\"tax_amt\":12420},{\"item_name\":\"Printer\",\"quantity\":\"1\",\"unit\":\"No\",\"rate\":\"12000\",\"total\":14160,\"price_unit\":\"TTP\",\"tax\":\"18\",\"tax_amt\":2160}]', 95580.00, 0.00, 95580.00, NULL, NULL, 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'YREE33', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'WQW', '2022-02-02 15:40:40', '2022-02-02 16:08:18', 'DFJETYUIOP', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL),
(19, 'U020222-19', NULL, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', '2021-12-26', '2022-02-19', 1, 'Services', '[{\"item_name\":\"Laptop Top panel\",\"quantity\":\"1\",\"unit\":\"No\",\"rate\":\"3444\",\"total\":4063.920000000000072759576141834259033203125,\"price_unit\":\"NTC\",\"tax\":\"18\",\"tax_amt\":619.9199999999999590727384202182292938232421875}]', 4063.92, 0.00, 4063.92, NULL, 'WRERTTT', 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'TRREE', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'WEEWW', '2022-02-02 16:01:22', '2022-02-02 16:08:02', 'UYTREWQ', 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_files`
--

CREATE TABLE `purchase_order_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_id` bigint(20) UNSIGNED NOT NULL,
  `po_file_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_file_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_files`
--

INSERT INTO `purchase_order_files` (`id`, `po_id`, `po_file_type`, `po_file_path`, `po_file_description`, `created_at`, `updated_at`) VALUES
(1, 12, 'pdf', 'po_file/1642738197939541012.pdf', 'bagdewew', '2022-01-21 04:09:58', '2022-01-21 04:09:58'),
(2, 13, 'pdf', 'po_file/1642761770945994013.pdf', 'aldfkj ASLKFH', '2022-01-21 10:42:50', '2022-01-21 10:42:50'),
(3, 14, 'jpg', 'po_file/1643002407575282014.jpg', '/lkdj', '2022-01-24 05:33:27', '2022-01-24 05:33:27'),
(4, 15, 'pdf', 'po_file/1643004944545938015.pdf', 'a;dldf', '2022-01-24 06:15:44', '2022-01-24 06:15:44'),
(5, 16, 'pdf', 'po_file/1643445686551850016.pdf', NULL, '2022-01-29 08:41:26', '2022-01-29 08:41:26'),
(6, 18, 'jpg', 'po_file/1643816440861033018.jpg', 'ERRTTD', '2022-02-02 15:40:40', '2022-02-02 15:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'Employee', 1, 'employee', NULL, '2021-08-30 06:10:35', '2021-09-15 00:22:20'),
(5, 'Employee Manager', 1, 'employee-manager', NULL, '2021-09-15 00:21:13', '2021-09-15 00:21:13'),
(6, 'Finance Approver', 1, 'finance-approver', NULL, '2021-09-15 00:21:31', '2021-09-15 00:21:31'),
(7, 'Trust Office', 1, 'trust-office', NULL, '2021-09-15 00:21:45', '2021-09-15 00:21:45'),
(8, 'Vendor Approval Manager', 1, 'vendor-approval-manager', NULL, '2021-10-05 01:52:41', '2021-10-05 01:52:41'),
(9, 'Account office', 1, 'account-office', NULL, '2021-10-06 07:46:18', '2021-10-06 07:46:18'),
(10, 'Payments Office', 1, 'payments-office', NULL, '2021-10-16 00:55:35', '2021-10-16 00:55:35'),
(11, 'TDS Office', 1, 'tds-office', NULL, '2021-10-16 00:55:46', '2021-10-16 00:55:46');

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
  `social_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `download_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `email`, `mobile`, `phone`, `dark_logo`, `light_logo`, `favicon_icon`, `address`, `city`, `pin_code`, `country`, `social_link`, `download_link`, `created_at`, `updated_at`) VALUES
(1, 'The Art of Living', 'art@gmail.com', '98798798', '7987987778', 'setting/1630314476.png', 'setting/16303144761363.png', 'setting/16303144761695.png', 'JAIPUR', 'JAIPUR', '98798', 'INDIA', '[null,null,null,null]', '[null,null,null]', '2021-08-30 04:37:56', '2021-08-30 04:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `description`, `image`, `status`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(5, 'Andhra Pradesh (AP)', NULL, NULL, 1, 'andhra-pradesh-ap', NULL, '2021-09-02 01:17:21', '2021-09-02 01:17:21'),
(6, 'Arunachal Pradesh (AR)', NULL, NULL, 1, 'arunachal-pradesh-ar', NULL, '2021-09-02 01:17:22', '2021-09-02 01:17:22'),
(7, 'Assam (AS)', NULL, NULL, 1, 'assam-as', NULL, '2021-09-02 01:17:23', '2021-09-02 01:17:23'),
(8, 'Bihar (BR)', NULL, NULL, 1, 'bihar-br', NULL, '2021-09-02 01:17:24', '2021-09-02 01:17:24'),
(9, 'Chhattisgarh (CG)', NULL, NULL, 1, 'chhattisgarh-cg', NULL, '2021-09-02 01:17:26', '2021-09-02 01:17:26'),
(10, 'Dadra and Nagar Haveli (DN)', NULL, NULL, 1, 'dadra-and-nagar-haveli-dn', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(11, 'Daman and Diu (DD)', NULL, NULL, 1, 'daman-and-diu-dd', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(12, 'Delhi (DL)', NULL, NULL, 1, 'delhi-dl', NULL, '2021-09-02 01:17:27', '2021-09-02 01:17:27'),
(13, 'Goa (GA)', NULL, NULL, 1, 'goa-ga', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(14, 'Gujarat (GJ)', NULL, NULL, 1, 'gujarat-gj', NULL, '2021-09-02 01:17:28', '2021-09-02 01:17:28'),
(15, 'Haryana (HR)', NULL, NULL, 1, 'haryana-hr', NULL, '2021-09-02 01:17:29', '2021-09-02 01:17:29'),
(16, 'Himachal Pradesh (HP)', NULL, NULL, 1, 'himachal-pradesh-hp', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(17, 'Jammu and Kashmir (JK)', NULL, NULL, 1, 'jammu-and-kashmir-jk', NULL, '2021-09-02 01:17:30', '2021-09-02 01:17:30'),
(18, 'Jharkhand (JH)', NULL, NULL, 1, 'jharkhand-jh', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(19, 'Karnataka (KA)', NULL, NULL, 1, 'karnataka-ka', NULL, '2021-09-02 01:17:32', '2021-09-02 01:17:32'),
(20, 'Kerala (KL)', NULL, NULL, 1, 'kerala-kl', NULL, '2021-09-02 01:17:34', '2021-09-02 01:17:34'),
(21, 'Madhya Pradesh (MP)', NULL, NULL, 1, 'madhya-pradesh-mp', NULL, '2021-09-02 01:17:35', '2021-09-02 01:17:35'),
(22, 'Maharashtra (MH)', NULL, NULL, 1, 'maharashtra-mh', NULL, '2021-09-02 01:17:37', '2021-09-02 01:17:37'),
(23, 'Manipur (MN)', NULL, NULL, 1, 'manipur-mn', NULL, '2021-09-02 01:17:38', '2021-09-02 01:17:38'),
(24, 'Meghalaya (ML)', NULL, NULL, 1, 'meghalaya-ml', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(25, 'Mizoram (MZ)', NULL, NULL, 1, 'mizoram-mz', NULL, '2021-09-02 01:17:39', '2021-09-02 01:17:39'),
(26, 'Nagaland (NL)', NULL, NULL, 1, 'nagaland-nl', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(27, 'Orissa (OR)', NULL, NULL, 1, 'orissa-or', NULL, '2021-09-02 01:17:40', '2021-09-02 01:17:40'),
(28, 'Pondicherry (Puducherry) (PY)', NULL, NULL, 1, 'pondicherry-puducherry-py', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(29, 'Punjab (PB)', NULL, NULL, 1, 'punjab-pb', NULL, '2021-09-02 01:17:42', '2021-09-02 01:17:42'),
(30, 'Rajasthan (RJ)', NULL, NULL, 1, 'rajasthan-rj', NULL, '2021-09-02 01:17:43', '2021-09-02 01:17:43'),
(31, 'Sikkim (SK)', NULL, NULL, 1, 'sikkim-sk', NULL, '2021-09-02 01:17:44', '2021-09-02 01:17:44'),
(32, 'Tamil Nadu (TN)', NULL, NULL, 1, 'tamil-nadu-tn', NULL, '2021-09-02 01:17:45', '2021-09-02 01:17:45'),
(33, 'Tripura (TR)', NULL, NULL, 1, 'tripura-tr', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(34, 'Uttar Pradesh (UP)', NULL, NULL, 1, 'uttar-pradesh-up', NULL, '2021-09-02 01:17:46', '2021-09-02 01:17:46'),
(35, 'Uttarakhand (UK)', NULL, NULL, 1, 'uttarakhand-uk', NULL, '2021-09-02 01:17:50', '2021-09-02 01:17:50'),
(36, 'West Bengal (WB)', NULL, NULL, 1, 'west-bengal-wb', NULL, '2021-09-02 01:17:51', '2021-09-02 01:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` int(11) NOT NULL DEFAULT 0,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_admin`, `password`, `original_password`, `status`, `image`, `mobile_code`, `mobile`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, 1, '$2y$10$B.rnsr7ddjid7Ro54NPude19.6wnGfB6cp.qo3rmcpylKe7dUFAcS', '123456', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for active 2 for deactivate',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specified_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `state_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `city_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_type` int(11) NOT NULL DEFAULT 1 COMMENT '1 for employee 2 for vendor form',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `constitution` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specify_if_other` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_cheque_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_status` int(11) NOT NULL DEFAULT 1,
  `account_status_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_user_id` int(11) NOT NULL DEFAULT 0,
  `approved_user_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `password`, `original_password`, `mobile_code`, `mobile`, `phone`, `status`, `image`, `bank_account_type`, `bank_account_number`, `ifsc`, `pan`, `specified_person`, `address`, `location`, `zip`, `state_id`, `state_ary`, `city_id`, `city_ary`, `vendor_type`, `user_id`, `user_ary`, `constitution`, `specify_if_other`, `gst`, `pan_file`, `cancel_cheque_file`, `account_status`, `account_status_comment`, `approved_user_id`, `approved_user_ary`, `vendor_code`, `created_at`, `updated_at`) VALUES
(5, 'vend', 'ven@gmail.com', '$2y$10$IjrdUT4lZYr/RuuKljlQDeBtSfWebmiBhCibbJdJ4PDJRH7vzRKIi', '123456', NULL, NULL, '9879879875', 1, NULL, 'Saving', '32432455453', '3453f45', 'aads4587fg', NULL, 'sdff', 'sdfg', 'dfsgre', 8, '{\"id\":8,\"name\":\"Bihar (BR)\",\"slug\":\"bihar-br\"}', 67, '{\"id\":67,\"name\":\"Araria\",\"slug\":\"araria-bihar-br\"}', 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 'Trust', NULL, 'sdfsdf', 'vendor/pan_file/1641463600748738.png', 'vendor/cancel_cheque_file/1641463600748738.jpg', 3, 'adfwe', 2, '{\"id\":2,\"name\":\"amit\",\"email\":\"amit@gmail.com\",\"mobile\":null,\"employee_code\":\"A0001\"}', 'V000005', '2022-01-06 10:06:41', '2022-01-06 10:07:36'),
(6, 'Teleb', 'jgdrajeshg@gmail.com', '$2y$10$BsI5O2sGZwU.aeoO0/XjGeUyZisA15AeZPFOTWQOJ0OlniYDwYh0C', '123456', NULL, NULL, '8665654544', 1, NULL, 'Saving', '23343433002', 'SBIN5656576', 'AWWFR4536T', NULL, 'EWYWYWHHAAH', 'BIHAR', '544322', 8, '{\"id\":8,\"name\":\"Bihar (BR)\",\"slug\":\"bihar-br\"}', 67, '{\"id\":67,\"name\":\"Araria\",\"slug\":\"araria-bihar-br\"}', 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 'Partnership', 'EWWDW', NULL, 'vendor/pan_file/1642582029990858.jpg', 'vendor/cancel_cheque_file/1642582029990858.pdf', 3, 'eert', 2, '{\"id\":2,\"name\":\"amit\",\"email\":\"amit@gmail.com\",\"mobile\":null,\"employee_code\":\"A0001\"}', 'V000006', '2022-01-19 08:47:09', '2022-01-19 08:48:52'),
(7, 'BSNL', 'sureshpnambiar@rediffmail.com', '$2y$10$L2aWRPplXNQqv7UFlAdFkOOgxDE1TwsxG6RSliKQ9RKaJkq5g0I3C', '123456', NULL, NULL, '9880014935', 1, NULL, 'Saving', '55555555', 'CITI5555', '5555555555', NULL, 'aaaa', 'SALFJ', '560082', 10, '{\"id\":10,\"name\":\"Dadra and Nagar Haveli (DN)\",\"slug\":\"dadra-and-nagar-haveli-dn\"}', 124, '{\"id\":124,\"name\":\"Dadra and Nagar Haveli\",\"slug\":\"dadra-and-nagar-haveli-dadra-and-nagar-haveli-dn\"}', 1, 2, '{\"id\":2,\"name\":\"amit\",\"email\":\"amit@gmail.com\",\"mobile\":null,\"employee_code\":\"A0001\"}', 'Sole Propritor', 'SAKFJSKF', NULL, 'vendor/pan_file/1643002230363229.pdf', 'vendor/cancel_cheque_file/1643002230363229.jpg', 3, 'new24122', 2, '{\"id\":2,\"name\":\"amit\",\"email\":\"amit@gmail.com\",\"mobile\":null,\"employee_code\":\"A0001\"}', 'V000007', '2022-01-24 05:30:31', '2022-01-24 05:31:39'),
(8, 'DIGICOM', 'sureshpnambiar@gmail.com', '$2y$10$SKKGxci/4Msl/6xVMQkJIOXSB3g2/wiyb8/XKrJ3OtsJH79Fy5pgC', '123456', NULL, NULL, '9880014935', 1, NULL, 'Saving', 'DBS', 'DBS10005', 'ACHNO2376D', NULL, 'sLKFJ', 'SLKfj', '560082', 5, '{\"id\":5,\"name\":\"Andhra Pradesh (AP)\",\"slug\":\"andhra-pradesh-ap\"}', 2, '{\"id\":2,\"name\":\"Adilabad\",\"slug\":\"adilabad-andhra-pradesh-ap\"}', 1, 9, '{\"id\":9,\"name\":\"EMPLOYEE 2\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 'Company', 'LASKFJ ASFLkj ASFlkj', NULL, 'vendor/pan_file/1643445455860600.jpg', 'vendor/cancel_cheque_file/1643445455860600.pdf', 3, 'rteee', 2, '{\"id\":2,\"name\":\"amit\",\"email\":\"amit@gmail.com\",\"mobile\":null,\"employee_code\":\"A0001\"}', 'U290122-08', '2022-01-29 08:37:36', '2022-01-29 08:38:30'),
(9, 'BAJAJ', 'harsha.nambiar1@gmail.com', '$2y$10$o67xjizMWVTYVvg.BzJvCOIiblH0qQZHfAt0wWkTh7YW1cxCE2axi', '123456', NULL, NULL, '9880014935', 1, NULL, 'Saving', 'DBS', 'DBS000011', 'DFCHO2552R', NULL, 'SLFKJ SAFLJ SFLj', 'SLFJ', '110011', 12, '{\"id\":12,\"name\":\"Delhi (DL)\",\"slug\":\"delhi-dl\"}', 127, '{\"id\":127,\"name\":\"Central Delhi\",\"slug\":\"central-delhi-delhi-dl\"}', 1, 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 'Sole Propritor', 'saKLJFljf', NULL, 'vendor/pan_file/1643884940868771.pdf', 'vendor/cancel_cheque_file/1643884940868771.pdf', 3, 'rteee', 2, '{\"id\":2,\"name\":\"amit\",\"email\":\"amit@gmail.com\",\"mobile\":null,\"employee_code\":\"A0001\"}', 'V030222-09', '2022-02-03 10:42:20', '2022-02-03 10:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `without_po_invoices`
--

CREATE TABLE `without_po_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_status` int(11) NOT NULL DEFAULT 1,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) NOT NULL DEFAULT 0,
  `tax_amount` int(11) NOT NULL DEFAULT 0,
  `invoice_amount` int(11) NOT NULL DEFAULT 0,
  `po_file_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `employee_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver_manager` int(11) NOT NULL DEFAULT 0,
  `manager_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver_financer` int(11) NOT NULL DEFAULT 0,
  `financer_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financer_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approver_trust` int(11) NOT NULL DEFAULT 0,
  `approver_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trust_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_approval_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_by_account` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advance_payment_mode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specified_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Yes or No',
  `payment_ofc_id` int(11) NOT NULL DEFAULT 0,
  `payment_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `tds_ofc_id` int(11) NOT NULL DEFAULT 0,
  `tds_ofc_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_ofc_comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_date` date DEFAULT NULL,
  `apexe_id` int(11) NOT NULL DEFAULT 0,
  `apexe_ary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds` int(11) NOT NULL DEFAULT 0,
  `tds_amount` int(11) NOT NULL DEFAULT 0,
  `tds_month` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `tds_payable` int(11) NOT NULL DEFAULT 0,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_date` date DEFAULT NULL,
  `financer_date` date DEFAULT NULL,
  `account_date` date DEFAULT NULL,
  `trust_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `without_po_invoices`
--

INSERT INTO `without_po_invoices` (`id`, `vendor_id`, `vendor_ary`, `invoice_status`, `invoice_number`, `invoice_date`, `amount`, `tax`, `tax_amount`, `invoice_amount`, `po_file_type`, `invoice_file_path`, `employee_id`, `employee_ary`, `approver_manager`, `manager_ary`, `manager_comment`, `approver_financer`, `financer_ary`, `financer_comment`, `approver_trust`, `approver_ary`, `trust_comment`, `invoice_approval_date`, `form_by_account`, `advance_payment_mode`, `item_detail`, `created_at`, `updated_at`, `order_id`, `specified_person`, `payment_ofc_id`, `payment_ofc_ary`, `payment_ofc_comment`, `payment_date`, `tds_ofc_id`, `tds_ofc_ary`, `tds_ofc_comment`, `tds_date`, `apexe_id`, `apexe_ary`, `tds`, `tds_amount`, `tds_month`, `tds_payable`, `transaction_id`, `transaction_date`, `date_of_payment`, `manager_date`, `financer_date`, `account_date`, `trust_date`) VALUES
(1, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\"}', 6, '56465465', '2022-01-06', 1500, 30, 450, 1950, 'jpg', 'WithoutPoInvoice/16415472595816950.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'CSDWfeg', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'rteedwdw', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'ffgl', NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"1950\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', NULL, NULL, '2022-01-07 09:20:59', '2022-01-24 07:40:26', 'A000001', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-24', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Rajasthan\",\"slug\":\"rajasthan\"}', 10, 150, '94J', 1800, 'Sbqkqq', '2022-01-07', '2022-01-24', NULL, NULL, NULL, NULL),
(2, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\"}', 6, '32487486', '2022-01-07', 2000, 20, 400, 2400, 'jpg', 'WithoutPoInvoice/16415472595816951.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'DGVNDVhgV DNBKV DghV WHDV BJKVD jkbWDKJG WKLDFjk WBDFmbWGDB jmW BDFJKmBW FM', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'FEWRFWRF', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'DSWDFWDW', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"1100\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"},{\"debit_account\":\"133300007800\",\"amount\":\"900\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-01-07 09:21:00', '2022-01-21 03:59:45', 'A000002', 'Yes', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-07', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Rajasthan\",\"slug\":\"rajasthan\"}', 10, 200, 'SADc', 2200, 'dsdww1', '2022-01-07', '2022-01-07', NULL, NULL, NULL, NULL),
(3, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\",\"bank_account_number\":\"32432455453\",\"ifsc\":\"3453f45\",\"pan\":\"aads4587fg\",\"specified_person\":null,\"address\":\"sdff\",\"location\":\"sdfg\",\"zip\":\"dfsgre\"}', 6, 'aeesrfwerst345353', '2022-01-13', 3000, 10, 300, 3300, 'jpg', 'WithoutPoInvoice/16420695526870500.jpg', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'XSWRSWDW', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'TEEGEG', NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"1200\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"},{\"debit_account\":\"560000212212\",\"amount\":\"2100\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-01-13 10:25:52', '2022-01-21 12:25:46', 'A000003', 'Yes', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-25', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 5, 150, 'aedesf', 3150, '894f798s89f', '2022-01-25', '2022-01-25', NULL, NULL, NULL, NULL),
(4, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', 6, 'HY233', '2022-01-11', 2300, 18, 414, 2714, 'jpg', 'WithoutPoInvoice/16430075282874220.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'telwehqbwqw', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', NULL, 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'dyguk', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"2714\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-01-24 06:58:48', '2022-01-24 07:40:26', 'A000004', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-24', 0, NULL, NULL, NULL, 2, '{\"id\":2,\"name\":\"Haryana\",\"slug\":\"haryana\"}', 0, 0, NULL, 2714, 'tewkkwl', '2022-01-24', '2022-01-24', NULL, NULL, NULL, NULL),
(5, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', 6, 'te3202/21-22', '2022-01-18', 35000, 5, 1750, 36750, 'pdf', 'WithoutPoInvoice/16430845804908090.pdf', 9, '{\"id\":9,\"name\":\"ade\",\"email\":\"employee@gmail.com\",\"mobile\":null,\"employee_code\":\"eaaed\"}', 11, '{\"id\":11,\"name\":\"HO\",\"email\":\"manager@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP456\"}', 'rteee', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'wewdw', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'dwdwdd', NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"36750\",\"cost_center\":\"Special programs\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-01-25 04:23:00', '2022-01-25 04:28:34', 'A000005', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-25', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 10, 3500, '94J', 33250, 'WIA25122', '2022-01-25', '2022-01-25', NULL, NULL, NULL, NULL),
(6, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\",\"bank_account_number\":\"32432455453\",\"ifsc\":\"3453f45\",\"pan\":\"aads4587fg\",\"specified_person\":null,\"address\":\"sdff\",\"location\":\"sdfg\",\"zip\":\"dfsgre\"}', 6, 'IN200200', '2022-01-18', 1000, 10, 100, 1100, 'jpg', 'WithoutPoInvoice/16431014185770920.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'slfkj', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'wewew', 12, '{\"id\":12,\"name\":\"PRASANTH NAIR\",\"email\":\"trustee@gmail.com\",\"mobile\":null,\"employee_code\":\"TRUSTEE1\"}', 'WLFJfj', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"1100\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', NULL, NULL, '2022-01-25 09:03:38', '2022-02-03 09:23:18', 'A000006', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-25', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 10, 100, '94C', 1000, 'ICIC2221', '2022-01-25', '2022-01-25', NULL, NULL, NULL, NULL),
(7, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', 6, 'VF10000', '2022-01-18', 50500, 18, 9090, 59590, 'jpg', 'WithoutPoInvoice/16431019357306360.jpg', 13, '{\"id\":13,\"name\":\"EMPLOYEE 2\",\"email\":\"employee2@gmail.com\",\"mobile\":null,\"employee_code\":\"EMP001\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'SALKFJ', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'ereedtfd', 12, '{\"id\":12,\"name\":\"PRASANTH NAIR\",\"email\":\"trustee@gmail.com\",\"mobile\":null,\"employee_code\":\"TRUSTEE1\"}', 'ALKFJAFLKj', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"10000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"49590\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-01-25 09:12:15', '2022-02-03 09:23:18', 'A000007', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-25', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 10, 5050, '94J', 54540, 'ICIC2222', '2022-01-25', '2022-01-25', NULL, NULL, NULL, NULL),
(8, 6, '{\"id\":6,\"name\":\"Teleb\",\"email\":\"jgdrajeshg@gmail.com\",\"phone\":\"8665654544\",\"vendor_code\":\"V000006\",\"bank_account_number\":\"23343433002\",\"ifsc\":\"SBIN5656576\",\"pan\":\"AWWFR4536T\",\"specified_person\":null,\"address\":\"EWYWYWHHAAH\",\"location\":\"BIHAR\",\"zip\":\"544322\"}', 6, 'G22222', '2022-01-18', 10000, 20, 2000, 12000, 'pdf', 'WithoutPoInvoice/16431026849602040.pdf', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'ALKFH', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'sdsdsd', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', NULL, NULL, '{\"form_by_account\":[{\"debit_account\":\"133300007800\",\"amount\":\"12000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-01-25 09:24:44', '2022-02-03 09:23:18', 'A000008', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-25', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 5, 500, '94J', 11500, 'ICIC2223', '2022-01-25', '2022-01-25', NULL, NULL, NULL, NULL),
(9, 7, '{\"id\":7,\"name\":\"BSNL\",\"email\":\"sureshpnambiar@rediffmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V000007\",\"bank_account_number\":\"55555555\",\"ifsc\":\"CITI5555\",\"pan\":\"5555555555\",\"specified_person\":null,\"address\":\"aaaa\",\"location\":\"SALFJ\",\"zip\":\"560082\"}', 6, 'BSNL2233', '2022-01-03', 300, 18, 54, 354, 'jpg', 'WithoutPoInvoice/16431723977975580.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'ytrew', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'hgfdsa', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'hgfdsa', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"354\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', NULL, NULL, '2022-01-26 04:46:37', '2022-02-03 09:23:18', 'A000009', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-01-26', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 0, 0, NULL, 354, 'SBIN441', '2022-01-26', '2022-01-26', NULL, NULL, NULL, NULL),
(10, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\",\"bank_account_number\":\"32432455453\",\"ifsc\":\"3453f45\",\"pan\":\"aads4587fg\",\"specified_person\":null,\"address\":\"sdff\",\"location\":\"sdfg\",\"zip\":\"dfsgre\"}', 6, 'EFEE2121-RR', '2022-02-01', 2300, 5, 115, 2415, 'pdf', 'WithoutPoInvoice/16438188715822340.pdf', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', 'SDA', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'wgfdsx', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'yrerewe', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"2000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"},{\"debit_account\":\"133300007800\",\"amount\":\"415\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-02-02 16:21:11', '2022-02-03 09:24:42', 'U020222-10', 'Yes', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-02-02', 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 2, 46, '94C', 2369, 'AOL0001', '2022-02-02', '2022-02-02', NULL, NULL, NULL, NULL),
(11, 8, '{\"id\":8,\"name\":\"DIGICOM\",\"email\":\"sureshpnambiar@gmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"U290122-08\",\"bank_account_number\":\"DBS\",\"ifsc\":\"DBS10005\",\"pan\":\"ACHNO2376D\",\"specified_person\":null,\"address\":\"sLKFJ\",\"location\":\"SLKfj\",\"zip\":\"560082\"}', 6, 'RWWEW2211-22', '2022-01-29', 1200, 18, 216, 1416, 'jpg', 'WithoutPoInvoice/16438189624246170.jpg', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', '1133323', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'hrwqq', 5, '{\"id\":5,\"name\":\"ARG\",\"email\":\"arg@gmail.com\",\"mobile\":null,\"employee_code\":\"ARG123\"}', 'wwqwqw', NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"1416\",\"cost_center\":\"Advance Course\",\"category\":\"HouseKeeping\"}],\"bank_account\":\"1214454545466\",\"ifsc\":\"11225533\",\"bank_name\":\"CITI\"}', NULL, NULL, '2022-02-02 16:22:42', '2022-02-03 09:24:42', 'U020222-11', 'No', 7, '{\"id\":7,\"name\":\"pay\",\"email\":\"pay@gmail.com\",\"mobile\":null,\"employee_code\":\"123556546\"}', NULL, '2022-02-02', 0, NULL, NULL, NULL, 3, '{\"id\":3,\"name\":\"Gujrat\",\"slug\":\"gujrat\"}', 0, 0, NULL, 1416, 'AOL0001', '2022-02-02', '2022-02-02', NULL, NULL, NULL, NULL),
(12, 9, '{\"id\":9,\"name\":\"BAJAJ\",\"email\":\"harsha.nambiar1@gmail.com\",\"phone\":\"9880014935\",\"vendor_code\":\"V030222-09\",\"bank_account_number\":\"DBS\",\"ifsc\":\"DBS000011\",\"pan\":\"DFCHO2552R\",\"specified_person\":null,\"address\":\"SLFKJ SAFLJ SFLj\",\"location\":\"SLFJ\",\"zip\":\"110011\"}', 4, 'INV99991', '2022-02-01', 10000, 10, 1000, 11000, 'pdf', 'WithoutPoInvoice/16438866155957700.pdf', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile\":null,\"employee_code\":\"R147\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile\":null,\"employee_code\":\"PW123\"}', NULL, 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile\":null,\"employee_code\":\"D717\"}', 'rterwerw322022', 0, NULL, NULL, NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"11000\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', NULL, NULL, '2022-02-03 11:10:15', '2022-02-03 11:15:47', 'WDIN030222-12', 'No', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 2, 200, '94c', 10800, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 5, '{\"id\":5,\"name\":\"vend\",\"email\":\"ven@gmail.com\",\"phone\":\"9879879875\",\"vendor_code\":\"V000005\",\"bank_account_number\":\"32432455453\",\"ifsc\":\"3453f45\",\"pan\":\"aads4587fg\",\"specified_person\":null,\"address\":\"sdff\",\"location\":\"sdfg\",\"zip\":\"dfsgre\"}', 4, 'dawfwf', '2022-02-14', 102, 18, 18, 120, 'png', 'WithoutPoInvoice/16448295871758610.png', 1, '{\"id\":1,\"name\":\"Rahul\",\"email\":\"rahul@gmail.com\",\"mobile_code\":null,\"mobile\":null,\"phone\":\"9898989898\",\"employee_code\":\"R147\",\"bank_account_type\":\"Saving\",\"bank_account_number\":\"98798798465456\",\"ifsc\":\"4TGE5R456\",\"pan\":\"AQDS4654\",\"specified_person\":\"Yes\",\"address\":\"JAIPUR\",\"location\":\"MANSROVAR\",\"zip\":\"303030\",\"medical_welfare\":\"Yes\"}', 4, '{\"id\":4,\"name\":\"pawan\",\"email\":\"pawan@gmail.com\",\"mobile_code\":null,\"mobile\":null,\"phone\":\"9898989898\",\"employee_code\":\"PW123\",\"bank_account_type\":\"Saving\",\"bank_account_number\":\"98798798465456\",\"ifsc\":\"4TGE5R456\",\"pan\":null,\"specified_person\":\"Yes\",\"address\":\"JAIPUR\",\"location\":\"MANSROVAR\",\"zip\":\"303030\",\"medical_welfare\":\"Yes\"}', 'adsfa', 3, '{\"id\":3,\"name\":\"dp\",\"email\":\"dp@gmail.com\",\"mobile_code\":null,\"mobile\":null,\"phone\":\"3214569875\",\"employee_code\":\"D717\",\"bank_account_type\":\"Saving\",\"bank_account_number\":\"4365141654654654\",\"ifsc\":\"4SD6A465465\",\"pan\":null,\"specified_person\":\"Yes\",\"address\":\"jaipur\",\"location\":\"mans\",\"zip\":\"102020\",\"medical_welfare\":null}', NULL, 0, NULL, NULL, NULL, '{\"form_by_account\":[{\"debit_account\":\"560000212212\",\"amount\":\"120\",\"cost_center\":\"Special programs\",\"category\":\"Stationary\"}],\"bank_account\":\"222192971222\",\"ifsc\":\"123322111\",\"bank_name\":\"ICICI\"}', NULL, NULL, '2022-02-14 09:06:27', '2022-02-14 09:18:50', 'WDIN140222-13', 'Yes', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, '{\"id\":1,\"name\":\"Head Office\",\"slug\":\"head-office\"}', 2, 3, 'weqa', 117, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apexes`
--
ALTER TABLE `apexes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_processes`
--
ALTER TABLE `assign_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulk_attachments`
--
ALTER TABLE `bulk_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulk_csv_uploads`
--
ALTER TABLE `bulk_csv_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bulk_csv_uploads_bulk_upload_id_foreign` (`bulk_upload_id`);

--
-- Indexes for table `bulk_uploads`
--
ALTER TABLE `bulk_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bulk_uploads_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `bulk_upload_files`
--
ALTER TABLE `bulk_upload_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bulk_upload_files_bulk_upload_id_foreign` (`bulk_upload_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `claim_types`
--
ALTER TABLE `claim_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_centers`
--
ALTER TABLE `cost_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debit_accounts`
--
ALTER TABLE `debit_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_state_id_foreign` (`state_id`),
  ADD KEY `employees_city_id_foreign` (`city_id`),
  ADD KEY `employees_role_id_foreign` (`role_id`),
  ADD KEY `employees_user_id_foreign` (`user_id`);

--
-- Indexes for table `employee_assign_processes`
--
ALTER TABLE `employee_assign_processes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_assign_processes_employees_id_foreign` (`employees_id`),
  ADD KEY `employee_assign_processes_assign_processes_id_foreign` (`assign_processes_id`);

--
-- Indexes for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_bank_accounts_employees_id_foreign` (`employees_id`);

--
-- Indexes for table `employee_pays`
--
ALTER TABLE `employee_pays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_pays_pay_for_employee_id_foreign` (`pay_for_employee_id`),
  ADD KEY `employee_pays_nature_of_claim_id_foreign` (`nature_of_claim_id`),
  ADD KEY `employee_pays_apexe_id_foreign` (`apexe_id`),
  ADD KEY `employee_pays_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_pay_files`
--
ALTER TABLE `employee_pay_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_pay_files_emp_req_id_foreign` (`emp_req_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_transfers`
--
ALTER TABLE `internal_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internal_transfers_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `internal_transfer_files`
--
ALTER TABLE `internal_transfer_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internal_transfer_files_internal_transfer_id_foreign` (`internal_transfer_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_vendor_id_foreign` (`vendor_id`),
  ADD KEY `invoices_po_id_foreign` (`po_id`),
  ADD KEY `invoices_employee_id_foreign` (`employee_id`);

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
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `purchase_order_files`
--
ALTER TABLE `purchase_order_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_files_po_id_foreign` (`po_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_email_unique` (`email`),
  ADD KEY `vendors_state_id_foreign` (`state_id`),
  ADD KEY `vendors_city_id_foreign` (`city_id`),
  ADD KEY `vendors_user_id_foreign` (`user_id`);

--
-- Indexes for table `without_po_invoices`
--
ALTER TABLE `without_po_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `without_po_invoices_vendor_id_foreign` (`vendor_id`),
  ADD KEY `without_po_invoices_employee_id_foreign` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apexes`
--
ALTER TABLE `apexes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `assign_processes`
--
ALTER TABLE `assign_processes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bulk_attachments`
--
ALTER TABLE `bulk_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulk_csv_uploads`
--
ALTER TABLE `bulk_csv_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulk_uploads`
--
ALTER TABLE `bulk_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulk_upload_files`
--
ALTER TABLE `bulk_upload_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=639;

--
-- AUTO_INCREMENT for table `claim_types`
--
ALTER TABLE `claim_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cost_centers`
--
ALTER TABLE `cost_centers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `debit_accounts`
--
ALTER TABLE `debit_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employee_assign_processes`
--
ALTER TABLE `employee_assign_processes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=634;

--
-- AUTO_INCREMENT for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `employee_pays`
--
ALTER TABLE `employee_pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `employee_pay_files`
--
ALTER TABLE `employee_pay_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internal_transfers`
--
ALTER TABLE `internal_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `internal_transfer_files`
--
ALTER TABLE `internal_transfer_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `purchase_order_files`
--
ALTER TABLE `purchase_order_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `without_po_invoices`
--
ALTER TABLE `without_po_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bulk_csv_uploads`
--
ALTER TABLE `bulk_csv_uploads`
  ADD CONSTRAINT `bulk_csv_uploads_bulk_upload_id_foreign` FOREIGN KEY (`bulk_upload_id`) REFERENCES `bulk_uploads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bulk_uploads`
--
ALTER TABLE `bulk_uploads`
  ADD CONSTRAINT `bulk_uploads_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `bulk_upload_files`
--
ALTER TABLE `bulk_upload_files`
  ADD CONSTRAINT `bulk_upload_files_bulk_upload_id_foreign` FOREIGN KEY (`bulk_upload_id`) REFERENCES `bulk_uploads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_assign_processes`
--
ALTER TABLE `employee_assign_processes`
  ADD CONSTRAINT `employee_assign_processes_assign_processes_id_foreign` FOREIGN KEY (`assign_processes_id`) REFERENCES `assign_processes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_assign_processes_employees_id_foreign` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  ADD CONSTRAINT `employee_bank_accounts_employees_id_foreign` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_pays`
--
ALTER TABLE `employee_pays`
  ADD CONSTRAINT `employee_pays_apexe_id_foreign` FOREIGN KEY (`apexe_id`) REFERENCES `apexes` (`id`),
  ADD CONSTRAINT `employee_pays_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_pays_nature_of_claim_id_foreign` FOREIGN KEY (`nature_of_claim_id`) REFERENCES `claim_types` (`id`),
  ADD CONSTRAINT `employee_pays_pay_for_employee_id_foreign` FOREIGN KEY (`pay_for_employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employee_pay_files`
--
ALTER TABLE `employee_pay_files`
  ADD CONSTRAINT `employee_pay_files_emp_req_id_foreign` FOREIGN KEY (`emp_req_id`) REFERENCES `employee_pays` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `internal_transfers`
--
ALTER TABLE `internal_transfers`
  ADD CONSTRAINT `internal_transfers_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `internal_transfer_files`
--
ALTER TABLE `internal_transfer_files`
  ADD CONSTRAINT `internal_transfer_files_internal_transfer_id_foreign` FOREIGN KEY (`internal_transfer_id`) REFERENCES `internal_transfers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `invoices_po_id_foreign` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `invoices_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `purchase_order_files`
--
ALTER TABLE `purchase_order_files`
  ADD CONSTRAINT `purchase_order_files_po_id_foreign` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendors_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `without_po_invoices`
--
ALTER TABLE `without_po_invoices`
  ADD CONSTRAINT `without_po_invoices_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `without_po_invoices_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
