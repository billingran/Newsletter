-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2023 at 11:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsletter`
--

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int NOT NULL,
  `interest` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `interest`) VALUES
(1, 'Peinture'),
(2, 'Sculpture'),
(3, 'Photographie'),
(4, 'Art contemporain'),
(5, 'Films'),
(6, 'Art numérique'),
(7, 'Installations');

-- --------------------------------------------------------

--
-- Table structure for table `origins`
--

CREATE TABLE `origins` (
  `id` int NOT NULL,
  `original_label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `origins`
--

INSERT INTO `origins` (`id`, `original_label`) VALUES
(1, 'Un ami m’en a parlé'),
(2, 'Recherche sur internet'),
(3, 'Publicité dans un magazine');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `date_time` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `original_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `date_time`, `email`, `firstname`, `lastname`, `original_id`) VALUES
(1, '2023-02-14 12:05:26', 'alfred.dupont@gmail.com', 'Alfred', 'Dupont', NULL),
(2, '2023-02-14 12:05:26', 'b.lav@hotmail.fr', 'Bertrand', 'Lavoisier', NULL),
(3, '2023-02-14 12:05:26', 'sarahlamine@gmail.com', 'Sarah', 'Lamine', NULL),
(4, '2023-02-14 12:05:26', 'mo78@laposte.net', 'Mohamed', 'Ben salam', NULL),
(5, '2023-02-14 12:13:19', 'billingran@gmail.com', 'teng-wei', 'Huang', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers_interests`
--

CREATE TABLE `subscribers_interests` (
  `subscribers_id` int NOT NULL,
  `interests_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `subscribers_interests`
--

INSERT INTO `subscribers_interests` (`subscribers_id`, `interests_id`) VALUES
(5, 4),
(5, 5),
(5, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `origins`
--
ALTER TABLE `origins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `link_original_id` (`original_id`) USING BTREE;

--
-- Indexes for table `subscribers_interests`
--
ALTER TABLE `subscribers_interests`
  ADD KEY `link_interests_id` (`interests_id`),
  ADD KEY `link_subscribers_id` (`subscribers_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `origins`
--
ALTER TABLE `origins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD CONSTRAINT `link_original_id` FOREIGN KEY (`original_id`) REFERENCES `origins` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `subscribers_interests`
--
ALTER TABLE `subscribers_interests`
  ADD CONSTRAINT `link_interests_id` FOREIGN KEY (`interests_id`) REFERENCES `interests` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `link_subscribers_id` FOREIGN KEY (`subscribers_id`) REFERENCES `subscribers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
