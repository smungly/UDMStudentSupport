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

if (!isset($_SESSION['type'])){
    header('Location: ../sign_in.html');
    exit(0);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title>Mon Calendrier</title>
<link rel="shortcut icon" type="image/x-icon" href="../images/logo-udm.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" />
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />

<style>

@font-face {
  font-family: BalsamiqSansRegular;
  src: url(../fonts/BalsamiqSansRegular.ttf);
}

@font-face {
  font-family: BalsamiqSansBold;
  src: url(../fonts/BalsamiqSansBold.ttf);
}

body {
  padding-top: 25px;
  font-size: 90% !important;    
}

h3{
  font: 1.5em BalsamiqSansRegular; 
}

#calendar {
  max-width: 800px;
}
h4{
  font: 1.5em BalsamiqSansRegular;  
}

h2{
  font: 1.5em BalsamiqSansBold; 
}

.col-centered{
    float: none;
    margin: 0 auto;
}

.vl {
  border-left: 1px solid black;
  height: 500px;
}

footer{
    position: fixed;
    float: left;
    bottom: 0;
    right: 10px;
}

a:link {
  text-decoration: none;
  color: black;
}

a:visited {
  text-decoration: none;
    color: black;
}

a:hover {
  text-decoration: none;
    color: black;
}

a:active {
  text-decoration: none;
    color: black;
}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
<script src='js/fullcalendar/locale/fr.js'></script>
<script>
   
$(document).ready(function() {

  var calendar = $('#calendar').fullCalendar({
      plugins: [ 'bootstrap' ],
      themeSystem: 'bootstrap4',
      editable:false,
      header:{
      left:'prev,next ',
      center:'title',
      right:'month,agendaWeek,agendaDay,listMonth'
    },

    events: 'charger.php',
    selectable:true,
    selectHelper:true,
    eventLimit: true,
    weekends: false,

    views: {
          month: {
          eventLimit: 4
        }
    },
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
</head>
<body>

<h3 style="text-align: right;" class="form-title"><a href="mes-rdv.php"><img src="../images/home.png">&nbsp;&nbsp;ACCEUIL&nbsp;&nbsp;&nbsp;<a/></h3>

<div class="col-lg-11 col-centered">
<h2>Calendrier</h2>
<h4>Vu d'ensemble de vos rendez-vous</h4>
</div>

<br>

<div class="container" id="col-centered">
   <div id="calendar" class="col-centered"></div>
</div>

<footer>
  <img src="../images/logo-udm.png" alt="UDM-LOGO">
</footer> 

</body>
</html>