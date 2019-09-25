<?php

include_once '../classes/Config.php';

$currDate = date('Y-m-d');

// Convert the date string into a unix timestamp.
$unixTimestamp = strtotime($currDate);
 
// Get the day of the week using PHP's date function.
$dayOfWeek = date("l", $unixTimestamp);

    if ($dayOfWeek == "Monday"){
      $dayOfWeek = 'LUNDI';
    }
    elseif($dayOfWeek == "Tuesday"){
      $dayOfWeek = 'MARDI';
    }
    else if($dayOfWeek == "Wednesday"){
      $dayOfWeek = 'MERCREDI';
    }
    else if($dayOfWeek == "Thursday"){
      $dayOfWeek = 'JEUDI';
    }
    else if($dayOfWeek == "Friday"){
      $dayOfWeek = 'VENDREDI';
    }

  echo '<br>';
  echo '<br>';

echo '<h3 style="text-align: center">Aujourd\'hui : '.$dayOfWeek.' '.$currDate.' </h3>';

$currDate = date('Y-m-d');

$sql = "SELECT membres.NOM , membres.EMAIL, membres.PRENOM, rdv.* FROM `rdv`, `membres` WHERE rdv.ID_MEMBRE = membres.ID_MEMBRE AND DATE = '$currDate' ORDER BY DATE ASC";

try{

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    $data = $resultat->fetchAll();


  foreach($data as $ligne){

      $nom = $ligne['NOM'];
      $prenom = $ligne['PRENOM'];
      $email = $ligne['EMAIL'];
      $idrdv = $ligne['ID_RDV'];
      $idmem = $ligne['ID_MEMBRE'];
      $idserv = $ligne['ID_SERVICE'];
      $date = $ligne['DATE'];
      $hd = $ligne['HEURE_DEBUT'];
      $hf = $ligne['HEURE_FIN'];
      $des = $ligne['DESCRP'];
      $stat = $ligne['STATUT'];
      $ret = $ligne['RETOUR'];


      // Convertie les heures

      $hd = strtotime($hd);
      $debut = date('H:i', $hd);

      $hf = strtotime($hf);
      $fin = date('H:i', $hf);

  echo '<br>';
  echo '<br>';

       echo '<div class="container">';
       echo '<div class="card">';
       echo '<div style="text-transform: uppercase !important" class="card-header"><b>'.$nom.' '.$prenom.'&nbsp;//&nbsp;&nbsp;'.$idserv.'</b></div>';
       echo '<div class"card-body">';
       echo '<h5 class="card-title"></h5>';

       // Notification
       echo '<form action="notify.php" method="POST">';
       echo '<input type="hidden" name="hd" id="hd" value="'.$hd.'">';
       echo '<input type="hidden" name="hf" id="hf" value="'.$hf.'">';
       echo '<input type="hidden" name="mail" id="mail" value="'.$email.'">';
       echo '<p style="text-align: right">&nbsp;<button type="submit" data-toggle="tooltip" data-placement="top" title="Notifier L\'Étudiant" class="btn btn-outline-light">&nbsp;&#x1f514;&nbsp;</button>&nbsp;<button type="button" data-toggle="tooltip" data-placement="top" title="Sauvegarder le retour" class="btn btn-outline-light">&nbsp;&#128190;&nbsp;</button>&nbsp;</p>';
       echo '</form>';

       echo '<p style="text-transform: uppercase !important" class="card-text"><b>&nbsp;&nbsp;Horaire: </b>'.$debut.' à '.$fin.'</p>';

       echo '<p style="text-transform: uppercase !important" class="card-text"><b>&nbsp;&nbsp;Description de l\'Étudiant: </b>'.$des.'</p>';

       echo '<p style="text-align:right;text-transform: uppercase !important" class="card-text"><b>Retour du RDV&nbsp;&nbsp;&nbsp;&nbsp;</b></p>';
       echo '<p style="text-align:right"><textarea id="story" name="story" rows="1" cols="33">'.$ret.'</textarea>&nbsp;&nbsp;&nbsp;</p>';
       echo '<small style="text-align:right;font-style:italic" id="emailHelp" class="form-text text-muted">*Note: L\'îcone de sauvegarde se trouve à côté de celui de la clôche.&nbsp;&nbsp;</small>';

        if ($stat == "En Attente"){
           echo '<p style="text-align:center;">&nbsp;&nbsp;<button type="button" class="btn btn-warning" disabled>En Attente</button></p>';
        }

        else if($stat == "Termines"){
          echo '<p style="text-align:center;">&nbsp;&nbsp;<button type="button" class="btn btn-success" disabled>Archivé</button></p>';
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
    
    $db = $bdd->fermer();

}catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
}

?>