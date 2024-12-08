-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 01:51 PM
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
-- Database: `dormerdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `landlord`
--

CREATE TABLE `landlord` (
  `id` int(11) NOT NULL,
  `landlordname` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `contact_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landlord`
--

INSERT INTO `landlord` (`id`, `landlordname`, `email`, `password`, `contact_number`) VALUES
(2, 'Jio Delgado', 'jiodelgado@gmail.com', '$2y$10$Ex08UEKS1VCzaWcNIEsA5.OcSlOA7xgfAKept2JhKBYUcOJWvGfuC', '09692134345'),
(3, 'Joshua Dajao II', 'derpybaby123@gmail.com', '$2y$10$g8qPluCR.T.0BH5A3NoY9uasNni/3aoQ1EW9CiVeghYW5kIzA9WEi', '09459816048'),
(4, 'derpy baby', 'db@gmail.com', '$2y$10$FPbyvefggME0sOm5pr6.pO0VNFZrU.az8fWyR44Igo/DoR/d/3vpy', '2141242142'),
(5, 'joshua', 'jerichorueras69@gmail.com', '$2y$10$ch45sK2yRfmLP.ktrXY8MOLwkj.TBXrA12uqdr/shJOV44q4c4hHW', '09298005825');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `reference_number` int(11) NOT NULL,
  `electricitybill` float NOT NULL,
  `waterbill` float NOT NULL,
  `amount` float NOT NULL,
  `date_of_payment` date NOT NULL,
  `tenantID` int(11) DEFAULT NULL,
  `landlordID` int(11) DEFAULT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`reference_number`, `electricitybill`, `waterbill`, `amount`, `date_of_payment`, `tenantID`, `landlordID`, `status`) VALUES
(1, 1000, 500, 9500.5, '2024-07-11', 1, 2, 'Payment Overdue'),
(2, 1000, 500, 8900.75, '2024-07-13', 2, 2, 'Paid'),
(4, 1000, 500, 8200.6, '2024-07-13', 4, 2, 'Payment Overdue'),
(5, 1000, 500, 9800.45, '2024-07-13', 5, 2, 'Payment Overdue'),
(6, 1000, 500, 10500.3, '2024-07-13', 6, 2, 'Payment Overdue'),
(7, 1000, 500, 7500.1, '2024-07-13', 7, 2, 'Payment Overdue'),
(8, 1000, 500, 8800.2, '2024-07-13', 8, 2, 'Payment Overdue'),
(9, 1000, 500, 9300.4, '2024-07-13', 9, 2, 'Payment Overdue'),
(10, 1000, 500, 8700.35, '2024-07-13', 10, 2, 'Payment Overdue'),
(11, 1000, 500, 9100.5, '2024-07-13', 11, 2, 'Payment Overdue'),
(12, 1000, 500, 8200.6, '2024-07-13', 12, 2, 'Payment Overdue'),
(13, 1000, 500, 9700.7, '2024-07-13', 13, 2, 'Payment Overdue'),
(14, 1000, 500, 10600.8, '2024-07-13', 14, 2, 'Payment Overdue'),
(15, 1000, 500, 7500.9, '2024-07-13', 15, 2, 'Payment Overdue'),
(16, 1000, 500, 8600, '2024-07-13', 16, 2, 'Payment Overdue'),
(17, 1000, 500, 9200.1, '2024-07-13', 17, 2, 'Payment Overdue'),
(18, 1000, 500, 9000.2, '2024-07-13', 18, 2, 'Payment Overdue'),
(20, 1000, 500, 8300.4, '2024-07-13', 20, 2, 'Payment Overdue'),
(21, 1000, 500, 9500.5, '2024-07-13', 21, 2, 'Payment Overdue'),
(22, 1000, 500, 7700.6, '2024-07-13', 22, 2, 'Payment Overdue'),
(23, 1000, 500, 8700.7, '2024-07-13', 23, 2, 'Payment Overdue'),
(24, 1000, 500, 9100.8, '2024-07-13', 24, 2, 'Payment Overdue'),
(25, 1000, 500, 8200.9, '2024-07-13', 25, 2, 'Payment Overdue'),
(26, 1000, 500, 9400, '2024-07-13', 26, 2, 'Payment Overdue'),
(35, 1000, 500, 10000, '2024-11-05', 1, NULL, 'Paid'),
(36, 1000, 500, 10000, '2024-11-05', 2, NULL, 'Paid'),
(40, 1000, 500, 10000, '2024-11-05', 6, NULL, 'Payment Overdue'),
(41, 1000, 500, 10000, '2024-11-05', 7, NULL, 'Payment Overdue'),
(42, 1000, 500, 10000, '2024-11-05', 8, NULL, 'Payment Overdue'),
(43, 1000, 500, 10000, '2024-11-05', 9, NULL, 'Payment Overdue'),
(44, 1000, 500, 10000, '2024-11-05', 10, NULL, 'Payment Overdue'),
(45, 1000, 500, 10000, '2024-11-05', 11, NULL, 'Payment Overdue'),
(46, 1000, 500, 10000, '2024-11-05', 12, NULL, 'Payment Overdue'),
(47, 1000, 500, 10000, '2024-11-05', 13, NULL, 'Payment Overdue'),
(48, 1000, 500, 10000, '2024-11-05', 14, NULL, 'Payment Overdue'),
(49, 1000, 500, 10000, '2024-11-05', 15, NULL, 'Payment Overdue'),
(50, 1000, 500, 10000, '2024-11-05', 16, NULL, 'Payment Overdue'),
(51, 1000, 500, 10000, '2024-11-05', 17, NULL, 'Payment Overdue'),
(52, 1000, 500, 10000, '2024-11-05', 18, NULL, 'Payment Overdue'),
(53, 1000, 500, 10000, '2024-11-05', 19, NULL, 'Payment Overdue'),
(56, 1000, 500, 10000, '2024-11-05', 22, NULL, 'Payment Overdue'),
(57, 1000, 500, 10000, '2024-11-05', 23, NULL, 'Payment Overdue'),
(61, 1000, 500, 31146.9, '2024-08-05', 2, NULL, 'Payment Due'),
(62, 1000, 500, 24050.6, '2024-07-12', 4, NULL, 'Payment Overdue'),
(63, 1000, 500, 35308, '2024-07-13', 2, NULL, 'Payment Overdue'),
(64, 1000, 500, 35366.5, '2024-07-13', 1, NULL, 'Payment Overdue'),
(77, 531320, 2981, 534301, '2024-07-13', 2, NULL, 'Payment Overdue'),
(78, 2130, 1716, 3846, '2024-07-13', 2, NULL, 'Payment Overdue'),
(81, 50000, 2981, 52981, '2024-07-13', 1, NULL, 'Payment Overdue'),
(82, 50000, 38500, 88500, '2024-07-14', 1, NULL, 'Payment Overdue'),
(83, 50000, 1100, 51100, '2024-07-13', 1, NULL, 'Payment Overdue'),
(86, 12310, 17176.5, 29486.5, '2024-07-13', 2, NULL, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_number` int(11) NOT NULL,
  `availability` varchar(20) NOT NULL,
  `roomRentalFee` float NOT NULL,
  `servicesID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_number`, `availability`, `roomRentalFee`, `servicesID`) VALUES
