<?php
namespace Projet;

require_once '../modeles/User.php';
require_once '../modeles/Adress.php';
require_once '../modeles/Item.php';
require_once '../modeles/Commande.php';

$u = new User();
$u->populateIfConnected();
$a = new Adress();
$a->populateWithUser($u->getIdUser());
if($a->getIdAdress() === NULL){
	$_SESSION["error_validate_adress"] = "Vous ne pouvez pas commander si vous n'avez pas d'addresse.";
	header("Location: ../vues/account/profil.php");
	return;
}

$cart = $u->getCart();
$limit_prix = 5;
$current_prix = 0;
foreach($cart as $idItem => $nb){
	$item = new Item();
	$item->populateWithId($idItem);
	$current_prix += $item->getPrix() * $nb;
}

if($current_prix > $limit_prix){

	$c = new Commande();
	$c->populateNewCommande($u->getIdUser());

	foreach($cart as $id => $nb){
		$c->setItem($id, $nb);
	}

	$u->dumpCart();

	header("Location: ../vues/account/commandes.php");
}else{
	header("Location: ../vues/cart/cart.php");
}
?>