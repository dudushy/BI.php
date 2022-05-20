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

--
-- Indexes for table `tb_company`
--

ALTER TABLE `tb_company`
  ADD PRIMARY KEY (`com_id`);

-- --------------------------------------------------------

--
-- Table structure for table `tb_group`
--

CREATE TABLE `tb_group` (
  `grp_id` int(11) NOT NULL,
  `grp_name` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `tb_group`
--

ALTER TABLE `tb_group`
  ADD PRIMARY KEY (`grp_id`);

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

-- --------------------------------------------------------

--
-- Table structure for table `tb_kpi`
--

CREATE TABLE `tb_kpi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `com_id` int(11) NOT NULL,
  `year` varchar(5) NOT NULL,
  `month` varchar(3) NOT NULL,
  `tus` varchar(400) NOT NULL,
  `m3_water` varchar(400) NOT NULL,
  `m3_well` varchar(400) NOT NULL,
  `m3_cistern` varchar(400) NOT NULL,
  `m3_water_total` varchar(400) NOT NULL,
  `m3_water_tus` varchar(400) NOT NULL,
  `m3_well_tus` varchar(400) NOT NULL,
  `m3_cistern_tus` varchar(400) NOT NULL,
  `m3_water_total_tus` varchar(400) NOT NULL,
  `value_water` varchar(400) NOT NULL,
  `kwh_energy` varchar(400) NOT NULL,
  `kwh_energy_tus` varchar(400) NOT NULL,
  `value_energy` varchar(400) NOT NULL,
  `total_recyclable` varchar(400) NOT NULL,
  `total_contaminated` varchar(400) NOT NULL,
  `total_recyclable_tus` varchar(400) NOT NULL,
  `total_contaminated_tus` varchar(400) NOT NULL,
  `badgoal_m3_water_total` varchar(400) NOT NULL,
  `badgoal_m3_water_total_tus` varchar(400) NOT NULL,
  `badgoal_kwh_energy` varchar(400) NOT NULL,
  `badgoal_kwh_energy_tus` varchar(400) NOT NULL,
  `badgoal_recyclable_tus` varchar(400) NOT NULL,
  `badgoal_total_contaminated_tus` varchar(400) NOT NULL,
  `delayed_tus` varchar(400) NOT NULL,
  `delayed_m3_water` varchar(400) NOT NULL,
  `delayed_m3_well` varchar(400) NOT NULL,
  `delayed_m3_cistern` varchar(400) NOT NULL,
  `delayed_value_water` varchar(400) NOT NULL,
  `delayed_kwh_energy` varchar(400) NOT NULL,
  `delayed_value_energy` varchar(400) NOT NULL,
  `delayed_total_recyclable` varchar(400) NOT NULL,
  `delayed_total_contaminated` varchar(400) NOT NULL,
  `unlocked` varchar(400) NOT NULL,
  `obs` varchar(1000) NOT NULL,
  `iso14001` varchar(400) NOT NULL,
  `iso14001_validate_date` varchar(400) NOT NULL,
  `iso14001_file` varchar(400) NOT NULL,
  `iso14001_file_path` varchar(1000) NOT NULL,
  `inserted` varchar(400) NOT NULL,
  `water_file` varchar(400) NOT NULL,
  `water_file_path` varchar(1000) NOT NULL,
  `energy_file` varchar(400) NOT NULL,
  `energy_file_path` varchar(1000) NOT NULL,
  `me_goal_water` varchar(400) NOT NULL,
  `me_goal_energy` varchar(400) NOT NULL,
  `current` varchar(400) NOT NULL,
  `permission` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `tb_kpi`
--
ALTER TABLE `tb_kpi`
  ADD PRIMARY KEY (`id`);

-- changes
ALTER TABLE `tb_company` ADD `int_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD `com_id` INT NOT NULL AFTER `int_id`, ADD PRIMARY KEY (`int_id`);