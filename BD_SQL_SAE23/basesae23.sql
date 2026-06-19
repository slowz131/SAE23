-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 19 Juin 2026 à 23:33
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `sae23`
--
CREATE DATABASE IF NOT EXISTS `sae23` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sae23`;

-- --------------------------------------------------------

--
-- Structure de la table `Administration`
--

DROP TABLE IF EXISTS `Administration`;
CREATE TABLE IF NOT EXISTS `Administration` (
  `LOGIN_ADMIN` varchar(25) NOT NULL,
  `Mdp_admin` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Administration`
--

INSERT INTO `Administration` (`LOGIN_ADMIN`, `Mdp_admin`) VALUES
('admin_sae23', 'je_suis_admin_sae23');

-- --------------------------------------------------------

--
-- Structure de la table `Batiment`
--

DROP TABLE IF EXISTS `Batiment`;
CREATE TABLE IF NOT EXISTS `Batiment` (
  `ID_BAT` varchar(1) NOT NULL,
  `Nom_bat` varchar(25) DEFAULT NULL,
  `Login` varchar(25) DEFAULT NULL,
  `Mdp` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Batiment`
--

INSERT INTO `Batiment` (`ID_BAT`, `Nom_bat`, `Login`, `Mdp`) VALUES
('B', 'GIM/INFO', 'gestionnaire_batB', 'jesuisgestionnaire_batB'),
('E', 'RT/CS', 'gestionnaire_batE', 'jesuisgestionnaire_batE');

-- --------------------------------------------------------

--
-- Structure de la table `Capteur`
--

DROP TABLE IF EXISTS `Capteur`;
CREATE TABLE IF NOT EXISTS `Capteur` (
  `NOM_CAPTEUR` varchar(10) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Unite` varchar(8) NOT NULL,
  `NOM_SALLE` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Capteur`
--

INSERT INTO `Capteur` (`NOM_CAPTEUR`, `Type`, `Unite`, `NOM_SALLE`) VALUES
('AM107-16', 'Humidity', 'test', 'B109'),
('AM107-3', 'Temperature', '°C', 'B111'),
('AM107-32', 'Temperature', '°C', 'E102'),
('AM107-38', 'CO2', 'PPM', 'E208'),
('AM107-5', 'CO2', 'PPM', 'B202');

-- --------------------------------------------------------

--
-- Structure de la table `Mesure`
--

DROP TABLE IF EXISTS `Mesure`;
CREATE TABLE IF NOT EXISTS `Mesure` (
`ID_MESURE` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Horaire` time NOT NULL,
  `Valeur` float(6,1) NOT NULL,
  `NOM_CAPTEUR` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=204 ;

--
-- Contenu de la table `Mesure`
--

INSERT INTO `Mesure` (`ID_MESURE`, `Date`, `Horaire`, `Valeur`, `NOM_CAPTEUR`) VALUES
(199, '2026-06-19', '23:30:02', 29.8, 'AM107-3'),
(200, '2026-06-19', '23:30:02', 403.0, 'AM107-38'),
(201, '2026-06-19', '23:30:02', 28.9, 'AM107-32'),
(202, '2026-06-19', '23:30:02', 435.0, 'AM107-5'),
(203, '2026-06-19', '23:30:02', 46.5, 'AM107-16');

-- --------------------------------------------------------

--
-- Structure de la table `Salle`
--

DROP TABLE IF EXISTS `Salle`;
CREATE TABLE IF NOT EXISTS `Salle` (
  `NOM_SALLE` varchar(4) NOT NULL,
  `Type` varchar(2) DEFAULT NULL,
  `Capacite` tinyint(3) unsigned DEFAULT NULL,
  `ID_BAT` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Salle`
--

INSERT INTO `Salle` (`NOM_SALLE`, `Type`, `Capacite`, `ID_BAT`) VALUES
('B109', 'TP', 24, 'B'),
('B111', 'TP', 17, 'B'),
('B202', 'TP', 17, 'B'),
('E102', 'TP', 17, 'E'),
('E208', 'TP', 17, 'E');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Administration`
--
ALTER TABLE `Administration`
 ADD PRIMARY KEY (`LOGIN_ADMIN`);

--
-- Index pour la table `Batiment`
--
ALTER TABLE `Batiment`
 ADD PRIMARY KEY (`ID_BAT`);

--
-- Index pour la table `Capteur`
--
ALTER TABLE `Capteur`
 ADD PRIMARY KEY (`NOM_CAPTEUR`), ADD KEY `NOM_SALLE` (`NOM_SALLE`);

--
-- Index pour la table `Mesure`
--
ALTER TABLE `Mesure`
 ADD PRIMARY KEY (`ID_MESURE`), ADD KEY `NOM_CAPTEUR` (`NOM_CAPTEUR`);

--
-- Index pour la table `Salle`
--
ALTER TABLE `Salle`
 ADD PRIMARY KEY (`NOM_SALLE`), ADD KEY `ID_BAT` (`ID_BAT`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Mesure`
--
ALTER TABLE `Mesure`
MODIFY `ID_MESURE` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=204;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Capteur`
--
ALTER TABLE `Capteur`
ADD CONSTRAINT `FK_salle` FOREIGN KEY (`NOM_SALLE`) REFERENCES `Salle` (`NOM_SALLE`);

--
-- Contraintes pour la table `Mesure`
--
ALTER TABLE `Mesure`
ADD CONSTRAINT `FK_capteur` FOREIGN KEY (`NOM_CAPTEUR`) REFERENCES `Capteur` (`NOM_CAPTEUR`);

--
-- Contraintes pour la table `Salle`
--
ALTER TABLE `Salle`
ADD CONSTRAINT `FK_bat` FOREIGN KEY (`ID_BAT`) REFERENCES `Batiment` (`ID_BAT`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
