<?php

/*
================================================

	Nom : Mungly Sydney
	Mail: sydneymungly15@gmail.com
	Description : Projet Tut.
	Date: Fevrier 2018

================================================
*/

$connect = new PDO('mysql:host=localhost;dbname=pfe', 'root', '');

$data = array();

$query = "SELECT DISTINCT membres.NOM, membres.PRENOM, rdv.* FROM `rdv`, `membres` WHERE rdv.STATUT != 'Annules' AND rdv.ID_MEMBRE = membres.ID_MEMBRE ORDER BY DATE ASC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["ID_RDV"],
  'stat' => $row["STATUT"],
  'description' => $row["DESCRP"],
  'title'   => "Reservé/Indisponible",
  'start'   => $row["DATE"].' '.$row["HEURE_DEBUT"],
  'end'   => $row["DATE"].' '.$row["HEURE_FIN"]
 );
}

	echo json_encode($data);
?>