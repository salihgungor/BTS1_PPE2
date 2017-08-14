<?php

if (isset($_POST['mailConnexion'])) {
	session_start();
	connexion();
} else if (isset($_POST['mailInscription'])) {
	session_start();
	inscription();
} elseif (isset($_POST['ajouterPossibiliteRdv'])) {
	session_start();
	ajouterPossibiliteRdv();
} elseif (isset($_GET['listeMedecinsService'])) {
	session_start();
	getListeMedecinsService(filter_input(INPUT_GET, 'listeMedecinsService'));
} elseif(isset($_GET['listeRdvLibreMedecin'])){
	session_start();
	getListeRdvLibreMed(filter_input(INPUT_GET, 'listeRdvLibreMedecin'));
} elseif(isset($_GET['prendreRdv'])){
	session_start();
	prendreRdv(loginToId($_SESSION['login']), filter_input(INPUT_GET, 'prendreRdv'));
} elseif(isset($_GET['infosJustificatif'])){
	session_start();
	InfosJustificatif(filter_input(INPUT_GET, "infosJustificatif"));
}

function connexionBDD() {
	try {
		//$bdd = new PDO("mysql:host=localhost;dbname=hopital", "root");
		$bdd = new PDO("mysql:host=localhost;dbname=hopital", "alexandre", "alexandre");
		return $bdd;
	} catch (Exception $ex) {
		die();
	}
}

function connexion() {
	if (!empty($_POST['mailConnexion'])) {
		$mail = $_POST['mailConnexion'];
		if (mailValidator($mail) == false) {
			header("Location: ../index.php?page=connexion&e=1"); //email invalide
			exit();
		}
	} else {
		header("Location: ../index.php?page=connexion&e=2"); //email vide
		exit();
	}

	if (isset($_POST['mdpConnexion']) && !empty($_POST['mdpConnexion'])) {
		$mdp = $_POST['mdpConnexion'];
	} else {
		header("Location: ../index.php?page=connexion&e=3"); //mot de passe non saisi
		exit();
	}
	$mdp = hashage($mdp);
	$ok = verifCompte($mail, $mdp);
	if ($ok == 1) {
		$_SESSION['login'] = $mail;
		$_SESSION['mdp'] = $mdp;
		getTypeCompte();
		header("Location: ../index.php");
		exit();
	} else if ($ok == 0) {
		header("Location: ../index.php?page=connexion&ok=0");
		exit();
	}
}

function mailValidator($mail) {
	$retour = false;
	if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		$retour = true;
	}
	return $retour;
}

function hashage($mdp) {
	$mdp = hash("SHA256", $mdp);
	return $mdp;
}

function verifCompte($mail, $mdp) {
	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT Count(id) FROM utilisateur WHERE login = ? AND mdp = ?");
		$requete->execute(array($mail, $mdp));
		$resultat = $requete->fetch();
		$resultat = $resultat[0];
		return $resultat;
	} catch (Exception $ex) {
		return $ex;
	}
}

/* function inscription($mail, $mdp, $dateNaiss, $cp, $telephone, $ville, $adresse, $verif_mdp) {
  if (!empty($_POST['mailInscription'])) {
  $mail = $_POST['mailInscription'];
  if (mailValidator($mail) == false) {
  header("Location: ../index.php?page=connexion&e=1"); //email invalide
  exit();
  }
  } else {
  header("Location: ../index.php?page=connexion&e=2"); //email vide
  exit();
  }

  if (isset($_POST['mdpInscription']) && !empty($_POST['mdpInscription']) || (isset($_POST['verifMdpInscription']) && !empty($_POST['mdpInscription']))) {
  $mdp = $_POST['mdpConnexion'];
  } else {
  header("Location: ../index.php?page=connexion&e=3"); //mot de passe non saisi
  exit();
  }
  if ($mdp != $verif_mdp) {
  header("Location: ../index.php?page=connexion&e=4"); // confirmation de mdp non identique
  exit();
  }


  if (!verifCp($cp)) {
  header("Location: ../index.php?page=connexion&e=4"); // code postale invalide
  exit();
  }

  if (!validateDate($dateNaiss)) {
  header("Location: ../index.php?page=connexion&e=5"); // date naissance non valide
  exit();
  }

  if (!verifNum($telephone)) {
  header("Location: ../index.php?page=connexion&e=6"); // numero non valide
  exit();
  }


  $mdp = hashage($mdp);
  $ok = mailExiste($mail);
  if ($ok == 1) {

  header("Location: ../index.php?page=connexion?ok=1"); // il existe deja

  exit();
  } else if ($ok == 0) {
  header("Location: ../index.php?page=connexion?ok=0"); // c'est ok
  exit();
  }
  $bdd = connexionBDD();
  $msg = "ajoutée !! ";

  try {
  $requete = $bdd->prepare("INSERT INTO hopital VALUES (NULL,?,?,?,?,?,?,?,2,NULL)");
  $requete->execute(array(
  $mail,
  $mdp,
  $telephone,
  $dateNaiss,
  $adresse,
  $cp,
  $ville
  ));
  if ($bdd) {
  $requete->closeCursor();
  return $msg;
  }
  } catch (Exception $ex) {

  return $ex;
  }
  } */

