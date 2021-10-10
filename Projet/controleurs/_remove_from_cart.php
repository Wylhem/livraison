<?php
namespace Projet;

require_once '../modeles/User.php';

$bd = initBD();

$u = new User();
$u->populateIfConnected();

$idItem = htmlspecialchars($_GET['idItem']);

$u->removeFromCart($idItem);

header("Location: ../vues/cart/cart.php");
?>