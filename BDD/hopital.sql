-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 23 Avril 2017 à 21:08
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hopital`
--

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

CREATE TABLE `horaires` (
  `id` int(11) NOT NULL,
  `idMedecin` int(11) NOT NULL,
  `debut` time NOT NULL,
  `fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `horaires`
--

INSERT INTO `horaires` (`id`, `idMedecin`, `debut`, `fin`) VALUES
(1, 2, '08:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `idPatient` int(11) NOT NULL,
  `idMedecin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `rdv`
--

INSERT INTO `rdv` (`id`, `date`, `heure`, `idPatient`, `idMedecin`) VALUES
(1, '2017-03-28', '11:10:30', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `code` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `service`
--

INSERT INTO `service` (`code`, `libelle`) VALUES
(1, 'chirurgie'),
(2, 'pediatrie');

-- --------------------------------------------------------

--
-- Structure de la table `typeutilisateur`
--

CREATE TABLE `typeutilisateur` (
  `code` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typeutilisateur`
--

INSERT INTO `typeutilisateur` (`code`, `libelle`) VALUES
(1, 'medecin'),
(2, 'patient'),
(3, 'secretaire');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `mdp` char(64) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` char(10) DEFAULT NULL,
  `dateNaiss` date NOT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `codePostal` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `codeTypeUtilisateur` int(11) NOT NULL,
  `codeService` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `mdp`, `nom`, `prenom`, `telephone`, `dateNaiss`, `adresse`, `codePostal`, `ville`, `codeTypeUtilisateur`, `codeService`) VALUES
(1, 'apicavet@orange.fr', 'fcddb3ba91ab8b4ff38a08424f343f7f465e93ac1e61926e2cf283b9d493ce09', 'patpik', 'patalex', '0606060606', '2017-03-08', 'patAdresse', '59510', 'patHem', 2, NULL),
(2, 'apicavet@hotmail.fr', 'fcddb3ba91ab8b4ff38a08424f343f7f465e93ac1e61926e2cf283b9d493ce09', 'picavet', 'alexandre', '0606060606', '1998-07-16', 'mon adresse', '59510', 'hem', 1, 1),
(3, 'gungor.salih@outlook.fr', 'aa', 'gungor', 'salih', '0673087798', '1988-08-20', '137 rue colbert', '59200', 'TOURCOING', 2, NULL),
(4, 'salut@hotmail.fr', '961b6dd3ede3cb8ecbaacbd68de040cd78eb2ed5889130cceb4c49268ea4d506', 'gungor', 'salih', '0600000000', '1999-05-14', '87 rue grand place', '59100', 'roubaix', 2, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idMedecin` (`idMedecin`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPatient` (`idPatient`,`idMedecin`),
  ADD KEY `idMedecin` (`idMedecin`),
  ADD KEY `idPatient_2` (`idPatient`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `typeutilisateur`
--
ALTER TABLE `typeutilisateur`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codeTypeUtilisateur` (`codeTypeUtilisateur`,`codeService`),
  ADD KEY `codeService` (`codeService`),
  ADD KEY `codeTypeUtilisateur_2` (`codeTypeUtilisateur`),
  ADD KEY `codeTypeUtilisateur_3` (`codeTypeUtilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `typeutilisateur`
--
ALTER TABLE `typeutilisateur`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD CONSTRAINT `horaires_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `rdv_ibfk_1` FOREIGN KEY (`idPatient`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `rdv_ibfk_2` FOREIGN KEY (`idMedecin`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`codeTypeUtilisateur`) REFERENCES `typeutilisateur` (`code`),
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`codeService`) REFERENCES `service` (`code`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
