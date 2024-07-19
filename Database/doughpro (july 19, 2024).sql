-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 09:21 AM
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
(1, 'Nestle Fresh Milk', ' ', '1', 100, 30, 30, 'CARTON', '2024-07-19 06:05:53', '2024-07-19 06:06:06');

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

--
-- Dumping data for table `products_table`
--

INSERT INTO `products_table` (`product_id`, `product_name`, `price`, `total_products`, `remaining_products`, `shelf_life`, `date_produced`, `spoilage_date`, `created_at`, `updated_at`) VALUES
(1, 'Pandesal', 5.00, 50, 50, 5, '2024-07-19', '2024-07-22', '2024-07-19 06:07:01', '2024-07-19 06:07:01'),
(2, 'Pandesal', 5.00, 50, 50, 5, '2024-07-19', '2024-07-22', '2024-07-19 06:07:09', '2024-07-19 06:07:09'),
(3, 'Pandesal', 5.00, 50, 50, 5, '2024-07-19', '2024-07-22', '2024-07-19 06:07:11', '2024-07-19 06:07:11'),
(4, 'Pandesal', 5.00, 50, 50, 5, '2024-07-19', '2024-07-22', '2024-07-19 06:07:14', '2024-07-19 06:07:14'),
(5, 'Pandesal', 5.00, 50, 50, 5, '2024-07-19', '2024-07-22', '2024-07-19 06:07:16', '2024-07-19 06:07:16');

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

--
-- Dumping data for table `stocks_out_table`
--

INSERT INTO `stocks_out_table` (`stock_id`, `inventory_id`, `quantity`, `remaining_quantity`, `used`, `expired`, `discarded`, `created_at`, `updated_at`, `expiry_date`) VALUES
(1, 1, 30, 30, 0, 0, 0, '2024-07-19 06:06:06', '2024-07-19 06:06:06', '2024-08-07');

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
(1, 1, 30, 30, '2024-08-07', '2024-07-19 06:06:06', '2024-07-19 06:06:06');

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
  `supply` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
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
(73, 'Admin', '1', '1@gmail.com', '$2y$10$l7RCPLfgTCvKWmkCZKP0OOrcef9w72CEgrEQ0PHEBmoFzwmJgFl1S', '2024-07-19', '2024-07-08 15:17:47', '2024-07-19 05:57:36');

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory_table`
--
ALTER TABLE `inventory_table`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products_table`
--
ALTER TABLE `products_table`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stocks_table`
--
ALTER TABLE `stocks_table`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers_table`
--
ALTER TABLE `suppliers_table`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
