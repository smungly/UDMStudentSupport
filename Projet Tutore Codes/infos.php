<?php

/*
================================================

  Nom : Mungly Sydney
  Mail: sydneymungly15@gmail.com
  Description : Projet Tut.
  Date: Fevrier 2018

================================================
*/

include 'classes/Config.php';

$identifiant = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$add = $_POST['adresse'];
$mail = $_POST['email'];
$tel = $_POST['tel'];
$sexe = $_POST['sexe'];
$ville = $_POST['ville'];

$pattern = '/[^a-z0-9 ]+/i';

$pat = '/^[\w\.]+@/';

$mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

$numTel = preg_replace('/[^0-9]/', '', $tel);

$identifiant = (int)$identifiant;

	if (1 === preg_match('~[0-9]~', $nom) || (preg_match($pattern, $nom))){
		echo "001";
		exit(0);
	}

	if (preg_match($pat, $add)){
		echo "003";
		exit(0);
	}

	if (1 === preg_match('~[0-9]~', $prenom) || (preg_match($pattern, $prenom))){
		echo "002";
		exit(0);
	}

	if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
		echo "004";
		exit(0);
	}

	if (strlen($numTel) > 13){
		echo "005";
		exit(0);
	}

$sql = "UPDATE `membres` SET NOM = '$nom', PRENOM = '$prenom', ADRESSE = '$add', EMAIL = '$mail', TELEPHONE = '$numTel', SEXE = '$sexe', VILLE = '$ville'  WHERE ID_MEMBRE = $identifiant";

try{

    // Instantiasiation
   		 $bdd = new Connect();

    // Ouverture de la connexion
  		 $db = $bdd->ouvrir();

    	 $stmt = $db->prepare($sql);

    	 $stmt->execute(
            array(
            	'id_membre' =>$identifiant,
                'nom' => $nom,
                'prenom' => $prenom,
                'adresse' => $add,
                'email' => $mail,
                'telephone' => $numTel
            )
    	 );

    // Fermer la connexion
         $db = $bdd->fermer();

        echo "*Vos informations ont été mises à jour !";
    	exit(0);
	}

catch(PDOException $e){
	    $db = $bdd->fermer();
		echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
		exit(0);
}

?>