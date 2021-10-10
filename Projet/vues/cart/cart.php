<?php
namespace Projet;

require_once '../../modeles/Item.php';
require_once '../../modeles/User.php';

$u = new User();
$u->populateIfConnected();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../styesheets/basket/main.css">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Panier</title>
</head>

<body>
	<?php
	require_once '../utilities/header.php';
	?>
	<main>
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
			$cart = $u->getCart();
			$totale = 0;
			foreach($cart as $idItem => $nb){
				$item = new Item();
				$item->populateWithId($idItem);
				$subtotale = $item->getPrix() * $nb;
				$totale += $subtotale;
				echo <<<EOF
					<div class="basket-product">
						<div class="item">
							<div class="product-image">
								<img src="../../controleurs/_get_image.php?idItem={$item->getIdItem()}" alt="">
							</div>
							<div class="product-details">
								<p>
									<span class="bold">{$nb} x {$item->getNom()}</span>
								</p>
								<p>
									<span class="bold">Product code :</span>
									{$item->getIdItem()}
								</p>
							</div>
						</div>
						<div class="price">{$item->getPrix()}€</div>
						<div class="quantity">
							<form action="../../controleurs/_add_to_cart.php" method="get">
								<input type="hidden" name="idItem" value="{$item->getIdItem()}">
								<input type="number" name="nb" value="{$nb}" min="1" max="{$item->getNb()}" class="quantity-field">
								<button class="btn-input" type="submit" name="send" required>
									<i class="far fa-save"></i>
								</button>
							</form>
						</div>
						<div class="subtotal">{$subtotale}€</div>
						<div class="remove">
							<a href="../../controleurs/_remove_from_cart.php?idItem={$item->getIdItem()}">
								<i class="far fa-trash-alt" style="font-size: 24px;" id="trash"></i>
							</a>
						</div>
					</div>
				EOF;
			}

			?>
		</div>

		<aside>
			<form action="" method="post">
				<div class="summary">
					<div class="summary-total-items">
						<span class="total-items">Items dans votre Panier</span>
					</div>

					<div class="summary-email">
						<div class="email-title">Des personnes à ajouter à la commande ?</div>
						<input class="input-email" type="text" name="email" placeholder="Email">
						<input type="button" class="button-email" name="check" value="valider">

<!-- 						<p class="email-added"> -->
<!-- 							wyl <i class="fas fa-times"></i> -->
<!-- 						</p> -->
					</div>

					<div class="summary-subtotal">
						<div class="total-title">Total</div>
						<div class="subtotal-value final-value" id="basket-subtotal">
							<?php echo "{$totale}€" ?>
						</div>
					</div>
					<div class="summary-subtotal">
						<div class="summary-checkout">
						<?php
						if($totale < 5){
							echo "Commande < 5€";
						}else{
							echo <<< EOF
								<a href="../../controleurs/_pass_command.php" class="check"> Commander </a>
							EOF;
						}
						?>
						</div>
					</div>
				</div>
			</form>
		</aside>
	</main>

	<script src="../js/funtions.js"></script>

</body>

</html>