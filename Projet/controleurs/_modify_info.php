<?php
namespace Projet;

require_once '../modeles/User.php';
require_once '../modeles/Adress.php';

$u = new User();
$u->populateIfConnected();

$a = new Adress();
$a->populateWithUser($u->getIdUser());

extract($_POST);

$pseudo = htmlspecialchars($_POST['pseudo']);
$email = htmlspecialchars($_POST['email']);

$foreName = htmlspecialchars($_POST['foreName']);
$familyName = htmlspecialchars($_POST['familyName']);

$adress = htmlspecialchars($_POST['adress']);
$city = htmlspecialchars($_POST['city']);
$CP = htmlspecialchars($_POST['CP']);

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

$u->updateInfos($pseudo, $email, $foreName, $familyName);
$u->setImage($image);
$a->updateMainAdress($adress, $city, $CP);

header("Location: ../vues/account/profil.php");

?>