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

if (isset($_GET['verif'])){
	$cle = $_GET['verif'];

	try{
    // Instantiasiation
 	$bdd = new Connect();

    // Ouverture de la connexion.
 	$db = $bdd->ouvrir();

 	// Requete
 	$sql = "SELECT * FROM `membres` WHERE VERIF = '$cle' AND STATUT = 'Inactive' LIMIT 1";

 	$stmt = $db->prepare($sql);

 	// Verifie si les donnees sont entrer dans la base de donnee
 	$stmt->execute(
            array(
                'verif' => $cle
            )
    );

 	$count = $stmt->rowCount();

 	if ($count == 1){
 		$requete = "UPDATE `membres` SET STATUT = 'Actif' WHERE VERIF = '$cle'";
 		$message = "<br><h3 style='text-align: center'>Compte validé avec succès. Vous pouvez dés à présent vous connecter.</h3>";

        $rep = $db->prepare($requete);

        $rep = $db->exec($requete);    
 	}
 	else {
 		$message = "<br><h3 style='text-align: center'>Compte invalide ou déjà vérifié ! </h3>";
 	}

 }

 catch (PDOException $e){
 	header ('location: OOps.php');
	exit(0);
}
}
else{
	header ('location: OOps.php');
	exit(0);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="shortcut icon" type="image/x-icon" href="images/logo-udm.png">
    <title>UDM STUDENT SUPPORT: Page de Verification</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <!--Javascript-->
     <script type = "text/javascript" src="images/validat_sign.js"></script>
</head>
<body>

    <div class="main">

    <h3 class="form-title"><a href="index.html"><img src="images/back.png"><a/>&nbsp;&nbsp;&nbsp;&nbsp;ACCEUIL</h3>

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">

                <p style="text-align: center"><img src="images/logo-udm.png" alt="UDM LOGO"></p>

                <?php echo $message; ?>
                </div>
            </div>
        </section>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

<?php

// Fermer la connexion

    $db = $bdd->fermer();
    exit(0);

?>