<?php
namespace Projet;

require_once '../../modeles/Bd.php';
require_once '../../modeles/Item.php';

$bd = initBD();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">

<link rel="stylesheet" href="../styesheets/hub/main.css">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Marchandise</title>
</head>

<body>
	
	<?php
	require_once '../utilities/header.php';
	?>

	<div class="bg-img"></div>
	<h1 class="title-shop">Shop</h1>
	<main class="main bd-grid">
	
	
			<?php
			$nbelementpage = 80;
			if(isset($_SESSION["page"])){
				$page = $_SESSION["page"];
			}else{
				$page = 1;
			}
			$start = ($page - 1) * $nbelementpage;
			$end = $page * $nbelementpage;
			$sql = "SELECT idItem FROM ProjetS3.Item WHERE nb > 0 ORDER BY idItem LIMIT {$start}, {$end}";
			// var_dump($sql);
			$res = $bd->query($sql);
			while($row = $res->fetch_assoc()){
				$idItem = $row["idItem"];
				$item = new Item();
				$item->populateWithId($idItem);

				echo <<<EOF
					<article class="card">
						<div class="card-img">
							<img src="../../controleurs/_get_image.php?idItem={$item->getIdItem()}" alt="">
						</div>
						<div class="card-name">
							<h3>{$item->getNom()}</h3>
						</div>
						<div class="card-precis">
							<span class="price">{$item->getPrix()}€</span>
							<span class="poids">{$item->getPoidsUnite()}g</span>
							<a href="../../controleurs/_add_to_cart.php?idItem={$item->getIdItem()}&nb=1">
								<i class="fas fa-cart-plus"></i>
							</a>
						</div>
					</article>
				EOF;
			}
			?>
	</main>

	<script src="../js/funtions.js"></script>

</body>

</html>