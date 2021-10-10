<?php
namespace Projet;

require_once '../modeles/User.php';

$pseudo = htmlspecialchars($_POST['pseudo']);
$password = htmlspecialchars($_POST['password']);

if(empty($pseudo) || empty($password)){
	header("Location: ../vues/forms/connexion.php");
}

$u = new User();

$result = $u->connexion($pseudo, $password);

if($result){
	header("Location: ../vues/acceuil/marchandise.php");
}else{
	header("Location: ../vues/forms/connexion.php");
}

?>