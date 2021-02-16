
-- ajout de l'utilisateur
	-- sucess
CALL addUtilisateur("nicolas.marie@u-psud.fr", "Nico", "MARIE", "Nicolas", "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6", FALSE);
	-- failed
		-- memme pseudo et email
CALL addUtilisateur("nicolas.marie@u-psud.fr", "Nico", "MARIE", "Nicolas", "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6", FALSE);
		-- memme email
CALL addUtilisateur("nicolas.marie@u-psud.fr", "unpseudo", "MARIE", "Nicolas", "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6", FALSE);
		-- memme pseudo
CALL addUtilisateur("other@mail.fr", "Nico", "MARIE", "Nicolas", "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6", FALSE);


-- test changement de mdp
	-- sucess
CALL tryChangeMdpUtilisateur(1, "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6", "47b8ed851158e9062c7c505d041068db23f9c15557f249f1e03c200bd3376e3ac286791872103aec38e7a85f05cebde3ddee5e1c4430510e7f63c2045fab48af");
	-- failed
CALL tryChangeMdpUtilisateur(1, "wrong password", "47b8ed851158e9062c7c505d041068db23f9c15557f249f1e03c200bd3376e3ac286791872103aec38e7a85f05cebde3ddee5e1c4430510e7f63c2045fab48af");
CALL tryChangeMdpUtilisateur(57, "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6", "47b8ed851158e9062c7c505d041068db23f9c15557f249f1e03c200bd3376e3ac286791872103aec38e7a85f05cebde3ddee5e1c4430510e7f63c2045fab48af");


-- test login
	-- sucess
CALL loginUtilisateur("nicolas.marie@u-psud.fr", "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6");
	-- failed
		-- utilisateur n'existe pas
CALL loginUtilisateur("test@jsp.io", "313dee0b8b9b98060fbf183249811ef45fbef0a5843c5f4a97bb65d678bc42cb0251a8753f3b735b0e8e795cf6472cac10b3a59629e7cb87a2282c14953dffb6");
		-- mot de passe invalide
CALL loginUtilisateur("nicolas.marie@u-psud.fr", "pas le bon mdp");


-- test changeInfoUtilisateur
CALL changeInfoUtilisateur(1, 'newmail@jsp.org', 'un nouveau pseudo', 'mon nouveau nom', 'a new forname', FALSE);

-- test deleteUtilisateur
CALL deleteUtilisateur(1);








