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
<title>Gerer Livraison</title>
</head>

<body>
	<?php
	require_once '../utilities/header.php';
	?>
	<div class="com-container">
		<div class="com-contain">
			<div class="title-section">
				<h1 class="subtitle">GERER les livraison</h1>
				<p>Voir les détails des transactions de vos clients</p>
			</div>
			<div class="result-container">
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

						$sql = "SELECT idCommande FROM ProjetS3.Commande WHERE idProducteur={$u->getIdUser()} ORDER BY idCommande DESC";

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
	<script src="../../js/funtions.js"></script>
</body>

</html>