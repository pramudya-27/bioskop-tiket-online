-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 27, 2025 at 06:10 AM
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
-- Database: `bioskop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `password`, `foto`, `level`) VALUES
(3, 'admin', '0192023a7bbd73250516f069df18b500', '', 'admin'),
(4, 'manager', '1d0258c2440a8d19e716292b231e3190', '', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `dtl_pemesan`
--

CREATE TABLE `dtl_pemesan` (
  `id_dtl_pemesan` int NOT NULL,
  `kursi` int NOT NULL,
  `id_tiket` varchar(11) NOT NULL,
  `id_pemesan` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dtl_pemesan`
--

INSERT INTO `dtl_pemesan` (`id_dtl_pemesan`, `kursi`, `id_tiket`, `id_pemesan`) VALUES
(6, 1, '22', 'PMSN00001'),
(7, 1, '29', 'PMSN00001'),
(8, 2, '30', 'PMSN00002'),
(9, 2, '29', 'PMSN00003'),
(10, 3, '29', 'PMSN00003'),
(11, 33, '24', 'PMSN00004');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `id_film` int NOT NULL,
  `judul` varchar(40) NOT NULL,
  `rating` varchar(5) NOT NULL,
  `durasi` time NOT NULL,
  `id_jadwal` varchar(10) NOT NULL,
  `sinopsis` text NOT NULL,
  `score` int NOT NULL,
  `rilis` year NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_berhenti` date NOT NULL,
  `id_sesi` varchar(10) NOT NULL,
  `id_ruang` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama`, `email`, `password`, `jk`, `tgl_lahir`, `foto`) VALUES
(12, 'daimyo', 'diopramudia2@gmail.com', '340baf1c93c74ba7b12180de829bb724', 'Laki-laki', '2006-01-25', '');

-- --------------------------------------------------------

--
-- Table structure for table `pemesan`
--

CREATE TABLE `pemesan` (
  `id_pemesan` varchar(11) NOT NULL,
  `id_member` varchar(11) NOT NULL,
  `jml_tiket_pesan` int NOT NULL,
  `total_harga` varchar(100) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesan`
--

INSERT INTO `pemesan` (`id_pemesan`, `id_member`, `jml_tiket_pesan`, `total_harga`, `tgl_pesan`, `status`) VALUES
('PMSN00001', '8', 2, '90000', '2017-05-22', 1),
('PMSN00002', '7', 1, '45000', '2017-05-22', 0),
('PMSN00003', '9', 2, '112000', '2017-05-22', 0),
('PMSN00004', '11', 1, '28000', '2017-05-22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id_ruang` int NOT NULL,
  `nama` varchar(20) NOT NULL,
  `jm_kursi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id_ruang`, `nama`, `jm_kursi`) VALUES
(1, 'A-1', 30),
(5, 'B-1', 30),
(6, 'B-2', 20),
(7, 'C-1', 30);

-- --------------------------------------------------------

--
-- Table structure for table `sesi`
--

CREATE TABLE `sesi` (
  `id_sesi` int NOT NULL,
  `sesi` int NOT NULL,
  `mulai` time NOT NULL,
  `selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sesi`
--

INSERT INTO `sesi` (`id_sesi`, `sesi`, `mulai`, `selesai`) VALUES
(1, 1, '08:00:00', '10:00:00'),
(2, 2, '10:15:00', '12:15:00'),
(3, 3, '13:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int NOT NULL,
  `harga` varchar(255) NOT NULL,
  `stok` int NOT NULL,
  `id_film` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `dtl_pemesan`
--
ALTER TABLE `dtl_pemesan`
  ADD PRIMARY KEY (`id_dtl_pemesan`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id_film`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `pemesan`
--
ALTER TABLE `pemesan`
  ADD PRIMARY KEY (`id_pemesan`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id_ruang`);

--
-- Indexes for table `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id_sesi`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dtl_pemesan`
--
ALTER TABLE `dtl_pemesan`
  MODIFY `id_dtl_pemesan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `id_film` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id_ruang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id_sesi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
