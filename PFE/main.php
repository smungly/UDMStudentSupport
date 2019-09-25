<?php
// Initialiser la session
session_start();
?>
<?php
/*
================================================

	Nom : Mungly Sydney
	Mail: sydneymungly15@gmail.com
	Description : Projet Tut.
	Date: Fevrier 2018

================================================
*/

require_once "classes/Config.php";
 
// Verifie si l'utilisateur est connecte
if(!isset($_SESSION["username"]) || !isset($_SESSION["id"]) || $_SESSION["loggedin"] !== true){
    header("location: sign_in.html");
    exit;
}

$uname = $_SESSION["username"];

$sql = "SELECT PRENOM FROM `membres` WHERE UNAME = '{$uname}'";

try{

	 // Instantiasiation
    $bdd = new Connect();

    // Ouverture de la connexion
    $db = $bdd->ouvrir();

    $resultat = $db->prepare($sql);

    $resultat->execute();

    $res = $resultat->fetchColumn();

}catch (PDOException $e){
    echo "Oops. Nous avons eu un probleme. Ré-essayer plus tard.<br>";
    header('location: Oops.php');
    exit(0);
 }   

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title>UDM STUDENT SUPPORT: Bienvenu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="shortcut icon" type="image/x-icon" href="images/logo-udm.png">
<link rel="stylesheet" href="css/mainstyle.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>

<section class="top-">

  <div class="btn-group">
  <div class="btn-group dropleft" role="group">
    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="profile.php">mon profil</a>
       <a class="dropdown-item" href="modif-uname-mot-de-passe.php">mes identifiants</a>
       <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="deconnexion.php">déconnexion</a>
    </div>
  </div>
  <button type="button" class="btn btn-secondary">
    Menu
  </button>
</div>

</section>

<div class="contain">
  <h2 style="text-align: center">Bienvenu, <?php echo $res; ?></h2>
<div class="rangee">
  <div class="colonne">
    <div class="move-left">
     <a href="book/book.php"><img src="images/cal.png" alt="Calendrier"></a>
          <p style="text-align: center">PRENDRE UN RDV</p>
    <span>&nbsp;</span>
      </div>
  </div>

  <div class="colonne">
   <div class="move-right">
    <a href="mes-rdv.php"><img src="images/mesrdv.png" alt="Mes RDV"></a>
          <p style="text-align: center">MES RENDEZ-VOUS</p>
    </div>
  </div>
</div>
</div>

<footer>
  <img src="images/logo-udm.png" alt="UDM-LOGO" >
</footer>
</body>
</html>
