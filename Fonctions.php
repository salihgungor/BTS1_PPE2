<?php
	if(isset($_POST['emailNP']) && $_POST['emailNP'] != ""){
		creationRdvNouveauPatient();
	}
	else if(isset($_POST['email']) && $_POST['email'] != ""){
		creationRdv();
	}

	function connexion(){
		try{
			$bdd = new PDO('mysql:host=localhost; dbname=hopital; charset=utf8', 'root');
		} catch (Exception $ex) {
			$bdd = $ex->getMessage();
		}
		return $bdd;
	}
	
	function deconnexion($bdd){
		$bdd = null;
	}
	
	function creationRdvNouveauPatient(){
		$bdd = connexion();
		if(gettype($bdd) == "string"){
			echo "erreur : ".$bdd; 
		}
		else{
			//on recupere les variables recupérées dans verif info et on les stocke dans un tableau
			$tableau = verifInfoNouveauPatient();
			if(gettype($tableau) == "string"){
				echo $tableau;
			}
			else if(gettype($tableau) == "boolean"){
				echo "Veuillez remplir tout les champs demandés.";
			}
			else if(gettype($tableau) == "array"){
				//si les champs ont bien étés renseignés
				if($tableau['saisie'] === true){
					//on verifie si le patient existe sinon on le rajoute
					$requete = $bdd->prepare('SELECT * FROM patient WHERE id=?');
					$requete->execute(array($tableau['id']));
					//si il n'existe pas alors on le crée
					if($requete->rowCount() == 0){
						$patientAjoute = ajoutePatient($bdd, $tableau['id'], $tableau['nom'], $tableau['prenom'], $tableau['tel'], $tableau['dateN'], $tableau['adresse'], $tableau['codePostal'], $tableau['ville']);
						if($patientAjoute == false){
							echo "une erreur est survenue.";
							exit();
						}
						//on crée le rendez-vous
						$idMedecin = MedecinVersId($bdd, $tableau['medecin']);
						settype($idMedecin, "int");
						$rdvCree = ajoutRdv($bdd, $tableau['id'], $idMedecin, $tableau['dateRdv'], $tableau['heureRdv']);
						if($rdvCree == false){
							echo "erreur lors de la création du rdv";
							redirection(false);
						}
						else{
							redirection(true);
						}
					}
					else{
						echo "l'adresse mail que vous avez saisi appartient à un patient déja enregistré.";
					}
				}	
				else
				{
					echo "erreur les champs ont été mal remplis.";
					exit();
				}
			}
		}
	}
	
	function verifInfoNouveauPatient(){
		$ok = false;
		if(isset($_POST['emailNP'], $_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['dateN'], $_POST['adresse'], $_POST['codepostal'], $_POST['ville'], $_POST['daterdv'])){
			//verification adresse email
			if(filter_var($_POST['emailNP'], FILTER_VALIDATE_EMAIL)){
				$id = strtolower($_POST['emailNP']);
			}
			else{
				return "Adresse email invalide....";
			}
			
			//verification numero telephone
			if(preg_match('`[0-9]{10}`',$_POST['tel'])){
				$tel = $_POST['tel'];
			}
			else{
				return "Numéro invalide.";
			}
			
			//verification date de naissance
			$dateN = $_POST['dateN'];
			$dN = substr($dateN, 0,2);
			$mN = substr($dateN, 3,2);
			$yN = substr($dateN, 6,4);
			if(checkdate($mN, $dN, $yN)){
				$dateN = $yN."-".$mN."-".$dN;
			}
			else
			{
				return "Date de naissance invalide.";
			}
			
			//verification service
			if($service = $_POST['service']){
				if($service == "Selectionner"){
					return "Veuillez selectionner un service";
				}
			}
			
			//verification docteur
			if($docteur = $_POST['docteur']){
				if($docteur == "Selectionner"){
					return "Veuillez selectionner un service";
				}
			}
			
			//verification date du rendez-vous
			$dateRdv = $_POST['daterdv'];
			$dRdv = substr($dateRdv, 0,2);
			$mRdv = substr($dateRdv, 3,2);
			$yRdv = substr($dateRdv, 6,4);
			if(checkdate($mRdv, $dRdv, $yRdv)){
				$dateRdv =  $yRdv."-".$mRdv."-".$dRdv;
			}
			else
			{
				return "Date du rendez-vous invalide.";
			}
			
			//verification horaire rendez-vous
			if($heureRdv = $_POST['heurerdv']){
				if($heureRdv == "Selectionner"){
					return "Veuillez selectionner un service";
				}
			}
			
		}
		else
		{
			return false;
		}
		
		//retour des variables

		$retour = [
		"id" => $id,
		"nom" => $_POST['nom'],
		"prenom" => $_POST['prenom'],
		"tel" => $tel,
		"dateN" => $dateN,
		"adresse" => $_POST['adresse'],
		"codePostal" => $_POST['codepostal'],
		"ville" => $_POST['ville'],
		"service" => $service,
		"medecin" => $docteur,
		"dateRdv" => $dateRdv,
		"heureRdv" => $heureRdv,
		"saisie" => true,
		];
		return $retour;
	}
	
	function creationRdv(){
		$bdd = connexion();
		if(gettype($bdd) == "string"){
			echo "erreur : ".$bdd; 
		}
		else{
			//on recupere les variables recupérées dans verif info et on les stocke dans un tableau
			$tableau = verifInfo();
			if(gettype($tableau) == "string"){
				echo $tableau;
			}
			else if(gettype($tableau) == "boolean"){
				echo "Veuillez remplir tout les champs demandés.";
			}
			else if(gettype($tableau) == "array"){
				//si les champs ont bien étés renseignés
				if($tableau['saisie'] === true){
					//on verifie si le patient existe sinon on le rajoute
					$requete = $bdd->prepare('SELECT * FROM patient WHERE id=?');
					$requete->execute(array($tableau['id']));
					//si il n'existe pas alors on le dit
					if($requete->rowCount() == 0){
						echo "L'adresse email que vous avez selectionné ne correspond à aucun patient.";
					}
					else{
						//on crée le rendez-vous
						$idMedecin = MedecinVersId($bdd, $tableau['medecin']);
						settype($idMedecin, "int");
						$rdvCree = ajoutRdv($bdd, $tableau['id'], $idMedecin, $tableau['dateRdv'], $tableau['heureRdv']);
						if($rdvCree == false){
							echo "erreur lors de la création du rdv";
							redirection(false);
						}
						else{
							redirection(true);
						}
					}
				}	
				else
				{
					echo "erreur les champs ont été mal remplis.";
					exit();
				}
			}
		}
	}
	
	function verifInfo(){
		$ok = false;
		if(isset($_POST['email'], $_POST['daterdv'])){
			//verification adresse email
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$id = strtolower($_POST['email']);
			}
			else{
				return "Adresse email invalide 1.";
			}

			//verification service
			if($service = $_POST['service']){
				if($service == "Selectionner"){
					return "Veuillez selectionner un service";
				}
			}
			
			//verification docteur
			if($docteur = $_POST['docteur']){
				if($docteur == "Selectionner"){
					return "Veuillez selectionner un service";
				}
			}
			
			//verification date du rendez-vous
			$dateRdv = $_POST['daterdv'];
			$dRdv = substr($dateRdv, 0,2);
			$mRdv = substr($dateRdv, 3,2);
			$yRdv = substr($dateRdv, 6,4);
			if(checkdate($mRdv, $dRdv, $yRdv)){
				$dateRdv =  $yRdv."-".$mRdv."-".$dRdv;
			}
			else
			{
				return "Date du rendez-vous invalide.";
			}
			
			//verification horaire rendez-vous
			if($heureRdv = $_POST['heurerdv']){
				if($heureRdv == "Selectionner"){
					return "Veuillez selectionner un service";
				}
			}
			
		}
		else
		{
			return false;
		}
		
		//retour des variables

		$retour = [
		"id" => $id,
		"service" => $service,
		"medecin" => $docteur,
		"dateRdv" => $dateRdv,
		"heureRdv" => $heureRdv,
		"saisie" => true,
		];
		return $retour;
	}
	
	//ajouter un patient
	function ajoutePatient($bdd, $id, $nom, $prenom, $tel, $dateN, $adresse, $codePostal, $ville){
		$requete = $bdd->prepare('INSERT INTO patient VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
		$ok = $requete->execute(array(
			$id,
			$nom,
			$prenom,
			$tel,
			$dateN,
			$adresse,
			$codePostal,
			$ville
		));
		return $ok;
	}
	
	//trouver l'id du medecin avec son nom
	function MedecinVersId($bdd, $medecin){
		$requete = $bdd->prepare('SELECT id FROM medecin WHERE nom=?');
		$requete->execute(array($medecin));
		while($donnee = $requete->fetch()){
			$idMedecin = $donnee['id'];
		}
		return $idMedecin;
	}
	
	//ajouter un rendez-vous
	function ajoutRdv($bdd, $id, $idMedecin,$date, $heure){
		$requete = $bdd->prepare('INSERT INTO rdv(patient, medecin, date, heure) VALUES(?, ?, ?, ?)');
		$ok = $requete->execute(array(
			$id,
			$idMedecin,
			$date,
			$heure
		));
		return $ok;
	}
	
	function redirection($ok){
		echo "redirection";
		if($ok == true){
			header('Location: rdv.php?r=0');
			exit();
		}
		else{
			header('Location: rdv.php?r=1');
			exit();
		}
	}
	
	function listeRdv(){
		if(isset($_POST['mail'])){
			$mail = strtolower($_POST['mail']);
			if($mail != ''){
				try{
					$bdd = connexion();
					$reponse = $bdd->prepare('SELECT patient.nom as patient, medecin.nom as medecin, service.nom as service, date, heure FROM patient JOIN rdv ON patient.id = rdv.patient JOIN medecin ON rdv.medecin = medecin.id JOIN service ON medecin.idservice = service.id WHERE patient.id=? ORDER BY date, heure');
					$reponse->execute(array($_POST['mail']));
					if($reponse->rowCount() == 0)
					{
						echo '<p>Aucun rendez-vous trouvés pour cette adresse mail.</p>';
					}
					else
					{
						echo '<table id="tabRDV">';
						echo '<tr><th>Patient :</th><th>Docteur :</th><th>Service :</th><th>Date :</th><th>Heure :</th></tr>';
						while($donnee = $reponse->fetch()){
							$patient = 'M/Mr.'.$donnee['patient'];
							$medecin = 'Dr.'.$donnee['medecin'];
							$service = $donnee['service'];
							$date = $donnee['date'];
							$heure = $donnee['heure'];
							echo '<tr>';
							echo '<td>'.$patient.'</td>';
							echo '<td>'.$medecin.'</td>';
							echo '<td>'.$service.'</td>';
							echo '<td>'.$date.'</td>';
							echo '<td>'.$heure.'</td>';
							echo '</tr>';
						}
						echo '</table>';
					}
				} catch (Exception $ex) {
					echo '<p>Une erreur c\'est produite, veuillez réessayer.</p>';
				}
			}
			else
			{
				echo '<p>Veuillez entrer une adresse mail.</p>';
			}
		}
	}
	
	function connexionBDD(){
    try{
        $UnObjPDO=new PDO('mysql:host=localhost;dbname=bddgs','root','');
    }
    catch(PDOException $e){
        echo 'Connexion echoué : '.$e->getMessage();
    }
    
    return $UnObjPDO;
}


	function getInfo($heure,$medecin){
    $bdd = connexionBDD();
    $requete = $bdd->prepare("SELECT rdv.patient,rdv.medecin,rdv.date,rdv.heure,medecin.nom FROM rdv JOIN  medecin ON medecin.id=rdv.medecin WHERE heure = ? AND medecin.nom = ?");
    $ok = $requete->execute(array($heure, $medecin));
    
    if($ok){
    $info = $requete->fetchAll();
    }
    else
    {
        throw new Exception("Erreur dans la requete ... ");
    }
    
    $requete->closeCursor();
    return $info;
    
   }

	function getMedecin(){
    
    $maConnexionPDO= connexionBDD();
    
    $maRequete = $maConnexionPDO->prepare("SELECT medecin.nom FROM medecin");
    
    $executionOK=$maRequete->execute();
    
    if($executionOK){
        $lesMedecins=$maRequete->fetchAll();
    }
    else
    {
        throw new Exception("erreur dans la requete");
    }
    
    $maRequete->closeCursor();
    return $lesMedecins;
}
	
?>