#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Adress
#------------------------------------------------------------

CREATE TABLE Adress(
        id_adress Int  Auto_increment  NOT NULL ,
        adress    Varchar (256) NOT NULL ,
        city      Varchar (256) NOT NULL ,
        CP        Int NOT NULL
	,CONSTRAINT Adress_PK PRIMARY KEY (id_adress)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        id_user   Int  Auto_increment  NOT NULL ,
        email     Varchar (256) NOT NULL ,
        pseudo    Varchar (256) NOT NULL ,
        name      Varchar (256) NOT NULL ,
        forname   Varchar (256) NOT NULL ,
        hashmdp   Varchar (256) NOT NULL ,
        id_adress Int NOT NULL
	,CONSTRAINT Utilisateur_PK PRIMARY KEY (id_user)

	,CONSTRAINT Utilisateur_Adress_FK FOREIGN KEY (id_adress) REFERENCES Adress(id_adress)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Client
#------------------------------------------------------------

CREATE TABLE Client(
        id_user   Int NOT NULL ,
        email     Varchar (256) NOT NULL ,
        pseudo    Varchar (256) NOT NULL ,
        name      Varchar (256) NOT NULL ,
        forname   Varchar (256) NOT NULL ,
        hashmdp   Varchar (256) NOT NULL ,
        id_adress Int NOT NULL
	,CONSTRAINT Client_PK PRIMARY KEY (id_user)

	,CONSTRAINT Client_Utilisateur_FK FOREIGN KEY (id_user) REFERENCES Utilisateur(id_user)
	,CONSTRAINT Client_Adress0_FK FOREIGN KEY (id_adress) REFERENCES Adress(id_adress)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Producteur
#------------------------------------------------------------

CREATE TABLE Producteur(
        id_user   Int NOT NULL ,
        email     Varchar (256) NOT NULL ,
        pseudo    Varchar (256) NOT NULL ,
        name      Varchar (256) NOT NULL ,
        forname   Varchar (256) NOT NULL ,
        hashmdp   Varchar (256) NOT NULL ,
        id_adress Int NOT NULL
	,CONSTRAINT Producteur_PK PRIMARY KEY (id_user)

	,CONSTRAINT Producteur_Utilisateur_FK FOREIGN KEY (id_user) REFERENCES Utilisateur(id_user)
	,CONSTRAINT Producteur_Adress0_FK FOREIGN KEY (id_adress) REFERENCES Adress(id_adress)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: FruitLegume
#------------------------------------------------------------

CREATE TABLE FruitLegume(
        id_fruit     Int  Auto_increment  NOT NULL ,
        nom_fruit    Varchar (256) NOT NULL ,
        prix_produit DECIMAL (15,3)  NOT NULL
	,CONSTRAINT FruitLegume_PK PRIMARY KEY (id_fruit)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Livraison
#------------------------------------------------------------

CREATE TABLE Livraison(
        id_livraison   Int  Auto_increment  NOT NULL ,
        date_livraison Date NOT NULL ,
        id_user        Int NOT NULL ,
        id_adress      Int NOT NULL
	,CONSTRAINT Livraison_PK PRIMARY KEY (id_livraison)

	,CONSTRAINT Livraison_Producteur_FK FOREIGN KEY (id_user) REFERENCES Producteur(id_user)
	,CONSTRAINT Livraison_Adress0_FK FOREIGN KEY (id_adress) REFERENCES Adress(id_adress)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: CommandeHebdomadaire
#------------------------------------------------------------

CREATE TABLE CommandeHebdomadaire(
        id_commande_hebdo Int  Auto_increment  NOT NULL ,
        id_user           Int NOT NULL
	,CONSTRAINT CommandeHebdomadaire_PK PRIMARY KEY (id_commande_hebdo)

	,CONSTRAINT CommandeHebdomadaire_Producteur_FK FOREIGN KEY (id_user) REFERENCES Producteur(id_user)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commande
#------------------------------------------------------------

CREATE TABLE Commande(
        id_commande       Int  Auto_increment  NOT NULL ,
        id_user           Int NOT NULL ,
        id_livraison      Int NOT NULL ,
        id_commande_hebdo Int
	,CONSTRAINT Commande_PK PRIMARY KEY (id_commande)

	,CONSTRAINT Commande_Client_FK FOREIGN KEY (id_user) REFERENCES Client(id_user)
	,CONSTRAINT Commande_Livraison0_FK FOREIGN KEY (id_livraison) REFERENCES Livraison(id_livraison)
	,CONSTRAINT Commande_CommandeHebdomadaire1_FK FOREIGN KEY (id_commande_hebdo) REFERENCES CommandeHebdomadaire(id_commande_hebdo)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: AdressSave
#------------------------------------------------------------

CREATE TABLE AdressSave(
        id_user   Int NOT NULL ,
        id_adress Int NOT NULL
	,CONSTRAINT AdressSave_PK PRIMARY KEY (id_user,id_adress)

	,CONSTRAINT AdressSave_Client_FK FOREIGN KEY (id_user) REFERENCES Client(id_user)
	,CONSTRAINT AdressSave_Adress0_FK FOREIGN KEY (id_adress) REFERENCES Adress(id_adress)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: DansCommande
#------------------------------------------------------------

CREATE TABLE DansCommande(
        id_fruit    Int NOT NULL ,
        id_commande Int NOT NULL ,
        NB_FRUIT    Int NOT NULL
	,CONSTRAINT DansCommande_PK PRIMARY KEY (id_fruit,id_commande)

	,CONSTRAINT DansCommande_FruitLegume_FK FOREIGN KEY (id_fruit) REFERENCES FruitLegume(id_fruit)
	,CONSTRAINT DansCommande_Commande0_FK FOREIGN KEY (id_commande) REFERENCES Commande(id_commande)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: EnStock
#------------------------------------------------------------

CREATE TABLE EnStock(
        id_user  Int NOT NULL ,
        id_fruit Int NOT NULL ,
        NB_FRUIT Int NOT NULL
	,CONSTRAINT EnStock_PK PRIMARY KEY (id_user,id_fruit)

	,CONSTRAINT EnStock_Producteur_FK FOREIGN KEY (id_user) REFERENCES Producteur(id_user)
	,CONSTRAINT EnStock_FruitLegume0_FK FOREIGN KEY (id_fruit) REFERENCES FruitLegume(id_fruit)
)ENGINE=InnoDB;

