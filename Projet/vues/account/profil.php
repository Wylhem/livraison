<?php
namespace Projet;

require_once '../../modeles/User.php';
require_once '../../modeles/Adress.php';

initSession();

$u = new User();
$u->populateIfConnected();
$a = new Adress();
$a->populateWithUser($u->getIdUser());
$hasAdress = ($a->getIdAdress() !== NULL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../styesheets/hub/main.css">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Profil</title>
</head>

<body>
	<?php
	require_once '../utilities/header.php';
	?>
	<div class="profil">
		<div class="profil-container">
			<div class="title-section">
				<h2 class="subtitle">paramètres généraux</h2>
				<p>Gérez les informations de compte que vous avez partagées avec POTATO STORE, dont votre contact et plus</p>
			</div>
			<div class="title-section">
				<h2 class="subtitle">infos de compte</h2>
				<p>
					<span class="bold">ID: </span>
					<?php
					echo $u->getIdUser();
					?>
				</p>
				<form action="../../controleurs/_modify_info.php" method="post" enctype="multipart/form-data" class="informations">
					<div class="input-section">
						<p>
							<?php
							echo getErrorFromSession("error_validate_pseudo");
							?>
						</p>
						<div class="area">
							<label class="account-lbl" for="pseudo">PSEUDO</label>
							<input type="text" class="input-txt" name="pseudo" placeholder="Votre pseudo"
								value="<?php echo "{$u->getPseudo()}" ?>">
						</div>
						<p>
							<?php
							echo getErrorFromSession("error_validate_email");
							?>
						</p>
						<div class="area">
							<label class="account-lbl" for="email"> EMAIL</label>
							<input type="text" class="input-txt" name="email" placeholder="Votre email"
								value="<?php echo "{$u->getEmail()}" ?>">
						</div>
						<div class="title-section">
							<h2 class="subtitle">Informations personnelles</h2>
							<p>Gérer votre nom et vos coordonnées. Ces informations personnelles sont privées et ne seront pas visibles par
								les autres utilisateurs.</p>
						</div>
						<div class="area">
							<label class="account-lbl" for="foreName">prenom * </label>
							<input type="text" class="input-txt" name="foreName" placeholder="Votre prénom"
								value="<?php echo "{$u->getForeName()}" ?>">
						</div>
						<div class="area">
							<label class="account-lbl" for="familyName">nom * </label>
							<input type="text" class="input-txt" name="familyName" placeholder="Votre nom"
								value="<?php echo "{$u->getFamilyName()}" ?>">
						</div>
						<div class="area">
							<label for="stock-lbl">Entrer une image de Profil:</label>
							<input type="file" class="img-input" name="image" accept=".jpg,.jpeg" src="" alt="">
						</div>
						<div class="title-section">
							<h2 class="subtitle">adresse</h2>
						</div>
						<div>
							<p class="error">
								<?php
								$str = getErrorFromSession("error_validate_adress");
								if($str !== NULL){
									echo $str."</br>";
								}elseif(!$hasAdress){
									echo "Attention: Vous n'avez pas d'adresse définie.";
								}
								?>
							</p>
						</div>
						<div class="area">
							<input type="text" class="input-txt" name="adress" placeholder="ADRESSE"
								value="<?php echo "{$a->getAdress()}" ?>">
						</div>
						<div class="area">
							<input type="text" class="input-txt" name="CP" placeholder="CODE POSTAL" value="<?php echo "{$a->getCP()}" ?>">
						</div>
						<div class="area">
							<input type="text" class="input-txt" name="city" placeholder="ville" value="<?php echo "{$a->getCity()}" ?>">
						</div>
						<div class="buttons">
							<input type="submit" class="btn-sub green" name="submit" value="Sauvegarder les changements">
							<input type="reset" class="btn-sub pink" name="cancel-input" value="Annuler les changements">
						</div>
					</div>
				</form>

				<form action="../../controleurs/_change_password.php" method="post" class="informations">
					<div class="input-section">
						<div class="title-section">
							<h2 class="subtitle">Change Password</h2>
						</div>
						<p class="error">
							<?php
							echo getErrorFromSession("error_verif_password");
							?>
						</p>
						<div class="area">
							<label class="account-lbl" for="currentPassword">Password</label>
							<input type="password" class="input-txt" name="currentPassword" placeholder="password*" required>
						</div>
						<p class="error">
							<?php
							echo getErrorFromSession("error_validate_password");
							?>
						</p>
						<div class="area">
							<label class="account-lbl" for="password">New Password</label>
							<input type="password" class="input-txt" name="password" placeholder="New password*" required>
						</div>
						<div class="area">
							<label class="account-lbl" for="passwordConfirm">Confirm New Password</label>
							<input type="password" class="input-txt" name="passwordConfirm" placeholder="Confirm New password*" required>
						</div>

						<div class="buttons">
							<input type="submit" class="btn-sub green" name="submit" value="Changer le mot de Passe">
							<input type="reset" class="btn-sub pink" name="cancel-input" value="Annuler">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="../js/funtions.js"></script>
</body>

</html>