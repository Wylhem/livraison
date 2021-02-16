
INSERT INTO ProjetS3.TypeFruit (nom_type_fruit) VALUES('FRUIT');
INSERT INTO ProjetS3.TypeFruit (nom_type_fruit) VALUES('LEGUME');

/*
INSERT INTO ProjetS3.Adress
(adress, city, CP)
VALUES('31 rue des Peupliers', 'Palaiseau', 91120);

INSERT INTO ProjetS3.Utilisateur
(email, pseudo, name, forname, hashmdp, resetPWDToken, estProducteur, id_adress)
VALUES('nicolas.marie@universite-paris-saclay.fr', 'Nicofolxarus', 'Marie', 'Nicolas', 'srioeduhguihwsfoidguhowdiufrhogiur', NULL, TRUE, 1);

INSERT INTO ProjetS3.Livraison
(date_envoi, id_user, id_adress)
VALUES('1999-12-31', 1, 1);
*/

-- Utilisateur Insert
-- 12345678
INSERT INTO ProjetS3.Utilisateur
(email, pseudo, name, forname, hashmdp, resetPWDToken, estProducteur)
VALUES('richard.riviere@yahoo.fr', 'gilbert.pons', 'Jaques', 'Pauette', '$argon2id$v=19$m=65536,t=4,p=1$aWJodHhBTi94NFlvd2hpNQ$RPU9StS12SkyrooRl6dNZ49gfQ/QxqHUsJXr1uF7Ji4', NULL,TRUE);

-- 87654321
INSERT INTO ProjetS3.Utilisateur
(email, pseudo, name, forname, hashmdp, resetPWDToken, estProducteur)
VALUES('henri.hamon@free.fr','taubry', 'Alain', 'Olivier', '$argon2id$v=19$m=65536,t=4,p=1$QTQ4WUdhUENPY0ZmUGhEMg$aY1c8DVKVHTneiXX1qKxrsNnzZtpnvyvXNorHoWr7pQ', NULL, TRUE);

-- azertyuiop
INSERT INTO ProjetS3.Utilisateur
(email, pseudo, name, forname, hashmdp, resetPWDToken, estProducteur)
VALUES('antoinette.renard@orange.fr', 'dominique91', 'Masse', 'Michelle', '$argon2id$v=19$m=65536,t=4,p=1$SEtuVmJ2L2dSdTlpeXAxag$oiI5SlVYJQ/9ZmErd41nNgSDxdDHsxmuuNbZp7PayDg', NULL, false);

-- qsdfghjklm
INSERT INTO ProjetS3.Utilisateur
(email, pseudo, name, forname, hashmdp, resetPWDToken, estProducteur)
VALUES('antoine.bousquet@tele2.fr', 'pelletier.xavier', 'Stephanie ', 'Mercier', '$argon2id$v=19$m=65536,t=4,p=1$RFA0eWJmNThJSUxnNXZ4dg$SBiYoAFqTdhcRtPgK8HrJIRpCsr+E2g+dTA3ehbNy5g', NULL, false);

-- wxcvbn456
INSERT INTO ProjetS3.Utilisateur
(email, pseudo, name, forname, hashmdp, resetPWDToken, estProducteur)
VALUES('luc.dupuy@live.com', 'denis.cecile', 'Perrier', 'Veronique', '$argon2id$v=19$m=65536,t=4,p=1$Q3lXdTRHbXZoQjFDVUVFMw$ZJIzBDv1zvg1u/qxkRqvYc9IXfZknHFCbJqp8vTTojE', NULL, FALSE);


-- adress Insert
INSERT INTO ProjetS3.Adress
(adress, city, CP, id_user)
VALUES('24, impasse Roux', 'Gillet-la-Foret', 24401, 1);

INSERT INTO ProjetS3.Adress (adress, city, CP, id_user)
VALUES('4 rue Wagner', 'Maury', 56948, 2);

INSERT INTO ProjetS3.Adress
(adress, city, CP, id_user)
VALUES('6, boulevard Marty', 'Daviddan', 65982, 3);

INSERT INTO ProjetS3.Adress
(adress, city, CP, id_user)
VALUES('82, impasse de Morin', 'Regnierdan', 83267, 4);

INSERT INTO ProjetS3.Adress
(adress, city, CP, id_user)
VALUES('boulevard de Duval', 'Labbe', 54591, 5);


-- Livraison Insert
INSERT INTO ProjetS3.Livraison
(date_envoi, id_user, id_adress)
VALUES('2021-06-10', 1, 1);

