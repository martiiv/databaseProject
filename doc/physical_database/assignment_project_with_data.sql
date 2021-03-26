-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26. Mar, 2021 15:24 PM
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

--
-- Dataark for tabell `address`
--

INSERT INTO `address` (`postal_code`, `city_id`, `street_name`, `house_no`, `id`) VALUES
(150, 51234, 'Langkaia', 1, 1),
(5130, 15422, 'Myrdalsvegen', 22, 2),
(6005, 23124, 'Tøffeveien', 35, 3),
(3085, 13513, 'Taperveien', 45, 4);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `county_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `city`
--

INSERT INTO `city` (`city_id`, `name`, `county_no`) VALUES
(13513, 'Holmestrand', 7),
(15422, 'Bergen', 13),
(23124, 'Ålesund', 15),
(51234, 'Oslo', 3);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `county`
--

CREATE TABLE `county` (
  `county_no` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `county`
--

INSERT INTO `county` (`county_no`, `name`) VALUES
(3, 'Oslo'),
(7, 'Vestfold'),
(13, 'Bergen'),
(15, 'Møre_og_Romsdal');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `customer_representative`
--

CREATE TABLE `customer_representative` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `customer_representative`
--

INSERT INTO `customer_representative` (`number`) VALUES
(1),
(4);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `employees`
--

CREATE TABLE `employees` (
  `number` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `department` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `employees`
--

INSERT INTO `employees` (`number`, `name`, `department`) VALUES
(1, 'Ragnhild', 'Customer-Rep'),
(2, 'Tord', 'Storekeeper'),
(3, 'Pelle', 'Production-Planner'),
(4, 'Oline', 'Customer-Rep'),
(5, 'Polse', 'Customer-Rep');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `franchises`
--

CREATE TABLE `franchises` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `contract_duration` date GENERATED ALWAYS AS (case when `end_date` is null then to_days(curdate()) - to_days(`start_date`) else to_days(`end_date`) - to_days(`start_date`) end) VIRTUAL,
  `buying_price` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `franchises`
--

INSERT INTO `franchises` (`customer_id`, `name`, `start_date`, `end_date`, `buying_price`, `address_id`) VALUES
(3, 'XXL', '2021-03-01', '2040-03-05', 500, 2);

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

--
-- Dataark for tabell `history`
--

INSERT INTO `history` (`date`, `status`, `order_no`, `employee_no`) VALUES
('2020-06-25 00:00:00', 0, 12478, 4),
('2020-06-26 00:00:00', 0, 12478, 1),
('2020-06-27 00:00:00', 0, 12478, 2),
('2021-04-22 00:00:00', 0, 15232, 1),
('2021-04-23 00:00:00', 0, 15232, 4),
('2021-04-24 00:00:00', 0, 15232, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `individual_stores`
--

CREATE TABLE `individual_stores` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `contract_duration` date GENERATED ALWAYS AS (case when `end_date` is null then to_days(curdate()) - to_days(`start_date`) else to_days(`end_date`) - to_days(`start_date`) end) VIRTUAL,
  `buying_price` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `individual_stores`
--

INSERT INTO `individual_stores` (`customer_id`, `name`, `start_date`, `end_date`, `buying_price`, `address_id`) VALUES
(1, 'Gamletorvet sport Oslo sportslager', '2021-03-01', '2035-03-05', 1000, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `items_picked`
--

CREATE TABLE `items_picked` (
  `amount` int(11) DEFAULT NULL,
  `shipment_no` int(11) NOT NULL,
  `product_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `items_picked`
--

INSERT INTO `items_picked` (`amount`, `shipment_no`, `product_no`) VALUES
(200, 1, 240444),
(150, 1, 592903),
(25, 2, 834480),
(50, 2, 975634);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `orders`
--

