-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: salary_management_system
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
  `EID` int NOT NULL AUTO_INCREMENT,
  `EName` varchar(100) DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  PRIMARY KEY (`EID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (11,'Alice Smith','Male','alice@example.com','2025-08-01');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_leave`
--

DROP TABLE IF EXISTS `employee_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_leave` (
  `LID` int NOT NULL AUTO_INCREMENT,
  `EID` int DEFAULT NULL,
  `L_month` varchar(20) DEFAULT NULL,
  `L_days` int DEFAULT NULL,
  PRIMARY KEY (`LID`),
  KEY `EID` (`EID`),
  CONSTRAINT `employee_leave_ibfk_1` FOREIGN KEY (`EID`) REFERENCES `employee` (`EID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_leave`
--

LOCK TABLES `employee_leave` WRITE;
/*!40000 ALTER TABLE `employee_leave` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_salary`
--

DROP TABLE IF EXISTS `employee_salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_salary` (
  `EID` int DEFAULT NULL,
  `SID` int DEFAULT NULL,
  KEY `EID` (`EID`),
  KEY `SID` (`SID`),
  CONSTRAINT `employee_salary_ibfk_1` FOREIGN KEY (`EID`) REFERENCES `employee` (`EID`) ON DELETE CASCADE,
  CONSTRAINT `employee_salary_ibfk_2` FOREIGN KEY (`SID`) REFERENCES `salary` (`SID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_salary`
--

LOCK TABLES `employee_salary` WRITE;
/*!40000 ALTER TABLE `employee_salary` DISABLE KEYS */;
INSERT INTO `employee_salary` VALUES (11,1);
/*!40000 ALTER TABLE `employee_salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empsalary_audit`
--

DROP TABLE IF EXISTS `empsalary_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empsalary_audit` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `EID` int DEFAULT NULL,
  `NewSID` int DEFAULT NULL,
  `OldSID` int DEFAULT NULL,
  `ChangingDate` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empsalary_audit`
--

LOCK TABLES `empsalary_audit` WRITE;
/*!40000 ALTER TABLE `empsalary_audit` DISABLE KEYS */;
INSERT INTO `empsalary_audit` VALUES (1,3,1,NULL,'2025-05-29'),(2,4,1,NULL,'2025-05-29'),(3,5,2,NULL,'2025-05-30'),(4,2,3,2,'2025-05-30'),(5,6,2,NULL,'2025-06-10'),(6,8,1,NULL,'2025-10-27'),(7,11,1,NULL,'2025-10-27');
/*!40000 ALTER TABLE `empsalary_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund`
--

DROP TABLE IF EXISTS `fund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fund` (
  `FID` int NOT NULL AUTO_INCREMENT,
  `Fund_amount` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`FID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fund`
--

LOCK TABLES `fund` WRITE;
/*!40000 ALTER TABLE `fund` DISABLE KEYS */;
INSERT INTO `fund` VALUES (1,2001000.00),(2,1000000.00);
/*!40000 ALTER TABLE `fund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund_audit`
--

DROP TABLE IF EXISTS `fund_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fund_audit` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NewFund` decimal(15,2) DEFAULT NULL,
  `OldFund` decimal(15,2) DEFAULT NULL,
  `T_Date` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fund_audit`
--

LOCK TABLES `fund_audit` WRITE;
/*!40000 ALTER TABLE `fund_audit` DISABLE KEYS */;
INSERT INTO `fund_audit` VALUES (1,1001000.00,1000000.00,'2025-05-30'),(2,2001000.00,1001000.00,'2025-10-27');
/*!40000 ALTER TABLE `fund_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary`
--

DROP TABLE IF EXISTS `salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salary` (
  `SID` int NOT NULL AUTO_INCREMENT,
  `Basic` decimal(10,2) DEFAULT NULL,
  `Allowance` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary`
--

LOCK TABLES `salary` WRITE;
/*!40000 ALTER TABLE `salary` DISABLE KEYS */;
INSERT INTO `salary` VALUES (1,30000.00,5000.00),(2,40000.00,8000.00),(3,50000.00,10000.00),(4,30000.00,5000.00),(5,40000.00,8000.00),(6,50000.00,10000.00);
/*!40000 ALTER TABLE `salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terminated_employees`
--

DROP TABLE IF EXISTS `terminated_employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terminated_employees` (
  `TerminationID` int NOT NULL AUTO_INCREMENT,
  `EID` int DEFAULT NULL,
  `EName` varchar(100) DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  `TerminationDate` date DEFAULT NULL,
  `Reason` text,
  PRIMARY KEY (`TerminationID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terminated_employees`
--

LOCK TABLES `terminated_employees` WRITE;
/*!40000 ALTER TABLE `terminated_employees` DISABLE KEYS */;
INSERT INTO `terminated_employees` VALUES (1,3,'Carol',NULL,NULL,'2025-05-29','2025-05-29','3wfrgt'),(2,4,'Carol',NULL,NULL,'2025-05-29','2025-05-29','mn'),(3,1,'Alice Smith',NULL,NULL,'2023-01-10','2025-05-30','hiuh'),(4,2,'Bob Johnson',NULL,NULL,'2023-03-15','2025-10-27','XYZ'),(5,5,'Carol',NULL,NULL,'2025-05-30','2025-10-27','XYZ'),(6,6,'john',NULL,NULL,'2025-06-10','2025-10-27','XYZ'),(7,8,'Alice ',NULL,NULL,'2025-08-01','2025-10-27','XYZ'),(8,9,'Alice Smith',NULL,NULL,'2023-01-10','2025-10-27','XYZ'),(9,10,'Bob Johnson',NULL,NULL,'2023-03-15','2025-10-27','XYZ');
/*!40000 ALTER TABLE `terminated_employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transection`
--

DROP TABLE IF EXISTS `transection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transection` (
  `TID` int NOT NULL AUTO_INCREMENT,
  `EID` int DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `T_Date` date DEFAULT NULL,
  `S_month` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`TID`),
  KEY `EID` (`EID`),
  CONSTRAINT `transection_ibfk_1` FOREIGN KEY (`EID`) REFERENCES `employee` (`EID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transection`
--

LOCK TABLES `transection` WRITE;
/*!40000 ALTER TABLE `transection` DISABLE KEYS */;
/*!40000 ALTER TABLE `transection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transection_log`
--

DROP TABLE IF EXISTS `transection_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transection_log` (
  `LogID` int NOT NULL AUTO_INCREMENT,
  `TID` int DEFAULT NULL,
  `EID` int DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `T_Date` date DEFAULT NULL,
  `LogTime` datetime DEFAULT NULL,
  PRIMARY KEY (`LogID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transection_log`
--

LOCK TABLES `transection_log` WRITE;
/*!40000 ALTER TABLE `transection_log` DISABLE KEYS */;
INSERT INTO `transection_log` VALUES (1,1,1,35000.00,'2025-05-29','2025-05-29 19:42:02'),(2,2,2,48000.00,'2025-05-30','2025-05-30 10:39:34'),(3,3,2,60000.00,'2025-05-30','2025-05-30 12:25:50'),(4,4,2,60000.00,'2025-05-30','2025-05-30 12:25:56'),(5,5,2,60000.00,'2025-05-30','2025-05-30 12:26:02'),(6,6,2,60000.00,'2025-06-10','2025-06-10 12:14:59'),(7,7,5,48000.00,'2025-06-17','2025-06-17 19:06:47'),(8,8,5,48000.00,'2025-06-17','2025-06-17 19:07:58'),(9,9,2,60000.00,'2025-10-26','2025-10-27 01:24:02');
/*!40000 ALTER TABLE `transection_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-23 18:57:23
