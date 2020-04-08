<?php
$error = '';
require_once 'PDO.php';

$Brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];

if($user->is_loggedin()=="")
{
  $user->redirect('Default.php');
} 
else 
{ 
  $username=$_SESSION['bnavn'];
}
if(isset($_POST['btn-logout']))
{
    if($user->logout())
    {
    $user->redirect('Default.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset ="UTF-8">
    <link rel="stylesheet" href="FellesCSS.css">
    <title>Ny melding</title>
</head>
<body>

    <div class="container1">
        <h1 class="meldinger-tittel">Ny melding</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            <div class="main-content">
                <form action="" method="POST">
                    <h2 class="nymeldtit">Tittel</h2>
                    <textarea name="tittel" id="meldingtittel" cols="50" rows="2"></textarea>
                    <h2 class="nymeldtit">Tekst</h2>
                    <textarea name="tekst" id="meldingtekst" cols="50" rows="8"></textarea>
                    <h2 class="nymeldtit">Mottaker</h2>
                        <select name="mottakermeny">
                        <?php 
                            $mysqli = new mysqli("localhost", "root", "", "klima");
                            //Henter ut en liste av alle brukere utenom den som er logget inn
                            $sql = "SELECT idbruker, brukernavn FROM bruker EXCEPT SELECT idbruker, brukernavn FROM bruker WHERE idbruker = '{$brukerid}'";
                            $result = $mysqli->query($sql);
                            if ($result) {
                              while($row = mysqli_fetch_array($result)) {
                                echo "<option value='",$row['brukernavn'],"'>",$row['brukernavn'],"</option>";
                              }
                            }
                            else {
                              echo mysql_error();
                            }
                             
                            //Variabler og sql for å sende melding til databasen
                            $meldingtittel = "meldingtittel";
                            $meldingtekst = "meldingtekst";
                            $datetime = date("Y-m-d H:i:s");
                            $input = '5';
                            $user->nyMelding($meldingtittel, $meldingtekst, $datetime, $brukerid, $input);
                        
                        ?>
                        </select>
                    </div>
                    <div class="sendmeld">
                    <input type="submit" name="sendmelding">
                        
                    </input>
                    </div>
                </form>
                <a href="Meldinger.php">Tilbake til alle meldinger</a>
            </div>
        </div>
    </section>
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
