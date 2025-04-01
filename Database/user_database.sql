-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 09:26 PM
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
-- Database: `user_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) NOT NULL,
  `rooms` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `guests` int(11) DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `leaving_date` date DEFAULT NULL,
  `flight_id` int(11) NOT NULL,
  `booking_status` enum('reserved','canceled') NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `hotel_id`, `rooms`, `name`, `surname`, `email`, `location`, `address`, `guests`, `arrival_date`, `leaving_date`, `flight_id`, `booking_status`, `phone`) VALUES
(38, 0, 0, 0, 'dasdasda', 'dasdasdas', 'adsdasddas@gmail.com', 'Peja', 'asddslop', 3, '2025-01-16', '2025-01-25', 0, 'reserved', '23131231'),
(39, 0, 0, 0, 'dasdasda', 'dasdasdas', 'adsdasddas@gmail.com', 'Peja', 'asddslop', 3, '2025-01-16', '2025-01-25', 0, 'reserved', '23131231'),
(40, 0, 0, 0, 'asdasdas', 'Deam', 'oltimiftarii21@gmail.com', 'Peja', 'Haredin Bajrami', 3, '2025-01-27', '2025-01-29', 0, 'reserved', '044274813'),
(41, 54, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 1, 'reserved', NULL),
(42, 54, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 1, 'reserved', NULL),
(43, 54, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 1, 'reserved', NULL),
(44, 1313, 0, 0, 'Olti', 'Miftari', 'oltimif@gmail.com', 'Kosova', 'Lip', 3, '2025-01-21', '2025-01-30', 0, 'reserved', '04428232'),
(45, 1313, 0, 0, 'Olti', 'Miftari', 'oltimif@gmail.com', 'Kosova', 'Lip', 3, '2025-01-21', '2025-01-30', 0, 'reserved', '04428232'),
(46, 2313, 0, 0, '31231231', '123123123', 'oltimiftarii22@gmail.com', 'Kosova', 'Haredin Bajrami', 2, '2025-01-28', '2025-01-30', 0, 'reserved', '044274813'),
(47, 59, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 1, 'reserved', NULL),
(48, 63, 2, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 0, 'reserved', NULL),
(49, 63, 1, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 0, 'reserved', NULL),
(50, 63, 1, 3, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 0, 'reserved', NULL),
(51, 66, 1, 2, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 0, 'reserved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `flight_number` varchar(50) NOT NULL,
  `departure_location` varchar(100) NOT NULL,
  `arrival_location` varchar(100) NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_time` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `flight_number`, `departure_location`, `arrival_location`, `departure_time`, `arrival_time`, `price`) VALUES
(1, '1231', 'Pristina', 'Stuttgart', '2025-01-18 18:09:00', '2025-01-19 17:09:00', 132.00),
(2, '1444', 'Tirana', 'Egypt', '2025-01-25 16:16:00', '2025-01-30 16:16:00', 130.00),
(3, '1231', 'Tirana', 'Egypt', '2025-01-25 19:45:00', '2025-01-29 19:45:00', 34.00),
(4, '124', 'Skopje', 'Malmo', '2025-01-24 16:27:00', '2025-01-29 16:27:00', 322.00),
(5, '1231', 'Tirana', 'Malmo', '2025-01-26 20:17:00', '2025-01-30 20:17:00', 2332.00),
(6, '1231', 'Tirana', 'Malmo', '2025-01-26 20:17:00', '2025-01-30 20:17:00', 2332.00),
(7, '1231', 'Tirana', 'Stuttgart', '2025-01-28 01:14:00', '2025-01-31 01:14:00', 24.00);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotelID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `rating` double NOT NULL,
  `pricePerNight` double NOT NULL,
  `availability` int(11) NOT NULL,
  `facilities` text NOT NULL,
  `contactDetails` varchar(255) NOT NULL,
  `imagePath` varchar(255) NOT NULL DEFAULT '../img/hotel-placeholder.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotelID`, `name`, `location`, `rating`, `pricePerNight`, `availability`, `facilities`, `contactDetails`, `imagePath`) VALUES
