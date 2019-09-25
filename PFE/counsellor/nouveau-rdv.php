<?php

/*
================================================

  Nom : Mungly Sydney
  Mail: sydneymungly15@gmail.com
  Description : Projet Tut.
  Date: Fevrier 2018

================================================
*/
session_start();

require_once "../classes/Config.php";
 
// Verifie si l'utilisateur est connecte
if(!isset($_SESSION["username"]) || !isset($_SESSION["id"]) || $_SESSION["loggedin"] !== true){
    header("location: ../sign_in.html");
    exit;
}

$idmembre = $_SESSION["id"];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title>Prendre un RDV</title>
<link rel="shortcut icon" type="image/x-icon" href="../images/logo-udm.png">

<script src="js/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
<script src='js/fr.js'></script>
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/newrdv.css">

<script src="js/jquery-ui.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datepicker-fr.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="js/dates.js"></script>

<script>

function maFonc(){
  alert("Rendez-vous prit !");
  location.reload(); 
};
  
$( function() {
    $('#datepicker').datepicker( $.datepicker.regional['sv'] );
});

$(function() {
   $('#txtDate').datepicker({ 
       beforeShowDay: $.datepicker.noWeekends,
       minDate: 0 
   });
});

</script>

</head>
<body>

<p>&nbsp;&nbsp;</p>

<h3 style="text-align: right;" class="form-title"><a href="mes-rdv.php"><img src="../images/home.png">&nbsp;&nbsp;ACCEUIL&nbsp;&nbsp;&nbsp;<a/></h3>

<section style="padding-top: 20px;">
</section>

<div class="container">
      <h2>Nouveau RDV <img src="../images/new_appoint.png"></h2>
    <br>
<div class="row">
<div class="col">
<div style="float: left;width: 18rem;height: 30rem;padding-bottom: 10px" class="card">
  <div style="background-color: #eaeaea" class="card-body">
  	 <h5 style="text-align: center" class="card-title"><img src="../images/ca.png"></h5>
  	 <h5 style="text-align: center;/* font-size: 15px*/" class="card-title"></h5>
  	<form>
		  <div class="form-group">

          <div class="form-group">
            <label for="email">Mail de L'Etudiant</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="exemple@gmail.com">
            <small id="emailHelp" class="form-text text-muted"><i>*Il faut que l'Étudiant soit inscrit au service</i></small>
          </div>

    	  	<label for="txtDate">Date du RDV</label>
          	<input type="text" class="form-control" id="txtDate" aria-describedby="Date du rdv" placeholder="Date du rdv">
          </div>

        <div class="form-group">
    		  <label for="hd">Choisir l'heure</label>
    		  <select class="form-control" id="hd">
     			 <option value="09:00 AM">09:00</option>
      			 <option value="10:15 AM">10:15</option>
      			 <option value="01:30 PM">13:30</option>
      			 <option value="02:45 PM">14:45</option>
    		  </select>
  			</div>

      <div class="form-group">
            <input type="text" class="form-control" id="hf" hidden>
        </div>

  			 <div class="form-group">
   				 <label for="desc">Description</label>
    			 <textarea class="form-control" id="desc" rows="2"></textarea>
           <small id="desc" class="form-text text-muted"><i>*Description du rendez-vous.</i></small>
  			</div>

  			<div class="form-group">
    		  <label for="type">Choisir type de RDV</label>
    		  <select class="form-control" id="type">
     			 <option value="ETUD">Études (Durée: 60min)</option>
      			 <option value="CONS">Conseilles de tout types (Durée: 60min)</option>
      			 <option value="PERS">Personnelles (Durée: 60min)</option>
      			 <option value="AUTRE">Autre (Durée: 60min)</option>
    		  </select>
  		   </div>
    <div id="err"></div>
    <br>
		<p style="text-align: center"><button id="button" data-loading-text="Loading..." type="button" onclick="dates()" class="btn btn-secondary">Valider</button></p>
	</form>
  </div>
</div>
</div>
<div class="col">
  <div class="container">
    <div id="calendar" class="col-centered"></div> 
   </div>  
</div>
</div>

<footer>
  <img src="../images/logo-udm.png" alt="UDM-LOGO">
</footer> 

</body>
</html>

<script>
   
$(document).ready(function() {

  var calendar = $('#calendar').fullCalendar({
      plugins: [ 'bootstrap' ],
      defaultView: 'listWeek',
      themeSystem: 'bootstrap4',
      editable:false,
      /*header:{
      /*left:'prev,next ',
      center:'title',
      right:'listMonth'
    },*/

    events: 'charger.php',
    selectable:true,
    selectHelper:true,
    eventLimit: true,
    weekends: false,

    editable:false, /*Differentes couleurs par statut de l'évenement*/
    eventRender: function (event, element, view) {
      if (event.stat == 'Termines') {
          element.css('background-color', '#2EEB6DC')
      }
      else if(event.stat == 'En Attente'){
          element.css('background-color', '#FFCC33')
      }
      else if(event.stat == 'Confirmes'){
          element.css('background-color', '#3F25EC')
      }
      else if(event.stat == 'Annules'){
          element.css('background-color', '#E83636')
      }
    },
   });
  });
   
</script>