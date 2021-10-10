<?php
namespace Projet;

require_once '../../modeles/Bd.php';
require_once '../../modeles/Item.php';
require_once '../../modeles/User.php';

$u = new User();
$u->populateIfConnected();
$bd = initBD();

$isModif = FALSE;
if(isset($_GET["idItem"])){
	$idItem = htmlspecialchars($_GET["idItem"]);
	$formItem = new Item();
	if($formItem->populateWithId($idItem)){
		$isModif = TRUE;
	}
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../styesheets/stock/main.css">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Stock</title>
</head>

<body>
	<?php
	require_once '../utilities/header.php';
	?>
	<div class="stock-container">
		<div class="stock-contain">
			<div class="forms">
				<form
					<?php
					if($isModif){
						echo "action=\"../../controleurs/_modif_item.php\"";
					}else{
						echo "action=\"../../controleurs/_add_to_stock.php\"";
					}
					?>
					method="post" enctype="multipart/form-data">

					<?php
					if($isModif){
						echo "<input type=\"hidden\" name=\"idItem\" value=\"{$formItem->getIdItem()}\">";
					}
					?>
					
					<div class="title-section">
						<h2 class="subtitle">Gérez vos compte ici</h2>
					</div>
					<?php
					if($isModif){
						echo <<<EOF
							<div class="supprimer">
								<a href="../../controleurs/_remove_from_stock.php?idItem={$formItem->getIdItem()}">
									<i class="far fa-trash-alt" style="font-size: 48px;" id="trash"></i>
								</a>
							</div>
						EOF;
					}
					?>
					<div class="input-section">
						<div class="area">
							<label for="" class="stock-lbl">Un produit a entrer ?</label>
							<input type="text" class="input-txt" name="nom" placeholder="exp BANANE"
								<?php if($isModif) { echo "value=\"{$formItem->getNom()}\""; } ?> required="required">
						</div>
						<div class="area">
							<label for="" class="stock-lbl">Décriver votre produit:</label>
							<input type="text" class="input-txt" name="description" placeholder="exp Description ..."
								<?php if($isModif) { echo "value=\"{$formItem->getDescription()}\""; } ?>>
						</div>
						<div class="area">
							<label for="" class="stock-lbl">Fruit ou légume ?</label> <select name="category" id="category">
								<option value="0">--Choose a product category--</option>
								<option value="1">vegetables</option>
								<option value="2">fruits</option>
							</select>
						</div>
						<div class="area">
							<label for="" class="stock-lbl">Fruit ou légume ?</label>
							<input type="text" class="input-txt" placeholder="exp EXOTQUE ">
						</div>
						<div class="area">
							<label for="" class="stock-lbl">Combien de produits ?</label>
							<input type="number" class="input-number" min="0" name="nb"
								value="<?php if($isModif) { echo "{$formItem->getNb()}"; }else{ echo "0";} ?>">
						</div>
						<div class="area">
							<label for="" class="stock-lbl"> poids moyen d'un produit (en gramme g) </label>
							<input type="number" class="input-number" min="0" name="poids"
								value="<?php if($isModif) { echo "{$formItem->getPoidsUnite()}"; }else{ echo "0";} ?>" tabindex="0.1"
								required="required">
						</div>
						<div class="area">
							<label for="" class="stock-lbl"> prix/kg</label>
							<input type="number" id="prix" class="input-number" min="0" name="prixKilo"
								value="<?php if($isModif) { echo "{$formItem->getPrixKilo()}"; }else{ echo "0";} ?>" tabindex="0.1"
								required="required">
						</div>
						<div class="area">
							<label for="stock-lbl">Entrer une image du produit:</label>
							<input type="file" class="img-input" name="image" accept=".jpg,.jpeg" src="" alt="">
						</div>
						<div class="inputs">
							<input class="btn-input" type="submit" name="send"
								value="<?php
								if($isModif){
									echo "Modifier l'Item";
								}else{
									echo "Ajouter l'Item";
								}
								?>"
								required>
						</div>
						<p id="required">* :is required</p>
					</div>
				</form>
			</div>
			<div class="your-merk">
				<h1>Vos articles</h1>
				<div class="bd-grid">
					<?php
					$idUser = $u->getIdUser();

					$nbelementpage = 80;
					if(isset($_SESSION["page"])){
						$page = $_SESSION["page"];
					}else{
						$page = 1;
					}
					$start = ($page - 1) * $nbelementpage;
					$end = $page * $nbelementpage;
					$sql = "SELECT idItem FROM ProjetS3.Item WHERE idUser='{$idUser}' ORDER BY idItem LIMIT {$start}, {$end}";
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
									<h3>{$item->getNom()} x {$item->getNb()}</h3>
								</div>
								<div class="card-precis">
									<span class="price">{$item->getPrix()}$</span>
									<span class="poids">{$item->getPoidsUnite()}g</span>
									<a href="./stock.php?idItem={$item->getIdItem()}">
										<i class="far fa-edit"></i>
									</a>
								</div>
							</article>
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