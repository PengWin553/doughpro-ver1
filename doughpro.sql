-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 05:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doughpro`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_current_stock` (IN `p_inventory_id` INT)   BEGIN
    DECLARE total_stock INT;

    -- Calculate the total stock for the given inventory_id
    SELECT IFNULL(SUM(quantity), 0) INTO total_stock
    FROM stocks_table
    WHERE inventory_id = p_inventory_id;

    -- Update the current_stock in the inventory_table
    UPDATE inventory_table
    SET current_stock = total_stock
    WHERE inventory_id = p_inventory_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category_table`
--

CREATE TABLE `category_table` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(8, 'Ingredients', '2024-05-16 13:18:11', '2024-05-16 13:18:11'),
(9, 'Cakes', '2024-05-16 13:18:39', '2024-05-16 13:18:39'),
(10, 'Bread', '2024-05-16 13:18:48', '2024-05-16 13:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_table`
--

CREATE TABLE `inventory_table` (
  `inventory_id` int(11) NOT NULL,
  `inventory_name` varchar(255) NOT NULL,
  `inventory_description` varchar(255) DEFAULT NULL,
  `inventory_category` varchar(255) DEFAULT NULL,
  `inventory_price` int(10) DEFAULT NULL,
  `current_stock` int(11) NOT NULL,
  `min_stock_level` int(11) DEFAULT 0,
  `unit` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_table`
--

INSERT INTO `inventory_table` (`inventory_id`, `inventory_name`, `inventory_description`, `inventory_category`, `inventory_price`, `current_stock`, `min_stock_level`, `unit`, `created_at`, `updated_at`) VALUES
(7, 'Flour', ' 1111', '8', 100, 1000, 70, 'SACK', '2024-05-17 05:29:23', '2024-05-23 15:39:44'),
(39, 'Salt', 'it\'s salty', '8', 123, 20, 80, 'KG', '2024-05-23 13:05:53', '2024-05-23 15:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `stocks_table`
--

CREATE TABLE `stocks_table` (
  `stock_id` int(11) NOT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks_table`
--

INSERT INTO `stocks_table` (`stock_id`, `inventory_id`, `quantity`, `expiry_date`, `created_at`, `updated_at`) VALUES
(20, 8, 90, '2024-05-14', '2024-05-23 15:36:12', '2024-05-23 15:36:12'),
(21, 7, 1000, '2024-05-30', '2024-05-23 15:36:34', '2024-05-23 15:39:44'),
(22, 39, 10, '2024-05-20', '2024-05-23 15:40:43', '2024-05-23 15:42:04'),
(23, 39, 10, '2024-05-30', '2024-05-23 15:41:44', '2024-05-23 15:41:59');

--
-- Triggers `stocks_table`
--
DELIMITER $$
CREATE TRIGGER `after_stocks_delete` AFTER DELETE ON `stocks_table` FOR EACH ROW BEGIN
    CALL update_current_stock(OLD.inventory_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_stocks_insert` AFTER INSERT ON `stocks_table` FOR EACH ROW BEGIN
    CALL update_current_stock(NEW.inventory_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_stocks_update` AFTER UPDATE ON `stocks_table` FOR EACH ROW BEGIN
    CALL update_current_stock(NEW.inventory_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

CREATE TABLE `users_table` (
  `user_id` int(11) NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `password_hash` varchar(100) NOT NULL,
  `last_login_date` date NOT NULL,
  `salt` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`user_id`, `user_role`, `user_name`, `user_email`, `password_hash`, `last_login_date`, `salt`, `created_at`, `updated_at`) VALUES
(28, 'Admin', 'Yuu Koito', 'arianatorswiftyfangurl@gmail.com', '8a925302d802e39251ea16b4e87dc662a058690f066ee7bc5b736140ab021135', '2024-05-23', 'a058690f066ee7bc5b736140ab021135', '2024-05-16 09:35:12', '2024-05-23 11:42:12'),
(35, 'Staff', 'Staff Name', 'staff@example.com', 'e909cfcd6b7bf9d92cff781472e503c4ff8e496c1f41e5db8efe8b9ef09cb0d7', '2024-05-18', 'ff8e496c1f41e5db8efe8b9ef09cb0d7', '2024-05-16 09:35:12', '2024-05-18 06:19:57'),
(36, 'Admin', 'Jham', 'jham@gmail.com', 'c4ebbb1455dab67a0bcf95e633ad44c28487b2df9331348de26fb267aa9c70ff', '2024-05-15', '8487b2df9331348de26fb267aa9c70ff', '2024-05-16 09:35:12', '2024-05-16 09:35:12'),
(43, 'Staff', 'Rae Taylor', 'raetaylor@gmail.com', 'ed3a7ab919795f62d36f6658a0f703a9d33ca9256f4360f9b111f0e5d83ba00a', '2024-05-16', 'd33ca9256f4360f9b111f0e5d83ba00a', '2024-05-16 09:35:12', '2024-05-16 09:35:12'),
(44, 'Admin', 'Claire Francois1', 'clairefrancois@gmail.com', 'ed3a7ab919795f62d36f6658a0f703a9220da88abd4ecc919554de105758a54b', '2024-05-16', '220da88abd4ecc919554de105758a54b', '2024-05-16 09:35:12', '2024-05-18 07:01:48'),
(66, 'Staff', 'Kanno', 'kannokobayashi@gmail.com', 'ed3a7ab919795f62d36f6658a0f703a9a7c9f08d42337ec61214027b97715262', '0000-00-00', 'a7c9f08d42337ec61214027b97715262', '2024-05-18 08:14:04', '2024-05-18 08:35:24'),
(67, 'Admin', 'Sushi Kobayashi 123', 'sushikobayashi@gmail.com', 'ed3a7ab919795f62d36f6658a0f703a9d0deb233c9802ff49eeacad85381f91c', '0000-00-00', 'd0deb233c9802ff49eeacad85381f91c', '2024-05-18 08:49:24', '2024-05-18 08:49:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_table`
--
ALTER TABLE `category_table`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `inventory_table`
--
ALTER TABLE `inventory_table`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `stocks_table`
--
ALTER TABLE `stocks_table`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_table`
--
ALTER TABLE `category_table`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `inventory_table`
--
ALTER TABLE `inventory_table`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `stocks_table`
--
ALTER TABLE `stocks_table`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
