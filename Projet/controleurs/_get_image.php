<?php
namespace Projet;

require_once '../modeles/User.php';
require_once '../modeles/Item.php';

// function getimage($image){
// $filename = basename($image);
// $file_extension = strtolower(substr(strrchr($filename, "."), 1));
// switch($file_extension){
// case "gif":
// $ctype = "image/gif";
// break;
// case "png":
// $ctype = "image/png";
// break;
// case "jpeg":
// case "jpg":
// $ctype = "image/jpeg";
// break;
// default:
// }

// header('Content-type: '.$ctype);
// $image = file_get_contents($image);
// echo $image;
// }

// $image = "../../../../projet-s3-livraison/fruitslegumes/images/{$_GET["name"]}.jpg";
// getimage($image);

$image = NULL;
if(isset($_GET['idItem'])){
	$idItem = htmlspecialchars($_GET['idItem']);
	$item = new Item();
	$item->populateWithId($idItem);
	$image = $item->getImage();
}else{
	$idUser = htmlspecialchars($_GET['idUser']);
	$user = new User();
	$user->populateWithId($idUser);
	$image = $user->getImageProfil();
}

$ctype = "image/jpeg";
header('Content-type: '.$ctype);
if($image !== NULL){
	echo $image;
}

?>