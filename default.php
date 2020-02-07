<?php
require_once "PDO.php";
session_start();
if($user->is_loggedin()==True)
{
    $user->redirect('Backend.php');
} 


?>

<html>
	<head>
	<meta charset ="UTF-8">
	<title> Klima</title>
	<link rel="stylesheet" type="text/css" href="FellesCSS.css">	
	</head>

<body>
    <header class="hovedheader">

        <a href="default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:80px;"></img></a>

        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="logginn.php">Login</a></li>
            <li><a href="registrer.php">Registrer</a></li>
        </ul>   
    </header>
  
      <section id="showcase">
      <div class="container">
	  <div class="bildetekst">
        <h1>Klima</h1>
        <p>Klimadebatten pågår, la oss redde verden!</p>
		</div>
      </div>
    </section>
		
	<section id="tekst">
	<div class="container">
          <article>
          <h3>Klima</h3>
          <p>
          Velkommen til våre organisasjons nettsted.
        Vi på Klima skal servere som en mellomledd mellom eksperter, redaktører og den generelle befolkningen for å forstå klimakrisen og finne tiltak på å løse den.
        Personer kan lage kontoer for å ha diskusjoner, sette opp arrangementer og sende meldinger mellom hverandre. Vi har også redaktører satt opp av klimaeksparter
        og klimaamatører som publiserer interesante og informative artikkler. Våre redaktører deler også bra informasjonskilder for generell kunnskap og for å informere andre
        om klimaeendring. Ta kontakt med våre administratorer hvis du ønsker å være en redaktør
          </p>
		  </article>
     
	       <article>
		  <img class="bilde" src="img/iceberg.jpg" alt="">
	
		</article>
   </section>
  </div>

  
      <footer class="hovedfooter">
        <section class="lenker_footer">
        <a href="">Om oss</a>
        <a href="">Sidekart</a>
        <a href="">Kariarre</a>
        <a href="">Støtt oss</a>
        <a href="">In English</a>
        </section>
        <section class="copyright">Gruppe 30 | copyright 2019 - <?php echo date("Y"); ?>
</section>
      </footer>
  </body>
</html>
