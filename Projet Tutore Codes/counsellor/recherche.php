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

$champ = $_POST['champ'];

$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$sql = "SELECT DISTINCT membres.ID_MEMBRE, membres.NOM, membres.PRENOM, membres.EMAIL, count(ID_RDV) AS NUM FROM membres, rdv where membres.NOM = '$champ' OR membres.PRENOM = '$champ' AND membres.ID_MEMBRE = rdv.ID_MEMBRE";

try{

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    $data = $resultat->fetchAll();

    $count = $resultat->rowCount();

    echo "<h2 style='text-align:center;'>Resultats de la recherche<br><br></h2>";

    foreach($data as $ligne){

    	$ID = $ligne['ID_MEMBRE'];
    	$nombre = $ligne['NUM'];
    	$prenom = $ligne['PRENOM'];
    	$nom = $ligne['NOM'];
    	$email = $ligne['EMAIL'];

    	if ($nombre == 0){
 			echo "<h2 style='text-align:center; font-size: 1.1em'>Il n'y a aucun étudiant de ce nom / prénom. Veuillez ré-essayer.</h2>";
 			exit(0);
 		}else{
 			echo "$space <a href='historique.php?id=".$ID."'><b>$nom $prenom &#128279;</b></a><br>";
 			echo "$space <b>Email</b>: $email<br>";
 			echo "$space <b>Nombre de rendez-vous:</b> $nombre<br>";
 			echo "<br>";
 			echo "<br>";
 		}
    }

    $db = $bdd->fermer();

  }catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    exit(0);
  }

?>