-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: 26.11.2024 klo 15:59
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sauna_reservations`
--
ALTER TABLE `sauna_reservations`
  ADD PRIMARY KEY (`reservation_slot`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sauna_reservations`
--
ALTER TABLE `sauna_reservations`
  MODIFY `reservation_slot` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
