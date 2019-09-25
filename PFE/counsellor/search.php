<?php

session_start();

if (!isset($_SESSION['type'])){
    header('Location: ../sign_in.html');
    exit(0);
}

/*
================================================

  Nom : Mungly Sydney
  Mail: sydneymungly15@gmail.com
  Description : Projet Tut.
  Date: Fevrier 2018

================================================
*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="shortcut icon" type="image/x-icon" href="../images/logo-udm.png">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/search_styles.css">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="js/recherche.js"></script>

<title>Recherche</title>
</head>
<body>

<br>
<br>
<h3 style="text-align: right;" class="form-title"><a href="mes-rdv.php"><img src="../images/home.png">&nbsp;&nbsp;ACCEUIL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a/></h3>

<div class="col-lg-11 col-centered">
<h2>&nbsp;&nbsp;Recherche</h2>
<h4>&nbsp;&nbsp;Faire la recherche d'une historique d'entrées sur un étudiant</h4>
</div>

<br>

<div class="container" id="col-centered">
<div class="card">
  <div class="card-body">
  		<form>
  		  <div class="form-group">
          	<input type="text" class="form-control" id="nom" aria-describedby="Help" placeholder="Recherche">
          	<small id="Help" class="form-text text-muted"><i>*Nom ou prénom(s) de l'étudiant</i></small>
          </div>

          <center><button type="button" onclick="searchres()" class="btn btn-outline-warning">Faire la recherche</button></center>

  		</form>
  </div>
</div>
</div>

<br>
<br>
<p style="text-align: left"><div id="results">
	
</div></p>

<footer>
  <img src="../images/logo-udm.png" alt="UDM-LOGO">
</footer> 
</body>
</html>
