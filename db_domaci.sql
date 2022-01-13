-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2021 at 07:29 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_domaci`
--

-- --------------------------------------------------------

--
-- Table structure for table `obligations`
--

CREATE TABLE `obligations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(240) NOT NULL,
  `date` date NOT NULL,
  `isDone` bit(1) NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obligations`
--

INSERT INTO `obligations` (`id`, `name`, `description`, `date`, `isDone`, `subject_id`) VALUES
(1, 'PHP Project', 'Create a website that uses pure PHP on the backend to communicate with the MySQL database. No JS frameworks can be used!', '2020-12-31', b'1', 1),
(8, 'Laravel Project', 'Build a (similar) website as in PHP project, but this time by using Laravel framework for PHP. Main accent shoud be on migrations!', '2021-01-20', b'0', 1),
(9, 'Tableau Project', 'Make one story with in total three dashboards containing at least 9 visualizations. Make sure you learn the theory - questions are on the channel.', '2020-11-17', b'1', 3),
(10, 'Second test', 'Second theoretical written test. Topics include Database Broker, Threads, Sockets and Databases, more generally in Java programming language.', '2020-12-17', b'1', 2),
(15, 'test', 'jedan dugacak opis za test\r\nmalo jos duzi', '2022-12-12', b'1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `ESPB` int(2) NOT NULL,
  `semester` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `ESPB`, `semester`) VALUES
(1, 'Internet Technologies', 5, 7),
(2, 'Software Design', 5, 7),
(3, 'Decision Support Systems', 4, 7),
(5, 'Databases', 5, 6),
(6, 'Information Systems Design', 5, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `obligations`
--
ALTER TABLE `obligations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Test` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `obligations`
--
ALTER TABLE `obligations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `obligations`
--
ALTER TABLE `obligations`
  ADD CONSTRAINT `Test` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