(101, 'Occupied', 6500, 1),
(102, 'Occupied', 6500, 2),
(103, 'Occupied', 6500, 3),
(104, 'Occupied', 6500, 4),
(105, 'Occupied', 6500, 5),
(106, 'Occupied', 6500, 6),
(107, 'Occupied', 6500, 7),
(108, 'Occupied', 6500, 8),
(109, 'Occupied', 6500, 9),
(201, 'Occupied', 6500, 10),
(202, 'Occupied', 6500, 11),
(203, 'Occupied', 6500, 12),
(204, 'Occupied', 6500, 13),
(205, 'Occupied', 6500, 14),
(206, 'Occupied', 6500, 15),
(207, 'Occupied', 6500, 16),
(208, 'Occupied', 6500, 17),
(209, 'Occupied', 6500, 18),
(301, 'Occupied', 6500, 19),
(302, 'Occupied', 6500, 20),
(303, 'Occupied', 6500, 21),
(304, 'Occupied', 6500, 22),
(305, 'Occupied', 6500, 23),
(306, 'Occupied', 6500, 24),
(307, 'Occupied', 6500, 25),
(308, 'Vacant', 6500, 26),
(309, 'Vacant', 6500, 27),
(401, 'Vacant', 6500, 28),
(402, 'Vacant', 6500, 29),
(403, 'Vacant', 6500, 30),
(404, 'Vacant', 6500, 31),
(405, 'Vacant', 6500, 32),
(406, 'Vacant', 6500, 33),
(407, 'Vacant', 6500, 34),
(408, 'Vacant', 6500, 35),
(409, 'Vacant', 6500, 36);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `electricitybaseprice` float NOT NULL,
  `electricity` float NOT NULL,
  `waterbaseprice` float NOT NULL,
  `water` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `electricitybaseprice`, `electricity`, `waterbaseprice`, `water`) VALUES
