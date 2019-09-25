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

$email = $_POST['email'];
$date = $_POST['date'];
$jour = $_POST['date_ajd'];
$hd = $_POST['hd'];
$hf = $_POST['hf'];

$hd = date('g:ia', strtotime($hd));
$hf = date('g:ia', strtotime($hf));

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	  ->setUsername('counsellorudm@gmail.com')
	  ->setPassword('n0Password13');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$message = (new Swift_Message('Rappel de RDV'))
  ->setFrom(['counsellorudm@gmail.com' => 'UDM COUNSELLOR'])
  ->setTo([$email => 'UDM STUDENT'])
  ->addPart('Bonjour, <br> Ce mail est un rappel que vous avez un rdv chez la conseillère d\'orientation prévu le: <br><br><b>'.$jour.' '.$date.'</b> à <b>'.$hd.'</b><br><br><b>UDM Counsellor</b><br><b>Université des Mascareignes</b>', 'text/html');

header('Location: mes-rdv.php');
$result = $mailer->send($message);

?>