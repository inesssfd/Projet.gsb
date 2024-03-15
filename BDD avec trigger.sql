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
CREATE DATABASE IF NOT EXISTS `location_gsb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `location_gsb`;

-- Listage de la structure de table location_gsb. appartement
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
  CONSTRAINT `appartement_ibfk_1` FOREIGN KEY (`numero_prop`) REFERENCES `proprietaire` (`numero_prop`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table location_gsb. demandeurs
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table location_gsb. locataire
CREATE TABLE IF NOT EXISTS `locataire` (
  `num_loc` int NOT NULL AUTO_INCREMENT,
  `nom_loc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prenom_loc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_nais` date DEFAULT NULL,
  `tel_loc` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `num_bancaire` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nom_banque` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cp_banque` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tel_banque` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `login_loc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `motdepasse_loc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `num_appt` int DEFAULT NULL,
  PRIMARY KEY (`num_loc`) USING BTREE,
  KEY `num_appt` (`num_appt`) USING BTREE,
  CONSTRAINT `locataires_ibfk_1` FOREIGN KEY (`num_appt`) REFERENCES `appartement` (`num_appt`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table location_gsb. proprietaire
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table location_gsb. visite
CREATE TABLE IF NOT EXISTS `visite` (
  `id_visite` int NOT NULL AUTO_INCREMENT,
  `num_demandeur` int DEFAULT NULL,
  `date_visite` date DEFAULT NULL,
  `num_appt` int DEFAULT NULL,
  PRIMARY KEY (`id_visite`),
  KEY `num_demandeur` (`num_demandeur`),
  KEY `num_appt` (`num_appt`),
  CONSTRAINT `visite_ibfk_1` FOREIGN KEY (`num_demandeur`) REFERENCES `demandeurs` (`num_demandeur`) ON DELETE CASCADE,
  CONSTRAINT `visite_ibfk_2` FOREIGN KEY (`num_appt`) REFERENCES `appartement` (`num_appt`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de déclencheur location_gsb. check_max_apartments
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `check_max_apartments` BEFORE INSERT ON `appartement` FOR EACH ROW BEGIN
    DECLARE owner_apartment_count INT;

    -- Compter le nombre d'appartements déjà ajoutés par le propriétaire
    SELECT COUNT(*)
    INTO owner_apartment_count
    FROM appartement
    WHERE numero_prop = NEW.numero_prop;

    -- Vérifier si le propriétaire a déjà atteint le nombre maximal d'appartements (par exemple, 5)
    IF owner_apartment_count >= 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Vous avez atteint le nombre maximal d\'appartements que vous pouvez ajouter.';
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
