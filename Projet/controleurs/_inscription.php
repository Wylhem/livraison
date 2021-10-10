<?php
namespace Projet;

require_once '../modeles/User.php';

$email = htmlspecialchars($_POST['email']);
$pseudo = htmlspecialchars($_POST['pseudo']);
$password = htmlspecialchars($_POST['password']);
$passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
$isProducteur = isset($_POST['isProducteur']);

if(empty($email) || empty($pseudo) || empty($password) || empty($passwordConfirm)){
	header("Location: ../vues/forms/inscription.php");
}

$u = new User();

$result = $u->inscription($email, $pseudo, $password, $passwordConfirm, $isProducteur);

if($result){
	header("Location: ../vues/account/profil.php");
}else{
	header("Location: ../vues/forms/inscription.php");
}

?>