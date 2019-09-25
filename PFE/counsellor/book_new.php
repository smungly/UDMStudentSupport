<?php

// Configuration du mail
require_once '../vendor/autoload.php';

include '../classes/Config.php';

$date = $_POST['date'];
$hd = $_POST['hd'];
$des = $_POST['des'];
$type = $_POST['type'];
$email = $_POST['id'];
$hf = $_POST['hf'];

// Conversion des types textes au types temps pour la base de donnees

$hd = strtotime($hd);
$debut = date('H:i', $hd);

$date = strtr($date, '/', '-');
$new_date = date('Y-m-d', strtotime($date));

$hf = strtotime($hf);
$fin = date('H:i', $hf);

$mail = filter_var($email, FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo "Adresse Mail non valide";
		exit(0);
}

$check = "SELECT ID_MEMBRE FROM MEMBRES WHERE EMAIL = '$email'";

// Verifie si l'adresse mail est dans la base de donnees

try{
	$bdd = new Connect();

	$db = $bdd->ouvrir();

	$stmt = $db->prepare($check);

 	$stmt->execute(
 		array(
 			'email'=>$email
 		)
 	);

 	$count = $stmt->rowCount();

 	if ($count == 0){
 		echo "*Cet adresse mail n'est associé à aucun étudiant.";
 		// Fermer la connexion
    	$db = $bdd->fermer();
 		exit(0);
 	} 

}catch (PDOException $e){
 		echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
 		exit(0);
}

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
      ->setUsername('counsellorudm@gmail.com')
      ->setPassword('n0Password13');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$message = (new Swift_Message('Rappel de RDV'))
  ->setFrom(['counsellorudm@gmail.com' => 'UDM COUNSELLOR'])
  ->setTo([$email => 'UDM STUDENT'])
  ->addPart('Bonjour, <br> Votre prochain rendez vous chez la conseillère d\'orientation est prévu pour le <b>'.$new_date.'</b> à <b>'.$debut.'</b>. <br><br> <b>*Cette date / heure est cependant sujette à un changement mais vous serez informé de toute évolution.<br><br><b>UDM Counsellor</b><br><b>Université des Mascareignes</b>', 'text/html');

// Verifie si la date est disponible

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

// Book !

$select = "SELECT ID_MEMBRE FROM membres WHERE EMAIL = '$email'";

try{
    // Instantiasiation
    $bdd = new Connect();

    // Ouverture de la connexion
    $db = $bdd->ouvrir();

    $stmt = $db->prepare($select);

    $stmt->execute(
        array(
            'EMAIL' => $email
        )
    );

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = $res['ID_MEMBRE'];

    $db = $bdd->fermer();

} catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.";
 }   

// Convertie le texte en entier

$identifiant = (int)$id;

try{
    // Instantiatiation
 	$bdd = new Connect();

    // Ouverture de la connexion.
 	$db = $bdd->ouvrir();

 	// Requete
	$insert = "INSERT INTO `rdv` (ID_MEMBRE, ID_SERVICE, DATE, HEURE_DEBUT, HEURE_FIN, DESCRP, STATUT) VALUES ($identifiant, '$type', '$new_date', '$debut', '$fin', '$des', 'Confirmes')";

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

?>