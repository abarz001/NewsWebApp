-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: PROJECT
-- ------------------------------------------------------
-- Server version	8.0.26-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `PROJECT`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `PROJECT` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `PROJECT`;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USERS` (
  `Email` varchar(254) NOT NULL,
  `Registration_Date` datetime NOT NULL,
  `Password` char(32) NOT NULL,
  `Name_First` varchar(72) DEFAULT NULL,
  `Name_Last` varchar(128) DEFAULT NULL,
  `Organization` varchar(128) DEFAULT NULL,
  `Last_Login` datetime DEFAULT NULL,
  `Reset_Code` char(32) DEFAULT NULL,
  `Two_Factor_Code` char(32) DEFAULT NULL,
  `Two_Factor_Approved` bit(1) NOT NULL DEFAULT b'0',
  `Verification_Code` char(32) NOT NULL,
  `Admin_User` bit(1) NOT NULL DEFAULT b'0',
  `Rejected` bit(1) NOT NULL DEFAULT b'0',
  `Email_Verified` bit(1) NOT NULL DEFAULT b'0',
  `Approved_By_Admin` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USERS`
--

LOCK TABLES `USERS` WRITE;
/*!40000 ALTER TABLE `USERS` DISABLE KEYS */;
INSERT INTO `USERS` VALUES ('aran@odu.edu','2021-10-05 02:57:38','1f60713ff4f2b230c47c22d771cfb5fd','Aaron','Rodgers','NFL','2021-10-05 02:57:38',NULL,NULL,_binary '\0','d1063298a2c33a7ff6564a0f8fd99faa',_binary '\0',_binary '\0',_binary '\0',_binary '\0'),('aranbarzanji@gmail.com','2021-10-05 00:05:48','ae2b1fca515949e5d54fb22b8ed95575','Aran','Barzanji','Old Dominion University','2021-10-05 03:08:02',NULL,'c989a3386bcee70b54f546ddaf3ca9f0',_binary '','d1063298a2c33a7ff6564a0f8fd99faa',_binary '',_binary '\0',_binary '',_binary ''),('barzanjiaran@gmail.com','2021-10-05 03:06:11','28b662d883b6d76fd96e4ddc5e9ba780','Elon','Musk','Tesla','2021-10-05 03:11:56','a202807ed53eaca01f112566916314d1','73697298f282ceacf7af8de18a58efaf',_binary '','a15f708aac9eb5228842a89a0e371a5c',_binary '\0',_binary '\0',_binary '',_binary ''),('bill@odu.edu','2021-10-05 02:58:57','739969b53246b2c727850dbb3490ede6','Bill','Johnson','ODU','2021-10-05 02:58:57',NULL,NULL,_binary '\0','9f5518d13a21a4165bc0bc5d0463ffc5',_binary '\0',_binary '\0',_binary '\0',_binary '\0'),('elonmusk@odu.edu','2021-10-05 02:58:12','5d41402abc4b2a76b9719d911017c592','Elon','Musk','Tesla','2021-10-05 02:58:12',NULL,NULL,_binary '\0','05e84553173706d7d5a92a1622e42039',_binary '\0',_binary '',_binary '\0',_binary '\0');
/*!40000 ALTER TABLE `USERS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-05  3:27:05
