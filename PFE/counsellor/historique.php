<?php

/*
================================================

  Nom : Mungly Sydney
  Mail: sydneymungly15@gmail.com
  Description : Projet Tut.
  Date: Fevrier 2018

================================================
*/

include_once '../classes/Config.php';

session_start();

if (!isset($_SESSION['type'])){
    header('Location: ../sign_in.html');
    exit(0);
}

$ID_MEMBRE = $_GET['id'];
$ID_MEMBRE = (int)$ID_MEMBRE;

$requete = "SELECT membres.NOM, membres.PRENOM FROM membres, rdv WHERE membres.ID_MEMBRE = $ID_MEMBRE AND rdv.STATUT = 'Termines' OR rdv.STATUT = 'Confirmes' AND membres.ID_MEMBRE = $ID_MEMBRE AND rdv.ID_MEMBRE = $ID_MEMBRE";

  try{

        $bdd = new Connect();

        $db = $bdd->ouvrir();

        $resultat = $db->prepare($requete);

        $resultat->execute();

        $res = $resultat->fetch(PDO::FETCH_ASSOC);

        $nom = $res['NOM'];
        $prenom = $res['PRENOM'];

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

<link rel="shortcut icon" type="image/x-icon" href="../images/logo-udm.png">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/couns_style.css">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<title>Historique d'un Étudiant</title>

</head>
<body>

<br>
<br>
<h3 style="text-align: right;" class="form-title"><a href="mes-rdv.php"><img src="../images/home.png">&nbsp;&nbsp;ACCEUIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a/></h3>

<div class="col-lg-11 col-centered">
<h2>&nbsp;&nbsp;Historique</h2>
<h4>&nbsp;&nbsp;Historique d'entrées sur un étudiant</h4>
</div>

<br>

<div class="container">
<div class="card">
  <div class="card-body">

<?php 

    	$sql = "SELECT membres.NOM, membres.PRENOM, rdv.DATE, rdv.RETOUR, rdv.ID_SERVICE FROM membres, rdv WHERE membres.ID_MEMBRE = $ID_MEMBRE AND rdv.STATUT = 'Termines' OR rdv.STATUT = 'Confirmes' AND membres.ID_MEMBRE = $ID_MEMBRE AND rdv.ID_MEMBRE = $ID_MEMBRE ORDER BY DATE ASC";

    	try{

    		$bdd = new Connect();

    		$db = $bdd->ouvrir();

    		$resultat = $db->prepare($sql);

    		$resultat->execute();

    		$data = $resultat->fetchAll();

    		echo '<br><br>';
    		echo '<h5 class="card-subtitle mb-2 text-muted">&nbsp;&nbsp;&nbsp;&nbsp;'.$nom.' '.$prenom.'</h5>';
    		echo '<br><br>';

        echo '<table class="table">';
        echo  '<thead><tr>
          <th scope="col">Date</th>
          <th scope="col">Retour</th>
          <th scope="col">Service</th>
          </tr></thead>';

    		foreach($data as $ligne){

    			$date = $ligne['DATE'];
    			$retour = $ligne['RETOUR'];
          $service = $ligne['ID_SERVICE'];

          echo '<tbody><tr><td>'.$date.'</td><td>'.$retour.'</td><td>'.$service.'</td></tr></tbody>';
    		}

        $db = $bdd->fermer();

  		}catch (PDOException $e){
    		echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
   			exit(0);
  		}
?>

  </div>
</div>
</div>

<footer>
  <img src="../images/logo-udm.png" alt="UDM-LOGO">
</footer> 
</body>
</html>