<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Alexandre PICAVET</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<link rel="stylesheet" href="ressources/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="ressources/style.css" />
		<script src="ressources/jquery.min.js"></script>
		<script src="ressources/bootstrap/js/bootstrap.min.js"></script>
		<script src="ressources/functions.js"></script>
	</head>
	<body>
		<div class="container">
			<?php
			session_start();
			include_once 'ressources/fonctions.php';
			include 'parts/header.php';
			if (isset($_GET['page'])) {
				switch ($_GET['page']) {
					case "medecine": include 'parts/medecine.php';
						break;
					case "pediatrie": include 'parts/pediatrie.php';
						break;
					case "chirurgie": include 'parts/chirurgie.php';
						break;
					case "urgences": include 'parts/urgences.php';
						break;
					case "contacts": include 'parts/contacts.php';
						break;
					case "formalites": include 'parts/formalites.php';
						break;
					case "rdv": include 'parts/rdv.php';
						break;
					case "connexion": include 'parts/connexion.php';
						break;
					case "inscription": include 'parts/inscription.php';
						break;
					case "deconnexion": deconnexion();
						include 'accueil';
						break;
				}
			} else {
				include 'parts/accueil.php';
			}
			include 'parts/footer.php';
			?>
		</div>
	</body>
</html>
