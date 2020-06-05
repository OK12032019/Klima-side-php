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
    <title>Brukerrapport</title>
</head>
<body>

    <div class="container1">
        <h1 class="meldinger-tittel">Brukerrapport</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
        <form method="POST">
            <div class="main-content">
                <div class="meldinger">
                    <h2 class="nymeldtit">Regler</h2>
                    <ul>
                    <?php
                      //php for å hente ut en liste av regler, skrevet ut som <li>-tagger
                      $mysqli = new mysqli("localhost", "root", "", "klima");
                      mysqli_set_charset($mysqli,'utf8');
                      $sql = "SELECT regeltekst FROM regel";
                      $result = $mysqli->query($sql);
                      if ($result) {
                        while($row = mysqli_fetch_array($result)) {
                          echo "<li>",$row['regeltekst'],"</li>";
                        }
                      }
                      else {
                        echo mysql_error();
                      }
                    ?>
                    </ul>
                    <p>Rapportert bruker: 
                        <select name="rapportvalg">
                        <?php
                            //Henter ut en liste av alle brukere utenom den som er logget inn
                            $sql = "SELECT idbruker, brukernavn FROM bruker WHERE brukertype=3||brukertype=2  EXCEPT SELECT idbruker, brukernavn FROM bruker WHERE idbruker = '{$brukerid}'";
                            $result = $mysqli->query($sql);
                            if ($result) {
                              while($row = mysqli_fetch_array($result)) {
                                echo "<option value='",$row['idbruker'],"'>",$row['brukernavn'],"</option>";
                              }
                            }
                            else {
                              echo mysql_error();
                            }
                            //Variabler og sql for å sende melding til databasen
                            $rapporttekst = $_POST["rapport"];
                            $datetime = date("Y-m-d H:i:s");
                            $rapportertbruker = $_POST["rapportvalg"];
                            $user->nyRapport($rapporttekst, $datetime, $brukerid, $rapportertbruker);
                        ?>
                        </select>
                    </p>
                    <p>Vennligst skriv i rapporten hvilken regel(eller regler) brukeren brudde i følge deg, så vil en av våre administratorer håndtere saken.<p>
                    <h2 class="nymeldtit">Rapporten</h2>
                    <textarea name="rapport" id="rapporttekst" cols="50" rows="8" maxlength="1024"></textarea>
                    <div class="sendmeld">
                    <?php
                    
                    ?>
                    <input type="submit" name="sendrapport">
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
<?php
include "./includefooter.php";
?>
</body>
</html>
