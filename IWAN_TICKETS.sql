-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 28 mai 2026 à 14:29
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `IWAN_TICKETS`
--
CREATE DATABASE IF NOT EXISTS `IWAN_TICKETS` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `IWAN_TICKETS`;

-- --------------------------------------------------------

--
-- Structure de la table `NIVEAU_URGENCE`
--

CREATE TABLE `NIVEAU_URGENCE` (
  `id_urgence` int(11) NOT NULL,
  `libelle_urgence` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `NIVEAU_URGENCE`
--

INSERT INTO `NIVEAU_URGENCE` (`id_urgence`, `libelle_urgence`) VALUES
(1, 'Bloquant / Très urgent'),
(2, 'Urgent'),
(3, 'Normal'),
(4, 'Non urgent / Demande d\'évolution');

-- --------------------------------------------------------

--
-- Structure de la table `PIECES_JOINTES`
--

CREATE TABLE `PIECES_JOINTES` (
  `id_piece_jointe` int(11) NOT NULL,
  `nom_origine` varchar(255) NOT NULL,
  `nom_stockage` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `taille_octets` int(11) NOT NULL,
  `date_upload` datetime NOT NULL,
  `id_reponse` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `REPONSE`
--

CREATE TABLE `REPONSE` (
  `id_reponse` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `date_envoi` datetime NOT NULL,
  `auteur_nom` varchar(50) NOT NULL,
  `auteur_prenom` varchar(50) NOT NULL,
  `auteur_type` varchar(50) NOT NULL,
  `id_ticket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `STATUT`
--

CREATE TABLE `STATUT` (
  `id_statut` int(11) NOT NULL,
  `libelle_statut` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `STATUT`
--

INSERT INTO `STATUT` (`id_statut`, `libelle_statut`) VALUES
(1, 'En attente'),
(2, 'En cours'),
(3, 'Résolu'),
(4, 'Archivé');

-- --------------------------------------------------------

--
-- Structure de la table `TICKETS`
--

CREATE TABLE `TICKETS` (
  `id_ticket` int(11) NOT NULL,
  `numero_ticket` varchar(30) NOT NULL,
  `declarant_nom` varchar(50) NOT NULL,
  `declarant_prenom` varchar(50) DEFAULT NULL,
  `declarant_telephone` varchar(16) DEFAULT NULL,
  `declarant_email` varchar(100) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_archivage` datetime DEFAULT NULL,
  `date_resolution` datetime DEFAULT NULL,
  `date_maj` datetime DEFAULT NULL,
  `id_entreprise` varchar(50) NOT NULL,
  `nom_entreprise` varchar(100) NOT NULL,
  `id_urgence` int(11) NOT NULL,
  `id_statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `NIVEAU_URGENCE`
--
ALTER TABLE `NIVEAU_URGENCE`
  ADD PRIMARY KEY (`id_urgence`);

--
-- Index pour la table `PIECES_JOINTES`
--
ALTER TABLE `PIECES_JOINTES`
  ADD PRIMARY KEY (`id_piece_jointe`),
  ADD KEY `id_reponse` (`id_reponse`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Index pour la table `REPONSE`
--
ALTER TABLE `REPONSE`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `id_ticket` (`id_ticket`);

--
-- Index pour la table `STATUT`
--
ALTER TABLE `STATUT`
  ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `TICKETS`
--
ALTER TABLE `TICKETS`
  ADD PRIMARY KEY (`id_ticket`),
  ADD UNIQUE KEY `numero_ticket` (`numero_ticket`),
  ADD KEY `id_urgence` (`id_urgence`),
  ADD KEY `id_statut` (`id_statut`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `NIVEAU_URGENCE`
--
ALTER TABLE `NIVEAU_URGENCE`
  MODIFY `id_urgence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `PIECES_JOINTES`
--
ALTER TABLE `PIECES_JOINTES`
  MODIFY `id_piece_jointe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `REPONSE`
--
ALTER TABLE `REPONSE`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `STATUT`
--
ALTER TABLE `STATUT`
  MODIFY `id_statut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `TICKETS`
--
ALTER TABLE `TICKETS`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `PIECES_JOINTES`
--
ALTER TABLE `PIECES_JOINTES`
  ADD CONSTRAINT `pieces_jointes_ibfk_1` FOREIGN KEY (`id_reponse`) REFERENCES `REPONSE` (`id_reponse`) ON DELETE CASCADE,
  ADD CONSTRAINT `pieces_jointes_ibfk_2` FOREIGN KEY (`id_ticket`) REFERENCES `TICKETS` (`id_ticket`) ON DELETE CASCADE;

--
-- Contraintes pour la table `REPONSE`
--
ALTER TABLE `REPONSE`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `TICKETS` (`id_ticket`) ON DELETE CASCADE;

--
-- Contraintes pour la table `TICKETS`
--
ALTER TABLE `TICKETS`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id_urgence`) REFERENCES `NIVEAU_URGENCE` (`id_urgence`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`id_statut`) REFERENCES `STATUT` (`id_statut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