CREATE TABLE `orders` (
  `order_no` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipment_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `orders`
--

INSERT INTO `orders` (`order_no`, `total_price`, `status`, `customer_id`, `shipment_no`) VALUES
(12478, 12000, 'new', 2, NULL),
(15231, 2500, 'new', 3, 1),
(15232, 34000, 'new', 1, 2),
(19324, 2000, 'new', 3, NULL),
(46029, 1000, 'new', 2, NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `order_items`
--

CREATE TABLE `order_items` (
  `amount` int(11) DEFAULT NULL,
  `order_no` int(11) NOT NULL,
  `ski_type` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `order_items`
--

INSERT INTO `order_items` (`amount`, `order_no`, `ski_type`) VALUES
(200, 12478, 'Active Pro'),
(50, 15231, 'Race Pro'),
(150, 15232, 'Redline'),
(30, 19324, 'Race Speed'),
(25, 46029, 'Intrasonic');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `product`
--

CREATE TABLE `product` (
  `product_no` int(11) NOT NULL,
  `ski_type` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `product`
--

INSERT INTO `product` (`product_no`, `ski_type`) VALUES
(202315, 'Active Pro'),
(329781, 'Active Pro'),
(885235, 'Active Pro'),
(240444, 'Race Pro'),
(881273, 'Race pro'),
(975634, 'Race pro'),
(328833, 'Redline'),
(592903, 'Redline'),
(834480, 'Redline');

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

--
-- Dataark for tabell `production_list`
--

INSERT INTO `production_list` (`amount`, `production_plan_start_date`, `production_plan_end_date`, `ski_type_model`) VALUES
(1500, '2021-04-22', '2021-05-19', 'Active Pro'),
(1600, '2021-06-18', '2021-07-15', 'Redline'),
(2000, '2021-08-14', '2021-09-11', 'Race Pro');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `production_plan`
--

CREATE TABLE `production_plan` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `no_of_skis_per_day` int(11) NOT NULL,
  `production_planner_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `production_plan`
--

INSERT INTO `production_plan` (`start_date`, `end_date`, `no_of_skis_per_day`, `production_planner_number`) VALUES
('2021-04-22', '2021-05-19', 1500, 5),
('2021-05-22', '2021-06-17', 1400, 3),
('2021-06-18', '2021-07-15', 1600, 3),
('2021-07-16', '2021-08-13', 1800, 3),
('2021-08-14', '2021-09-11', 2000, 5);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `production_planner`
--

CREATE TABLE `production_planner` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `production_planner`
--

INSERT INTO `production_planner` (`number`) VALUES
(3),
(5);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `shipments`
--

CREATE TABLE `shipments` (
  `shipment_no` int(11) NOT NULL,
  `store_franchise_name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `transporter` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `shipments`
--

INSERT INTO `shipments` (`shipment_no`, `store_franchise_name`, `pickup_date`, `state`, `driver_id`, `transporter`, `address_id`) VALUES
(1, 'XXL', '2021-04-25', 0, 1, 'Einars levering', 2),
(2, 'Gamletorvet sport Oslo sportslager', '2021-06-28', 0, 2, 'Gro Anitas postservice', 1);

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
  `description` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `historical` tinyint(1) NOT NULL,
  `photo_url` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `retail_price` int(11) NOT NULL,
  `production_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `ski_type`
--

INSERT INTO `ski_type` (`model`, `ski_type`, `temperature`, `grip_system`, `size`, `weight_class`, `description`, `historical`, `photo_url`, `retail_price`, `production_date`) VALUES
('Active', 'classic', 'cold', 'wax', 142, '20-30', 'Bra ski', 0, 'bildet', 1200, '2021-03-20'),
('Active Pro', 'skate', 'warm', 'intelligrip', 147, '30-40', 'Rævva ski', 0, 'bildet', 1400, '2021-04-02'),
('Endurance', 'double-pole', 'warm', 'wax', 152, '40-50', 'Ok ski', 0, 'bildet', 1500, '2021-12-03'),
('Intrasonic', 'classic', 'cold', 'intelligrip', 157, '40-50', 'Litt bra ski', 0, 'bildet', 1500, '2021-10-05'),
('Race Pro', 'skate', 'warm', 'wax', 162, '50-60', 'Ræser ski', 0, 'bildet', 2200, '2021-04-28'),
('Race Speed', 'double-pole', 'warm', 'intelligrip', 167, '70-80', 'Beste skia', 0, 'bildet', 36000, '2017-01-01'),
('Redline', 'skate', 'cold', 'wax', 172, '80-90', 'Verste skia', 0, 'bildet', 200, '2012-07-22');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `storekeeper`
--

CREATE TABLE `storekeeper` (
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `storekeeper`
--

INSERT INTO `storekeeper` (`number`) VALUES
(2);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `team_skiers`
--

CREATE TABLE `team_skiers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `contract_duration` date GENERATED ALWAYS AS (case when `end_date` is null then to_days(curdate()) - to_days(`start_date`) else to_days(`end_date`) - to_days(`start_date`) end) VIRTUAL,
  `dob` date NOT NULL,
  `club` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL,
  `no_skies_per_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `team_skiers`
--

INSERT INTO `team_skiers` (`customer_id`, `name`, `start_date`, `end_date`, `dob`, `club`, `no_skies_per_year`) VALUES
(2, 'Han Raske', '2021-03-01', '2023-05-03', '1995-05-01', 'Gutta', 15);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `transporters`
--

CREATE TABLE `transporters` (
  `name` varchar(100) COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_danish_ci;

--
-- Dataark for tabell `transporters`
--

INSERT INTO `transporters` (`name`) VALUES
('Einars levering'),
('Gro Anitas postservice'),
('Henriks utkjøring'),
('Oles transport');

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
  ADD PRIMARY KEY (`date`),
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
  ADD KEY `shipment_no` (`shipment_no`);

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
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `transporters`
--
ALTER TABLE `transporters`
  ADD PRIMARY KEY (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `Customer_representative_ibfk_1` FOREIGN KEY (`number`) REFERENCES `employees` (`number`);

--
-- Begrensninger for tabell `franchises`
--
ALTER TABLE `franchises`
  ADD CONSTRAINT `franchises_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Begrensninger for tabell `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`order_no`) REFERENCES `orders` (`order_no`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`employee_no`) REFERENCES `employees` (`number`);

--
-- Begrensninger for tabell `individual_stores`
--
ALTER TABLE `individual_stores`
  ADD CONSTRAINT `individual_stores_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Begrensninger for tabell `items_picked`
--
ALTER TABLE `items_picked`
  ADD CONSTRAINT `items_picked_ibfk_1` FOREIGN KEY (`shipment_no`) REFERENCES `shipments` (`shipment_no`),
  ADD CONSTRAINT `items_picked_ibfk_2` FOREIGN KEY (`product_no`) REFERENCES `product` (`product_no`);

--
-- Begrensninger for tabell `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`shipment_no`) REFERENCES `shipments` (`shipment_no`);

--
-- Begrensninger for tabell `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`ski_type`) REFERENCES `ski_type` (`model`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_no`) REFERENCES `orders` (`order_no`);

--
-- Begrensninger for tabell `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`ski_type`) REFERENCES `ski_type` (`model`);

--
-- Begrensninger for tabell `production_list`
--
ALTER TABLE `production_list`
  ADD CONSTRAINT `FK_production_period` FOREIGN KEY (`production_plan_start_date`,`production_plan_end_date`) REFERENCES `production_plan` (`start_date`, `end_date`),
  ADD CONSTRAINT `production_list_ibfk_1` FOREIGN KEY (`ski_type_model`) REFERENCES `ski_type` (`model`);

--
-- Begrensninger for tabell `production_plan`
--
ALTER TABLE `production_plan`
  ADD CONSTRAINT `production_Plan_ibfk_1` FOREIGN KEY (`production_planner_number`) REFERENCES `production_planner` (`number`);

--
-- Begrensninger for tabell `production_planner`
--
ALTER TABLE `production_planner`
  ADD CONSTRAINT `Production_planner_ibfk_1` FOREIGN KEY (`number`) REFERENCES `employees` (`number`);

--
-- Begrensninger for tabell `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`transporter`) REFERENCES `transporters` (`name`),
  ADD CONSTRAINT `shipments_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

--
-- Begrensninger for tabell `storekeeper`
--
ALTER TABLE `storekeeper`
  ADD CONSTRAINT `Storekeeper_ibfk_1` FOREIGN KEY (`number`) REFERENCES `employees` (`number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;