<?php
namespace Projet;

require_once '../../modeles/Commande.php';
require_once '../../modeles/User.php';

$curentUser = new User();
$curentUser->populateIfConnected();

if(isset($_GET["idCommande"])){
	$idCommande = htmlspecialchars($_GET["idCommande"]);

	$c = new Commande();
	$c->populateWithId($idCommande);

	$clientUser = new User();
	$clientUser->populateWithId($c->getIdUser());

	if($c->getIdProducteur() == $curentUser->getIdUser()){
		$accesProducteur = TRUE;
	}elseif($c->getIdUser() == $curentUser->getIdUser()){
		$accesProducteur = FALSE;
	}else{
		header("Location: ./commandes.php");
	}
}else{
	header("Location: ./commandes.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../styesheets/detailCommande/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Detail Livraison</title>
</head>

<body>
	<?php
	require_once '../utilities/header.php';
	?>
	<div class="det-container">
		<div class="det-contain">
			<div class="title-section">
				<div class="subtitle">
					<h2>information sur la commande</h2>
				</div>
			</div>
			<div class="detail-section">
				<p>
					<span class="bold">N° de commande : </span>
					<?php echo $c->getIdCommande(); ?>
				</p>
				<p>
					<span class="bold">Date de la commande : </span>
					<?php echo $c->getDate(); ?>
				</p>
				<p>
					<span class="bold">facturée a : </span>
					<a href="" class="blue"><?php echo $clientUser->getEmail(); ?></a>
				</p>
				<p>
					<span class="bold">Prix : </span>
					<?php echo "{$c->calculatePrix()} €"; ?>
				</p>
				<p>
					<span class="bold">Statut : </span>
					<?php echo ($c->isValidated() ? "Validé" : "En attente"); ?>
				</p>
				<?php
				if($accesProducteur){
					echo <<<EOF
						<p>
							<span class="bold"> Validé la commande :</span>
							<a href="../../controleurs/_validate_commande.php?idCommande={$c->getIdCommande()}" class="blue">
								<i class="far fa-calendar-check" style="overflow: hidden;"></i>
							</a>
						</p>
					EOF;
				}
				?>

			</div>
			<div class="recap">
				<div class="basket">
					<div class="basket-labels">
						<ul>
							<li class="item item-heading">Item</li>
							<li class="price">Price</li>
							<li class="quantity">quantity</li>
							<li class="subtotal">Subtotal</li>
						</ul>
					</div>
					<?php
					foreach($c->getItems() as $idItem => $infos){
						$item = new Item();
						$item->populateWithId($idItem);

						$nb = $infos["nb"];
						$prixKilo = $infos["prixKilo"];
						$poidsUnite = $infos["poidsUnite"];
						$prixUnite = ($prixKilo * $poidsUnite) / 1000;
						$subTotale = $prixUnite * $nb;
						echo <<<EOF
						<div class="basket-product">
							<div class="item">
								<div class="product-image">
									<img src="../../controleurs/_get_image.php?idItem={$item->getIdItem()}" alt="">
								</div>
								<div class="product-details">
									<p>
										<span class="bold">{$item->getNom()}</span>
									</p>
									<p>
										<span class="bold">Product code :</span>
										{$item->getIdItem()}
									</p>
								</div>
							</div>
							<div class="price">{$prixUnite} €</div>
							<div class="quantity">{$nb}</div>
							<div class="subtotal">{$subTotale} €</div>
						</div>
						EOF;
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<script src="../js/funtions.js"></script>
</body>

</html>