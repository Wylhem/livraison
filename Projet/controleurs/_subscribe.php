<?php
namespace Projet;

require_once '../modeles/Bd.php';
require_once '../modeles/Item.php';
require_once '../modeles/User.php';

$u = new User();
$u->populateIfConnected();
$bd = initBD();

$subscribe = htmlspecialchars($_GET['subscribe']);

if(isset($subscribe)){
	if($subscribe == "true"){
		$_SESSION["sub"] = TRUE;
	}elseif($subscribe == "false"){
		$_SESSION["sub"] = FALSE;
	}
}

header("Location: ../vues/account/subscribe.php");

?>