(1, 20, 12345, 10, 1234),
(2, 20, 1231, 10, 3123),
(3, 20, 6000, 10, 330),
(4, 20, 1490.42, 10, 210.18),
(5, 20, 3010.32, 10, 290.13),
(6, 20, 2800.21, 10, 1200.09),
(7, 20, 700.07, 10, 300.03),
(8, 20, 2010.14, 10, 290.06),
(9, 20, 2560.28, 10, 240.12),
(10, 20, 1940.24, 10, 260.105),
(11, 20, 2420.35, 10, 180.15),
(12, 20, 1490.42, 10, 210.18),
(13, 20, 2940.49, 10, 260.21),
(14, 20, 3770.56, 10, 330.24),
(15, 20, 800.63, 10, 200.27),
(16, 20, 1870, 10, 230),
(17, 20, 2390.07, 10, 310.03),
(18, 20, 2250.14, 10, 250.06),
(19, 20, 2180.21, 10, 220.09),
(20, 20, 1560.28, 10, 240.12),
(21, 20, 2800.35, 10, 200.15),
(22, 20, 1040.42, 10, 160.18),
(23, 20, 1940.49, 10, 260.21),
(24, 20, 2320.56, 10, 280.24),
(25, 20, 1490.63, 10, 210.27),
(26, 20, 2630, 10, 270),
(27, 20, 770.07, 10, 330.03),
(28, 20, 1940.14, 10, 260.06),
(29, 20, 2320.21, 10, 280.09),
(30, 20, 1490.28, 10, 210.12),
(31, 20, 3250, 10, 250),
(32, 20, 2010.63, 10, 290.27),
(33, 20, 2840.56, 10, 360.24),
(34, 20, 5000, 10, 330),
(35, 20, 1630.42, 10, 270.18),
(36, 20, 1870.35, 10, 230.15);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `tenantID` int(11) NOT NULL,
  `fName` text NOT NULL,
  `lName` text NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `contact_number` text NOT NULL,
  `landlordID` int(11) DEFAULT NULL,
  `room_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`tenantID`, `fName`, `lName`, `age`, `gender`, `date_of_birth`, `email`, `password`, `contact_number`, `landlordID`, `room_number`) VALUES
(1, 'Maya ', 'Ty', 20, 'F', '2004-01-18', 'mayaty@gmail.com', '$2y$10$jkN.vBt1wWF5AFCL2uqkiuZnTM7s7GF3whl5AUa2t3.N5M3r03fzS', '9123456789', 2, 101),
(2, 'Summi', 'Derama', 19, 'F', '2004-04-13', 'summiderama@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '9223456789', 2, 102),
(3, 'John', 'Codilla', 20, 'M', '2004-05-20', 'johncodilla@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '9133456789', 2, 103),
(4, 'Jer ', 'Bayot', 20, 'M', '2004-07-02', 'jerandreou@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '9233456789', 2, 104),
(5, 'Joshua', 'Dajao', 20, 'M', '2004-06-21', 'joshuadajao@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '9143456789', 2, 105),
(6, 'Jane', 'Castillo', 21, 'F', NULL, 'janesmith@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09153456006', 2, 106),
(7, 'Michael', 'Francisco', 22, 'M', NULL, 'michaelbrown@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09253456007', 2, 107),
(8, 'Sarah', 'Rivera', 20, 'F', NULL, 'sarahlee@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09163456008', 2, 108),
(9, 'David', 'Aquino', 23, 'M', NULL, 'davidgarcia@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09263456009', 2, 109),
(10, 'Emily', 'Castro', 20, 'F', NULL, 'emilymartinez@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09173456010', 2, 201),
(11, 'Matthew', 'Sánchez', 24, 'M', NULL, 'matthewlopez@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09273456011', 2, 202),
(12, 'Olivia', 'Torres', 20, 'F', NULL, 'oliviagonzalez@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09183456012', 2, 203),
(13, 'Daniel', 'de León', 25, 'M', NULL, 'danielrodriguez@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09283456013', 2, 204),
(14, 'Sophia', 'Domingo', 20, 'F', NULL, 'sophiaperez@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09193456014', 2, 205),
(15, 'Alexander', 'Martínez', 26, 'M', NULL, 'alexanderwilson@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09293456015', 2, 206),
(16, 'Isabella', 'Rodríguez', 20, 'F', NULL, 'isabellamoore@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09203456016', 2, 207),
(17, 'Ethan', 'Santiago', 27, 'M', NULL, 'ethantaylor@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09203456017', 2, 208),
(18, 'Mia', 'Soriano', 20, 'F', NULL, 'miajackson@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09213456018', 2, 209),
(19, 'James', 'delos Santos', 28, 'M', NULL, 'jameswhite@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09213456019', 2, 301),
(20, 'Ava', 'Díaz', 20, 'F', NULL, 'avaharris@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09223456020', 2, 302),
(21, 'Benjamin', 'Hernández', 29, 'M', NULL, 'benjaminmartin@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09223456021', 2, 303),
(22, 'Charlotte', 'Tolentino', 20, 'F', NULL, 'charlottethompson@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09233456022', 2, 304),
(23, 'William', 'Valdez', 30, 'M', NULL, 'williamgarcia@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09233456023', 2, 305),
(24, 'Amelia', 'Ramírez', 20, 'F', NULL, 'ameliamartinez@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09243456024', 2, 306),
(25, 'Daniel', 'Morales', 31, 'M', NULL, 'danielrobinson@gmail.com', '$2a$04$5iaxXzTWrKcjCx0BzmIyAurSt3Gy8Untd0YC0Ch.ypnE.RCt4mEJi', '09243456025', 2, 307);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `landlord`
--
ALTER TABLE `landlord`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`reference_number`),
  ADD KEY `landlordID` (`landlordID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_number`),
  ADD KEY `fk_utilityID` (`servicesID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`tenantID`),
  ADD KEY `fk_landlordID` (`landlordID`),
  ADD KEY `fk_room_number` (`room_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `landlord`
--
ALTER TABLE `landlord`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `reference_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `tenantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`landlordID`) REFERENCES `landlord` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_utilityID` FOREIGN KEY (`servicesID`) REFERENCES `services` (`id`);

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `fk_landlordID` FOREIGN KEY (`landlordID`) REFERENCES `landlord` (`id`),
  ADD CONSTRAINT `fk_room_number` FOREIGN KEY (`room_number`) REFERENCES `rooms` (`room_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
