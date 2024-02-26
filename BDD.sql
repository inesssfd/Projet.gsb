-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour location_gsb
DROP DATABASE IF EXISTS `location_gsb`;
CREATE DATABASE IF NOT EXISTS `location_gsb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `location_gsb`;

-- Listage de la structure de table location_gsb. appartement
DROP TABLE IF EXISTS `appartement`;
CREATE TABLE IF NOT EXISTS `appartement` (
  `num_appt` int NOT NULL AUTO_INCREMENT,
  `type_appt` varchar(255) DEFAULT NULL,
  `prix_loc` float(10,2) DEFAULT NULL,
  `prix_charge` float(10,2) DEFAULT NULL,
  `rue` varchar(255) DEFAULT NULL,
  `arrondisement` int DEFAULT NULL,
  `etage` int DEFAULT NULL,
  `ascenceur` tinyint(1) DEFAULT NULL,
  `preavis` int DEFAULT NULL,
  `date_libre` date DEFAULT NULL,
  `numero_prop` int DEFAULT NULL,
  PRIMARY KEY (`num_appt`),
  KEY `numero_prop` (`numero_prop`),
  CONSTRAINT `appartement_ibfk_1` FOREIGN KEY (`numero_prop`) REFERENCES `proprietaire` (`numero_prop`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table location_gsb.appartement : ~0 rows (environ)
INSERT INTO `appartement` (`num_appt`, `type_appt`, `prix_loc`, `prix_charge`, `rue`, `arrondisement`, `etage`, `ascenceur`, `preavis`, `date_libre`, `numero_prop`) VALUES
	(1, 'Stuuudio', 70.00, 20.00, 'ksjdcnj', 75015, 8, 1, 1, '2024-02-16', 1);

-- Listage de la structure de table location_gsb. demandeurs
DROP TABLE IF EXISTS `demandeurs`;
CREATE TABLE IF NOT EXISTS `demandeurs` (
  `num_demandeur` int NOT NULL AUTO_INCREMENT,
  `nom_demandeur` varchar(255) DEFAULT NULL,
  `prenom_demandeur` varchar(255) DEFAULT NULL,
  `adresse_demandeur` varchar(255) DEFAULT NULL,
  `cp_demandeur` varchar(10) DEFAULT NULL,
  `tel_demandeur` varchar(15) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `motdepasse_demandeur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`num_demandeur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table location_gsb.demandeurs : ~1 rows (environ)
INSERT INTO `demandeurs` (`num_demandeur`, `nom_demandeur`, `prenom_demandeur`, `adresse_demandeur`, `cp_demandeur`, `tel_demandeur`, `login`, `motdepasse_demandeur`) VALUES
	(1, 'ineeess', 'safady', 'zjfieci', 'lifuzhiuz', '0548458484', 'root', 'root');

-- Listage de la structure de table location_gsb. locataires
DROP TABLE IF EXISTS `locataires`;
CREATE TABLE IF NOT EXISTS `locataires` (
  `num_loc` int NOT NULL AUTO_INCREMENT,
  `nom_loc` varchar(255) DEFAULT NULL,
  `prenom_loc` varchar(255) DEFAULT NULL,
  `date_nais` date DEFAULT NULL,
  `tel_loc` varchar(15) DEFAULT NULL,
  `num_bancaire` varchar(20) DEFAULT NULL,
  `nom_banque` varchar(255) DEFAULT NULL,
  `cp_banque` varchar(10) DEFAULT NULL,
  `tel_banque` varchar(15) DEFAULT NULL,
  `login_loc` varchar(50) DEFAULT NULL,
  `motdepasse_loc` varchar(255) DEFAULT NULL,
  `num_appt` int DEFAULT NULL,
  PRIMARY KEY (`num_loc`),
  KEY `num_appt` (`num_appt`),
  CONSTRAINT `locataires_ibfk_1` FOREIGN KEY (`num_appt`) REFERENCES `appartement` (`num_appt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table location_gsb.locataires : ~0 rows (environ)

-- Listage de la structure de table location_gsb. proprietaire
DROP TABLE IF EXISTS `proprietaire`;
CREATE TABLE IF NOT EXISTS `proprietaire` (
  `numero_prop` int NOT NULL AUTO_INCREMENT,
  `nom_prop` varchar(255) DEFAULT NULL,
  `prenom_prop` varchar(255) DEFAULT NULL,
  `adresse_prop` varchar(255) DEFAULT NULL,
  `cp_prop` varchar(10) DEFAULT NULL,
  `tel_prop` varchar(15) DEFAULT NULL,
  `login_prop` varchar(50) DEFAULT NULL,
  `motdepasse_pro` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`numero_prop`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table location_gsb.proprietaire : ~0 rows (environ)
INSERT INTO `proprietaire` (`numero_prop`, `nom_prop`, `prenom_prop`, `adresse_prop`, `cp_prop`, `tel_prop`, `login_prop`, `motdepasse_pro`) VALUES
	(1, 'ineeess', 'safady', 'okndc', '9588', '65485', 'root', 'root');

-- Listage de la structure de table location_gsb. visite
DROP TABLE IF EXISTS `visite`;
CREATE TABLE IF NOT EXISTS `visite` (
  `id_visite` int NOT NULL AUTO_INCREMENT,
  `num_demandeur` int DEFAULT NULL,
  `date_visite` date DEFAULT NULL,
  `num_appt` int DEFAULT NULL,
  PRIMARY KEY (`id_visite`),
  KEY `num_demandeur` (`num_demandeur`),
  KEY `num_appt` (`num_appt`),
  CONSTRAINT `visite_ibfk_1` FOREIGN KEY (`num_demandeur`) REFERENCES `demandeurs` (`num_demandeur`),
  CONSTRAINT `visite_ibfk_2` FOREIGN KEY (`num_appt`) REFERENCES `appartement` (`num_appt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table location_gsb.visite : ~0 rows (environ)
INSERT INTO `visite` (`id_visite`, `num_demandeur`, `date_visite`, `num_appt`) VALUES
	(1, 1, '2024-02-28', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
