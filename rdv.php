<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style_rdv.css">
	<title>Médecine de l'hopital du bien être</title>
	<script src="ressources/js/pdfmake.min.js"></script>
	<script src="ressources/js/vfs_fonts.js"></script>
	<script src="ressources/js/rdv_info.js"></script>
</head>
<body id="Haut">
	<div id="CentrePage">
		<div id="DivNav">
			<ul id="MenuNav">
				<a href="index.html"><li class="MNG">Accueil</li></a>
				<a href="medecine.html"><li class="MNG">Médecine</li></a>
				<a href="pediatrie.html"><li class="MNG">Pédiatrie</li></a>
				<a href="chirurgie.html"><li class="MNG">Chirurgie</li></a>
				<a href="urgences.html"><li class="MNG">Urgences</li></a>
				<a href="formalites.html"><li class="MND">Formalités</li></a>
				<a href="contact.html"><li class="MND">Contacts</li></a>
			</ul>
		</div>
		<br />
		<center><img src="ressources/index_03.gif" width="933" height="95" alt="bannière" /></center>
		<br />
		<div id="fs">
			<div id="dmdrdv">
				<form method="post" action="Fonctions.php" id="validInfo">
					<fieldset>
						<legend>Demande de rendez-vous</legend>
						<div id="infos">
							<div id="gauche">
								<fieldset>
									<legend>Nouveau Patient :</legend>
									<p>Nom : <input type="text" name="nom" id="nom"></p>
									<p>Prénom : <input type="text" name="prenom" id="prenom"></p>
									<p>Adresse mail : <input type="email" name="emailNP" id="mail"></p>
									<p>Numéro de téléphone : <input type="tel" name="tel" id="tel"></p>
									<p>Date de naissance : <input type="date" name="dateN" id="dateN"></p>
									<p>Adresse du domicile : <input type="text" name="adresse" id="adresse"></p>
									<p>Code postal : <input type="text" name="codepostal" id="codepostal"></p>
									<p>Ville : <input type="text" name="ville" id="ville"></p>
								</fieldset>
							</div>
							<div id="droite">
								<fieldset>
									<legend>Patient Existant :</legend>
									<p>Adresse mail : <input type="email" name="email" id="mail"></p>
								</fieldset>
								<fieldset>
									<legend>informations RDV :</legend>
									<p>
										Service : <select name="service" size="1" id="service">
											<option value="selectionner">Selectionner</option>
											<option value="Médecine">Médecine</option>
											<option value="Pédiatrie">Pédiatrie</option>
											<option value="Chirurgie">Chirurgie</option>
											<option value="Urgences">Urgences</option>
										</select>
									</p>
									<p>Docteur : <select name="docteur" size="1" id="docteur">
										<option value="selectionner">Selectionner</option>
										<option value="Bacle">Dr.Bacle</option>
										<option value="Picavet">Dr.Picavet</option>
										<option value="Gungor">Dr.Gungor</option>
										<option value="Rousseau">Dr.Rousseau</option>
									</select></p>
									<p>Date du rendez-vous : <input type="date" name="daterdv" id="daterdv" /></p>
									<p>Horaires disponibles : <select name="heurerdv" size="1" id="heurerdv">
										<option value="selectionner">Selectionner</option>
										<option value="8:00">8h00</option>
										<option value="9:00">9h00</option>
										<option value="10:00">10h00</option>
									</select>
									</p>
								</fieldset>
							</div>
						</div>
						<div id="formbuttons">
							<input type="submit" value="Valider"  />
							<input type="reset" value="Annuler" />		
						</div>
						<?php
							if(isset($_GET['r'])){
								if($_GET['r'] == 0){
									echo '<p>Votre rendez-vous a bien été pris en compte.</p>';
								}
								else
								{
									echo '<p>Une erreur c\'est produite.</p>';
								}
							}
						?>
					</fieldset>
				</form>
			</div>
			<div id="listeRDV">
				<fieldset>
					<legend>Liste des rendez-vous</legend>
					<div id="mailListeRDV">
						<form method="post" action="">
						<p>Veuillez entrer votre adresse email : <input type="text" name="mail" id="inputMailListeRDV" /><input type="submit" value="Valider" /></p>
						</form>
						<?php
							include_once 'Fonctions.php';
							listeRdv();
						?>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</body>
</html>
