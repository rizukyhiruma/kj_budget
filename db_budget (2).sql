-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2020 at 07:55 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_budget`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_approval`
--

CREATE TABLE IF NOT EXISTS `tb_approval` (
`id_approval` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `sent` int(11) NOT NULL,
  `approval_1` int(11) NOT NULL,
  `approval_2` int(11) NOT NULL,
  `approval_3` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_approval`
--

INSERT INTO `tb_approval` (`id_approval`, `id_user`, `id_periode`, `sent`, `approval_1`, `approval_2`, `approval_3`) VALUES
(1, 2, 2, 1, 1, 0, 0),
(2, 6, 11, 1, 0, 0, 0),
(3, 6, 13, 1, 0, 0, 0),
(4, 6, 14, 1, 1, 0, 0),
(5, 6, 15, 1, 0, 0, 0),
(6, 6, 7, 1, 0, 0, 0),
(7, 2, 3, 1, 1, 1, 1),
(8, 2, 5, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_budget`
--

CREATE TABLE IF NOT EXISTS `tb_budget` (
`id_budget` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `rutin` tinyint(4) NOT NULL,
  `sent` tinyint(4) NOT NULL,
  `approval_1` int(11) NOT NULL,
  `approval_2` tinyint(4) NOT NULL,
  `approval_3` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_budget`
--

INSERT INTO `tb_budget` (`id_budget`, `id_user`, `id_periode`, `keterangan`, `rutin`, `sent`, `approval_1`, `approval_2`, `approval_3`) VALUES
(1, 2, 0, '', 0, 0, 0, 2, 2),
(2, 2, 2, 'Cloud + PPN 10%', 0, 1, 1, 0, 0),
(3, 2, 2, 'Dedicated Gold Skybro 8Mbps', 0, 1, 1, 0, 0),
(4, 2, 2, 'Pembayaran Add On 4 Core VCPU DB Server', 0, 1, 1, 0, 0),
(11, 2, 5, 'test rutin 1', 0, 1, 0, 0, 0),
(16, 2, 2, 'Renewal Antivirus Kaspersky', 0, 1, 1, 0, 0),
(17, 2, 3, 'Cloud + PPN 10%', 0, 1, 1, 1, 1),
(18, 2, 3, 'Dedicated Gold Skybro 8Mbps', 0, 1, 1, 1, 1),
(19, 2, 3, 'Pembayaran Add On 4 Core VCPU DB Server', 0, 1, 1, 1, 1),
(22, 2, 2, 'CDN Subscribe', 0, 1, 1, 0, 0),
(25, 2, 2, 'Lain-lain', 0, 1, 1, 0, 0),
(26, 6, 7, 'Beli kertas', 0, 1, 0, 0, 0),
(27, 6, 11, 'Beli kertas', 0, 1, 0, 0, 0),
(28, 6, 13, 'servis ac', 0, 1, 0, 0, 0),
(29, 6, 14, 'servis ac', 0, 1, 1, 0, 0),
(30, 6, 15, 'servis mobil', 0, 1, 0, 0, 0),
(33, 2, 3, 'Lain-lain', 0, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_budget_2`
--

CREATE TABLE IF NOT EXISTS `tb_budget_2` (
`id_budget_2` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `id_budget` int(11) NOT NULL,
  `jumlah_unit` int(11) NOT NULL,
  `jumlah_waktu` int(11) NOT NULL,
  `biaya` varchar(255) NOT NULL,
  `total_budget` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_budget_2`
--

INSERT INTO `tb_budget_2` (`id_budget_2`, `id_user`, `id_periode`, `id_budget`, `jumlah_unit`, `jumlah_waktu`, `biaya`, `total_budget`) VALUES
(1, 2, 2, 2, 1, 1, '13387000', '13387000'),
(4, 2, 2, 3, 1, 1, '8910000', '8910000'),
(5, 2, 2, 4, 1, 1, '2475000', '2475000'),
(6, 2, 2, 16, 1, 1, '8000000', '8000000'),
(7, 2, 3, 17, 1, 1, '13387004', '13387004'),
(8, 2, 3, 18, 1, 1, '8910004', '8910004'),
(9, 2, 3, 19, 1, 1, '2475004', '2475004'),
(12, 2, 2, 22, 1, 1, '32000000', '32000000'),
(15, 2, 2, 25, 1, 1, '9000000', '9000000'),
(16, 6, 7, 26, 1, 0, '50000', '0'),
(17, 6, 11, 27, 1, 1, '300000', '300000'),
(18, 6, 13, 28, 1, 1, '500000', '500000'),
(19, 6, 14, 29, 1, 1, '500000', '500000'),
(20, 6, 15, 30, 2, 1, '100000', '200000'),
(23, 2, 3, 33, 1, 1, '3000000', '3000000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_departemen`
--

CREATE TABLE IF NOT EXISTS `tb_departemen` (
`id_departemen` int(11) NOT NULL,
  `nama_departemen` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_departemen`
--

INSERT INTO `tb_departemen` (`id_departemen`, `nama_departemen`) VALUES
(1, 'Finance'),
(2, 'Distribusi'),
(3, 'Sirkulasi'),
(4, 'CS'),
(5, 'IT'),
(6, 'Layout'),
(7, 'MD'),
(8, 'CEO'),
(9, 'Super Admin'),
(10, 'HRD & GA'),
(11, 'Iklan'),
(12, 'Redaksi');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nonrutin`
--

CREATE TABLE IF NOT EXISTS `tb_nonrutin` (
`id_nonrutin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `id_budget` int(11) NOT NULL,
  `jumlah_unit` int(11) NOT NULL,
  `jumlah_waktu` int(11) NOT NULL,
  `biaya` varchar(255) NOT NULL,
  `total_budget` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_periode`
--

CREATE TABLE IF NOT EXISTS `tb_periode` (
`id_periode` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `bulan` varchar(255) NOT NULL,
  `tahun` varchar(255) NOT NULL,
  `periode` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_periode`
--

INSERT INTO `tb_periode` (`id_periode`, `id_user`, `bulan`, `tahun`, `periode`) VALUES
(1, 0, 'Mar', '2020', '2020-03-00'),
(2, 2, 'Mar', '2020', '2020-03-00'),
(3, 2, 'Apr', '2020', '2020-04-00'),
(4, 3, 'Mar', '2020', '2020-03-00'),
(5, 2, 'May', '2020', '2020-05-00'),
(6, 2, 'Jun', '2020', '2020-06-00'),
(7, 6, 'Jul', '2020', '2020-07-00'),
(12, 3, 'Apr', '2020', '2020-04-00'),
(13, 6, 'Aug', '2020', '2020-08-00'),
(14, 6, 'Jun', '2020', '2020-06-00'),
(15, 6, 'Mar', '2020', '2020-03-00'),
(16, 6, 'Nov', '2020', '2020-11-00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_reject`
--

CREATE TABLE IF NOT EXISTS `tb_reject` (
`id_reject` int(11) NOT NULL,
  `id_budget` int(11) NOT NULL,
  `reject_notes` text NOT NULL,
  `reject_status` varchar(255) NOT NULL,
  `approve_status` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_reject`
--

INSERT INTO `tb_reject` (`id_reject`, `id_budget`, `reject_notes`, `reject_status`, `approve_status`) VALUES
(11, 32, 'delete!', 'approval_1 rejected', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rutin`
--

CREATE TABLE IF NOT EXISTS `tb_rutin` (
`id_rutin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `id_budget` int(11) NOT NULL,
  `jumlah_unit` int(11) NOT NULL,
  `jumlah_waktu` int(11) NOT NULL,
  `biaya` decimal(10,0) NOT NULL,
  `total_budget` decimal(10,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rutin`
--

INSERT INTO `tb_rutin` (`id_rutin`, `id_user`, `id_periode`, `id_budget`, `jumlah_unit`, `jumlah_waktu`, `biaya`, `total_budget`) VALUES
(4, 2, 2, 2, 1, 1, '13387000', '13387000'),
(5, 2, 2, 3, 1, 1, '8910000', '8910000'),
(6, 2, 2, 4, 1, 1, '2475000', '2475000'),
(7, 2, 3, 2, 1, 1, '13387004', '13387004'),
(8, 2, 3, 3, 1, 1, '8910004', '8910004'),
(9, 2, 3, 4, 1, 1, '2475004', '2475004'),
(10, 2, 5, 2, 1, 1, '13387005', '13387005'),
(11, 2, 5, 3, 1, 1, '8910005', '8910005'),
(12, 2, 5, 4, 1, 1, '2475005', '2475005'),
(13, 2, 5, 6, 1, 1, '1000000', '1000000'),
(17, 2, 5, 11, 0, 0, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE IF NOT EXISTS `tb_status` (
  `id_status` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_budget` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
`id_user` int(11) NOT NULL,
  `id_departemen` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `id_departemen`, `username`, `password`, `type`) VALUES
(1, 9, 'superadmin', 'superadmin', 'Super Admin'),
(2, 5, 'rizky', 'rizky', 'User'),
(3, 1, 'tedy', 'tedy', 'Finance'),
(4, 7, 'bapak', 'bapak', 'MD'),
(5, 8, 'ibu', 'ibu', 'CEO'),
(6, 9, 'admin', 'admin', 'Super Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_approval`
--
ALTER TABLE `tb_approval`
 ADD PRIMARY KEY (`id_approval`);

--
-- Indexes for table `tb_budget`
--
ALTER TABLE `tb_budget`
 ADD PRIMARY KEY (`id_budget`);

--
-- Indexes for table `tb_budget_2`
--
ALTER TABLE `tb_budget_2`
 ADD PRIMARY KEY (`id_budget_2`);

--
-- Indexes for table `tb_departemen`
--
ALTER TABLE `tb_departemen`
 ADD PRIMARY KEY (`id_departemen`);

--
-- Indexes for table `tb_nonrutin`
--
ALTER TABLE `tb_nonrutin`
 ADD PRIMARY KEY (`id_nonrutin`);

--
-- Indexes for table `tb_periode`
--
ALTER TABLE `tb_periode`
 ADD PRIMARY KEY (`id_periode`);

--
-- Indexes for table `tb_reject`
--
ALTER TABLE `tb_reject`
 ADD PRIMARY KEY (`id_reject`);

--
-- Indexes for table `tb_rutin`
--
ALTER TABLE `tb_rutin`
 ADD PRIMARY KEY (`id_rutin`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_approval`
--
ALTER TABLE `tb_approval`
MODIFY `id_approval` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tb_budget`
--
ALTER TABLE `tb_budget`
MODIFY `id_budget` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tb_budget_2`
--
ALTER TABLE `tb_budget_2`
MODIFY `id_budget_2` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tb_departemen`
--
ALTER TABLE `tb_departemen`
MODIFY `id_departemen` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tb_nonrutin`
--
ALTER TABLE `tb_nonrutin`
MODIFY `id_nonrutin` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_periode`
--
ALTER TABLE `tb_periode`
MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tb_reject`
--
ALTER TABLE `tb_reject`
MODIFY `id_reject` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tb_rutin`
--
ALTER TABLE `tb_rutin`
MODIFY `id_rutin` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
