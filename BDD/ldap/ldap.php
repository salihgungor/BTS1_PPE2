<?php

// Authentification LDAP (username et mot de passe)

$ldaprdn  = 'infirmier1';     // DN ou RDN LDAP
$ldappass = 'infirmier1';  // Mot de passe associé
$ldapconfig['host'] = '192.168.1.5'; //HOST(serveur)
$ldapconfig['basedn'] = 'dc=slam,dc=sio'; //BASE DN
$ldapconfig['port'] = NULL; //PORT
$ldapconfig['basedn'] = 'dc=slam,dc=sio';

// Connexion au serveur LDAP
$ldapconn = ldap_connect($ldapconfig['host'],$ldapconfig['port'])
        //ldap_connect($ldapconfig['host'],$ldapconfig['port'])  //ldap_conect qui sert a se connecter au serveur ldap.
    or die("Impossible de se connecter au serveur LDAP."); //affiche un message d'erreur si jamais la connexion est échoué 


$dn="uid=".$username.",ou=people,".$ldapconfig['basedn'];

if ($ldapconn) { //si la connexion est reussie

    // Connexion au serveur LDAP
    $ldapbind = ldap_bind($ldapconn, $dn, $ldappass); //on se connecte avec les informations saisie(ldaprdn et ldappass)

    // Vérification de l'authentification
    if ($ldapbind) { //si l'authentification est bonne
        echo "Connexion LDAP réussie...<br/>";
    } else {
        echo "Connexion LDAP échouée...";
    }

}



