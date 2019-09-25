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

	$sql = "SELECT DISTINCT membres.EMAIL,membres.ID_MEMBRE,membres.NOM, membres.PRENOM, rdv.* FROM membres, rdv WHERE rdv.ID_MEMBRE = membres.ID_MEMBRE AND rdv.STATUT = 'Termines' ORDER BY rdv.DATE ASC";

  $error = "";

	try{

		$bdd = new Connect();

    	$db = $bdd->ouvrir();

    	$resultat = $db->prepare($sql);

    	$resultat->execute();

    	$data = $resultat->fetchAll();

    	echo '<br>';
        echo '<br>';

    	foreach($data as $ligne){

    		$email = $ligne['EMAIL'];
    		$idmem = $ligne['ID_MEMBRE'];
    		$nom = $ligne['NOM'];
    		$prenom = $ligne['PRENOM'];
      	$idrdv = $ligne['ID_RDV'];
      	$idmem = $ligne['ID_MEMBRE'];
     		$idserv = $ligne['ID_SERVICE'];
      	$date = $ligne['DATE'];
      	$hd = $ligne['HEURE_DEBUT'];
     		$hf = $ligne['HEURE_FIN'];
      	$des = $ligne['DESCRP'];
      	$stat = $ligne['STATUT'];

    //Convert the date string into a unix timestamp.
    $unixTimestamp = strtotime($date);
 
    //Get the day of the week using PHP's date function.
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


     		echo '<div class="container">';
     		echo  '<div class="card">';
  					echo '<h5 class="card-header"><b> '.$nom.' '.$prenom.' // '.$idserv.' </b></h5>';
  					echo '<div class="card-body">';
  					echo '<form method="POST" action="modif.php">';

  							echo '<input type="hidden" id="id_rdv" name="id_rdv" value='.$idrdv.'>';
  							echo '<input type="hidden" id="id_etud" name="id_etud" value='.$idmem.'>';
  							echo '<input type="hidden" id="email" name="email" value='.$email.'>';

  							echo '<div class="form-group">';
                echo '<b>'.$dayOfWeek.'</b>';
  							echo '<input type="date" id="date" name="date" value='.$date.' readonly>';
  							echo '</div>';

  							 echo '<div class="form-group">';
                 echo '<label for="Debut">Heure de debut</label>';
  								echo '<select id="Debut" name="Debut" class="form-control" disabled>';

  									if ($hd == "09:00:00"){
  									echo '<option value="09:00" selected>09:00</option>';
  									echo '<option value="10:15">10:15</option>';
										echo '<option value="13:30">13:30</option>';
										echo '<option value="14:45">14:45</option>';
  									}
  									else if ($hd == "10:15:00"){
                    echo '<option value="09:00" >09:00</option>';
                    echo '<option value="10:15" selected>10:15</option>';
                    echo '<option value="13:30">13:30</option>';
                    echo '<option value="14:45">14:45</option>';
  									}
  									else if($hd == "13:30:00"){
                    echo '<option value="09:00" >09:00</option>';
                    echo '<option value="10:15" >10:15</option>';
                    echo '<option value="13:30"selected>13:30</option>';
                    echo '<option value="14:45">14:45</option>';
  									}
  									else if($hd == "14:45:00"){
                    echo '<option value="09:00" >09:00</option>';
                    echo '<option value="10:15">10:15</option>';
                    echo '<option value="13:30">13:30</option>';
                    echo '<option value="14:45" selected>14:45</option>';
  									}
								echo '</select>';
							 echo '</div>';

							  echo '<div class="form-group">';
                 echo '<label for="Fin">Heure de fin</label>';
  								echo '<select id="Fin" name="Fin" class="form-control" disabled>';

                  if ($hf == "10:00:00"){
                    echo '<option value="10:00" selected>10:00</option>';
                    echo '<option value="11:15">11:15</option>';
                    echo '<option value="14:30">14:30</option>';
                    echo '<option value="15:45">15:45</option>';
                    }
                    else if ($hf == "11:15:00"){
                    echo '<option value="10:00">10:00</option>';
                    echo '<option value="11:15" selected>11:15</option>';
                    echo '<option value="14:30">14:30</option>';
                    echo '<option value="15:45">15:45</option>';
                    }
                    else if($hf == "14:30:00"){
                    echo '<option value="10:00">10:00</option>';
                    echo '<option value="11:15">11:15</option>';
                    echo '<option value="14:30" selected>14:30</option>';
                    echo '<option value="15:45">15:45</option>';
                    }
                    else if($hf == "15:45:00"){
                    echo '<option value="10:00">10:00</option>';
                    echo '<option value="11:15">11:45</option>';
                    echo '<option value="14:30">14:30</option>';
                    echo '<option value="15:45" selected>15:45</option>';
                    }

							 echo '</select>';
							 echo '</div>';

  								echo '<div class="input-group">';
  									echo '<div class="input-group-prepend">';
    								echo '<span class="input-group-text">Desciption</span>';
  								echo '</div>';
  									echo '<textarea style="height: 55px;" class="form-control" id="des" aria-label="Description de l\'Étudiant" readonly>'.$des.'</textarea>';
								echo '</div>';

								echo '<br>';
							 echo '</div>';
							 echo '<br>';

               echo '<span class="error"><?php echo '.$error.'; ?></span>';

  					echo  '</form>';
 					echo '</div>';
					echo '</div>';
     		echo '</div>';
     		echo '<br>';
      		echo '<br>';
  		}

  	  echo '<br>';
      echo '<br>';

	}catch (PDOException $e){
    	echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    	exit(0);
	}

?>
