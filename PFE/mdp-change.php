<?php

include 'classes/Config.php'; // Configuration base de donnees

// Configuration du mail
require_once 'vendor/autoload.php';

// Create the Transport
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	  ->setUsername('udmstudentsup@gmail.com')
	  ->setPassword('PassW0rd!3');

// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

$id = $_POST['identifiant'];

$old = $_POST['old']; // ancien mot de passe

$mdp1 = $_POST['mdp1'];
$mdp1 = trim($mdp1);

if (!preg_match("#[0-9]+#", $mdp1)) {
      echo  "*Votre mot de passe doit inclure au moins un chiffre, une lettre et ne doit pas commencer et terminer par un espace";
      exit(0);
}

if (!preg_match("#[a-zA-Z]+#", $mdp1)) {
      echo "*Votre mot de passe doit inclure au moins un chiffre, une lettre et ne doit pas commencer et terminer par un espace";
      exit(0);
}

if(preg_match('/^\s|\s$/', $mdp1)) {
      echo "*Votre mot de passe doit inclure au moins un chiffre, une lettre et ne doit pas commencer et terminer par un espace";
      exit(0);
}

$id =(int)$id;

$hash = password_hash($mdp1, PASSWORD_DEFAULT); // Encrypte le mot de passe

$sql = "SELECT * FROM `membres` WHERE ID_MEMBRE = $id";

// Verifie si le mot de passe correspond

try{

	$bdd = new Connect();

	$db = $bdd->ouvrir();

	$stmt = $db->prepare($sql);

 	$stmt->execute();

    $data = $stmt->fetchAll();

  	foreach($data as $ligne){
        $mdp = $ligne['MDP'];
        $nom = $ligne['NOM'];
        $prenom = $ligne['PRENOM'];
        $mail = $ligne['EMAIL'];
    }

    if (!password_verify($old, $mdp)){
    	echo "*Ancien mot de passe incorrect";
    	$db = $bdd->fermer();
    	exit(0);
    }

}catch (PDOException $e){
 	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
 	$db = $bdd->fermer();
 	exit(0);
}

// Changer le mot de passe

$update = "UPDATE `membres` SET MDP = '$hash' WHERE ID_MEMBRE = $id";

try{

// Create a message
	$message = (new Swift_Message('Notification'))
  ->setFrom(['udmstudentsup@gmail.com' => 'UDM STUDENT SUPPORT'])
  ->setTo([$mail => 'UDM STUDENT'])
  ->addPart('Bonjour, <br>Ce mail vous notifie du changement avec succès de votre mot de passe.</b><br><br><b>Student Support<br>Université des Mascareignes</b>', 'text/html')
  ;

	$bdd = new Connect();

	$db = $bdd->ouvrir();

	$stmt = $db->prepare($update);

 	$stmt->execute();

 	$result = $mailer->send($message);

   echo "Success";
   exit(0);

}catch (PDOException $e){
	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
 	$db = $bdd->fermer();
 	exit(0);
}

?>