<?php

/*
================================================

	Nom : Mungly Sydney
	Mail: sydneymungly15@gmail.com
	Description : Projet Tut.
	Date: Fevrier 2018

================================================
*/

// Initialiser
session_start();
 
// Reinitialiser les variables de sessions
$_SESSION = array();
 
// Detruire la session
session_destroy();
 
// Redirection vers la page de connexion
header("location: sign_in.html");
exit(0);

?>