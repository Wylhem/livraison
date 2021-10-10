<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../styesheets/landing/main.css">
<script src="https://kit.fontawesome.com/8342f5a505.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet">
<link rel="icon" href="../images/Icon_Potato.png">
<title>Projet</title>
</head>

<body>
	<div class="landing">
		<div class="circle"></div>
		<header>
			<a href="#" class="logo">
				<img src="../images/Icon_Potato.png" alt="">
			</a>
			<div id="toggle" onclick="toggleMenu();"></div>
			<ul id="navigation">
				<li>
					<a href="#">Home</a>
				</li>
				<li>
					<a href="../acceuil/marchandise.php">marchandises</a>
				</li>
			</ul>
		</header>
		<div class="content">
			<div class="textBox">
				<h1>
					Mangez bien avec
					<span>Potato Store</span>
				</h1>
				<h2>En aidant les producteurs locaux</h2>
				<div class="buttons">
					<a href="../forms/inscription.php">
						<button class="inscription">Inscription</button>
					</a>
					<a href="../forms/connexion.php">
						<button class="connexion">Connexion</button>
					</a>
				</div>
			</div>
			<div class="imgBox">
				<img src="../images/farm.svg" class="farm" alt="">
			</div>
		</div>
	</div>

	<script src="../js/funtions.js" type="text/javascript"></script>
</body>


<noscript>Activez javascript</noscript>

</html>