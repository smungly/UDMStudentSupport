<?php

/*
================================================

	Nom : Mungly Sydney
	Mail: sydneymungly15@gmail.com
	Description : Projet Tut.
	Date: Fevrier 2018

================================================
*/

include '../classes/Config.php';

$sql = "SELECT * FROM rdv";

  try{

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    $data = $resultat->fetchAll();

     echo '<br><br>';
     echo '<div class="container">';
     echo '<h2>TABLEAU : RENDEZ-VOUS</h2>';
     echo '<p>Ce tableau affiche toutes les informations sur un rendez-vous.</p>';
     echo '<div class="table-responsive">';
     echo '<table class="table">';
     echo "<thead><tr><th>ID-RDV</th><th>ID-MEMBRE</th><th>ID-SERVICE</th><th>Date</th><th>HD</th><th>HF</th><th>Description</th><th>STATUT</th></tr></thead>";

    foreach($data as $ligne){

    	$idrdv = $ligne['ID_RDV'];
    	$idmem = $ligne['ID_MEMBRE'];
    	$idserv = $ligne['ID_SERVICE'];
    	$date = $ligne['DATE'];
    	$hd = $ligne['HEURE_DEBUT'];
    	$hf = $ligne['HEURE_FIN'];
    	$des = $ligne['DESCRP'];
    	$stat = $ligne['STATUT'];

        echo "<tbody><tr><td>".$idrdv."</td><td>".$idmem."</td><td>".$idserv."</td><td>".$date."</td><td>".$hd."</td><td>".$hf."</td><td>".$des."</td><td>".$stat."</td></tr></tbody>";
    }

    echo '</table>';
    echo '</div>';
    echo '</div>';

    
    $db = $bdd->fermer();

  }catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
  }

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
</body>
</html>