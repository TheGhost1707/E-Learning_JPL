-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 08:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_learning_jpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `gambar_membaca`
--

CREATE TABLE `gambar_membaca` (
  `id_level` int(3) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `level` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gambar_membaca`
--

INSERT INTO `gambar_membaca` (`id_level`, `gambar`, `level`) VALUES
(4, '665d545aeef24_strawberry.png', 1),
(6, '665d590e3abc1_girl.png', 2),
(7, '665ff1f72d8b1_car.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `gambar_mendengar`
--

CREATE TABLE `gambar_mendengar` (
  `id_gambar` int(3) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `level` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gambar_menulis`
--

CREATE TABLE `gambar_menulis` (
  `id_gambar` int(3) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `level` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_membaca`
--

CREATE TABLE `task_membaca` (
  `id_level` int(3) NOT NULL,
  `id_task` int(3) NOT NULL,
  `jenis_task` varchar(20) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `jawaban_benar` varchar(30) NOT NULL,
  `jawaban_salah1` varchar(30) NOT NULL,
  `jawaban_salah2` varchar(30) NOT NULL,
  `jawaban_salah3` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_membaca`
--

INSERT INTO `task_membaca` (`id_level`, `id_task`, `jenis_task`, `nama`, `gambar`, `jawaban_benar`, `jawaban_salah1`, `jawaban_salah2`, `jawaban_salah3`) VALUES
(4, 13, 'Buah-Buahan', 'Semangka', '6660f58ba1fe6_watermelon.png', 'Suika', 'Kudamono', 'Ichigo', 'Gurappe'),
(4, 14, 'Buah-buahan', 'Apel', '666131174fc92_apple.png', 'Ringo', 'Suika', 'Ichigo', 'Gurappe');

-- --------------------------------------------------------

--
-- Table structure for table `task_mendengar`
--

CREATE TABLE `task_mendengar` (
  `id_task` int(3) NOT NULL,
  `jenis_task` varchar(20) NOT NULL,
  `level_task` int(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `audio` varchar(30) NOT NULL,
  `gambar_benar` varchar(30) NOT NULL,
  `gambar_salah1` varchar(30) NOT NULL,
  `gambar_salah2` varchar(30) NOT NULL,
  `gambar_salah3` varchar(30) NOT NULL,
  `progres_reward` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_penulisan`
--

CREATE TABLE `task_penulisan` (
  `id_gambar` int(3) NOT NULL,
  `id_task` int(3) NOT NULL,
  `jenis_task` varchar(20) NOT NULL,
  `level_task` int(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gambar` varchar(30) NOT NULL,
  `jawaban_benar` varchar(30) NOT NULL,
  `progres_reward` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `foto_profile` varchar(30) NOT NULL,
  `nama` char(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  `progres_level` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `foto_profile`, `nama`, `username`, `password`, `role`, `progres_level`) VALUES
(8, '665b8919bb518_DSCF0902.JPG', 'Syaqilla', 'Qilla', '123', 'Users', '0'),
(10, '665b8f47d52eb_kaneki.jpg', 'Akbar Maulana', 'Akbar', '123', 'Admin', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gambar_membaca`
--
ALTER TABLE `gambar_membaca`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `gambar_mendengar`
--
ALTER TABLE `gambar_mendengar`
  ADD PRIMARY KEY (`id_gambar`);

--
-- Indexes for table `gambar_menulis`
--
ALTER TABLE `gambar_menulis`
  ADD PRIMARY KEY (`id_gambar`);

--
-- Indexes for table `task_membaca`
--
ALTER TABLE `task_membaca`
  ADD PRIMARY KEY (`id_task`);

--
-- Indexes for table `task_mendengar`
--
ALTER TABLE `task_mendengar`
  ADD PRIMARY KEY (`id_task`);

--
-- Indexes for table `task_penulisan`
--
ALTER TABLE `task_penulisan`
  ADD PRIMARY KEY (`id_task`),
  ADD UNIQUE KEY `id_gambar` (`id_gambar`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gambar_membaca`
--
ALTER TABLE `gambar_membaca`
  MODIFY `id_level` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gambar_mendengar`
--
ALTER TABLE `gambar_mendengar`
  MODIFY `id_gambar` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gambar_menulis`
--
ALTER TABLE `gambar_menulis`
  MODIFY `id_gambar` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_membaca`
--
ALTER TABLE `task_membaca`
  MODIFY `id_task` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `task_mendengar`
--
ALTER TABLE `task_mendengar`
  MODIFY `id_task` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_penulisan`
--
ALTER TABLE `task_penulisan`
  MODIFY `id_task` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
