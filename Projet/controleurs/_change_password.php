<?php
namespace Projet;

require_once '../modeles/User.php';

$currentPassword = htmlspecialchars($_POST['currentPassword']);
$password = htmlspecialchars($_POST['password']);
$passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);

if(empty($currentPassword) || empty($password) || empty($passwordConfirm)){
	header("Location: ../vues/account/profil.php");
}

$u = new User();
$u->populateIfConnected();

$result = $u->changePasword($currentPassword, $password, $passwordConfirm);

header("Location: ../vues/account/profil.php");

?>