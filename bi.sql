-- phpMyAdmin SQL Dump
-- version 4.8.5
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "-04:00";

--
-- Database: `bi`
--

CREATE SCHEMA IF NOT EXISTS `bi` DEFAULT CHARACTER SET utf8 ;
USE `bi` ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_company`
--

CREATE TABLE `tb_company` (
  `com_id` int(11) NOT NULL,
  `com_name` varchar(400) NOT NULL,
  `com_cnpj` varchar(30) NOT NULL,
  `grp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_group`
--

CREATE TABLE `tb_group` (
  `grp_id` int(11) NOT NULL,
  `grp_name` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_iso_companies`
--

CREATE TABLE `tb_iso_companies` (
  `com_id` int(11) NOT NULL,
  `com_name` varchar(400) NOT NULL,
  `grp_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `year` varchar(5) NOT NULL,
  `month` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_iso_groups`
--

CREATE TABLE `tb_iso_groups` (
  `grp_id` int(11) NOT NULL,
  `grp_name` varchar(400) NOT NULL,
  `total_companies` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `year` varchar(5) NOT NULL,
  `month` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_iso_process`
--

CREATE TABLE `tb_iso_process` (
  `prc_id` int(11) NOT NULL,
  `prc_name` varchar(400) NOT NULL,
  `prc_order` int(11) NOT NULL,
  `grp_id` int(11) NOT NULL,
  `com_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `year` varchar(5) NOT NULL,
  `month` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `tb_company`
--

ALTER TABLE `tb_company`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `tb_group`
--

ALTER TABLE `tb_group`
  ADD PRIMARY KEY (`grp_id`);

--
-- Indexes for table `tb_iso_companies`
--

ALTER TABLE `tb_iso_companies`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `tb_iso_groups`
--

ALTER TABLE `tb_iso_groups`
  ADD PRIMARY KEY (`grp_id`);

--
-- Indexes for table `tb_iso_process`
--

ALTER TABLE `tb_iso_process`
  ADD PRIMARY KEY (`prc_id`);
COMMIT;
