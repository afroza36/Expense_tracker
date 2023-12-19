-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2023 at 05:08 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expense`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` int NOT NULL,
  `budget` int DEFAULT NULL,
  `person_id` int DEFAULT NULL,
  `month` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`id`, `budget`, `person_id`, `month`) VALUES
(1, 3500, 1, ''),
(2, 5600, 2, ''),
(4, 4000, 2, ''),
(5, 3460, 2, 'March'),
(6, 6500, 3, 'May'),
(7, 21000, 1, 'December'),
(8, 4500, 1, 'March'),
(9, 8000, 1, 'August'),
(10, 20000, 1, 'November');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `month` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `budget` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `person_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `month`, `budget`, `person_id`) VALUES
(1, 'food', 'February', '6000', 1),
(2, 'movie', 'December', '500', 1),
(3, 'food', 'December', '1000', 1),
(4, 'lippi', 'December', '2000', 1),
(11, 'cloth', 'March', '10000', 1),
(12, 'food', 'August', '400', 1),
(13, 'cloth', 'August', '6000', 1),
(14, 'movie', 'August', '700', 1),
(15, 'food', 'November', '1000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tyme` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `person_id` int DEFAULT NULL,
  `location` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pay_method` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `category`, `tyme`, `amount`, `description`, `person_id`, `location`, `pay_method`) VALUES
(1, 'movie', '2023-12-15', '250', 'netflix', 1, '', ''),
(2, 'food', '2023-12-25', '340', 'burger', 1, '', ''),
(3, 'lippi', '2023-12-26', '340', 'nirvana', 1, '', ''),
(4, 'food', '2023-12-20', '600', 'burger', 1, '', ''),
(5, 'food', '2023-11-19', '200', 'Something', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sign_info`
--

CREATE TABLE `sign_info` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sign_info`
--

INSERT INTO `sign_info` (`id`, `name`, `email`, `password`) VALUES
(1, 'afroza', 'roza@gmail.com', '1234'),
(2, 'soma', 'soma@gmail.com', '5555'),
(3, 'tanha', 'tanha@gmail.com', '6666');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk1` (`person_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk2` (`person_id`);

--
-- Indexes for table `sign_info`
--
ALTER TABLE `sign_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sign_info`
--
ALTER TABLE `sign_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `sign_info` (`id`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`person_id`) REFERENCES `sign_info` (`id`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `fk2` FOREIGN KEY (`person_id`) REFERENCES `sign_info` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
