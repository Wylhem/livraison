
DROP TRIGGER IF EXISTS hors_stock;
DROP TRIGGER IF EXISTS prix_fruit;
DROP TRIGGER IF EXISTS poids_fruit;

DELIMITER /

-- hors stock
CREATE TRIGGER hors_stock BEFORE UPDATE ON ProjetS3.FruitLegume FOR EACH ROW 
BEGIN 
	IF (NEW.NB_FRUIT < 0) THEN
		SET NEW.NB_FRUIT = OLD.NB_FRUIT;
	END IF;
END;
/

-- anti prix negatif
CREATE TRIGGER prix_fruit BEFORE UPDATE ON ProjetS3.FruitLegume FOR EACH ROW 
BEGIN
	IF (NEW.prix_kilo < 0) THEN
		SET NEW.prix_kilo = OLD.prix_kilo;
	END IF;
END;
/

-- pas de poids negatifs
CREATE TRIGGER poids_fruit BEFORE UPDATE ON ProjetS3.FruitLegume FOR EACH ROW 
BEGIN
	IF (NEW.poids < 0) THEN
		SET NEW.poids = OLD.poids;
	END IF;
END;
/

DELIMITER ;














-- ajouter triger pas de Livraison, Commande et stock a genere quand estProducteur = False; 



