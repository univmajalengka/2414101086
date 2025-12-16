-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 03:53 AM
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
-- Database: `wisata_rajaampat`
--

-- --------------------------------------------------------

--
-- Table structure for table `paket_wisata`
--

CREATE TABLE `paket_wisata` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `gambar_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_wisata`
--

INSERT INTO `paket_wisata` (`id`, `nama_paket`, `deskripsi`, `harga`, `gambar_url`, `video_url`, `created_at`) VALUES
(1, 'Paket Snorkeling', 'Paket snorkeling 2 tempat', 2500000, 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80', 'https://www.youtube.com/embed/GPt07Cw02ac', '2025-12-15 14:57:57'),
(2, 'Paket Diving', 'Paket diving 3 tempat', 5500000, 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgMDAU1ZwtIP0Y3xcIeGRazonKOx5ZS_PI7q9xw-Thdcaol46lRZ3l6NKR9jjy90LdaSZGct37Xr0Qx6_4feWdXa2J7gygQSgJRMbNqv7Fg6X5-wn9qaqs6L_IfG76kVIu3xKDNSWVwMsco2YJknZK4Ycn1t0VcqtBgWeqqFF3T3fgKHzLff4dwrPhG/s500/7%20', 'https://www.youtube.com/embed/y1yrBLy3z1U', '2025-12-15 14:57:57'),
(3, 'Paket Eksplorasi', 'Melakukan Eksplorasi ke 5 tempat di Raja ampat', 7500000, 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80', 'https://www.youtube.com/embed/UJiVARkYs0c', '2025-12-15 14:57:57');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `tanggal_pesan` date NOT NULL,
  `waktu_pelaksanaan` date NOT NULL,
  `penginapan` tinyint(1) DEFAULT 0,
  `transportasi` tinyint(1) DEFAULT 0,
  `service_makan` tinyint(1) DEFAULT 0,
  `jumlah_peserta` int(11) NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `harga_paket` int(11) NOT NULL,
  `jumlah_tagihan` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama_pemesan`, `nomor_hp`, `tanggal_pesan`, `waktu_pelaksanaan`, `penginapan`, `transportasi`, `service_makan`, `jumlah_peserta`, `jumlah_hari`, `harga_paket`, `jumlah_tagihan`, `created_at`) VALUES
(3, 'Riziq', '089997823', '2025-12-16', '2025-12-30', 1, 0, 0, 2, 1, 4000000, 8000000, '2025-12-16 02:28:01'),
(4, 'Nasgor', '088889334', '2025-12-16', '2025-12-30', 0, 1, 0, 1, 1, 8000000, 8000000, '2025-12-16 02:29:17'),
(5, 'contoh', '1231244', '2025-12-16', '2025-12-30', 0, 0, 1, 1, 2, 8000000, 16000000, '2025-12-16 02:29:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paket_wisata`
--
ALTER TABLE `paket_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
