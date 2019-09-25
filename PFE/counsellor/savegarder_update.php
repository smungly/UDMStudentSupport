<?php
/*
================================================

  Nom : Mungly Sydney
  Mail: sydneymungly15@gmail.com
  Description : Projet Tut.
  Date: Fevrier 2018

================================================
*/

    require_once "../classes/Config.php";

	$retour = $_POST['des'];
	$idrdv = $_POST['id'];

	$id = (int)$idrdv;

	$sql = "UPDATE rdv SET RETOUR = '$retour' WHERE ID_RDV = $id";

try{

    // Instantiation
   		 $bdd = new Connect();

    // Ouverture de la connexion
  		 $db = $bdd->ouvrir();

    	 $stmt = $db->prepare($sql);

    	 $stmt = $db->exec($sql);

    // Fermer la connexion
        $db = $bdd->fermer();

        echo "Success";
    	exit(0);
	}
catch(PDOException $e){
		$erreur = "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
		exit(0);
}

?>