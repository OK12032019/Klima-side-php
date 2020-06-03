<?php
require_once "PDO.php";

if($user->is_loggedin()==True)
{
    $user->redirect('backend.php');
} 
else
{
  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
}

include "./minmeny.php";
include "./includefooter.php"; 
?>

<!DOCTYPE HTML>
<html>
	<head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <link type="text/css" rel="stylesheet" href="css/Flat.css"  media="screen,projection"/>	

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
	<meta charset ="UTF-8">
	<title> Klima</title>
		
	</head>

<body>
<div class="container">
  <div class="center-align">
    <h1>Klima</h1>
    <p>Klimadebatten pågår, la oss redde verden!</p>

  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-image">
          <img src="img/iceberg.jpg">
          <span class="card-title">Klima</span>
          </div>
          <div class="card-content">
          <p>
          Velkommen til våre organisasjons nettsted.
          Vi på Klima skal servere som en mellomledd mellom eksperter, redaktører og den generelle befolkningen for å forstå klimakrisen og finne tiltak på å løse den.
          Personer kan lage kontoer for å ha diskusjoner, sette opp arrangementer og sende meldinger mellom hverandre. Vi har også redaktører satt opp av klimaeksparter
          og klimaamatører som publiserer interesante og informative artikkler. Våre redaktører deler også bra informasjonskilder for generell kunnskap og for å informere andre
          om klimaeendring. Ta kontakt med våre administratorer hvis du ønsker å være en redaktør</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>


  

      </div>
</div>
  </body>
</html>
