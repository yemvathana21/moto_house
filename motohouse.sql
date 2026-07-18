-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 01, 2026 at 06:53 PM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motohouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hero',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image`, `link`, `position`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Everything for You', 'Quality motorcycle gear at the best prices', 'banners/01KV072TYMWY3FV1APNG52QTTP.png', 'https://moto-house.vercel.app/shop', 'hero', 2, 1, '2026-05-20 21:16:12', '2026-06-13 03:26:22'),
(3, 'Everything for You', 'Quality motorcycle gear at the best prices!!!', 'banners/01KV070T2JP9YQ3DFS6XYSSRSR.png', 'https://moto-house.vercel.app/shop', 'hero', 1, 1, '2026-05-21 11:45:55', '2026-06-13 03:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Helmet', 'Helmet', '<p>Helmet</p>', 'categories/01KS8A07HYKG3Z8RXAZ1V18W5J.png', NULL, 1, '2026-05-20 20:18:13', '2026-05-22 09:58:51'),
(2, 'Parts', 'Parts', '<p>Parts</p>', 'categories/01KS8AHNT1AKKW7TGF5ZRE17YE.png', NULL, 1, '2026-05-20 20:31:23', '2026-05-22 10:08:22'),
(3, 'Accessories', 'Accessories', '<p>Accessories</p>', 'categories/01KS8A82H3EHRHZ1ZM06KGE0SD.png', NULL, 1, '2026-05-20 20:36:05', '2026-05-22 10:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_uses` int DEFAULT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_order_amount`, `max_uses`, `used_count`, `starts_at`, `expires_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'MOTOHOUSE', 'percentage', 30.00, 25.00, 10, 6, '2026-05-21 03:10:06', '2027-12-31 03:10:10', 1, '2026-05-21 20:11:01', '2026-06-03 18:31:16');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_vip` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `address`, `city`, `state`, `postal_code`, `country`, `is_vip`, `notes`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'Vathana', 'sreymas2016@gmail.com', '', '0978537707', '10mc', 'pp', 'pp', '12000', 'kh', 1, 'First client ', '2026-05-21 11:56:20', '2026-05-22 21:10:03', NULL),
(2, 'Pu Sok', 'pusok55@gmail.com', '', '0978537707', '10mc', 'pp', 'pp', '12000', 'Cambodia', 0, NULL, '2026-05-21 21:15:25', '2026-05-21 21:15:25', NULL),
(3, 'Ah Jo', 'ahjo123@gmail.com', '', '0978537707', '10mc', 'Pp', 'Pp', '12000', 'Pp', 0, NULL, '2026-05-22 20:13:00', '2026-05-22 20:13:00', NULL),
(4, 'Ah Jo ', 'jo123@gmail.com', '', '', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-22 22:11:04', '2026-05-22 22:11:04', NULL),
(5, 'Admin', 'admin@motohouse.com', '', '', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-05-25 19:44:50', '2026-05-25 19:44:50', NULL),
(6, 'Ban Chreok', 'dhj@gmail.com', '', '0964545', 'Ghjx', 'Hjdi', 'Jjxdi', 'Mkkd', 'Nnbs', 0, NULL, '2026-05-25 19:45:43', '2026-05-25 19:45:43', NULL),
(7, 'Vathana', 'vathana@gmail.com', '', '123', 'dd', 'dd', 'dd', '1200', 'Cambodia', 0, NULL, '2026-06-03 18:31:16', '2026-06-03 18:31:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exports`
--

CREATE TABLE `exports` (
  `id` bigint UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `total_rows` int UNSIGNED NOT NULL,
  `successful_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_import_rows`
--

CREATE TABLE `failed_import_rows` (
  `id` bigint UNSIGNED NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `import_id` bigint UNSIGNED NOT NULL,
  `validation_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` bigint UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `total_rows` int UNSIGNED NOT NULL,
  `successful_rows` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"3f4caa09-3943-45b2-9e1e-de992313d7fb\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"yemvathana86@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779389781,\"delay\":null}', 0, NULL, 1779389781, 1779389781),
(2, 'default', '{\"uuid\":\"0f046954-876c-45be-b438-cc5c17746677\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"yemvathana86@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779390013,\"delay\":null}', 0, NULL, 1779390013, 1779390013),
(3, 'default', '{\"uuid\":\"7558a696-02e3-450d-b36e-1141a57b4c23\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"yemvathana86@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779390148,\"delay\":null}', 0, NULL, 1779390148, 1779390148),
(4, 'default', '{\"uuid\":\"fdffcfa1-1b90-4443-af20-e0f277fdb30e\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"yemvathana86@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779419870,\"delay\":null}', 0, NULL, 1779419870, 1779419870),
(5, 'default', '{\"uuid\":\"9433878e-5e30-4d14-ac83-0f24061176fd\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"yemvathana86@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779419983,\"delay\":null}', 0, NULL, 1779419983, 1779419983),
(6, 'default', '{\"uuid\":\"8342322e-8e90-425b-9940-3b0537c9f29e\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"yemvathana86@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779420091,\"delay\":null}', 0, NULL, 1779420091, 1779420091),
(7, 'default', '{\"uuid\":\"0174af8f-0dca-4962-adc9-c554a7682535\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:7;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"pusok55@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779423326,\"delay\":null}', 0, NULL, 1779423326, 1779423326),
(8, 'default', '{\"uuid\":\"14208e0a-6512-4f69-b83c-b6bf9a2da0d0\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:8;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"pusok55@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779423461,\"delay\":null}', 0, NULL, 1779423461, 1779423461),
(9, 'default', '{\"uuid\":\"5230f775-b8a6-4bdf-ba56-beb775c0354d\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:9;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"pusok55@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779429803,\"delay\":null}', 0, NULL, 1779429803, 1779429803),
(10, 'default', '{\"uuid\":\"f1d933b6-a2b9-4b3b-a69d-120da93fd9c1\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"ahjo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779505982,\"delay\":null}', 0, NULL, 1779505982, 1779505982),
(11, 'default', '{\"uuid\":\"65e29d7e-36c0-474b-a58e-540642d628a8\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:11;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779513632,\"delay\":null}', 0, NULL, 1779513632, 1779513632),
(12, 'default', '{\"uuid\":\"1d0545ce-2e92-4541-bfff-f895e75303b1\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:12;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779555796,\"delay\":null}', 0, NULL, 1779555796, 1779555796),
(13, 'default', '{\"uuid\":\"a3d09609-e1a5-4e4d-892e-5aaac73713a0\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"pusok55@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779555858,\"delay\":null}', 0, NULL, 1779555858, 1779555858),
(14, 'default', '{\"uuid\":\"96e48d0b-dfed-497b-bdbb-30de20e293d4\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:14;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779558022,\"delay\":null}', 0, NULL, 1779558022, 1779558022),
(15, 'default', '{\"uuid\":\"f2e771ca-47fc-4820-900d-585ef2712115\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:15;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"pusok55@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779563124,\"delay\":null}', 0, NULL, 1779563125, 1779563125),
(16, 'default', '{\"uuid\":\"32948c53-323c-46c7-a19e-7eeed5267011\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:16;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779603088,\"delay\":null}', 0, NULL, 1779603088, 1779603088),
(17, 'default', '{\"uuid\":\"54cfdbd6-188d-4244-afc9-8ebd16105d03\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:17;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:13:\\\"dhj@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779763544,\"delay\":null}', 0, NULL, 1779763544, 1779763544),
(18, 'default', '{\"uuid\":\"c3247783-627d-4d64-92e0-f1ac54a76cb8\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:18;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779764916,\"delay\":null}', 0, NULL, 1779764916, 1779764916),
(19, 'default', '{\"uuid\":\"5b1690b7-6064-43cf-97cf-300899ab285a\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:19;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779815409,\"delay\":null}', 0, NULL, 1779815409, 1779815409),
(20, 'default', '{\"uuid\":\"23aac655-185a-4d28-b373-eb6a4d1c5df1\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:20;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:17:\\\"vathana@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1780536677,\"delay\":null}', 0, NULL, 1780536677, 1780536677),
(21, 'default', '{\"uuid\":\"1433fffe-81dd-4f46-8e59-1c5c6a999b60\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:21;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1782528549,\"delay\":null}', 0, NULL, 1782528549, 1782528549),
(22, 'default', '{\"uuid\":\"69c0902f-b5a6-49c8-baa6-5ec7e0dfa7b5\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:22;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1782531389,\"delay\":null}', 0, NULL, 1782531389, 1782531389),
(23, 'default', '{\"uuid\":\"5a36a0bb-369d-48d8-8930-933527781d21\",\"displayName\":\"App\\\\Mail\\\\OrderConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":18:{s:8:\\\"mailable\\\";O:26:\\\"App\\\\Mail\\\\OrderConfirmation\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:23;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:15:\\\"jo123@gmail.com\\\";}}s:6:\\\"mailer\\\";s:3:\\\"log\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:13:\\\"debounceOwner\\\";s:0:\\\"\\\";s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1782537078,\"delay\":null}', 0, NULL, 1782537078, 1782537078);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_20_014541_create_categories_table', 1),
(5, '2026_05_20_014542_create_products_table', 1),
(6, '2026_05_20_014543_create_customers_table', 1),
(7, '2026_05_20_014545_create_orders_table', 1),
(8, '2026_05_20_014546_create_order_items_table', 1),
(9, '2026_05_20_020709_create_permission_tables', 2),
(10, '2026_05_20_020917_create_settings_table', 3),
(11, '2026_05_20_042044_create_reviews_table', 4),
(12, '2026_05_20_042045_create_wishlists_table', 4),
(13, '2026_05_20_042046_create_coupons_table', 4),
(14, '2026_05_21_015350_create_pages_table', 5),
(15, '2026_05_21_015402_create_banners_table', 5),
(16, '2026_05_23_063615_add_parent_id_to_reviews_table', 6),
(17, '2026_05_27_000001_add_bakong_fields_to_orders_table', 7),
(18, '2026_06_07_103519_create_imports_table', 8),
(19, '2026_06_07_103520_create_exports_table', 8),
(20, '2026_06_07_103521_create_failed_import_rows_table', 8),
(21, '2026_06_13_171747_create_personal_access_tokens_table', 9),
(22, '2026_06_13_171953_add_password_to_customers_table', 9),
(23, '2026_06_13_172123_add_customer_id_to_reviews_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shipping_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `md5_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `status`, `subtotal`, `tax`, `shipping`, `discount`, `total`, `notes`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_postal_code`, `shipping_country`, `payment_method`, `payment_status`, `transaction_id`, `paid_at`, `md5_hash`, `created_at`, `updated_at`) VALUES
(1, 'MH-6A0F5554796C6', 1, 'pending', 99.50, 9.95, 0.00, 0.00, 109.45, NULL, '10mc', 'pp', 'pp', '12000', 'kh', 'bank_transfer', 'paid', NULL, NULL, NULL, '2026-05-21 11:56:20', '2026-05-23 23:13:52'),
(2, 'MH-6A0F563D8FBC6', 1, 'processing', 22.00, 2.20, 0.00, 0.00, 24.20, NULL, '10mc', NULL, NULL, NULL, NULL, 'cash', 'paid', NULL, NULL, NULL, '2026-05-21 12:00:13', '2026-05-21 12:06:13'),
(3, 'MH-6A0F56C467B00', 1, 'delivered', 2.50, 0.25, 0.00, 0.00, 2.75, NULL, '10mc', NULL, NULL, NULL, NULL, 'cash', 'paid', NULL, NULL, NULL, '2026-05-21 12:02:28', '2026-05-21 12:05:46'),
(4, 'MH-6A0FCADDE0634', 1, 'pending', 75.00, 7.50, 0.00, 22.50, 60.00, NULL, '10mc', 'pp', '', '12000', 'Cambodia', 'cash', 'pending', NULL, NULL, NULL, '2026-05-21 20:17:49', '2026-05-21 20:17:49'),
(5, 'MH-6A0FCB4F19A6D', 1, 'pending', 75.00, 7.50, 0.00, 22.50, 60.00, NULL, '10mc', 'pp', 'pp', '12000', 'Cambodia', 'cash', 'pending', NULL, NULL, NULL, '2026-05-21 20:19:43', '2026-05-21 20:19:43'),
(6, 'MH-6A0FCBBB5086B', 1, 'cancelled', 75.00, 7.50, 0.00, 22.50, 60.00, NULL, '10mc', 'pp', 'pp', '12000', 'Cambodia', 'cash', 'pending', NULL, NULL, NULL, '2026-05-21 20:21:31', '2026-05-21 20:24:57'),
(7, 'MH-6A0FD85DEDA3D', 2, 'pending', 15.00, 1.50, 0.00, 0.00, 16.50, NULL, '10mc', 'pp', 'pp', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-21 21:15:25', '2026-05-21 21:15:25'),
(8, 'MH-6A0FD8E557906', 2, 'pending', 15.00, 1.50, 0.00, 0.00, 16.50, NULL, '10mc', 'pp', '', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-21 21:17:41', '2026-05-21 21:17:41'),
(9, 'MH-6A0FF1AB6724D', 2, 'pending', 75.00, 7.50, 0.00, 22.50, 60.00, NULL, '10mc', 'pp', '', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-21 23:03:23', '2026-05-21 23:03:23'),
(11, 'MH-6A11391E25319', 4, 'shipped', 3.50, 0.35, 0.00, 0.00, 3.85, NULL, 'Ququ', 'Aha', 'Aha', 'Hah', 'Ahha', 'cash', 'pending', NULL, NULL, NULL, '2026-05-22 22:20:30', '2026-05-22 22:21:17'),
(12, 'MH-6A11DDD4144AF', 4, 'pending', 2.50, 0.25, 0.00, 0.00, 2.75, NULL, 'Sjsj', 'Sjsj', 'Sjsj', 'Sjsj', 'Sjsj', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-23 10:03:16', '2026-05-23 10:03:16'),
(13, 'MH-6A11DE12BD1A1', 2, 'pending', 75.00, 7.50, 0.00, 0.00, 82.50, NULL, '10mc', 'pp', '', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-23 10:04:18', '2026-05-23 10:04:18'),
(14, 'MH-6A11E686B90AA', 4, 'pending', 3.50, 0.35, 0.00, 0.00, 3.85, NULL, 'Sjjs', 'Sjs', 'Djsj', 'Sjsj', 'Sjsj', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-23 10:40:22', '2026-05-23 10:40:22'),
(15, 'MH-6A11FA728BE31', 2, 'pending', 15.00, 1.50, 0.00, 0.00, 16.50, NULL, '10mc', 'pp', '', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-23 12:05:22', '2026-05-23 12:05:22'),
(16, 'MH-6A12968DD4228', 4, 'pending', 15.00, 1.50, 0.00, 0.00, 16.50, NULL, '10mc', 'pp', 'pp', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-23 23:11:25', '2026-05-23 23:11:25'),
(17, 'MH-6A150957BB713', 6, 'pending', 250.00, 25.00, 0.00, 0.00, 275.00, NULL, 'Ghjx', 'Hjdi', 'Jjxdi', 'Mkkd', 'Nnbs', 'khqr', 'pending', NULL, NULL, NULL, '2026-05-25 19:45:43', '2026-05-25 19:45:43'),
(18, 'MH-6A150EB42B052', 4, 'pending', 0.01, 0.00, 0.00, 0.00, 0.01, NULL, '10mc', 'pp', 'pp', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, 'fce013975b5825cdd7d1afd00f87780b', '2026-05-25 20:08:36', '2026-05-26 10:08:20'),
(19, 'MH-6A15D3EF85343', 4, 'pending', 0.01, 0.00, 0.00, 0.00, 0.01, NULL, '10mc', 'pp', '', '12000', 'Cambodia', 'khqr', 'pending', NULL, NULL, '69950f2565d692ee35ed63800737ccd3', '2026-05-26 10:10:07', '2026-05-26 10:22:07'),
(20, 'MH-6A20D564F0B8D', 7, 'pending', 150.00, 15.00, 0.00, 45.00, 120.00, NULL, 'dd', 'dd', 'dd', '1200', 'Cambodia', 'khqr', 'pending', NULL, NULL, NULL, '2026-06-03 18:31:16', '2026-06-03 18:31:16'),
(21, 'MH-6A3F3A20A24FE', 4, 'pending', 15.00, 1.50, 0.00, 0.00, 16.50, NULL, '10mc', 'pp', 'pp', '12000', 'Cambodia', 'cod', 'pending', NULL, NULL, NULL, '2026-06-26 19:49:04', '2026-06-26 19:49:04'),
(22, 'MH-6A3F453D4AA91', 4, 'pending', 0.01, 0.00, 0.00, 0.00, 0.01, NULL, '10mc', 'pp', '', '12000', 'Cambodia', 'cod', 'pending', NULL, NULL, NULL, '2026-06-26 20:36:29', '2026-06-26 20:36:29'),
(23, 'MH-6A3F5B763F4DE', 4, 'delivered', 0.01, 0.00, 0.00, 0.00, 0.01, NULL, '10mc', 'pp', NULL, '12000', 'Cambodia', 'cash', 'paid', NULL, NULL, NULL, '2026-06-26 22:11:18', '2026-06-26 22:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'RCB Break', 22.00, 1, 22.00, '2026-05-21 11:56:20', '2026-05-21 11:56:20'),
(2, 1, 3, 'Gloves', 2.50, 1, 2.50, '2026-05-21 11:56:20', '2026-05-21 11:56:20'),
(3, 1, 1, 'Helmet', 75.00, 1, 75.00, '2026-05-21 11:56:20', '2026-05-21 11:56:20'),
(4, 2, 4, 'RCB Break', 22.00, 1, 22.00, '2026-05-21 12:00:13', '2026-05-21 12:00:13'),
(5, 3, 3, 'Gloves', 2.50, 1, 2.50, '2026-05-21 12:02:28', '2026-05-21 12:02:28'),
(6, 4, 1, 'Helmet', 75.00, 1, 75.00, '2026-05-21 20:17:49', '2026-05-21 20:17:49'),
(7, 5, 1, 'Helmet', 75.00, 1, 75.00, '2026-05-21 20:19:43', '2026-05-21 20:19:43'),
(8, 6, 1, 'Helmet', 75.00, 1, 75.00, '2026-05-21 20:21:31', '2026-05-21 20:21:31'),
(9, 7, 2, 'LED Light', 15.00, 1, 15.00, '2026-05-21 21:15:25', '2026-05-21 21:15:25'),
(10, 8, 2, 'LED Light', 15.00, 1, 15.00, '2026-05-21 21:17:41', '2026-05-21 21:17:41'),
(11, 9, 1, 'Helmet', 75.00, 1, 75.00, '2026-05-21 23:03:23', '2026-05-21 23:03:23'),
(13, 11, 5, 'Stickers', 3.50, 1, 3.50, '2026-05-22 22:20:30', '2026-05-22 22:20:30'),
(14, 12, 3, 'Gloves', 2.50, 1, 2.50, '2026-05-23 10:03:16', '2026-05-23 10:03:16'),
(15, 13, 7, 'MFZ Caliper', 75.00, 1, 75.00, '2026-05-23 10:04:18', '2026-05-23 10:04:18'),
(16, 14, 5, 'Stickers', 3.50, 1, 3.50, '2026-05-23 10:40:22', '2026-05-23 10:40:22'),
(17, 15, 9, 'HT Racing CNC Aluminum Radiator Guard for Honda Click / Vario 125/150', 15.00, 1, 15.00, '2026-05-23 12:05:22', '2026-05-23 12:05:22'),
(18, 16, 9, 'HT Racing CNC Aluminum Radiator Guard for Honda Click / Vario 125/150', 15.00, 1, 15.00, '2026-05-23 23:11:25', '2026-05-23 23:11:25'),
(19, 17, 6, 'KYT Helmet', 125.00, 2, 250.00, '2026-05-25 19:45:43', '2026-05-25 19:45:43'),
(20, 18, 3, 'Gloves', 0.01, 1, 0.01, '2026-05-25 20:08:36', '2026-05-25 20:08:36'),
(21, 19, 3, 'Gloves', 0.01, 1, 0.01, '2026-05-26 10:10:07', '2026-05-26 10:10:07'),
(22, 20, 7, 'MFZ Caliper', 75.00, 2, 150.00, '2026-06-03 18:31:17', '2026-06-03 18:31:17'),
(23, 21, 2, 'LED Light', 15.00, 1, 15.00, '2026-06-26 19:49:04', '2026-06-26 19:49:04'),
(24, 22, 3, 'Gloves', 0.01, 1, 0.01, '2026-06-26 20:36:29', '2026-06-26 20:36:29'),
(25, 23, 3, 'Gloves', 0.01, 1, 0.01, '2026-06-26 22:11:18', '2026-06-26 22:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Terms of Service', 'terms-of-service', '<p>terms-of-service</p>', 'terms-of-service', 'terms-of-service', 1, '2026-05-22 08:33:29', '2026-06-26 20:59:14'),
(2, 'Privacy Policy', 'privacy-policy', '<p>privacy-policy</p>', 'privacy-policy', 'privacy-policy', 1, '2026-06-26 20:57:47', '2026-06-26 20:57:47'),
(3, 'Shipping Policy', 'shipping-policy', '<p>Coming soon</p>', 'Meta Title', 'Meta Description', 1, '2026-06-26 21:00:09', '2026-06-26 21:04:48'),
(4, 'Returns Exchanges', 'returns-exchanges', '<p>returns-exchanges</p>', 'returns-exchanges', 'returns-exchanges', 1, '2026-06-26 21:03:06', '2026-06-26 21:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view_any_category', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(2, 'view_category', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(3, 'create_category', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(4, 'update_category', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(5, 'delete_category', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(6, 'view_any_product', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(7, 'view_product', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(8, 'create_product', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(9, 'update_product', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(10, 'delete_product', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(11, 'view_any_customer', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(12, 'view_customer', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(13, 'create_customer', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(14, 'update_customer', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(15, 'delete_customer', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(16, 'view_any_order', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(17, 'view_order', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(18, 'create_order', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(19, 'update_order', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(20, 'delete_order', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(21, 'view_any_role', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(22, 'view_role', 'web', '2026-05-19 19:11:05', '2026-05-19 19:11:05'),
(23, 'create_role', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(24, 'update_role', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(25, 'delete_role', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(26, 'view_any_permission', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(27, 'view_permission', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(28, 'create_permission', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(29, 'update_permission', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(30, 'delete_permission', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(31, 'view_any_user', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(32, 'view_user', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(33, 'create_user', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(34, 'update_user', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(35, 'delete_user', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(36, 'view_settings', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(37, 'update_settings', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(38, 'view_any_review', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(39, 'view_review', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(40, 'create_review', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(41, 'update_review', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(42, 'delete_review', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(43, 'view_any_coupon', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(44, 'view_coupon', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(45, 'create_coupon', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(46, 'update_coupon', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(47, 'delete_coupon', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(48, 'view_any_page', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(49, 'view_page', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(50, 'create_page', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(51, 'update_page', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(52, 'delete_page', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(53, 'view_any_banner', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(54, 'view_banner', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(55, 'create_banner', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(56, 'update_banner', 'web', '2026-05-20 18:59:12', '2026-05-20 18:59:12'),
(57, 'delete_banner', 'web', '2026-05-20 18:59:13', '2026-05-20 18:59:13'),
(58, 'ViewAny:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(59, 'View:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(60, 'Create:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(61, 'Update:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(62, 'Delete:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(63, 'DeleteAny:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(64, 'Restore:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(65, 'ForceDelete:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(66, 'ForceDeleteAny:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(67, 'RestoreAny:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(68, 'Replicate:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(69, 'Reorder:Banner', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(70, 'ViewAny:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(71, 'View:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(72, 'Create:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(73, 'Update:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(74, 'Delete:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(75, 'DeleteAny:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(76, 'Restore:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(77, 'ForceDelete:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(78, 'ForceDeleteAny:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(79, 'RestoreAny:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(80, 'Replicate:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(81, 'Reorder:Category', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(82, 'ViewAny:Coupon', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(83, 'View:Coupon', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(84, 'Create:Coupon', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(85, 'Update:Coupon', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(86, 'Delete:Coupon', 'admin', '2026-06-07 03:03:34', '2026-06-07 03:03:34'),
(87, 'DeleteAny:Coupon', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(88, 'Restore:Coupon', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(89, 'ForceDelete:Coupon', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(90, 'ForceDeleteAny:Coupon', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(91, 'RestoreAny:Coupon', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(92, 'Replicate:Coupon', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(93, 'Reorder:Coupon', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(94, 'ViewAny:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(95, 'View:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(96, 'Create:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(97, 'Update:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(98, 'Delete:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(99, 'DeleteAny:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(100, 'Restore:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(101, 'ForceDelete:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(102, 'ForceDeleteAny:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(103, 'RestoreAny:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(104, 'Replicate:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(105, 'Reorder:Customer', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(106, 'ViewAny:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(107, 'View:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(108, 'Create:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(109, 'Update:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(110, 'Delete:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(111, 'DeleteAny:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(112, 'Restore:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(113, 'ForceDelete:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(114, 'ForceDeleteAny:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(115, 'RestoreAny:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(116, 'Replicate:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(117, 'Reorder:Order', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(118, 'ViewAny:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(119, 'View:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(120, 'Create:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(121, 'Update:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(122, 'Delete:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(123, 'DeleteAny:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(124, 'Restore:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(125, 'ForceDelete:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(126, 'ForceDeleteAny:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(127, 'RestoreAny:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(128, 'Replicate:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(129, 'Reorder:Page', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(130, 'ViewAny:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(131, 'View:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(132, 'Create:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(133, 'Update:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(134, 'Delete:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(135, 'DeleteAny:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(136, 'Restore:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(137, 'ForceDelete:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(138, 'ForceDeleteAny:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(139, 'RestoreAny:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(140, 'Replicate:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(141, 'Reorder:Permission', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(142, 'ViewAny:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(143, 'View:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(144, 'Create:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(145, 'Update:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(146, 'Delete:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(147, 'DeleteAny:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(148, 'Restore:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(149, 'ForceDelete:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(150, 'ForceDeleteAny:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(151, 'RestoreAny:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(152, 'Replicate:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(153, 'Reorder:Product', 'admin', '2026-06-07 03:03:35', '2026-06-07 03:03:35'),
(154, 'ViewAny:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(155, 'View:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(156, 'Create:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(157, 'Update:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(158, 'Delete:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(159, 'DeleteAny:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(160, 'Restore:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(161, 'ForceDelete:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(162, 'ForceDeleteAny:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(163, 'RestoreAny:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(164, 'Replicate:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(165, 'Reorder:Review', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(166, 'ViewAny:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(167, 'View:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(168, 'Create:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(169, 'Update:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(170, 'Delete:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(171, 'DeleteAny:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(172, 'Restore:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(173, 'ForceDelete:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(174, 'ForceDeleteAny:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(175, 'RestoreAny:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(176, 'Replicate:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(177, 'Reorder:Role', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(178, 'ViewAny:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(179, 'View:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(180, 'Create:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(181, 'Update:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(182, 'Delete:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(183, 'DeleteAny:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(184, 'Restore:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(185, 'ForceDelete:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(186, 'ForceDeleteAny:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(187, 'RestoreAny:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(188, 'Replicate:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(189, 'Reorder:User', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(190, 'View:ManageEmailSettings', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(191, 'View:ManagePaymentSettings', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(192, 'View:ManageSettings', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(193, 'View:ManageTheme', 'admin', '2026-06-07 03:03:36', '2026-06-07 03:03:36'),
(194, 'View:StatsOverview', 'admin', '2026-06-07 03:03:37', '2026-06-07 03:03:37'),
(195, 'View:RevenueChart', 'admin', '2026-06-07 03:03:37', '2026-06-07 03:03:37'),
(196, 'View:RecentOrders', 'admin', '2026-06-07 03:03:37', '2026-06-07 03:03:37'),
(197, 'View:LowStockAlerts', 'admin', '2026-06-07 03:03:37', '2026-06-07 03:03:37');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `images` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specifications` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `compare_price`, `stock_quantity`, `sku`, `category_id`, `images`, `is_active`, `is_featured`, `brand`, `specifications`, `created_at`, `updated_at`) VALUES
(1, 'Helmet', 'Helmet', '<p>full face</p>', 75.00, 100.00, 85, 'HEL-001', 1, '[\"products/01KS4B3W0QVMY4CB2P2D99PDD6.jpg\"]', 1, 1, 'KYT', '{\"Size\": \"S/M/XL\", \"Brand\": \"KYT\", \"Color\": \"Black and white\", \"Years\": \"2026\"}', '2026-05-20 20:19:48', '2026-05-21 23:03:23'),
(2, 'LED Light', 'led-light', '<p>RGB full light</p>', 15.00, 25.00, 17, 'DMX-V1', 2, '[\"products/01KS4B4TXCE4VV5K76BHN00V0A.jpg\"]', 1, 1, 'DMX', '{\"BOT\": \"2 Output\", \"From\": \"Indonesia \", \"Brand\": \"DMX\"}', '2026-05-20 20:34:14', '2026-06-26 19:49:04'),
(3, 'Gloves', 'gloves', '<p>The best gloves for you!!!</p>', 0.01, 5.00, 14, 'KYT-G-001', 3, '[\"products/01KS4B5EMX2D4PM221EN5EXQ3R.jpg\"]', 1, 1, 'KYT', '{\"Brand\": \"KYT\", \"Color\": \"White and blue\"}', '2026-05-20 20:38:18', '2026-06-26 22:11:18'),
(4, 'RCB Break', 'rcb-break', '<p>RCB break</p>', 22.00, 25.00, 100, 'RCB-001', 2, '[\"products/01KS5X9F9C5CHEBG2SRR7TF0DS.jpg\"]', 1, 1, 'RCB', '{\"Color\": \"Black and red\", \"Model\": \"RCB\", \"Sensor\": \"2 sensor, left and right\"}', '2026-05-21 11:38:13', '2026-05-22 09:12:03'),
(5, 'Stickers', 'stickers', '<p>Stickers for bikes</p>', 3.50, 5.00, 18, 'STIKERS-001', 3, '[\"products/01KS87XCN5XC4XV3714B9AP6BG.jpg\"]', 1, 1, 'Stickers', '{\"Album\": \"30 Stickers\", \"Color\": \"Colorful\", \"Made in\": \"Cambodia\"}', '2026-05-22 09:22:21', '2026-05-23 10:40:22'),
(6, 'KYT Helmet', 'kyt-helmet', '<p>Full face</p>', 125.00, 150.00, 66, 'HEL-002', 1, '[\"products/01KS88B05HXJBPHD00W67DVMSD.jpg\"]', 1, 1, 'KYT', '{\"Size\": \"S/M/L/XL\", \"Brand\": \"KYT\", \"Color\": \"Black and White\", \"Glasses\": \"2 Black and white\"}', '2026-05-22 09:29:47', '2026-05-25 19:45:43'),
(7, 'MFZ Caliper', 'mfz-caliper', '<blockquote><p>Upgrade your machine’s stopping power with the <strong>MFZ Racing High-Performance Radial Brake Caliper</strong>. Engineered explicitly for demanding track setups, performance scooters (like XMAX, Forza), and custom sportbikes, this masterfully crafted component replaces weak factory setups with absolute precision.</p><p>Machined flawlessly from a single block of <strong>A7075 Super Duralumin alloy</strong>, it maximizes structural rigidity under extreme clamping loads while maintaining a lightweight profile. The exterior body features integrated, deep aggressive cooling fins designed to rapidly dissipate heat, eliminating brake fade during hard tracking sessions. Fitted with premium anodized protection, striking red branding accents, and integrated pressure bleeders, it delivers elite-tier braking modulation at an exceptional value.</p></blockquote>', 75.00, 100.00, 51, 'MFZ-4B', 2, '[\"products/01KS89RNN3ZCNJK7AE0PCA89NM.jpg\", \"products/01KV0ADAYKHKFMAY4K28N0ZAQR.jpg\"]', 1, 1, 'MFZ Racing', '{\"Brand\": \"MFZ Racing\", \"Material\": \"CNC-Machined Billet Aluminum Alloy (A7075 Super Duralumin)\", \"Mounting Type\": \"Radial Mount\", \"Piston Configuration\": \"4-Piston Setup\", \"Available Mounting Pitch\": \"100mm / 108mm (Standard Radial Universal)\"}', '2026-05-22 09:54:43', '2026-06-13 04:03:35'),
(8, 'KURADO Premium Front Shock Absorber Assembly (5cm Lower)', 'kurado-premium-front-shock-absorber-assembly-5cm-lower', '<p>Upgrade your ride with the KURADO Premium Front Shock Absorber Assembly. Featuring a striking, high-polished anodized gold inner tube finish paired with durable satin black lowers, these forks deliver a premium sport aesthetic and high-performance dampening control.</p><p>This model is engineered to sit 5 cm lower than the original stock (Zin) height, making it the perfect choice for riders looking to achieve a clean, aggressive, low-down stance while maintaining excellent stability and handling on the road.</p><p>Designed as a direct factory replacement, it comes pre-sealed and ready to install with factory-integrated heavy-duty mounting points for your front brake caliper and fender.</p><p>Key Features:</p><p>- Premium Custom Look: High-polished gold stanchions with satin black sliders.</p><p>- Low-Down Stance: 5 cm lower than OEM (Zin) height for a sporty, custom look.</p><p>- Direct Fitment: Features built-in caliper and fender brackets for a hassle-free install.</p><p>- High-Grade Performance: Advanced internal oil seals prevent leaks and ensure a smooth, stable ride.</p><p>- Authenticity Guaranteed: Includes genuine Kurado holographic seal and scannable verification code on the packaging.</p><p>ដំឡើងស៊េរីម៉ូតូរបស់អ្នកជាមួយបូមមុខអាជីព KURADO Premium Front Shock Absorber Assembly។ ជាមួយការរចនាពណ៌មាសភ្លឺរលោង (Anodized Gold) ផ្នែកខាងលើ និងពណ៌ខ្មៅគ្រើម (Satin Black) ផ្នែកខាងក្រោម ផ្តល់នូវប្រណីតភាព និងភាពទាក់ទាញបំផុត។</p><p>បូមម៉ូដែលនេះត្រូវបានកែច្នៃឲ្យមានកម្ពស់ទាបជាងសំបកស៊ីនហ្ស៊ីន (Zin) 5 cm ដែលជាជម្រើសដ៏ល្អឥតខ្ចោះសម្រាប់អ្នកដែលចូលចិត្តលេងម៉ូតូស្ទីលទាប (Low-down style) ជួយឲ្យម៉ូតូមានលំនឹងល្អ និងរាងស្ព័រស្រស់ស្អាត។</p><p>លក្ខណៈពិសេស៖</p><p>- កម្ពស់ទាបជាងស៊ីនហ្ស៊ីន (Zin) 5 cm ផ្តល់រាងទាប បែបស្ព័រ និងលំនឹងរឹងមាំ</p><p>- ពណ៌មាសលាយខ្មៅស្អាតប្លែក បែប Premium Custom Look</p><p>- មានជើងចាប់ហ្វ្រាំងឌីស និងជើងចាប់កាងកាត់ភក់មកស្រាប់ (Direct OEM Replacement)</p><p>- ក្រវិលប្រេងកម្រិតខ្ពស់ ការពារការលេចជ្រាបប្រេង និងធានាភាពទន់ភ្លន់ពេលបើកបរ</p><p>- ផលិតផលសុទ្ធ 100% មានស្ទីកគ័រហូឡូក្រាម និង QR Code បញ្ជាក់ពីគុណភាពនៅលើប្រអប់</p>', 25.00, 45.00, 40, 'KURADO-5CM', 2, '[\"products/01KS9R2T9WNBPBP7HEDRFYKCY2.jpg\"]', 1, 0, 'KURADO', '{\"Brand\": \"KURADO\", \"Style\": \"Low-down Stance / Sporty Look\", \"height\": \"5cm lower than OEM (ទាបជាងស៊ីន 5 សង់ទីម៉ែត្រ)\", \"Features\": \"Pre-sealed, Includes Caliper & Fender Mounts\", \"Placement\": \"Front (Left & Right Pair)\", \"Installation\": \"Direct OEM Replacement\", \"Product Type\": \"Front Shock Absorber Assembly\", \"Color / Finish\": \"Gold Inner Tubes / Satin Black Lowers\"}', '2026-05-22 23:24:10', '2026-05-22 23:45:08'),
(9, 'HT Racing CNC Aluminum Radiator Guard for Honda Click / Vario 125/150', 'ht-racing-cnc-aluminum-radiator-guard-for-honda-click-vario-125150', '<p>Protect and stylize your bike&#039;s cooling system with the HT Racing CNC Aluminum Radiator Guard. Precision-engineered specifically for Honda Click and Vario 125/150 models, this premium shield protects your delicate radiator fins from road debris, rocks, and damage without restricting airflow.</p><p>Cut from high-grade aluminum with a brilliant silver finish, it features aggressive diagonal slots for a clean, custom racing aesthetic.</p><p>Key Features:</p><p>- Robust Protection: Shields your radiator core from costly stone puncture damage.</p><p>- Premium CNC Build: Light, durable, and rust-resistant billet aluminum.</p><p>- Complete Kit: Comes with the necessary mounting bolts and metal spacers for a quick install.</p><p>- Perfect Fitment: Tailored precisely for Honda Click &amp; Vario 125/150.</p><p>ការពារ និងបង្កើនសម្រស់ប្រព័ន្ធស្អំទឹកម៉ូតូរបស់អ្នកជាមួយ សំណាញ់ការពារធុងទឹក CNC ពីប្រេន HT Racing។ ត្រូវបានរចនាឡើងយ៉ាងច្បាស់លាស់សម្រាប់ម៉ូដែល Honda Click និង Vario ស៊េរី 125/150 ជួយការពារធុងទឹកពីការខ្ទាតដុំថ្ម ឬកម្ទេចកំទីផ្សេងៗ មិនឱ្យខូចខាតសរសៃញែកធុងទឹក ដោយមិនបង្កការស្ទះខ្យល់ឡើយ។</p><p>ផលិតពីអាលុយមីញ៉ូមប្រភេទក្រាស់ (CNC Aluminum) ពណ៌ប្រាក់ភ្លឺរលោង រឹងមាំមិនងាយច្រែះ និងមានរន្ធឆ្នូតស្អាត បែបស្ព័រ ទាក់ទាញ។</p><p>លក្ខណៈពិសេស៖</p><p>- ការពារខ្ពស់៖ ការពារធុងទឹកពីការធ្លាយ ឬវៀចសរសៃញែកដោយសារការខ្ទាតថ្ម</p><p>- គុណភាព Premium CNC៖ ផលិតពីអាលុយមីញ៉ូមម៉ាស៊ីនកាត់ ស្រាល ក្រាស់ និងធន់ខ្លាំង</p><p>- មានគ្រឿងផ្គុំស្រាប់៖ មកជាមួយខ្ចៅ និងតម្រង់ (Spacers) ងាយស្រួលដំឡើងដោយខ្លួនឯង</p><p>- ត្រូវចំស៊េរី៖ សម្រាប់ប្រើប្រាស់ត្រូវចំពោះ Honda Click &amp; Vario 125/150 តែម្តង</p>', 15.00, 18.00, 4, 'HT-RACING', 2, '[\"products/01KS9S7BXM02XCS6KEBJVJY41K.jpg\"]', 1, 1, 'HT Racing', '{\"Brand\": \"HT Racing\", \"Color\": \"Silver / Chrome Finish\", \"Origin\": \"Made in Vietnam (Sản xuất tại Việt Nam)\", \"Material\": \"High-Grade CNC Billet Aluminum\", \"Product Type\": \"Radiator Guard / Cover (សំណាញ់ធុងទឹក)\", \"Compatibility\": \"Honda Click 125i / 150i, Honda Vario 125 / 150\", \"Included Hardware\": \"3x Mounting Bolts & Spacer Sleeves\"}', '2026-05-22 23:44:08', '2026-06-13 03:17:06'),
(10, 'LUR Racing Flame Edition Seat Cover', 'lur-racing-flame-edition-seat-cover', '<blockquote><p>Premium custom-embroidered aftermarket seat cover featuring a vibrant hot-rod flame design and the bold &quot;LUR Racing&quot; emblem. Made with a modern 3D &quot;smoke edition&quot; background pattern and a stylized checkerboard rear finish. Built with high-durability fabric and finished with contrasting red stitched edges for a sleek racing aesthetic. Perfect for Indo-concept underbone scooters (e.g., Honda Vario/Click).</p></blockquote>', 15.00, 18.00, 13, 'LUR-001', 2, '[\"products/01KV0B3ARY4AGER7DFFKFT9WJ5.jpg\", \"products/01KV0B3NAGP1QJ6G61BHM8DQ08.jpg\", \"products/01KV0B3XM0NSFX3Z708TA96EFX.jpg\", \"products/01KV0B44MF93SE885C2G8XGEHT.jpg\"]', 1, 1, 'LUR Racing', '{\"Brand\": \"LUR Racing\", \"Color\": \"Red, Blue, Purple\", \"Fit Type\": \"Universal for underbone scooters\", \"Material\": \"Premium synthetic leather\", \"Waterproof\": \"Yes\", \"Flame Style\": \"Embroidered Neon Fire Graphic\", \"Design Theme\": \"Embroidered hot-rod flames & 3D smoke background\"}', '2026-06-13 04:16:02', '2026-06-13 04:16:02'),
(11, 'Full LED Digital Speedometer & Tachometer Assembly for Honda Vario / Click 125 150', 'full-led-digital-speedometer-tachometer-assembly-for-honda-vario-click-125-150', '<blockquote><p>Upgrade your motorcycle instrument panel with this premium, high-visibility Full LED Digital Speedometer Cluster. Engineered for seamless integration, it provides real-time tracking of speed, engine RPM, mileage, fuel level, and essential dashboard warning indicators. Featuring an anti-glare, multi-colored backlit display, it ensures exceptional readability under bright sunlight or dark night riding conditions.</p></blockquote>', 35.00, 50.00, 7, 'DIGITAL-SP-001', 2, '[\"products/01KV0F86MWDJ74XPPTXDC41XF2.jpg\", \"products/01KV0F8F47R2PM294E3HSMAQ1C.jpg\", \"products/01KV0F8PFQ6WZRWW9K6983F3SA.jpg\"]', 1, 1, 'Honda', '{\"Display Type\": \": Full Multi-Color LED Digital Backlight\", \"Compatible Models\": \"Honda Vario 125 / 150 & Honda Click V2/V3\"}', '2026-06-13 05:28:24', '2026-06-13 05:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `customer_id`, `customer_name`, `customer_email`, `rating`, `comment`, `is_approved`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 7, NULL, 'Vathana', 'yemvathana86@gmail.com', 5, 'good!!!', 1, NULL, '2026-05-22 11:05:57', '2026-05-22 11:05:57'),
(2, 8, NULL, 'Ah Jo ', 'jo123@gmail.com', 5, 'Free តម្លើងអត់?', 1, NULL, '2026-05-22 23:30:34', '2026-05-22 23:31:08'),
(3, 8, NULL, 'Yem Vathana', 'sreymas2016@gmail.com', 4, 'install +2.5$', 1, 2, '2026-05-22 23:47:56', '2026-05-22 23:51:42'),
(4, 8, NULL, 'Admin', 'admin@motohouse.com', 0, 'គិតថ្លៃសេវាផ្សេងបង!!!', 1, 2, '2026-05-22 23:51:09', '2026-05-22 23:51:09'),
(5, 7, NULL, 'Yem Vathana', 'sreymas2016@gmail.com', 5, 'free install?', 1, NULL, '2026-05-22 23:55:46', '2026-05-22 23:55:46'),
(6, 7, NULL, 'Admin', 'admin@motohouse.com', 0, 'yes', 1, 5, '2026-05-22 23:56:16', '2026-05-22 23:56:16'),
(7, 7, NULL, 'Ah Jo ', 'jo123@gmail.com', 0, 'Smooth?', 1, 1, '2026-05-23 00:01:43', '2026-05-23 00:01:43'),
(8, 9, NULL, 'Ah Jo ', 'jo123@gmail.com', 5, 'តម្លើងអោយអត់?', 1, NULL, '2026-05-23 00:10:05', '2026-05-23 00:10:05'),
(10, 9, NULL, 'Yem Vathana', 'sreymas2016@gmail.com', 0, 'គិតសេវាម៉ាន?', 1, 8, '2026-05-23 00:14:08', '2026-05-23 00:14:08'),
(11, 9, NULL, 'Store', 'admin@motohouse.com', 4, 'free bong', 1, 8, '2026-05-23 00:15:21', '2026-05-23 00:17:23'),
(12, 9, NULL, 'Store', 'admin@motohouse.com', 0, 'free install', 1, 8, '2026-05-23 00:18:43', '2026-05-23 00:18:43'),
(13, 4, NULL, 'Ah Jo ', 'jo123@gmail.com', 5, 'good!!!!!!', 1, NULL, '2026-06-26 20:46:38', '2026-06-26 20:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(2, 'manager', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(3, 'staff', 'web', '2026-05-19 19:11:06', '2026-05-19 19:11:06'),
(4, 'Customer', 'web', '2026-05-21 19:05:41', '2026-05-21 19:05:41'),
(5, 'super_admin', 'admin', '2026-06-07 03:02:21', '2026-06-07 03:02:21'),
(6, 'panel_user', 'admin', '2026-06-07 03:02:21', '2026-06-07 03:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(43, 2),
(44, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(59, 3),
(70, 3),
(71, 3),
(82, 3),
(83, 3),
(95, 3),
(142, 3),
(194, 3),
(58, 5),
(59, 5),
(60, 5),
(61, 5),
(62, 5),
(63, 5),
(64, 5),
(65, 5),
(66, 5),
(67, 5),
(68, 5),
(69, 5),
(70, 5),
(71, 5),
(72, 5),
(73, 5),
(74, 5),
(75, 5),
(76, 5),
(77, 5),
(78, 5),
(79, 5),
(80, 5),
(81, 5),
(82, 5),
(83, 5),
(84, 5),
(85, 5),
(86, 5),
(87, 5),
(88, 5),
(89, 5),
(90, 5),
(91, 5),
(92, 5),
(93, 5),
(94, 5),
(95, 5),
(96, 5),
(97, 5),
(98, 5),
(99, 5),
(100, 5),
(101, 5),
(102, 5),
(103, 5),
(104, 5),
(105, 5),
(106, 5),
(107, 5),
(108, 5),
(109, 5),
(110, 5),
(111, 5),
(112, 5),
(113, 5),
(114, 5),
(115, 5),
(116, 5),
(117, 5),
(118, 5),
(119, 5),
(120, 5),
(121, 5),
(122, 5),
(123, 5),
(124, 5),
(125, 5),
(126, 5),
(127, 5),
(128, 5),
(129, 5),
(130, 5),
(131, 5),
(132, 5),
(133, 5),
(134, 5),
(135, 5),
(136, 5),
(137, 5),
(138, 5),
(139, 5),
(140, 5),
(141, 5),
(142, 5),
(143, 5),
(144, 5),
(145, 5),
(146, 5),
(147, 5),
(148, 5),
(149, 5),
(150, 5),
(151, 5),
(152, 5),
(153, 5),
(154, 5),
(155, 5),
(156, 5),
(157, 5),
(158, 5),
(159, 5),
(160, 5),
(161, 5),
(162, 5),
(163, 5),
(164, 5),
(165, 5),
(166, 5),
(167, 5),
(168, 5),
(169, 5),
(170, 5),
(171, 5),
(172, 5),
(173, 5),
(174, 5),
(175, 5),
(176, 5),
(177, 5),
(178, 5),
(179, 5),
(180, 5),
(181, 5),
(182, 5),
(183, 5),
(184, 5),
(185, 5),
(186, 5),
(187, 5),
(188, 5),
(189, 5),
(190, 5),
(191, 5),
(192, 5),
(193, 5),
(194, 5),
(195, 5),
(196, 5),
(197, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cHnsE26IUgMjeXYEr7GSdnNpyEGrKVd99TeWQh4U', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJlYlZ1MWdZaWUzdU84V3BSdng5Qm92QlE1YTJBZmNQY29QbU9TamRWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL21vdG9ob3VzZS5tZTo4MDgwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1782931922),
('D0mWNX7TUtD2JSI9jQ4XQEZy8FdVRfSm7N5PnDDo', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJpT3lOZUt1aFBXaTV2ZUs0dDB6TjlzQ3JGd2VYQzF4UEZuM2pMUVpOIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL21vdG9ob3VzZS5tZVwvY29udGFjdCIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxLCJwYXNzd29yZF9oYXNoX2FkbWluIjoiOTU4N2Y1YmE4MzExNGU0NTA3ZGEyOTU5YzAyZDYzMDAxYjBkN2IwMjZiMzk4MWQ4NGFhZTM5MDM0NzY1ZjM0MyIsImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo0LCJ0YWJsZXMiOnsiOTc4NmI4NmRkZjE5ZDAzZjliOTYzYzVjMzYyZDg0NjdfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJvcmRlcl9udW1iZXIiLCJsYWJlbCI6Ik9yZGVyIG51bWJlciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjdXN0b21lci5uYW1lIiwibGFiZWwiOiJDdXN0b21lciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6IlN0YXR1cyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0b3RhbCIsImxhYmVsIjoiVG90YWwiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiRGF0ZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XSwiY2FkMmM5OGQzMDM3NzNkYTRlZTMzYzU5N2Y4ZGQyNWFfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJOYW1lIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImJyYW5kIiwibGFiZWwiOiJCcmFuZCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdG9ja19xdWFudGl0eSIsImxhYmVsIjoiU3RvY2siLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicHJpY2UiLCJsYWJlbCI6IlByaWNlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dLCJkZGMxZDA4ZWJlZmE2NTIyOTAzYWIxZjM3YzNjYjhhY19jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImltYWdlIiwibGFiZWwiOiJJbWFnZXMiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoibmFtZSIsImxhYmVsIjoiTmFtZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwYXJlbnQubmFtZSIsImxhYmVsIjoiUGFyZW50IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InByb2R1Y3RzX2NvdW50IiwibGFiZWwiOiJQcm9kdWN0cyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19hY3RpdmUiLCJsYWJlbCI6IklzIGFjdGl2ZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImlkIiwibGFiZWwiOiJJRCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9XSwiOWY2ZTcyMzIxMzY3ZTVjYjMzZTg5NDM0ZDVmZDhmMGNfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpbWFnZSIsImxhYmVsIjoiSW1hZ2UiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidGl0bGUiLCJsYWJlbCI6IlRpdGxlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InBvc2l0aW9uIiwibGFiZWwiOiJQb3NpdGlvbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzb3J0X29yZGVyIiwibGFiZWwiOiJPcmRlciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19hY3RpdmUiLCJsYWJlbCI6IklzIGFjdGl2ZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XSwiMzUzMzZhODA4Nzc4ODM0Zjg5NDE3NDcxMTJjMjY0M2VfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJOYW1lIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Imd1YXJkX25hbWUiLCJsYWJlbCI6Ikd1YXJkIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InBlcm1pc3Npb25zX2NvdW50IiwibGFiZWwiOiJQZXJtaXNzaW9ucyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCJlNjQ0ODMzZjRlNGUwODcxMjMxNWRhNzFiMzNmYWNkMl9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im5hbWUiLCJsYWJlbCI6Ik5hbWUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZW1haWwiLCJsYWJlbCI6IkVtYWlsIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InJvbGVzLm5hbWUiLCJsYWJlbCI6IlJvbGVzIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyZWF0ZWQgYXQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sImU2NDQ4MzNmNGU0ZTA4NzEyMzE1ZGE3MWIzM2ZhY2QyX3Blcl9wYWdlIjoiMjUiLCI5NzkyYjZkZTU3MzE1NmVjMDQ1ZWE4MTg4MWJlM2QzZF9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRpdGxlIiwibGFiZWwiOiJUaXRsZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzbHVnIiwibGFiZWwiOiJTbHVnIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImlzX2FjdGl2ZSIsImxhYmVsIjoiSXMgYWN0aXZlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyZWF0ZWQgYXQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sImU3OTNhMjc5ZDU2ZTQ1MDYwOTc1NDAyMGQ2MjdiZWVjX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaWQiLCJsYWJlbCI6Ik9yZGVyIElEIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImN1c3RvbWVyX25hbWUiLCJsYWJlbCI6IkN1c3RvbWVyIG5hbWUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidG90YWwiLCJsYWJlbCI6IlRvdGFsIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InBheW1lbnRfc3RhdHVzIiwibGFiZWwiOiJQYXltZW50IHN0YXR1cyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH1dLCJlNzkzYTI3OWQ1NmU0NTA2MDk3NTQwMjBkNjI3YmVlY19wZXJfcGFnZSI6IjUwIn0sImNhcnRfZW1haWwiOiJqbzEyM0BnbWFpbC5jb20iLCJjdXN0b21lcl9pZCI6NCwiZmlsYW1lbnQiOltdLCJyZWNlbnRseV92aWV3ZWQiOlszLDRdLCJjYXJ0Ijp7IjMiOnsiaWQiOjMsIm5hbWUiOiJHbG92ZXMiLCJwcmljZSI6MC4wMSwiaW1hZ2UiOiJwcm9kdWN0c1wvMDFLUzRCNUVNWDJENFBNMjIxRU41RVhRM1IuanBnIiwicXVhbnRpdHkiOjF9fX0=', 1782541134),
('Udg4GmVuOcE6EDwJw02ntuHBDWfTZAi1jQcFLQFA', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiJIOGJONTlzNnNUUXpPcG5WV1FNZWFkNkd6UjFUZWJLOTJLaVhidHV0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL21vdG9ob3VzZS5tZVwvY2hlY2tvdXQiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwicmVjZW50bHlfdmlld2VkIjpbMl0sImNhcnQiOnsiMiI6eyJpZCI6MiwibmFtZSI6IkxFRCBMaWdodCIsInByaWNlIjoxNSwiaW1hZ2UiOiJwcm9kdWN0c1wvMDFLUzRCNFRYQ0U0VlY1Szc2QkhOMDBWMEEuanBnIiwicXVhbnRpdHkiOjF9fSwibG9jYWxlIjoia20iLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NH0=', 1782537624);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'payment_method', 'khqr', '2026-05-21 22:07:15', '2026-05-21 22:07:15'),
(2, 'aba_merchant_name', 'VATHANA YEM', '2026-05-21 22:07:16', '2026-05-21 22:07:16'),
(3, 'aba_merchant_id', '009536701', '2026-05-21 22:07:16', '2026-05-21 22:07:16'),
(4, 'aba_bakong_id', 'vathana_yem@bkt', '2026-05-21 22:07:16', '2026-05-26 10:39:07'),
(5, 'aba_bank', 'BAKONG Bank', '2026-05-21 22:07:16', '2026-05-26 10:39:57'),
(6, 'currency', 'USD', '2026-05-21 22:07:16', '2026-05-21 22:07:16'),
(7, 'currency_position', 'after', '2026-05-21 22:07:16', '2026-05-21 22:07:16'),
(8, 'site_name', 'Moto House', '2026-05-21 22:24:45', '2026-05-21 22:24:45'),
(9, 'site_description', 'Premium Motorcycle Accessories', '2026-05-21 22:24:45', '2026-05-21 22:24:45'),
(10, 'contact_email', 'yemvathana86@gmail.com', '2026-05-21 22:24:45', '2026-05-21 22:24:45'),
(11, 'contact_phone', '+855 978 537 797', '2026-05-21 22:24:45', '2026-05-21 22:24:45'),
(12, 'address', '10mc', '2026-05-21 22:24:45', '2026-05-21 22:25:05'),
(13, 'tax_rate', '0', '2026-05-21 22:24:45', '2026-05-21 22:24:45'),
(14, 'logo', NULL, '2026-05-21 22:24:45', '2026-05-21 22:24:45'),
(15, 'theme', 'light', '2026-05-21 22:53:30', '2026-05-21 22:57:50'),
(16, 'primary_color', 'Amber', '2026-05-21 22:53:30', '2026-05-21 23:01:54'),
(17, 'background_color', 'Amber', '2026-05-21 22:53:30', '2026-05-22 08:49:44'),
(18, 'sidebar_collapsed', '0', '2026-05-21 22:53:30', '2026-05-22 08:49:45'),
(19, 'mail_driver', 'sendmail', '2026-05-22 09:08:14', '2026-05-22 09:08:14'),
(20, 'mail_from_address', 'yemvathana86@gmail.com', '2026-05-22 09:08:14', '2026-05-22 09:08:14'),
(21, 'mail_from_name', 'Moto House', '2026-05-22 09:08:14', '2026-05-22 09:08:14'),
(22, 'order_confirmation', 'true', '2026-05-22 09:08:14', '2026-05-22 09:08:14'),
(23, 'order_shipped', 'true', '2026-05-22 09:08:14', '2026-05-22 09:08:14'),
(24, 'bakong_merchant_name', 'Moto House', '2026-05-25 20:07:00', '2026-05-25 20:07:00'),
(25, 'bakong_merchant_id', 'vathana_yem@bkrt', '2026-05-25 20:07:00', '2026-05-25 20:07:00'),
(26, 'bakong_bank_name', 'ABA Bank', '2026-05-25 20:07:00', '2026-05-25 20:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@motohouse.com', NULL, '$2y$12$7je0uh3qRFTiuOU/XEBRqee7fcBoO3gQt.FswL6d1uKtyIen5/g2K', 'ViwSdKRpUgPJtoznJFCG9zKOkV0XI53xmdpLq2oWzeIlttakvSRYQz2cmlpF', '2026-05-19 18:53:10', '2026-05-19 20:04:55'),
(2, 'staff_1', 'staff_1@motohouse.com', NULL, '$2y$12$ngncjIKs0lzRTkegmdQ01uJOni5bYQIWsAhx0cIVlFnBAzib9KPRO', NULL, '2026-05-19 19:37:09', '2026-06-24 18:39:41'),
(3, 'Yem Vathana', 'sreymas2016@gmail.com', NULL, '$2y$12$NEiukt7gJzdSYM7WeR.3UuRdU7gNFKqzAtS5rO3U1mhmLFPGqXmS6', 'mMUGuhA5HAb0Q6pP6AF5lN6CYjcTo1D1aEDDDrzY3Yu3cijaMFV7HxzuwLdZ', '2026-05-21 19:04:39', '2026-05-21 19:06:13'),
(4, 'Ah Jo ', 'jo123@gmail.com', NULL, '$2y$12$Dm0u6lqyst7U8gnvCks//ebn4QP2wqLp53EVrP9N0VdlmcxjAaPXS', '5HZkP4MkLJSr5qyViY55SEPz175KTojKAzSFDFU51Y0oVZX4WCac4mfPjwKw', '2026-05-22 19:59:02', '2026-05-25 19:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(6, 1, 7, '2026-05-22 22:56:08', '2026-05-22 22:56:08'),
(7, 4, 4, '2026-05-22 22:56:26', '2026-05-22 22:56:26'),
(8, 4, 7, '2026-05-22 22:57:30', '2026-05-22 22:57:30'),
(9, 4, 5, '2026-05-22 23:02:24', '2026-05-22 23:02:24'),
(11, 4, 10, '2026-06-13 04:20:24', '2026-06-13 04:20:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exports_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_import_rows_import_id_foreign` (`import_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imports_user_id_foreign` (`user_id`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_parent_id_foreign` (`parent_id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_customer_id_product_id_unique` (`customer_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exports`
--
ALTER TABLE `exports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `exports`
--
ALTER TABLE `exports`
  ADD CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
