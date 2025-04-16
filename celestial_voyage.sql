/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `celestial_voyage` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `celestial_voyage`;

CREATE TABLE IF NOT EXISTS `comments` (
  `ID_Comments` int NOT NULL AUTO_INCREMENT,
  `Comments_Users` int NOT NULL,
  `Date` datetime NOT NULL,
  `Text` text NOT NULL,
  `Comments_Cosmic-objects` int NOT NULL,
  `Likes` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_Comments`),
  KEY `FK_Comments_Users` (`Comments_Users`),
  KEY `FK_Comments_Cosmic-objects` (`Comments_Cosmic-objects`),
  CONSTRAINT `FK_Comments_Cosmic-objects` FOREIGN KEY (`Comments_Cosmic-objects`) REFERENCES `cosmic-objects` (`ID_Cosmic-objects`),
  CONSTRAINT `FK_Comments_Users` FOREIGN KEY (`Comments_Users`) REFERENCES `users` (`ID_users`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `contact-me` (
  `ID_contact-me` int NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Subject` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_contact-me`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `cosmic-objects` (
  `ID_Cosmic-objects` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Content` text NOT NULL,
  `Mass` float NOT NULL,
  `Area` float NOT NULL,
  `Speed` float NOT NULL,
  `Cosmic-objects_object-class` int NOT NULL,
  `Cosmic-objects_type` int NOT NULL,
  `Views` int unsigned NOT NULL DEFAULT '0',
  `Object` blob NOT NULL,
  PRIMARY KEY (`ID_Cosmic-objects`),
  KEY `FK_Cosmic-objects_type` (`Cosmic-objects_type`),
  KEY `FK_Cosmic-objects_object-class` (`Cosmic-objects_object-class`),
  CONSTRAINT `FK_Cosmic-objects_object-class` FOREIGN KEY (`Cosmic-objects_object-class`) REFERENCES `object-class` (`ID_Object-class`),
  CONSTRAINT `FK_Cosmic-objects_type` FOREIGN KEY (`Cosmic-objects_type`) REFERENCES `type` (`ID_Type`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `cosmic_calendar` (
  `ID_Calendar` int NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `Content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Calendar`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `object-class` (
  `ID_Object-class` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID_Object-class`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `type` (
  `ID_Type` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_Type`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `ID_users` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Surname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Birthdate` date NOT NULL,
  `Password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Avatar` blob,
  `Admin` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_users`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
