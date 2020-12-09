-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for focusacademy
CREATE DATABASE IF NOT EXISTS `focusacademy` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `focusacademy`;

-- Dumping structure for table focusacademy.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `max_students` tinyint(4) DEFAULT '10',
  `status` tinyint(4) DEFAULT '1',
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table focusacademy.classes: ~4 rows (approximately)
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` (`id`, `class_code`, `name`, `max_students`, `status`, `description`) VALUES
	(1, '4221312', 'Software Engineer - Class', 12, 1, 'Software Engineer is a good one'),
	(5, 'AuBVwynK', 'Hands on Programming', 10, 1, 'Hands on Programming - PHP'),
	(6, 'aw123314', 'Software Engineer - Mobile Development', 1, 1, 'Software Engineer - Mobile Development'),
	(7, '43121312asd231', 'Graphic Designer - Indesign | Photoshop | Illustra', 10, 1, 'Graphic Designer - Indesign | Photoshop | Illustra'),
	(9, 'aw123313', 'Web Developer', 5, 1, 'Web Developer');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;

-- Dumping structure for table focusacademy.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table focusacademy.students: ~5 rows (approximately)
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` (`id`, `class_id`, `first_name`, `last_name`, `date_of_birth`) VALUES
	(3, 5, 'Chua', 'Pa', '2020-12-11'),
	(6, 1, 'Sample1', 'sample1', '2020-12-25'),
	(7, 6, 'Shada', 'Huessein', '2020-12-15'),
	(9, 9, 'Wakani', 'Black', '2020-12-04'),
	(10, 7, 'Shatha', 'Mo', '2020-11-04');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
