
DROP VIEW IF EXISTS FruitLegumeView;
DROP VIEW IF EXISTS CommandeUtilisateur;


CREATE VIEW FruitLegumeView AS
	SELECT id_fruit, nom_fruit, nom_type_fruit, prix_kilo, poids, image
	FROM FruitLegume
	JOIN TypeFruit;
	
CREATE VIEW CommandeUtilisateur AS
	SELECT c.id_user, c.id_commande, l.id_user AS 'id_producteur', c.is_payed, c.date_commande, l.date_envoi, l.id_adress
	FROM Commande c
	JOIN Livraison l ON(c.id_livraison = l.id_livraison);





	