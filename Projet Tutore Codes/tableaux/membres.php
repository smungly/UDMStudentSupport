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

  $sql = "SELECT * FROM `membres`";

  try{

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    $data = $resultat->fetchAll();

     echo '<br><br>';
     echo '<div class="container">';
     echo '<h2>TABLEAU : MEMBRES</h2>';
     echo '<p>Ce tableau affiche toutes les informations sur un utilisateur.</p>';
     echo '<div class="table-responsive">';
     echo '<table class="table">';
     echo "<thead><tr><th>ID</th><th>Nom Utilisateur</th><th>Nom</th><th>Prenom</th><th>Sexe</th><th>DDN</th><th>Mail</th><th>MDP(Encrypte)</th><th>Ville</th><th>Adresse</th><th>Nationalite</th><th>Statut</th><th>Dept</th><th>Rejoint le</th></tr></thead>";

    foreach($data as $ligne){

      $id = $ligne['ID_MEMBRE'];
        $nom = $ligne['NOM'];
        $uname = $ligne['UNAME'];
        $prenom = $ligne['PRENOM'];
        $mdp = $ligne['MDP'];
        $stat = $ligne['STATUT'];
        $add = $ligne['ADRESSE'];
        $DateJoint = $ligne['CREATION_DATE'];
        $DDN = $ligne['DDN'];
        $Nationalite = $ligne['NATION'];
        $mail = $ligne['EMAIL'];
        $sexe = $ligne['SEXE'];
        $ville = $ligne['VILLE'];
        $dept = $ligne['DEPT'];

        echo "<tbody><tr><td>".$id."</td><td>".$uname."</td><td>".$nom."</td><td>".$prenom."</td><td>".$sexe."</td><td>".$DDN."</td><td>".$mail."</td><td>".$mdp."</td><td>".$ville."</td><td>".$add."</td><td>".$Nationalite."</td><td>".$stat."</td><td>".$dept."</td><td>".$DateJoint."</td></tr></tbody>";
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
