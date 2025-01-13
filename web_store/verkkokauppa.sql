-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2024 at 12:40 AM
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
-- Database: `verkkokauppa`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`OrderItemID`, `OrderID`, `ProductID`, `Quantity`, `Subtotal`) VALUES
(1, 1, 1, 1, 19.99),
(2, 2, 2, 1, 24.99),
(3, 3, 3, 1, 14.99),
(84, 62, 12, 1, 149.90),
(85, 62, 14, 1, 43.50),
(90, 65, 16, 2, 35.00),
(91, 65, 5, 1, 129.99),
(95, 67, 14, 1, 43.50),
(96, 68, 10, 1, 39.99),
(97, 69, 1, 1, 79.99),
(98, 69, 5, 1, 129.99),
(99, 69, 8, 1, 149.99);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OrderDate` datetime DEFAULT NULL,
  `Status` enum('Pending','Shipped','Delivered') DEFAULT 'Pending',
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `notRegisteredUserAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `OrderDate`, `Status`, `TotalPrice`, `notRegisteredUserAddress`) VALUES
(1, 1, '2023-10-15 10:30:00', 'Pending', 19.99, NULL),
(2, 2, '2023-10-16 14:45:00', 'Shipped', 24.99, NULL),
(3, 3, '2023-10-17 11:15:00', 'Delivered', 14.99, NULL),
(62, 8, '2024-01-19 17:26:15', 'Shipped', 202.35, NULL),
(65, NULL, '2024-01-23 20:12:58', 'Pending', 173.94, 'Mikko Mallikas, mallikas@testi.nom, mallitie 56'),
(67, NULL, '2024-01-23 21:43:08', 'Delivered', 52.45, 'Antti Anttonen, anttonenantti@testi.nom, anttostie 543'),
(68, 6, '2024-01-23 21:45:47', 'Shipped', 48.94, NULL),
(69, NULL, '2024-01-24 01:30:11', 'Pending', 368.92, 'Ulla Taalasmaa, Pihlajakatu 23 B as 1, taalasmaaulla@testi.nom');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `Description`, `Price`, `ImageURL`, `deleted_at`) VALUES
(1, 'Elegant Wristwatch', 'A sleek and stylish wristwatch with a genuine leather strap.', 79.99, 'wristwatch.jpg', NULL),
(2, 'Artisanal Handbag', 'Handcrafted handbag with intricate embroidery and a timeless design.', 49.99, 'handbag.jpg', NULL),
(3, 'Smart Home Speaker', 'Voice-activated smart speaker with built-in virtual assistant and impressive sound quality.', 149.99, 'smart_speaker.jpg', NULL),
(4, 'Luxury Perfume', 'Exquisite perfume with a captivating scent in an elegant glass bottle.', 59.99, 'perfume.jpg', NULL),
(5, 'Designer Dress', 'Fashion-forward designer dress that is perfect for special occasions.', 129.99, 'designer_dress.jpg', NULL),
(6, 'Gourmet Cheese Selection', 'Indulge in a variety of artisanal cheeses from around the world.', 24.99, 'cheese_selection.jpg', NULL),
(7, 'High-Performance Laptop', 'Powerful laptop for work and entertainment with a high-resolution display.', 999.99, 'laptop.jpg', NULL),
(8, 'Vintage Record Player', 'Enjoy your vinyl collection with a vintage-style record player.', 149.99, 'record_player.jpg', NULL),
(9, 'Leather Office Chair', 'Ergonomic office chair with genuine leather upholstery for superior comfort.', 179.99, 'office_chair.jpg', NULL),
(10, 'Wireless Gaming Mouse', 'Responsive gaming mouse with customizable RGB lighting and precision tracking.', 39.99, 'gaming_mouse.jpg', NULL),
(11, 'Cat', 'Meet your new feline friend! Each cat is delivered in a cardboard box with holes. Color may vary.', 6361.74, 'cat.jpg', NULL),
(12, 'Crystal Glasses', 'Our crystal glasses transform every sip into a luxurious experience. Each set contains six glasses.', 149.90, 'glass.jpg', NULL),
(13, 'Heart Necklace', 'Our exquisite necklace captures the essence of sophistication and timeless beauty.', 364.90, 'necklace.jpg', NULL),
(14, 'Bath Set', 'This Lavish bath set will turn your bath time into a regal retreat.', 43.50, 'bathset.jpg', NULL),
(15, 'Fountain Pen', 'Unleash your creativity in the most opulent way possible with our distinguished fountain pen.', 19.90, 'fountainpen.jpg', NULL),
(16, 'Luxury Blend Coffee', 'A blend of rare beans meticulously curated for a rich, velvety flavor. Each bag contains 100 grams of coffee beans.', 17.50, 'coffee.jpg', NULL),
(17, 'Test_item_1afsz', 'only for testing purposes', 5.57, 'test1.png', '2024-01-22 18:33:33'),
(21, 'TESTefs', 'this is a new description text for testhrfzbszh esf', 6.54, 'test1.png', '2024-01-23 03:32:02'),
(25, 'Testi13egs', 'wfwwadfwaewgwse', 6.70, '', '2024-01-24 00:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `UserType` enum('Customer','Admin') DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Password`, `Email`, `Address`, `UserType`, `deleted_at`) VALUES
(1, 'John', 'Doe', '$2y$10$CkSDo14zYUwZx381KeK3KOg50zkiKFjUg2gWeaCryOQMv/16lp/Km', 'john.doe@example.com', '123 Main St', 'Customer', NULL),
(2, 'Jane', 'Smith', '$2y$10$CkSDo14zYUwZx381KeK3KOg50zkiKFjUg2gWeaCryOQMv/16lp/Km', 'jane.smith@example.com', '456 Elm St', 'Admin', NULL),
(3, 'Alice', 'Johnson', '$2y$10$CkSDo14zYUwZx381KeK3KOg50zkiKFjUg2gWeaCryOQMv/16lp/Km', 'alice.johnson@example.com', '789 Oak St', 'Customer', NULL),
(4, 'Krista', 'Ojala', '$2y$10$yJpMLc1hIuI.flwi3wuzj.d3sAs8wvU7nI/QNbgqX96m9mNYT9A92', 'kristaojala@hotmail.com', NULL, 'Admin', NULL),
(5, 'Matti-Pekka', 'Meikäläinen-Miettinen', '$2y$12$hkvhQxpsscXaSQMZYFnrqOAl1c7YzavC8GBnkTdVvYuTvj9.CtPou', 'esimerkkiemail@testi.nom', 'Mattilantie 5, Mattila', 'Customer', NULL),
(6, 'Timo', 'Testinen', '$2y$12$7jhSTr.rhYKYiDe2M9mdPud.mRtLz6wMT/3iKd.GlJPVGhOM7xX2.', 'timotestinen@testi.nom', 'Testistie 9', 'Customer', '2024-01-23 18:19:54'),
(7, 'Lux', 'Leather', '$2y$12$BYQqg./6M/CGoiCT.3hCgOUwfQtS9TFBi57cmcz4Wr2hOqIkpwGIS', 'luxleather@esimerkkiemail.nom', 'Leatherstreet 4', 'Customer', NULL),
(8, 'Testi', 'Testinen', '$2y$12$qBQht1eaDz.lhUd2WWr0K.BK1cJj.BHHkHeqUj.kQ9nOXNFhBNk1e', 'testi@testi.nom', 'Tie 1, 4321 Kaupunki', 'Customer', NULL),
(14, 'Andy', 'Admin', '$2y$12$.fy.wSiHUDeVE.a4xZhz/.oy0ZD0D/2Xd2s5EQIvG7gGo3dHfqFjW', 'adminandy@testiemail.nom', 'adminstreet 1, 1234 adland', 'Admin', NULL),
(15, 'Calle', 'Customer', '$2y$12$9AfQxiXcD0eU5Bjuzht.JuginbKcg.QohPLiNEBANen9EmImzAjBa', 'customercalle@testi.nom', NULL, 'Customer', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
