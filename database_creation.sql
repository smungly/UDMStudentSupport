-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2019 at 08:52 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pfe`
--

-- --------------------------------------------------------

--
-- Table structure for table `membres`
--

CREATE TABLE `membres` (
  `ID_MEMBRE` int(10) UNSIGNED NOT NULL,
  `NOM` varchar(50) NOT NULL,
  `PRENOM` varchar(30) NOT NULL,
  `EMAIL` varchar(1024) NOT NULL,
  `UNAME` varchar(35) NOT NULL,
  `MDP` varchar(100) NOT NULL,
  `SEXE` varchar(10) NOT NULL,
  `DDN` date NOT NULL,
  `TELEPHONE` varchar(13) NOT NULL,
  `DEPT` varchar(10) NOT NULL,
  `PHOTO` blob,
  `NATION` varchar(5) NOT NULL DEFAULT 'MU',
  `ADRESSE` varchar(150) NOT NULL,
  `VILLE` varchar(30) NOT NULL,
  `STATUT` varchar(10) NOT NULL DEFAULT 'Inactive',
  `CREATION_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TYPE` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `VERIF` varchar(50) NOT NULL,
  `TOKEN` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membres`
--

INSERT INTO `membres` (`ID_MEMBRE`, `NOM`, `PRENOM`, `EMAIL`, `UNAME`, `MDP`, `SEXE`, `DDN`, `TELEPHONE`, `DEPT`, `PHOTO`, `NATION`, `ADRESSE`, `VILLE`, `STATUT`, `CREATION_DATE`, `TYPE`, `VERIF`, `TOKEN`) VALUES
(1, 'UDM', 'Counsellor', 'counsellorUDM@gmail.com', 'counsellorUDM', '$2y$10$3nghS7DK4iRBCIjZZTdy1.9oXJZj1yCSnyZn2jWmf/Zy7Gwj6A4Yu', 'H', '1997-02-13', '', 'INFO', NULL, 'MU', 'UDM', '', 'Actif', '2019-03-10 13:55:04', 0, '6fad0a4068f698835192cdb5272e554f', ''),
(2, 'Mungly', 'Sydney', 'sydneymungly15@gmail.com', 'Sydney', '$2y$10$VhljAEBm3tOC3eTandetgu2m7mymy9VDfDPsIB1FBg7uZA/w7Dy7G', 'H', '1997-02-13', '23058941122', 'INFO', NULL, 'MU', '21, Premsing Baboollal Street, Roches-Brunes', 'BB-RH', 'Actif', '2019-03-07 20:30:44', 1, '2b2252275bad2669fb83ac1f68312e4b', '');

-- --------------------------------------------------------

--
-- Table structure for table `rdv`
--

CREATE TABLE `rdv` (
  `ID_RDV` int(11) NOT NULL,
  `ID_MEMBRE` int(10) UNSIGNED DEFAULT NULL,
  `ID_SERVICE` varchar(10) DEFAULT NULL,
  `DATE` date NOT NULL,
  `HEURE_DEBUT` time DEFAULT NULL,
  `HEURE_FIN` time DEFAULT NULL,
  `DESCRP` varchar(1500) DEFAULT NULL,
  `STATUT` enum('En Attente','Confirmes','Termines','Annules') NOT NULL DEFAULT 'En Attente',
  `RETOUR` varchar(2000) NOT NULL DEFAULT 'Aucun'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rdv`
--

INSERT INTO `rdv` (`ID_RDV`, `ID_MEMBRE`, `ID_SERVICE`, `DATE`, `HEURE_DEBUT`, `HEURE_FIN`, `DESCRP`, `STATUT`, `RETOUR`) VALUES
(6, 2, 'ETUD', '2019-03-21', '13:30:00', '14:30:00', 'nlkn', 'Confirmes', 'Aucun');

-- --------------------------------------------------------

--
-- Table structure for table `reinitialiser_mdp`
--

CREATE TABLE `reinitialiser_mdp` (
  `EMAIL` varchar(250) NOT NULL,
  `TOKEN` varchar(250) NOT NULL,
  `DATE_EXP` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reinitialiser_mdp`
--

INSERT INTO `reinitialiser_mdp` (`EMAIL`, `TOKEN`, `DATE_EXP`) VALUES
('kjWBDKJ@KDFK.COM', '0c959f9a1d7557a285302e739f96dd03354facd600', '2019-03-07 16:50:18'),
('sidneyment@gmail.com', 'c51c1bc89f6a7b57afb71802b854bc7103d6904ee4', '2019-03-07 16:50:48');

-- --------------------------------------------------------

--
-- Table structure for table `serv`
--

CREATE TABLE `serv` (
  `ID_SERVICE` varchar(10) NOT NULL,
  `LIBELLE_SER` varchar(10) DEFAULT NULL,
  `DUREE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `serv`
--

INSERT INTO `serv` (`ID_SERVICE`, `LIBELLE_SER`, `DUREE`) VALUES
('AUTRE', 'Autres', 60),
('CONS', 'Conseilles', 60),
('ETUD', 'Education', 60),
('PERS', 'Perso', 60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`ID_MEMBRE`);

--
-- Indexes for table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`ID_RDV`),
  ADD KEY `FK_SERV` (`ID_SERVICE`),
  ADD KEY `FK_STD` (`ID_MEMBRE`);

--
-- Indexes for table `serv`
--
ALTER TABLE `serv`
  ADD PRIMARY KEY (`ID_SERVICE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `membres`
--
ALTER TABLE `membres`
  MODIFY `ID_MEMBRE` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `ID_RDV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `FK_SERV` FOREIGN KEY (`ID_SERVICE`) REFERENCES `serv` (`ID_SERVICE`),
  ADD CONSTRAINT `FK_STD` FOREIGN KEY (`ID_MEMBRE`) REFERENCES `membres` (`ID_MEMBRE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
