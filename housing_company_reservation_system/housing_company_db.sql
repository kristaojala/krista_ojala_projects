/* SQL for the project, things relevant to sauna are done by my teammate.*/

/* Projektin SQL, saunaan liittyvät asiat teki tiimikaverini.*/

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: 12.01.2025 klo 16:41
-- Palvelimen versio: 8.3.0
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `housing_company_db`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `cars`
--

CREATE TABLE `cars` (
  `registration_number` varchar(15) NOT NULL,
  `apartment` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `cars`
--

INSERT INTO `cars` (`registration_number`, `apartment`) VALUES
('AAA-111', 1),
('ABC-123', 1),
('BBB-222', 1),
('CCC-333', 1),
('DEF-456', 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `parking_reservations`
--

CREATE TABLE `parking_reservations` (
  `reservation_id` int NOT NULL,
  `parking_spot` int NOT NULL,
  `apartment` int NOT NULL,
  `car_registration_number` varchar(15) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ;

--
-- Vedos taulusta `parking_reservations`
--

INSERT INTO `parking_reservations` (`reservation_id`, `parking_spot`, `apartment`, `car_registration_number`, `start_time`, `end_time`) VALUES
(200, 6, 1, 'AAA-111', '2025-01-12 15:51:16', '2025-01-12 16:51:16'),
(201, 1, 1, 'ABC-123', '2025-01-12 15:51:18', '2025-01-12 16:51:18'),
(202, 3, 1, 'BBB-222', '2025-01-12 15:53:22', '2025-01-12 16:53:22');

-- --------------------------------------------------------

--
-- Rakenne taululle `parking_spaces`
--

CREATE TABLE `parking_spaces` (
  `parking_spot` int NOT NULL,
  `status` enum('available','reserved') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `parking_spaces`
--

INSERT INTO `parking_spaces` (`parking_spot`, `status`) VALUES
(1, 'reserved'),
(2, 'available'),
(3, 'reserved'),
(4, 'available'),
(5, 'available'),
(6, 'reserved');

-- --------------------------------------------------------

--
-- Rakenne taululle `sauna_reservations`
--

CREATE TABLE `sauna_reservations` (
  `reservation_slot` int NOT NULL,
  `weekday` enum('Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai','Lauantai','Sunnuntai') NOT NULL,
  `starting_hour` int NOT NULL,
  `userID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `sauna_reservations`
--

INSERT INTO `sauna_reservations` (`reservation_slot`, `weekday`, `starting_hour`, `userID`) VALUES
(1, 'Maanantai', 17, 0),
(2, 'Tiistai', 17, 0),
(3, 'Keskiviikko', 17, 0),
(4, 'Torstai', 17, 0),
(5, 'Perjantai', 17, 0),
(6, 'Lauantai', 17, 0),
(7, 'Sunnuntai', 17, 0),
(8, 'Maanantai', 18, 0),
(9, 'Tiistai', 18, 0),
(10, 'Keskiviikko', 18, 0),
(11, 'Torstai', 18, 0),
(12, 'Perjantai', 18, 0),
(13, 'Lauantai', 18, 0),
(14, 'Sunnuntai', 18, 0),
(15, 'Maanantai', 19, 0),
(16, 'Tiistai', 19, 0),
(17, 'Keskiviikko', 19, 0),
(18, 'Torstai', 19, 0),
(19, 'Perjantai', 19, 0),
(20, 'Lauantai', 19, 0),
(21, 'Sunnuntai', 19, 0),
(22, 'Maanantai', 20, 0),
(23, 'Tiistai', 20, 0),
(24, 'Keskiviikko', 20, 0),
(25, 'Torstai', 20, 0),
(26, 'Perjantai', 20, 0),
(27, 'Lauantai', 20, 0),
(28, 'Sunnuntai', 20, 0),
(29, 'Maanantai', 21, 0),
(30, 'Tiistai', 21, 0),
(31, 'Keskiviikko', 21, 0),
(32, 'Torstai', 21, 0),
(33, 'Perjantai', 21, 0),
(34, 'Lauantai', 21, 0),
(35, 'Sunnuntai', 21, 0),
(36, 'Maanantai', 22, 0),
(37, 'Tiistai', 22, 0),
(38, 'Keskiviikko', 22, 0),
(39, 'Torstai', 22, 0),
(40, 'Perjantai', 22, 0),
(41, 'Lauantai', 22, 0),
(42, 'Sunnuntai', 22, 0),
(43, 'Maanantai', 23, 0),
(44, 'Tiistai', 23, 0),
(45, 'Keskiviikko', 23, 0),
(46, 'Torstai', 23, 0),
(47, 'Perjantai', 23, 0),
(48, 'Lauantai', 23, 0),
(49, 'Sunnuntai', 23, 0);

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE `users` (
  `apartment` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`apartment`, `name`, `role`, `password`, `email`) VALUES
(0, 'Admin Andy', 'admin', '$2y$10$mC1AMozk2NWlXhzTR7bQW.pSbiyGMM00Lscrc2ZgfWeg6Ua2159fq', 'admin@testi.nom'),
(1, 'John Smither', 'user', '$2y$10$u5zyNFBD7SYfr9RzkvVSleZbd8hL6EMy1G1NMNy6DlkZRoM3BWrSe', 'js@testi.nom');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`registration_number`),
  ADD KEY `apartment` (`apartment`);

--
-- Indexes for table `parking_reservations`
--
ALTER TABLE `parking_reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `parking_spot` (`parking_spot`),
  ADD KEY `apartment` (`apartment`),
  ADD KEY `car_registration_number` (`car_registration_number`);

--
-- Indexes for table `parking_spaces`
--
ALTER TABLE `parking_spaces`
  ADD PRIMARY KEY (`parking_spot`);

--
-- Indexes for table `sauna_reservations`
--
ALTER TABLE `sauna_reservations`
  ADD PRIMARY KEY (`reservation_slot`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`apartment`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parking_reservations`
--
ALTER TABLE `parking_reservations`
  MODIFY `reservation_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sauna_reservations`
--
ALTER TABLE `sauna_reservations`
  MODIFY `reservation_slot` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`apartment`) REFERENCES `users` (`apartment`) ON DELETE CASCADE;

--
-- Rajoitteet taululle `parking_reservations`
--
ALTER TABLE `parking_reservations`
  ADD CONSTRAINT `parking_reservations_ibfk_1` FOREIGN KEY (`parking_spot`) REFERENCES `parking_spaces` (`parking_spot`) ON DELETE CASCADE,
  ADD CONSTRAINT `parking_reservations_ibfk_2` FOREIGN KEY (`apartment`) REFERENCES `users` (`apartment`) ON DELETE CASCADE,
  ADD CONSTRAINT `parking_reservations_ibfk_3` FOREIGN KEY (`car_registration_number`) REFERENCES `cars` (`registration_number`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
