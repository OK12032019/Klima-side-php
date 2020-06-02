<?php
$error = '';
require_once 'PDO.php';

$Brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];

if($user->is_loggedin()=="")
{
  $user->redirect('default.php');
} 
else 
{ 
  $username=$_SESSION['bnavn'];
}
if(isset($_POST['btn-logout']))
{
    if($user->logout())
    {
    $user->redirect('default.php');
    }
    else
    {
    $error = "Kunne ikke logge ut";
    } 
}
include "./minmeny.php";
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
    <title>Ny melding</title>
</head>
<body>

    <div class="container1">
        <h1 class="meldinger-tittel">Ny melding</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            <div class="main-content">
                <form method="POST">
                    <h2 class="nymeldtit">Tittel</h2>
                    <textarea name="tittel" id="meldingtittel" cols="50" rows="2" maxlength="45"></textarea>
                    <h2 class="nymeldtit">Tekst</h2>
                    <textarea name="tekst" id="meldingtekst" cols="50" rows="8" maxlength="1024"></textarea>
                    <h2 class="nymeldtit">Mottaker</h2>
                        <select name="mottakermeny">
                        <?php 
                            //Ny Metode
                            $result = $user->getBrukerlisteMeld($brukerid);
                            if ($result) {
                              foreach($result as $row) {
                                echo "<option value='",$row['idbruker'],"'>",$row['brukernavn'],"</option>";
                              }
                            }
                            else {
                              echo mysql_error();
                            }
                            $mottaker = $_POST["mottakermeny"];
                        ?>
                        </select>
                    </div>
                    <div class="sendmeld">
                    <input type="submit" class="btn btn-block btn-primary" name="Sendmelding">
                    </input>
                    </div>
                </form>
                
                <a href="meldinger.php">Tilbake til alle meldinger</a>
            </div>
        </div>
    </section>

    <?php
    if(isset($_POST['Sendmelding']))
    {
      //Variabler og sql for å sende melding til databasen
      $meldingtittel = trim($_POST["tittel"]);
      $meldingtekst = trim($_POST["tekst"]);
      $datetime = date("Y-m-d H:i:s");
      $user->nyMelding($meldingtittel, $meldingtekst, $datetime, $brukerid, $mottaker);
    }
      
    ?>

    <footer class="hovedfooter">
            <section class="lenker_footer">
            <a href="">Om oss</a>
            <a href="">Sidekart</a>
            <a href="">Kariarre</a>
            <a href="">Støtt oss</a>
            <a href="">In English</a>
            </section>
            <section class="copyright">Gruppe 30 | copyright 2019</section>
    </footer>
</body>
</html>
