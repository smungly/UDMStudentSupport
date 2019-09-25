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
$uname = $_SESSION["username"];

$sql = "SELECT * FROM `membres` WHERE UNAME = '$uname'";

try{

    $bdd = new Connect();

    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    $data = $resultat->fetchAll();

    foreach($data as $ligne){
        $id = $ligne['ID_MEMBRE'];
        $uname = $ligne['UNAME'];
    }

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
<title>Modifier Informations Utilisateur</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="css/profile_style.css">

 <!--Javascript-->
<script type = "text/javascript" src="scripts/valider_uname.js"></script>

</head>
<body>

<section class="retour">
</section>
		
<div class="container">

<div class="l">
  <h3 style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="main.php"><img src="images/arrow_back.png">&nbsp;&nbsp;&nbsp;&nbsp;ACCEUIL<a/></h3>
    <br>
</div>

	 <div class="col-lg-11 col-centered">
    <img src="images/lockk.png" alt="Lock">
    <br>
		<h2>Changer mes identifiants </h2>
		<p>Mot de Passe</p>
    <div id="valid"></div>
	 </div>

   <input type="text" class="form-control" id="identifiant" value="<?php echo $id; ?>" hidden> <!--ID_MEMBRE-->

	<form class="text-center border border-light p-5">
		<h2 style="text-align: right"><img src="images/key.png" alt="KEY" onmouseover='mouseoverPass();' onmouseout='mouseoutPass()';></img></h2>

  <div class="form-group">
      <label for="pswd">Votre Mot de Passe Actuel</label>
      <input type="password" class="form-control" id="pswd">
      <div style="text-align: left;" id="erreur1"></div>
  </div>

	<div class="form-group">
  		<div class="row">
    		<div class="col">
    			<label for="md1">Nouveau Mot de Passe</label>
     			 <input type="password" id="mdp1" class="form-control" required>
   			</div>

    		<div class="col">
    			<label for="mdp2">Re-Nouveau Mot de Passe</label>
      			<input type="password" id="mdp2" class="form-control" required>
    		</div>
       </div>

       <div style="text-align: center;" id="erreur2"></div>
    </div>
    	<br>
    	<br>
		 <button type="button" onclick="new_password()" class="btn btn-warning">Sauvegarder</button>
         <button type="button" onclick="retour()" class="btn btn-light">Annuler</button>  

	</form>

	 <div class="col-lg-11 col-centered">
	 	<br>
	 	<br>
		<p>Nom Utilisateur</p>
    <div id="valid2"></div>
	 </div>
	<form class="text-center border border-light p-5">
		<h2 style="text-align: right"><img src="images/prof.png" alt="PROFILE"></img></h2>

    <div class="form-group">
  		<div class="row">
    		<div class="col">
    			<label for="uname1">Votre Nom Utilisateur actuel</label>
     			<input type="text" id="uname1" class="form-control" readonly value='<?php echo $uname; ?>'>
   			</div>

    		<div class="col">
    			<label for="uname2">Nouveau Nom Utilisateur</label>
      			<input type="text" id="uname2" class="form-control" required>
             	<div style="text-align: left;" id="erreur2"></div>
    		</div>
       </div>
    </div>
    	<br>
    	<br>
		 <button type="button" onclick="new_uname()" class="btn btn-secondary">Sauvegarder</button>
         <button type="button" onclick="retour()" class="btn btn-light">Annuler</button>  

	</form>

</div>

<footer>
  <img src="images/logo-udm.png" alt="UDM-LOGO" >
</footer>  

</body>
</html>

<script type="text/javascript">

// Fonction pour rendre le mot de passe visible a l'utilisateur

    function mouseoverPass(obj) {
        var obj = document.getElementById('pswd');
        obj.type = "text";
    };

    function mouseoutPass(obj) {
        var obj = document.getElementById('pswd');
        obj.type = "password";
    };

</script>