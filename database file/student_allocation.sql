-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 02:36 PM
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
-- Database: `student_allocation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `staffNo` varchar(8) NOT NULL,
  `pin` varchar(5) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL DEFAULT 'Housing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `staffNo`, `pin`, `fname`, `lname`, `department`) VALUES
(1, '12345678', '1234', 'John', 'Doe', 'Housing'),
(2, '87654321', '5678', 'Jane', 'Smith', 'Housing'),
(3, '11223344', '9012', 'Michael', 'Johnson', 'Housing'),
(4, '66778899', '3456', 'Emily', 'Wilson', 'Housing'),
(5, '22334455', '7890', 'David', 'Brown', 'Housing');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `studentNumber` varchar(20) NOT NULL,
  `residenceId` varchar(20) NOT NULL,
  `resName` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `levelOfStudy` varchar(50) NOT NULL,
  `roomNumber` varchar(255) NOT NULL,
  `roomType` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `studentNumber`, `residenceId`, `resName`, `status`, `levelOfStudy`, `roomNumber`, `roomType`, `date_created`) VALUES
(1, '19013688', 'UNV71997', 'f3', 'approved', '3', '', '', '2024-04-17 23:18:07'),
(6, '87654321', 'UNV24312', 'Maphula Res', 'pending', '1', '', '', '2024-04-18 08:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `residences`
--

CREATE TABLE `residences` (
  `id` int(11) NOT NULL,
  `residenceId` varchar(10) NOT NULL,
  `resName` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `location` varchar(100) NOT NULL,
  `rooms` int(11) NOT NULL,
  `singlesRoom` int(11) NOT NULL,
  `doubleRoom` int(11) NOT NULL,
  `buses` tinyint(1) NOT NULL,
  `extras` text DEFAULT NULL,
  `mainImage` varchar(200) NOT NULL,
  `otherImages` text DEFAULT NULL,
  `rules` text DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `residences`
--

INSERT INTO `residences` (`id`, `residenceId`, `resName`, `address`, `location`, `rooms`, `singlesRoom`, `doubleRoom`, `buses`, `extras`, `mainImage`, `otherImages`, `rules`, `contact`, `date_created`) VALUES
(1, 'UNV24312', 'Maphula Res', 'P.O.Box 145  Thohoyandou  0950', 'Thohoyandou', 30, 13, 16, 1, '0', 'uploads/Maphula.jpg', 'uploads/IMG-20220223-WA0137.jpg,uploads/IMG-20220223-WA0143.jpg,uploads/IMG-20220223-WA0145.jpg,uploads/IMG-20220223-WA0151.jpg', 'no smoking', '12345678', '2024-04-17 17:20:28'),
(3, 'UNV24313', 'Beverly', 'P.O.Box 145  Thohoyandou  0950', 'Thohoyandou', 30, 13, 16, 1, '0', 'uploads/Maphula.jpg', 'uploads/IMG-20220223-WA0137.jpg,uploads/IMG-20220223-WA0143.jpg,uploads/IMG-20220223-WA0145.jpg,uploads/IMG-20220223-WA0151.jpg', 'no smoking', '', '2024-04-17 17:20:04'),
(4, 'UNV71997', 'f3', 'Thohoyandou, Univen', 'Univen', 60, 29, 31, 1, '0', 'uploads/Univen-F3-Student-Residence.jpg', 'uploads/', 'no sex', '', '2024-04-17 17:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `studentNumber` varchar(8) NOT NULL,
  `pin` varchar(5) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `levelOfStudy` int(11) NOT NULL CHECK (`levelOfStudy` <= 3),
  `degreeCode` varchar(10) NOT NULL,
  `Contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `studentNumber`, `pin`, `fname`, `lname`, `degree`, `levelOfStudy`, `degreeCode`, `Contact`) VALUES
(1, '19013688', '1234', 'Arnold', 'Masutha', 'Bachelor of Science', 3, 'BSC', '0123456789'),
(2, '87654321', '5678', 'Jane', 'Smith', 'Bachelor of Arts', 1, 'BA', '9876543210'),
(3, '11223344', '9012', 'Michael', 'Johnson', 'Bachelor of Commerce', 3, 'BCom', '5555555555'),
(4, '66778899', '3456', 'Emily', 'Wilson', 'Bachelor of Engineering', 2, 'BEng', '1234567890'),
(5, '22334455', '7890', 'David', 'Brown', 'Bachelor of Education', 1, 'BEd', '0987654321'),
(6, '44556677', '1234', 'Sarah', 'Taylor', 'Bachelor of Science', 3, 'BSC', '6789012345'),
(7, '88990011', '5678', 'Daniel', 'Anderson', 'Bachelor of Arts', 2, 'BA', '2345678901'),
(8, '33445566', '9012', 'Olivia', 'Thomas', 'Bachelor of Commerce', 1, 'BCom', '8901234567'),
(9, '12345678', '12345', 'rosinah', 'Thomas', 'Bachelor of Commerce', 1, 'BCom', '8901234576');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staffNo` (`staffNo`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residences`
--
ALTER TABLE `residences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `residenceId` (`residenceId`),
  ADD UNIQUE KEY `idx_residenceId` (`residenceId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studentNumber` (`studentNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `residences`
--
ALTER TABLE `residences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
