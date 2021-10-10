<?php
namespace Projet;

require_once '../modeles/User.php';
require_once '../modeles/Bd.php';

$bd = initBD();

$u = new User();
$u->populateIfConnected();

$idItem = htmlspecialchars($_GET['idItem']);

$bd->modify_query("DELETE FROM ProjetS3.Item WHERE idUser={$u->getIdUser()} AND idItem={$idItem}");

header("Location: ../vues/account/stock.php");
?>