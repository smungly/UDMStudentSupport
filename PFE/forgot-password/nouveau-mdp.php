<?php

/*
================================================

    Nom : Mungly Sydney
    Mail: sydneymungly15@gmail.com
    Description : Projet Tut.
    Date: Fevrier 2018

================================================
*/

	include '../classes/Config.php'; // Configuration base de donnees

	// Configuration du mail
	require_once '../vendor/autoload.php';

	$mail = $_GET['mail'];
	$token = $_GET['tok'];
	$action = $_GET['action'];
    $erreur = '';

	$dateDajd = date("Y-m-d H:i:s"); // La date d'aujourd'hui pour valider la validite du lien

	$sql = "SELECT * FROM `reinitialiser_mdp` WHERE TOKEN = '$token' AND EMAIL = '$mail' LIMIT 1";

	try{
		$bdd = new Connect();

		$db = $bdd->ouvrir();

		$stmt = $db->prepare($sql);

 		$stmt->execute(
 			array(
 				'email'=>$mail,
 				'token'=>$token
 			)
 		);

 		$count = $stmt->rowCount();

 		$data = $stmt->fetchAll();

 		if ($count == 0){
 		// Fermer la connexion
        	$db = $bdd->fermer();
 			header ('location: ../OOps.php');
 			exit(0);
 		}

 		else{

 			foreach($data as $ligne){
        		$dateDex = $ligne['DATE_EXP'];
   			}

   			if ($dateDex > $dateDajd){
   							$msg = '<form method="POST" action="new.php" name="'.$action.'">';

   				            $msg .= '<div class="form-group">
                                <label for="pswd"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pswd" id="pswd" placeholder="Nouveau mot de passe"/>
                            </div>';

                            $msg .= '<div class="form-group">
                                <label for="pswd2"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pswd2" id="pswd2" placeholder="Ré nouveau mot de passe"/>
                            </div>';

                            $msg .= '<div class="form-group form-button">
                                <input type="button" onclick="Valider()" name="valider" id="valider" class="form-submit" value="Envoyer"/>
                            </div>';

                            $msg .= '<input type="hidden" name="email" id="email" value='.$mail.'>';

                            $msg .= '</form>';
   			}
   			else{
   				$msg = "<h2>Ce lien a expiré. Veuillez ré-essayer sur ce <a href ='localhost/PFE/forgot-password/reinitialiser-mot-de-passe.php'>lien</a> .</h2>";
   			}

 		}

	}catch (PDOException $e){
	// Fermer la connexion
        $db = $bdd->fermer();
 		header ('location: ../OOps.php');
 		exit(0);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../images/logo-udm.png">
    <title>Nouveau Mot de Passe</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="../fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="../css/style.css">

    <!--Javascript-->
    <script type = "text/javascript" src="../scripts/validations.js"></script>
</head>
<body>


    <div class="main">

          <h3 class="form-title"><a href="home/index.html"><img src="../images/back.png"><a/>&nbsp;&nbsp;&nbsp;&nbsp;RETOUR À L'ACCEUIL</h3>

         <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <h1 class="form-title">VOTRE NOUVEAU MOT DE PASSE</h1>
                        <figure><img src="../images/verif.png" alt="VERIF"></figure>
                    </div>
                    <div class="signin-form">
                        <p style="text-align: center;"><img alt="UDM Logo" src="../images/logo-udm.png"></p>

                        	<?php echo $msg; ?>

                        	<div id="erreur"><?php echo $erreur;?></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
