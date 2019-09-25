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
        $nom = $ligne['NOM'];
        $prenom = $ligne['PRENOM'];
        $stat = $ligne['STATUT'];
        $add = $ligne['ADRESSE'];
        $uname = $ligne['UNAME'];
        $DateJoint = $ligne['CREATION_DATE'];
        $DDN = $ligne['DDN'];
        $tel = $ligne['TELEPHONE'];
        $Nationalite = $ligne['NATION'];
        $mail = $ligne['EMAIL'];
        $sexe = $ligne['SEXE'];
        $ville = $ligne['VILLE'];
        $dept = $ligne['DEPT'];
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
<title>Informations Utilisateur</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="css/profile_style.css">

<!--Javascript-->
<script type = "text/javascript" src="scripts/valider_infos.js"></script>

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
		<h2>Mon profil</h2>
		<p>Informations personnelles, telles que votre nom et votre location.</p>
    <div id="valid"></div>
	 </div>

	 	<form class="text-center border border-light p-5">
	 	  	<h2 style="text-align: left;"><img src="images/stuudent.png" alt="Mon Profil"></h2>

    <div class="form-group">
      <input type="text" class="form-control" id="identifiant" readonly value='<?php echo $id; ?>' hidden>
  </div>

    <div class="form-group">
  		<div class="row">
    		<div class="col">
    			<label for="nom">Nom</label>
     			 <input type="text" id="nom" class="form-control" placeholder="Nom" value='<?php echo $nom; ?>'>
            <div style="text-align: left;" id="errNom"></div>
   			</div>

    		<div class="col">
    			<label for="prenom">Prénom (s)</label>
      			 <input type="text" id="prenom" class="form-control" placeholder="Prenom" value='<?php echo $prenom; ?>'>
             <div style="text-align: left;" id="errPre"></div>
    		</div>
       </div>
    </div>

    <div class="form-group">
      <label for="ddn">Date de Naissance</label>
      <input type="text" class="form-control" id="ddn" readonly value='<?php echo $DDN; ?>'>
  </div>

    <div class="form-group">
      <label for="sexe">Sexe</label>
      <select id="sexe" class="form-control">
          <?php
            if ($sexe == 'H'){
              echo "<option value='H' selected>Homme</option>";
              echo "<option value='F'>Femme</option>";
            }
            else if($sexe == 'F'){
              echo "<option value='H'>Homme</option>";
              echo "<option value='F' selected>Femme</option>";
            }
            else{
              echo "<option value='H'>Homme</option>";
              echo "<option value='F' selected>Femme</option>";
            }
          ?>
      </select>
     </div>

   <div class="form-group">
      <label for="dept">Département</label>
      <input type="text" class="form-control" id="dept" readonly value='<?php echo $dept; ?>' readonly>
  </div>

    </form>

    <br>