(1, 'Hotel Paradise', 'New York', 4.5, 150, 0, 'Free WiFi, Pool, Parking', 'info@paradise.com', '../img/hotel1.jpg'),
(2, 'Beachside Inn', 'Miami', 4.8, 200, 0, 'Ocean View, Breakfast Included', 'contact@beachside.com', '../img/hotel2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itineraries`
--

CREATE TABLE `itineraries` (
  `id` int(11) NOT NULL,
  `traveler_id` int(11) NOT NULL,
  `details` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itineraries`
--

INSERT INTO `itineraries` (`id`, `traveler_id`, `details`, `created_at`) VALUES
(3, 1, 'Detajet jane se do shkoj ne pristhine ', '2025-01-11 21:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `card_expiry` varchar(5) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `user_id`, `amount`, `payment_method`, `payment_status`, `card_number`, `card_expiry`, `bank_account`, `paypal_email`, `payment_date`) VALUES
(1, 41, 11.00, 'Credit Card', 'Pending', NULL, NULL, NULL, NULL, '2025-01-12 23:00:00'),
(2, 41, 11.00, 'Credit Card', 'Pending', NULL, NULL, NULL, NULL, '2025-01-12 23:00:00'),
(3, 41, 212.00, 'Credit Card', 'Pending', NULL, NULL, NULL, NULL, '2025-01-13 12:14:23'),
(4, 41, 23131.00, 'Credit Card', 'Pending', NULL, NULL, NULL, NULL, '2025-01-13 12:14:33'),
(5, 41, 5.00, 'Credit Card', 'Pending', NULL, NULL, NULL, NULL, '2025-01-14 12:20:19'),
(6, 59, 23232.00, 'Credit Card', 'Pending', NULL, NULL, NULL, NULL, '2025-01-16 17:15:52'),
(7, 59, 100.00, 'Credit Card', 'Pending', NULL, NULL, NULL, NULL, '2025-01-16 17:21:14'),
(8, 59, 12113.00, 'Credit Card', 'Pending', '123123123123123', '11/25', '', '', '2025-01-16 17:33:56'),
(9, 64, 123.00, 'Credit Card', 'Pending', '312312312231', '11/26', '', '', '2025-01-16 19:16:09'),
(10, 67, 100.00, 'Credit Card', 'Pending', '564566456456', '12/24', '', '', '2025-01-16 22:25:09'),
(11, 67, 100.00, 'Credit Card', 'Pending', '12231231223', '11/27', '', '', '2025-01-16 22:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `itinerary_id` int(11) NOT NULL,
  `traveler_id` int(11) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `itinerary_id`, `traveler_id`, `details`, `created_at`) VALUES
(1, 3, 1, 'asdasdasd', '2025-01-11 21:25:14'),
(2, 3, 1, 'sfsdfsdf', '2025-01-11 21:28:21'),
(3, 3, 1, 'sdfsdfsdf', '2025-01-11 21:28:23'),
(4, 3, 1, 'sdfsdfsdf', '2025-01-11 21:28:24'),
(5, 3, 1, 'sdfsdfsdf', '2025-01-12 01:56:19'),
(6, 3, 1, 'asdassdasd', '2025-01-12 13:53:27'),
(7, 3, 1, 'asdasdasd', '2025-01-12 13:53:30'),
(8, 3, 1, 'dadasdasd', '2025-01-12 16:51:45'),
(9, 3, 1, 'asdasdadasd', '2025-01-13 23:50:43'),
(10, 3, 1, 'uiyiyui', '2025-01-15 21:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `travelID` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `reviewDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewID`, `customerID`, `travelID`, `rating`, `comment`, `reviewDate`) VALUES
(1, 0, 0, 4, 'asdasdasdasdad', '0000-00-00'),
(2, 0, 0, 4, 'asdasdasdad', '0000-00-00'),
(3, 0, 0, 4, 'asdasdasdad', '0000-00-00'),
(4, 0, 0, 4, 'Oltiii\r\n', '0000-00-00'),
(5, 0, 0, 3, 'Edi', '0000-00-00'),
(6, 0, 0, 3, 'asdasdasdasdad', '0000-00-00'),
(7, 0, 0, 4, 'asdasdad', '0000-00-00'),
(8, 0, 0, 5, 'fvdvddf', '0000-00-00'),
(9, 0, 0, 3, 'qwewewqewq', '0000-00-00'),
(10, 0, 0, 4, 'jghggukgukgugu', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `transaction_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `travelers`
--

CREATE TABLE `travelers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` varchar(50) NOT NULL,
  `passport_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `travel_details`
--

CREATE TABLE `travel_details` (
  `travelDetailsID` int(11) NOT NULL,
  `itineraryID` int(11) NOT NULL,
  `departureLocation` varchar(255) NOT NULL,
  `arrivalLocation` varchar(255) NOT NULL,
  `transportMode` varchar(50) NOT NULL,
  `totalCost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `user_type`) VALUES
(49, 'Olti', 'Miftari', 'oltim3@gmail.com', '$2y$10$QBece8ZHgeDjG6urGX.dxerwsWUvHCqsILRVEVk0pbpW1AUh518lS', 0),
(50, 'Altin', 'Krasn', 'altink@gmail.com', '$2y$10$gkj8aVa.Md8kbnVdTX9uEuD0kzfwdNCG7r5CbKEGhqwhVOVVJTyzC', 0),
(51, 'asdasd', 'asdasdasd', 'edd@gmail.com', '$2y$10$nUpMYzySP1ozlNdU6b8OrOKU.2PU0m5hPCuaStGy/TfvywYbJh5Y6', 0),
(52, 'Edinjo', 'Krasn', 'ediedi3@gmail.com', '$2y$10$b9vORALd3UTfRPFTZSXJqeVH1qWBdQFttE8qDz0Be5b0ZgaGC85w6', 0),
(53, 'asdadas', 'asdadasd', 'krasn@gmail.com', '$2y$10$Gzsbqbv5mN59GBZ.3jqvCOqeEJ6xdj4rfzjdIcGTKoVcOG8CDKgf2', 0),
(54, 'asdasda', 'dasdasdas', 'olti2@gmail.com', '$2y$10$o75pisvSLzrAI/JjecEVLu3o13V8CXgtzRHoxzDgicl1G79AaUihq', 0),
(55, 'Olti', 'Miftar', 'olt2@gmail.com', '$2y$10$c4Wyx1zHePmTZVlGQeIYzeBLSDBr5g9YpLQMZL7VAfYwKyHB6Yg/S', 0),
(56, 'Maf', 'Mafi', 'maf2@gmail.com', '$2y$10$WMnjD6z5QOSUQJQpMSRIhu.TQvks5lP.NbCD9vPWVgLbh8iGS0Ndi', 0),
(57, 'Olti', 'Mifs', 'olti34@gmail.com', '$2y$10$9iz2C1n5Nd4OQgk3U.dsp.2kDdKhGmE0F1scbEXagLWhu/6bU3iFq', 0),
(58, 'Olti', 'Miftari', 'oltimif3@gmail.com', '$2y$10$bV.Exm6rkoskzIaFrCEPUOvLCO67gOdHev6geFJ3ryCwoTBmJRFGe', 0),
(59, 'Olti', 'Miftss', 'oltiedi@gmail.com', '$2y$10$xqQRsORXs0LcQ150MxZr0uL1uImIsqHJI7A/mDJBfYKBg9SakSul6', 0),
(60, 'Olt', 'MSD', 'olt311@gmail.com', '$2y$10$evvBZE0572H8i5omf2wVpeGrI3o/b0hXyoyYF6tEPL7PJdFXMtsuu', 0),
(62, 'sdasd', 'asdasdasd', 'asdas1d@gmail.com', '$2y$10$U7KUz.es4zIk8KU.3heiZuleivrkk6isEMWcYHHEmByK6qpzWgIy2', 0),
(63, 'Edin', 'Krasniqi', 'edi1@gmail.com', '$2y$10$R25yjHmwM7H.MbPgrItRs.mEgzUs/vobt8c8/q/Z/HGqysL17UZKa', 0),
(64, 'Oltin', 'Mif', 'oltim23@gmail.com', '$2y$10$tXCKmZoV5cmmtuCLXEnCHOvyv3kARv04dKA3MafcaBsU.xKuhA3dy', 0),
(65, 'Olti', 'Miftari', 'olti5@gmail.com', '$2y$10$05w/D7YFuXwcpZFczTCOo.bXLE9OsVNfsn3mqpEnfvlkMpyMOnTBC', 1),
(66, 'Olti', 'Miftarii', 'oltim6@gmail.com', '$2y$10$R3JXeAovs/3yb372wO7YYuSjG8JkjNxioZJlwPoFH/1rv40BwTaiO', 0),
(67, 'Jona', 'Rrahmani', 'jonarrah33@gmail.com', '$2y$10$8cz6eQLE9ttaN0xKkPlOmewA1piZUswOq8e8JinUGXLSct2TzTLtG', 0),
(68, 'Olti', 'Miftari', 'oltim4@gmail.com', '$2y$10$WN2aoyyVPz74nLkm6Yg22.8wR0veXZ.2U3LPX8killRy2kIY8S7VO', 0),
(69, 'Olti', 'Miftari', 'oltimiftarii3@gmail.com', '$2y$10$LVjIMAqgv5Yi41mS/mrLYOn.0FTIWDCqE0dHgK4q4qkLetRBu2q8m', 1),
(71, 'Nart', 'Cerkini', 'nart5@gmail.com', '$2y$10$sRaH44XGk2qLr0pFwK4qNeGltxZ1YBHXJe0u.iM.krUlcPo05uYP2', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotelID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `itineraries`
--
ALTER TABLE `itineraries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `traveler_id` (`traveler_id`,`details`) USING HASH;

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `travelers`
--
ALTER TABLE `travelers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `travel_details`
--
ALTER TABLE `travel_details`
  ADD PRIMARY KEY (`travelDetailsID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itineraries`
--
ALTER TABLE `itineraries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `travelers`
--
ALTER TABLE `travelers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `travel_details`
--
ALTER TABLE `travel_details`
  MODIFY `travelDetailsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
