<?php
namespace Projet;

require_once '../../modeles/Bd.php';
initSession();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<link rel="stylesheet" href="../styesheets/formulaire/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../images/Icon_Potato.png">
<title>SignUp</title>
</head>

<body>
	<div class="header">
		<img class="logo" src="../images/Icon_Potato.png" alt="">
		<a class="icon" href="../landing/landing.php">
			<i class="fas fa-times"></i>
		</a>
	</div>
	<div class="forms">
		<form action="../../controleurs/_inscription.php" method="post">
			<h2>SignUp</h2>
			<p>
				Vous avez déjà un compte ?
				<span>
					<a href="./connexion.php">Se connecter</a>
				</span>
			</p>
			<p class="error">
				<?php
				echo getErrorFromSession("error_validate_email");
				?>
			</p>
			<div class="inputs ">
				<input class="txt-input" type="text" name="email" placeholder="email*" required>
			</div>
			<p class="error">
				<?php
				echo getErrorFromSession("error_validate_pseudo");
				?>
			</p>
			<div class="inputs ">
				<input class="txt-input" type="text" name="pseudo" placeholder="pseudo" required>
			</div>
			<p class="error">
				<?php
				echo getErrorFromSession("error_validate_password");
				?>
			</p>
			<div class="inputs ">
				<input class="txt-input" type="password" name="password" placeholder="password*" required>
			</div>
			<div class="inputs ">
				<input class="txt-input" type="password" name="passwordConfirm" placeholder="Confirm password*" required>
			</div>

			<div class="inputs">
				<input class="btn-input" type="checkbox" name="isProducteur">
				<label for="prod"> Créer un compte producteur</label>
			</div>
			<div class="inputs">
				<input class="btn-input" type="submit" name="send" value="S'enregistrer" required>
			</div>
			<p id="required">* :is required</p>
		</form>
	</div>
</body>

</html>