function inscription($mail, $mdp, $dateNaiss, $cp, $telephone, $ville, $adresse, $verif_mdp) {
	if (!empty($_POST['mailInscription'])) {
		$mail = $_POST['mailInscription'];
		if (mailValidator($mail) == false) {
			header("Location: ../index.php?page=inscription.php&e=1"); //email invalide
			exit();
		}
	} else {
		header("Location: ../index.php?page=inscription.php&e=2"); //email vide
		exit();
	}

	if (!empty($_POST['nom'])) {
		$nom = $_POST['nom'];
	} else {
		header("Location: ../index.php?page=inscription.php&e=8"); //nom vide
		exit();
	}

	if (!empty($_POST['prenom'])) {
		$prenom = $_POST['prenom'];
	} else {
		header("Location: ../index.php?page=inscription.php&e=9"); //prenom vide
		exit();
	}

	if (isset($_POST['mdpInscription']) && !empty($_POST['mdpInscription']) && (isset($_POST['verifMdpInscription']) && !empty($_POST['verifMdpInscription']))) {
		$mdp = $_POST['mdpInscription'];
		$verif_mdp = $_POST['verifMdpInscription'];
	} else {
		header("Location: ../index.php?page=inscription.php&e=3"); //mot de passe non saisi
		exit();
	}

	if ($mdp != $verif_mdp) {
		header("Location: ../index.php?page=inscription.php&e=4"); // confirmation de mdp non identique
		exit();
	}

	if (!empty($_POST['cp'])) {
		$cp = $_POST['cp'];
	} else {
		header("Location: ../index.php?page=inscription.php&e=10"); //prenom vide
		exit();
	}

	if (!verifCp($cp)) {
		header("Location: ../index.php?page=inscription.php&e=5"); // code postale invalide
		exit();
	}

	if (!empty($_POST['dateNaiss'])) {
		$dateNaiss = $_POST['dateNaiss'];
	} else {
		header("Location: ../index.php?page=inscription.php&e=11"); // date de naissance vide
		exit();
	}
	if (empty($dateNaiss)) {
		header("Location: ../index.php?page=inscription.php&e=6"); // date naissance non valide
		exit();
	}

	if (!empty($_POST['telephone'])) {
		$telephone = $_POST['telephone'];
	} else {
		header("Location: ../index.php?page=inscription.php&e=12"); //numero vide
		exit();
	}
	if (!verifNum($telephone)) {
		header("Location: ../index.php?page=inscription.php&e=7"); // numero non valide
		exit();
	}
	$mdp = hashage($mdp);
	$ok = mailExiste($mail);

	if ($ok == 1) {

		header("Location: ../index.php?page=inscription.php&ok=1"); // il existe deja  

		exit();
	} else if ($ok == 0) {
		$bdd = connexionBDD();

		$requete = $bdd->prepare("INSERT INTO utilisateur VALUES (NULL,?,?,?,?,?,?,?,?,?,2,NULL)");
		$requete->execute(array(
				$_POST["mailInscription"],
				$mdp,
				$nom,
				$prenom,
				$_POST["telephone"],
				$_POST["dateNaiss"],
				$_POST["adresse"],
				$_POST["cp"],
				$_POST["ville"]
		));
		header("Location: ../index.php?page=connexion.php&ok=1"); // c'est ok  
		exit();
	}
}

function deconnexion() {
	session_unset();
	session_destroy();
	header("Location: index.php");
}

function mailExiste($mail) {

	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT Count(id) FROM utilisateur WHERE login = ?");
		$requete->execute(array($mail));
		$resultat = $requete->fetch();
		return $resultat[0];
	} catch (Exception $ex) {
		return $ex;
	}
}

function getTypeCompte() {
	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT codeTypeUtilisateur FROM utilisateur WHERE login = ? AND mdp = ?");
		$requete->execute(array($_SESSION['login'], $_SESSION['mdp']));
		$resultat = $requete->fetch();

		$_SESSION['typeUtilisateur'] = $resultat[0];
		return true;
	} catch (Exception $ex) {
		return $ex;
	}
}

function verifCp($cp) {
	$estPostale = true;
	if (!eregi("^([0-9]{5})$", $cp)) {
		$estPostale = false;
	}
	return $estPostale;
}

function validateDate($date, $format = 'd/m/Y') {
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

function verifNum($num) {
	return preg_match("#(\+[0-9]{2}\([0-9]\))?[0-9]{10}#", $num);
}

function getListeRdvMed($login) {
	$bdd = connexionBDD();
	try {
		$idMedecin = loginToId($login);
		$requete = $bdd->prepare("SELECT date, heure, nom, prenom FROM rdv LEFT JOIN utilisateur ON rdv.idPatient = utilisateur.id WHERE idMedecin = ?");
		$requete->execute(array($idMedecin));
		$resultat = $requete->fetchAll();
		return $resultat;
	} catch (Exception $ex) {
		throw new Exception("erreur lors de la recuperation des rendez-vous du medecin: " . $ex);
	}
}

function getListeServices() {
	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT code, libelle FROM service");
		$requete->execute();
		$resultat = $requete->fetchAll();
		$requete->closeCursor();
		return $resultat;
	} catch (Exception $ex) {
		throw new Exception("erreur lors de la recuperation de la liste des services: " . $ex);
	}
}

