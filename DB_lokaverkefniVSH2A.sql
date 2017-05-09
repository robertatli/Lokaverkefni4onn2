-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 09, 2017 at 11:22 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1802992039_v5`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `image_name` varchar(45) NOT NULL,
  `image_path` varchar(25) NOT NULL,
  `image_text` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `owner_id`, `image_name`, `image_path`, `image_text`) VALUES
(1, 1, 'Kisa', 'kisa.jpg', 'Konni á kisu.'),
(2, 1, 'Gullfiskur', 'gulli.jpg', 'Konni átti Gullfisk.'),
(3, 1, 'wow', 'wow.png', 'wow'),
(4, 1, 'hestur', 'hestur.jpg', 'mynd af hest.'),
(5, 1, 'Earth', 'world.jpg', 'Mynd af Jörðinni'),
(6, 1, 'teningur', 'teningur.jpg', 'mynd af tening\r\n'),
(7, 1, 'gírafi', 'Giraffes.jpg', 'mynd af gírafa');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `email` varchar(125) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`) VALUES
(1, 'Konráð Valsson', 'konnichiva@picturebase.xxx', 'konni59', 'Y7B62Dr0jJ'),
(2, 'Anna Káradóttir', 'annsy@fakemail.us', 'annakarXXX', 'Al04Jut6'),
(5, 'robertatlisvavarsson', 'robertatlis@gmail.com', 'robertatli', '$2y$10$gOxuMbaDOxwq2s56HeIVcOMOklGnTOq6wkPauAbWww4jw9tEYVLKK'),
(6, 'Róbert Atli Svavarsson', 'robbster10@gmail.com', 'robertatliasd', '$2y$10$tA73vGjZ21ujVW3d5Sf2yOfT2MukO.NE9WuIi6DsRKi7UodXj76KK'),
(9, 'robertatlisvav', 'robbster@gmail.com', 'robbster', '$2y$10$.AsymW.RCDnAk..9Qv8sae3wzaflLPAG76akinOsNWoWFpCD4d44C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `useremail_NQ` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
