<div id="enquete">
	<script type="text/javascript" src="ressources/pdfmake.min.js"></script>
	<script type="text/javascript" src="ressources/vfs_fonts.js"></script>
	<script type="text/javascript" src="ressources/satisfaction_info.js"></script>
	<?php

	function interdit() {
		?>
		<h1>Vous ne pouvez pas acceder a cette page.</h1>
		<?php
	}

	if (isset($_SESSION['login'])) {
		if ($_SESSION['typeUtilisateur'] == 2) {
			?>
			<div class="blocks">
				<form id="formEnqueteSatisfaction">
					<div id="quest">
						<h1>Enquete de Satisfaction</h1>
						Séjour dans le service :
						<select name="service" id="service">
							<option value="selectionner">Selectionner</option>
							<option value="Médecine">Médecine</option>
							<option value="Pédiatrie">Pédiatrie</option>
							<option value="Chirurgie">Chirurgie</option>
							<option value="Urgences">Urgences</option>
						</select><br/>
						<table>
							<tr>
								<th><strong>Accueil:</strong></th>
								<th>Tbien</th>
								<th>Bien</th>
								<th>Moyen</th>
								<th>Mauvais</th>
								<th>Aucun Avis</th>
							</tr>
							<tr>
								<td>Accueil du service administratif</td>
								<td><input type="radio" name="servadmin" value="très bien" /></td>
								<td><input type="radio" name="servadmin" value="bien" /></td>
								<td><input type="radio" name="servadmin" value="moyen" /></td>
								<td><input type="radio" name="servadmin" value="mauvais" /></td>
								<td><input type="radio" name="servadmin" value="pas d'avis" checked="true" /></td>
							</tr>
							<tr>
								<td>Accueil dans l'unité de soin:</td>
								<td><input type="radio" name="unitsoin" value="très bien" /></td>
								<td><input type="radio" name="unitsoin" value="bien" /></td>
								<td><input type="radio" name="unitsoin" value="moyen" /></td>
								<td><input type="radio" name="unitsoin" value="mauvais" /></td>
								<td><input type="radio" name="unitsoin" value="pas d'avis" checked="true" /></td>
							</tr>
							<tr>
								<th><strong>Qualite de:</strong></th>
								<th>Tbien</th>
								<th>Bien</th>
								<th>Moyen</th>
								<th>Mauvais</th>
								<th>Aucun Avis</th>
							</tr>
							<tr>
								<td>Prise en charge de la douleur:</td>
								<td><input type="radio" name="douleur" value="très bien" /></td>
								<td><input type="radio" name="douleur" value="bien" /></td>
								<td><input type="radio" name="douleur" value="moyen" /></td>
								<td><input type="radio" name="douleur" value="mauvais" /></td>
								<td><input type="radio" name="douleur" value="pas d'avis" checked="true" /></td>
							</tr>
							<tr>
								<td>Soins(infirmiers/aides soignant(e)s):</td>
								<td><input type="radio" name="soins" value="très bien" /></td>
								<td><input type="radio" name="soins" value="bien" /></td>
								<td><input type="radio" name="soins" value="moyen" /></td>
								<td><input type="radio" name="soins" value="mauvais" /></td>
								<td><input type="radio" name="soins" value="pas d'avis" checked="true" /></td>
							</tr>
							<tr>
								<th><strong>Prise en charge de la douleur</strong></th>
								<th>Tbien</th>
								<th>Bien</th>
								<th>Moyen</th>
								<th>Mauvais</th>
								<th>Aucun Avis</th>
							</tr>
							<tr>
								<td>A-t-on été à votre écoute ? :</td>
								<td><input type="radio" name="ecoute" value="tres bien" /></td>
								<td><input type="radio" name="ecoute" value="bien" /></td>
								<td><input type="radio" name="ecoute" value="moyen" /></td>
								<td><input type="radio" name="ecoute" value="mauvais" /></td>
								<td><input type="radio" name="ecoute" value="pas d'avis" checked="true" /></td>
							</tr>
							<tr>
								<td>Le soulagement de la douleur a été ?:</td>
								<td><input type="radio" name="soulagement" value="très bien" /></td>
								<td><input type="radio" name="soulagement" value="bien" /></td>
								<td><input type="radio" name="soulagement" value="moyen" /></td>
								<td><input type="radio" name="soulagement" value="mauvais" /></td>
								<td><input type="radio" name="soulagement" value="pas d'avis" checked="true" /></td>
							</tr>
						</table> 
					</div>
					<div>
						<input type="button" value="valider" onclick="donnees()" />
						<input type="reset" value="annuler" />
					</div>
				</form>
			</div>
			<?php
		} else {
			interdit();
		}
	} else {
		interdit();
	}
	?>
</div>