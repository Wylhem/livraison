
INSERT INTO ProjetS3.Utilisateur
(email, pseudo, name, forname, hashmdp, resetPWDToken, estProducteur)
VALUES('test', 'test', 'test', 'test', 'gfxhjxfghxfg', NULL, TRUE);


INSERT INTO ProjetS3.TypeFruit
(nom_type_fruit)
VALUES('test');


INSERT INTO ProjetS3.FruitLegume
(nom_fruit, prix_kilo, poids, image, NB_FRUIT, id_user, id_type_fruit)
VALUES('test', 5, 3, NULL, 8, 1, 1);




UPDATE ProjetS3.FruitLegume
SET NB_FRUIT=-5
WHERE id_user=1 AND id_fruit=1;

UPDATE ProjetS3.FruitLegume
SET prix_kilo=-47
WHERE id_user=1 AND id_fruit=1;

UPDATE ProjetS3.FruitLegume
SET poids=-82
WHERE id_user=1 AND id_fruit=1;


