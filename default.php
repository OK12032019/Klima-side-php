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
		  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
