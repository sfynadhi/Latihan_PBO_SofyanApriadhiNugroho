-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2026 at 06:12 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_latihan_pbo_trpl1a_sofyanapriadhinugroho`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_tiket`
--

CREATE TABLE `tabel_tiket` (
  `id_tiket` int NOT NULL,
  `nama_film` varchar(255) NOT NULL,
  `jadwal_tayang` datetime NOT NULL,
  `jumlah_kursi` int NOT NULL,
  `harga_dasar_tiket` decimal(10,2) NOT NULL,
  `jenis_studio` enum('Regular','IMAX','Velvet') NOT NULL,
  `tipe_audio` varchar(50) DEFAULT NULL,
  `lokasi_baris` varchar(10) DEFAULT NULL,
  `kacamata_3d_id` varchar(50) DEFAULT NULL,
  `efek_gerak_fitur` varchar(100) DEFAULT NULL,
  `bantal_selimut_pack` varchar(50) DEFAULT NULL,
  `layanan_butler` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_tiket`
--

INSERT INTO `tabel_tiket` (`id_tiket`, `nama_film`, `jadwal_tayang`, `jumlah_kursi`, `harga_dasar_tiket`, `jenis_studio`, `tipe_audio`, `lokasi_baris`, `kacamata_3d_id`, `efek_gerak_fitur`, `bantal_selimut_pack`, `layanan_butler`) VALUES
(1, 'The Batman', '2026-06-15 13:00:00', 1, 45000.00, 'Regular', 'Dolby Digital 5.1', 'Row G', NULL, NULL, NULL, NULL),
(2, 'The Batman', '2026-06-15 13:00:00', 1, 45000.00, 'Regular', 'Dolby Digital 5.1', 'Row G', NULL, NULL, NULL, NULL),
(3, 'Avatar 3', '2026-06-15 15:30:00', 1, 50000.00, 'Regular', 'Dolby Atmos', 'Row E', NULL, NULL, NULL, NULL),
(4, 'Avatar 3', '2026-06-15 15:30:00', 1, 50000.00, 'Regular', 'Dolby Atmos', 'Row E', NULL, NULL, NULL, NULL),
(5, 'Spiderman', '2026-06-16 19:00:00', 1, 45000.00, 'Regular', 'Standard Stereo', 'Row F', NULL, NULL, NULL, NULL),
(6, 'Spiderman', '2026-06-16 19:00:00', 1, 45000.00, 'Regular', 'Standard Stereo', 'Row F', NULL, NULL, NULL, NULL),
(7, 'Inception', '2026-06-16 21:30:00', 1, 45000.00, 'Regular', 'Dolby Digital 5.1', 'Row C', NULL, NULL, NULL, NULL),
(8, 'Interstellar', '2026-06-15 14:00:00', 1, 95000.00, 'IMAX', 'IMAX 6-Track', 'Row A', '3D-IMAX-001', 'Laser Projection', NULL, NULL),
(9, 'Interstellar', '2026-06-15 14:00:00', 1, 95000.00, 'IMAX', 'IMAX 6-Track', 'Row A', '3D-IMAX-002', 'Laser Projection', NULL, NULL),
(10, 'Dune: Part Two', '2026-06-15 18:00:00', 1, 100000.00, 'IMAX', 'IMAX 12-Channel', 'Row B', '3D-IMAX-045', 'Dual Laser 4K', NULL, NULL),
(11, 'Dune: Part Two', '2026-06-15 18:00:00', 1, 100000.00, 'IMAX', 'IMAX 12-Channel', 'Row B', '3D-IMAX-046', 'Dual Laser 4K', NULL, NULL),
(12, 'The Matrix', '2026-06-17 13:00:00', 1, 95000.00, 'IMAX', 'IMAX 6-Track', 'Row D', '3D-IMAX-102', 'Standard IMAX', NULL, NULL),
(13, 'The Matrix', '2026-06-17 13:00:00', 1, 95000.00, 'IMAX', 'IMAX 6-Track', 'Row D', '3D-IMAX-103', 'Standard IMAX', NULL, NULL),
(14, 'Avengers', '2026-06-17 16:30:00', 1, 100000.00, 'IMAX', 'IMAX 12-Channel', 'Row C', '3D-IMAX-088', 'Dual Laser 4K', NULL, NULL),
(15, 'Titanic', '2026-06-15 20:00:00', 2, 25000.00, 'Velvet', NULL, 'Sofa A1', NULL, NULL, 'Premium Pack A', 'Personal Butler - Andi'),
(16, 'Titanic', '2026-06-15 20:00:00', 2, 25000.00, 'Velvet', NULL, 'Sofa A2', NULL, NULL, 'Premium Pack A', 'Personal Butler - Andi'),
(17, 'La La Land', '2026-06-16 16:00:00', 2, 220000.00, 'Velvet', NULL, 'Sofa B1', NULL, NULL, 'Standard Pack B', 'On-Call Butler'),
(18, 'La La Land', '2026-06-16 16:00:00', 2, 220000.00, 'Velvet', NULL, 'Sofa B2', NULL, NULL, 'Standard Pack B', 'On-Call Butler'),
(19, 'Gladiator 2', '2026-06-17 19:30:00', 2, 250000.00, 'Velvet', NULL, 'Sofa C1', NULL, NULL, 'Premium Pack VIP', 'Personal Butler - Sinta'),
(20, 'Gladiator 2', '2026-06-17 19:30:00', 2, 250000.00, 'Velvet', NULL, 'Sofa C2', NULL, NULL, 'Premium Pack VIP', 'Personal Butler - Sinta'),
(21, 'The Godfather', '2026-06-18 20:00:00', 2, 220000.00, 'Velvet', NULL, 'Sofa D1', NULL, NULL, 'Standard Pack C', 'On-Call Butler');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_tiket`
--
ALTER TABLE `tabel_tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
