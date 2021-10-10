<?php
namespace Projet;

require_once '../modeles/User.php';
require_once '../modeles/Commande.php';

$u = new User();
$u->populateIfConnected();

if(isset($_GET["idCommande"])){
	$idCommande = htmlspecialchars($_GET["idCommande"]);
	$c = new Commande();
	$c->populateWithId($idCommande);
	if($c->getIdProducteur() == $u->getIdUser()){
		$c->setValidated(TRUE);
	}
	header("Location: ../vues/account/detailLivraison.php?idCommande={$c->getIdCommande()}");
}else{
	header("Location: ../vues/account/gererLivraison.php");
}
?>