function getListeMedecins() {
	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT id, nom, codeService FROM utilisateur WHERE codeTypeUtilisateur = 1");
		$requete->execute();
		$resultat = $requete->fetchAll();
		$requete->closeCursor();
		return $resultat;
	} catch (Exception $ex) {
		throw new Exception("erreur lors de la recuperation de la liste des medecins: " . $ex);
	}
}

function getListeRdvLibreMed($idMedecin) {
	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT id, date, heure FROM rdv WHERE idMedecin = ? AND idPatient IS NULL AND CURDATE() < date ");
		$requete->execute(array($idMedecin));
		$resultat = $requete->fetchAll();
		$retour = "";
		foreach ($resultat as $rdv) {
			$retour .= "<tr><td>" . $rdv['date'] . "</td><td>" . $rdv['heure'] . "</td><td><a href=\"#\" onclick=\"RDV(" . $rdv['id'] . ")\">prendre Rendez-vous</a></td></tr>";
		}
		print($retour);
	} catch (Exception $ex) {
		throw new Exception("erreur lors de la recuperation des rendez-vous du medecin: " . $ex);
	}
}

function getListeMedecinsService($service) {
	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT id, nom FROM utilisateur WHERE codeTypeUtilisateur=1 AND codeService=?");
		$requete->execute(array($service));
		$resultat = $requete->fetchAll();
		$requete->closeCursor();
		$retour = "";
		foreach ($resultat as $medecin) {
			$retour .= "<option value=\"" . $medecin['id'] . "\">" . $medecin['nom'] . "</option>";
		}
		print($retour);
	} catch (Exception $ex) {
		throw new Exception("erreur lors de la recuperation de la liste des medecins: " . $ex);
	}
}

function ajouterPossibiliteRdv() {
	$bdd = connexionBDD();
	$buf = explode(" ", filter_input(INPUT_POST, "date"));
	$date = $buf[0];
	$heure = $buf[1];
	unset($buf);
	var_dump($date);
	var_dump($heure);
	$idMedecin = loginToId($_SESSION['login']);
	var_dump($idMedecin);
	try {
		$requete = $bdd->prepare("INSERT INTO rdv(date, heure, idMedecin) VALUES(?, ?, ?)");
		$ok = $requete->execute(array($date, $heure, $idMedecin));
		header("Location: ../index.php?page=rdv");
	} catch (Exception $ex) {
		throw new Exception("Une erreur c'est produite lors de l'ajout d'un horaire de rendez-vous: ".$ex);
	}
}

function loginToId($login) {
	$bdd = connexionBDD();
	try {
		$requete = $bdd->prepare("SELECT id FROM utilisateur WHERE login=?");
		$requete->execute(array($login));
		$resultat = $requete->fetch();
		$requete->closeCursor();
		return $resultat[0];
	} catch (Exception $ex) {
		throw new Exception("Une erreur c'est produite lors de la recuperation de l'id d'un utilisateur avec son login: ".$ex);
	}
}

function prendreRdv($patient, $rdv){
	$bdd = connexionBDD();
	try{
		$requete = $bdd->prepare("UPDATE rdv SET idPatient=? WHERE id=?");
		$ok = $requete->execute(array($patient, $rdv));
		if($ok){
			print('ok');
		}
	} catch (Exception $ex) {
		throw new Exception("Une erreur c'est produite lors de la mise a jout de la table rdv:".$ex);
	}
}

function InfosJustificatif($idRdv){
	$bdd = connexionBDD();
	$requete = $bdd->prepare("SELECT nom, prenom, adresse, codePostal as codepostal, ville, date, heure FROM rdv JOIN utilisateur ON rdv.idPatient = utilisateur.id WHERE rdv.id=?");
	$requete->execute(array($idRdv));
	$resultat = $requete->fetch();
	$requete->closeCursor();
	$requete = $bdd->prepare("SELECT nom as docteur, libelle FROM rdv JOIN utilisateur ON rdv.idMedecin = utilisateur.id JOIN service ON utilisateur.codeService = service.code WHERE rdv.id=?");
	$requete->execute(array($idRdv));
	$resultat2 = $requete->fetch();
	$docteur=$resultat2['docteur'];
	$service=$resultat2['libelle'];
	$retour = $resultat['nom']." ".$resultat['prenom']." ".$resultat['adresse']." ".$resultat['codepostal']." ".$resultat['ville']." ".$docteur." ".$service." ".$resultat['date']." ".$resultat['heure'];
	print($retour);
}

?>
