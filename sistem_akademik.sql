-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 02:04 PM
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
-- Database: `sistem_akademik`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) DEFAULT NULL,
  `id_matakuliah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kehadiran` enum('Hadir','Tidak Hadir','Izin','Sakit') DEFAULT 'Hadir'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_mahasiswa`, `id_matakuliah`, `tanggal`, `kehadiran`) VALUES
(6, 6, 44, NULL, 'Hadir'),
(7, 8, 45, NULL, 'Tidak Hadir'),
(8, 9, 43, NULL, 'Sakit'),
(9, 11, 40, NULL, 'Hadir'),
(10, 13, 41, NULL, 'Sakit'),
(11, 14, 42, NULL, 'Tidak Hadir'),
(12, 15, 38, NULL, 'Izin'),
(13, 16, 39, NULL, 'Izin'),
(14, 17, 38, NULL, 'Izin');

-- --------------------------------------------------------

--
-- Table structure for table `data_mahasiswa`
--

CREATE TABLE `data_mahasiswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` char(20) NOT NULL,
  `fakultas` varchar(50) NOT NULL,
  `prodi` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_mahasiswa`
--

INSERT INTO `data_mahasiswa` (`id`, `nama`, `nim`, `fakultas`, `prodi`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `password`) VALUES
(6, 'Faturrahman', '2220006', 'FAKULTAS TEKNIK', 'Industri', 'L', '2004-05-03', 'Taktakan, Serang, Banten.', '123'),
(8, 'Anwar', '2220008', 'FAKULTAS TEKNIK', 'Kimia', 'L', '2002-07-02', 'Legok, Serang, Banten.', '123'),
(9, 'Alfin', '2220009', 'FAKULTAS TEKNIK', 'Sipil', 'L', '2003-08-19', 'Kp. Rancasawah, Taktakan, Serang, Banten.', '123'),
(11, 'M. Iqbal', '1110001', 'FAKULTAS TEKNOLOGI INFORMASI', 'Informatika', 'L', '2004-05-25', 'Kp. Balebatu, Taktakan, Serang, Banten.', '123'),
(12, 'Denny', '3330001', 'FAKULTAS HUKUM', 'Hukum', 'L', '2003-03-09', 'Pandeglang, Banten.', '123'),
(13, 'Rohmah', '1110002', 'FAKULTAS TEKNOLOGI INFORMASI', 'Sistem Informasi', 'P', '2003-04-07', 'Kp. Rancatales, Taktakan, Serang, Banten.', '123'),
(14, 'Alfian', '1110003', 'FAKULTAS TEKNOLOGI INFORMASI', 'Sistem Komputer', 'L', '2003-05-09', 'Komp. Persada Banten.', '123'),
(15, 'Firda', '3330002', 'FAKULTAS HUKUM', 'Hukum', 'P', '2004-06-03', 'Taman Pesona, Taktakan, Serang, Banten.', '123'),
(16, 'Maymunah', '3330003', 'FAKULTAS HUKUM', 'Hukum', 'P', '2003-03-15', 'Gunung Sari, Taktakan, Serang, Banten.', '123'),
(17, 'Mahsumah', '3330004', 'FAKULTAS HUKUM', 'Hukum', 'P', '2003-04-06', 'Taktakan, Serang, Banten.', '123');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_dosen` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nama`, `kode_dosen`, `nid`, `fakultas`, `prodi`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `password`) VALUES
(8, 'Mohamad Syafiq', 'HK-888', 'HK-HUK-95664', 'FAKULTAS HUKUM', 'Hukum', 'L', '2004-01-22', 'Warung Gunung, Rangkasbitung, Pandeglang, Banten.', '123'),
(9, 'Arya Septianto', 'TK-777', 'TK-IND-92918', 'FAKULTAS TEKNIK', 'Industri', 'L', '2004-01-22', 'Tegal Buntu, Cilegon, Banten.', '123'),
(10, 'Tirta Ryadussalam', 'TI-111', 'TI-INF-54653', 'FAKULTAS TEKNOLOGI INFORMASI', 'Informatika', 'L', '2004-05-25', 'Bumi Agung, Kota Serang, Banten', '123'),
(11, 'Djikri Ferdiyansyah', 'TK-555', 'TK-KIM-53659', 'FAKULTAS TEKNIK', 'Kimia', 'L', '2004-02-20', 'BAP, Kota Serang, Banten.', '123'),
(12, 'Upiyah', 'HK-888', 'HK-HUK-84442', 'FAKULTAS HUKUM', 'Hukum', 'P', '2004-06-07', 'Banjarsari, Lebak, Banten.', '123'),
(13, 'A. Fauzi Sofyan', 'TI-222', 'TI-SI-67542', 'FAKULTAS TEKNOLOGI INFORMASI', 'Sistem Informasi', 'L', '2003-01-01', 'Banjarsari, Lebak, Banten.', '123'),
(14, 'Dimas Adiskiana', 'TI-333', 'TI-SK-37535', 'FAKULTAS TEKNOLOGI INFORMASI', 'Sistem Komputer', 'L', '2003-08-03', 'Banjarsari, Lebak, Banten.', '123'),
(15, 'Nafis', 'TK-999', 'TK-SIP-47651', 'FAKULTAS TEKNIK', 'Sipil', 'L', '2004-11-19', 'Anyer, Banten.', '123');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas_increment`
--

CREATE TABLE `fakultas_increment` (
  `fakultas` varchar(50) NOT NULL,
  `increment_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fakultas_increment`
--

INSERT INTO `fakultas_increment` (`fakultas`, `increment_id`) VALUES
('FAKULTAS HUKUM', 4),
('FAKULTAS TEKNIK', 10),
('FAKULTAS TEKNOLOGI INFORMASI', 3);

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `kode_matakuliah` varchar(20) NOT NULL,
  `nama_matakuliah` varchar(100) NOT NULL,
  `sks` int(11) NOT NULL,
  `dosen_pengampu` varchar(100) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam` varchar(20) NOT NULL,
  `ruangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id`, `nim`, `kode_matakuliah`, `nama_matakuliah`, `sks`, `dosen_pengampu`, `hari`, `jam`, `ruangan`) VALUES
