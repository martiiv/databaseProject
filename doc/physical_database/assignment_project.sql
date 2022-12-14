 -- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19. Apr, 2021 09:39 AM
-- Tjener-versjon: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment_project`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `address`
--

CREATE TABLE `address` (
  `postal_code` int(4) NOT NULL,
  `city_id` int(11) NOT NULL,
  `street_name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `house_no` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `county_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `county`
--

CREATE TABLE `county` (
  `county_no` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Erstatningsstruktur for visning `customer_address`
-- (See below for the actual view)
--
CREATE TABLE `customer_address` (
`customer_id` int(11)
,`address_id` int(11)
);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `customer_representative`
--

CREATE TABLE `customer_representative` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `employees`
--

CREATE TABLE `employees` (
  `number` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `department` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `franchises`
--

CREATE TABLE `franchises` (
  `customer_id` int(11) NOT NULL,
  `buying_price` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `history`
--

CREATE TABLE `history` (
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `employee_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `individual_stores`
--

CREATE TABLE `individual_stores` (
  `customer_id` int(11) NOT NULL,
  `buying_price` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `items_picked`
--

CREATE TABLE `items_picked` (
  `amount` int(11) DEFAULT NULL,
  `shipment_no` int(11) NOT NULL,
  `product_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `orders`
--

CREATE TABLE `orders` (
  `order_no` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `total_price` int(11) NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipment_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_items`
--

CREATE TABLE `order_items` (
  `amount` int(11) DEFAULT NULL,
  `order_no` int(11) NOT NULL,
  `ski_type` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `product`
--

CREATE TABLE `product` (
  `product_no` int(11) NOT NULL,
  `production_date` date NOT NULL,
  `ski_type` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `production_list`
--

CREATE TABLE `production_list` (
  `amount` int(11) NOT NULL,
  `production_plan_start_date` date NOT NULL,
  `production_plan_end_date` date NOT NULL,
  `ski_type_model` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `production_plan`
--

CREATE TABLE `production_plan` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `no_of_skis_per_day` int(11) NOT NULL,
  `production_planner_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `production_planner`
--

CREATE TABLE `production_planner` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `shipments`
--

CREATE TABLE `shipments` (
  `shipment_no` int(11) NOT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `driver_id` int(11) DEFAULT NULL,
  `transporter` varchar(100) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `ski_type`
--

CREATE TABLE `ski_type` (
  `model` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `ski_type` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `temperature` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `grip_system` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `size` int(11) NOT NULL,
  `weight_class` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `historical` tinyint(1) NOT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_danish_ci DEFAULT NULL,
  `retail_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `storekeeper`
--

CREATE TABLE `storekeeper` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `team_skiers`
--

CREATE TABLE `team_skiers` (
  `customer_id` int(11) NOT NULL,
  `dob` date NOT NULL,
  `club` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `no_skies_per_year` int(11) DEFAULT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `transporters`
--

CREATE TABLE `transporters` (
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `auth_token`
--

CREATE TABLE `auth_token` (
  `user` varchar(255) COLLATE utf8mb4_danish_ci NOT NULL,
  `token` char(64) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

 -- --------------------------------------------------------

--
-- Visningsstruktur `customer_address`
--
 DROP VIEW IF EXISTS `customer_address`;
 CREATE VIEW `customer_address`  AS ( SELECT customer_id, address_id FROM franchises UNION ALL SELECT customer_id, address_id FROM individual_stores UNION ALL SELECT customer_id, address_id FROM team_skiers );

 -- --------------------------------------------------------
--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_ibfk_1` (`city_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `city_ibfk_1` (`county_no`);

--
-- Indexes for table `county`
--
ALTER TABLE `county`
  ADD PRIMARY KEY (`county_no`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_representative`
--
ALTER TABLE `customer_representative`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `franchises`
--
ALTER TABLE `franchises`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`date`,`order_no`) USING BTREE,
  ADD KEY `order_no` (`order_no`),
  ADD KEY `employee_no` (`employee_no`);

--
-- Indexes for table `individual_stores`
--
ALTER TABLE `individual_stores`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `items_picked`
--
ALTER TABLE `items_picked`
  ADD PRIMARY KEY (`shipment_no`,`product_no`),
  ADD KEY `product_no` (`product_no`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_no`),
  ADD KEY `shipment_no` (`shipment_no`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_no`,`ski_type`),
  ADD KEY `ski_type` (`ski_type`),
  ADD KEY `order_no` (`order_no`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_no`),
  ADD KEY `ski_type` (`ski_type`);

--
-- Indexes for table `production_list`
--
ALTER TABLE `production_list`
  ADD PRIMARY KEY (`production_plan_start_date`,`production_plan_end_date`,`ski_type_model`),
  ADD KEY `ski_type_model` (`ski_type_model`);

--
-- Indexes for table `production_plan`
--
ALTER TABLE `production_plan`
  ADD PRIMARY KEY (`start_date`,`end_date`),
  ADD KEY `production_planner_number` (`production_planner_number`);

--
-- Indexes for table `production_planner`
--
ALTER TABLE `production_planner`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`shipment_no`),
  ADD KEY `transporter` (`transporter`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `ski_type`
--
ALTER TABLE `ski_type`
  ADD PRIMARY KEY (`model`);

--
-- Indexes for table `storekeeper`
--
ALTER TABLE `storekeeper`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `team_skiers`
--
ALTER TABLE `team_skiers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `team_skiers_ibfk_2` (`address_id`);

--
-- Indexes for table `transporters`
--
ALTER TABLE `transporters`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `auth_token`
--
ALTER TABLE `auth_token`
  ADD UNIQUE KEY `token` (`token`);
COMMIT;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `shipment_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`county_no`) REFERENCES `county` (`county_no`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `customer_representative`
--
ALTER TABLE `customer_representative`
  ADD CONSTRAINT `Customer_representative_ibfk_1` FOREIGN KEY (`number`) REFERENCES `employees` (`number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `franchises`
--
ALTER TABLE `franchises`
  ADD CONSTRAINT `franchises_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `franchises_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`order_no`) REFERENCES `orders` (`order_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `individual_stores`
--
ALTER TABLE `individual_stores`
  ADD CONSTRAINT `individual_stores_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `individual_stores_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `items_picked`
--
ALTER TABLE `items_picked`
  ADD CONSTRAINT `items_picked_ibfk_1` FOREIGN KEY (`shipment_no`) REFERENCES `shipments` (`shipment_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_picked_ibfk_2` FOREIGN KEY (`product_no`) REFERENCES `product` (`product_no`);

--
-- Begrensninger for tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`shipment_no`) REFERENCES `shipments` (`shipment_no`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`ski_type`) REFERENCES `ski_type` (`model`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_no`) REFERENCES `orders` (`order_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`ski_type`) REFERENCES `ski_type` (`model`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `production_list`
--
ALTER TABLE `production_list`
  ADD CONSTRAINT `FK_production_period` FOREIGN KEY (`production_plan_start_date`,`production_plan_end_date`) REFERENCES `production_plan` (`start_date`, `end_date`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `production_list_ibfk_1` FOREIGN KEY (`ski_type_model`) REFERENCES `ski_type` (`model`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `production_plan`
--
ALTER TABLE `production_plan`
  ADD CONSTRAINT `production_plan_ibfk_1` FOREIGN KEY (`production_planner_number`) REFERENCES `production_planner` (`number`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Begrensninger for tabell `production_planner`
--
ALTER TABLE `production_planner`
  ADD CONSTRAINT `Production_planner_ibfk_1` FOREIGN KEY (`number`) REFERENCES `employees` (`number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`transporter`) REFERENCES `transporters` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `shipments_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON UPDATE CASCADE;

--
-- Begrensninger for tabell `storekeeper`
--
ALTER TABLE `storekeeper`
  ADD CONSTRAINT `Storekeeper_ibfk_1` FOREIGN KEY (`number`) REFERENCES `employees` (`number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `team_skiers`
--
ALTER TABLE `team_skiers`
  ADD CONSTRAINT `team_skiers_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `team_skiers_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
