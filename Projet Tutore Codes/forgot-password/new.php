<?php

/*
================================================

    Nom : Mungly Sydney
    Mail: sydneymungly15@gmail.com
    Description : Projet Tut.
    Date: Fevrier 2018

================================================
*/

include '../classes/Config.php';

require_once '../vendor/autoload.php';


$flag = false;
$email = $_POST["mail"];
$mdp = $_POST['mdp'];

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
      ->setUsername('udmstudentsup@gmail.com')
      ->setPassword('PassW0rd!3');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Mot de Passe Modifié'))
  ->setFrom(['udmstudentsup@gmail.com' => 'UDM STUDENT SUPPORT'])
  ->setTo([$email])
  ->addPart('Bonjour,<br><br>Votre Mot de Passe a été modifié avec succès.<br><br><b>Student Support<br>Université des Mascareignes</b>', 'text/html')
  ;

	if (!preg_match("#[0-9]+#", $mdp)) {
		$flag = true;
        echo  "*Votre mot de passe doit inclure au moins un chiffre !";
        exit(0);
    }

    if (!preg_match("#[a-zA-Z]+#", $mdp)) {
    	$flag = true;
        echo "*Votre mot de passe doit inclure au moins une lettre !";
        exit(0);
    }

    if(preg_match('/^\s|\s$/', $mdp)) {
        $flag = true;
        echo "*Votre mot de passe ne peux commencer et terminer par un espace !";
        exit(0);
	}

$hash = password_hash($mdp, PASSWORD_DEFAULT); // Encrypte le mot de passe

$req = "UPDATE `membres` SET MDP = '$hash' WHERE EMAIL = '$email'";

$req2 = "DELETE FROM `reinitialiser_mdp` WHERE EMAIL = '$email'";

try{

    // Instantiasiation
   		 $bdd = new Connect();

    // Ouverture de la connexion
  		 $db = $bdd->ouvrir();

    	 $stmt = $db->prepare($req);

    	 $stmt_ = $db->prepare($req2);

    	 $stmt = $db->exec($req);

    	 $stmt_ = $db->exec($req2);

    // Fermer la connexion
        $db = $bdd->fermer();

        echo "Success";
        $result = $mailer->send($message);
    	exit(0);
	}
	catch(PDOException $e){
		$erreur = "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
		exit(0);
	}


?>