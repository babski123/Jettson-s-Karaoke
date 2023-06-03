-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2023 at 09:28 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videoke`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_codes`
--

CREATE TABLE `access_codes` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `access_codes`
--

INSERT INTO `access_codes` (`id`, `name`, `code`) VALUES
(1, 'babski', 'jettson123');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `vid` varchar(255) NOT NULL,
  `access_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `vid`, `access_name`) VALUES
(10, 'test1', 'test1', 'test1'),
(177, '[MAGICSING KARAOKE] SPONGE COLA_MAKAPILING KA KARAOKE | TAGALOG', 'N-ESned-dw4', 'babski'),
(178, 'DI NA MABABAWI - SPONGE COLA (KARAOKE VERSION)', 'ZD3qmtSZHTk', 'babski'),
(179, '[MAGICSING KARAOKE] SPONGE COLA_MAKAPILING KA KARAOKE | TAGALOG', 'ey6ouHZt9O0', 'babski'),
(180, 'SPONGECOLA - JEEPNEY (KARAOKE', 'N2PzZ5bq4qk', 'babski'),
(181, 'TULIRO - SPONGE COLA (KARAOKE VERSION)', 'a6pwTgDhnvI', 'babski'),
(182, 'GEMINI - SPONGE COLA (KARAOKE VERSION)', '1rS6bLmZBOI', 'babski'),
(183, 'KLSP - SPONGE COLA (KARAOKE VERSION)', 'LjHC1oKUI74', 'babski');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_codes`
--
ALTER TABLE `access_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_codes`
--
ALTER TABLE `access_codes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
