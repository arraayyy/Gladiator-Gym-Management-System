-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2022 at 02:53 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gladiator`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_fname` varchar(100) NOT NULL,
  `customer_lname` varchar(100) NOT NULL,
  `customer_mname` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_contact` char(11) NOT NULL,
  `customer_age` int(11) NOT NULL,
  `customer_gender` varchar(20) NOT NULL,
  `customer_address` varchar(50) NOT NULL,
  `customer_weight` float NOT NULL,
  `customer_height` float NOT NULL,
  `customer_bmi` varchar(20) NOT NULL,
  `customer_health` text NOT NULL,
  `customer_datecreated` datetime NOT NULL,
  `customer_queue` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_fname`, `customer_lname`, `customer_mname`, `customer_email`, `customer_contact`, `customer_age`, `customer_gender`, `customer_address`, `customer_weight`, `customer_height`, `customer_bmi`, `customer_health`, `customer_datecreated`, `customer_queue`, `is_active`, `is_deleted`) VALUES
(8, 'Green', 'Goblin', 'S', 'greengob@gmail.com', '09152900332', 25, 'M', 'Cebu City', 69, 1.81, 'Normal', 'NULL', '2022-08-03 06:39:05', 1, 1, 0),
(14, 'Roe Ann Kim', 'Codoy', 'G', 'roeannkim@gmail.com', '09152900340', 20, 'F', 'Minoza St., Tigbao, Talamban, Cebu City', 51, 1.65, 'Normal', 'Asthma', '2022-08-05 12:09:41', 1, 0, 0),
(15, 'Jade', 'Tejada', 'A.', 'j@gmial.com', '09128309218', 18, 'M', 'jklasfdj', 69, 2, 'Underweight', 'NULL', '2022-08-11 09:35:39', 0, 0, 1),
(16, 'tes', 'ting', 't', 'z@gmail.com', '0932', 2, 'm', 'aaa', 50, 3, 'Underweight', 'NULL', '2022-08-12 08:43:53', 0, 0, 1),
(17, 'Todd', 'Machacon', 'C', 'todd@email.com', '091232323', 20, 'M', 'Cebu', 55, 1.75, 'Underweight', 'NULL', '2022-08-16 01:04:24', 1, 0, 0),
(18, 'Wendel', 'Mejaran', 'D', 'wendel@email.com', '0915232323', 20, 'M', 'Cebu', 53, 1.67, 'Normal', 'NULL', '2022-08-16 01:10:17', 2, 1, 0),
(19, 'RA', 'Codoy', 'G', 'ra@email.com', '0912323233', 20, 'F', 'Talamban,Cebu', 52, 1.67, 'Normal', 'NULL', '2022-08-16 01:11:18', 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `package_plan`
--

CREATE TABLE `package_plan` (
  `package_plan_id` int(11) NOT NULL,
  `package_plan_type` varchar(30) NOT NULL,
  `numdays` int(11) NOT NULL,
  `package_plan_desc` text NOT NULL,
  `package_plan_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `package_plan`
--

INSERT INTO `package_plan` (`package_plan_id`, `package_plan_type`, `numdays`, `package_plan_desc`, `package_plan_amount`) VALUES
(1, '1 Year Plan', 365, '1 year usage', 14000),
(2, '2 Year Plan', 730, '2 years gym usage', 20000),
(14, '1 month', 30, '1 month', 500),
(15, '3 months', 90, '3 months', 3000),
(16, '5 months', 150, '5 months of gym usage', 5000),
(19, '6 months', 182, '6 months of gym usage', 6000);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `reg_id` int(30) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 1,
  `package_plan` varchar(50) NOT NULL,
  `payment_amount` int(30) NOT NULL,
  `remarks` text NOT NULL,
  `date_issued` datetime NOT NULL DEFAULT current_timestamp(),
  `is_refunded` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `reg_id`, `customer_id`, `package_plan`, `payment_amount`, `remarks`, `date_issued`, `is_refunded`) VALUES
(62, 114, 14, '1 Year Plan', 14000, 'Paid', '2022-08-13 00:24:25', 0),
(63, 115, 8, '1 Year Plan', 14000, 'Paid', '2022-08-13 00:56:03', 0),
(64, 116, 15, '1 Year Plan', 14000, 'Refunded', '2022-08-13 01:24:09', 1),
(65, 117, 14, '2 Year Plan', 20000, 'Paid', '2022-08-13 00:00:00', 0),
(66, 118, 8, '2 Year Plan', 20000, 'Paid', '2022-08-13 00:00:00', 0),
(67, 119, 8, '2 Year Plan', 20000, 'Paid', '2022-08-13 11:02:11', 0),
(68, 120, 8, '2 Year Plan', 20000, 'Paid', '2022-08-13 11:06:21', 0),
(69, 121, 8, '1 month', 500, 'Paid', '2022-08-13 21:34:30', 0),
(70, 122, 8, '1 month', 500, 'Paid', '0000-00-00 00:00:00', 0),
(71, 123, 14, '1 Year Plan', 14000, 'Refunded', '0000-00-00 00:00:00', 1),
(72, 124, 14, '1 Year Plan', 14000, 'Paid', '0000-00-00 00:00:00', 0),
(73, 125, 8, '1 Year Plan', 14000, 'Refunded', '0000-00-00 00:00:00', 1),
(74, 126, 8, '1 Year Plan', 14000, 'Paid', '0000-00-00 00:00:00', 0),
(80, 132, 8, '1 Year Plan', 14000, 'Paid', '2022-08-13 22:16:45', 0),
(81, 133, 17, '1 month', 500, 'Paid', '2022-08-16 19:04:35', 0),
(82, 134, 17, '3 months', 3000, 'Refunded', '2022-08-16 19:04:52', 1),
(83, 135, 17, '1 month', 500, 'Refunded', '2022-08-16 19:05:20', 1),
(84, 136, 18, '1 month', 500, 'Paid', '2022-08-16 19:10:28', 0),
(85, 137, 18, '3 months', 3000, 'Paid', '2022-08-16 19:10:40', 0),
(86, 138, 19, '1 month', 500, 'Paid', '2022-08-16 19:11:28', 0),
(87, 139, 19, '1 month', 500, 'Refunded', '2022-08-16 19:11:38', 1),
(88, 140, 19, '3 months', 3000, 'Refunded', '2022-08-16 19:11:51', 1),
(89, 141, 19, '1 Year Plan', 14000, 'Paid', '2022-08-16 20:50:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `reg_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_queue` int(11) NOT NULL,
  `package_plan_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `remainingPayment` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_issued` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`reg_id`, `customer_id`, `customer_queue`, `package_plan_id`, `start_date`, `end_date`, `remainingPayment`, `status`, `date_issued`) VALUES
(114, 14, 1, 1, '2022-09-13', '2023-09-13', 14000, 1, '0000-00-00'),
(115, 8, 1, 1, '2022-08-12', '2023-08-12', 14000, 1, '0000-00-00'),
(116, 15, -1, 1, '2022-08-13', '2023-08-13', 14000, 1, '0000-00-00'),
(125, 8, -1, 1, '2023-08-12', '2024-08-11', 14000, 1, '2022-08-13'),
(127, 8, -1, 1, '2023-08-12', '2024-08-11', 14000, 1, '2022-08-13'),
(128, 8, -1, 1, '2023-08-12', '2024-08-11', 14000, 1, '2022-08-13'),
(129, 8, -1, 2, '2023-08-12', '2025-08-11', 20000, 1, '2022-08-13'),
(130, 14, -1, 1, '2023-09-14', '2024-09-12', 14000, 1, '2022-08-13'),
(131, 14, -1, 2, '2023-09-14', '2025-09-12', 20000, 1, '2022-08-13'),
(132, 8, 2, 1, '2023-08-13', '2024-08-11', 14000, 1, '2022-08-13'),
(133, 17, 1, 14, '2022-07-16', '2022-08-15', 500, 1, '2022-08-16'),
(134, 17, -1, 15, '2022-08-16', '2022-11-14', 3000, 1, '2022-08-16'),
(135, 17, -1, 14, '2022-11-15', '2022-12-15', 500, 1, '2022-08-16'),
(136, 18, 1, 14, '2022-07-16', '2022-08-15', 500, 1, '2022-08-16'),
(137, 18, 2, 15, '2022-08-16', '2022-11-14', 3000, 1, '2022-08-16'),
(138, 19, 1, 14, '2022-07-13', '2022-08-12', 500, 1, '2022-08-16'),
(139, 19, -1, 14, '2022-08-16', '2022-09-15', 500, 1, '2022-08-16'),
(140, 19, -1, 15, '2022-09-16', '2022-12-15', 3000, 1, '2022-08-16'),
(141, 19, 2, 1, '2022-08-13', '2023-08-13', 14000, 1, '2022-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE `trainer` (
  `trainer_id` int(11) NOT NULL,
  `trainer_name` text NOT NULL,
  `trainer_contact` char(11) NOT NULL,
  `trainer_email` varchar(100) NOT NULL,
  `trainer_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`trainer_id`, `trainer_name`, `trainer_contact`, `trainer_email`, `trainer_rate`) VALUES
(1, 'Wendel Mejaran', '091234567', 'wendel@email.com', 100),
(2, 'John Doe', '091234557', 'jon@email.com', 100);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_password` text NOT NULL,
  `user_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_username`, `user_password`, `user_type`) VALUES
(1, 'Admin', 'admin', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `package_plan`
--
ALTER TABLE `package_plan`
  ADD PRIMARY KEY (`package_plan_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `customer_restrict` (`customer_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`reg_id`),
  ADD KEY `conn_customer` (`customer_id`),
  ADD KEY `conn_package_plan` (`package_plan_id`);

--
-- Indexes for table `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`trainer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `package_plan`
--
ALTER TABLE `package_plan`
  MODIFY `package_plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `trainer`
--
ALTER TABLE `trainer`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `customer_restrict` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `conn_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `conn_package_plan` FOREIGN KEY (`package_plan_id`) REFERENCES `package_plan` (`package_plan_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
