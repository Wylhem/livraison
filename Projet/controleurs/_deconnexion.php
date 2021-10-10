<?php
namespace Projet;

require_once '../modeles/User.php';

$u = new User();
$u->setConnected(FALSE);

header("Location: ../vues/landing/landing.php");

?>