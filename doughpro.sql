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
-- Table structure for table `suppliers_table`
--

CREATE TABLE `suppliers_table` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supply` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers_table`
--

INSERT INTO `suppliers_table` (`supplier_id`, `supplier_name`, `supply`, `created_at`, `updated_at`) VALUES
(1, 'Kanno', 'Fish', '2024-07-12 00:39:18', '2024-07-12 00:39:18');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`user_id`, `user_role`, `user_name`, `user_email`, `password_hash`, `last_login_date`, `created_at`, `updated_at`) VALUES
(73, 'Admin', '1', '1@gmail.com', '$2y$10$l7RCPLfgTCvKWmkCZKP0OOrcef9w72CEgrEQ0PHEBmoFzwmJgFl1S', '2024-07-09', '2024-07-08 15:17:47', '2024-07-08 16:09:35'),
(78, 'Staff', '2', '2@gmail.com', '$2y$10$CRtOF3eR1OkeBwuvj9QoCujuaAkTl9ZprquulIjZlXosYCVcSPMuu', '2024-07-09', '2024-07-08 16:09:52', '2024-07-08 16:10:19');

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
-- Indexes for table `suppliers_table`
--
ALTER TABLE `suppliers_table`
  ADD PRIMARY KEY (`supplier_id`);

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

--
-- AUTO_INCREMENT for table `suppliers_table`
--
ALTER TABLE `suppliers_table`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
