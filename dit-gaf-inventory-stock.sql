-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2023 at 05:33 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dit-gaf-inventory-stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `name`, `email`, `description`, `date_time`, `created_at`, `updated_at`) VALUES
(131, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Mon, Apr 3, 2023 12:05 AM', NULL, NULL),
(132, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Mon, Apr 3, 2023 12:05 AM', NULL, NULL),
(133, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Mon, Apr 3, 2023 12:17 AM', NULL, NULL),
(134, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Mon, Apr 3, 2023 10:49 AM', NULL, NULL),
(135, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Mon, Apr 3, 2023 11:53 AM', NULL, NULL),
(136, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Mon, Apr 3, 2023 12:35 PM', NULL, NULL),
(137, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Mon, Apr 3, 2023 12:40 PM', NULL, NULL),
(138, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Mon, Apr 3, 2023 12:42 PM', NULL, NULL),
(139, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Mon, Apr 3, 2023 1:47 PM', NULL, NULL),
(140, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Tue, Apr 4, 2023 9:12 AM', NULL, NULL),
(141, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Tue, Apr 4, 2023 9:13 AM', NULL, NULL),
(142, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Tue, Apr 4, 2023 9:16 AM', NULL, NULL),
(143, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Wed, Apr 5, 2023 3:16 AM', NULL, NULL),
(144, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Wed, Apr 5, 2023 5:55 AM', NULL, NULL),
(145, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Wed, Apr 5, 2023 5:56 AM', NULL, NULL),
(146, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Wed, Apr 5, 2023 5:57 AM', NULL, NULL),
(147, 'Superadmin@admin.com', 'Superadmin@admin.com', 'has log in', 'Wed, Apr 5, 2023 11:28 AM', NULL, NULL),
(148, 'Isaac Totimeh', 'Superadmin@admin.com', 'has logged out', 'Wed, Apr 5, 2023 11:30 AM', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audits`
--

INSERT INTO `audits` (`id`, `user_type`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"gender\":null,\"image\":null}', '{\"gender\":\"Male\",\"image\":\"202302181911inventorymanagement.jpg\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.46', NULL, '2023-02-18 19:11:26', '2023-02-18 19:11:26'),
(2, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Supplier', 2, '{\"mobile_no\":\"+233546312171\",\"updated_by\":null}', '{\"mobile_no\":\"+233546312172\",\"updated_by\":1}', 'http://127.0.0.1:8000/Supplier/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.46', NULL, '2023-02-18 23:30:04', '2023-02-18 23:30:04'),
(3, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Supplier', 2, '{\"mobile_no\":\"+233546312172\"}', '{\"mobile_no\":\"+233546312171\"}', 'http://127.0.0.1:8000/Supplier/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.46', NULL, '2023-02-18 23:30:27', '2023-02-18 23:30:27'),
(4, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Category', 1, '{\"id\":1,\"category_name\":\"Computers\",\"created_by\":1,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/Category/category/delete1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.46', NULL, '2023-02-18 23:54:39', '2023-02-18 23:54:39'),
(5, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Supplier', 2, '{\"id\":2,\"supplier_name\":\"Isaac Totimeh\",\"mobile_no\":\"+233546312171\",\"email\":\"isaactotimeh12@gmail.com\",\"address\":\"15 North Close Tesano\",\"created_by\":1,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/Supplier/delete2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.46', NULL, '2023-02-19 00:19:49', '2023-02-19 00:19:49'),
(6, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Product', 2, '{\"id\":2,\"product_name\":\"HP-Pavilion-Laptop\",\"price\":200,\"qty\":50,\"product_image\":\"uploadimage\\/user_images\\/1758313811728064.jpg\",\"category_id\":2,\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Products/delete2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-20 02:05:36', '2023-02-20 02:05:36'),
(7, 'App\\Models\\User', 1, 'created', 'App\\Models\\Purchase_Product', 1, '[]', '{\"product_id\":\"1\",\"supplier_id\":\"3\",\"qty\":\"500\",\"purchase_date\":\"02\\/22\\/2023\",\"created_by\":1,\"id\":1}', 'http://127.0.0.1:8000/NewProductsPurchase/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 01:04:40', '2023-02-22 01:04:40'),
(8, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Product', 1, '{\"qty\":500}', '{\"qty\":1000}', 'http://127.0.0.1:8000/NewProductsPurchase/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 01:04:40', '2023-02-22 01:04:40'),
(9, 'App\\Models\\User', 1, 'created', 'App\\Models\\Purchase_Product', 2, '[]', '{\"product_id\":\"3\",\"supplier_id\":\"Open this select menu\",\"qty\":\"500\",\"purchase_date\":\"02\\/22\\/2023\",\"created_by\":1,\"id\":2}', 'http://127.0.0.1:8000/NewProductsPurchase/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 01:12:23', '2023-02-22 01:12:23'),
(10, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Product', 3, '{\"qty\":50}', '{\"qty\":550}', 'http://127.0.0.1:8000/NewProductsPurchase/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 01:12:23', '2023-02-22 01:12:23'),
(11, 'App\\Models\\User', 1, 'created', 'App\\Models\\Purchase_Product', 3, '[]', '{\"product_id\":\"3\",\"supplier_id\":\"3\",\"qty\":\"400\",\"purchase_date\":\"02\\/22\\/2023\",\"updated_by\":1,\"id\":3}', 'http://127.0.0.1:8000/NewProductsPurchase/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 12:24:04', '2023-02-22 12:24:04'),
(12, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Product', 3, '{\"qty\":550}', '{\"qty\":950}', 'http://127.0.0.1:8000/NewProductsPurchase/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 12:24:04', '2023-02-22 12:24:04'),
(13, 'App\\Models\\User', 1, 'created', 'App\\Models\\Purchase_Product', 4, '[]', '{\"product_id\":\"3\",\"supplier_id\":\"3\",\"qty\":\"100\",\"purchase_date\":\"02\\/22\\/2023\",\"updated_by\":1,\"id\":4}', 'http://127.0.0.1:8000/NewProductsPurchase/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 12:31:07', '2023-02-22 12:31:07'),
(14, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Product', 3, '{\"qty\":950}', '{\"qty\":1050}', 'http://127.0.0.1:8000/NewProductsPurchase/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 12:31:07', '2023-02-22 12:31:07'),
(15, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Purchase_Product', 4, '{\"qty\":\"100\"}', '{\"qty\":\"10\"}', 'http://127.0.0.1:8000/NewProductsPurchase/update4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 12:58:49', '2023-02-22 12:58:49'),
(16, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Product', 3, '{\"qty\":1050}', '{\"qty\":1060}', 'http://127.0.0.1:8000/NewProductsPurchase/update4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 12:58:49', '2023-02-22 12:58:49'),
(17, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Purchase_Product', 3, '{\"qty\":\"400\"}', '{\"qty\":\"4\"}', 'http://127.0.0.1:8000/NewProductsPurchase/update3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 13:00:11', '2023-02-22 13:00:11'),
(18, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Product', 3, '{\"qty\":1060}', '{\"qty\":1064}', 'http://127.0.0.1:8000/NewProductsPurchase/update3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 13:00:11', '2023-02-22 13:00:11'),
(19, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Purchase_Product', 4, '{\"id\":4,\"product_id\":\"3\",\"supplier_id\":\"3\",\"qty\":\"10\",\"purchase_date\":\"02\\/22\\/2023\",\"created_by\":null,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/NewProductsPurchase/delete4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 13:07:32', '2023-02-22 13:07:32'),
(20, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Purchase_Product', 3, '{\"id\":3,\"product_id\":\"3\",\"supplier_id\":\"3\",\"qty\":\"4\",\"purchase_date\":\"02\\/22\\/2023\",\"created_by\":null,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/NewProductsPurchase/delete3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50', NULL, '2023-02-22 13:07:46', '2023-02-22 13:07:46'),
(21, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Category', 3, '{\"id\":3,\"category_name\":\"M-Boot\",\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Category/category/delete3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.56', NULL, '2023-02-26 23:42:17', '2023-02-26 23:42:17'),
(22, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"image\":\"202302181911inventorymanagement.jpg\"}', '{\"image\":\"202302262343202302222319gafimage.jpg\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.56', NULL, '2023-02-26 23:43:20', '2023-02-26 23:43:20'),
(23, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 1, '{\"id\":1,\"product_name\":\"HP-Pavilion-Laptop\",\"serial_no\":\"8CG82525KM\",\"status\":1,\"item_image\":\"uploadimage\\/user_images\\/1758941752827608.jpg\",\"category_id\":4,\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Items/delete1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.56', NULL, '2023-02-27 00:31:51', '2023-02-27 00:31:51'),
(24, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Category', 2, '{\"id\":2,\"category_name\":\"Computers\",\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Category/category/delete2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-02-28 10:40:41', '2023-02-28 10:40:41'),
(25, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Category', 4, '{\"category_name\":\"Laptop\",\"updated_by\":null}', '{\"category_name\":\"Laptops\",\"updated_by\":1}', 'http://127.0.0.1:8000/Category/category/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-02-28 10:40:54', '2023-02-28 10:40:54'),
(26, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Category', 6, '{\"category_name\":\"Table\",\"updated_by\":null}', '{\"category_name\":\"Tables\",\"updated_by\":1}', 'http://127.0.0.1:8000/Category/category/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-03-01 11:48:46', '2023-03-01 11:48:46'),
(27, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"name\":\"Super Admin\"}', '{\"name\":\"SuperAdmin\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-03-01 14:54:01', '2023-03-01 14:54:01'),
(28, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"gender\":\"Male\"}', '{\"gender\":\"Female\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-03-01 15:41:21', '2023-03-01 15:41:21'),
(29, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"gender\":\"Female\"}', '{\"gender\":\"Male\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-03-01 15:41:51', '2023-03-01 15:41:51'),
(30, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 2, '{\"status\":0,\"updated_by\":null}', '{\"status\":\"1\",\"updated_by\":1}', 'http://127.0.0.1:8000/Items/nonupdate', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-03-01 16:30:46', '2023-03-01 16:30:46'),
(31, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 2, '{\"status\":1}', '{\"status\":\"0\"}', 'http://127.0.0.1:8000/Items/nonupdate', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-03-01 16:31:33', '2023-03-01 16:31:33'),
(32, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 2, '{\"status\":1,\"updated_by\":null}', '{\"status\":\"0\",\"updated_by\":1}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.57', NULL, '2023-03-02 09:50:41', '2023-03-02 09:50:41'),
(33, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 3, '{\"id\":3,\"product_name\":\"Dell-Monitor\",\"serial_no\":\"7CR82525BF\",\"status\":1,\"item_image\":\"uploadimage\\/user_images\\/1759071564303669.png\",\"category_id\":5,\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Items/delete3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-07 00:00:22', '2023-03-07 00:00:22'),
(34, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 2, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-07 00:52:18', '2023-03-07 00:52:18'),
(35, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 4, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-07 00:52:46', '2023-03-07 00:52:46'),
(36, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 2, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/unser2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-07 00:56:44', '2023-03-07 00:56:44'),
(37, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 2, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-07 00:56:58', '2023-03-07 00:56:58'),
(38, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 1, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-08 12:56:30', '2023-03-08 12:56:30'),
(39, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 2, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/unser2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-08 12:56:34', '2023-03-08 12:56:34'),
(40, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 2, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-08 12:56:46', '2023-03-08 12:56:46'),
(41, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 1, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/unser1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-08 12:57:48', '2023-03-08 12:57:48'),
(42, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 4, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-08 13:48:20', '2023-03-08 13:48:20'),
(43, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 2, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.63', NULL, '2023-03-08 13:48:34', '2023-03-08 13:48:34'),
(44, 'App\\Models\\User', 1, 'created', 'App\\Models\\User', 2, '[]', '{\"name\":\"Isaac Totimeh\",\"email\":\"isaactotimeh12@gmail.com\",\"password\":\"$2y$10$rVJckYdHR8rOkKkkFRjmaees.TdJTZd0v570LdxL\\/CmsEFYNcdhLu\",\"id\":2}', 'http://127.0.0.1:8000/admin/users', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 11:52:14', '2023-03-13 11:52:14'),
(45, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 2, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 11:54:03', '2023-03-13 11:54:03'),
(46, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 2, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 11:54:27', '2023-03-13 11:54:27'),
(47, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 4, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 12:27:06', '2023-03-13 12:27:06'),
(48, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 4, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 12:29:51', '2023-03-13 12:29:51'),
(49, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 4, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 16:20:56', '2023-03-13 16:20:56'),
(50, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Rank', 2, '{\"updated_by\":null}', '{\"updated_by\":1}', 'http://127.0.0.1:8000/ranks/update2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 18:33:53', '2023-03-13 18:33:53'),
(51, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Personnel', 1, '{\"id\":1,\"rank_name\":\"1\",\"svcnumber\":\"1898\",\"surname\":\"TOTIMEH\",\"othernames\":\"ISAAC\",\"mobile_no\":\"+233546312171\",\"email\":\"isaactotimeh12@gmail.com\",\"gender\":\"MALE\",\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Personnel_details/delete1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-13 23:04:59', '2023-03-13 23:04:59'),
(52, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Personnel', 2, '{\"updated_by\":null}', '{\"updated_by\":1}', 'http://127.0.0.1:8000/Personnel_details/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 05:48:20', '2023-03-14 05:48:20'),
(53, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Personnel', 3, '{\"svcnumber\":\"1898\",\"updated_by\":null}', '{\"svcnumber\":\"1445\",\"updated_by\":1}', 'http://127.0.0.1:8000/Personnel_details/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 05:49:41', '2023-03-14 05:49:41'),
(54, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Category', 8, '{\"id\":8,\"category_name\":\"Mouse\",\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Category/category/delete8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 10:46:59', '2023-03-14 10:46:59'),
(55, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 6, '{\"updated_by\":null}', '{\"updated_by\":1}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:45:30', '2023-03-14 12:45:30'),
(56, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 5, '{\"updated_by\":null}', '{\"updated_by\":1}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:46:59', '2023-03-14 12:46:59'),
(57, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 2, '{\"id\":2,\"product_name\":\"HP-Pavilion-Laptop\",\"serial_no\":\"8CG82525KM\",\"status\":0,\"state\":null,\"item_image\":\"uploadimage\\/user_images\\/1758942174226083.jpg\",\"category_id\":4,\"created_by\":1,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/Items/delete2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:50:33', '2023-03-14 12:50:33'),
(58, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 4, '{\"id\":4,\"product_name\":\"Dell-Monitor\",\"serial_no\":\"756R82525VB\",\"status\":0,\"state\":null,\"item_image\":\"uploadimage\\/user_images\\/1759072044352188.png\",\"category_id\":5,\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Items/delete4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:50:44', '2023-03-14 12:50:44'),
(59, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 5, '{\"id\":5,\"product_name\":\"Dell-Monitor\",\"serial_no\":\"7EC82525CC\",\"status\":1,\"state\":null,\"item_image\":\"uploadimage\\/user_images\\/1760255357267216.jpg\",\"category_id\":5,\"created_by\":1,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/Items/delete5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:50:52', '2023-03-14 12:50:52'),
(60, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 6, '{\"id\":6,\"product_name\":\"NASCO-1.5-HP\",\"serial_no\":\"8AA82525TH\",\"status\":1,\"state\":null,\"item_image\":\"uploadimage\\/user_images\\/1760340577494011.jfif\",\"category_id\":9,\"created_by\":1,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/Items/delete6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:50:58', '2023-03-14 12:50:58'),
(61, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 8, '{\"state\":1,\"updated_by\":null}', '{\"state\":null,\"updated_by\":1}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:55:11', '2023-03-14 12:55:11'),
(62, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 8, '{\"id\":8,\"product_name\":\"Dell-Monitor\",\"serial_no\":\"7CR82525BF\",\"status\":1,\"state\":null,\"item_image\":\"uploadimage\\/user_images\\/1760347751185003.png\",\"category_id\":4,\"created_by\":1,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/Items/delete8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 12:59:06', '2023-03-14 12:59:06'),
(63, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 13:07:17', '2023-03-14 13:07:17'),
(64, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 13:11:36', '2023-03-14 13:11:36'),
(65, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 13:12:32', '2023-03-14 13:12:32'),
(66, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 13:27:16', '2023-03-14 13:27:16'),
(67, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 13:27:51', '2023-03-14 13:27:51'),
(68, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\NonElectronicItem', 2, '{\"id\":2,\"product_name\":\"Office-Chair\",\"body_no\":\"GHA-123-24\",\"status\":0,\"state\":null,\"item_image\":\"nonelectronics\\/user_images\\/1759166869526316.jfif\",\"category_id\":7,\"created_by\":1,\"updated_by\":1}', '[]', 'http://127.0.0.1:8000/Items/nondelete2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 17:05:47', '2023-03-14 17:05:47'),
(69, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\NonElectronicItem', 1, '{\"id\":1,\"product_name\":\"Office-Table\",\"body_no\":\"GHA-123-22\",\"status\":1,\"state\":null,\"item_image\":\"nonelectronics\\/user_images\\/1759166308957201.jfif\",\"category_id\":6,\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Items/nondelete1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 17:05:54', '2023-03-14 17:05:54'),
(70, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 17:50:26', '2023-03-14 17:50:26'),
(71, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/unser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.69', NULL, '2023-03-14 17:50:38', '2023-03-14 17:50:38'),
(72, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":1,\"category_id\":4,\"updated_by\":null}', '{\"state\":null,\"category_id\":\"5\",\"updated_by\":1}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 11:44:36', '2023-03-15 11:44:36'),
(73, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"status\":0,\"state\":1,\"category_id\":4,\"updated_by\":null}', '{\"status\":\"1\",\"state\":null,\"category_id\":\"5\",\"updated_by\":1}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 11:45:28', '2023-03-15 11:45:28'),
(74, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '[]', '[]', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 11:46:00', '2023-03-15 11:46:00'),
(75, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":null}', '{\"state\":\"1\"}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 11:47:56', '2023-03-15 11:47:56'),
(76, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"status\":1,\"state\":null}', '{\"status\":\"0\",\"state\":\"1\"}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 11:48:16', '2023-03-15 11:48:16'),
(77, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":1}', '{\"state\":\"0\"}', 'http://127.0.0.1:8000/Items/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 11:48:29', '2023-03-15 11:48:29'),
(78, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items/eletronicavailability9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 12:44:06', '2023-03-15 12:44:06'),
(79, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 12:44:22', '2023-03-15 12:44:22'),
(80, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 12:44:56', '2023-03-15 12:44:56'),
(81, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items/eletronicavailability7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 12:45:23', '2023-03-15 12:45:23'),
(82, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items/eletronicavailability9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 12:49:50', '2023-03-15 12:49:50'),
(83, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 12:49:57', '2023-03-15 12:49:57'),
(84, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items/generalavailability3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 13:35:47', '2023-03-15 13:35:47'),
(85, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/generalunavailability3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 13:37:09', '2023-03-15 13:37:09'),
(86, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items/generalavailability3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 13:37:18', '2023-03-15 13:37:18'),
(87, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/generalunavailability3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 13:37:25', '2023-03-15 13:37:25'),
(88, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 14:27:34', '2023-03-15 14:27:34'),
(89, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/unser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-15 14:27:50', '2023-03-15 14:27:50'),
(90, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-16 14:12:22', '2023-03-16 14:12:22'),
(91, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items/generalavailability3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-16 14:12:31', '2023-03-16 14:12:31'),
(92, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/unser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-16 14:13:18', '2023-03-16 14:13:18'),
(93, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/generalunavailability3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-16 14:13:23', '2023-03-16 14:13:23'),
(94, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-16 17:27:50', '2023-03-16 17:27:50'),
(95, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"updated_by\":null}', '{\"updated_by\":1}', 'http://127.0.0.1:8000/Items/nonupdate', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-16 21:51:24', '2023-03-16 21:51:24'),
(96, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 10:46:41', '2023-03-17 10:46:41'),
(97, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 10:46:50', '2023-03-17 10:46:50'),
(98, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/approving9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 10:47:19', '2023-03-17 10:47:19'),
(100, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 2, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"status\":\"0\",\"created_by\":1,\"id\":2}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 14:06:55', '2023-03-17 14:06:55'),
(101, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 3, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"status\":\"0\",\"created_by\":1,\"id\":3}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 14:09:53', '2023-03-17 14:09:53'),
(102, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 4, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"status\":\"0\",\"created_by\":1,\"id\":4}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 14:10:09', '2023-03-17 14:10:09'),
(103, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 5, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"status\":\"0\",\"created_by\":1,\"id\":5}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 14:25:28', '2023-03-17 14:25:28'),
(111, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 13, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"756R82525CC\",\"product_name\":\"HP-Mouse\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Mouse\",\"state\":\"0\",\"created_by\":1,\"id\":13}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 20:24:30', '2023-03-17 20:24:30'),
(118, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 12, '{\"id\":12,\"product_name\":\"Dell Printer\",\"serial_no\":\"erewtdfc\",\"status\":1,\"state\":1,\"item_image\":null,\"category_name\":11,\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Items/delete12', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:14:25', '2023-03-17 22:14:25'),
(119, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\Electronic_Gadget', 11, '{\"id\":11,\"product_name\":\"Hp LaserJet 200\",\"serial_no\":\"4trefgfjy\",\"status\":1,\"state\":1,\"item_image\":null,\"category_name\":11,\"created_by\":1,\"updated_by\":null}', '[]', 'http://127.0.0.1:8000/Items/delete11', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:14:30', '2023-03-17 22:14:30'),
(120, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:14:38', '2023-03-17 22:14:38'),
(123, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 22, '[]', '{\"svcnumber\":\"1445\",\"surname\":\"Addy\",\"gender\":\"FEMALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Karean\",\"email\":\"kareanaddy@gmail.com\",\"serial_no\":\"8CG82525KM\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"state\":\"0\",\"created_by\":1,\"id\":22}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:23:06', '2023-03-17 22:23:06'),
(124, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:23:06', '2023-03-17 22:23:06'),
(125, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 23, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"state\":\"2\",\"created_by\":1,\"id\":23}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:24:58', '2023-03-17 22:24:58'),
(126, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:24:58', '2023-03-17 22:24:58'),
(127, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 24, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"8CG82525KM\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"state\":\"0\",\"created_by\":1,\"id\":24}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:47:21', '2023-03-17 22:47:21'),
(128, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 25, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"state\":\"0\",\"created_by\":1,\"id\":25}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:49:31', '2023-03-17 22:49:31'),
(129, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 26, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"state\":\"0\",\"created_by\":1,\"id\":26}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 22:51:15', '2023-03-17 22:51:15'),
(130, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 23:20:56', '2023-03-17 23:20:56'),
(131, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 23:21:01', '2023-03-17 23:21:01'),
(132, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 27, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"state\":\"0\",\"created_by\":1,\"id\":27}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 23:22:09', '2023-03-17 23:22:09'),
(133, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.41', NULL, '2023-03-17 23:22:09', '2023-03-17 23:22:09');
INSERT INTO `audits` (`id`, `user_type`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(134, 'App\\Models\\User', 1, 'created', 'App\\Models\\GeneralItemIssuing', 1, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"body_no\":\"GHA-123-33\",\"product_name\":\"Office-Table\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Tables\",\"status\":\"2\",\"created_by\":1,\"id\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/generaliussing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 01:25:19', '2023-03-21 01:25:19'),
(135, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/generaliussing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 01:25:19', '2023-03-21 01:25:19'),
(136, 'App\\Models\\User', 1, 'created', 'App\\Models\\GeneralItemIssuing', 2, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"body_no\":\"GHA-123-33\",\"product_name\":\"Office-Table\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Tables\",\"status\":\"0\",\"created_by\":1,\"id\":2}', 'http://127.0.0.1:8000/Items_Issuing_out/generaliussing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 01:26:03', '2023-03-21 01:26:03'),
(137, 'App\\Models\\User', 1, 'created', 'App\\Models\\GeneralItemIssuing', 3, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"body_no\":\"GHA-123-33\",\"product_name\":\"Office-Table\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Tables\",\"status\":\"2\",\"created_by\":1,\"id\":3}', 'http://127.0.0.1:8000/Items_Issuing_out/generaliussing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 01:30:01', '2023-03-21 01:30:01'),
(138, 'App\\Models\\User', 1, 'created', 'App\\Models\\GeneralItemIssuing', 4, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"body_no\":\"GHA-123-33\",\"product_name\":\"Office-Table\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Tables\",\"status\":\"0\",\"created_by\":1,\"id\":4}', 'http://127.0.0.1:8000/Items_Issuing_out/generaliussing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 01:31:25', '2023-03-21 01:31:25'),
(139, 'App\\Models\\User', 1, 'created', 'App\\Models\\GeneralItemIssuing', 5, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"body_no\":\"GHA-123-33\",\"product_name\":\"Office-Table\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Tables\",\"status\":\"2\",\"created_by\":1,\"id\":5}', 'http://127.0.0.1:8000/Items_Issuing_out/generaliussing', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 01:43:49', '2023-03-21 01:43:49'),
(140, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 27, '{\"state\":\"0\"}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicloaned27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 10:26:18', '2023-03-21 10:26:18'),
(141, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 27, '{\"state\":\"1\"}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicretun27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 10:26:46', '2023-03-21 10:26:46'),
(142, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 27, '{\"state\":\"0\"}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicloaned27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 10:31:53', '2023-03-21 10:31:53'),
(143, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 27, '{\"state\":\"1\"}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicretun27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 10:32:02', '2023-03-21 10:32:02'),
(144, 'App\\Models\\User', 1, 'updated', 'App\\Models\\GeneralItemIssuing', 1, '{\"status\":\"0\"}', '{\"status\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/generalloan1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 10:36:29', '2023-03-21 10:36:29'),
(145, 'App\\Models\\User', 1, 'updated', 'App\\Models\\GeneralItemIssuing', 1, '{\"status\":\"1\"}', '{\"status\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/generalretuned1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-21 10:36:40', '2023-03-21 10:36:40'),
(146, 'App\\Models\\User', 1, 'updated', 'App\\Models\\GeneralItemIssuing', 1, '{\"status\":\"0\"}', '{\"status\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/generalloan1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-22 22:15:15', '2023-03-22 22:15:15'),
(147, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Category', 9, '{\"category_name\":\"Air Condition\",\"updated_by\":null}', '{\"category_name\":\"Air_Condition\",\"updated_by\":1}', 'http://127.0.0.1:8000/Category/update', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-23 19:16:17', '2023-03-23 19:16:17'),
(148, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/generalunavailability3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.44', NULL, '2023-03-23 21:09:52', '2023-03-23 21:09:52'),
(149, 'App\\Models\\User', 1, 'created', 'App\\Models\\User', 3, '[]', '{\"name\":\"Isaac Totimeh\",\"email\":\"isaactotimeh@gmail.com\",\"password\":\"$2y$10$65VN3rvans5XCc7PENBpvO5cH9i1rBfqkey\\/5LFbUhvqnhGvz.mSS\",\"id\":3}', 'http://127.0.0.1:8000/admin/users', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.51', NULL, '2023-03-24 12:51:25', '2023-03-24 12:51:25'),
(150, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 28, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"MALE\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"email\":\"appenock@gmail.com\",\"serial_no\":\"8CG82525KM\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"state\":\"0\",\"created_by\":1,\"id\":28}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.51', NULL, '2023-03-24 13:01:22', '2023-03-24 13:01:22'),
(151, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.51', NULL, '2023-03-24 13:01:22', '2023-03-24 13:01:22'),
(152, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 27, '{\"state\":\"0\"}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicloaned27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.51', NULL, '2023-03-24 13:04:27', '2023-03-24 13:04:27'),
(153, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 28, '{\"state\":\"0\"}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicloaned28', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.51', NULL, '2023-03-24 13:13:41', '2023-03-24 13:13:41'),
(154, 'App\\Models\\User', 1, 'deleted', 'App\\Models\\User', 3, '{\"id\":3,\"name\":\"Isaac Totimeh\",\"email\":\"isaactotimeh@gmail.com\",\"gender\":null,\"image\":null,\"email_verified_at\":null,\"password\":\"$2y$10$65VN3rvans5XCc7PENBpvO5cH9i1rBfqkey\\/5LFbUhvqnhGvz.mSS\",\"two_factor_secret\":null,\"two_factor_recovery_codes\":null,\"two_factor_confirmed_at\":null,\"remember_token\":null,\"current_team_id\":null,\"profile_photo_path\":null}', '[]', 'http://127.0.0.1:8000/admin/users/3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 13:06:48', '2023-03-28 13:06:48'),
(155, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"name\":\"SuperAdmin\"}', '{\"name\":\"Enock Appianing\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 16:32:31', '2023-03-28 16:32:31'),
(156, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 27, '{\"state\":\"1\"}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicretun27', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 17:26:10', '2023-03-28 17:26:10'),
(157, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 29, '[]', '{\"svcnumber\":\"1556\",\"surname\":\"BOAKYE\",\"gender\":\"Male\",\"mobile\":\"+233546312171\",\"rank_name\":\"Captain\",\"othernames\":\"PRINCE\",\"email\":\"poboakye@gmail.com\",\"serial_no\":\"756R82525CC\",\"product_name\":\"HP-Mouse\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Mouse\",\"issued_date\":\"03\\/28\\/2023\",\"user_issuer\":\"1\",\"state\":\"0\",\"created_by\":1,\"id\":29}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 18:48:40', '2023-03-28 18:48:40'),
(158, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 10, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 18:48:40', '2023-03-28 18:48:40'),
(159, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"name\":\"Enock Appianing\"}', '{\"name\":\"Kenneth Tagoe\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 18:52:09', '2023-03-28 18:52:09'),
(160, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 19:07:57', '2023-03-28 19:07:57'),
(161, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items/eletronicunavailability7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 19:08:02', '2023-03-28 19:08:02'),
(163, 'App\\Models\\User', 1, 'created', 'App\\Models\\RetElectronicItem', 2, '[]', '{\"svcnumber\":\"1455\",\"surname\":\"Boakye\",\"gender\":\"Male\",\"mobile\":\"0244805650\",\"rank_name\":\"Captain\",\"othernames\":\"Prince\",\"serial_no\":\"756R82525CC\",\"product_name\":\"HP-Mouse\",\"item_location\":null,\"category_name\":\"Mouse\",\"receive_date\":null,\"state\":\"1\",\"created_by\":1,\"id\":2}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:34:43', '2023-03-28 22:34:43'),
(164, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 29, '{\"state\":\"0\"}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:34:43', '2023-03-28 22:34:43'),
(165, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 10, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:34:43', '2023-03-28 22:34:43'),
(166, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 10, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items/eletronicavailability10', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:46:00', '2023-03-28 22:46:00'),
(167, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 29, '{\"state\":\"1\"}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicretun29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:46:14', '2023-03-28 22:46:14'),
(168, 'App\\Models\\User', 1, 'created', 'App\\Models\\RetElectronicItem', 3, '[]', '{\"svcnumber\":\"1445\",\"surname\":\"BOAKYE\",\"gender\":\"Male\",\"mobile\":\"0244145151\",\"rank_name\":\"Captain\",\"othernames\":\"PRINCE\",\"serial_no\":\"756R82525CC\",\"product_name\":\"HP-Mouse\",\"item_location\":null,\"category_name\":\"Mouse\",\"receive_date\":\"03\\/28\\/2023\",\"state\":\"1\",\"created_by\":1,\"id\":3}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:48:15', '2023-03-28 22:48:15'),
(169, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 29, '{\"state\":\"0\"}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:48:15', '2023-03-28 22:48:15'),
(170, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 10, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 22:48:15', '2023-03-28 22:48:15'),
(171, 'App\\Models\\User', 1, 'updated', 'App\\Models\\inventoryrecord', 29, '{\"state\":\"1\"}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/eletronicretun29', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-03-28 23:07:11', '2023-03-28 23:07:11'),
(172, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"name\":\"Kenneth Tagoe\"}', '{\"name\":\"Isaac Totimeh\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 00:05:11', '2023-04-03 00:05:11'),
(173, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 30, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"Male\",\"mobile\":\"0244805650\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"issued_date\":\"04\\/03\\/2023\",\"state\":\"0\",\"created_by\":1,\"id\":30}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 11:00:38', '2023-04-03 11:00:38'),
(174, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 11:00:38', '2023-04-03 11:00:38'),
(175, 'App\\Models\\User', 1, 'created', 'App\\Models\\RetElectronicItem', 4, '[]', '{\"svcnumber\":\"1898\",\"surname\":\"Appianing\",\"gender\":\"Male\",\"mobile\":\"+233546312171\",\"rank_name\":\"Lieutenant\",\"othernames\":\"Enock\",\"serial_no\":\"7CR82525BF\",\"product_name\":\"Dell-Monitor\",\"item_location\":null,\"category_name\":\"Monitors\",\"receive_date\":\"04\\/03\\/2023\",\"state\":\"1\",\"created_by\":1,\"id\":4}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 11:02:21', '2023-04-03 11:02:21'),
(176, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"state\":0}', '{\"state\":1}', 'http://127.0.0.1:8000/Items_Issuing_out/itemreceivestore', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 11:02:21', '2023-04-03 11:02:21'),
(177, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 9, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/electronicser9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 11:03:11', '2023-04-03 11:03:11'),
(178, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 31, '[]', '{\"svcnumber\":\"1445\",\"surname\":\"Appianing\",\"gender\":\"Male\",\"mobile\":\"0244805650\",\"rank_name\":\"Captain\",\"othernames\":\"Enock\",\"serial_no\":\"8CG82525KM\",\"product_name\":\"Dell-Monitor\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Monitors\",\"issued_date\":\"04\\/03\\/2023\",\"state\":\"0\",\"created_by\":1,\"id\":31}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 12:54:45', '2023-04-03 12:54:45'),
(179, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 7, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 12:54:45', '2023-04-03 12:54:45'),
(180, 'App\\Models\\User', 1, 'created', 'App\\Models\\inventoryrecord', 32, '[]', '{\"svcnumber\":\"199340\",\"surname\":\"Appianing\",\"gender\":\"Male\",\"mobile\":\"0244805650\",\"rank_name\":\"Captain\",\"othernames\":\"PRINCE\",\"serial_no\":\"756R82525CC\",\"product_name\":\"HP-Mouse\",\"item_location\":\"Networking-Admin-Office\",\"category_name\":\"Mouse\",\"issued_date\":\"04\\/03\\/2023\",\"state\":\"0\",\"created_by\":1,\"id\":32}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 12:58:12', '2023-04-03 12:58:12'),
(181, 'App\\Models\\User', 1, 'updated', 'App\\Models\\Electronic_Gadget', 10, '{\"state\":1}', '{\"state\":0}', 'http://127.0.0.1:8000/Items_Issuing_out/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.54', NULL, '2023-04-03 12:58:12', '2023-04-03 12:58:12'),
(182, 'App\\Models\\User', 1, 'updated', 'App\\Models\\User', 1, '{\"image\":\"202302262343202302222319gafimage.jpg\"}', '{\"image\":\"202304040918GAF ghq colors circular wide.png\"}', 'http://127.0.0.1:8000/Profile/store', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.62', NULL, '2023-04-04 09:18:03', '2023-04-04 09:18:03'),
(183, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"body_no\":\"GHA-123-33\"}', '{\"body_no\":\"GHQ-123-33\"}', 'http://127.0.0.1:8000/Items/nonupdate', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.62', NULL, '2023-04-05 05:26:10', '2023-04-05 05:26:10'),
(184, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.62', NULL, '2023-04-05 05:38:12', '2023-04-05 05:38:12'),
(185, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":0}', '{\"status\":1}', 'http://127.0.0.1:8000/Items/unser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.62', NULL, '2023-04-05 05:39:13', '2023-04-05 05:39:13'),
(186, 'App\\Models\\User', 1, 'updated', 'App\\Models\\NonElectronicItem', 3, '{\"status\":1}', '{\"status\":0}', 'http://127.0.0.1:8000/Items/ser3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.62', NULL, '2023-04-05 05:39:20', '2023-04-05 05:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Laptops', 1, 1, '2023-02-26 23:42:10', '2023-02-28 10:40:54'),
(5, 'Monitors', 1, NULL, '2023-02-28 10:41:46', NULL),
(6, 'Tables', 1, 1, '2023-03-01 11:48:38', '2023-03-01 11:48:46'),
(7, 'Chairs', 1, NULL, '2023-03-01 12:03:36', NULL),
(9, 'Air_Condition', 1, 1, '2023-03-14 10:48:05', '2023-03-23 19:16:16'),
(10, 'Mouse', 1, NULL, '2023-03-17 11:00:06', NULL),
(11, 'Printer', 1, NULL, '2023-03-17 14:40:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `electronic__gadgets`
--

CREATE TABLE `electronic__gadgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Serviceable=1,Unserviceable=0',
  `state` tinyint(11) DEFAULT NULL COMMENT 'available=1,unavailable=0',
  `item_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `electronic__gadgets`
--

INSERT INTO `electronic__gadgets` (`id`, `product_name`, `serial_no`, `status`, `state`, `item_image`, `category_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 'Dell-Monitor', '8CG82525KM', 1, 0, 'uploadimage/user_images/1760347673983705.png', 5, 1, 1, '2023-03-14 12:52:45', '2023-04-03 12:54:45'),
(9, 'Dell-Monitor', '7CR82525BF', 1, 1, 'uploadimage/user_images/1760348134854805.png', 5, 1, 1, '2023-03-14 13:00:04', '2023-04-03 11:03:11'),
(10, 'HP-Mouse', '756R82525CC', 1, 0, NULL, 10, 1, NULL, '2023-03-17 11:15:38', '2023-04-03 12:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_item_issuings`
--

CREATE TABLE `general_item_issuings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `svcnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othernames` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Loaned=0,Keep=2,Retuned=1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_item_issuings`
--

INSERT INTO `general_item_issuings` (`id`, `rank_name`, `svcnumber`, `surname`, `gender`, `mobile`, `othernames`, `email`, `product_name`, `category_name`, `item_location`, `body_no`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Lieutenant', '1898', 'Appianing', 'MALE', '+233546312171', 'Enock', 'appenock@gmail.com', 'Office-Table', 'Tables', 'Networking-Admin-Office', 'GHA-123-33', '1', 1, NULL, '2023-03-21 01:25:19', '2023-03-22 22:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `inventoryrecords`
--

CREATE TABLE `inventoryrecords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `svcnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othernames` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Loaned=0,Returned=1,Keep=2',
  `issued_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventoryrecords`
--

INSERT INTO `inventoryrecords` (`id`, `rank_name`, `svcnumber`, `surname`, `gender`, `mobile`, `othernames`, `product_name`, `category_name`, `item_location`, `serial_no`, `state`, `issued_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(31, 'Captain', '1445', 'Appianing', 'Male', '0244805650', 'Enock', 'Dell-Monitor', 'Monitors', 'Networking-Admin-Office', '8CG82525KM', '0', '04/03/2023', 1, NULL, '2023-04-03 12:54:45', '2023-04-03 12:54:45'),
(32, 'Captain', '199340', 'Appianing', 'Male', '0244805650', 'PRINCE', 'HP-Mouse', 'Mouse', 'Networking-Admin-Office', '756R82525CC', '0', '04/03/2023', 1, NULL, '2023-04-03 12:58:12', '2023-04-03 12:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_01_30_214405_create_sessions_table', 1),
(7, '2023_01_31_122637_create_activity_logs_table', 1),
(8, '2023_01_31_124159_create_permission_tables', 1),
(9, '2023_01_31_200223_create_audits_table', 1),
(10, '2023_02_18_201344_create_categories_table', 2),
(11, '2023_02_18_221302_create_suppliers_table', 3),
(12, '2023_02_19_005035_create_products_table', 4),
(13, '2023_02_21_115104_create_purchase__products_table', 5),
(14, '2023_02_26_134741_create_electronic__gadgets_table', 6),
(15, '2023_02_28_133012_create_non-_electronic-_items_table', 7),
(16, '2023_02_28_133915_create_non_electronic_items_table', 8),
(17, '2023_03_13_174715_create_ranks_table', 9),
(18, '2023_03_13_180339_create_personnels_table', 9),
(19, '2023_03_14_055619_create_inventoryrecords_table', 10),
(20, '2023_03_16_220809_create_general_item_issuings_table', 11),
(21, '2023_03_28_182930_create_ret_electronic_items_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `non_electronic_items`
--

CREATE TABLE `non_electronic_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `item_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `non_electronic_items`
--

INSERT INTO `non_electronic_items` (`id`, `product_name`, `body_no`, `status`, `item_location`, `item_image`, `category_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'Office-Table', 'GHQ-123-33', 0, 'Programmer\'s main office', NULL, 6, 1, 1, '2023-03-14 17:05:17', '2023-04-05 05:39:20'),
(4, 'Office-Chair', 'GHQ-123-254', 1, 'Networking-Admin-Office', NULL, 7, 1, NULL, '2023-04-05 05:25:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'dashboard', 'web', '2023-02-18 10:37:04', '2023-02-18 10:37:04'),
(2, 'dashboard.edit', 'dashboard', 'web', '2023-02-18 10:37:05', '2023-02-18 10:37:05'),
(3, 'superadmin.create', 'superadmin', 'web', '2023-02-18 10:37:05', '2023-02-18 10:37:05'),
(4, 'superadmin.view', 'superadmin', 'web', '2023-02-18 10:37:05', '2023-02-18 10:37:05'),
(5, 'superadmin.edit', 'superadmin', 'web', '2023-02-18 10:37:05', '2023-02-18 10:37:05'),
(6, 'superadmin.delete', 'superadmin', 'web', '2023-02-18 10:37:05', '2023-02-18 10:37:05'),
(7, 'superadmin.approve', 'superadmin', 'web', '2023-02-18 10:37:05', '2023-02-18 10:37:05'),
(8, 'admin.create', 'admin', 'web', '2023-02-18 10:37:05', '2023-02-18 10:37:05'),
(9, 'admin.view', 'admin', 'web', '2023-02-18 10:37:06', '2023-02-18 10:37:06'),
(10, 'admin.edit', 'admin', 'web', '2023-02-18 10:37:06', '2023-02-18 10:37:06'),
(11, 'admin.delete', 'admin', 'web', '2023-02-18 10:37:06', '2023-02-18 10:37:06'),
(12, 'admin.approve', 'admin', 'web', '2023-02-18 10:37:06', '2023-02-18 10:37:06'),
(13, 'role.create', 'role', 'web', '2023-02-18 10:37:06', '2023-02-18 10:37:06'),
(14, 'role.view', 'role', 'web', '2023-02-18 10:37:06', '2023-02-18 10:37:06'),
(15, 'role.edit', 'role', 'web', '2023-02-18 10:37:06', '2023-02-18 10:37:06'),
(16, 'role.delete', 'role', 'web', '2023-02-18 10:37:07', '2023-02-18 10:37:07'),
(17, 'role.approve', 'role', 'web', '2023-02-18 10:37:07', '2023-02-18 10:37:07'),
(18, 'profile.view', 'profile', 'web', '2023-02-18 10:37:07', '2023-02-18 10:37:07'),
(19, 'profile.edit', 'profile', 'web', '2023-02-18 10:37:07', '2023-02-18 10:37:07');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnels`
--

CREATE TABLE `personnels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `svcnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othernames` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personnels`
--

INSERT INTO `personnels` (`id`, `rank_name`, `svcnumber`, `surname`, `othernames`, `mobile_no`, `email`, `gender`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, '3', '1898', 'Appianing', 'Enock', '+233546312171', 'appenock@gmail.com', 'MALE', 1, 1, '2023-03-14 05:48:20', '2023-03-14 05:48:20'),
(3, '3', '1445', 'Addy', 'Karean', '+233546312171', 'kareanaddy@gmail.com', 'FEMALE', 1, 1, '2023-03-14 05:49:41', '2023-03-14 05:49:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) NOT NULL,
  `qty` double DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `qty`, `product_image`, `category_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Boot', 150, 1000, 'uploadimage/user_images/1758310652455400.jfif', 3, 1, NULL, '2023-02-20 01:15:09', '2023-02-22 01:04:40'),
(3, 'HP-Pavilion-Laptop', 200, 1064, 'uploadimage/user_images/1758313861709849.jpg', 2, 1, NULL, '2023-02-20 02:06:10', '2023-02-22 13:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `purchase__products`
--

CREATE TABLE `purchase__products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase__products`
--

INSERT INTO `purchase__products` (`id`, `product_id`, `supplier_id`, `qty`, `purchase_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1', '3', '500', '02/22/2023', 1, NULL, '2023-02-22 01:04:40', '2023-02-22 01:04:40'),
(2, '3', ' 3', '500', '02/22/2023', 1, NULL, '2023-02-22 01:12:23', '2023-02-22 01:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `rank_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2ndLieutenant', 1, NULL, '2023-03-13 18:31:40', NULL),
(2, 'Staff-Sergeant', 1, 1, '2023-03-13 18:31:58', '2023-03-13 18:33:52'),
(3, 'Lieutenant', 1, NULL, '2023-03-13 23:05:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ret_electronic_items`
--

CREATE TABLE `ret_electronic_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `svcnumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `othernames` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Returned=1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2023-02-18 10:37:04', '2023-02-18 10:37:04'),
(2, 'admin', 'web', '2023-02-18 10:37:04', '2023-02-18 10:37:04'),
(3, 'user', 'web', '2023-02-18 10:37:04', '2023-02-18 10:37:04'),
(4, 'CO', 'web', '2023-03-14 10:38:59', '2023-03-14 10:38:59'),
(5, 'MC', 'web', '2023-03-24 13:34:09', '2023-03-24 13:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 4),
(1, 5),
(2, 1),
(2, 4),
(2, 5),
(3, 1),
(3, 4),
(3, 5),
(4, 1),
(4, 4),
(4, 5),
(5, 1),
(5, 4),
(5, 5),
(6, 1),
(6, 4),
(6, 5),
(7, 1),
(7, 4),
(7, 5),
(8, 1),
(8, 4),
(8, 5),
(9, 1),
(9, 4),
(9, 5),
(10, 1),
(10, 4),
(10, 5),
(11, 1),
(11, 4),
(11, 5),
(12, 1),
(12, 4),
(12, 5),
(13, 1),
(13, 4),
(13, 5),
(14, 1),
(14, 4),
(14, 5),
(15, 1),
(15, 4),
(15, 5),
(16, 1),
(16, 4),
(16, 5),
(17, 1),
(17, 4),
(17, 5),
(18, 1),
(18, 4),
(18, 5),
(19, 1),
(19, 4),
(19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('SFUV2Ted5nxKHKzDpl4AKtWph9YGToDepDNs9pYV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.62', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieENyYWZKdUFsSmllVHFKSThiZEZKTmFYM3BaOFZpbEluQmJaTWNORSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJHh5T3RTNUNCRlpHM3pUNzBPYkoxTXVBaDJPVEkxelVvNEpUYmpUd0NTQ1V0LkVqUEFmak5LIjtzOjQ6InVzZXIiO086MTU6IkFwcFxNb2RlbHNcVXNlciI6Mzc6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6NToidXNlcnMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxNTp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czoxMzoiSXNhYWMgVG90aW1laCI7czo1OiJlbWFpbCI7czoyMDoiU3VwZXJhZG1pbkBhZG1pbi5jb20iO3M6NjoiZ2VuZGVyIjtzOjQ6Ik1hbGUiO3M6NToiaW1hZ2UiO3M6NDQ6IjIwMjMwNDA0MDkxOEdBRiBnaHEgY29sb3JzIGNpcmN1bGFyIHdpZGUucG5nIjtzOjE3OiJlbWFpbF92ZXJpZmllZF9hdCI7TjtzOjg6InBhc3N3b3JkIjtzOjYwOiIkMnkkMTAkeHlPdFM1Q0JGWkczelQ3ME9iSjFNdUFoMk9USTF6VW80SlRialR3Q1NDVXQuRWpQQWZqTksiO3M6MTc6InR3b19mYWN0b3Jfc2VjcmV0IjtOO3M6MjU6InR3b19mYWN0b3JfcmVjb3ZlcnlfY29kZXMiO047czoyMzoidHdvX2ZhY3Rvcl9jb25maXJtZWRfYXQiO047czoxNDoicmVtZW1iZXJfdG9rZW4iO047czoxNToiY3VycmVudF90ZWFtX2lkIjtOO3M6MTg6InByb2ZpbGVfcGhvdG9fcGF0aCI7TjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIzLTAyLTE4IDEwOjM3OjA0IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIzLTA0LTA0IDA5OjE4OjAzIjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTU6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6MTM6IklzYWFjIFRvdGltZWgiO3M6NToiZW1haWwiO3M6MjA6IlN1cGVyYWRtaW5AYWRtaW4uY29tIjtzOjY6ImdlbmRlciI7czo0OiJNYWxlIjtzOjU6ImltYWdlIjtzOjQ0OiIyMDIzMDQwNDA5MThHQUYgZ2hxIGNvbG9ycyBjaXJjdWxhciB3aWRlLnBuZyI7czoxNzoiZW1haWxfdmVyaWZpZWRfYXQiO047czo4OiJwYXNzd29yZCI7czo2MDoiJDJ5JDEwJHh5T3RTNUNCRlpHM3pUNzBPYkoxTXVBaDJPVEkxelVvNEpUYmpUd0NTQ1V0LkVqUEFmak5LIjtzOjE3OiJ0d29fZmFjdG9yX3NlY3JldCI7TjtzOjI1OiJ0d29fZmFjdG9yX3JlY292ZXJ5X2NvZGVzIjtOO3M6MjM6InR3b19mYWN0b3JfY29uZmlybWVkX2F0IjtOO3M6MTQ6InJlbWVtYmVyX3Rva2VuIjtOO3M6MTU6ImN1cnJlbnRfdGVhbV9pZCI7TjtzOjE4OiJwcm9maWxlX3Bob3RvX3BhdGgiO047czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMy0wMi0xOCAxMDozNzowNCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMy0wNC0wNCAwOToxODowMyI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MTp7czoxNzoiZW1haWxfdmVyaWZpZWRfYXQiO3M6ODoiZGF0ZXRpbWUiO31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjg6IgAqAGRhdGVzIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MTp7aTowO3M6MTc6InByb2ZpbGVfcGhvdG9fdXJsIjt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YTowOnt9czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoxMDoidGltZXN0YW1wcyI7YjoxO3M6OToiACoAaGlkZGVuIjthOjQ6e2k6MDtzOjg6InBhc3N3b3JkIjtpOjE7czoxNDoicmVtZW1iZXJfdG9rZW4iO2k6MjtzOjI1OiJ0d29fZmFjdG9yX3JlY292ZXJ5X2NvZGVzIjtpOjM7czoxNzoidHdvX2ZhY3Rvcl9zZWNyZXQiO31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTozOntpOjA7czo0OiJuYW1lIjtpOjE7czo1OiJlbWFpbCI7aToyO3M6ODoicGFzc3dvcmQiO31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjE6IioiO31zOjIwOiIAKgByZW1lbWJlclRva2VuTmFtZSI7czoxNDoicmVtZW1iZXJfdG9rZW4iO3M6MTQ6IgAqAGFjY2Vzc1Rva2VuIjtOO3M6MjE6IgAqAGV4Y2x1ZGVkQXR0cmlidXRlcyI7YTowOnt9czoxMDoiYXVkaXRFdmVudCI7TjtzOjE0OiJhdWRpdEN1c3RvbU9sZCI7TjtzOjE0OiJhdWRpdEN1c3RvbU5ldyI7TjtzOjEzOiJpc0N1c3RvbUV2ZW50IjtiOjA7fX0=', 1680694210),
('xRoXAfkdJS1a4GaVNbSqqOD9zC3Z4Hm1SvlRTzKw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36 Edg/111.0.1661.62', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV1l1cDJjZGc2R3JqSGxUT3h6eUlPMlJkRGgyQ0xCcWRIbzZQTE92eCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJHh5T3RTNUNCRlpHM3pUNzBPYkoxTXVBaDJPVEkxelVvNEpUYmpUd0NTQ1V0LkVqUEFmak5LIjtzOjQ6InVzZXIiO086MTU6IkFwcFxNb2RlbHNcVXNlciI6Mzc6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6NToidXNlcnMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxNTp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czoxMzoiSXNhYWMgVG90aW1laCI7czo1OiJlbWFpbCI7czoyMDoiU3VwZXJhZG1pbkBhZG1pbi5jb20iO3M6NjoiZ2VuZGVyIjtzOjQ6Ik1hbGUiO3M6NToiaW1hZ2UiO3M6NDQ6IjIwMjMwNDA0MDkxOEdBRiBnaHEgY29sb3JzIGNpcmN1bGFyIHdpZGUucG5nIjtzOjE3OiJlbWFpbF92ZXJpZmllZF9hdCI7TjtzOjg6InBhc3N3b3JkIjtzOjYwOiIkMnkkMTAkeHlPdFM1Q0JGWkczelQ3ME9iSjFNdUFoMk9USTF6VW80SlRialR3Q1NDVXQuRWpQQWZqTksiO3M6MTc6InR3b19mYWN0b3Jfc2VjcmV0IjtOO3M6MjU6InR3b19mYWN0b3JfcmVjb3ZlcnlfY29kZXMiO047czoyMzoidHdvX2ZhY3Rvcl9jb25maXJtZWRfYXQiO047czoxNDoicmVtZW1iZXJfdG9rZW4iO047czoxNToiY3VycmVudF90ZWFtX2lkIjtOO3M6MTg6InByb2ZpbGVfcGhvdG9fcGF0aCI7TjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDIzLTAyLTE4IDEwOjM3OjA0IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDIzLTA0LTA0IDA5OjE4OjAzIjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTU6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6MTM6IklzYWFjIFRvdGltZWgiO3M6NToiZW1haWwiO3M6MjA6IlN1cGVyYWRtaW5AYWRtaW4uY29tIjtzOjY6ImdlbmRlciI7czo0OiJNYWxlIjtzOjU6ImltYWdlIjtzOjQ0OiIyMDIzMDQwNDA5MThHQUYgZ2hxIGNvbG9ycyBjaXJjdWxhciB3aWRlLnBuZyI7czoxNzoiZW1haWxfdmVyaWZpZWRfYXQiO047czo4OiJwYXNzd29yZCI7czo2MDoiJDJ5JDEwJHh5T3RTNUNCRlpHM3pUNzBPYkoxTXVBaDJPVEkxelVvNEpUYmpUd0NTQ1V0LkVqUEFmak5LIjtzOjE3OiJ0d29fZmFjdG9yX3NlY3JldCI7TjtzOjI1OiJ0d29fZmFjdG9yX3JlY292ZXJ5X2NvZGVzIjtOO3M6MjM6InR3b19mYWN0b3JfY29uZmlybWVkX2F0IjtOO3M6MTQ6InJlbWVtYmVyX3Rva2VuIjtOO3M6MTU6ImN1cnJlbnRfdGVhbV9pZCI7TjtzOjE4OiJwcm9maWxlX3Bob3RvX3BhdGgiO047czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyMy0wMi0xOCAxMDozNzowNCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyMy0wNC0wNCAwOToxODowMyI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MTp7czoxNzoiZW1haWxfdmVyaWZpZWRfYXQiO3M6ODoiZGF0ZXRpbWUiO31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjg6IgAqAGRhdGVzIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MTp7aTowO3M6MTc6InByb2ZpbGVfcGhvdG9fdXJsIjt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YTowOnt9czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoxMDoidGltZXN0YW1wcyI7YjoxO3M6OToiACoAaGlkZGVuIjthOjQ6e2k6MDtzOjg6InBhc3N3b3JkIjtpOjE7czoxNDoicmVtZW1iZXJfdG9rZW4iO2k6MjtzOjI1OiJ0d29fZmFjdG9yX3JlY292ZXJ5X2NvZGVzIjtpOjM7czoxNzoidHdvX2ZhY3Rvcl9zZWNyZXQiO31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTozOntpOjA7czo0OiJuYW1lIjtpOjE7czo1OiJlbWFpbCI7aToyO3M6ODoicGFzc3dvcmQiO31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjE6IioiO31zOjIwOiIAKgByZW1lbWJlclRva2VuTmFtZSI7czoxNDoicmVtZW1iZXJfdG9rZW4iO3M6MTQ6IgAqAGFjY2Vzc1Rva2VuIjtOO3M6MjE6IgAqAGV4Y2x1ZGVkQXR0cmlidXRlcyI7YTowOnt9czoxMDoiYXVkaXRFdmVudCI7TjtzOjE0OiJhdWRpdEN1c3RvbU9sZCI7TjtzOjE0OiJhdWRpdEN1c3RvbU5ldyI7TjtzOjEzOiJpc0N1c3RvbUV2ZW50IjtiOjA7fX0=', 1680674221);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `mobile_no`, `email`, `address`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'Isaac Totimeh', '+233546312171', 'isaactotimeh12@gmail.com', '15 North Close Tesano', 1, NULL, '2023-02-19 00:19:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `gender`, `image`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Isaac Totimeh', 'Superadmin@admin.com', 'Male', '202304040918GAF ghq colors circular wide.png', NULL, '$2y$10$xyOtS5CBFZG3zT70ObJ1MuAh2OTI1zUo4JTbjTwCSCUt.EjPAfjNK', NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-18 10:37:04', '2023-04-04 09:18:03'),
(2, 'Isaac Totimeh', 'isaactotimeh12@gmail.com', NULL, NULL, NULL, '$2y$10$rVJckYdHR8rOkKkkFRjmaees.TdJTZd0v570LdxL/CmsEFYNcdhLu', NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-13 11:52:14', '2023-03-13 11:52:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `electronic__gadgets`
--
ALTER TABLE `electronic__gadgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `general_item_issuings`
--
ALTER TABLE `general_item_issuings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventoryrecords`
--
ALTER TABLE `inventoryrecords`
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
-- Indexes for table `non_electronic_items`
--
ALTER TABLE `non_electronic_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `personnels`
--
ALTER TABLE `personnels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase__products`
--
ALTER TABLE `purchase__products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ret_electronic_items`
--
ALTER TABLE `ret_electronic_items`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `electronic__gadgets`
--
ALTER TABLE `electronic__gadgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_item_issuings`
--
ALTER TABLE `general_item_issuings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventoryrecords`
--
ALTER TABLE `inventoryrecords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `non_electronic_items`
--
ALTER TABLE `non_electronic_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnels`
--
ALTER TABLE `personnels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase__products`
--
ALTER TABLE `purchase__products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ret_electronic_items`
--
ALTER TABLE `ret_electronic_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
