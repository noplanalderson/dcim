-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2021 at 08:17 AM
-- Server version: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_apl_dcim2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_application`
--

CREATE TABLE `tb_application` (
  `app_id` int(11) NOT NULL,
  `app_address` varchar(255) NOT NULL,
  `notes` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_app_setting`
--

CREATE TABLE `tb_app_setting` (
  `app_id` tinyint(1) NOT NULL,
  `app_title` char(100) NOT NULL,
  `app_title_short` char(50) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_copyright` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_app_setting`
--

INSERT INTO `tb_app_setting` (`app_id`, `app_title`, `app_title_short`, `app_logo`, `app_copyright`) VALUES
(1, 'Data Center Inventory Management', 'DCIM', 'logo.png', 'Dinas Komunikasi dan Informatika Kota Tangerang');

-- --------------------------------------------------------

--
-- Table structure for table `tb_devices`
--

CREATE TABLE `tb_devices` (
  `device_id` int(11) NOT NULL,
  `device_code` varchar(30) NOT NULL,
  `group_code` varchar(3) DEFAULT NULL,
  `dev_manufacture_id` int(11) DEFAULT NULL,
  `dev_model_id` int(11) DEFAULT NULL,
  `processor_type` varchar(150) DEFAULT NULL,
  `cores` int(3) DEFAULT NULL,
  `memory_model` varchar(100) DEFAULT NULL,
  `memory_cap` varchar(100) NOT NULL,
  `hdd_model` varchar(100) DEFAULT NULL,
  `hdd_cap` varchar(100) DEFAULT NULL,
  `eth_port` int(3) NOT NULL,
  `usb_port` int(2) DEFAULT NULL,
  `console_port` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dev_group`
--

CREATE TABLE `tb_dev_group` (
  `group_id` int(11) NOT NULL,
  `group_code` varchar(3) NOT NULL,
  `group_label` varchar(50) NOT NULL,
  `group_icon` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dev_group`
--

INSERT INTO `tb_dev_group` (`group_id`, `group_code`, `group_label`, `group_icon`) VALUES
(1, 'UC', 'Uncategorize', 'fa fa-question'),
(2, 'SRV', 'Server', 'fa fa-server'),
(3, 'AP', 'Access Point', 'fa fa-life-ring'),
(4, 'RO', 'Router', 'fa fa-life-ring'),
(5, 'FW', 'Firewall', 'fa fa-shield'),
(6, 'MO', 'Modem', 'fa fa-signal'),
(7, 'SWM', 'Switch Manageable', 'fa fa-tasks'),
(8, 'SW', 'Switch', 'fa fa-tasks');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dev_identity`
--

CREATE TABLE `tb_dev_identity` (
  `identity_id` int(11) NOT NULL,
  `device_code` varchar(30) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `hostname` char(255) NOT NULL,
  `operating_system` char(255) NOT NULL,
  `os_architecture` char(255) NOT NULL,
  `procurement` int(4) NOT NULL,
  `device_location` char(255) NOT NULL,
  `rack_number` int(11) DEFAULT NULL,
  `device_owner` char(255) NOT NULL,
  `device_status` enum('active','broken','vacant') NOT NULL,
  `device_picture` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dev_manufacture`
--

CREATE TABLE `tb_dev_manufacture` (
  `dev_manufacture_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `dev_manufacture` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dev_manufacture`
--

INSERT INTO `tb_dev_manufacture` (`dev_manufacture_id`, `group_id`, `dev_manufacture`) VALUES
(1, 1, 'Unknown'),
(2, 2, 'HEWLETT PACKARD'),
(3, 2, 'LENOVO'),
(4, 2, 'IBM'),
(5, 2, 'BUFFALO'),
(6, 2, 'DELL EMC'),
(7, 2, 'SUPER MICRO113-M'),
(8, 2, 'DELL'),
(9, 4, 'Mikrotik'),
(10, 5, 'Juniper'),
(11, 5, 'Unifi'),
(13, 7, 'TP-LINK Manageable'),
(14, 3, 'UniFi AP'),
(15, 3, 'ASUS'),
(16, 7, 'HPE'),
(17, 7, 'Cisco'),
(19, 3, 'D-Link'),
(20, 4, 'Unifi'),
(21, 3, 'TP-Link');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dev_model`
--

CREATE TABLE `tb_dev_model` (
  `dev_model_id` int(11) NOT NULL,
  `dev_manufacture_id` int(11) DEFAULT NULL,
  `dev_model` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dev_model`
--

INSERT INTO `tb_dev_model` (`dev_model_id`, `dev_manufacture_id`, `dev_model`) VALUES
(1, 1, 'Unkown'),
(3, 2, 'PROLIANT DL380 GEN 8'),
(4, 2, 'PROLIANT DL380 GEN 9'),
(5, 8, 'POWER EDGE R720'),
(6, 8, 'POWER EDGE R710'),
(7, 8, 'POWER EDGE T630'),
(8, 8, 'POWER EDGE R730'),
(9, 2, 'PROLIANT ML350 G6'),
(10, 3, 'SYSTEM X 3650 M5'),
(11, 8, 'POWER EDGE R440'),
(12, 4, 'SYSTEM X 3650 M4'),
(13, 5, 'TS5400D'),
(14, 8, 'POWER EDGE T610'),
(15, 4, 'SYSTEM X 3560'),
(16, 4, 'SYSTEM X 3560 M3'),
(17, 2, 'PROLIANT DL180 G6'),
(18, 3, 'THINK SERVER TS 150'),
(19, 2, '1840 STORAGE'),
(20, 7, 'SUPER MICRO113-M'),
(21, 2, 'PROLIANT ML350P GEN8'),
(22, 2, 'PROLIANT ML110 G6'),
(23, 2, 'PROLIANT DL 380 GEN10'),
(24, 9, 'RB951G-2HnD'),
(25, 3, 'THINK SYSTEM SR650'),
(26, 4, 'SYSTEM X3850 X5'),
(27, 8, 'POWER EDGE T430'),
(28, 8, 'POWER EDGE R620'),
(29, 2, 'PROLIANT DL160 GEN 9'),
(30, 5, 'TERA SYSTEM'),
(31, 9, 'CCR1016-12G'),
(32, 9, 'RB800'),
(33, 9, 'RB450Gx4 (arm)'),
(34, 9, 'RB450G (mipsbe)'),
(35, 9, 'RB1100Hx4 Dude Edition'),
(36, 9, 'RB1100AHx2 (powerpc)'),
(37, 10, 'SRX-550'),
(38, 11, 'UniFi Security Gateway 4P'),
(39, 11, 'AP-AC-EDU'),
(40, 11, 'AP-LR'),
(41, 13, 'TL-SL2218'),
(42, 15, 'RT-AC5300'),
(43, 13, 'TL-SG3424'),
(44, 16, 'HPE 1910-24-PoE'),
(45, 13, 'T2600G-28TS'),
(46, 13, 'JetStream 24-Port Gigabit'),
(47, 17, 'WS-C2960L-48TS-LL'),
(48, 17, 'WS-C3560G-48PS'),
(49, 17, 'Catalyst 2960-X Series'),
(52, 8, 'POWER EDGE R740'),
(53, 19, 'DAP-2695'),
(55, 9, 'RB 1100AHx4 Series'),
(56, 14, 'UAP-AC-HD'),
(57, 14, 'AP-AC-EDU'),
(58, 14, 'AP-LR'),
(59, 14, 'NanoStation M5'),
(60, 14, 'UAP-AC-PRO'),
(61, 14, 'AP-AC-LR'),
(62, 9, 'RB951Ui-2HnD'),
(63, 14, 'AP V2'),
(64, 1, 'TESTING'),
(65, 1, 'TESTING'),
(66, 4, 'TESTING'),
(67, 1, 'TESTING1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dev_setting`
--

CREATE TABLE `tb_dev_setting` (
  `setting_id` int(11) NOT NULL,
  `service` enum('app','wifi','vm','ip') NOT NULL,
  `group_code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_group_menu`
--

CREATE TABLE `tb_group_menu` (
  `menu_group_id` int(2) NOT NULL,
  `menu_group` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_group_menu`
--

INSERT INTO `tb_group_menu` (`menu_group_id`, `menu_group`) VALUES
(1, 'GENERAL'),
(2, 'DATA MASTER'),
(3, 'MANAGEMENT');

-- --------------------------------------------------------

--
-- Table structure for table `tb_hardware`
--

CREATE TABLE `tb_hardware` (
  `hardware_id` int(11) NOT NULL,
  `hw_code` varchar(30) NOT NULL,
  `category_code` varchar(4) DEFAULT 'UC',
  `hw_manufacture_id` int(11) DEFAULT NULL,
  `hw_model` char(255) NOT NULL,
  `capacity` double(6,2) NOT NULL,
  `capacity_unit` enum('MB','GB','TB','Ghz','Mhz','Watt','Volt','Ampere') NOT NULL,
  `hw_quantity` int(4) NOT NULL,
  `procurement` int(4) NOT NULL,
  `notes` char(255) NOT NULL,
  `hw_status` enum('active','broken','vacant') NOT NULL,
  `hw_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_hw_category`
--

CREATE TABLE `tb_hw_category` (
  `hw_category_id` int(11) NOT NULL,
  `hw_code` varchar(3) NOT NULL,
  `hw_category` char(255) NOT NULL,
  `hw_icon` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_hw_category`
--

INSERT INTO `tb_hw_category` (`hw_category_id`, `hw_code`, `hw_category`, `hw_icon`) VALUES
(1, 'UC', 'UNCATEGORIZE', 'fa fa-question'),
(2, 'HD', 'Harddisk', 'fa fa-hdd-o'),
(3, 'MEM', 'RAM', 'fa fa-ticket'),
(4, 'PRO', 'Processor', 'fa fa-square'),
(11, 'RAK', 'Rack', 'fa fa-tasks'),
(12, 'HTS', 'Heatsink', 'fa fa-life-ring');

-- --------------------------------------------------------

--
-- Table structure for table `tb_hw_manufacture`
--

CREATE TABLE `tb_hw_manufacture` (
  `hw_manufacture_id` int(11) NOT NULL,
  `hw_category_id` int(11) DEFAULT NULL,
  `hw_manufacture` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_hw_manufacture`
--

INSERT INTO `tb_hw_manufacture` (`hw_manufacture_id`, `hw_category_id`, `hw_manufacture`) VALUES
(1, 1, 'Unknown'),
(2, 2, 'COMPAQ'),
(3, 2, 'DELL'),
(4, 2, 'FUJITSU'),
(5, 2, 'HITACHI'),
(6, 2, 'HEWLETT PACKARD'),
(7, 2, 'IBM'),
(8, 2, 'SEAGATE'),
(9, 3, 'HYNIX'),
(10, 3, 'MTA'),
(11, 3, 'SAMSUNG'),
(12, 4, 'INTEL'),
(13, 2, 'SKYHAWK'),
(14, 2, 'Testing HDD');

-- --------------------------------------------------------

--
-- Table structure for table `tb_isp`
--

CREATE TABLE `tb_isp` (
  `isp_id` int(1) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `isp_name` char(100) NOT NULL,
  `sla_standard` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_logs`
--

CREATE TABLE `tb_logs` (
  `log_id` int(10) NOT NULL,
  `log_type` enum('device','hardware','service','sla-summary') NOT NULL,
  `action_date` datetime NOT NULL,
  `action` varchar(255) NOT NULL,
  `status` enum('READ','UNREAD') DEFAULT 'UNREAD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_menus`
--

CREATE TABLE `tb_menus` (
  `menu_id` int(3) NOT NULL,
  `menu_label` char(100) NOT NULL,
  `menu_group_id` int(1) NOT NULL,
  `menu_parent` int(3) DEFAULT NULL,
  `menu_sequence` int(3) DEFAULT NULL,
  `menu_location` enum('sidebar','content','menu','submenu') NOT NULL,
  `menu_icon` char(100) NOT NULL,
  `menu_link` char(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_menus`
--

INSERT INTO `tb_menus` (`menu_id`, `menu_label`, `menu_group_id`, `menu_parent`, `menu_sequence`, `menu_location`, `menu_icon`, `menu_link`) VALUES
(12, 'Dashboard', 1, NULL, 1, 'menu', 'fa fa-dashboard', 'dashboard'),
(13, 'Add Device', 1, NULL, 2, 'menu', 'fa fa-plus-square', 'add-device'),
(14, 'Add Hardware', 1, NULL, 3, 'menu', 'fa fa-plus-square', 'add-hardware'),
(15, 'Add Service', 1, NULL, 4, 'menu', 'fa fa-plus-square', 'add-service'),
(16, 'Add Application', 1, 15, 1, 'submenu', 'fa fa-plus-square', 'add-service/app'),
(17, 'Add Wifi', 1, 15, 2, 'submenu', 'fa fa-plus-square', 'add-service/wifi'),
(18, 'Add Network', 1, 15, 3, 'submenu', 'fa fa-plus-square', 'add-service/network'),
(19, 'Add VM', 1, 15, 4, 'submenu', 'fa fa-plus-square', 'add-service/vm'),
(20, 'Add Subnetwork', 1, 15, NULL, 'content', 'fa fa-plus-square', 'add-service/subnet'),
(21, 'Add SLA', 1, NULL, 5, 'menu', 'fa fa-plus-square', 'add-sla'),
(22, 'Data Device', 2, NULL, 6, 'menu', 'fa fa-tasks', 'devices'),
(23, 'Device Group', 2, 22, NULL, 'content', '', 'devices/group'),
(32, 'Data Hardware', 2, NULL, 7, 'menu', 'fa fa-hdd-o', 'hardwares'),
(33, 'Hardware Group', 2, 32, NULL, 'content', '', 'hardwares/group'),
(38, 'Data Services', 2, NULL, 8, 'menu', 'fa fa-share-alt', 'services'),
(39, 'Applications', 2, 38, 1, 'submenu', 'fa fa-android', 'services/apps'),
(40, 'Wifi', 2, 38, 2, 'submenu', 'fa fa-wifi', 'services/wifi'),
(41, 'Networks', 2, 38, 3, 'submenu', 'fa fa-code-fork', 'services/networks'),
(42, 'VM', 2, 38, 4, 'submenu', 'fa fa-sitemap', 'services/vms'),
(43, 'Device Detail', 2, 22, NULL, 'content', '', 'devices/detail'),
(44, 'Edit Device', 2, 22, NULL, 'content', 'fa fa-edit', 'devices/edit'),
(45, 'Delete Device', 2, 22, NULL, 'content', 'fa fa-trash', 'devices/delete'),
(46, 'Device Timeline', 2, 22, NULL, 'content', 'fa fa-info', 'devices/timeline'),
(47, 'Subnet Lists', 2, 38, NULL, 'content', 'fa fa-list', 'services/subnet'),
(48, 'Edit Hardware', 2, 32, NULL, 'content', 'fa fa-edit', 'hardwares/edit'),
(49, 'Delete Hardware', 2, 32, NULL, 'content', 'fa fa-trash', 'hardwares/delete'),
(50, 'Hardware Detail', 2, 32, NULL, 'content', '', 'hardwares/detail'),
(51, 'Edit Service', 2, 38, NULL, 'content', 'fa fa-edit', 'services/edit'),
(52, 'Delete Service', 2, 38, NULL, 'content', 'fa fa-trash', 'services/delete'),
(53, 'IP Action', 2, 38, NULL, 'content', '', 'services/action'),
(54, 'Racks', 2, NULL, 9, 'menu', 'fa fa-bars', 'racks'),
(55, 'Rack Number', 2, 54, 1, 'content', '', 'racks/number'),
(56, 'Procurements', 2, NULL, 10, 'menu', 'fa fa-calendar-o', 'procurements'),
(57, 'Device Procurements', 2, 56, 1, 'submenu', '', 'procurements/devices'),
(58, 'Hardware Procurements', 2, 56, 2, 'submenu', '', 'procurements/hardwares'),
(59, 'SLA Summary', 2, NULL, 11, 'menu', 'fa fa-line-chart', 'sla-summary'),
(60, 'Edit SLA', 2, 59, NULL, 'content', 'fa fa-edit', 'sla-summary/edit'),
(61, 'SLA Period', 2, 59, NULL, 'content', '', 'sla-summary/period'),
(62, 'Get SLA', 2, 59, NULL, 'content', '', 'sla-summary/get_sla'),
(63, 'Delete SLA', 2, 59, NULL, 'content', 'fa fa-trash', 'sla-summary/delete'),
(64, 'ISP Setting', 3, NULL, 12, 'menu', 'fa fa-gear', 'isp-setting'),
(65, 'Get ISP', 3, 64, NULL, 'content', '', 'isp-setting/get-isp'),
(66, 'Edit ISP', 3, 64, NULL, 'content', 'fa fa-edit', 'isp-setting/edit'),
(67, 'Delete ISP', 3, 64, NULL, 'content', 'fa fa-trash', 'isp-setting/delete'),
(68, 'User Management', 3, NULL, 13, 'menu', 'fa fa-users', 'user-management'),
(69, 'Add User', 3, 68, NULL, 'content', 'fa fa-user-plus', 'user-management/add'),
(70, 'Edit User', 3, 68, NULL, 'content', 'fa fa-edit', 'user-management/edit'),
(71, 'Get User', 3, 68, NULL, 'content', '', 'user-management/get-user'),
(72, 'Delete User', 3, 68, NULL, 'content', 'fa fa-trash', 'user-management/delete'),
(73, 'Utilities', 3, NULL, 14, 'menu', 'fa fa-wrench', 'utilities'),
(74, 'Add Utils', 3, 73, 1, 'submenu', 'fa fa-plus-square', 'utilities/add'),
(75, 'Edit Utils', 3, 73, NULL, 'content', 'fa fa-edit', 'utilities/edit'),
(76, 'Delete Utils', 3, 73, NULL, 'content', 'fa fa-trash', 'utilities/delete'),
(77, 'Data Utils', 3, 73, 2, 'submenu', 'fa fa-file-text', 'utilities'),
(79, 'Add ISP', 3, 64, NULL, 'content', 'fa fa-plus-square', 'isp-setting/add'),
(80, 'Role Management', 3, NULL, 15, 'menu', 'fa fa-key', 'role-management'),
(81, 'Edit Role', 3, 80, NULL, 'content', 'fa fa-edit', 'role-management/edit'),
(82, 'Delete Role', 3, 80, NULL, 'content', 'fa fa-trash', 'role-management/delete'),
(83, 'Get Role', 3, 80, NULL, 'content', '', 'role-management/get-role'),
(84, 'Add User Group', 3, 80, NULL, 'content', 'fa fa-plus-square', 'role-management/add'),
(85, 'Search', 2, NULL, NULL, 'content', '', 'search/term');

-- --------------------------------------------------------

--
-- Table structure for table `tb_network`
--

CREATE TABLE `tb_network` (
  `network_id` int(11) NOT NULL,
  `network_label` char(150) NOT NULL,
  `network_type` enum('PRIVATE','PUBLIC') NOT NULL,
  `network_block` varchar(50) NOT NULL,
  `submask` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_private_ip`
--

CREATE TABLE `tb_private_ip` (
  `private_ip_id` int(11) NOT NULL,
  `subnet_id` int(11) NOT NULL,
  `device_code` varchar(30) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL,
  `wifi_id` int(11) DEFAULT NULL,
  `vm_id` int(11) DEFAULT NULL,
  `ip_address` varbinary(16) NOT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_public_ip`
--

CREATE TABLE `tb_public_ip` (
  `public_ip_id` int(11) NOT NULL,
  `subnet_id` int(11) NOT NULL,
  `device_code` varchar(30) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL,
  `wifi_id` int(11) DEFAULT NULL,
  `vm_id` int(11) DEFAULT NULL,
  `ip_address` varbinary(16) NOT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `role_id` int(5) NOT NULL,
  `user_group_id` int(2) NOT NULL,
  `menu_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`role_id`, `user_group_id`, `menu_id`) VALUES
(1, 1, 12),
(3, 1, 14),
(4, 1, 15),
(5, 1, 16),
(6, 1, 17),
(7, 1, 18),
(8, 1, 19),
(9, 1, 20),
(10, 1, 21),
(11, 1, 22),
(12, 1, 23),
(13, 1, 32),
(14, 1, 33),
(15, 1, 38),
(16, 1, 39),
(17, 1, 40),
(18, 1, 41),
(19, 1, 42),
(20, 1, 43),
(21, 1, 44),
(22, 1, 45),
(23, 1, 45),
(24, 1, 46),
(25, 1, 47),
(26, 1, 48),
(27, 1, 49),
(28, 1, 50),
(29, 1, 51),
(30, 1, 52),
(31, 1, 53),
(32, 1, 54),
(33, 1, 55),
(34, 1, 56),
(35, 1, 57),
(36, 1, 58),
(37, 1, 59),
(38, 1, 60),
(39, 1, 62),
(40, 1, 63),
(41, 1, 64),
(42, 1, 65),
(43, 1, 66),
(44, 1, 67),
(45, 1, 73),
(46, 1, 74),
(47, 1, 75),
(48, 1, 76),
(49, 1, 77),
(51, 1, 61),
(52, 1, 79),
(53, 3, 68),
(54, 3, 69),
(55, 3, 70),
(56, 3, 71),
(57, 3, 72),
(58, 3, 80),
(59, 3, 81),
(60, 3, 82),
(61, 3, 12),
(62, 3, 83),
(75, 1, 13),
(76, 3, 84),
(77, 1, 85),
(78, 1, 75);

-- --------------------------------------------------------

--
-- Table structure for table `tb_sec_question`
--

CREATE TABLE `tb_sec_question` (
  `sec_question_id` int(3) NOT NULL,
  `sec_question` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_sec_question`
--

INSERT INTO `tb_sec_question` (`sec_question_id`, `sec_question`) VALUES
(1, 'Siapakah Presiden Pertama Republik Indonesia?'),
(2, 'Siapa nama ibu kandung Anda?'),
(3, 'Apa hewan peliharaan Anda?'),
(4, 'Apa makanan favorit Anda?'),
(5, 'Apa minuman favorit Anda?'),
(6, 'Di mana Anda bekerja?'),
(7, 'Siapa tokoh favorit Anda?'),
(8, 'Salah satu negara di Asia Tengah?');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sla`
--

CREATE TABLE `tb_sla` (
  `sla_id` int(10) NOT NULL,
  `isp_id` int(1) NOT NULL,
  `downtime` datetime NOT NULL,
  `uptime` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `percentage` decimal(4,2) NOT NULL,
  `cause` char(255) NOT NULL,
  `solution` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_subnet`
--

CREATE TABLE `tb_subnet` (
  `subnet_id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL,
  `subnet_label` varchar(150) NOT NULL,
  `ip_subnet` varchar(20) NOT NULL,
  `min_ip` varbinary(16) NOT NULL,
  `max_ip` varbinary(16) NOT NULL,
  `vlan` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline`
--

CREATE TABLE `tb_timeline` (
  `timeline_id` int(11) NOT NULL,
  `device_code` varchar(30) NOT NULL,
  `installation_date` date NOT NULL,
  `installation_location` varchar(80) NOT NULL,
  `status` enum('ACTIVE','VACANT','BROKEN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `user_group_id` int(2) NOT NULL,
  `sec_question_id` int(3) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` char(100) NOT NULL,
  `sec_answer` varchar(255) NOT NULL,
  `user_picture` varchar(128) NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_group_id`, `sec_question_id`, `user_name`, `user_password`, `user_email`, `sec_answer`, `user_picture`, `last_login`, `user_status`) VALUES
(2, 3, 1, 'userman', '$argon2id$v=19$m=65536,t=4,p=1$eG0uZHUwMTNvWnBPRVBOLg$nHRUxl2N9/7Mee/HRXu+9V5EmN2r4hYlEmZkQa5juHo', 'userman@somewhere.com', 'hayo apa hayo', '9d4c2f63-7f89-cc14862c-6f06-c81e728d/noplanalderson_7dWLX_dyh_86514_mrn_20200806023438.png', 1597785023, 1),
(6, 1, 3, 'employee', '$argon2id$v=19$m=65536,t=4,p=1$azIvUHdlSmM0MmcyQkdyVg$4kcfjNOqb6X7XjrzdanVo5Ufv72vluvKSA5Ui28DNTc', 'employee@office.com', 'kucing', '340fa23e-3929-0fe28944-eb16-b0f2fb34/ridwannaim_wb6ZN_dyh_61825_mrn_20200806042927.png', 1596809646, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_group`
--

CREATE TABLE `tb_user_group` (
  `user_group_id` int(2) NOT NULL,
  `user_group` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_group`
--

INSERT INTO `tb_user_group` (`user_group_id`, `user_group`) VALUES
(1, 'Employee'),
(3, 'User Manager');

-- --------------------------------------------------------

--
-- Table structure for table `tb_vm`
--

CREATE TABLE `tb_vm` (
  `vm_id` int(11) NOT NULL,
  `device_code` varchar(30) DEFAULT NULL,
  `hostname` char(255) NOT NULL,
  `operating_system` char(255) DEFAULT NULL,
  `os_architecture` char(255) DEFAULT NULL,
  `cores` int(3) DEFAULT NULL,
  `mem_cap` int(4) DEFAULT NULL,
  `hdd_cap` int(5) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_wifi`
--

CREATE TABLE `tb_wifi` (
  `wifi_id` int(5) NOT NULL,
  `wifi_ssid` char(150) NOT NULL,
  `wifi_user` char(100) NOT NULL,
  `wifi_password` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_application`
--
ALTER TABLE `tb_application`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `tb_app_setting`
--
ALTER TABLE `tb_app_setting`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `tb_devices`
--
ALTER TABLE `tb_devices`
  ADD PRIMARY KEY (`device_id`),
  ADD UNIQUE KEY `device_code` (`device_code`),
  ADD KEY `dev_manufacture_id` (`dev_manufacture_id`),
  ADD KEY `dev_model_id` (`dev_model_id`),
  ADD KEY `group_code` (`group_code`);

--
-- Indexes for table `tb_dev_group`
--
ALTER TABLE `tb_dev_group`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `group_code` (`group_code`);

--
-- Indexes for table `tb_dev_identity`
--
ALTER TABLE `tb_dev_identity`
  ADD PRIMARY KEY (`identity_id`),
  ADD UNIQUE KEY `device_code` (`device_code`);

--
-- Indexes for table `tb_dev_manufacture`
--
ALTER TABLE `tb_dev_manufacture`
  ADD PRIMARY KEY (`dev_manufacture_id`);

--
-- Indexes for table `tb_dev_model`
--
ALTER TABLE `tb_dev_model`
  ADD PRIMARY KEY (`dev_model_id`),
  ADD KEY `dev_manufacture_id` (`dev_manufacture_id`);

--
-- Indexes for table `tb_dev_setting`
--
ALTER TABLE `tb_dev_setting`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `group_code` (`group_code`);

--
-- Indexes for table `tb_group_menu`
--
ALTER TABLE `tb_group_menu`
  ADD PRIMARY KEY (`menu_group_id`);

--
-- Indexes for table `tb_hardware`
--
ALTER TABLE `tb_hardware`
  ADD PRIMARY KEY (`hardware_id`),
  ADD KEY `hw_manufacture_id` (`hw_manufacture_id`),
  ADD KEY `category_code` (`category_code`);

--
-- Indexes for table `tb_hw_category`
--
ALTER TABLE `tb_hw_category`
  ADD PRIMARY KEY (`hw_category_id`),
  ADD UNIQUE KEY `hw_code` (`hw_code`);

--
-- Indexes for table `tb_hw_manufacture`
--
ALTER TABLE `tb_hw_manufacture`
  ADD PRIMARY KEY (`hw_manufacture_id`),
  ADD KEY `hw_category_id` (`hw_category_id`);

--
-- Indexes for table `tb_isp`
--
ALTER TABLE `tb_isp`
  ADD PRIMARY KEY (`isp_id`);

--
-- Indexes for table `tb_logs`
--
ALTER TABLE `tb_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_menus`
--
ALTER TABLE `tb_menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `menu_group_id` (`menu_group_id`);

--
-- Indexes for table `tb_network`
--
ALTER TABLE `tb_network`
  ADD PRIMARY KEY (`network_id`);

--
-- Indexes for table `tb_private_ip`
--
ALTER TABLE `tb_private_ip`
  ADD PRIMARY KEY (`private_ip_id`),
  ADD KEY `subnet_id` (`subnet_id`),
  ADD KEY `device_code` (`device_code`),
  ADD KEY `app_id` (`app_id`),
  ADD KEY `wifi_id` (`wifi_id`),
  ADD KEY `vm_id` (`vm_id`);

--
-- Indexes for table `tb_public_ip`
--
ALTER TABLE `tb_public_ip`
  ADD PRIMARY KEY (`public_ip_id`),
  ADD KEY `subnet_id` (`subnet_id`),
  ADD KEY `device_code` (`device_code`),
  ADD KEY `app_id` (`app_id`),
  ADD KEY `wifi_id` (`wifi_id`),
  ADD KEY `vm_id` (`vm_id`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `user_group_id` (`user_group_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `tb_sec_question`
--
ALTER TABLE `tb_sec_question`
  ADD PRIMARY KEY (`sec_question_id`);

--
-- Indexes for table `tb_sla`
--
ALTER TABLE `tb_sla`
  ADD PRIMARY KEY (`sla_id`),
  ADD KEY `isp_id` (`isp_id`);

--
-- Indexes for table `tb_subnet`
--
ALTER TABLE `tb_subnet`
  ADD PRIMARY KEY (`subnet_id`),
  ADD KEY `network_id` (`network_id`);

--
-- Indexes for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  ADD PRIMARY KEY (`timeline_id`),
  ADD KEY `tb_timeline_ibfk_1` (`device_code`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `sec_question_id` (`sec_question_id`),
  ADD KEY `user_group_id` (`user_group_id`);

--
-- Indexes for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `tb_vm`
--
ALTER TABLE `tb_vm`
  ADD PRIMARY KEY (`vm_id`),
  ADD KEY `device_code` (`device_code`);

--
-- Indexes for table `tb_wifi`
--
ALTER TABLE `tb_wifi`
  ADD PRIMARY KEY (`wifi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_application`
--
ALTER TABLE `tb_application`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_devices`
--
ALTER TABLE `tb_devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dev_group`
--
ALTER TABLE `tb_dev_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_dev_identity`
--
ALTER TABLE `tb_dev_identity`
  MODIFY `identity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dev_manufacture`
--
ALTER TABLE `tb_dev_manufacture`
  MODIFY `dev_manufacture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_dev_model`
--
ALTER TABLE `tb_dev_model`
  MODIFY `dev_model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tb_dev_setting`
--
ALTER TABLE `tb_dev_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_group_menu`
--
ALTER TABLE `tb_group_menu`
  MODIFY `menu_group_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_hardware`
--
ALTER TABLE `tb_hardware`
  MODIFY `hardware_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_hw_category`
--
ALTER TABLE `tb_hw_category`
  MODIFY `hw_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_hw_manufacture`
--
ALTER TABLE `tb_hw_manufacture`
  MODIFY `hw_manufacture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_isp`
--
ALTER TABLE `tb_isp`
  MODIFY `isp_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_logs`
--
ALTER TABLE `tb_logs`
  MODIFY `log_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_menus`
--
ALTER TABLE `tb_menus`
  MODIFY `menu_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tb_network`
--
ALTER TABLE `tb_network`
  MODIFY `network_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_private_ip`
--
ALTER TABLE `tb_private_ip`
  MODIFY `private_ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_public_ip`
--
ALTER TABLE `tb_public_ip`
  MODIFY `public_ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tb_sec_question`
--
ALTER TABLE `tb_sec_question`
  MODIFY `sec_question_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_sla`
--
ALTER TABLE `tb_sla`
  MODIFY `sla_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_subnet`
--
ALTER TABLE `tb_subnet`
  MODIFY `subnet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  MODIFY `timeline_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  MODIFY `user_group_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_vm`
--
ALTER TABLE `tb_vm`
  MODIFY `vm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_wifi`
--
ALTER TABLE `tb_wifi`
  MODIFY `wifi_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_devices`
--
ALTER TABLE `tb_devices`
  ADD CONSTRAINT `tb_devices_ibfk_2` FOREIGN KEY (`dev_manufacture_id`) REFERENCES `tb_dev_manufacture` (`dev_manufacture_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_devices_ibfk_3` FOREIGN KEY (`dev_model_id`) REFERENCES `tb_dev_model` (`dev_model_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_devices_ibfk_4` FOREIGN KEY (`group_code`) REFERENCES `tb_dev_group` (`group_code`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_dev_identity`
--
ALTER TABLE `tb_dev_identity`
  ADD CONSTRAINT `tb_dev_identity_ibfk_1` FOREIGN KEY (`device_code`) REFERENCES `tb_devices` (`device_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_dev_model`
--
ALTER TABLE `tb_dev_model`
  ADD CONSTRAINT `tb_dev_model_ibfk_1` FOREIGN KEY (`dev_manufacture_id`) REFERENCES `tb_dev_manufacture` (`dev_manufacture_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_dev_setting`
--
ALTER TABLE `tb_dev_setting`
  ADD CONSTRAINT `tb_dev_setting_ibfk_1` FOREIGN KEY (`group_code`) REFERENCES `tb_dev_group` (`group_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_hardware`
--
ALTER TABLE `tb_hardware`
  ADD CONSTRAINT `tb_hardware_ibfk_2` FOREIGN KEY (`hw_manufacture_id`) REFERENCES `tb_hw_manufacture` (`hw_manufacture_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_hardware_ibfk_3` FOREIGN KEY (`category_code`) REFERENCES `tb_hw_category` (`hw_code`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_hw_manufacture`
--
ALTER TABLE `tb_hw_manufacture`
  ADD CONSTRAINT `tb_hw_manufacture_ibfk_1` FOREIGN KEY (`hw_category_id`) REFERENCES `tb_hw_category` (`hw_category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_menus`
--
ALTER TABLE `tb_menus`
  ADD CONSTRAINT `tb_menus_ibfk_1` FOREIGN KEY (`menu_group_id`) REFERENCES `tb_group_menu` (`menu_group_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_private_ip`
--
ALTER TABLE `tb_private_ip`
  ADD CONSTRAINT `tb_private_ip_ibfk_1` FOREIGN KEY (`subnet_id`) REFERENCES `tb_subnet` (`subnet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_private_ip_ibfk_2` FOREIGN KEY (`device_code`) REFERENCES `tb_devices` (`device_code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_private_ip_ibfk_3` FOREIGN KEY (`app_id`) REFERENCES `tb_application` (`app_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_private_ip_ibfk_4` FOREIGN KEY (`wifi_id`) REFERENCES `tb_wifi` (`wifi_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_private_ip_ibfk_5` FOREIGN KEY (`vm_id`) REFERENCES `tb_vm` (`vm_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_public_ip`
--
ALTER TABLE `tb_public_ip`
  ADD CONSTRAINT `tb_public_ip_ibfk_1` FOREIGN KEY (`subnet_id`) REFERENCES `tb_subnet` (`subnet_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_public_ip_ibfk_2` FOREIGN KEY (`device_code`) REFERENCES `tb_devices` (`device_code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_public_ip_ibfk_3` FOREIGN KEY (`app_id`) REFERENCES `tb_application` (`app_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_public_ip_ibfk_4` FOREIGN KEY (`wifi_id`) REFERENCES `tb_wifi` (`wifi_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_public_ip_ibfk_5` FOREIGN KEY (`vm_id`) REFERENCES `tb_vm` (`vm_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD CONSTRAINT `tb_roles_ibfk_1` FOREIGN KEY (`user_group_id`) REFERENCES `tb_user_group` (`user_group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_roles_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `tb_menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_sla`
--
ALTER TABLE `tb_sla`
  ADD CONSTRAINT `tb_sla_ibfk_1` FOREIGN KEY (`isp_id`) REFERENCES `tb_isp` (`isp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_subnet`
--
ALTER TABLE `tb_subnet`
  ADD CONSTRAINT `tb_subnet_ibfk_1` FOREIGN KEY (`network_id`) REFERENCES `tb_network` (`network_id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  ADD CONSTRAINT `tb_timeline_ibfk_1` FOREIGN KEY (`device_code`) REFERENCES `tb_devices` (`device_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`sec_question_id`) REFERENCES `tb_sec_question` (`sec_question_id`),
  ADD CONSTRAINT `tb_user_ibfk_2` FOREIGN KEY (`user_group_id`) REFERENCES `tb_user_group` (`user_group_id`);

--
-- Constraints for table `tb_vm`
--
ALTER TABLE `tb_vm`
  ADD CONSTRAINT `tb_vm_ibfk_1` FOREIGN KEY (`device_code`) REFERENCES `tb_devices` (`device_code`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
