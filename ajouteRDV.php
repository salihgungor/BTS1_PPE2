<?php
	try{
		//on se connecte à la bdd
		$bdd = new PDO('mysql:host=localhost; dbname=hopital; charset=utf8', 'root');
		//on recupere les variables
		$id = strtolower($_POST['email']);
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$tel = $_POST['tel'];
		$medecin = $_POST['docteur'];
		$date = $_POST['daterdv'];
		$d = substr($date, 0,2);
		$m = substr($date, 3,2);
		$y = substr($date, 6,4);
		$date =  $y."-".$m."-".$d;
		$heure = $_POST['heurerdv'];
		
		//on verifie si le patient existe (par rapport a son email)
		$requete = $bdd->prepare('SELECT * FROM patient WHERE id=?');
		$requete->execute(array($id));
		if($requete->rowCount() == 0){
			//le patient n'existe pas on l'ajoute
			$requete = $bdd->prepare('INSERT INTO patient(id, nom, prenom, telephone) VALUES(:id, :nom, :prenom, :telephone)');
			$requete->execute(array(
				'id'=>$id,
				'nom'=>$nom,
				'prenom'=>$prenom,
				'telephone'=>$tel
			));
		}
		
		//on va trouver l'id du medecin avec son nom 
		$requete = $bdd->prepare('SELECT id FROM medecin WHERE nom=?');
		$requete->execute(array($medecin));
		while($donnee = $requete->fetch()){$idMedecin = $donnee['id'];}
		
		/*//on va trouver le service dans lequel le medecin est
		$requete = $bdd->prepare('SELECT nom FROM service JOIN medecin on medecin.idservice = service.id WHERE medecin.id = ?');
		$requete = $bdd->execute(array($idMedecin));
		$nomService = $requete->fetch();*/
		
		//on ajoute le rendez-vous
		$requete = $bdd->prepare('INSERT INTO rdv(patient, medecin, date, heure) VALUES(:patient, :medecin, :date, :heure)');
		$requete->execute(array(
			'patient'=>$id,
			'medecin'=>$idMedecin,
			'date'=>$date,
			'heure'=>$heure
		));
		header('Location: rdv.php?r=0');
		exit();
	} catch (Exception $ex) {
		echo 'Erreur : ' . $ex;
		header('Location: rdv.php?r=1');
		exis();
	}
?>