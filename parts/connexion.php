<div>
	<div id="connexion" class="FormSession">
		<?php
		if (isset($_SESSION['login'])) {
			echo "<h1>Vous ne pouvez pas acceder a cette page.</h1>";
			exit();
		}
		if (isset($_GET["ok"])) {
			if ($_GET["ok"] == 0) {
				echo "c'est pas cool ...";
			}
			else if ($_GET["ok"] == 1) {
				echo "Votre inscription à été prise en compte.";
			}
		}
		if (isset($_GET['e'])) {
			if ($_GET['e'] == 1) {
				echo "email invalide";
			} else if ($_GET['e'] == 2) {
				echo "veuillez saisir une adresse email.";
			} else if ($_GET['e'] == 3) {
				echo "veuillez saisir un mot de passe.";
			}
		}
		?>
		<form method="post" action="ressources/fonctions.php">
			<h1>Se Connecter</h1>
			<label for="mailConnexion">Adresse e-mail</label><br />
			<input type="email" name="mailConnexion" id="mailConnexion" placeholder="exemple@exemple.fr" required /><br />
			<label for="mdpConnexion">Mot de passe</label><br />
			<input type="password" name="mdpConnexion" id="mdpConnexion" required /><br />
			<button type="submit">Se Connecter</button>
		</form>
	</div>
	<div id="inscription">
		<fieldset>
			<p>Vous n'avez pas encore de compte ? </p>
			<a href="index.php?page=inscription">Créer un compte</a>
		</fieldset>
	</div>
</div>