INSERT INTO ProjetS3.Livraison
(date_envoi, id_user, id_adress)
VALUES('2021-06-21', 2, 2);

INSERT INTO ProjetS3.Livraison
(date_envoi, id_user, id_adress)
VALUES('2021-06-25', 2, 2);

INSERT INTO ProjetS3.Livraison
(date_envoi, id_user, id_adress)
VALUES('2021-06-28', 1, 4);

INSERT INTO ProjetS3.Livraison
(date_envoi, id_user, id_adress)
VALUES('2021-12-28', 1, 5);


-- Commande hebdomadaire Insert
INSERT INTO ProjetS3.CommandeHebdomadaire
(id_user)
VALUES(1);

INSERT INTO ProjetS3.CommandeHebdomadaire
(id_user)
VALUES(2);

INSERT INTO ProjetS3.CommandeHebdomadaire
(id_user)
VALUES(2);

INSERT INTO ProjetS3.CommandeHebdomadaire
(id_user)
VALUES(1);

INSERT INTO ProjetS3.CommandeHebdomadaire
(id_user)
VALUES(1);


-- Commande Insert
INSERT INTO ProjetS3.Commande
(date_commande, is_payed, id_user, id_livraison, id_commande_hebdo)
VALUES('2021-03-10', TRUE, 1, 1, NULL);

INSERT INTO ProjetS3.Commande
(date_commande, is_payed, id_user, id_livraison, id_commande_hebdo)
VALUES('2021-06-21', FALSE, 2, 1, NULL);

INSERT INTO ProjetS3.Commande
(date_commande, is_payed, id_user, id_livraison, id_commande_hebdo)
VALUES('2021-08-30', FALSE, 3, 3, NULL);

INSERT INTO ProjetS3.Commande
(date_commande, is_payed, id_user, id_livraison, id_commande_hebdo)
VALUES('2021-09-14', TRUE, 4, 4, 1);

INSERT INTO ProjetS3.Commande
(date_commande, is_payed, id_user, id_livraison, id_commande_hebdo)
VALUES('2021-11-17', TRUE, 5, 5, 1);


-- TypeFruit 
INSERT INTO ProjetS3.TypeFruit
(nom_type_fruit)
VALUES('exotique');

INSERT INTO ProjetS3.TypeFruit
(nom_type_fruit)
VALUES('fleurs');

INSERT INTO ProjetS3.TypeFruit
(nom_type_fruit)
VALUES('feuilles');

INSERT INTO ProjetS3.TypeFruit
(nom_type_fruit)
VALUES('noyau');

INSERT INTO ProjetS3.TypeFruit
(nom_type_fruit)
VALUES('fruits rouges');

-- FruitLegumes
INSERT INTO ProjetS3.FruitLegume
(nom_fruit, prix_kilo, poids, image, NB_FRUIT, id_user, id_type_fruit)
VALUES('artichaud', 0.4, 100, NULL, 6, 1, 1);

INSERT INTO ProjetS3.FruitLegume
(nom_fruit, prix_kilo, poids, image, NB_FRUIT, id_user, id_type_fruit)
VALUES('chou', 0.42, 250, NULL, 12, 1, 2);

INSERT INTO ProjetS3.FruitLegume
(nom_fruit, prix_kilo, poids, image, NB_FRUIT, id_user, id_type_fruit)
VALUES('prune', 0.13, 15, NULL, 24, 1, 3);

INSERT INTO ProjetS3.FruitLegume
(nom_fruit, prix_kilo, poids, image, NB_FRUIT, id_user, id_type_fruit)
VALUES('fraise', 2.5, 100, NULL, 35, 1, 4);

INSERT INTO ProjetS3.FruitLegume
(nom_fruit, prix_kilo, poids, image, NB_FRUIT, id_user, id_type_fruit)
VALUES('goyave', 0.78, 150, NULL, 16, 2, 5);


-- Dans commande
INSERT INTO ProjetS3.DansCommande
(id_fruit, id_commande, NB_FRUIT)
VALUES(1, 1, 1);

INSERT INTO ProjetS3.DansCommande
(id_fruit, id_commande, NB_FRUIT)
VALUES(2, 2, 2);

INSERT INTO ProjetS3.DansCommande
(id_fruit, id_commande, NB_FRUIT)
VALUES(3, 3, 3);

INSERT INTO ProjetS3.DansCommande
(id_fruit, id_commande, NB_FRUIT)
VALUES(4, 4, 4);

INSERT INTO ProjetS3.DansCommande
(id_fruit, id_commande, NB_FRUIT)
VALUES(5, 5, 5);