(10, '2220006', '7', 'Praktikum Menggambar Teknik', 4, 'Arya Septianto', 'Selasa', '08:00 - 10:00 WIB', 'LG. 004'),
(11, '2220008', '8', 'Proses Kimia Industri', 3, 'Djikri Ferdiyansyah', 'Rabu', '10:00 - 12:00 WIB', '04.002'),
(12, '2220009', '6', 'Struktur Baja', 3, 'Nafis', 'Senin', '14:00 - 15:00', '04.001'),
(13, '1110001', '3', 'Pemrograman Web', 3, 'Tirta Ryadussalam', 'Rabu', '10:00 - 12:00 WIB', 'LG. 003'),
(14, '3330001', '1', 'Hukum Tata Negara', 4, 'Mohamad Syafiq', 'Senin', '08:00 - 10:00 \n WIB', '02.001'),
(15, '1110002', '4', 'Rekayasa Perangkat Lunak', 3, 'A. Fauzi Sofyan', 'Kamis', '11:00 - 13:00 WIB', 'LG. 001'),
(16, '1110003', '5', 'Pemrograman Komputer', 2, 'Dimas Adiskiana', 'Jum\'at', '13:00 - 14:00 WIB', 'LG. 002'),
(17, '3330002', '1', 'Hukum Tata Negara', 4, 'Mohamad Syafiq', 'Senin', '08:00 - 10:00 \n WIB', '02.001'),
(18, '3330003', '2', 'Hukum Adat dan Sosiologi', 3, 'Upiyah', 'Selasa', '09:00 - 11:00 WIB', '02.002'),
(19, '3330004', '1', 'Hukum Tata Negara', 4, 'Mohamad Syafiq', 'Senin', '08:00 - 10:00 \n WIB', '02.001'),
(20, '3330004', '2', 'Hukum Adat dan Sosiologi', 3, 'Upiyah', 'Selasa', '09:00 - 11:00 WIB', '02.002');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id` int(11) NOT NULL,
  `fakultas` varchar(30) NOT NULL,
  `prodi` varchar(20) NOT NULL,
  `kode_matakuliah` varchar(20) NOT NULL,
  `nama_matakuliah` varchar(100) NOT NULL,
  `sks` int(11) NOT NULL,
  `dosen_pengampu` varchar(100) NOT NULL,
  `nid_dosen` varchar(30) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam` varchar(20) NOT NULL,
  `ruangan` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`id`, `fakultas`, `prodi`, `kode_matakuliah`, `nama_matakuliah`, `sks`, `dosen_pengampu`, `nid_dosen`, `hari`, `jam`, `ruangan`, `semester`) VALUES
