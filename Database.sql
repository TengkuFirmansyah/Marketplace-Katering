-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 06, 2024 at 09:24 AM
-- Server version: 8.0.32
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `katering`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forget_password`
--

CREATE TABLE `forget_password` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_status`
--

CREATE TABLE `job_status` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `is_read` tinyint UNSIGNED NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`id`, `user_id`, `nama`, `alamat`, `kontak`, `deskripsi`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('bd955723-043b-4f7c-b28e-ec9225dd19de', '130e4804-e6df-47cf-8f0e-d5f276a0250b', 'Merchant Sate', 'Jl. Raya Jakarta Selatan', '0812345678123', 'Menjual Segala jenis Sate Daging dan Ayam', '130e4804-e6df-47cf-8f0e-d5f276a0250b', NULL, NULL, '2024-08-06 09:21:19', '2024-08-06 09:21:19', NULL),
('e2f2fc80-2e0c-4969-8133-dad545f4b5ed', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'Merchant Ayam', 'Jl. Raya Kota Bogor', '0812345678', 'Menjual Segala jenis masakan daging ayam', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 05:17:13', '2024-08-06 05:21:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_menu`
--

CREATE TABLE `merchant_menu` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` double NOT NULL,
  `created_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchant_menu`
--

INSERT INTO `merchant_menu` (`id`, `merchant_id`, `nama`, `deskripsi`, `foto`, `harga`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('06841711-e243-4045-b10f-c4d0a6f730c8', 'e2f2fc80-2e0c-4969-8133-dad545f4b5ed', 'Ayam Goreng', 'Ayam goreng', 'http://localhost/katering/public/images/menu/1722926498.jpg', 10000, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, '2024-08-06 06:11:49', '2024-08-06 06:41:38', NULL),
('ccb5fd7e-f0eb-4c5b-9895-2117b1afd319', 'e2f2fc80-2e0c-4969-8133-dad545f4b5ed', 'Ayam Geprek', 'Ayam geprek dengan sambal matah', 'http://localhost/katering/public/images/menu/1722926305.jpg', 10000, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, '2024-08-06 06:09:06', '2024-08-06 06:38:25', NULL),
('fe0f6beb-1b33-4c5b-8ea4-38803c87039a', 'bd955723-043b-4f7c-b28e-ec9225dd19de', 'Sate Padang', 'Sate Padang 12 Tusuk', 'http://localhost/katering/public/images/menu/1722936138.jpg', 15000, '130e4804-e6df-47cf-8f0e-d5f276a0250b', NULL, NULL, '2024-08-06 09:22:18', '2024-08-06 09:22:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2022_04_18_142350_url_table', 1),
(3, '2022_04_19_111712_permissions_table', 1),
(4, '2022_04_20_101916_role_menus_table', 1),
(5, '2022_04_20_101916_role_permissions_table', 1),
(6, '2024_04_16_135400_create_users_table', 1),
(7, '2024_04_16_140840_create_roles_table', 2),
(8, '2022_10_25_093533_forget_password_table', 3),
(9, '2023_01_06_072530_create_jobs_table', 3),
(10, '2023_01_09_020948_create_job_status_table', 3),
(62, '2024_07_19_202952_master_alat_table', 29),
(63, '2024_07_19_202952_master_metode_pemeriksaan_table', 29),
(64, '2024_07_19_202952_master_nama_program_table', 29),
(65, '2024_07_19_202952_master_parameter_table', 29),
(66, '2024_07_19_202952_master_periode_table', 29),
(67, '2024_07_19_202952_master_reagen_kit_table', 29),
(68, '2024_07_20_083827_master_laboratorium_table', 30),
(69, '2024_08_06_112639_merchant_menu_table', 31),
(70, '2024_08_06_112639_merchant_table', 31),
(72, '2024_08_06_112639_orders_table', 32);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `for` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `merchant_id`, `customer_id`, `kode`, `tanggal`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01f2ca99-553c-45ba-b15c-053f5caded39', 'e2f2fc80-2e0c-4969-8133-dad545f4b5ed', '0cc56985-1586-49e9-b8e9-25cec2bb9ae7', 'M2G0', '2024-08-06', '0cc56985-1586-49e9-b8e9-25cec2bb9ae7', NULL, NULL, '2024-08-06 09:09:39', '2024-08-06 09:09:39', NULL),
('128bd817-23ac-4249-97e4-10733dfbfaa1', 'e2f2fc80-2e0c-4969-8133-dad545f4b5ed', '0cc56985-1586-49e9-b8e9-25cec2bb9ae7', 'C8AG', '2024-08-06', '0cc56985-1586-49e9-b8e9-25cec2bb9ae7', NULL, NULL, '2024-08-06 09:08:48', '2024-08-06 09:08:48', NULL),
('489b138a-e29e-4e16-8e08-b0fa84421157', 'e2f2fc80-2e0c-4969-8133-dad545f4b5ed', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'U8HK', '2024-08-06', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 08:07:56', '2024-08-06 08:07:56', NULL),
('a96ad2ba-121f-4133-8bcd-bb41477b98dc', 'e2f2fc80-2e0c-4969-8133-dad545f4b5ed', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'AAYW', '2024-08-06', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 08:07:02', '2024-08-06 08:07:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant_menu_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `harga` double(18,0) NOT NULL,
  `created_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `merchant_menu_id`, `qty`, `harga`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2458429c-07d0-49b3-8506-ce2f5b23f67c', '489b138a-e29e-4e16-8e08-b0fa84421157', '06841711-e243-4045-b10f-c4d0a6f730c8', 1, 10000, NULL, NULL, NULL, '2024-08-06 08:07:56', '2024-08-06 08:07:56', NULL),
('3f0990c0-46d6-4005-931d-67aef0138cd3', '01f2ca99-553c-45ba-b15c-053f5caded39', 'ccb5fd7e-f0eb-4c5b-9895-2117b1afd319', 1, 10000, NULL, NULL, NULL, '2024-08-06 09:09:39', '2024-08-06 09:09:39', NULL),
('41783b56-5369-413e-b029-3e1bd9f81a59', '01f2ca99-553c-45ba-b15c-053f5caded39', '06841711-e243-4045-b10f-c4d0a6f730c8', 2, 10000, NULL, NULL, NULL, '2024-08-06 09:09:39', '2024-08-06 09:09:39', NULL),
('5d9181cd-f4a3-49df-b96e-2e189d531a5f', 'a96ad2ba-121f-4133-8bcd-bb41477b98dc', 'ccb5fd7e-f0eb-4c5b-9895-2117b1afd319', 1, 10000, NULL, NULL, NULL, '2024-08-06 08:07:02', '2024-08-06 08:07:02', NULL),
('9cb13595-6715-453f-a264-4999ad99a15e', '489b138a-e29e-4e16-8e08-b0fa84421157', 'ccb5fd7e-f0eb-4c5b-9895-2117b1afd319', 1, 10000, NULL, NULL, NULL, '2024-08-06 08:07:56', '2024-08-06 08:07:56', NULL),
('aab11d58-5470-445f-95e7-6a1fbc1911ac', '128bd817-23ac-4249-97e4-10733dfbfaa1', 'ccb5fd7e-f0eb-4c5b-9895-2117b1afd319', 3, 10000, NULL, NULL, NULL, '2024-08-06 09:08:48', '2024-08-06 09:08:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('096a6eb7-5d45-45b6-9d84-dc9155d6a4b4', 'Profile Create', 'merchant-profile-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:33:54', '2024-08-06 04:33:54', NULL),
('0a48e0a1-904c-4527-b97a-e592d34b8178', 'Url Update', 'settings-url-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:08', '2024-04-17 03:42:08', NULL),
('115ad97b-e51e-4a97-8aae-4d2ed9efcaf0', 'Users Delete', 'settings-users-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:14', '2024-04-17 03:42:14', NULL),
('13db52fb-17a0-46c6-9268-1e153ce5e921', 'Menu Delete', 'merchant-menu-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:18', '2024-08-06 04:36:18', NULL),
('15712f20-7f4c-4c51-a2eb-a580d910c1c2', 'Profile View', 'merchant-profile-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:33:54', '2024-08-06 04:33:54', NULL),
('191b4847-e341-4eb6-9a5e-b66c25e96cfd', 'Roles View', 'settings-roles-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:40:42', '2024-04-17 03:40:42', NULL),
('1a9c7482-416b-4a22-9790-5424374f4df6', 'Orders Restore', 'merchant-orders-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:08', '2024-08-06 04:36:08', NULL),
('275223db-f5a2-4d08-982a-126dcf563768', 'Orders View', 'merchant-orders-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:08', '2024-08-06 04:36:08', NULL),
('2f862c28-d57a-45e0-8d1e-d4b9d3e41058', 'Pembelian View', 'customer-pembelian-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:25', '2024-08-06 04:39:25', NULL),
('3bbc35bd-c7c5-49d6-bf5a-ea467bde361a', 'Url Create', 'settings-url-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:08', '2024-04-17 03:42:08', NULL),
('3c8e6dc3-f0ff-4631-a67d-58ce29aa2ca7', 'Pembelian Restore', 'customer-pembelian-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:25', '2024-08-06 04:39:25', NULL),
('484503a5-f3cb-4417-9508-4bee4e889b67', 'Orders Create', 'merchant-orders-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:08', '2024-08-06 04:36:08', NULL),
('4e5c0892-1e4c-4b42-8791-43fdb49fe5de', 'Pencarian Delete', 'customer-pencarian-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:38:46', '2024-08-06 04:38:46', NULL),
('56ba4bc0-e65a-4810-af94-a6486aac0cba', 'Menu Restore', 'merchant-menu-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:18', '2024-08-06 04:36:18', NULL),
('589e57c5-6e99-462f-8864-48186e2c0ef9', 'Pencarian Update', 'customer-pencarian-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:38:46', '2024-08-06 04:38:46', NULL),
('5a3d4a2f-8a65-4e39-9914-6a12f5aa939f', 'Pembelian Update', 'customer-pembelian-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:25', '2024-08-06 04:39:25', NULL),
('5bd2f06c-4722-478e-8a4f-09504bf86f96', 'Profile Update', 'merchant-profile-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:33:54', '2024-08-06 04:33:54', NULL),
('601382c0-20c8-4384-9e3e-c45d445b2e64', 'Pencarian View', 'customer-pencarian-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:38:46', '2024-08-06 04:38:46', NULL),
('6177aa68-534e-49fd-9467-c1047d75f8d0', 'Url View', 'settings-url-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:08', '2024-04-17 03:42:08', NULL),
('622671a4-83c8-4f14-839f-7c0f5cdf4b26', 'Permissions Create', 'settings-permissions-create', NULL, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, '2024-04-17 03:42:23', '2024-04-18 04:02:24', NULL),
('66ff174b-d8cc-40ec-9da2-a5232928e373', 'Menu Update', 'merchant-menu-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:18', '2024-08-06 04:36:18', NULL),
('6f601648-2e7c-4c48-87c6-c15d8d83668f', 'Pencarian Restore', 'customer-pencarian-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:38:46', '2024-08-06 04:38:46', NULL),
('7e684987-72f0-475b-9fc2-0e5991fe9cfd', 'Permissions Update', 'settings-permissions-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:23', '2024-04-17 03:42:23', NULL),
('8472f610-87dd-45be-ad21-39f7402e75da', 'Permissions Delete', 'settings-permissions-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:23', '2024-04-17 03:42:23', NULL),
('8687652f-a840-4bba-b690-5b20610798fb', 'Users Update', 'settings-users-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:14', '2024-04-17 03:42:14', NULL),
('898034fe-222f-4a66-a338-acffc59d8173', 'Profile Restore', 'merchant-profile-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:33:54', '2024-08-06 04:33:54', NULL),
('899a5a01-bc22-440c-bf6e-72403b90958e', 'Roles Delete', 'settings-roles-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:40:42', '2024-04-17 03:40:42', NULL),
('8d281d88-5fda-438d-818d-47524ce5f5ca', 'Users Create', 'settings-users-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:14', '2024-04-17 03:42:14', NULL),
('8dbee382-fd74-4cfe-a1d1-a4401059c1ba', 'Pembelian Create', 'customer-pembelian-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:25', '2024-08-06 04:39:25', NULL),
('8fb9d2df-e225-4166-b14b-2ea3de0b6405', 'Menu Create', 'merchant-menu-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:18', '2024-08-06 04:36:18', NULL),
('9153ff49-3904-497b-8205-83b79a84de57', 'Url Delete', 'settings-url-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:08', '2024-04-17 03:42:08', NULL),
('922a02f7-57ac-43ef-ad73-dcb4a2601a5b', 'Orders Update', 'merchant-orders-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:08', '2024-08-06 04:36:08', NULL),
('96fb5d0b-39af-4320-bbf4-55542432c682', 'Permissions Restore', 'settings-permissions-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:23', '2024-04-17 03:42:23', NULL),
('99b297ab-10b2-40c7-9b49-2050bdb34e01', 'Url Restore', 'settings-url-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:08', '2024-04-17 03:42:08', NULL),
('9cba4ec6-93f4-4d6b-8620-36ee737b8f9a', 'Profile Delete', 'merchant-profile-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:33:54', '2024-08-06 04:33:54', NULL),
('9faae65c-0def-4fd4-8621-62e28e8386ed', 'Orders Delete', 'merchant-orders-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:08', '2024-08-06 04:36:08', NULL),
('b3a6d033-2b86-4b39-ad44-73daff8ce53a', 'Roles Create', 'settings-roles-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:40:42', '2024-04-17 03:40:42', NULL),
('b9dcb2fc-aff0-4f35-89f9-3bffbc720dc3', 'Users View', 'settings-users-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:14', '2024-04-17 03:42:14', NULL),
('bc90f809-a6bf-4f9d-96f1-2eab8aa22330', 'Menu View', 'merchant-menu-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:18', '2024-08-06 04:36:18', NULL),
('c66a1975-2d35-4cb5-a017-6044ff1306bd', 'Roles Update', 'settings-roles-update', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:40:42', '2024-04-17 03:40:42', NULL),
('cad60aef-e4e3-44c5-a464-d98bde72439d', 'Pembelian Delete', 'customer-pembelian-delete', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:25', '2024-08-06 04:39:25', NULL),
('e6ede68e-d457-420e-8a9e-03ff1be7f225', 'Roles Restore', 'settings-roles-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:40:42', '2024-04-17 03:40:42', NULL),
('ef5afc68-7c0d-4422-9938-6206c77cfd4e', 'Permissions View', 'settings-permissions-view', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:23', '2024-04-17 03:42:23', NULL),
('f2290a3a-a220-4312-9a19-0620c009a6e0', 'Users Restore', 'settings-users-restore', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 03:42:14', '2024-04-17 03:42:14', NULL),
('f2f91d69-9daf-4485-9fdc-06d159fc22e0', 'Pencarian Create', 'customer-pencarian-create', '', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:38:46', '2024-08-06 04:38:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2717020e-49bb-41a2-b790-d67e53089cc6', 'Merchant', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, '2024-07-10 07:30:36', '2024-08-06 04:31:25', NULL),
('4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'Admin', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, '2024-07-10 07:29:33', '2024-07-10 07:29:53', NULL),
('4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'Customer', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:31:33', '2024-08-06 04:31:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_menus`
--

CREATE TABLE `role_menus` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_menus`
--

INSERT INTO `role_menus` (`id`, `url_id`, `role_id`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0e3eab96-0e97-494b-943b-d840943245af', '26367372-fbc7-11ee-9a73-d06db130dbb9', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('1ca585c1-8a29-4587-b5c2-8cede66054d4', '0841c084-1b54-4add-bf5a-05d1ed6b08fd', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('20f48098-b4e2-4a0b-8c25-9f3d2b8bb97e', '118d2231-bcfd-4041-9842-2ff13ceb436e', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('264b5d49-ef9e-4151-bcf2-bcd78b297819', '0eaf0c9f-7504-44b2-b9a5-f85a8f023352', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:55', '2024-08-06 04:39:55', NULL),
('354cb017-635e-4086-be7d-1f0b69d0e15b', '3e01ed1a-fbc7-11ee-9a73-d06db130dbb9', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('39787dee-1a38-4202-94b2-0110666b8f92', '1e26bbac-fbc6-11ee-9a73-d06db130dbb9', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('55310d1f-f79f-4389-b9ab-2417cc366520', '4e26d2a2-0f79-4f2f-a397-07f692200090', '71005791-4508-47b8-a39f-c7d2b684c224', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-06-03 04:41:49', '2024-06-03 04:41:49', NULL),
('60fb924a-9428-4d5a-ae2a-4011ec23137e', 'ee74af47-0f05-4100-b80c-0e460b034a2d', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:55', '2024-08-06 04:39:55', NULL),
('7e37a0a7-1cec-4241-9ec5-2c1d9d44a920', 'ee74af47-0f05-4100-b80c-0e460b034a2d', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('8137eb21-b9fe-4279-86ec-b1b5c0a93cff', '8ecbc427-62dd-42c1-a3b3-da29fa4a8b19', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('85de35c6-207e-47a6-b9e0-a355769cb86c', '0841c084-1b54-4add-bf5a-05d1ed6b08fd', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:29', '2024-08-06 04:40:29', NULL),
('868f5904-4df1-4bc3-8ebf-452b3be51107', '0eaf0c9f-7504-44b2-b9a5-f85a8f023352', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('86a8b7d0-327d-4595-b4a9-302a8bb42d70', '46bfe88e-6c78-4f23-ab5b-0f79c499cc27', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:55', '2024-08-06 04:39:55', NULL),
('8a867b14-1753-49f9-a975-dffe4ad588ed', '721f4724-a7f9-4c27-a3f7-e51920652342', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('8e792406-ea3b-4118-8a31-a91d5889d0ca', '7ebb7710-b952-450a-bc6d-0a369558af97', '71005791-4508-47b8-a39f-c7d2b684c224', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-06-03 04:41:49', '2024-06-03 04:41:49', NULL),
('975bbc75-17f4-40c1-b0b7-a35da67c931b', '8ecbc427-62dd-42c1-a3b3-da29fa4a8b19', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:55', '2024-08-06 04:39:55', NULL),
('b122451a-0203-4e81-83c3-64dc8549ade4', '6f4997bd-fc7b-42ab-8f97-1eccbab32143', '71005791-4508-47b8-a39f-c7d2b684c224', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-06-03 04:41:49', '2024-06-03 04:41:49', NULL),
('b9da57bf-c5b0-4f5a-bffe-dd7c97c142d0', '118d2231-bcfd-4041-9842-2ff13ceb436e', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:29', '2024-08-06 04:40:29', NULL),
('d2115efe-024f-497f-b927-2da0ccc1ca83', '26366c60-fbc7-11ee-9a73-d06db130dbb9', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('d671fdbb-5b5b-4f96-9670-39aa4d40fe27', '721f4724-a7f9-4c27-a3f7-e51920652342', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:29', '2024-08-06 04:40:29', NULL),
('dfcd315c-0b32-475c-af31-3d8f8c340f64', 'ec79b342-fbc6-11ee-9a73-d06db130dbb9', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL),
('ff6890e3-617e-43f6-b722-c37bd7e78de4', '46bfe88e-6c78-4f23-ab5b-0f79c499cc27', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:34', '2024-08-06 04:39:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `permission_id`, `role_id`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('00e59776-5be7-4d17-b46a-1ef341804cbc', '9cba4ec6-93f4-4d6b-8620-36ee737b8f9a', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('01059fc9-db27-4b9e-aadd-b8eb382ab7b6', 'f2f91d69-9daf-4485-9fdc-06d159fc22e0', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('04150a22-1b8e-4e88-a4cd-6e7d3a10f278', 'ef5afc68-7c0d-4422-9938-6206c77cfd4e', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('0ad41a79-a5b4-442c-9442-c902b7f0db3e', '275223db-f5a2-4d08-982a-126dcf563768', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('1316ccb4-8177-4124-9d97-b534f45c887a', 'cad60aef-e4e3-44c5-a464-d98bde72439d', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('141c18f6-c0a6-4cf9-9473-2aaebfc32c6d', '4e5c0892-1e4c-4b42-8791-43fdb49fe5de', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('16791966-ed9a-420a-b188-bb55606f05e7', '589e57c5-6e99-462f-8864-48186e2c0ef9', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('1763e01c-6e26-4fc7-a9f9-25b6000837d1', '5bd2f06c-4722-478e-8a4f-09504bf86f96', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('1cf134e1-c7c2-4fad-8095-795739ebb53e', '484503a5-f3cb-4417-9508-4bee4e889b67', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('205ac018-2c3f-4b3a-9b8e-3eaf1d81ccb7', 'e6ede68e-d457-420e-8a9e-03ff1be7f225', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('21ead2e1-5e41-4ad9-9fb3-c13b6addff46', 'b9dcb2fc-aff0-4f35-89f9-3bffbc720dc3', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('2275fece-9325-48a8-8cee-8dd3b390c02d', '3c8e6dc3-f0ff-4631-a67d-58ce29aa2ca7', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('248780d6-6cec-4d3f-9ef2-b8bdc5988cd7', 'c66a1975-2d35-4cb5-a017-6044ff1306bd', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('2818ef33-7ec9-4f6f-823d-a6ec41035bae', '1a9c7482-416b-4a22-9790-5424374f4df6', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('28b5f980-ac03-45cb-bf56-278758bb80c8', '13db52fb-17a0-46c6-9268-1e153ce5e921', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('2da91fe8-cc36-4d8a-bd87-20d79769e03e', '2f862c28-d57a-45e0-8d1e-d4b9d3e41058', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('345592f2-603a-458b-919e-21dde756444d', '56ba4bc0-e65a-4810-af94-a6486aac0cba', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('3a86714f-f65f-47b1-b791-800a74171180', '922a02f7-57ac-43ef-ad73-dcb4a2601a5b', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('44a2555b-148c-4729-9b56-fb16df6f3d1a', '9faae65c-0def-4fd4-8621-62e28e8386ed', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('44eac914-e549-4c02-b76a-b555598efa34', '9faae65c-0def-4fd4-8621-62e28e8386ed', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('45d2e5ac-3d8a-4b73-ba4b-168d7946444c', '15712f20-7f4c-4c51-a2eb-a580d910c1c2', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('46868df0-4fff-421d-be61-66505b44e566', '96fb5d0b-39af-4320-bbf4-55542432c682', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('4a5dac33-9012-42ac-a2bd-1e42f9656b42', '8fb9d2df-e225-4166-b14b-2ea3de0b6405', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('4fd84454-848b-4061-8482-6ef459e587e0', '66ff174b-d8cc-40ec-9da2-a5232928e373', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('518d8a4d-d687-483d-8974-9bdbc91bc6fc', '8fb9d2df-e225-4166-b14b-2ea3de0b6405', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('526ad944-dafb-4962-9e3b-65131f301da4', '096a6eb7-5d45-45b6-9d84-dc9155d6a4b4', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('675390e3-5a36-429c-a9a3-def667ecdd51', '6177aa68-534e-49fd-9467-c1047d75f8d0', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('70a34cd2-7b81-4411-8f1c-bfa7acb3975b', 'bc90f809-a6bf-4f9d-96f1-2eab8aa22330', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('71284c11-7a87-44b8-8dd2-a420693ce661', 'f2f91d69-9daf-4485-9fdc-06d159fc22e0', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('73e943d4-c4a8-4554-930d-460a2b647186', '5a3d4a2f-8a65-4e39-9914-6a12f5aa939f', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('7460ea17-84fe-443b-b9af-1103a45362be', '9153ff49-3904-497b-8205-83b79a84de57', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('77ad5a6f-f480-4740-9d0b-dcbabeb077ff', '484503a5-f3cb-4417-9508-4bee4e889b67', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('77ba995d-bd4d-4248-8b66-5bf6ff39b87f', '56ba4bc0-e65a-4810-af94-a6486aac0cba', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('77bb9cb1-b75e-47c4-a136-d6a84e684bf5', '3bbc35bd-c7c5-49d6-bf5a-ea467bde361a', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('789dbb2e-8223-4f26-8478-f1fe8af4205f', '7e684987-72f0-475b-9fc2-0e5991fe9cfd', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('7d950912-04fb-431f-8793-c1be9e5d8f4f', '15712f20-7f4c-4c51-a2eb-a580d910c1c2', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('7f3e37c0-71c5-4399-a672-45df8847e837', '99b297ab-10b2-40c7-9b49-2050bdb34e01', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('8063d9bf-28f2-4596-b61c-32f4e2b6ed37', '275223db-f5a2-4d08-982a-126dcf563768', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('80cf611d-3f92-4e33-86b5-e77e3ceff36d', '13db52fb-17a0-46c6-9268-1e153ce5e921', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('8653cefa-68ec-4783-b003-08ddb1257a7e', '6f601648-2e7c-4c48-87c6-c15d8d83668f', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('87937d06-b6e7-42f1-a4c2-f9aa82926f0c', '5bd2f06c-4722-478e-8a4f-09504bf86f96', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('8f6a5be4-e3dc-40ed-9cd8-9e8e8dc4a73e', '66ff174b-d8cc-40ec-9da2-a5232928e373', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('8ffb4d6b-e606-4b1c-8d20-fe8af7f13f7a', '115ad97b-e51e-4a97-8aae-4d2ed9efcaf0', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('91c32a7f-9653-4892-a982-ed5169aef08b', 'cad60aef-e4e3-44c5-a464-d98bde72439d', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('97e4fc2a-e9d5-43ea-9c09-e750ab2dd63a', '1a9c7482-416b-4a22-9790-5424374f4df6', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('9e06ed13-3751-4764-8c7a-7554c2b67bc5', '601382c0-20c8-4384-9e3e-c45d445b2e64', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('a107a1bd-ef35-484e-8f6b-b19892013d3e', '899a5a01-bc22-440c-bf6e-72403b90958e', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('a5708e80-6b03-4a5c-96ab-58f6dc833e2a', '484503a5-f3cb-4417-9508-4bee4e889b67', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('a8e062b7-0ce7-4965-9a57-12d0d4019377', '922a02f7-57ac-43ef-ad73-dcb4a2601a5b', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('ac8a8025-68ae-4b5a-a8d1-661e512c9791', '8dbee382-fd74-4cfe-a1d1-a4401059c1ba', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('b189566a-ce40-4962-85db-9d7868704be5', '4e5c0892-1e4c-4b42-8791-43fdb49fe5de', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('b194ab45-116d-412f-984e-7ef25a2c3162', 'bc90f809-a6bf-4f9d-96f1-2eab8aa22330', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('b2c8361b-a72d-40e5-bfe7-1b019f0502f2', '898034fe-222f-4a66-a338-acffc59d8173', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('b3459696-9bf2-4c65-a38f-20685f2ed533', '9cba4ec6-93f4-4d6b-8620-36ee737b8f9a', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('b3ef873c-f394-4c19-88bc-3c2e9c91ba13', '191b4847-e341-4eb6-9a5e-b66c25e96cfd', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('b496a1b2-09f7-4511-a64f-91a1fee7d211', 'f2290a3a-a220-4312-9a19-0620c009a6e0', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('b530890f-871e-4014-b673-5787acc69e56', '096a6eb7-5d45-45b6-9d84-dc9155d6a4b4', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('b5cdf2de-4dbb-43b1-9fe2-0f013dccb7b7', '601382c0-20c8-4384-9e3e-c45d445b2e64', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('b9a34ce8-e0ba-4583-9af2-70fbacc155fc', 'bc90f809-a6bf-4f9d-96f1-2eab8aa22330', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('bc1c8412-9ea4-41d8-b6d2-485b81f00e5a', '589e57c5-6e99-462f-8864-48186e2c0ef9', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('bec15e5d-088b-424a-8ee5-7f843afbdc9a', '8687652f-a840-4bba-b690-5b20610798fb', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('c1d678d5-0a55-4c1a-b4a8-658dc6af4bb3', '922a02f7-57ac-43ef-ad73-dcb4a2601a5b', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('c4cf68ea-6335-4ee5-8e11-4f67ef3ed072', '8dbee382-fd74-4cfe-a1d1-a4401059c1ba', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('ccb40e77-31c2-4c7d-918f-b5b94ab18ada', '6f601648-2e7c-4c48-87c6-c15d8d83668f', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('cd91a9b6-f521-4c73-b206-3ba6dfa045a9', '15712f20-7f4c-4c51-a2eb-a580d910c1c2', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('e113fe9c-6473-471f-b4f5-78d01db41c59', 'b3a6d033-2b86-4b39-ad44-73daff8ce53a', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('e1c3f190-cecc-443b-9780-8c9340b0c7b1', '275223db-f5a2-4d08-982a-126dcf563768', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('e1e20efe-b6c4-49b2-be1c-dd0d8cc0d55c', '0a48e0a1-904c-4527-b97a-e592d34b8178', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('e4539d84-98fa-4d20-b329-c65be3f838fc', '2f862c28-d57a-45e0-8d1e-d4b9d3e41058', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 09:08:42', '2024-08-06 09:08:42', NULL),
('e771a336-a3bd-45d7-ad44-df2b8e17e681', '622671a4-83c8-4f14-839f-7c0f5cdf4b26', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('f290c6c6-a203-4bd3-b922-d558705ae51d', '8472f610-87dd-45be-ad21-39f7402e75da', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('fa05b2bf-331c-4a74-811a-e5545095cce7', '898034fe-222f-4a66-a338-acffc59d8173', '2717020e-49bb-41a2-b790-d67e53089cc6', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:40:21', '2024-08-06 04:40:21', NULL),
('fb4ad434-4e46-4ab6-91d8-8a2136816045', '5a3d4a2f-8a65-4e39-9914-6a12f5aa939f', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('fe9da73b-8431-49af-8bd4-b7228b4236fa', '3c8e6dc3-f0ff-4631-a67d-58ce29aa2ca7', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL),
('ffe57cac-ae1a-44a7-8767-cd8820dfe11e', '8d281d88-5fda-438d-818d-47524ce5f5ca', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:41', '2024-08-06 04:39:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `url`
--

CREATE TABLE `url` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `url`
--

INSERT INTO `url` (`id`, `parent_id`, `name`, `slug`, `path`, `icon`, `order`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0841c084-1b54-4add-bf5a-05d1ed6b08fd', '721f4724-a7f9-4c27-a3f7-e51920652342', 'Pembelian', 'customer-pembelian', '/customer/pembelian', 'bi bi-journals', 2, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:39:22', '2024-08-06 04:39:22', NULL),
('0eaf0c9f-7504-44b2-b9a5-f85a8f023352', NULL, 'Merchant', 'merchant', '/merchant', 'bi bi-dot', 1, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:32:28', '2024-08-06 04:32:28', NULL),
('118d2231-bcfd-4041-9842-2ff13ceb436e', '721f4724-a7f9-4c27-a3f7-e51920652342', 'Pencarian', 'customer-pencarian', '/customer/pencarian', 'bi bi-search', 1, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:38:40', '2024-08-06 04:38:40', NULL),
('1e26bbac-fbc6-11ee-9a73-d06db130dbb9', NULL, 'Settings', 'settings', '/setting', 'bi bi-gear-fill', 3, NULL, NULL, NULL, NULL, NULL, NULL),
('26366c60-fbc7-11ee-9a73-d06db130dbb9', '1e26bbac-fbc6-11ee-9a73-d06db130dbb9', 'Roles', 'settings-roles', '/setting/roles', 'bi bi-person-video2', 2, NULL, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-04-17 04:05:47', NULL),
('26367372-fbc7-11ee-9a73-d06db130dbb9', '1e26bbac-fbc6-11ee-9a73-d06db130dbb9', 'Permissions', 'settings-permissions', '/setting/permissions', 'bi bi-universal-access-circle', 3, NULL, NULL, NULL, NULL, NULL, NULL),
('3e01ed1a-fbc7-11ee-9a73-d06db130dbb9', '1e26bbac-fbc6-11ee-9a73-d06db130dbb9', 'Users', 'settings-users', '/setting/users', 'bi bi-people-fill', 4, NULL, NULL, NULL, NULL, NULL, NULL),
('46bfe88e-6c78-4f23-ab5b-0f79c499cc27', '0eaf0c9f-7504-44b2-b9a5-f85a8f023352', 'Profile', 'merchant-profile', '/merchant/profile/overview', 'bi bi-shop', 1, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, '2024-08-06 04:33:49', '2024-08-06 09:23:28', NULL),
('721f4724-a7f9-4c27-a3f7-e51920652342', NULL, 'Customer', 'customer', '/customer', 'bi bi-dot', 2, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:46', '2024-08-06 04:36:46', NULL),
('8ecbc427-62dd-42c1-a3b3-da29fa4a8b19', '0eaf0c9f-7504-44b2-b9a5-f85a8f023352', 'Orders', 'merchant-orders', '/merchant/orders', 'bi bi-journals', 3, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:36:03', '2024-08-06 04:36:03', NULL),
('ec79b342-fbc6-11ee-9a73-d06db130dbb9', '1e26bbac-fbc6-11ee-9a73-d06db130dbb9', 'Url', 'settings-url', '/setting/url', 'bi bi-link-45deg', 1, NULL, NULL, NULL, NULL, NULL, NULL),
('ee74af47-0f05-4100-b80c-0e460b034a2d', '0eaf0c9f-7504-44b2-b9a5-f85a8f023352', 'Menu', 'merchant-menu', '/merchant/menu', 'bi bi-list-ul', 2, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-08-06 04:35:07', '2024-08-06 04:35:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `role_id`, `password`, `remember_token`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0cc56985-1586-49e9-b8e9-25cec2bb9ae7', 'Tengku Firmansyah', 'tengkufirmansyah2@gmail.com', '2024-08-06 16:06:06', '4f4f0c6b-a3bf-4fa0-9e14-7c3ce00693d1', '$2y$10$.Z3xTQC7Ln5ENDUicTO4keqRcGOyimB/QM6OHXFY9mvdnIwYXmVhO', NULL, NULL, NULL, NULL, '2024-08-06 09:06:06', '2024-08-06 09:06:06', NULL),
('130e4804-e6df-47cf-8f0e-d5f276a0250b', 'User', 'user@gmail.com', NULL, '2717020e-49bb-41a2-b790-d67e53089cc6', '$2y$10$4Pj5ki/cjqN2B.kIuhCP7eikbxbPvsRjXhSMs0F45eR.zMrF2Ew2a', NULL, 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, '2024-04-18 05:55:11', '2024-08-06 09:10:04', NULL),
('ee9b1870-fbbf-11ee-9a73-d06db130dbb9', 'Admin', 'admin@gmail.com', '2022-10-11 11:38:49', '4b155cb4-fbc0-11ee-9a73-d06db130dbb9', '$2y$10$zdF/N8RsQeC8UhCDz0r68uwnpLbCz3mVmAfPYcxxnzKph2GIZNSxO', NULL, '5e7a6933-7ae5-432e-aabb-c82d133e12cd', 'ee9b1870-fbbf-11ee-9a73-d06db130dbb9', NULL, NULL, '2024-05-19 05:52:09', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forget_password`
--
ALTER TABLE `forget_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_status`
--
ALTER TABLE `job_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_status_nama_index` (`nama`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchant_menu`
--
ALTER TABLE `merchant_menu`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `url`
--
ALTER TABLE `url`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url_parent_id_index` (`parent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_status`
--
ALTER TABLE `job_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
