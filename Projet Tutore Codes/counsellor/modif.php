<?php

/*
================================================

  Nom : Mungly Sydney
  Mail: sydneymungly15@gmail.com
  Description : Projet Tut.
  Date: Fevrier 2018

================================================
*/
	// Configuration du mail
require_once '../vendor/autoload.php';

include_once '../classes/Config.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	  ->setUsername('counsellorudm@gmail.com')
	  ->setPassword('n0Password13');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$id_membre = $_POST['id_etud'];
$id_rdv = $_POST['id_rdv'];
$HD = $_POST['Debut'];
$HF = $_POST['Fin'];
$statut = $_POST['Statut'];
$date = $_POST['date'];
$email = $_POST['email'];

$error = "";

$id_membre = (int)$id_membre;
$id_rdv = (int)$id_rdv;

//Convert the date string into a unix timestamp.
$unixTimestamp = strtotime($date);
 
//Get the day of the week using PHP's date function.
$dayOfWeek = date("l", $unixTimestamp);

// Traduction 
if ($dayOfWeek == "Monday"){
  $dayOfWeek = 'Lundi';
}
elseif($dayOfWeek == "Tuesday"){
  $dayOfWeek = 'Mardi';
}
else if($dayOfWeek == "Wednesday"){
  $dayOfWeek = 'Mercredi';
}
else if($dayOfWeek == "Thursday"){
  $dayOfWeek = 'Jeudi';
}
else if($dayOfWeek == "Friday"){
  $dayOfWeek = 'Vendredi';
}

$select = "SELECT ID_RDV FROM `rdv` WHERE DATE = '$date' AND HEURE_DEBUT = '$HD' AND HEURE_FIN = '$HF' AND STATUT = '$statut'";
$sql = "UPDATE `rdv` SET STATUT = '$statut', HEURE_DEBUT = '$HD', HEURE_FIN = '$HF', DATE = '$date' WHERE ID_RDV = $id_rdv";

// Verif pour ne pas avoir de clash

try {

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $res = $db->prepare($select);

    $res->execute();

    $count = $res->rowCount();

    if ($count == 1){
      
      $error = "Creneau pas dispo";
      header('Location: mes-rdv.php');
      $db = $bdd->fermer();
      exit(0);
    }

}catch(PDOException $e){
      echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
      exit(0);
}

// Les messages

if($statut == "Confirmes"){

  $message = (new Swift_Message('Notification de RDV'))
  ->setFrom(['counsellorudm@gmail.com' => 'UDM COUNSELLOR'])
  ->setTo([$email => 'UDM STUDENT'])
  ->addPart('Bonjour,<br> Veuillez noter que votre rendez-vous chez la conseillère d\'orientation a été validé pour le: <br><br><b>'.$dayOfWeek.' '.$date.'</b> <br><br>Pour les horaires suivantes : De <b>'.$HD.'</b> à <b>'.$HF.'</b><br><br><b>UDM Counsellor</b><br><b>Université des Mascareignes</b>', 'text/html');
}

else if ($statut == "Annules" || $statut == "En Attente"){

  $message = (new Swift_Message('Notification de RDV'))
  ->setFrom(['counsellorudm@gmail.com' => 'UDM COUNSELLOR'])
  ->setTo([$email => 'UDM STUDENT'])
  ->addPart('Bonjour, <br> Veuillez noter que votre rendez-vous chez la conseillère d\'orientation prévu le <b> '.$dayOfWeek.' '.$date.' </b> à <b>'.$HD.' </b> a été annulé.<br><br> Vous serez informé(e) ulterieurement de toute evolution.<br><br>UDM Counsellor<b></b><br><b>Université des Mascareignes</b>', 'text/html');
}


try{

		$bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    header('Location: mes-rdv.php');
    $result = $mailer->send($message);
    $db = $bdd->fermer();
    exit(0);

}catch (PDOException $e){
    	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    	exit(0);
}

?>