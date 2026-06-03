-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 03 juin 2026 à 09:04
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
  `type` varchar(255) NOT NULL,
  `taille_octets` int(11) NOT NULL,
  `date_upload` datetime NOT NULL,
  `id_reponse` int(11) DEFAULT NULL,
  `id_ticket` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `PIECES_JOINTES`
--

INSERT INTO `PIECES_JOINTES` (`id_piece_jointe`, `nom_origine`, `nom_stockage`, `type`, `taille_octets`, `date_upload`, `id_reponse`, `id_ticket`) VALUES
(21, 'Dupe___Time__o_Note_de_veille_Informatique.pdf', '6a1856b92f7b0.pdf', 'application/pdf', 36371, '2026-05-28 16:52:41', NULL, 38),
(22, 'CV_Benjamin_DELAUNAY-GUITTON.pdf', '6a194f1ec378c.pdf', 'application/pdf', 271722, '2026-05-29 10:32:30', NULL, 54),
(25, 'DUPE___Time__o_1SLAM_Stage_2026_CompteRendu_hebdomadaire_n__03.pdf', '6a1e87df55044.pdf', 'application/pdf', 219514, '2026-06-02 09:35:59', 17, NULL),
(38, 'Note_de_veille_Informatique.docx', '6a1e9c2314f8d.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 18724, '2026-06-02 11:02:27', 17, NULL),
(39, 'Dupe___Time__o_Note_de_veille_Informatique.pdf', '6a1efb0d6a0fa.pdf', 'application/pdf', 36371, '2026-06-02 17:47:25', 18, NULL),
(40, 'feuille.pdf', '6a1efb4a0c455.pdf', 'application/pdf', 1250311, '2026-06-02 17:48:26', 19, NULL),
(41, 'oral_Role_Play.docx', '6a1efb4a0c8bb.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 21610, '2026-06-02 17:48:26', 19, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `REPONSE`
--

CREATE TABLE `REPONSE` (
  `id_reponse` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `date_envoi` datetime NOT NULL,
  `auteur_nom` varchar(50) DEFAULT NULL,
  `auteur_prenom` varchar(50) DEFAULT NULL,
  `est_admin` tinyint(1) NOT NULL DEFAULT 0,
  `id_ticket` int(11) NOT NULL,
  `id_parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `REPONSE`
--

INSERT INTO `REPONSE` (`id_reponse`, `titre`, `contenu`, `date_envoi`, `auteur_nom`, `auteur_prenom`, `est_admin`, `id_ticket`, `id_parent`) VALUES
(4, 'Voici ma réponse au ticket de scr pour pieces jointes + réponse\r\n', 'Bonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticketBonjour je vous répond suite a votre ticket', '2026-06-02 11:30:03', 'Martin', 'Jade', 1, 68, NULL),
(5, '2e réponse en test au ticket 68', 'Voici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce testVoici mon text pour ce test', '2026-06-02 14:45:47', 'Martin', 'Jade', 0, 68, 4),
(6, 'Test réponse depuis le site', 'Coucou tout le monde Coucou tout le monde Coucou tout le monde Coucou tout le monde Coucou tout le monde Coucou tout le monde', '2026-06-02 16:46:19', NULL, NULL, 1, 68, 5),
(7, 'Réponse premiere réponse depuis le site', 'Coucou, voici une réponse en répondant a la premiere réponse du ticket', '2026-06-02 16:47:40', NULL, NULL, 1, 68, 4),
(8, 'Ticket résolu', 'Bonjour,\r\n\r\nLe ticket a bien été traité et résolu', '2026-06-02 16:52:14', NULL, NULL, 1, 68, NULL),
(9, 'Remerciement', 'Bonjour,\r\n\r\nJe vous remercie pour votre vitesse de traitement rapide', '2026-06-02 16:53:37', NULL, NULL, 0, 68, 8),
(10, 'Demande d\'ajout', 'HGoaihgâogijhoaiga', '2026-06-02 16:53:46', NULL, NULL, 0, 68, NULL),
(11, 'Premiere demande urgente', 'qgagaga', '2026-06-02 16:56:14', NULL, NULL, 0, 68, NULL),
(12, 'Réponse sans changer le nom de session  et test maj', 'Voici une réponse sans changer le nom de la session qui est donc BRIANDIS et avec la maj', '2026-06-02 17:01:08', NULL, NULL, 0, 68, NULL),
(13, 'Réponse sans changer le nom de session  et test maj', 'Voici une réponse sans changer le nom de la session qui est donc BRIANDIS et avec la maj', '2026-06-02 17:01:29', NULL, NULL, 0, 68, NULL),
(14, 'Réponse sans changer le nom de session  et test maj', 'Voici une réponse sans changer le nom de la session qui est donc BRIANDIS et avec la maj', '2026-06-02 17:01:37', NULL, NULL, 0, 68, NULL),
(15, 'kg^pak', 'gzpghijazpgoaz', '2026-06-02 17:01:55', NULL, NULL, 0, 68, 14),
(16, 'fapg', 'gzsiohgnz', '2026-06-02 17:02:00', NULL, NULL, 0, 68, NULL),
(17, 'Test avec changement tel', '^kpojhiugyf', '2026-06-02 17:10:39', NULL, NULL, 0, 68, NULL),
(18, 'Demande d\'information', 'Bonjour,\r\n\r\nSuite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi Suite a votre demande je souhaiterai avoir plus d\'informations sur énormement de choses a commencer par jsp quoi', '2026-06-02 17:47:25', NULL, NULL, 1, 60, NULL),
(19, 'Informations demandée', 'Bonjour,\r\n\r\nVoici les informations demandés : \r\nNum de téléphone : 0707070707\r\nemail : jgzopgjaepg\r\nghjzopgjaz^pgla$g\r\ngzoghzog\r\naghiqoghoa', '2026-06-02 17:48:26', NULL, NULL, 0, 60, 18),
(20, '^phoejirkpâja', 'h^dkpthme^h', '2026-06-02 18:03:35', NULL, NULL, 0, 32, NULL);

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
  `declarant_telephone` varchar(100) DEFAULT NULL,
  `declarant_email` varchar(100) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_archivage` datetime DEFAULT NULL,
  `date_resolution` datetime DEFAULT NULL,
  `date_maj` datetime DEFAULT NULL,
  `derniere_action` varchar(255) DEFAULT '''Ticket créé''',
  `id_entreprise` varchar(50) NOT NULL,
  `nom_entreprise` varchar(100) NOT NULL,
  `id_urgence` int(11) NOT NULL,
  `id_statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TICKETS`
--

INSERT INTO `TICKETS` (`id_ticket`, `numero_ticket`, `declarant_nom`, `declarant_prenom`, `declarant_telephone`, `declarant_email`, `titre`, `description`, `date_creation`, `date_archivage`, `date_resolution`, `date_maj`, `derniere_action`, `id_entreprise`, `nom_entreprise`, `id_urgence`, `id_statut`) VALUES
(28, 'TKT-2605-32A1', 'Martin', 'Jade', '0707070707', 'jademrtn@exemple.com', 'Demande d\'ajout', 'Bonjour, je souhaiterai ajouter au site une page pour ne rien faire car je n\'ai pas d\'idées', '2026-05-28 14:49:06', NULL, NULL, NULL, 'Ticket créé', '2', 'BRIANDIS', 4, 1),
(29, 'TKT-2605-666D', 'Martin', 'Jade', '0707070707', 'jademrtn@exemple.com', 'Premiere demande urgente', 'Bonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere dBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesemande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptesBonjour voici ma premiere demande urgente a propos du site web, plusieurs client m\'ont signalé ne plus avoir accès a leurs comptes', '2026-05-25 14:50:54', NULL, '2026-05-29 15:04:16', '2026-05-29 15:04:16', 'Ticket créé', '2', 'BRIANDIS', 1, 3),
(31, 'TKT-2605-C9C5', 'Martin', 'Jade', '070707070707 après 18h', 'jademrtn@exemple.com', 'Test pour le message de confirmation', 'Voici le test pour le message de confirmation', '2026-05-28 15:38:31', NULL, NULL, NULL, 'Ticket créé', '2', 'BRIANDIS', 3, 1),
(32, 'TKT-2605-BFED', 'Dupé', 'Timéo', '0707070707', 'timeo.dupe@exemple.com', 'Test avec changement tel', 'gzgaga', '2026-05-28 15:39:21', NULL, NULL, '2026-06-02 18:03:35', 'Ticket créé', '2', 'BRIANDIS', 2, 1),
(33, 'TKT-2605-0613', 'Dupé', 'Timéo', '0707070707', 'timeo.dupe@exemple.com', 'Test avec changement tel', 'qgaqhaha', '2026-05-28 15:40:17', NULL, NULL, NULL, 'Ticket créé', '2', 'BRIANDIS', 3, 1),
(34, 'TKT-2605-190C', 'Dupé', 'Timéo', '0707070707', 'timeo.dupe@exemple.com', 'Test avec changement tel', 'qgaqhaha', '2026-05-18 15:41:21', NULL, NULL, NULL, 'Ticket créé', '3', 'SCR', 3, 1),
(35, 'TKT-2605-D2A5', 'Dupé', 'Timéo', '070707070707 après 18h', 'admin@intrawall.local', 'Premiere demande urgente', 'gagaHAHzeHerhRHh', '2026-05-28 15:41:57', '2026-06-01 11:48:52', NULL, '2026-06-01 11:48:52', 'Ticket créé', '2', 'BRIANDIS', 4, 4),
(37, 'TKT-2605-F392', 'Dupé', 'Tadeo', '070707070707 après 18h', 'admin@intrawall.local', 'Premier test depuis IWAN', 'gzpghjzaha^hka^h', '2026-05-28 16:51:00', NULL, '2026-05-28 17:56:04', '2026-05-28 17:56:04', 'Ticket créé', '3', 'SCR', 4, 3),
(38, 'TKT-2605-FC3A', 'Dupé', 'Timéo', '070707070707 après 20h', 'timeo.dupe@exemple.com', 'Test avec nouvel id depuis IWAN', 'gjhzpohjz^HOJ^Q', '2026-05-28 16:52:41', NULL, '2026-05-29 17:54:29', '2026-05-28 17:54:29', 'Ticket créé', '3', 'SCR', 1, 3),
(39, 'TKT-2605-420C', 'Dupé', 'Timéo', '0781348888', 'alice@intrawall.local', 'Test nom_entreprise en minuscule et nouveau nom', 'sjpgqpgjq', '2026-05-05 16:53:52', NULL, '2026-06-01 14:14:37', '2026-06-01 14:14:37', 'Ticket créé', '4', 'STELLANTIS', 4, 3),
(40, 'TKT-2605-1DBB', 'Dupé', 'Timéo', '0781348888', 'admin@intrawall.local', 'Test nom déjà présent mais en minuscule', 'gnsoipighziphqp', '2026-05-26 16:54:23', NULL, '2026-05-27 17:55:49', '2026-05-27 17:55:49', 'Ticket créé', '3', 'SCR', 2, 3),
(41, 'TKT-2605-73E2', 'Dupé', 'Timéo', '070707070707 après 18h', 'admin@intrawall.local', 'Test client après modification admin', 'gnspohjz^hjqôhjqmihj', '2026-05-28 16:56:38', NULL, NULL, '2026-06-01 11:48:40', 'Ticket créé', '2', 'BRIANDIS', 3, 2),
(44, 'TKT-2605-57C2', 'Dupé', 'Timéo', '0707070707', 'admin@intrawall.local', 'Premiere demande urgente', 'GHiapohgpa', '2026-04-28 09:18:34', NULL, NULL, NULL, 'Ticket créé', '', 'HSO', 3, 1),
(45, 'TKT-2605-FC4C', 'Dupé', 'Timéo', '0781348888', 'admin@intrawall.local', 'Test avec changement tel', 'igmfulydktsjr', '2025-12-17 09:27:57', NULL, NULL, NULL, 'Ticket créé', '2', 'BRIANDIS', 3, 1),
(46, 'TKT-2605-C55E', 'Dupé', 'Timéo', '0707070707', 'admin@intrawall.local', 'Test message succes admin', 'gjqpgjaq^gpkoaijehfiuopaklfqjpozf^pkfùmlf,', '2026-04-22 09:29:18', NULL, NULL, NULL, 'Ticket créé', '3', 'SCR', 2, 1),
(49, 'TKT-2605-2C13', 'Dupé', 'Timéo', '0707070707', 'admin@intrawall.local', 'Test message succes admin', 'gjqpgjaq^gpkoaijehfiuopaklfqjpozf^pkfùmlf,', '2026-03-17 09:31:51', NULL, NULL, NULL, 'Ticket créé', '3', 'SCR', 2, 1),
(54, 'TKT-2605-FD04', 'Dupé', 'Timéo', '0707070707', 'admin@intrawall.local', 'Premier test depuis le site', 'Bonjour', '2023-05-24 10:32:30', NULL, NULL, NULL, 'Ticket créé', '2', 'BRIANDIS', 2, 1),
(60, 'TKT-2606-16AA', 'La chocolaterie', 'Charlie', '08070707 Bonjour', 'charlo@exemple.com', 'Voici un ticket pour tester les maj', 'Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS Bonjour voici un test afin de vérifier que les tickets se mettent bien a jour pour les administrateur et BRIANDIS', '2026-06-01 17:04:18', NULL, NULL, '2026-06-02 17:48:26', 'Ticket créé', '2', 'BRIANDIS', 1, 2),
(64, 'TKT-2606-89B6', 'Dupé', 'Timéo', '0707070707', 'admin@intrawall.local', 'Test pour le message de confirmation', 'lnhuigyf', '2026-06-02 09:30:35', NULL, NULL, NULL, 'Ticket créé', '1', 'IWAN', 1, 1),
(65, 'TKT-2606-7E73', 'Dupé', 'Timéo', '0707070707', 'admin@intrawall.local', 'Test une fois IWAN déjà dans la bdd', 'gz^kpoh', '2026-06-02 09:31:02', NULL, NULL, NULL, 'Ticket créé', '1', 'IWAN', 2, 1),
(66, 'TKT-2606-4FFC', 'Dupé', 'Timéo', '0707070707', 'admin@intrawall.local', 'Test page détail', 'Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text Il s\'agit d\'un test afin de voir si tout fonctionne correctement dans la page détails. Pour cela il faut écrire un grand text', '2026-06-02 09:35:59', NULL, NULL, '2026-06-02 09:41:59', 'Ticket créé', '3', 'SCR', 2, 2),
(68, 'TKT-2606-6DC9', 'Dupé', 'Timéo', '070707070707 après 18h', 'alice@intrawall.local', 'Ticket de test pieces jointes + réponse', 'Bonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointeBonjour a tous voici du text pour ajouter une réponse a ce ticket qui affiche une piece jointe', '2026-06-02 11:02:27', NULL, NULL, '2026-06-02 17:10:39', 'Ticket créé', '3', 'SCR', 3, 1);

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
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `fk_reponse_parent` (`id_parent`);

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
  MODIFY `id_piece_jointe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `REPONSE`
--
ALTER TABLE `REPONSE`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `STATUT`
--
ALTER TABLE `STATUT`
  MODIFY `id_statut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `TICKETS`
--
ALTER TABLE `TICKETS`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
  ADD CONSTRAINT `fk_reponse_parent` FOREIGN KEY (`id_parent`) REFERENCES `REPONSE` (`id_reponse`) ON DELETE SET NULL,
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
