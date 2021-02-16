#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

DROP TABLE IF EXISTS DansCommande;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS TypeItem;
DROP TABLE IF EXISTS Commande;
DROP TABLE IF EXISTS CommandeHebdomadaire;
DROP TABLE IF EXISTS Livraison;
DROP TABLE IF EXISTS Adress;
DROP TABLE IF EXISTS Utilisateur;

#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
		idUser			Int Auto_increment NOT NULL,
		email			Varchar (128) NOT NULL,
		pseudo			Varchar (64) NOT NULL,
		foreName		Varchar (64),
		familyName		Varchar (64),
		hashmdp			Varchar (97) NOT NULL,
		resetPWDToken	Varchar (256),
		isProducteur	Bool NOT NULL,
		imageProfil		Mediumblob,
	CONSTRAINT Utilisateur_PK PRIMARY KEY (idUser)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Adress
#------------------------------------------------------------

CREATE TABLE Adress(
		idAdress	Int Auto_increment NOT NULL,
		adress		Varchar (256) NOT NULL,
		CP			Int NOT NULL,
		city		Varchar (64) NOT NULL,
		isMain		Bool NOT NULL DEFAULT FALSE,
		idUser		Int NOT NULL,
	CONSTRAINT Adress_PK PRIMARY KEY (idAdress),
	CONSTRAINT Adress_Utilisateur_FK FOREIGN KEY (idUser) REFERENCES Utilisateur(idUser) ON DELETE CASCADE
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Livraison
#------------------------------------------------------------

CREATE TABLE Livraison(
		idLivraison	Int Auto_increment NOT NULL,
		dateEnvoi	Date NOT NULL,
		idAdress	Int NOT NULL,
	CONSTRAINT Livraison_PK PRIMARY KEY (idLivraison),
	CONSTRAINT Livraison_Adress_FK FOREIGN KEY (idAdress) REFERENCES Adress(idAdress) ON DELETE CASCADE
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: CommandeHebdomadaire
#------------------------------------------------------------

CREATE TABLE CommandeHebdomadaire(
		idCommandeHebdo	Int Auto_increment NOT NULL,
		idUser			Int NOT NULL,
	CONSTRAINT CommandeHebdomadaire_PK PRIMARY KEY (idCommandeHebdo),
	CONSTRAINT CommandeHebdomadaire_Utilisateur_FK FOREIGN KEY (idUser) REFERENCES Utilisateur(idUser) ON DELETE CASCADE
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commande
#------------------------------------------------------------

CREATE TABLE Commande(
		idCommande		Int Auto_increment NOT NULL,
		dateCommande	Date NOT NULL,
		isValidated		Bool NOT NULL DEFAULT 0,
		idUser			Int NOT NULL,
		idProducteur	Int NOT NULL,
		idLivraison		Int,
		idCommandeHebdo	Int,
	CONSTRAINT Commande_PK PRIMARY KEY (idCommande),
	CONSTRAINT Commande_Utilisateur_Client_FK FOREIGN KEY (idUser) REFERENCES Utilisateur(idUser) ON DELETE CASCADE,
	CONSTRAINT Commande_Utilisateur_Producteur_FK FOREIGN KEY (idUser) REFERENCES Utilisateur(idUser) ON DELETE CASCADE,
	CONSTRAINT Commande_Livraison_FK FOREIGN KEY (idLivraison) REFERENCES Livraison(idLivraison) ON DELETE CASCADE,
	CONSTRAINT Commande_CommandeHebdomadaire_FK FOREIGN KEY (idCommandeHebdo) REFERENCES CommandeHebdomadaire(idCommandeHebdo) ON DELETE CASCADE
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: TypeItem
#------------------------------------------------------------

CREATE TABLE TypeItem(
		idTypeItem	Int Auto_increment NOT NULL,
		nomType		Varchar (64) NOT NULL,
	CONSTRAINT TypeFruit_PK PRIMARY KEY (idTypeItem)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Item
#------------------------------------------------------------

CREATE TABLE Item(
		idItem		Int Auto_increment NOT NULL,
		nom			Varchar (64) NOT NULL,
		description	Varchar (256),
		prixKilo	DECIMAL (15,3) NOT NULL,
		poidsUnite	Int NOT NULL,
		image		Mediumblob,
		nb			Int NOT NULL DEFAULT 0,
		idUser		Int NOT NULL,
		idTypeItem	Int,
	CONSTRAINT FruitLegume_PK PRIMARY KEY (idItem),
	CONSTRAINT FruitLegume_Utilisateur_FK FOREIGN KEY (idUser) REFERENCES Utilisateur(idUser) ON DELETE CASCADE,
	CONSTRAINT FruitLegume_TypeFruit_FK FOREIGN KEY (idTypeItem) REFERENCES TypeItem(idTypeItem)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: DansCommande
#------------------------------------------------------------

CREATE TABLE DansCommande(
		idItem			Int NOT NULL,
		idCommande		Int NOT NULL,
		nb				Int NOT NULL,
		prixKiloAcaht	DECIMAL (15,3) NOT NULL,
		poidsUniteAchat	Int NOT NULL,
	CONSTRAINT DansCommande_PK PRIMARY KEY (idItem,idCommande),
	CONSTRAINT DansCommande_FruitLegume_FK FOREIGN KEY (idItem) REFERENCES Item(idItem) ON DELETE CASCADE,
	CONSTRAINT DansCommande_Commande_FK FOREIGN KEY (idCommande) REFERENCES Commande(idCommande) ON DELETE CASCADE
)ENGINE=InnoDB;

