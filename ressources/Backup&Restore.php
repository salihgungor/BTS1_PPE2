<?php
$MyUsername = "alexandre";
$MyPassword = "alexandre";
$FTPUsername = "alexandre";
$FTPPassword = "alexandre";
if(isset($_GET['Sauvegarder'])){
	Sauvegarde();
}elseif(isset($_GET['Restorer'])){
	Reprise();
}

function ConnexionFTP() {
	return ftp_connect('192.168.1.33');
}

function LoginFTP($idConnexion) {
	global $FTPUsername, $FTPPassword;
	return ftp_login($idConnexion, $FTPUsername, $FTPPassword);
}

function Sauvegarde() {
	global $MyUsername, $MyPassword;
	$timeFile = strtotime(date("Y-n-d H:i:s"));
	$chemin = '/var/www/html/hopital_' . $timeFile . '.sql';
	exec("mysqldump -u ".$MyUsername." -p".$MyPassword." --opt --default-character-set=UTF8 --single-transaction --protocol=TCP --host=localhost hopital >" . $chemin);
	$ok = exec('ls ' . $chemin);
	if (!$ok = "") {
		echo "<p>BDD Sauvegardée avec succès.</p>";
		echo "<p>Préparation à l'envoi sur le serveur FTP...</p>";
		$CheminFichierDistant = "Backup/" . explode('/', $chemin)[count(explode('/', $chemin)) - 1];
		$idConnexion = ConnexionFTP();
		if (LoginFTP($idConnexion)) {
			echo "<p>FTP Connecté</p>";
			echo "<p>Transfert du fichier...</p>";
			ftp_put($idConnexion, $CheminFichierDistant, $chemin, FTP_ASCII);
			$fichiers = ftp_nlist($idConnexion, $CheminFichierDistant);
			if (in_array($CheminFichierDistant, $fichiers)) {
				echo "<p>Base de données transférée.</p>";
				exec('rm ' . $chemin);
			} else {
				echo "<p>Une erreur c'est produite lors du transfert de la sauvegarde de la base de données.<p>";
			}
		} else {
			echo 'impossible de se connecter au serveur ftp';
		}
		ftp_close($idConnexion);
	} else {
		echo "Une erreur c'est produite lors de la sauvegarde de la base de donnée.";
		die();
	}
}

function Reprise() {
	global $MyUsername, $MyPassword;
	$idConnexion = ConnexionFTP();
	if (LoginFTP($idConnexion)) {
		echo "<p>FTP Connecté</p>";
		echo "<p>Recuperation de la derniere sauvegarde de la base de données...</p>";
		$fichiers = ftp_nlist($idConnexion, "Backup/");
		foreach ($fichiers as $fichier) {
			$time = explode("_", explode(".", explode("/", $fichier)[count(explode("/", $fichier)) - 1])[0])[1];
			if (!isset($lastTime) || $lastTime < $time) {
				$lastTime = $time;
			}
		}
		$cheminDistant = "Backup/hopital_" . $lastTime . ".sql";
		$cheminLocal = "/var/www/html/hopital_" . $lastTime . ".sql";
		ftp_get($idConnexion, $cheminLocal, $cheminDistant, FTP_ASCII);
		if (exec("ls " . $cheminLocal)) {
			echo "<p>Récupération de la derniere sauvegarde de la base de données effectuée.</p>";
			echo "<p>Importation de la base de données...</p>";
			exec("mysql -h localhost -u ".$MyUsername." -p".$MyPassword." -e \"CREATE DATABASE IF NOT EXISTS hopital\" && mysql -h localhost -u ".$MyUsername." -p".$MyPassword." hopital < $cheminLocal");
			echo "<p>Importation de la base de données terminée.</p>";
			exec("rm ".$cheminLocal);
			echo "<p>Fichier temporaire supprimé</p>";
		} else {
			echo "<p>Une erreur c'est produite lors de la récupération de la derniere base de données.</p>";
		}
	} else {
		echo "L'identification auprès du serveur serveur FTP a échouee.";
	}
}
