-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2024 at 12:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nodeticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'admin2', '$2b$10$AZ8CqM5xrmMj9qYYq3bsfezStc9SnhdQM6709R.74Q6VLvwORezla');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `event_id`, `name`, `email`, `quantity`, `created_at`) VALUES
(4, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:32:05'),
(5, 1, 'Mayank Kumar Shrivastva', 'fghgfmghy@gmail', 1, '2024-05-24 15:36:40'),
(6, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:47:35'),
(7, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:49:13'),
(8, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 15:49:28'),
(9, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 15:49:45'),
(10, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 15:50:09'),
(11, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:51:53'),
(12, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 15:51:59'),
(13, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:53:56'),
(14, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:53:59'),
(15, 1, 'mayank', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:56:25'),
(16, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:57:12'),
(17, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 15:57:43'),
(18, 1, 'mayank', 'shrivastva.mayank27@gmail.com', 5, '2024-05-24 16:02:49'),
(19, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 5, '2024-05-24 16:03:10'),
(20, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 5, '2024-05-24 16:03:14'),
(21, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 5, '2024-05-24 16:03:18'),
(22, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 5, '2024-05-24 16:03:42'),
(23, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 16:04:35'),
(24, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 16:05:11'),
(25, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 16:07:06'),
(26, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 16:07:12'),
(27, 2, 'Maynak Kumar', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 17:02:08'),
(28, 1, 'Maynak Kumar', 'shrivastva.mayank27@gmail.com', 4, '2024-05-24 17:06:24'),
(29, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-24 17:09:36'),
(30, 2, 'mayank', 'shrivastva.mayank27@gmail.com', 5, '2024-05-24 18:01:59'),
(31, 1, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 3, '2024-05-25 05:11:04'),
(32, 3, 'Maynak Kumar', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:13:30'),
(33, 3, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:15:08'),
(34, 3, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:16:14'),
(35, 3, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:17:10'),
(36, 3, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:20:05'),
(37, 3, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:22:08'),
(38, 3, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 4, '2024-05-25 06:22:15'),
(39, 3, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:23:21'),
(40, 4, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:23:35'),
(41, 4, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:25:13'),
(42, 0, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 0, '2024-05-25 06:26:49'),
(43, 4, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:28:43'),
(44, 4, 'Mayank Kumar Shrivastva', 'shrivastva.mayank27@gmail.com', 1, '2024-05-25 06:30:08'),
(45, 1, 'Mayank Kumar Shrivastva', 'mayank14072002@gmail.com', 1, '2024-05-25 06:54:15'),
(46, 1, 'Mayank Kumar Shrivastva', 'admin2', 1, '2024-05-25 10:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `event-information`
--

CREATE TABLE `event-information` (
  `id` int(12) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start-time` time NOT NULL,
  `End-time` time NOT NULL,
  `available` int(30) NOT NULL,
  `remaining-ticket` int(40) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event-information`
--

INSERT INTO `event-information` (`id`, `Title`, `date`, `start-time`, `End-time`, `available`, `remaining-ticket`, `venue`, `Price`) VALUES
(1, 'Tech Conference 2024', '0000-00-00', '09:00:00', '17:00:00', 15, 6, 'Convention Center A', 100),
(2, 'Art Exhibition', '2024-07-20', '10:00:00', '18:00:00', 200, 194, 'City Art Gallery', 150),
(3, 'Music Festival', '2024-08-05', '12:00:00', '22:00:00', 10, 0, 'Central Park', 200);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'shrivastva.mayank27@gmail.com', '$2b$10$Td5RImOqxy/kOdCv.AhnmOONDoR9JFqM9bKl66rl2w64Ynox/9lQe'),
(3, 'testing@gmail.com', '$2b$10$A0HehyfWgpivFPwoHOmTJ.10nrbz/mTvoxO93/v/vKpQ78hrJdhxq'),
(4, '', ''),
(5, '', ''),
(6, 'admin', '$2b$10$U2p8fnth5zVh9phf8.RbTeQ08icqhZzS7AgGCBiZ3iL9Qp7bY2brK'),
(7, 'admin2', '$2b$10$ycybaVAQ/I10F2JO3rx/0.fLbTajpFsyLNSC6CNH63lZpZept/OoS'),
(8, 'mayank14072002@gmail.com', '$2b$10$.5DbsnR3oOv9jGGLPVxN9O8c3xmer0rl/F4IiwyqAMLt5XJlhoTtG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event-information`
--
ALTER TABLE `event-information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `event-information`
--
ALTER TABLE `event-information`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
