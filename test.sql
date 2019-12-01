-- MySQL dump 10.13  Distrib 8.0.18, for Linux (x86_64)
--
-- Host: localhost    Database: cbtm
-- ------------------------------------------------------
-- Server version	8.0.18

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
-- Temporary view structure for view `all_trajectories`
--

DROP TABLE IF EXISTS `all_trajectories`;
/*!50001 DROP VIEW IF EXISTS `all_trajectories`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `all_trajectories` AS SELECT 
 1 AS `nb_train`,
 1 AS `nom_dep`,
 1 AS `date_dep`,
 1 AS `heure_dep`,
 1 AS `nom_arr`,
 1 AS `date_arr`,
 1 AS `heure_arr`,
 1 AS `temps_arret`,
 1 AS `trains_string`,
 1 AS `path_string`,
 1 AS `time_string`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `arret`
--

DROP TABLE IF EXISTS `arret`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arret` (
  `nb_train` int(11) NOT NULL,
  `nom_dep` varchar(30) DEFAULT NULL,
  `date_dep` date NOT NULL,
  `heure_dep` time NOT NULL,
  `nom_arr` varchar(30) DEFAULT NULL,
  `date_arr` date NOT NULL,
  `heure_arr` time NOT NULL,
  `temps_arret` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`nb_train`,`date_dep`,`heure_dep`),
  CONSTRAINT `arret_ibfk_1` FOREIGN KEY (`nb_train`) REFERENCES `train` (`nb_train`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arret`
--

LOCK TABLES `arret` WRITE;
/*!40000 ALTER TABLE `arret` DISABLE KEYS */;
INSERT INTO `arret` (`nb_train`, `nom_dep`, `date_dep`, `heure_dep`, `nom_arr`, `date_arr`, `heure_arr`, `temps_arret`, `prix`) VALUES
(24675, 'Marseille Saint-Charles', '2019-11-22', '09:09:00', 'Avignon Centre', '2019-11-22', '10:21:00', 3, 20),
(24675, 'Avignon Centre', '2019-11-22', '10:24:00', 'Lyon Part-Dieu', '2019-11-22', '12:40:00', 10, 30),
(24675, 'Lyon Part-Dieu', '2019-11-22', '13:20:00', 'Avignon Centre', '2019-11-22', '15:41:00', 3, 30),
(24675, 'Lyon Part-Dieu', '2019-11-22', '15:20:00', 'Avignon Centre', '2019-11-22', '17:41:00', 3, 30),
(24675, 'Avignon Centre', '2019-11-22', '15:44:00', 'Marseille Saint-Charles', '2019-11-22', '16:55:00', 10, 20),
(24675, 'Marseille Saint-Charles', '2019-11-22', '17:03:00', 'Avignon Centre', '2019-11-22', '18:21:00', 3, 20),
(24675, 'Avignon Centre', '2019-11-22', '17:44:00', 'Marseille Saint-Charles', '2019-11-22', '18:53:00', 10, 20),
(24675, 'Avignon Centre', '2019-11-22', '18:24:00', 'Lyon Part-Dieu', '2019-11-22', '20:40:00', 10, 30),
(24675, 'Marseille Saint-Charles', '2019-11-23', '09:09:00', 'Avignon Centre', '2019-11-23', '10:21:00', 3, 20),
(24675, 'Avignon Centre', '2019-11-23', '10:24:00', 'Lyon Part-Dieu', '2019-11-23', '12:40:00', 10, 30),
(24675, 'Lyon Part-Dieu', '2019-11-23', '13:20:00', 'Avignon Centre', '2019-11-23', '15:41:00', 3, 30),
(24675, 'Lyon Part-Dieu', '2019-11-23', '15:20:00', 'Avignon Centre', '2019-11-23', '17:41:00', 3, 30),
(24675, 'Avignon Centre', '2019-11-23', '15:44:00', 'Marseille Saint-Charles', '2019-11-23', '16:55:00', 10, 20),
(24675, 'Marseille Saint-Charles', '2019-11-23', '17:03:00', 'Avignon Centre', '2019-11-23', '18:21:00', 3, 20),
(24675, 'Avignon Centre', '2019-11-23', '17:44:00', 'Marseille Saint-Charles', '2019-11-23', '18:53:00', 10, 20),
(24675, 'Avignon Centre', '2019-11-23', '18:24:00', 'Lyon Part-Dieu', '2019-11-23', '20:40:00', 10, 30),
(24675, 'Marseille Saint-Charles', '2019-11-24', '09:09:00', 'Avignon Centre', '2019-11-24', '10:21:00', 3, 20),
(24675, 'Avignon Centre', '2019-11-24', '10:24:00', 'Lyon Part-Dieu', '2019-11-24', '12:40:00', 10, 30),
(24675, 'Lyon Part-Dieu', '2019-11-24', '13:20:00', 'Avignon Centre', '2019-11-24', '15:41:00', 3, 30),
(24675, 'Lyon Part-Dieu', '2019-11-24', '15:20:00', 'Avignon Centre', '2019-11-24', '17:41:00', 3, 30),
(24675, 'Avignon Centre', '2019-11-24', '15:44:00', 'Marseille Saint-Charles', '2019-11-24', '16:55:00', 10, 20),
(24675, 'Marseille Saint-Charles', '2019-11-24', '17:03:00', 'Avignon Centre', '2019-11-24', '18:21:00', 3, 20),
(24675, 'Avignon Centre', '2019-11-24', '17:44:00', 'Marseille Saint-Charles', '2019-11-24', '18:53:00', 10, 20),
(24675, 'Avignon Centre', '2019-11-24', '18:24:00', 'Lyon Part-Dieu', '2019-11-24', '20:40:00', 10, 30);
/*!40000 ALTER TABLE `arret` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `arret_imp` BEFORE INSERT ON `arret` FOR EACH ROW begin IF (NEW.date_dep = NEW.date_arr AND NEW.heure_dep > NEW.heure_arr) OR (NEW.date_dep > NEW.date_arr) THEN
	SIGNAL SQLSTATE '45000';
END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `billet`
--

DROP TABLE IF EXISTS `billet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billet` (
  `numero` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nb_train` int(11) NOT NULL,
  `nom_arr` varchar(30) NOT NULL,
  `date_arr` date NOT NULL,
  `heure_arr` time NOT NULL,
  `nom_dep` varchar(30) NOT NULL,
  `date_dep` date NOT NULL,
  `heure_dep` time NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `nom_arr` (`nom_arr`),
  KEY `email` (`email`),
  KEY `nb_train` (`nb_train`),
  KEY `nom_dep` (`nom_dep`),
  KEY `date_arr` (`date_arr`),
  KEY `date_dep` (`date_dep`),
  KEY `heure_arr` (`heure_arr`),
  KEY `heure_dep` (`heure_dep`),
  CONSTRAINT `billet_ibfk_1` FOREIGN KEY (`nom_arr`) REFERENCES `gare` (`nom`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `billet_ibfk_2` FOREIGN KEY (`email`) REFERENCES `client` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `billet_ibfk_3` FOREIGN KEY (`nb_train`) REFERENCES `train` (`nb_train`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `billet_ibfk_4` FOREIGN KEY (`nom_dep`) REFERENCES `gare` (`nom`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billet`
--

LOCK TABLES `billet` WRITE;
/*!40000 ALTER TABLE `billet` DISABLE KEYS */;
/*!40000 ALTER TABLE `billet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `email` varchar(50) NOT NULL,
  `nom` varchar(15) NOT NULL,
  `prenom` varchar(15) NOT NULL,
  `age` int(11) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES ('alejandro_perez@yahoo.com','Pérez','Alejandro',12),('b.egidog@gmail.com','del Egido','Belén',25),('c.garciav@hotmail.com','García','Camilo',25);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gare`
--

DROP TABLE IF EXISTS `gare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gare` (
  `nom` varchar(30) NOT NULL,
  `ville` varchar(30) NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gare`
--

LOCK TABLES `gare` WRITE;
/*!40000 ALTER TABLE `gare` DISABLE KEYS */;
INSERT INTO `gare` VALUES ('Austerlitz','Paris'),('Avignon Centre','Avignon'),('Bordeaux-St-Jean','Bordeaux'),('Gare de Amiens','Amiens'),('Gare de Angoulême','Angoulême'),('Gare de Dijon','Dijon'),('Gare de Le Mans','Le Mans'),('Gare de Nancy','Nancy'),('Gare de Nantes','Nantes'),('Gare de Nice','Nice'),('Gare de Orléans','Orléans'),('Gare de Poitiers','Poitiers'),('Gare de Rennes','Rennes'),('Gare de Saint-Pierre-des-Corps','Saint Pierre des Corps'),('Gare de Strasbourg','Strasbourg'),('Gare de Tours','Tours'),('Gare de Vierzon','Vierzon'),('Les Aubrais','Orléans'),('Lille Flandres','Lille'),('Lyon Part-Dieu','Lyon'),('Lyon Perrache','Lyon'),('Marseille Saint-Charles','Marseille'),('Montpellier Saint-Roch','Montpellier'),('Paris Bercy','Paris'),('Paris Est','Paris'),('Paris Montparnasse','Paris'),('Paris Nord','Paris'),('Rouen Rive Droite','Rouen'),('Toulouse Matabiau','Toulouse');
/*!40000 ALTER TABLE `gare` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `place`
--

DROP TABLE IF EXISTS `place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `place` (
  `nb_place` int(11) NOT NULL,
  `nb_voiture` int(11) NOT NULL,
  `situation` varchar(15) NOT NULL,
  PRIMARY KEY (`nb_place`,`nb_voiture`),
  KEY `nb_voiture` (`nb_voiture`),
  CONSTRAINT `place_ibfk_1` FOREIGN KEY (`nb_voiture`) REFERENCES `voiture` (`nb_voiture`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `place`
--

LOCK TABLES `place` WRITE;
/*!40000 ALTER TABLE `place` DISABLE KEYS */;
/*!40000 ALTER TABLE `place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `possede`
--

DROP TABLE IF EXISTS `possede`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `possede` (
  `email` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `possede_ibfk_1` FOREIGN KEY (`email`) REFERENCES `client` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `possede`
--

LOCK TABLES `possede` WRITE;
/*!40000 ALTER TABLE `possede` DISABLE KEYS */;
/*!40000 ALTER TABLE `possede` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reduction`
--

DROP TABLE IF EXISTS `reduction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reduction` (
  `type` varchar(15) NOT NULL,
  `pourcentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reduction`
--

LOCK TABLES `reduction` WRITE;
/*!40000 ALTER TABLE `reduction` DISABLE KEYS */;
INSERT INTO `reduction` (`type`, `pourcentage`) VALUES
('enfant', 75),
('jeune', 25),
('senior', 60);
/*!40000 ALTER TABLE `reduction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `train`
--

DROP TABLE IF EXISTS `train`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `train` (
  `nb_train` int(11) NOT NULL,
  `max_voitures` int(11) NOT NULL,
  PRIMARY KEY (`nb_train`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `train`
--

LOCK TABLES `train` WRITE;
/*!40000 ALTER TABLE `train` DISABLE KEYS */;
INSERT INTO `train` VALUES (24155,5),(24675,4),(37104,6),(38751,5),(39714,3),(40187,4),(41605,4),(42048,5),(45734,4),(51334,3),(54114,4),(58260,6),(61927,4),(63699,6),(67330,4),(69511,3),(70533,3),(71149,4),(78473,6),(84327,4),(86888,5),(87158,3),(88716,5),(91109,6),(92111,4);
/*!40000 ALTER TABLE `train` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voiture`
--

DROP TABLE IF EXISTS `voiture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voiture` (
  `nb_train` int(11) NOT NULL,
  `nb_voiture` int(11) NOT NULL,
  `quant_places` int(11) NOT NULL,
  PRIMARY KEY (`nb_voiture`),
  KEY `nb_train` (`nb_train`),
  CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`nb_train`) REFERENCES `train` (`nb_train`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voiture`
--

LOCK TABLES `voiture` WRITE;
/*!40000 ALTER TABLE `voiture` DISABLE KEYS */;
INSERT INTO `voiture` VALUES (63699,129045,50),(38751,258191,50),(87158,312946,50),(38751,444301,50),(63699,475723,50),(39714,543055,50),(38751,547833,50),(63699,557064,50),(39714,618251,50),(24675,704698,50),(63699,737148,50),(38751,783925,50),(87158,838682,50),(24675,852617,50),(39714,883749,50),(63699,913801,50),(24675,929888,50),(24675,950081,50),(87158,984043,50),(38751,991490,50),(63699,996895,50),
(45734, 101, 50),
(45734, 102, 50),
(45734, 103, 50),
(45734, 104, 50),
(51334, 111, 50),
(51334, 112, 50),
(51334, 113, 50),
(24155, 123, 50),
(24155, 124, 50),
(24155, 125, 50),
(24155, 126, 50),
(24155, 127, 50),
(24675, 234, 50),
(24675, 235, 50),
(24675, 236, 50),
(24675, 237, 50),
(37104, 345, 50),
(37104, 346, 50),
(37104, 347, 50),
(37104, 348, 50),
(37104, 349, 50),
(37104, 350, 50),
(38751, 456, 50),
(38751, 457, 50),
(38751, 458, 50),
(38751, 459, 50),
(38751, 460, 50),
(39714, 567, 50),
(39714, 568, 50),
(39714, 569, 50),
(40187, 678, 50),
(40187, 679, 50),
(40187, 680, 50),
(40187, 681, 50),
(41605, 789, 50),
(41605, 790, 50),
(41605, 791, 50),
(41605, 792, 50),
(42048, 891, 50),
(42048, 892, 50),
(42048, 893, 50),
(42048, 894, 50),
(42048, 895, 50),
(54114, 1210, 50),
(54114, 1211, 50),
(54114, 1212, 50),
(54114, 1213, 50),
(58260, 1310, 50),
(58260, 1311, 50),
(58260, 1312, 50),
(58260, 1313, 50),
(58260, 1314, 50),
(58260, 1315, 50),
(61927, 1410, 50),
(61927, 1411, 50),
(61927, 1412, 50),
(61927, 1413, 50),
(63699, 1510, 50),
(63699, 1511, 50),
(63699, 1512, 50),
(63699, 1513, 50),
(63699, 1514, 50),
(63699, 1515, 50),
(67330, 1610, 50),
(67330, 1611, 50),
(67330, 1612, 50),
(67330, 1613, 50),
(69511, 1710, 50),
(69511, 1711, 50),
(69511, 1712, 50),
(70533, 1810, 50),
(70533, 1811, 50),
(70533, 1812, 50),
(78473, 1910, 50),
(78473, 1911, 50),
(78473, 1912, 50),
(78473, 1913, 50),
(78473, 1914, 50),
(78473, 1915, 50),
(84327, 2000, 50),
(84327, 2001, 50),
(84327, 2002, 50),
(84327, 2003, 50),
(86888, 2100, 50),
(86888, 2101, 50),
(86888, 2102, 50),
(86888, 2103, 50),
(86888, 2104, 50),
(87158, 2200, 50),
(87158, 2201, 50),
(87158, 2202, 50),
(88716, 2300, 50),
(88716, 2301, 50),
(88716, 2302, 50),
(88716, 2303, 50),
(88716, 2304, 50),
(91109, 2400, 50),
(91109, 2401, 50),
(91109, 2402, 50),
(91109, 2403, 50),
(91109, 2404, 50),
(91109, 2405, 50),
(92111, 2500, 50),
(92111, 2501, 50),
(92111, 2502, 50),
(92111, 2503, 50);
/*!40000 ALTER TABLE `voiture` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `limit_train` BEFORE INSERT ON `voiture` FOR EACH ROW begin
declare nb_max_voitures INT;
declare current_voitures INT;
select COUNT(*) + 1 into current_voitures FROM voiture AS V WHERE V.nb_train = new.nb_train;
SELECT max_voitures into nb_max_voitures FROM train as T WHERE T.nb_train = new.nb_train;
if current_voitures > nb_max_voitures then
SIGNAL SQLSTATE '45000';
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `all_trajectories`
--

/*!50001 DROP VIEW IF EXISTS `all_trajectories`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `all_trajectories` AS with recursive `trajectory` (`nb_train`,`nom_dep`,`date_dep`,`heure_dep`,`nom_arr`,`date_arr`,`heure_arr`,`temps_arret`,`trains_string`,`path_string`,`time_string`) as (select `arret`.`nb_train` AS `nb_train`,`arret`.`nom_dep` AS `nom_dep`,`arret`.`date_dep` AS `date_dep`,`arret`.`heure_dep` AS `heure_dep`,`arret`.`nom_arr` AS `nom_arr`,`arret`.`date_arr` AS `date_arr`,`arret`.`heure_arr` AS `heure_arr`,`arret`.`temps_arret` AS `temps_arret`,concat(cast(`arret`.`nb_train` as char(1000) charset utf8mb4),'.') AS `trains_string`,concat(cast(`arret`.`nom_dep` as char(1000) charset utf8mb4),'.',cast(`arret`.`nom_arr` as char(1000) charset utf8mb4),'.') AS `path_string`,concat(cast(unix_timestamp(timestamp(`arret`.`date_dep`,`arret`.`heure_dep`)) as char(1000) charset utf8mb4),'_',cast(unix_timestamp(timestamp(`arret`.`date_arr`,`arret`.`heure_arr`)) as char(1000) charset utf8mb4),'.') AS `time_string` from `arret` union all select `a2`.`nb_train` AS `nb_train`,`ty`.`nom_dep` AS `nom_dep`,`ty`.`date_dep` AS `date_dep`,`ty`.`heure_dep` AS `heure_dep`,`a2`.`nom_arr` AS `nom_arr`,`a2`.`date_arr` AS `date_arr`,`a2`.`heure_arr` AS `heure_arr`,`a2`.`temps_arret` AS `temps_arret`,concat(`ty`.`trains_string`,cast(`a2`.`nb_train` as char(1000) charset utf8mb4),'.') AS `trains_string`,concat(`ty`.`path_string`,cast(`a2`.`nom_arr` as char(1000) charset utf8mb4),'.') AS `path_string`,concat(`ty`.`time_string`,cast(unix_timestamp(timestamp(`a2`.`date_dep`,`a2`.`heure_dep`)) as char(1000) charset utf8mb4),'_',cast(unix_timestamp(timestamp(`a2`.`date_arr`,`a2`.`heure_arr`)) as char(1000) charset utf8mb4),'.') AS `time_string` from (`arret` `a2` join `trajectory` `ty` on((`a2`.`nom_dep` = `ty`.`nom_arr`))) where (((((cast(unix_timestamp(timestamp(`ty`.`date_arr`,`ty`.`heure_arr`)) as unsigned) + (`ty`.`temps_arret` * 60)) = cast(unix_timestamp(timestamp(`a2`.`date_dep`,`a2`.`heure_dep`)) as unsigned)) and (`ty`.`nb_train` = `a2`.`nb_train`)) or (((cast(unix_timestamp(timestamp(`ty`.`date_arr`,`ty`.`heure_arr`)) as unsigned) + (`ty`.`temps_arret` * 60)) < cast(unix_timestamp(timestamp(`a2`.`date_dep`,`a2`.`heure_dep`)) as unsigned)) and (`ty`.`nb_train` <> `a2`.`nb_train`))) and (not((`ty`.`path_string` like convert(concat('%',`a2`.`nom_arr`,'.%') using utf8mb4)))))) select `trajectory`.`nb_train` AS `nb_train`,`trajectory`.`nom_dep` AS `nom_dep`,`trajectory`.`date_dep` AS `date_dep`,`trajectory`.`heure_dep` AS `heure_dep`,`trajectory`.`nom_arr` AS `nom_arr`,`trajectory`.`date_arr` AS `date_arr`,`trajectory`.`heure_arr` AS `heure_arr`,`trajectory`.`temps_arret` AS `temps_arret`,`trajectory`.`trains_string` AS `trains_string`,`trajectory`.`path_string` AS `path_string`,`trajectory`.`time_string` AS `time_string` from `trajectory` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-22 21:03:55
