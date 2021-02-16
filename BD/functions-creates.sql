
DROP PROCEDURE IF EXISTS addUtilisateur;
DROP PROCEDURE IF EXISTS tryChangeMdpUtilisateur;
-- DROP PROCEDURE IF EXISTS startResetMdpUtilisateur;
-- DROP PROCEDURE IF EXISTS doResetMdpUtilisateur;
DROP PROCEDURE IF EXISTS loginUtilisateur;
DROP PROCEDURE IF EXISTS changeInfoUtilisateur;
DROP PROCEDURE IF EXISTS deleteUtilisateur;


DELIMITER /

-- crée un nouvelle utilisateur
CREATE PROCEDURE addUtilisateur (
	email Varchar(128),
	pseudo Varchar(64),
	name Varchar(64),
	forname Varchar(64),
	hashmdp Varchar(256),
	estProducteur Bool
)
BEGIN
	IF (SELECT COUNT(*) FROM Utilisateur u WHERE u.email = email) != 0 THEN
		SELECT -1;
	END IF;
	IF (SELECT COUNT(*) FROM Utilisateur u WHERE u.pseudo = pseudo) != 0 THEN
		SELECT -2;
	END IF;
	IF (SELECT COUNT(*) FROM Utilisateur u WHERE u.email = email OR u.pseudo = pseudo) = 0 THEN
		INSERT INTO Utilisateur (email, pseudo, name, forname, hashmdp, estProducteur) VALUES (email, pseudo, name, forname, hashmdp, estProducteur);
		CALL loginUtilisateur(email, hashmdp);
	END IF;
END;
/

-- change mdp
CREATE PROCEDURE tryChangeMdpUtilisateur(
	IN id_user Int,
	IN oldMdp Varchar(256),
	IN newMdp Varchar(256)
)
BEGIN
	UPDATE Utilisateur u
	SET u.hashmdp = newMdp
	WHERE u.id_user = id_user AND u.hashmdp = oldMdp;
END;
/
/*
-- start reset mdp procedure (need to send a mail in PHP before calling this function)
CREATE PROCEDURE startResetMdpUtilisateur(
	IN email Varchar(128),
	IN resetToken Varchar(256)
)
BEGIN
	UPDATE Utilisateur u
	SET u.hashmdp = newMdp
	WHERE u.email = email;
END;
/

-- reset mdp (after the client get a mail with the reset token)
CREATE PROCEDURE doResetMdpUtilisateur(
	IN email Varchar(128),
	IN resetToken Varchar(256),
	IN newMdp Varchar(256)
)
BEGIN
	UPDATE Utilisateur u
	SET u.hashmdp = newMdp, u.resetPWDToken = NULL
	WHERE u.email = email AND u.resetPWDToken IS NOT NULL AND u.resetPWDToken = resetToken;
END;
/
*/
-- login an Utilisateur
CREATE PROCEDURE loginUtilisateur(
	email Varchar(128),
	hashmdp Varchar(256)
)
BEGIN
	SELECT u.id_user FROM Utilisateur u WHERE u.email = email AND u.hashmdp = hashmdp;
END;
/

-- modifier les infos de l'utilisateur
CREATE PROCEDURE changeInfoUtilisateur(
	IN id_user Int,
	IN email Varchar(128),
	IN pseudo Varchar(64),
	IN name Varchar(64),
	IN forname Varchar(64),
	IN estProducteur Bool
)
BEGIN
	-- utilisateur avec ce mail existe deja
	IF (SELECT COUNT(*) FROM Utilisateur u WHERE u.email = email) != 0 THEN
		SELECT -1;
	END IF;
	-- utilisateur avec se pseudo existe deja
	IF (SELECT COUNT(*) FROM Utilisateur u WHERE u.pseudo = pseudo) != 0 THEN
		SELECT -2;
	END IF;
	-- nouvelle info valide, modification du profile de l'utilisateur
	IF (SELECT COUNT(*) FROM Utilisateur u WHERE u.email = email OR u.pseudo = pseudo) = 0 THEN
		UPDATE Utilisateur u SET u.email = email, u.pseudo = pseudo, u.name = name, u.forname = forname , u.estProducteur = estProducteur WHERE u.id_user = id_user;
		SELECT id_user;
	END IF;
END;
/

-- supprimer un utilisateur
CREATE PROCEDURE deleteUtilisateur(
	IN id_user Int
)
BEGIN
	DELETE FROM Utilisateur u WHERE u.id_user = id_user;
END;
/


DELIMITER ;