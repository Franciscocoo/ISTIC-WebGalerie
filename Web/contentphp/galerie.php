<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content = "text/html;charset =iso-8859-1"  />
		<link rel="stylesheet" href="../style/test.css" />
		<link rel="icon" href="../favicon.ico" />
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<title>Galerie</title>
	</head>
	<body>
		<header>
	  <nav>
			<a href="../accueil.php">Galerie Web</a>
			<a href="galerie.php"> Oeuvres </a>
			<a href="artistes.php"> Artistes </a>
			<a href="ajouter.php">Ajouter Oeuvre</a>
			<?php
				session_start();
				if(isset($_SESSION['user']) && isset($_SESSION['pwd'])) {
					echo  ("<a class='active' href='../account/deconnexion.php'> Deconnexion </a>");
					echo ("<a class='active' href='../account/moncompte.php'> Mon Compte </a>");
					echo  ("<a class='active' href='mesoeuvres.php'> Mes oeuvres </a>");
				} else {
					echo ("<a class='active' href='../account/seconnecter.php'> Connexion </a>");
					echo ("<a class='active' href='../account/inscription.php'> Inscription </a>");
				}
			 ?>
	  </nav>
	  </header>
	</br>
		<div class="main">
				</br>
				<div class="searchbar">
					<form action="searchoeuvre.php" method="post" align="center">
						<input type="text" name="text"/>
						<input type="submit" value="Chercher"/>
					</form>
				</div>
			</br>
				<div class="grid">
					<?php
						require('../BDDConnect.php');
						$co = getConnection();
						$query ="SELECT `Nom`,`Path` FROM `oeuvre` ORDER BY `Nom` asc";
						$result = $co->query($query);
						while($donnée = $result->fetch()){
							echo("<div class='case'>");
							echo("<img src=../imgs/$donnée[Path] width='150' height='150' class='miniature'>");
							echo("</br>");
							echo("<a href='oeuvre.php?titre=$donnée[Nom]'> $donnée[Nom] </a>");
							echo("</div>");
						}
		 			?>
	 		</div>
	 </br>
	 </div>
  </body>
</html>
