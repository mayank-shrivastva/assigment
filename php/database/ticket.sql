-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2024 at 02:48 PM
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
-- Database: `ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(1, 'mk', '$2y$10$7uxswcaG4Vdxl8pSQE0Z/O1rrkPm3M.T1bgXC8BNElsNUZD438laO', 'shrivastva.mayank27@gmail.com'),
(2, 'mk', '$2y$10$vW6j6bvJCBEZbRdUuHsd6uNcgI9OmarSZG1jSJKxFB3L/YGiivF.a', 'mayank14072002@gmail.com'),
(3, 'admin', '$2y$10$Pj8Oqv1g20aPjYJcRtgOxuUApj7pgRr4r1we/bbgsMge0eVVIazAa', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tickets` int(11) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `event_id`, `name`, `email`, `tickets`, `booking_id`, `booking_time`) VALUES
(8, 3, 'Maynak Kumar shrivastva', 'shrivastva.mayank27@gmail.com', 5, '6650884043470', '2024-05-24 12:29:52'),
(9, 3, 'Maynak Kumar shrivastva', 'shrivastva.mayank27@gmail.com', 1, '6650884b4296a', '2024-05-24 12:30:03'),
(10, 1, 'Maynak Kumar shrivastva', 'shrivastva.mayank27@gmail.com', 4, '6651c66821b7a', '2024-05-25 11:07:20'),
(12, 1, 'Maynak Kumar', 'shrivastva.mayank27@gmail.com', 3, '6651dd4dca94c', '2024-05-25 12:45:01');

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
  `venue` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event-information`
--

INSERT INTO `event-information` (`id`, `Title`, `date`, `start-time`, `End-time`, `available`, `venue`, `Price`) VALUES
(1, 'Tech Conference 2024', '2024-06-15', '09:00:00', '17:00:00', 15, 'Convention Center A', 100),
(2, 'Art Exhibition', '2024-07-20', '10:00:00', '18:00:00', 200, 'City Art Gallery', 150),
(3, 'Music Festival', '2024-08-05', '12:00:00', '22:00:00', 10, 'Central Park', 200),
(4, 'Business Networking Event', '2024-09-10', '18:00:00', '21:00:00', 100, 'Hotel Grand Ballroom', 100);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`) VALUES
(5, 'amansaxena_dcs2', '', 'shrivastva.mayank2@gmail.com'),
(6, 'amansaxena_dcs20', '', 'shrivastva.mayank27@gmail.com'),
(7, 'mayankkumarshr#cs21', '', 'mayank14072003@gmail.com'),
(8, 'mayank', '$2y$10$BRPqvIbSk3B5fz1NvqCv3ekepmaS4FKwMqwmai0471ldgz05ylMrS', 'shrivastva.mayank27@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event-information`
--
ALTER TABLE `event-information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event-information`
--
ALTER TABLE `event-information`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
