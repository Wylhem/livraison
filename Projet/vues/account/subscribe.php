<?php
namespace Projet;

require_once '../../modeles/Bd.php';
require_once '../../modeles/User.php';

$u = new User();
$u->populateIfConnected();
$bd = initBD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../styesheets/sub/main.css">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Abonnement</title>
</head>

<body>
	<?php
	require_once '../utilities/header.php';
	?>
	<div class="subscribe-container">
		<div class="sub-card">
			<div class="sub-title">Livraison hebdomadaire</div>
			<div class="sub-icon">
				<img src="../../images/arrived.svg" alt="">
				<div class="sub-features">
					<ul>
						<li><span class="bold">1</span> panier complet de fruits et légumes différents tous les mois</li>
						<li><span class="bold">1</span> Livraison tous les mois</li>
						<li><span class="bold">3</span> mois d'essai gratuit</li>
						<li><span class="bold">70 €</span> / an</li>
					</ul>
					<div class="btns">
					<?php
					if(isset($_SESSION["sub"]) && $_SESSION["sub"] == TRUE){
						echo <<<EOF
						<button class="sub-btn">
							<a href="../../controleurs/_subscribe.php?subscribe=false" class="sub-btn">Annuler l'abonnement </a>
						</button>
						EOF;
					}else{
						echo <<<EOF
						<button class="sub-btn">
							<a href="../../controleurs/_subscribe.php?subscribe=true" class="sub-btn">S'abonner</a>
						</button>
						EOF;
					}

					?>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>


	<script src="../js/funtions.js"></script>
</body>

</html>