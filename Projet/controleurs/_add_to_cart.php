<?php
namespace Projet;

require_once '../modeles/Item.php';
require_once '../modeles/User.php';

$u = new User();
$u->populateIfConnected();

$idItem = htmlspecialchars($_GET['idItem']);
$nb = htmlspecialchars($_GET['nb']);

$u->setToCart($idItem, $nb);

header("Location: ../vues/cart/cart.php");

?>