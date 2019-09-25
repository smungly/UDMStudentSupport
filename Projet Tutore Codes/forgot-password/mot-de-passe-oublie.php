<?php

/*
================================================

    Nom : Mungly Sydney
    Mail: sydneymungly15@gmail.com
    Description : Projet Tut.
    Date: Fevrier 2018

================================================
*/

	$mail = $_POST['mail'];

	$format = mktime(
   date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
   );

   	$DateDex = date("Y-m-d H:i:s",$format); // Creer une date d'expiration pour le token

   	$token = md5(time().$mail); // Creation du token

   	$cle = substr(md5(uniqid(rand(),1)),3,10);

   	$token = $token . $cle;

	  $mailflag = false;

    include '../classes/Config.php';

    require_once '../vendor/autoload.php';

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
		$mailflag = true;
		echo "*Email invalide<br>";
		exit(0);
	}

// Envoyer le mail

if ($mailflag == false){

	$requete = "INSERT INTO `reinitialiser_mdp` (EMAIL, TOKEN, DATE_EXP) VALUES ('$mail', '$token', '$DateDex')";

		// Create the Transport
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	  ->setUsername('udmstudentsup@gmail.com')
	  ->setPassword('PassW0rd!3');

	// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

	$message = (new Swift_Message('Demande de ré-initialisation de votre mot de passe'))
  ->setFrom(['udmstudentsup@gmail.com' => 'UDM STUDENT SUPPORT'])
  ->setTo([$mail])
  ->addPart('Bonjour, <br>Pour ré-initialiser votre mot de passe veuillez cliquer sur le lien suivant -> <a href="localhost/PFE/forgot-password/nouveau-mdp.php?tok='.$token.'&mail='.$mail.'&action=reset"> ICI </a>.<br><b>Notez que ce lien expire dans 1 jour.</b><br><br><b>Student Support<br>Université des Mascareignes</b>
', 'text/html')
  ;

    try{
    // Instantiasiation
 		$bdd = new Connect();

    // Ouverture de la connexion.
 		$db = $bdd->ouvrir();

 		$stmt = $db->prepare($requete);

 	// Verifie si les donnees sont entrer dans la base de donnee
 		$stmt = $db->exec($requete);

 	// Fermer la connexion
    $db = $bdd->fermer();
    
    $result = $mailer->send($message);
  
    // Fermer la connexion
    $db = $bdd->fermer();

 		echo "Success";
 		exit(0);
 }
 catch (PDOException $e){
 	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
 }

}

?>
