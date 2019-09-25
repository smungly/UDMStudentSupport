<?php

session_start();

/*
================================================

	Nom : Mungly Sydney
	Mail: sydneymungly15@gmail.com
	Description : Projet Tut.
	Date: Fevrier 2018

================================================
*/

$email = $_SESSION["email"];

include '../classes/Config.php';

// Configuration du mail
require_once '../vendor/autoload.php';

$date = $_POST['date'];
$hd = $_POST['hd'];
$des = $_POST['des'];
$type = $_POST['type'];
$id = $_POST['id'];
$hf = $_POST['hf'];

$id = (int)$id;

// Conversion des types textes au types temps pour la base de donnees

$hd = strtotime($hd);
$debut = date('H:i', $hd);

$date = strtr($date, '/', '-');
$new_date = date('Y-m-d', strtotime($date));

$hf = strtotime($hf);
$fin = date('H:i', $hf);

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	  ->setUsername('counsellorudm@gmail.com')
	  ->setPassword('n0Password13');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$message = (new Swift_Message('Prise de RDV'))
  ->setFrom(['counsellorudm@gmail.com' => 'UDM COUNSELLOR'])
  ->setTo([$email => 'UDM STUDENT'])
  ->addPart('Bonjour, <br> Votre demande de RDV chez la conseillère d\'orientation a été enregistré pour le <b>'.$date.'</b> à <b>'.$debut.'</b>.<br><br><b>Vous serez informé(e) bientôt si votre rendez-vous est confirmé.</b><br><br><b>UDM Counsellor</b><br><b>Université des Mascareignes</b>', 'text/html');

try{

	$bdd = new Connect();

	$db = $bdd->ouvrir();

    $verif = "SELECT ID_RDV FROM `rdv` WHERE `rdv`.`DATE` = '$new_date' AND `rdv`.`HEURE_DEBUT` = '$debut' AND `rdv`.`HEURE_FIN` = '$fin'";

	$stmt = $db->prepare($verif);

 	$stmt->execute();

 	$count = $stmt->rowCount();

 	if ($count > 0){
		echo "*Date ou Horaire Indisponible. Veuillez choisir une autre date ou une autre horaire. Consultez le calendrier à côté pour connaître les dates / horaires disponibles.";
      $db = $bdd->fermer();
 	  exit(0);
 	} 

}catch (PDOException $e){
 	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
}

try{
    // Instantiatiation
 	$bdd = new Connect();

    // Ouverture de la connexion.
 	$db = $bdd->ouvrir();

 	// Requete
	$insert = "INSERT INTO `rdv` (ID_MEMBRE, ID_SERVICE, DATE, HEURE_DEBUT, HEURE_FIN, DESCRP) VALUES ('$id', '$type', '$new_date', '$debut', '$fin', '$des')";

 	$stmt = $db->prepare($insert);

 	// Verifie si les donnees sont entrer dans la base de donnee
 	$stmt = $db->exec($insert);
 	
 	echo "Success";
 	$result = $mailer->send($message);
 	exit(0);
 }
 catch (PDOException $e){
 	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
 }

// Fermer la connexion

    $db = $bdd->fermer();
    exit(0);

?>