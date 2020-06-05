<?php
$error = '';
require_once 'PDO.php';

$brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];

  $username=$_SESSION['bnavn'];
  $fnavn=$_SESSION['fnavn'];
  $enavn=$_SESSION['enavn'];

  include "./minmeny.php";

if(isset($_SESSION['pwReset']) === False)
{
    $user->redirect('default.php');
}

/* Password Reset Button*/
if(isset($_POST['passordKnapp']))
{
    $pw= $_POST['pass'];
    $npw = $_POST['pass2'];
    if($user->PassordReset($brukerid, $pw, $npw))
    {
        $user->redirect('logginn.php');
    }
    else{
        echo("Kunne ikke sette ny passord, kontakt administrator");
    }
}
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
    <div class ="row">
        <div class="card blue-grey darken-1">
        <!--  Password Reset form -->
            <form method="post">
                <h2>Logg Inn</h2><hr />
                <input type="password" name="pass1" placeholder="Passord" required />
                
                <input type="password"  name="pass2" placeholder=" Gjentar Passord" required />
                
                <button class="btn waves-effect waves-light" type="submit" name="passordKnapp">Reset Passord
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
    </div>
</div>
<footer class="background-color ">
<div class ="row">
<section class="col m6 s12 center-align">
<a href="">Om oss</a>
<a href="">Sidekart</a>
<a href="">Kariarre</a>
<a href="">Støtt oss</a>
<a href="">In English</a>
</section>
<section class="col m6 s12 center-align">Gruppe 30 | copyright 2019</section>
</footer>
						<?php
include "./includefooter.php";
?>
</body>
</html>