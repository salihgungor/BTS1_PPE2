<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css"/>
		<script src="inscription.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
		<title>Inscription</title>
	</head>
	<body>
		<?php
		if (isset($_GET["ok"])) {
			if ($_GET["ok"] == 1) {
				echo "c'est pas cool !!";
			}
		}
		if (isset($_GET['e'])) {
			if ($_GET['e'] == 1) {
				echo "email invalide";
			} else if ($_GET['e'] == 2) {
				echo "veuillez saisir une adresse email.";
			} else if ($_GET['e'] == 3) {
				echo "veuillez saisir un mot de passe.";
			} else if ($_GET['e'] == 4) {
				echo "les deux mot de passe ne sont pas identique ...";
			} else if ($_GET['e'] == 5) {
				echo "cp non valide ..";
			} else if ($_GET['e'] == 6) {
				echo "date de naissance non valide ..";
			} else if ($_GET['e'] == 7) {
				echo "numero invalide ..";
			}
		}
		?>
		<div id="inscription" class="FormSession">
			<form method="post" action="ressources/fonctions.php" id="validInscription">

				<h1>Inscription</h1>

				<label for="mailInscription">Adresse e-mail</label><input type="text" name="mailInscription" id="email" placeholder="exemple@exemple.fr"/><br/>

				<label for="nom">Nom</label><input type="text" name="nom" id="passe"/><br/>
				
				<label for="prenom">Prénom</label><input type="text" name="prenom" id="passe"/><br/>
				
				<label for="mdpInscription">Mot de passe</label><input type="password" name="mdpInscription" id="passe"/><br/>

				<label for="verifMdpInscription">Confirmation</label><input type="password" name="verifMdpInscription" id="passe2"/><br/>

				<label for="dateNaiss">Date de naissance</label><input type="date" name="dateNaiss" id="dateNaiss"/><br/>

				<label for="adresse">Adresse postale</label><input type="textarea" name="adresse" id="adresse" rows="4" cols="50"><br/>

				<label for="cp">Code postal</label><input type="text" name="cp" id="cp" size="5"><br/>

				<label for="telephone">Téléphone</label><input type="text" name="telephone" id="telephone" size="15" placeholder="Ex : 0600000000"/><br/>

				<label for="ville">Ville</label><br/><input type="text" name="ville" id="ville"/><br/>

				<button type="submit">S'inscrire</button>

			</form>
		</div>

	</body>
</html>
