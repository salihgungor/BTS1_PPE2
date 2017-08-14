<header>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navBar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Hopital du bien être</a>
			</div>
			<div class="collapse navbar-collapse" id="navBar">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Accueil</a></li>
					<li><a href="index.php?page=medecine">Médecine</a></li>
					<li><a href="index.php?page=pediatrie">Pédiatrie</a></li>
					<li><a href="index.php?page=chirurgie">Chirurgie</a></li>
					<li><a href="index.php?page=urgences">Urgences</a></li>
					<?php
					if (isset($_SESSION['login'])) {
						echo "<li><a href=\"index.php?page=rdv\">Rendez-vous</a></li>";
						if($_SESSION["typeUtilisateur"] == 2){
						echo "<li><a href=\"index.php?page=enquete\">Enquete de Satisfaction</a></li>";
						}
						echo "</ul>";
						echo "<ul class=\"nav navbar-nav navbar-right\">";
						echo "<li><a href=\"index.php?page=deconnexion\">Déconnexion</a></li>";
						echo "</ul>";
					} else {
						echo "</ul>";
						echo "<ul class=\"nav navbar-nav navbar-right\">";
						echo "<li><a href=\"index.php?page=connexion\">Connexion</a></li>";
						echo "<li><a href=\"index.php?page=inscription\">Inscription</a></li>";
						echo "</ul>";
					}
					?>
			</div>
		</div>
	</nav>
</header>