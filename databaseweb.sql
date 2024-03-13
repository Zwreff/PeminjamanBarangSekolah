-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2024 at 08:10 AM
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
-- Database: `databaseweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(15) DEFAULT NULL,
  `nama_brg` varchar(50) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_brg`, `kategori`, `merk`, `jumlah`) VALUES
(1, '90101', 'Bola Voli', 'Bola', 'Mikasa', 118),
(2, '90202', 'Bola Basket', 'Bola', 'Molten', 19),
(3, '10101', 'Laptop', 'Perangkat', 'Asus', 24),
(4, '10202', 'Macbook', 'Perangkat', 'Apple', 16),
(5, '20101', 'VGA', 'Kabel', 'M-Tech', 9),
(6, '20202', 'HDMI', 'Kabel', 'Vention', 9),
(7, '50101', 'Speaker', 'Alat Elektronik', 'Aukey', 5);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `kode_barang` varchar(15) DEFAULT NULL,
  `nis` varchar(12) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `kode_barang`, `nis`, `tanggal_pinjam`) VALUES
(8, '10101', '222316070059', '2024-03-10'),
(11, '90101', '222316070059', '2024-03-10'),
(12, '90101', '222316070059', '2024-03-10'),
(13, '90202', '222316070059', '2024-03-10'),
(19, '90202', '222316070059', '2024-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_login` int(11) NOT NULL,
  `nis` varchar(12) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_login`, `nis`, `nama`, `status`, `username`, `password`, `role`) VALUES
(1, '666666666666', 'DARK MAGICIAN ZEREF', 'Raja Iblis', 'admin', 'fae0b27c451c728867a567e8c1bb4e53', 'admin'),
(11, '222316070059', 'Muhammad Riefan', 'Pelajar XI PPLG 3', 'riefan', 'fae0b27c451c728867a567e8c1bb4e53', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `kode_barang` (`kode_barang`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`nis`) REFERENCES `users` (`nis`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
