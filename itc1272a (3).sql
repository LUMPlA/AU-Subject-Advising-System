-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2024 at 09:39 PM
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
-- Database: `itc1272a`
--

-- --------------------------------------------------------

--
-- Table structure for table `stdaccounts`
--

CREATE TABLE `stdaccounts` (
  `studentNumber` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL DEFAULT 'Arellano123',
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `course` varchar(30) NOT NULL,
  `yearLevel` varchar(10) NOT NULL,
  `createdBy` varchar(50) NOT NULL,
  `dateCreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stdaccounts`
--

INSERT INTO `stdaccounts` (`studentNumber`, `password`, `lastName`, `firstName`, `middleName`, `course`, `yearLevel`, `createdBy`, `dateCreated`) VALUES
('22-00111', '1234', 'Luke', 'Sky', 'Walker', 'BS in Computer Science', 'SECOND', 'admin', '04/21/2024'),
('22-00211', 'Arellano123', 'Batumbakal', 'Ursula', 'Macalintal', 'BS in Computer Science', 'FOURTH', 'admin', '05/01/2024'),
('22-10000', 'Arellano123', 'Finn', 'The', 'Human', 'BS in Computer Science', 'SECOND', 'admin', '04/21/2024');

-- --------------------------------------------------------

--
-- Table structure for table `tblaccount`
--

CREATE TABLE `tblaccount` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(15) NOT NULL,
  `status` varchar(10) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `datecreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblaccount`
--

INSERT INTO `tblaccount` (`username`, `password`, `usertype`, `status`, `createdby`, `datecreated`) VALUES
('Jessie', '1234', 'Administrator', 'Active', 'Alfa', '03/21/2024'),
('Rose', '1234', 'Registrar', 'Active', 'admin', '03/21/2024'),
('Margot', '1234', 'Registrar', 'Active', 'admin', '03/22/2024'),
('Christopher', '1234', 'Administrator', 'Active', 'Margot', '03/23/2024'),
('Cedric', '1234', 'Staff', 'Active', 'Margot', '03/23/2024'),
('Ayeanne', '1234', 'Student', 'Active', 'admin', '03/31/2024'),
('Wyne', '1235', 'Administrator', 'Active', 'ADMIN', '04/11/2024'),
('admin', '1234', 'Administrator', 'Active', 'admin', '04/27/2024'),
('22-00211', 'Arellano123', 'Student', 'Active', 'admin', '05/01/2024');

-- --------------------------------------------------------

--
-- Table structure for table `tblgrades`
--

CREATE TABLE `tblgrades` (
  `studentNumber` varchar(20) NOT NULL,
  `subjectCode` varchar(20) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `encodedBy` varchar(50) NOT NULL,
  `dateCreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblgrades`
--

INSERT INTO `tblgrades` (`studentNumber`, `subjectCode`, `grade`, `encodedBy`, `dateCreated`) VALUES
('22-00111', 'CS222-LAB', '2.75', 'admin', '04/21/2024'),
('22-00211', 'GCAS-07	', '2.0', 'admin', '05/03/2024');

-- --------------------------------------------------------

--
-- Table structure for table `tblgrades_copy`
--

CREATE TABLE `tblgrades_copy` (
  `studentNumber` varchar(20) NOT NULL,
  `subjectCode` varchar(20) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `encodedBy` varchar(50) NOT NULL,
  `dateCreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbllogs`
--

CREATE TABLE `tbllogs` (
  `datelog` varchar(15) NOT NULL,
  `timelog` varchar(15) NOT NULL,
  `action` varchar(20) NOT NULL,
  `module` varchar(20) NOT NULL,
  `ID` varchar(30) NOT NULL,
  `performedby` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogs`
--

INSERT INTO `tbllogs` (`datelog`, `timelog`, `action`, `module`, `ID`, `performedby`) VALUES
('04/13/2024', '08:02:13', 'Add Grade', 'Grades Management', 'CS222-LEC', 'admin'),
('04/13/2024', '08:07:39', 'Add Grade', 'Grades Management', 'CS223', 'admin'),
('04/13/2024', '08:07:52', 'Update Grade', 'Grades Management', 'CS223', 'admin'),
('04/13/2024', '08:08:02', 'Delete Grade', 'Grades Management', 'CS223', 'admin'),
('04/13/2024', '08:17:50', 'Delete Grade', 'Grades Management', 'CS223', 'admin'),
('04/13/2024', '08:18:30', 'Add Grade', 'Grades Management', 'CS222-LEC', 'admin'),
('04/13/2024', '08:18:54', 'Update Grade', 'Grades Management', 'CS222-LEC', 'admin'),
('04/13/2024', '08:19:16', 'Add Grade', 'Grades Management', 'CS223', 'admin'),
('04/13/2024', '08:19:30', 'Delete Grade', 'Grades Management', 'CS222-LEC', 'admin'),
('04/13/2024', '08:27:30', 'Add Grade', 'Grades Management', '22-00589', 'admin'),
('04/21/2024', '01:34:54am', 'Delete', 'Students Management', '', 'admin'),
('04/21/2024', '01:34:58am', 'Delete', 'Students Management', '', 'admin'),
('04/21/2024', '01:38:21am', 'Create', 'Students Management', '10000', 'admin'),
('04/21/2024', '01:38:27am', 'Delete', 'Students Management', '10000', 'admin'),
('04/21/2024', '01:38:49am', 'Create', 'Students Management', '10000', 'admin'),
('04/21/2024', '02:26:44am', 'Create', 'Students Management', '22-00111', 'admin'),
('04/21/2024', '02:33:05am', 'Delete', 'Accounts Management', '22-00111', 'admin'),
('04/21/2024', '02:33:08am', 'Delete', 'Accounts Management', '10000', 'admin'),
('04/21/2024', '02:34:00am', 'Create', 'Students Management', '22-00111', 'admin'),
('04/21/2024', '02:56:52am', 'Delete', 'Accounts Management', '22-00111', 'admin'),
('04/21/2024', '02:57:21am', 'Create', 'Students Management', '22-00111', 'admin'),
('04/21/2024', '03:02:47am', 'Create', 'Students Management', '22-10000', 'admin'),
('04/21/2024', '03:40:49', 'Add', 'Grades Management', '22-00111', 'admin'),
('04/21/2024', '07:14:51', 'Update', 'Grades Management', '22-00111', 'admin'),
('04/22/2024', '12:04:29am', 'Change Password', 'Student Index', '22-00111', '22-00111'),
('04/22/2024', '01:47:54', 'Change Password', 'Student Index', '22-00111', '22-00111'),
('04/27/2024', '02:38:56', 'Delete', 'Accounts Management', 'admin', 'admin'),
('04/27/2024', '02:39:07', 'Create', 'Accounts Management', 'admin', 'admin'),
('05/01/2024', '10:56:05pm', 'Create', 'Students Management', '22-00211', 'admin'),
('05/03/2024', '02:40:11', 'Add', 'Grades Management', '22-00211', 'admin'),
('05/04/2024', '02:28:19am', 'Update', 'Students Management', '22-00211', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubject`
--

CREATE TABLE `tblsubject` (
  `subjectCode` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  `unit` varchar(5) NOT NULL,
  `course` varchar(50) NOT NULL,
  `createdBy` varchar(50) NOT NULL,
  `dateCreated` varchar(20) NOT NULL,
  `prerequisite1` varchar(30) NOT NULL,
  `prerequisite2` varchar(30) NOT NULL,
  `prerequisite3` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsubject`
--

INSERT INTO `tblsubject` (`subjectCode`, `description`, `unit`, `course`, `createdBy`, `dateCreated`, `prerequisite1`, `prerequisite2`, `prerequisite3`) VALUES
('CS222-LAB', 'Computer Architecture', '2', 'BS in Computer Science', 'admin', '03/26/2024', '', '', ''),
('CS222-LEC', 'Computer Architecture', '2', 'BS in Computer Science', 'admin', '03/31/2024', '', '', ''),
('CS223', 'Discrete Structure 2', '3', 'BS in Computer Science', 'admin', '04/11/2024', '', '', ''),
('GCAS-06', 'Science, Technology, Society', '2', 'Bachelor in Elementary Education', 'admin', '04/06/2024', '', '', ''),
('GCAS-07	', 'Purposive Communication', '3', 'BA in Psychology', 'admin', '04/07/2024', '', '', ''),
('GCAS-08', 'Practical Research', '3', 'BA in Psychology', 'admin', '04/07/2024', '', '', ''),
('ITC127', 'Advanced Database', '3', 'BS in Computer Science', 'admin', '04/11/2024', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stdaccounts`
--
ALTER TABLE `stdaccounts`
  ADD PRIMARY KEY (`studentNumber`);

--
-- Indexes for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD KEY `fk_studentNumber` (`studentNumber`),
  ADD KEY `fk_subjectCode` (`subjectCode`) USING BTREE;

--
-- Indexes for table `tblsubject`
--
ALTER TABLE `tblsubject`
  ADD PRIMARY KEY (`subjectCode`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD CONSTRAINT `fk_studentNumber` FOREIGN KEY (`studentNumber`) REFERENCES `stdaccounts` (`studentNumber`),
  ADD CONSTRAINT `fk_subjectCode` FOREIGN KEY (`subjectCode`) REFERENCES `tblsubject` (`subjectCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
