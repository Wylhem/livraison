<?php
namespace Projet;

require_once '../Projet/modeles/Bd.php';
require_once '../Projet/modeles/info.php';

$bd = new Bd("127.0.0.1", $GLOBALS["bd_user"], $GLOBALS["bd_passwd"], "ProjetS3");

$ressource = fopen("./infos.csv", 'r');
$idProducteur = $bd->row_query("SELECT idUser FROM ProjetS3.Utilisateur WHERE isProducteur=1 ORDER BY idUser ASC LIMIT 1 ")["idUser"];
var_dump($idProducteur);

while(($row = fgetcsv($ressource, 0, "\t")) !== FALSE){

	$sql = "INSERT INTO ProjetS3.Item (nom, description, prixKilo, poidsUnite, nb, idUser) VALUES('{$row[1]}', '{$row[2]}', '{$row[3]}', {$row[4]}, {$row[5]}, {$idProducteur})";
	echo $sql;
	echo "</br>";
	$bd->modify_query($sql);

	$filename = "./images/{$row[1]}.jpg";
	var_dump($filename);
	echo "</br>";
	$data = file_get_contents($filename);

	$res = $bd->update_type_querry("image", "ProjetS3.Item", $data, "nom='{$row[1]}'", 'b');

	$data = $bd->select_type_querry("image", "ProjetS3.Item", "nom='{$row[1]}'");
}

?>