-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2026 at 02:59 AM
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
-- Database: `crud-php`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `nama`, `username`, `email`, `password`, `level`) VALUES
(1, 'admin', 'admin', 'rahmahawa@gmail.com', '$2y$10$.fjAVr8gVjPCCduCEq4jhuJ09itokx52jMpsoPNVcA3yQr76YuvTy', '1'),
(5, 'operator barang', 'operator barang', 'takardjm@gmail.com', '$2y$10$joMqwg4cJUuPy6goWx0uxO/aDehYnv.KQxsjUTJat5KckIWfMAwsG', '2'),
(6, 'operator mahasiswa', 'operator mahasiswa', 'rion@gmail.com', '$2y$10$q1jvAzvUxqHueVUUW9gFGexART/.aRdHz7nDnFMBtAmpPQqboYhd2', '3'),
(7, 'operator gudang', 'operator gudang', 'gudang01@gmail.com', '$2y$10$0T6ALyoO8LeNG.E5fTw7YeQ9wfEWp9m0TT2cpsvO57z9OHjvD/FEe', '2'),
(8, 'staff akademik', 'staff akademik', 'akademik01@gmail.com', '$2y$10$aP/EuFVXJQQP3NVQDLioHOV4zDtBFvVThHQqljzYN4GTHOlRy3LKq', '3'),
(9, 'admin cadangan', 'admin2', 'admincadangan@gmail.com', '$2y$10$nBsaxinN5UipuwN0Kbk7oeQGk3sY.UdDD5AyqRl3QBKhf3rIQqDIa', '1');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `barcode` varchar(15) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama`, `jumlah`, `harga`, `barcode`, `tanggal`) VALUES
(6, 'laptop', 5, 2500000, '193503', '2026-07-20 01:48:00'),
(7, 'pulpen', 50, 10000, '388869', '2026-07-21 02:05:51'),
(8, 'mouse wireless', 30, 85000, '104521', '2026-07-21 02:15:00'),
(9, 'keyboard mekanik', 15, 350000, '204873', '2026-07-21 03:30:00'),
(10, 'buku tulis', 100, 5000, '305612', '2026-07-22 01:00:00'),
(11, 'flashdisk 32gb', 40, 65000, '406789', '2026-07-22 04:45:00'),
(12, 'headset gaming', 12, 275000, '507134', '2026-07-22 07:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `prodi`, `jk`, `telepon`, `alamat`, `email`, `foto`) VALUES
(1, 'rahma khoyrul', 'Teknik Informatika', 'Perempuan', '089675543377', '', 'rahmahawa@gmail.com', 'foto.jpg'),
(2, 'sadewa sagara', 'Teknik Mesin', 'Laki-laki', '089654437766', '', 'sadewasgr@gmail.com', '6a573537eaa94.png'),
(5, 'bima wicaksana', 'Sistem Informasi', 'Laki-laki', '081234567890', 'Bandung', 'bimawicaksana@gmail.com', 'foto.jpg'),
(6, 'citra ayu lestari', 'Teknik Informatika', 'Perempuan', '082345678901', 'Semarang', 'citralestari@gmail.com', 'foto.jpg'),
(7, 'dimas prakoso', 'Teknik Elektro', 'Laki-laki', '083456789012', 'Surabaya', 'dimasprakoso@gmail.com', 'foto.jpg'),
(8, 'eka putri wijaya', 'Sistem Informasi', 'Perempuan', '084567890123', 'Malang', 'ekaputri@gmail.com', 'foto.jpg'),
(9, 'fajar nugroho', 'Teknik Mesin', 'Laki-laki', '085678901234', 'Solo', 'fajarnugroho@gmail.com', 'foto.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `jabatan`, `email`, `telepon`, `alamat`) VALUES
(1, 'nakula nalendra', 'direktur', 'nakula@gmail.com', '087654321654', 'yogyakarta'),
(2, 'arjuna arkana', 'wakil direktur', 'arjuna@gmail.com', '762345578765', 'palembang'),
(3, 'taka radjiman', 'kepala bidang humas', 'taka@gmail.com', '098765432123', 'bogor'),
(4, 'gita savitri', 'staff keuangan', 'gita@gmail.com', '081122334455', 'jakarta'),
(5, 'hendra kusuma', 'staff IT', 'hendra@gmail.com', '082233445566', 'bandung'),
(6, 'indah permata', 'kepala bidang akademik', 'indah@gmail.com', '083344556677', 'yogyakarta'),
(7, 'joko santoso', 'staff logistik', 'joko@gmail.com', '084455667788', 'surabaya'),
(8, 'kirana dewi', 'staff HRD', 'kirana@gmail.com', '085566778899', 'semarang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
