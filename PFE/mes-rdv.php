<?php

/*
================================================

  Nom : Mungly Sydney
  Mail: sydneymungly15@gmail.com
  Description : Projet Tut.
  Date: Fevrier 2018

================================================
*/

// Initialiser la session
session_start();

require_once "classes/Config.php";
 
// Verifie si l'utilisateur est connecte
if(!isset($_SESSION["username"]) || !isset($_SESSION["id"]) || $_SESSION["loggedin"] !== true){
    header("location: sign_in.html");
    exit;
}

$identifiant = $_SESSION['id'];
$dateAc = date('Y-m-d');

$sql = "SELECT * FROM `rdv` WHERE ID_MEMBRE = $identifiant ORDER BY DATE ASC";

echo '<section class="retour"></section>';
echo '<div class="container">';
echo '<div class="l">';
echo '<h3 style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="main.php"><img src="images/back.png"><a/>&nbsp;&nbsp;&nbsp;&nbsp;RETOUR</h3>';
echo '<br>';
echo '</div>';
echo '<div class="col-lg-11 col-centered">';
echo '<h2>Mes rendez-vous <img src="images/mes-rdv.png" alt="My appointments"></h2>';
echo '<h4>Informations sur mes rendez-vous</h4>';
echo '</div>';
echo '</div>';

try{

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    $data = $resultat->fetchAll();


    foreach($data as $ligne){

      $idrdv = $ligne['ID_RDV'];
      $idmem = $ligne['ID_MEMBRE'];
      $idserv = $ligne['ID_SERVICE'];
      $date = $ligne['DATE'];
      $hd = $ligne['HEURE_DEBUT'];
      $hf = $ligne['HEURE_FIN'];
      $des = $ligne['DESCRP'];
      $stat = $ligne['STATUT'];

       echo '<div class="container">';
       echo '<div class="card">';
       echo '<div class="card-header"><b>'.$date.'</b></div>';
       echo '<div class"card-body">';
       echo '<h5 class="card-title"></h5>';
       echo '<p class="card-text"><b>&nbsp;&nbsp;Heure Debut: </b>'.$hd.'</p>';
       echo '<p class="card-text"><b>&nbsp;&nbsp;Heure Fin: </b>'.$hf.'</p>';
       echo '<p class="card-text"><b>&nbsp;&nbsp;Description: </b>'.$des.'</p>';


        if ($date < $dateAc && $stat == "En Attente"){
          echo '<p style="text-align:center;">&nbsp;&nbsp;<button type="button" class="btn btn-dark" disabled>Expiré</button></p>'; 
        }

        else if ($stat == "En Attente"){
           echo '<p style="text-align:center;">&nbsp;&nbsp;<button type="button" class="btn btn-warning" disabled>En Attente</button></p>';
        }

        else if($stat == "Termines"){
          echo '<p style="text-align:center;">&nbsp;&nbsp;<button type="button" class="btn btn-success" disabled>Terminé</button></p>';
        }

        else if($stat == "Confirmes"){
          echo '<p style="text-align:center;">&nbsp;&nbsp;<button type="button" class="btn btn-primary" disabled>Confirmé</button></p>';
        }

        else if($stat == "Annules"){
         echo '<p style="text-align:center;">&nbsp;&nbsp;<button type="button" class="btn btn-danger" disabled>Annulé</button></p>';
        }

      
      echo '</div>'; 
      echo '</div>';
      echo '</div>';
      echo '<br>';
      echo '<br>';
    }

  echo '<br>';
  echo '<br>';
  echo '<footer>';
  echo '<img src="images/logo-udm.png" alt="UDM-LOGO">';
  echo '</footer>';  
    
    $db = $bdd->fermer();

}catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
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
<title>Mes rendez-vous</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/mrdv_style.css">

</head>
<body> 
</body>
</html>