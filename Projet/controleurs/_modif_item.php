<?php
namespace Projet;

require_once '../modeles/User.php';
require_once '../modeles/Item.php';

$u = new User();
$u->populateIfConnected();

extract($_POST);

$idItem = htmlspecialchars($_POST['idItem']);
$nom = htmlspecialchars($_POST['nom']);
$description = htmlspecialchars($_POST['description']);
$prixKilo = htmlspecialchars($_POST['prixKilo']);
$poids = htmlspecialchars($_POST['poids']);
$nb = htmlspecialchars($_POST['nb']);

$image = NULL;
if($_FILES['image']['tmp_name'] !== ""){
	if($_FILES["image"]["size"] > 20971520){
		echo "Sorry, your file is too large: ".($_FILES["image"]["size"] / (1024 * 1024));
		return;
	}
	$image_extention = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
	if(!($image_extention == "jpg" || $image_extention == "jpeg")){
		echo "Sorry, we only accept jpeg file (.jpg/.jpeg), not: ".$image_extention;
		return;
	}
	$image = file_get_contents($_FILES['image']['tmp_name']);
	unlink($_FILES['image']['tmp_name']);
}

$item = new Item();
$item->populateWithId($idItem);
$item->updateInfos($nom, $description, $prixKilo, $poids, $nb, $image);

header("Location: ../vues/account/stock.php");
?>