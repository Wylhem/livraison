<?php
namespace Projet;

require_once '../../modeles/Commande.php';
require_once '../../modeles/User.php';

$bd = initBD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../styesheets/commande/main.css">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Commandes</title>
</head>

<body>
	<?php
	require_once '../utilities/header.php';
	?>

	<div class="com-container">
		<div class="com-contain">
			<div class="title-section">
				<h1 class="subtitle ">historique des achats</h1>
				<p>Voir les détails des transactions de votre compte</p>
			</div>
			<div class="result-container">
				<!-- 				<div class="input-section"> -->
				<!-- 					<div class="area"> -->
				<!-- 						<select name="his-achat" id="achat"> -->
				<!-- 							<option value="0">Trier en fonction de</option> -->
				<!-- 							<option value="1">prix croissant</option> -->
				<!-- 							<option value="2">prix decroissant</option> -->
				<!-- 							<option value="3">date croissant</option> -->
				<!-- 							<option value="4">date decroissant</option> -->
				<!-- 							<option value="5">Statut Terminer</option> -->
				<!-- 							<option value="6">Statut en attente</option> -->
				<!-- 							<option value="7">Statut en cours de livraison</option> -->
				<!-- 						</select> -->
				<!-- 					</div> -->
				<!-- 				</div> -->
				<table class="achat-container">
					<thead>
						<tr>
							<th>DATE</th>
							<th>id commande</th>
							<th>prix</th>
							<th>STATUT</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$u = new User();
					$u->populateIfConnected();

					$sql = "SELECT idCommande FROM ProjetS3.Commande WHERE idUser={$u->getIdUser()} ORDER BY idCommande DESC";

					$res = $bd->query($sql);
					while($row = $res->fetch_assoc()){
						$c = new Commande();
						$c->populateWithId($row["idCommande"]);
						$status = ($c->isValidated() ? "Terminé" : "En attente");
						echo <<< EOF
							<tr>
								<td>{$c->getDate()}</td>
								<td><a href="../account/detailLivraison.php?idCommande={$c->getIdCommande()}" class="blue">{$c->getIdCommande()}</a></td>
								<td class="price">{$c->calculatePrix()}</td>
								<td>{$status}</td>
							</tr>
						EOF;
					}

					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script src="../js/funtions.js"></script>
</body>

</html>