-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2025 at 04:38 PM
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
-- Database: `antrean_mlbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun_game`
--

CREATE TABLE `akun_game` (
  `ID_Game` int(7) NOT NULL,
  `ID_Penonton` int(7) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `foto_profile` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `ID_Antrian` int(7) NOT NULL,
  `ID_Penonton` int(7) NOT NULL,
  `Keterangan` varchar(500) NOT NULL,
  `urutan` int(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Tanggal` date NOT NULL,
  `Sesi` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foto_profile`
--

CREATE TABLE `foto_profile` (
  `id` int(3) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penonton`
--

CREATE TABLE `penonton` (
  `ID_Penonton` int(7) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `is_membership` tinyint(1) NOT NULL,
  `is_free` tinyint(1) NOT NULL,
  `role` varchar(100) NOT NULL,
  `total_MVP` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pertandingan`
--

CREATE TABLE `pertandingan` (
  `ID_Pertandingan` int(7) NOT NULL,
  `ID_Penonton` int(7) NOT NULL,
  `Partisipan` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `Sesi` smallint(6) NOT NULL,
  `is_win` tinyint(1) NOT NULL,
  `MVP` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(3) NOT NULL,
  `role` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `ID_Penonton` int(9) NOT NULL,
  `id_role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vip`
--

CREATE TABLE `vip` (
  `ID_VIP` int(7) NOT NULL,
  `ID_Penonton` int(7) NOT NULL,
  `is_Active` tinyint(1) NOT NULL,
  `Total` int(100) NOT NULL,
  `Sisa` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun_game`
--
ALTER TABLE `akun_game`
  ADD PRIMARY KEY (`ID_Game`),
  ADD KEY `ID_Penonton` (`ID_Penonton`),
  ADD KEY `foto_profile` (`foto_profile`);

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`ID_Antrian`),
  ADD KEY `ID_Penonton` (`ID_Penonton`);

--
-- Indexes for table `foto_profile`
--
ALTER TABLE `foto_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penonton`
--
ALTER TABLE `penonton`
  ADD PRIMARY KEY (`ID_Penonton`);

--
-- Indexes for table `pertandingan`
--
ALTER TABLE `pertandingan`
  ADD PRIMARY KEY (`ID_Pertandingan`),
  ADD KEY `ID_Penonton` (`ID_Penonton`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD KEY `ID_Penonton` (`ID_Penonton`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `vip`
--
ALTER TABLE `vip`
  ADD PRIMARY KEY (`ID_VIP`),
  ADD KEY `ID_Penonton` (`ID_Penonton`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun_game`
--
ALTER TABLE `akun_game`
  MODIFY `ID_Game` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `ID_Antrian` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foto_profile`
--
ALTER TABLE `foto_profile`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penonton`
--
ALTER TABLE `penonton`
  MODIFY `ID_Penonton` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pertandingan`
--
ALTER TABLE `pertandingan`
  MODIFY `ID_Pertandingan` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vip`
--
ALTER TABLE `vip`
  MODIFY `ID_VIP` int(7) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun_game`
--
ALTER TABLE `akun_game`
  ADD CONSTRAINT `akun_game_ibfk_1` FOREIGN KEY (`ID_Penonton`) REFERENCES `penonton` (`ID_Penonton`),
  ADD CONSTRAINT `akun_game_ibfk_2` FOREIGN KEY (`foto_profile`) REFERENCES `foto_profile` (`id`);

--
-- Constraints for table `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_ibfk_1` FOREIGN KEY (`ID_Penonton`) REFERENCES `penonton` (`ID_Penonton`);

--
-- Constraints for table `pertandingan`
--
ALTER TABLE `pertandingan`
  ADD CONSTRAINT `pertandingan_ibfk_1` FOREIGN KEY (`ID_Penonton`) REFERENCES `penonton` (`ID_Penonton`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`ID_Penonton`) REFERENCES `penonton` (`ID_Penonton`),
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);

--
-- Constraints for table `vip`
--
ALTER TABLE `vip`
  ADD CONSTRAINT `vip_ibfk_1` FOREIGN KEY (`ID_Penonton`) REFERENCES `penonton` (`ID_Penonton`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
