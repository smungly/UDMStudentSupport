<?php

/*
================================================

    Nom : Mungly Sydney
    Mail: sydneymungly15@gmail.com
    Description : Projet Tut.
    Date: Fevrier 2018

================================================
*/

	include 'classes/Config.php'; // Configuration base de donnees

	// Configuration du mail
	require_once 'vendor/autoload.php';
	
	$nameflag = false;
	$mailflag = false;
	$unameflag = false;
	$mdpflag = false;

	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$email = $_POST["mail"];
	$mdp = $_POST["mdp"];
	$uname = $_POST["uname"];
	$dept = $_POST["dept"];
	$sexe = $_POST["sexe"];
	$ddn = $_POST["bday"];
	$nat = $_POST["nat"];
	$add = $_POST["add"];

	$hash = password_hash($mdp, PASSWORD_DEFAULT); // Encrypte le mot de passe
	$verif = md5(time().$uname); // Genere un token pour la verification du compte

// Create the Transport
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
	  ->setUsername('udmstudentsup@gmail.com')
	  ->setPassword('PassW0rd!3');

// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

	$pattern = '/[^a-z0-9 ]+/i';

	$pat = '/^[\w\.]+@/';

	$mail = filter_var($email, FILTER_SANITIZE_EMAIL);

// Validations

	if (1 === preg_match('~[0-9]~', $nom) || (preg_match($pattern, $nom))){
		$nameflag = true;
		echo "001";
		exit(0);
	}

	if (preg_match($pat, $add)){
		$nameflag = true;
		echo "003";
		exit(0);
	}

	if (1 === preg_match('~[0-9]~', $prenom) || (preg_match($pattern, $prenom))){
		$nameflag = true;
		echo "002";
		exit(0);
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$mailflag = true;
		echo "004";
		exit(0);
	}
	
	if (!preg_match("#[0-9]+#", $mdp)) {
		$mdpflag = true;
        echo  "008";
        exit(0);
    }

    if (!preg_match("#[a-zA-Z]+#", $mdp)) {
    	$mdpflag = true;
        echo "008";
        exit(0);
    }

    if(preg_match('/^\s|\s$/', $mdp)) {
        $mdpflag = true;
        echo "008";
        exit(0);
	}

	// Verifie si l'adresse mail entree est disponible
if ($mailflag == false){

	try{
		$bdd = new Connect();

		$db = $bdd->ouvrir();

		$sql = "SELECT id_membre FROM `membres` WHERE email = '{$email}'";

		$stmt = $db->prepare($sql);

 		$stmt->execute(
 			array(
 				'email'=>$email
 			)
 		);

 		$count = $stmt->rowCount();

 		if ($count > 0){
 			echo "010";
 			exit(0);
 		} 

	}catch (PDOException $e){
 		echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    }

// Fermer la connexion

    $db = $bdd->fermer();
}

// Verifier si le nom utilisateur est disponible

if ($unameflag == false){

	try{
		$bdd = new Connect();

		$db = $bdd->ouvrir();

		$sql = "SELECT id_membre FROM `membres` WHERE uname = '{$uname}'";

		$stmt = $db->prepare($sql);
 		$stmt->execute(
 			array(
 				'uname' => $uname
 			)
 		);

 		$count = $stmt->rowCount();

 		if ($count > 0){
 			echo "007";
 			exit(0);
 		} 

	}catch (PDOException $e){
 		echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    }

// Fermer la connexion

    $db = $bdd->fermer();
}

// Insertion

if ($nameflag == false && $mailflag == false && $unameflag == false && $mdpflag == false){

	// Create a message
$message = (new Swift_Message('Étape finale de votre inscription'))
  ->setFrom(['udmstudentsup@gmail.com' => 'UDM STUDENT SUPPORT'])
  ->setTo([$email => 'UDM STUDENT'])
  ->addPart('Bonjour <b>'.$nom.' '.$prenom.'</b>,<br><br>Merci de votre inscription à nôtre site, pour valider votre inscription veuillez suivre ce <a href="http://localhost/pfe/verif.php?verif='.$verif.'">lien</a>.<br><br>Student Support', 'text/html')
  ;
try{
    // Instantiasiation
 	$bdd = new Connect();

    // Ouverture de la connexion.
 	$db = $bdd->ouvrir();

 	// Requete
    $sql = "INSERT INTO `membres` (NOM, PRENOM, EMAIL, UNAME, MDP, SEXE, DEPT, VERIF, DDN, NATION, ADRESSE) VALUES ('$nom','$prenom','$email','$uname','$hash','$sexe','$dept', '$verif', '$ddn', '$nat' ,'$add')";

 	$stmt = $db->prepare($sql);

 	// Verifie si les donnees sont entrer dans la base de donnee
 	$stmt = $db->exec($sql);

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
}

else{
	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
	exit(0);
}

?>