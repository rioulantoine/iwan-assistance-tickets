CREATE TABLE ROLES(
   id_role INT AUTO_INCREMENT,
   libelle_role VARCHAR(30) NOT NULL,
   PRIMARY KEY(id_role),
   UNIQUE(libelle_role)
);

CREATE TABLE USER_(
   id_user INT AUTO_INCREMENT,
   nom VARCHAR(100) NOT NULL,
   mot_de_passe VARCHAR(255) NOT NULL,
   date_creation DATETIME NOT NULL,
   id_role INT NOT NULL,
   PRIMARY KEY(id_user),
   FOREIGN KEY(id_role) REFERENCES ROLES(id_role)
);

CREATE TABLE STATUT(
   id_statut INT AUTO_INCREMENT,
   libelle_statut VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_statut),
   UNIQUE(libelle_statut)
);

CREATE TABLE NIVEAU_URGENCE(
   id_urgence INT AUTO_INCREMENT,
   libelle_urgence VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_urgence),
   UNIQUE(libelle_urgence)
);

CREATE TABLE TICKETS(
   id_ticket INT AUTO_INCREMENT,
   numero_ticket VARCHAR(30) NOT NULL,
   declarant_nom VARCHAR(50),
   declarant_prenom VARCHAR(50),
   declarant_email VARCHAR(100),
   titre VARCHAR(100) NOT NULL,
   description TEXT NOT NULL,
   date_creation DATETIME NOT NULL,
   date_archivage DATETIME NULL,
   id_urgence INT NOT NULL,
   id_user INT NOT NULL,
   id_statut INT NOT NULL,
   PRIMARY KEY(id_ticket),
   UNIQUE(numero_ticket),
   FOREIGN KEY(id_urgence) REFERENCES NIVEAU_URGENCE(id_urgence),
   FOREIGN KEY(id_user) REFERENCES USER_(id_user),
   FOREIGN KEY(id_statut) REFERENCES STATUT(id_statut)
);

CREATE TABLE REPONSE(
   id_reponse INT AUTO_INCREMENT,
   titre VARCHAR(100),
   contenu TEXT NOT NULL,
   date_envoi DATETIME NOT NULL,
   id_user INT NOT NULL,
   id_ticket INT NOT NULL,
   PRIMARY KEY(id_reponse),
   FOREIGN KEY(id_user) REFERENCES USER_(id_user),
   FOREIGN KEY(id_ticket) REFERENCES TICKETS(id_ticket) ON DELETE CASCADE
);

CREATE TABLE PIECES_JOINTES(
   id_piece_jointe INT AUTO_INCREMENT,
   nom_origine VARCHAR(255) NOT NULL,
   nom_stockage VARCHAR(255) NOT NULL,
   type VARCHAR(50) NOT NULL,
   taille_octets INT NOT NULL,
   date_upload DATETIME NOT NULL,
   id_reponse INT NULL,
   id_ticket INT NULL,
   PRIMARY KEY(id_piece_jointe),
   FOREIGN KEY(id_reponse) REFERENCES REPONSE(id_reponse) ON DELETE CASCADE,
   FOREIGN KEY(id_ticket) REFERENCES TICKETS(id_ticket) ON DELETE CASCADE
);