-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: le_quai_antique
-- ------------------------------------------------------
-- Server version	8.0.28

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
-- Table structure for table `allergen`
--

DROP TABLE IF EXISTS `allergen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `allergen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allergen`
--

/*!40000 ALTER TABLE `allergen` DISABLE KEYS */;
INSERT INTO `allergen` VALUES (1,'gluten'),(2,'crustacés'),(3,'oeufs'),(4,'poissons'),(5,'arachides'),(6,'soja'),(7,'lait'),(8,'fruits a coques'),(9,'celeri'),(10,'moutarde'),(11,'graines de sesame'),(12,'anhydride sulfureux et sulfites'),(13,'lupin'),(14,'mollusques');
/*!40000 ALTER TABLE `allergen` ENABLE KEYS */;

--
-- Table structure for table `foods`
--

DROP TABLE IF EXISTS `foods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `allergen` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(12) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_allergen` (`allergen`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foods`
--

/*!40000 ALTER TABLE `foods` DISABLE KEYS */;
INSERT INTO `foods` VALUES (2,'Salade césar','gluten , oeufs , poissons , soja , lait , moutarde , anhydride sulfureux et sulfites','Une délicieuse salade césar, authentique et fraiche qui saura vous ouvrir l\'appétit','2023-06-09 13:29:44','entree',5.99),(3,'Salade verte','','Une bonne salade verte','2023-06-09 15:59:09','entree',3.99),(4,'Brownie à la crème anglaise','gluten , oeufs , lait , fruits a coques','Un délicieux brownie, accompagné de sa crème anglaise maison ','2023-06-10 08:52:27','dessert',6.99),(7,'Steack haché avec des frites','lait , moutarde , anhydride sulfureux et sulfites , lupin','Un steack haché avec des frites sauce ketchup','2023-06-13 10:52:50','plat',12.88),(8,'Pate à la carbonara','oeufs , lait , anhydride sulfureux et sulfites','Des bonnes pâtes à la carbonara','2023-06-13 10:53:22','plat',18.99),(9,'Profiteroles','oeufs , lait , moutarde , mollusques','Des jolies profiteroles maison','2023-06-13 10:53:59','dessert',10.20);
/*!40000 ALTER TABLE `foods` ENABLE KEYS */;

--
-- Table structure for table `home_menu`
--

DROP TABLE IF EXISTS `home_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_menu` (
  `id` int NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `entree_id` int DEFAULT NULL,
  `plat_id` int DEFAULT NULL,
  `dessert_id` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entree_id` (`entree_id`),
  KEY `plat_id` (`plat_id`),
  KEY `dessert_id` (`dessert_id`),
  KEY `idx_menu_name` (`menu_name`),
  CONSTRAINT `home_menu_ibfk_1` FOREIGN KEY (`entree_id`) REFERENCES `foods` (`id`),
  CONSTRAINT `home_menu_ibfk_2` FOREIGN KEY (`plat_id`) REFERENCES `foods` (`id`),
  CONSTRAINT `home_menu_ibfk_3` FOREIGN KEY (`dessert_id`) REFERENCES `foods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_menu`
--

/*!40000 ALTER TABLE `home_menu` DISABLE KEYS */;
INSERT INTO `home_menu` VALUES (1,'menu midi',2,7,4,25.86),(2,'menu midi',2,8,4,31.97);
/*!40000 ALTER TABLE `home_menu` ENABLE KEYS */;

--
-- Table structure for table `menu_admin`
--

DROP TABLE IF EXISTS `menu_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entree_id` int DEFAULT NULL,
  `plat_id` int DEFAULT NULL,
  `dessert_id` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entree_id` (`entree_id`),
  KEY `plat_id` (`plat_id`),
  KEY `dessert_id` (`dessert_id`),
  CONSTRAINT `menu_admin_ibfk_1` FOREIGN KEY (`entree_id`) REFERENCES `foods` (`id`),
  CONSTRAINT `menu_admin_ibfk_2` FOREIGN KEY (`plat_id`) REFERENCES `foods` (`id`),
  CONSTRAINT `menu_admin_ibfk_3` FOREIGN KEY (`dessert_id`) REFERENCES `foods` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_admin`
--

/*!40000 ALTER TABLE `menu_admin` DISABLE KEYS */;
INSERT INTO `menu_admin` VALUES (1,2,7,4,25.86),(2,3,8,9,33.18),(3,2,8,4,31.97),(4,2,7,9,29.07),(5,3,7,9,27.07);
/*!40000 ALTER TABLE `menu_admin` ENABLE KEYS */;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number_of_seats` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `name_of_customer` varchar(255) NOT NULL,
  `allergens` varchar(255) NOT NULL,
  `menu` int NOT NULL,
  `meal_time` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name_of_customer` (`name_of_customer`),
  KEY `allergens` (`allergens`),
  KEY `menu` (`menu`),
  KEY `meal_time` (`meal_time`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`name_of_customer`) REFERENCES `users` (`lastName`),
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`allergens`) REFERENCES `foods` (`allergen`),
  CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`menu`) REFERENCES `menu_admin` (`id`),
  CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`meal_time`) REFERENCES `home_menu` (`menu_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day_of_week` int NOT NULL,
  `launch_opening_time` time DEFAULT NULL,
  `launch_closing_time` time DEFAULT NULL,
  `dinner_opening_time` time DEFAULT NULL,
  `dinner_closing_time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `schedule_chk_1` CHECK (((`day_of_week` >= 1) and (`day_of_week` <= 7)))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COMMENT='day_of_week values must be between 1(monday) and 7(sunday)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES (1,1,'11:30:00','13:30:00','18:30:00','23:30:00'),(2,2,'11:30:00','13:30:00','18:30:00','23:30:00'),(3,3,'11:30:00','13:30:00','18:30:00','23:30:00'),(4,4,'11:30:00','13:30:00','18:30:00','23:30:00'),(5,5,'11:30:00','13:30:00','18:30:00','23:30:00'),(6,6,'11:00:00','14:00:00','18:00:00','23:30:00'),(7,7,'11:00:00','14:00:00','00:00:00','00:00:00');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `companions` int DEFAULT '0',
  `allergen` varchar(5000) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `dateInscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(25) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_lastName` (`lastName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('7a6b1a53-248c-11ee-b5b1-98eecbb5f708','admin@admin.com','admin','admin','$2y$10$m.6NTV1Uq/0n2Gf8gjjmbemrCjhkpDcf99Na6nCCASGmcVItmbpCu',5,'arachides , lait , moutarde','0102030405','2023-07-17 12:27:06','admin'),('8a266f13-248c-11ee-b5b1-98eecbb5f708','user@user.com','user','user','$2y$10$p/sk4b9KV44h6a8Cv.FC.O3EtdKcjvS/NjX6Q9C4ox9VBgxs2pggy',5,'arachides , celeri , lupin','0203040506','2023-07-17 12:27:32','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Dumping routines for database 'le_quai_antique'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-17 12:47:24
