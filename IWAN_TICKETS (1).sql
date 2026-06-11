-- ========================================================
-- 1. CRÉATION DE LA TABLE LOGICIEL
-- ========================================================
CREATE TABLE IF NOT EXISTS `LOGICIEL` (
  `id_logiciel` INT(11) NOT NULL AUTO_INCREMENT,
  `logiciel` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_logiciel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================================
-- 2. INSERTION DES LOGICIELS PAR DÉFAUT
-- ========================================================
INSERT INTO `LOGICIEL` (`id_logiciel`, `logiciel`) VALUES
(1, 'GOA'),
(2, 'IWAN V3'),
(3, 'CRM'),
(4, 'RESAVAC'),
(5, 'WINLORE'),
(6, 'AERORESA'),
(7, 'PLANNING'),
(8, 'MATERIEL'),
(9, 'ANAMAG'),
(10, 'IWAN CAISSE'),
(11, 'AUTRE')
ON DUPLICATE KEY UPDATE `logiciel` = VALUES(`logiciel`);

-- ========================================================
-- 3. ADAPTATION DE LA TABLE CLIENT
-- ========================================================
-- On nettoie les anciennes données textuelles pour éviter le bug #1292
UPDATE `CLIENT` SET `logiciel` = NULL;

-- On renomme la colonne et on change son type en INT
ALTER TABLE `CLIENT` CHANGE `logiciel` `id_logiciel` INT(11) NULL;

-- On s'assure que la table utilise le bon moteur pour les clés étrangères
ALTER TABLE `CLIENT` ENGINE=InnoDB;

-- On ajoute l'index et la clé étrangère
ALTER TABLE `CLIENT` ADD KEY `id_logiciel` (`id_logiciel`);
ALTER TABLE `CLIENT` 
ADD CONSTRAINT `fk_client_logiciel` 
FOREIGN KEY (`id_logiciel`) REFERENCES `LOGICIEL` (`id_logiciel`) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- ========================================================
-- 4. ADAPTATION DE LA TABLE TICKETS
-- ========================================================
-- On nettoie les anciennes données textuelles pour éviter le bug #1292
UPDATE `TICKETS` SET `logiciel` = NULL;

-- On renomme la colonne et on change son type en INT
ALTER TABLE `TICKETS` CHANGE `logiciel` `id_logiciel` INT(11) NULL;

-- On s'assure que la table utilise le bon moteur pour les clés étrangères
ALTER TABLE `TICKETS` ENGINE=InnoDB;

-- On ajoute l'index et la clé étrangère
ALTER TABLE `TICKETS` ADD KEY `id_logiciel` (`id_logiciel`);
ALTER TABLE `TICKETS` 
ADD CONSTRAINT `fk_tickets_logiciel` 
FOREIGN KEY (`id_logiciel`) REFERENCES `LOGICIEL` (`id_logiciel`) 
ON DELETE SET NULL ON UPDATE CASCADE;