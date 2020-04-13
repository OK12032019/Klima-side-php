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
    <title>Brukerrapport</title>
</head>
<body>

    <div class="container1">
        <h1 class="meldinger-tittel">Brukerrapport</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
        <form action="" method="POST">
            <div class="main-content">
                <div class="meldinger">
                    <h2 class="nymeldtit">Regler</h2>
                    <!-- liste av regler -->
                    <p>Rapportert bruker: 
                        <select name="mottakermeny">
                        <?php 
                        //Virker ikke, finn ut hvorfor
                            /*$mysqli = new mysqli("localhost", "root", "", "klima");
                            //Henter ut en liste av alle brukere utenom den som er logget inn
                            $sql = "SELECT idbruker, brukernavn FROM bruker WHERE brukertype=3 EXCEPT SELECT idbruker, brukernavn FROM bruker WHERE idbruker = '{$brukerid}'";
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
                            $rapporttekst = "rapporttekst";
                            $datetime = date("Y-m-d H:i:s");
                            $input = '5';
                            $user->nyRapport($rapporttekst, $datetime, $input, $brukerid);
                        */
                        ?>
                        </select>
                    </p>
                    <p>Vennligst skriv i rapporten hvilken regel(eller regler) brukeren brudde i følge deg, så vil en av våre administratorer håndtere saken.<p>
                    <h2 class="nymeldtit">Rapport Tekst</h2>
                    <textarea name="tekst" id="rapporttekst" cols="50" rows="8"></textarea>
                    <div class="sendmeld">
                    <!-- bytt om til en submit knapp for å lage rapport, ikke melding-->
                    <input type="submit" name="sendmelding">
                    </input>
                    </div>
                    <!--På toppen ha liste av regler, med scrollbar slik at det er ikke for langt liste.
                    Under det, inntastingsboks for å beskrive regelbruddet.
                    Under det ha et knapp for å sende rapport. Teksten må være mindre enn 1024 tegn-->
                </div>
            </div> 
            </form>   
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
