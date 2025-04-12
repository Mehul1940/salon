-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 12:05 AM
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
-- Database: `salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pin_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'India',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line1`, `address_line2`, `city`, `state`, `pin_code`, `country`, `created_at`) VALUES
(3, 4, 'd-3,shiavlik residency,vatva', '', 'Ahmedabad', 'Gujrat', '382443', 'India', '2025-04-03 17:20:51'),
(4, 6, 'd-3,shiavlik residency,vatva', '', 'Ahmedabad', 'Gujrat', '382443', 'India', '2025-04-03 19:19:02'),
(5, 8, 'f-102,saurabh society,isanpur', '', 'Ahmedabad', 'Gujrat', '382443', 'India', '2025-04-03 19:21:21'),
(6, 7, 'f-102,saurabh society,isanpur', '', 'Ahmedabad', 'Gujrat', '382443', 'India', '2025-04-03 19:23:09'),
(7, 5, 'd-3,shiavlik residency,vatva', '', 'Ahmedabad', 'Gujrat', '382443', 'India', '2025-04-03 19:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `appointment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `service_id`, `staff_id`, `appointment_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 9, '2025-04-03 19:35:04', 'Confirmed', NULL, '2025-04-03 17:57:14', '2025-04-03 19:35:04'),
(2, 6, 2, 10, '2025-04-03 19:26:36', 'Completed', NULL, '2025-04-03 19:20:37', '2025-04-03 19:26:36'),
(3, 8, 3, 11, '2025-04-03 19:26:50', 'Cancelled', NULL, '2025-04-03 19:22:12', '2025-04-03 19:26:50'),
(4, 7, 4, 12, '2025-04-03 20:59:55', 'Confirmed', NULL, '2025-04-03 19:22:53', '2025-04-03 20:59:55'),
(5, 5, 6, NULL, '2025-04-24 23:30:00', 'Pending', NULL, '2025-04-03 19:25:14', '2025-04-03 19:25:14'),
(6, 5, 8, 13, '2025-04-03 19:30:01', 'Confirmed', NULL, '2025-04-03 19:28:45', '2025-04-03 19:30:01'),
(7, 7, 9, NULL, '2025-04-22 19:29:00', 'Pending', NULL, '2025-04-03 19:29:29', '2025-04-03 19:29:29');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`) VALUES
(2, 'Sunsilk', '2025-04-01 07:43:36'),
(3, 'L`Oreal', '2025-04-03 14:53:55'),
(4, 'ThriveCo', '2025-04-03 14:55:45'),
(5, 'Minimalist', '2025-04-03 15:02:54'),
(6, 'LAKMÉ', '2025-04-03 15:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(8, 4, 4, 2, '2025-04-03 17:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(3, 'Hair Shampoo', '2025-04-03 14:53:11'),
(4, 'Hair Conditioner', '2025-04-03 14:56:40'),
(5, 'Face Serum', '2025-04-03 15:03:10'),
(6, 'Face Cream', '2025-04-03 15:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected','expired','suspended') NOT NULL DEFAULT 'pending',
  `payment_proof` varchar(255) DEFAULT NULL,
  `admin_response` text DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `user_id`, `plan_id`, `request_date`, `status`, `payment_proof`, `admin_response`, `expiry_date`, `created_at`, `updated_at`) VALUES
(9, 4, 2, '2025-04-03 17:29:05', 'approved', '1743701345_1743497806_1 year QR.png', NULL, '2025-10-03', '2025-04-03 13:59:05', '2025-04-03 17:29:48'),
(10, 8, 2, '2025-04-03 18:05:12', 'suspended', '1743703512_1743499694_1 year QR.png', NULL, NULL, '2025-04-03 14:35:12', '2025-04-03 20:02:52'),
(11, 6, 1, '2025-04-03 18:32:19', 'approved', '1743705139_WhatsApp Image 2025-04-03 at 23.53.49_3bccafcd.jpg', NULL, '2025-07-03', '2025-04-03 15:02:19', '2025-04-03 20:06:08'),
(12, 7, 3, '2025-04-03 20:01:10', 'rejected', '1743710470_Screenshot (163).png', NULL, NULL, '2025-04-03 16:31:10', '2025-04-03 20:02:22'),
(13, 5, 2, '2025-04-03 20:01:40', 'expired', '1743710500_Screenshot (101).png', NULL, NULL, '2025-04-03 16:31:40', '2025-04-03 20:02:37');

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `duration` enum('3 months','6 months','1 year') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `order_discount` decimal(5,2) DEFAULT 0.00,
  `service_discount` decimal(5,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `payment_qr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `name`, `duration`, `price`, `order_discount`, `service_discount`, `description`, `payment_qr`, `created_at`, `updated_at`) VALUES
(1, '3 Months Plan', '3 months', 600.00, 10.00, 15.00, 'A 3-month membership plan offering a 10% discount on orders and 15% off on services.', '1743498349_3 Month Qr.png', '2025-04-01 08:45:25', '2025-04-03 18:13:03'),
(2, '6 Months Plan', '6 months', 900.00, 12.00, 18.00, 'A 6-month membership plan providing a 12% discount on orders and 18% off on services.', '1743498355_6 Month Qr.png', '2025-04-01 08:45:25', '2025-04-01 09:05:55'),
(3, '1 Year Plan', '1 year', 1500.00, 15.00, 20.00, 'A 1-year membership plan with a 15% discount on orders and 20% off on services.', '1743497813_1 year QR.png', '2025-04-01 08:45:25', '2025-04-01 08:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_option` enum('delivery','pickup') NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `delivery_option`, `status`, `created_at`) VALUES
(2, 4, 526.24, 'delivery', 'processing', '2025-04-03 17:32:14'),
(3, 6, 399.10, 'delivery', 'completed', '2025-04-03 19:19:15'),
(4, 8, 1596.00, 'delivery', 'completed', '2025-04-03 19:21:29'),
(5, 7, 599.00, 'delivery', 'processing', '2025-04-03 19:23:17'),
(6, 5, 339.00, 'delivery', 'processing', '2025-04-03 19:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`, `subtotal`) VALUES
(2, 2, 4, 263, 2, 526.24),
(3, 3, 8, 359, 1, 359.10),
(4, 4, 7, 399, 4, 1596.00),
(5, 5, 5, 599, 1, 599.00),
(6, 6, 6, 299, 1, 299.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','debit_card','cash') NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `amount`, `payment_method`, `status`, `created_at`) VALUES
(2, 2, 4, 526.24, 'cash', 'completed', '2025-04-03 17:32:14'),
(3, 3, 6, 399.10, 'cash', 'completed', '2025-04-03 19:19:15'),
(4, 4, 8, 1596.00, 'cash', 'completed', '2025-04-03 19:21:29'),
(5, 5, 7, 599.00, 'cash', 'completed', '2025-04-03 19:23:17'),
(6, 6, 5, 339.00, 'cash', 'completed', '2025-04-03 19:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `brand_id`, `price`, `stock`, `image`, `created_at`) VALUES
(2, 'L`Oreal Professionnel Absolut Repair Shampoo', 'Professional shampoo for Strengthening and Repairing Hair | 300ml', 3, 3, 699.00, 30, '1743691966_1742831308_product01.jpg', '2025-04-03 14:52:46'),
(4, 'ThriveCo Rosemary Hair Conditioner For Voluminous Hair', 'Densifying and Stimulating Hair Growth | Promotes Hair Strength | 250ml', 4, 4, 299.00, 20, '1743692251_1742831504_product02.jpg', '2025-04-03 14:57:31'),
(5, 'Minimalist Oil Control and Anti-Acne 10% Niacinamide Face Serum', 'Skin Clarifying, Blemishes and Pore Care for All Skin Types | 30ml', 5, 5, 599.00, 20, '1743692636_product03.jpg', '2025-04-03 15:03:56'),
(6, 'LAKMÉ Absolute Perfect Radiance Brightening Day Cream', 'SPF 30, Daily Illuminating Face Moisturizer for Glowing Skin | 50g', 6, 6, 299.00, 20, '1743692752_product04.jpg', '2025-04-03 15:05:52'),
(7, 'LAKMÉ 9To5 1% Active Vitamin C+ Day Cream For Face', 'Face Cream For Bright, Glowing Skin | For Dry, Oily, Normal, Sensitive &amp; Combination Skin | 50G', 6, 6, 399.00, 30, '1743692912_51e42U5tSHL._SX522_.jpg', '2025-04-03 15:08:32'),
(8, 'L`Oreal Paris Extraordinary Oil Nourishing Shampoo', 'L`Oreal Paris Extraordinary Oil Nourishing Shampoo For Dry &amp; Dull Hair, 180ml', 3, 3, 399.00, 20, '1743696214_31eYcjLg9QL._SX300_SY300_QL70_FMwebp_.webp', '2025-04-03 16:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `quote_requests`
--

CREATE TABLE `quote_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `event_type` enum('Wedding','Engagement','Birthday','Party','Corporate','Other') NOT NULL,
  `event_date` date NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','contacted','closed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quote_requests`
--

INSERT INTO `quote_requests` (`id`, `name`, `email`, `phone`, `event_type`, `event_date`, `message`, `status`, `created_at`) VALUES
(1, 'saroj', 'sarojuser@gmail.com', '9876543213', 'Engagement', '2025-04-16', 'I am regular customer of this salon', 'contacted', '2025-04-03 20:14:05'),
(2, 'aditi', 'aditiuser@gmail.com', '6778569823', 'Party', '2025-04-22', 'I am regular customer of this salon', 'closed', '2025-04-03 20:15:31'),
(3, 'kavya', 'kavyauser@gmail.com', '9876543213', 'Birthday', '2025-04-23', 'I am regular customer of this salon', 'pending', '2025-04-03 20:16:23'),
(4, 'muskan', 'muskanuser@gmail.com', '9876543778', 'Corporate', '2025-04-30', 'I have a corporate funtion', 'contacted', '2025-04-03 20:17:09'),
(5, 'renuka', 'renukauser@gmail.com', '9624040607', 'Wedding', '2025-04-08', 'I am regular customer of this salon', 'contacted', '2025-04-03 20:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category` enum('Hair Services','Beauty Services') NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `min_price` decimal(10,2) NOT NULL,
  `max_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category`, `name`, `description`, `min_price`, `max_price`, `created_at`) VALUES
(1, 'Hair Services', 'Haircut & Styling', 'Includes consultation, shampoo, and blow dry', 900.00, 1500.00, '2025-04-01 07:29:46'),
(2, 'Hair Services', 'Hair Coloring', 'Global color, highlights, balayage, or ombre', 2500.00, 6000.00, '2025-04-01 07:29:46'),
(3, 'Hair Services', 'Keratin Treatment', 'Smoothing and anti-frizz treatment', 5000.00, 8000.00, '2025-04-01 07:29:46'),
(4, 'Hair Services', 'Hair Spa', 'Deep conditioning and scalp massage', 1200.00, 2500.00, '2025-04-01 07:29:46'),
(6, 'Beauty Services', 'Manicure & Pedicure', 'Classic, gel, or spa options available', 800.00, 2000.00, '2025-04-01 07:29:46'),
(7, 'Beauty Services', 'Facial Treatments', 'Customized for your skin type', 1500.00, 4000.00, '2025-04-01 07:29:46'),
(8, 'Beauty Services', 'Makeup Application', 'Day, evening, or special occasion', 1800.00, 5000.00, '2025-04-01 07:29:46'),
(9, 'Beauty Services', 'Waxing Services', 'Full body or targeted areas', 200.00, 3000.00, '2025-04-01 07:29:46'),
(11, 'Beauty Services', 'Threading', 'Eyebrows, upper lip or face', 100.00, 500.00, '2025-04-03 14:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin','staff') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `profile_pic`, `token`, `role`, `created_at`) VALUES
(3, 'dhwani', 'dhwaniadmin@gmail.com', '$2y$10$QAv1lAqoX3yYL5..3y1Lb./4VrCwK49XSSQCbysUSgLS8Uwzb25oq', NULL, 'default-profile.png', NULL, 'admin', '2025-04-03 13:54:49'),
(4, 'renuka', 'renukauser@gmail.com', '$2y$10$qHhAt8ot/Z7Ksy8ksxFxtOFbuwTF0S1vrMcPoECa95e7yj88BTZ9m', '9624040607', 'default-profile.png', NULL, 'customer', '2025-04-03 13:57:12'),
(5, 'saroj', 'sarojuser@gmail.com', '$2y$10$rnsxA33n0bbjKmKfmhtvTOP3BEUxLnCvX3oar7iDJJpKiXRLlcMhe', '2323454567', 'default-profile.png', NULL, 'customer', '2025-04-03 13:57:41'),
(6, 'muskan', 'muskanuser@gmail.com', '$2y$10$fCna2t4hth0WD.xwBxpkaO7904lIkva29XzUfEIm10R.8jP3zr6L.', '1212343423', 'default-profile.png', NULL, 'customer', '2025-04-03 13:58:13'),
(7, 'aditi', 'aditiuser@gmail.com', '$2y$10$JbBSQSkYuV3c2.Bq/BNv9eWXm37AHdm3iogPr.2vAGwcNvU2ViGAy', '5656787867', 'default-profile.png', NULL, 'customer', '2025-04-03 13:58:38'),
(8, 'kavya', 'kavyauser@gmail.com', '$2y$10$yGLhGZBaW/fdQsmQoKzRUuTQebnENM9GyoZJWzk1KAumCT0LbcYxC', '7878565667', 'default-profile.png', NULL, 'customer', '2025-04-03 13:59:17'),
(9, 'meera', 'meera.staff@example.com', '$2y$10$aUzsKXR1au2MvUSaMVcmoOlnPfpDqCQsBiINargtMSpgk145yTiri', '9876543212', 'default-profile.png', NULL, 'staff', '2025-04-03 14:00:26'),
(10, 'seema', 'seemastaff@gmail.com', '$2y$10$eWxZ9qT5lGiNuHXImPCPp.0lncadiunK/9nbKOfFYlFG/co1QK3q2', '9876543213', 'default-profile.png', NULL, 'staff', '2025-04-03 14:01:02'),
(11, 'arti', 'artistaff@gmail.com', '$2y$10$mqkwmrLPaTvMc49ub00/SeYt9.Az6ICxE1eEiRWc8bAasQnRyoPmi', '9876543214', 'default-profile.png', NULL, 'staff', '2025-04-03 14:01:44'),
(12, 'rina', 'rinastaff@gmail.com', '$2y$10$7CDn99aeLAIGgytDM2Z3N./M0/FLg689Q5Vf9q5HgeuLmp.5YvAD2', '9876543215', 'default-profile.png', NULL, 'staff', '2025-04-03 14:02:19'),
(13, 'priya', 'priyastaff@gmail.com', '$2y$10$YFlWsw324wBeWornyYVzg.OQQ7YrKZKk9zELMfZaVTx6SSk2KmwA2', '9876543412', 'default-profile.png', NULL, 'staff', '2025-04-03 14:02:55'),
(14, 'chetna', 'chetnastaff@gmail.com', '$2y$10$KysLIiYo5IQgsYBAIj3vxuYmmCbcD7RJYD6IJKUCEtqS3Nb/USFO2', '7823120212', 'default-profile.png', NULL, 'staff', '2025-04-03 14:03:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `quote_requests`
--
ALTER TABLE `quote_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quote_requests`
--
ALTER TABLE `quote_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `membership_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `membership_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
