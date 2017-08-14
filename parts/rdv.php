<div id="rdv">
	<script type="text/javascript" src="ressources/rdv.js"></script>
	<script type="text/javascript" src="ressources/pdfmake.min.js"></script>
	<script type="text/javascript" src="ressources/vfs_fonts.js"></script>
	<script type="text/javascript" src="ressources/anytime.5.2.0.js"></script>
	<link rel="stylesheet" href="ressources/anytime.5.2.0.css" />
	<?php
	if (isset($_SESSION['typeUtilisateur'])) {
		$typeUtilisateur = $_SESSION['typeUtilisateur'];
		if ($typeUtilisateur == 1) {
			//medecin
			?>
			<div class="blocks">
				<h1>Voici la liste de vos rendez-vous: </h1>
				<table>
					<tr>
						<th>Nom du patient</th><th>Prénom du patient</th><th>Date du rendez-vous</th><th>Heure du rendez-vous</th>
					</tr>
					<?php
					$tableauRdvMed = getListeRdvMed($_SESSION['login']);
					foreach ($tableauRdvMed as $rdv) {
						echo "<tr>";
						echo "<td>" . $rdv['nom'] . "</td><td>" . $rdv['prenom'] . "</td><td>" . $rdv['date'] . "</td><td>" . $rdv['heure'] . "</td>";
						echo "</tr>";
					}
					?>
				</table>
			</div>
			<div class="blocks">
				<h1>Ajouter un horaire de rendez-vous.</h1>
				<form method="POST" action="ressources/fonctions.php">
					<input type="hidden" name="ajouterPossibiliteRdv" />
					<input type="text" id="DateTime" name="date"/>
					<script>
						$("#DateTime").AnyTime_picker({
							format: "%Y-%m-%d %H:%i:%s",
							formatUtcOffset: "%: (%@)",
							hideInput: true,
							placement: "inline"});
					</script>
					<br />
					<input type="submit" value="Ajouter rendez-vous"/>
				</form>
			</div>
			<?php
		} elseif ($typeUtilisateur == 2) {
			//patient
			?>
			<div class="blocks">
					<h1>Demande de rendez-vous : </h1>
					<div id="services"><label for="listeServices">Selectionnez le service:</label><br />
					<select id="listeServices" name="listeServices" onchange="renseignerMedecins()">
						<option value="0" name="selectServ">Selectionnez un service</option>
						<?php
						$listeServices = getListeServices();
						foreach ($listeServices as $service) {
								echo "<option value=\"" . $service['code'] . "\" name=\"" . $service['libelle'] . "\">" . $service['libelle'] . "</option>";
						}
						?>
					</select></div>
					<div id="medecins"></div>
					<div id="rendezVous"></div>

			</div>
			<?php
		} elseif ($typeUtilisateur == 3) {
			//secretaire
		}
	} else {
		?>
		<h1>Vous ne pouvez pas acceder a cette page.</h1>
		<?php
		exit();
	}
	?>
</div>
