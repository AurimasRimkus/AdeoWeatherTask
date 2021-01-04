-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2021 m. Sau 04 d. 16:30
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adeotask`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201231000840', '2020-12-31 01:13:01', 349),
('DoctrineMigrations\\Version20210102200459', '2021-01-02 21:05:10', 187),
('DoctrineMigrations\\Version20210103135725', '2021-01-03 14:57:33', 396);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `weather` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Sukurta duomenų kopija lentelei `product`
--

INSERT INTO `product` (`id`, `name`, `sku`, `price`, `weather`) VALUES
(1, 'Black Umbrella', 'UM-1', 10.33, 'a:3:{i:0;s:4:\"rain\";i:1;s:13:\"moderate-rain\";i:2;s:10:\"light-rain\";}'),
(2, 'Pink Hat', 'HAT-15', 7.22, 'a:3:{i:0;s:4:\"rain\";i:1;s:5:\"windy\";i:2;s:5:\"clear\";}'),
(3, 'Synergistic Leather Hat', 'HAT-16', 19.22, 'a:2:{i:0;s:5:\"sunny\";i:1;s:5:\"clear\";}'),
(4, 'Fullcap', 'HAT-66', 34.17, 'a:2:{i:0;s:5:\"sunny\";i:1;s:5:\"clear\";}'),
(5, 'Warm jacket', 'WINTER-5', 65.17, 'a:2:{i:0;s:4:\"snow\";i:1;s:10:\"light-snow\";}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
