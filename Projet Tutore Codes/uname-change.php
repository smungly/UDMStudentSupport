<?php

include 'classes/Config.php'; // Configuration base de donnees

// Configuration du mail
require_once 'vendor/autoload.php';

$uname = $_POST['uname'];
$old = $_POST['old']; // L'ancien nom utilisateur

$identifiant = $_POST['identifiant']; // ID_MEMBRE

$uname = trim($uname);

$identifiant = (int)$identifiant;

$sql = "SELECT * FROM `membres` WHERE ID_MEMBRE = $identifiant"; // Pour le mail

$update = "UPDATE `membres` SET UNAME = '$uname' WHERE ID_MEMBRE = $identifiant";

// Verfie si le nouveau nom d'utilisateur est disponible

try{
		$bdd = new Connect();

		$db = $bdd->ouvrir();

    $verif = "SELECT ID_MEMBRE FROM `membres` WHERE UNAME = '$uname'";

		$stmt = $db->prepare($verif);

 		$stmt->execute(
 			array(
 				'uname' => $uname
 			)
 		);

 		$count = $stmt->rowCount();

 		if ($count > 0){
 			echo "Ce nom d'utilisateur est indisponible.";
      // Fermer la connexion
      $db = $bdd->fermer();
 			exit(0);
 		} 

	}catch (PDOException $e){
 		echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    }

try{

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $stmt = $db->prepare($update);

    $resultat->execute();

    $stmt->execute();

    $data = $resultat->fetchAll();

    foreach($data as $ligne){
        $nom = $ligne['NOM'];
        $prenom = $ligne['PRENOM'];
        $mail = $ligne['EMAIL'];
    }

    // Envoyer mail de notification

    // Create the Transport
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	  ->setUsername('udmstudentsup@gmail.com')
	  ->setPassword('PassW0rd!3');

	// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

		// Create a message
	$message = (new Swift_Message('Notification'))
  ->setFrom(['udmstudentsup@gmail.com' => 'UDM STUDENT SUPPORT'])
  ->setTo([$mail => 'UDM STUDENT'])
  ->addPart('Bonjour, <br>Ce mail vous notifie du changement avec succès de votre nom utilisateur (anciennement <b>'.$old.'</b>) en maintenant <b>'.$uname.'.</b><br><br><b>Student Support<br>Université des Mascareignes</b>', 'text/html')
  ;

  // Changement du nom de session

  session_start();

  $_SESSION["loggedin"] = true;
  $_SESSION["username"] = $uname;

   $result = $mailer->send($message);

   echo "Success";

    $db = $bdd->fermer();

  }catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    exit(0);
  }
?>