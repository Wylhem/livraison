<?php
namespace Projet;

require_once '../../modeles/User.php';

$u = new User();
$u->tryPopulateIfConnected();
?>
<header>
	<div class="left_area">
		<a href="../landing/landing.php">
			<img src="../images/Icon_Potato.png" alt="">
		</a>
	</div>
	<div class="bar">
		<a href="../cart/cart.php">
			<i id="basket" class="fas fa-shopping-basket"></i>
		</a>
		<label for="check" id="toggle" onclick="toggleMenu();"><i class="fas fa-bars"></i></label>
	</div>
</header>
<div id="navigation">
	<ul>
		<li>
			<?php
			if($u->getImageProfil() !== NULL){
				echo <<<EOF
				<div class="prof-img">
					<img src="../../controleurs/_get_image.php?idUser={$u->getIdUser()}" alt="">
				</div>
				EOF;
			}else{
				echo <<<EOF
				<i class="fas fa-user-circle" id="img-account"></i>
				EOF;
			}
			?>
			<h3 class="nom"><?php echo "{$u->getFamilyName()} {$u->getForeName()}" ?></h3>
			<h4 class="nom"><?php echo "id: {$u->getIdUser()}"; ?></h4>
		</li>
		<li>
			<a href="../account/profil.php">
				<i class="fas fa-user"></i>
				<span>Votre compte</span>
			</a>
		</li>
		<li>
			<a href="../acceuil/marchandise.php">
				<i class="fas fa-shopping-bag"></i>
				<span>Shop</span>
			</a>
		</li>
		<li>
			<a href="../account/commandes.php">
				<i class="fas fa-address-book"></i>
				<span>Vos commandes</span>
			</a>
		</li>
		<li>
			<a href="../account/subscribe.php">
				<i class="fas fa-archive"></i>
				<span>Vos abonnements</span>
			</a>
		</li>
		<?php
		if($u->isConnected() && $u->isProducteur()){
			echo <<<EOF
			<li>
				<a href="../account/stock.php">
					<i class="fas fa-store"></i>
					<span>Gerer vos stocks</span>
				</a>
			</li>
			<li>
				<a href="../account/gererLivraison.php">
					<i class="fas fa-truck-loading"></i>
					<span>Gerer vos livraisons</span>
				</a>
			</li>
			EOF;
		}
		?>
		
		<li>
			<a href="../../controleurs/_deconnexion.php">
				<i class="fas fa-sign-out-alt"></i>
				<span>Se déconnecter</span>
			</a>
		</li>
	</ul>
</div>