(38, 'FAKULTAS HUKUM', 'Hukum', '1', 'Hukum Tata Negara', 4, 'Mohamad Syafiq', 'HK-HUK-95664', 'Senin', '08:00 - 10:00 \n WIB', '02.001', '1'),
(39, 'FAKULTAS HUKUM', 'Hukum', '2', 'Hukum Adat dan Sosiologi', 3, 'Upiyah', 'HK-HUK-84442', 'Selasa', '09:00 - 11:00 WIB', '02.002', '3'),
(40, 'FAKULTAS TEKNOLOGI INFORMASI', 'Informatika', '3', 'Pemrograman Web', 3, 'Tirta Ryadussalam', 'TI-INF-54653', 'Rabu', '10:00 - 12:00 WIB', 'LG. 003', '3'),
(41, 'FAKULTAS TEKNOLOGI INFORMASI', 'Sistem Informasi', '4', 'Rekayasa Perangkat Lunak', 3, 'A. Fauzi Sofyan', 'TI-SI-67542', 'Kamis', '11:00 - 13:00 WIB', 'LG. 001', '1'),
(42, 'FAKULTAS TEKNOLOGI INFORMASI', 'Sistem Komputer', '5', 'Pemrograman Komputer', 2, 'Dimas Adiskiana', 'TI-SK-37535', 'Jum\'at', '13:00 - 14:00 WIB', 'LG. 002', '5'),
(43, 'FAKULTAS TEKNIK', 'Sipil', '6', 'Struktur Baja', 3, 'Nafis', 'TK-SIP-47651', 'Senin', '14:00 - 15:00', '04.001', '5'),
(44, 'FAKULTAS TEKNIK', 'Industri', '7', 'Praktikum Menggambar Teknik', 4, 'Arya Septianto', 'TK-IND-92918', 'Selasa', '08:00 - 10:00 WIB', 'LG. 004', '7'),
(45, 'FAKULTAS TEKNIK', 'Kimia', '8', 'Proses Kimia Industri', 3, 'Djikri Ferdiyansyah', 'TK-KIM-53659', 'Rabu', '10:00 - 12:00 WIB', '04.002', '7');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_matakuliah` int(11) NOT NULL,
  `nilai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id`, `id_mahasiswa`, `id_matakuliah`, `nilai`) VALUES
(6, 6, 44, 'A'),
(7, 8, 45, 'B'),
(8, 9, 43, 'B+'),
(9, 11, 40, 'A-'),
(10, 13, 41, 'C+'),
(11, 14, 42, 'C-'),
(12, 15, 38, 'B-'),
(13, 16, 39, 'C'),
(14, 17, 38, 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_mahasiswa`
--
ALTER TABLE `data_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nid` (`nid`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `fakultas_increment`
--
ALTER TABLE `fakultas_increment`
  ADD PRIMARY KEY (`fakultas`);

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_matakuliah` (`nama_matakuliah`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_mahasiswa_matakuliah` (`id_mahasiswa`,`id_matakuliah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `data_mahasiswa`
--
ALTER TABLE `data_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `krs`
--
ALTER TABLE `krs`
  ADD CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `data_mahasiswa` (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