<form class="text-center border border-light p-5">

    <h2 style="text-align: left;"><img src="images/loc.png" alt="Ma Location"></h2>

    <div class="form-group">
      <label for="ville">Ville</label>
      <select id="ville" class="form-control">
        <?php
          if ($ville == 'BB-RH'){
            echo "<option value='BB-RH' selected>Beau-Bassin/Rose-Hill</option>";
            echo "<option value='CPE'>Curepipe</option>";
            echo "<option value='PL'>Port-Louis</option>";
            echo "<option value='MOK'>Moka</option>";
            echo "<option value='QB'>Quatres-Bornes</option>";
            echo "<option value='VP'>Vacoas-Phoenix</option>";
          }
          else if ($ville == 'CPE'){
            echo "<option value='BB-RH'>Beau-Bassin/Rose-Hill</option>";
            echo "<option value='CPE' selected>Curepipe</option>";
            echo "<option value='PL'>Port-Louis</option>";
            echo "<option value='MOK'>Moka</option>";
            echo "<option value='QB'>Quatres-Bornes</option>";
            echo "<option value='VP'>Vacoas-Phoenix</option>";
          }
          else if ($ville == 'PL'){
            echo "<option value='BB-RH'>Beau-Bassin/Rose-Hill</option>";
            echo "<option value='CPE'>Curepipe</option>";
            echo "<option value='PL' selected>Port-Louis</option>";
            echo "<option value='MOK'>Moka</option>";
            echo "<option value='QB'>Quatres-Bornes</option>";
            echo "<option value='VP'>Vacoas-Phoenix</option>";
          }
          else if ($ville == 'MOK'){
            echo "<option value='BB-RH'>Beau-Bassin/Rose-Hill</option>";
            echo "<option value='CPE'>Curepipe</option>";
            echo "<option value='PL'>Port-Louis</option>";
            echo "<option value='MOK' selected>Moka</option>";
            echo "<option value='QB'>Quatres-Bornes</option>";
            echo "<option value='VP'>Vacoas-Phoenix</option>";
          }
          else if ($ville == 'QB'){
            echo "<option value='BB-RH'>Beau-Bassin/Rose-Hill</option>";
            echo "<option value='CPE'>Curepipe</option>";
            echo "<option value='PL'>Port-Louis</option>";
            echo "<option value='MOK'>Moka</option>";
            echo "<option value='QB' selected>Quatres-Bornes</option>";
            echo "<option value='VP'>Vacoas-Phoenix</option>";
          }
          else if ($ville == 'VP'){
            echo "<option value='BB-RH'>Beau-Bassin/Rose-Hill</option>";
            echo "<option value='CPE'>Curepipe</option>";
            echo "<option value='PL'>Port-Louis</option>";
            echo "<option value='MOK'>Moka</option>";
            echo "<option value='QB'>Quatres-Bornes</option>";
            echo "<option value='VP' selected>Vacoas-Phoenix</option>";            
          }
          else{
            echo "<option value='BB-RH'>Beau-Bassin/Rose-Hill</option>";
            echo "<option value='CPE'>Curepipe</option>";
            echo "<option value='PL' selected>Port-Louis</option>";
            echo "<option value='MOK'>Moka</option>";
            echo "<option value='QB'>Quatres-Bornes</option>";
            echo "<option value='VP'>Vacoas-Phoenix</option>";             
          }
        ?>
      </select>
     </div>

  <div class="form-group">
      <label for="adresse">Adresse</label>
      <input type="text" class="form-control" id="adresse" value='<?php echo $add; ?>'>
      <div style="text-align: left;" id="errAdd"></div>
  </div>

		</form>

        <br>

    <form class="text-center border border-light p-5">
      <h2 style="text-align: left;"><img src="images/lock.png" alt="Mes identifiants"></h2>
      <p style="font-size: 20px">*Certaines informations (mot de passe et nom utilisateur) ne peuvent être modifiées <a href="modif-uname-mot-de-passe.php">ici</a> seulement.</p>

  <div class="form-group">
      <label for="email">Email</label>
      <input type="text" class="form-control" id="email" value='<?php echo $mail; ?>'>
      <div style="text-align: left;" id="errMail"></div>
  </div>

   <div class="form-group">
      <label for="uname">Nom Utilisateur</label>
      <input type="text" class="form-control" id="uname" readonly value='<?php echo $uname; ?>'>
  </div>

    <div class="form-group">
      <label for="tel">Telephone</label>
      <input type="text" class="form-control" id="tel" value='<?php echo $tel; ?>' maxlength="13">
      <div style="text-align: left;" id="errTel"></div>
  </div>

  <div class="form-group">
      <label for="pswd">Mot de Passe</label>
      <input type="password" class="form-control" id="pswd" value="default" readonly>
  </div>

         <button type="button" onclick="valider()" class="btn btn-info">Sauvegarder</button>
         <button type="button" onclick="retour()" class="btn btn-dark">Annuler</button>  

    </form>

	</div>
    </div> 

<footer>
  <img src="images/logo-udm.png" alt="UDM-LOGO" >
</footer>     

</body>
</html>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#image").change(function(){
        readURL(this);
    });
</script>