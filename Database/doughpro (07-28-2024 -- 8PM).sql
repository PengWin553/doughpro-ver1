-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2024 at 02:26 PM
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
-- Database: `doughpro`
--

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
(1, 'Ingredients', '2024-07-19 06:05:29', '2024-07-19 06:05:29');

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
(1, 'Nestle Fresh Milk', ' ', '1', 100, 42, 30, 'CARTON', '2024-07-19 06:05:53', '2024-07-28 11:08:29'),
(2, 'Baking Flour', ' ', '1', 100, 50, 50, 'Sack', '2024-07-28 11:45:49', '2024-07-28 11:48:58'),
(8, 'eggs', ' ', '1', 100, 50, 100, 'Tray', '2024-07-28 12:15:47', '2024-07-28 12:16:48');

--
-- Triggers `inventory_table`
--
DELIMITER $$
CREATE TRIGGER `inventory_insert_trigger` AFTER INSERT ON `inventory_table` FOR EACH ROW BEGIN
    IF NEW.current_stock < NEW.min_stock_level THEN
        INSERT INTO to_order_table (inventory_id, to_order_quantity)
        VALUES (NEW.inventory_id, NEW.min_stock_level - NEW.current_stock);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `inventory_update_trigger` AFTER UPDATE ON `inventory_table` FOR EACH ROW BEGIN
    DECLARE order_quantity INT;
    
    IF NEW.current_stock < NEW.min_stock_level THEN
        SET order_quantity = NEW.min_stock_level - NEW.current_stock;
        
        IF EXISTS (SELECT 1 FROM to_order_table WHERE inventory_id = NEW.inventory_id) THEN
            UPDATE to_order_table
            SET to_order_quantity = order_quantity
            WHERE inventory_id = NEW.inventory_id;
        ELSE
            INSERT INTO to_order_table (inventory_id, to_order_quantity)
            VALUES (NEW.inventory_id, order_quantity);
        END IF;
    ELSE
        -- Remove the row if current_stock is equal to or greater than min_stock_level
        DELETE FROM to_order_table WHERE inventory_id = NEW.inventory_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products_table`
--

CREATE TABLE `products_table` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_products` int(11) NOT NULL,
  `remaining_products` int(11) NOT NULL,
  `shelf_life` int(11) NOT NULL,
  `date_produced` date NOT NULL,
  `spoilage_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks_out_table`
--

CREATE TABLE `stocks_out_table` (
  `stock_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remaining_quantity` int(11) NOT NULL,
  `used` int(11) NOT NULL,
  `expired` int(11) NOT NULL,
  `discarded` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks_table`
--

CREATE TABLE `stocks_table` (
  `stock_id` int(11) NOT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `remaining_quantity` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks_table`
--

INSERT INTO `stocks_table` (`stock_id`, `inventory_id`, `quantity`, `remaining_quantity`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 1, 30, 30, '2024-08-07', '2024-07-19 06:06:06', '2024-07-19 06:06:06'),
(2, 1, 12, 12, '2024-08-01', '2024-07-28 11:08:29', '2024-07-28 11:08:29'),
(3, 2, 10, 10, '2024-07-31', '2024-07-28 11:47:57', '2024-07-28 11:47:57'),
(4, 2, 40, 40, '2024-08-10', '2024-07-28 11:48:58', '2024-07-28 11:48:58'),
(5, 3, 30, 0, '2024-07-24', '2024-07-28 11:55:32', '2024-07-28 11:55:59'),
(6, 3, 30, 0, '2024-08-10', '2024-07-28 11:55:50', '2024-07-28 11:56:35'),
(7, 4, 100, 50, '2024-08-10', '2024-07-28 11:58:23', '2024-07-28 11:58:35'),
(8, 5, 10, 10, '2024-08-10', '2024-07-28 12:02:49', '2024-07-28 12:02:49'),
(9, 5, 50, 50, '2024-08-01', '2024-07-28 12:03:23', '2024-07-28 12:03:23'),
(10, 6, 20, 20, '2024-08-09', '2024-07-28 12:06:07', '2024-07-28 12:06:07'),
(11, 6, 30, 0, '2024-08-01', '2024-07-28 12:06:19', '2024-07-28 12:07:26'),
(12, 7, 10, 0, '2024-08-08', '2024-07-28 12:12:34', '2024-07-28 12:13:27'),
(13, 7, 40, 40, '2024-08-02', '2024-07-28 12:13:13', '2024-07-28 12:13:13'),
(15, 8, 50, 50, '2024-08-10', '2024-07-28 12:16:48', '2024-07-28 12:16:48');

--
-- Triggers `stocks_table`
--
DELIMITER $$
CREATE TRIGGER `after_stock_delete` AFTER DELETE ON `stocks_table` FOR EACH ROW BEGIN
    DELETE FROM stocks_out_table
    WHERE stock_id = OLD.stock_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_stock_insert` AFTER INSERT ON `stocks_table` FOR EACH ROW BEGIN
    INSERT INTO stocks_out_table (stock_id, inventory_id, quantity, remaining_quantity, used, expired, expiry_date)
    VALUES (NEW.stock_id, NEW.inventory_id, NEW.quantity, NEW.quantity, 0, 0, NEW.expiry_date);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_stock_update` AFTER UPDATE ON `stocks_table` FOR EACH ROW BEGIN
    UPDATE stocks_out_table
    SET 
        inventory_id = NEW.inventory_id,
        quantity = NEW.quantity,
        remaining_quantity = NEW.remaining_quantity,
        expiry_date = NEW.expiry_date
    WHERE stock_id = NEW.stock_id;
END
$$
DELIMITER ;
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
  `email` varchar(200) NOT NULL,
  `contact_number` int(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `supply` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `to_order_table`
--

CREATE TABLE `to_order_table` (
  `to_order_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `to_order_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`user_id`, `user_role`, `user_name`, `user_email`, `password_hash`, `last_login_date`, `created_at`, `updated_at`) VALUES
(73, 'Admin', '1', '1@gmail.com', '$2y$10$l7RCPLfgTCvKWmkCZKP0OOrcef9w72CEgrEQ0PHEBmoFzwmJgFl1S', '2024-07-28', '2024-07-08 15:17:47', '2024-07-28 11:08:14');

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
-- Indexes for table `products_table`
--
ALTER TABLE `products_table`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `stocks_table`
--
ALTER TABLE `stocks_table`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `suppliers_table`
--
ALTER TABLE `suppliers_table`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `to_order_table`
--
ALTER TABLE `to_order_table`
  ADD PRIMARY KEY (`to_order_id`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory_table`
--
ALTER TABLE `inventory_table`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products_table`
--
ALTER TABLE `products_table`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks_table`
--
ALTER TABLE `stocks_table`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `suppliers_table`
--
ALTER TABLE `suppliers_table`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `to_order_table`
--
ALTER TABLE `to_order_table`
  MODIFY `to_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
