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
    <title>Meldinger</title>
</head>
<body>

    <div class="container1">
        <h1>Meldinger</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            <div class="main-content">
                <div class="meldinger">
                    <p><a href="nyMelding.php">Skriv ny melding</a></p>
                    <h2>Alle meldinger:</h2>
                    <?php
                    //Gammel metode, slett senere
                    //Flytt mysqli på til class.user
                    $mysqli = new mysqli("localhost", "root", "", "klima");
                    mysqli_set_charset($mysqli,'utf8');
                    //To sql spørringer er utførte, en for uleste medlinger og en for leste meldinger
                    $ulestmeld = "SELECT * FROM melding WHERE mottaker = '{$brukerid}' AND lest = 0";
                    $lestmeld = "SELECT * FROM melding WHERE mottaker = '{$brukerid}' AND lest = 1";
                    $ulestmeldingsliste = $mysqli->query($ulestmeld);
                    //Ny metode
                    //$ulestmeldingsliste = $user->getUlesteMeldinger();
                    ?>
                    <h3>Uleste Meldinger (<?php echo(mysqli_num_rows($ulestmeldingsliste));?>)</h3>
                    
                    <table>
                        <tr class="meldrow">
                            <th>Sender</th>
                            <th>Tittel</th>
                            <th>Tekst</th>
                            <th>Tid Sendt</th>
                        </tr>
                    <?php
                    //Vis liste av alle uleste meldinger
                    while($row = mysqli_fetch_array($ulestmeldingsliste))
                    {
                        $meldingid = $row['idmelding'];
                        $senderid = $row['sender'];
                        $tittel = $row['tittel'];
                        $tidsendt = $row['tid'];
                        //Spørring for å hente ut brukernavn til sender
                        $result = $user -> getBrukernavn($senderid);
                        //Sender, tittel, tid sendt
                        echo '<tr class="meldrow"> 
                        <td>',$result['brukernavn'],'</td>
                        <td>',$tittel,'</td>
                        <td>',$tidsendt,'</td>
                        <td>
                        <form method="POST" action="lesmelding.php">
                            <button type="submit" name="btn_lesmelding" value="',$meldingid,'">Les melding</button>
                        </form>
                        </td>
                        </tr>';
                        //Ny metode
                        //$result = $user->getUlesteMeldinger();
                        $result = $mysqli->query($ulestmeld);
                        $row = mysqli_fetch_array($result);
                    
                    }
                    //Hvis det er ingen så vises det en melding
                    //Ny metode
                    //$result = $user->getUlesteMeldinger();
                    $result = $mysqli->query($ulestmeld);
                    if(intval(mysqli_num_rows($result))==0)
                    {
                    ?>
                        <tr class="meldrow">
                            <td colspan="4">Du har ingen uleste meldinger</td>
                        </tr>
                    <?php
                    }
                    
                    ?>
                    </table>
                    <br />
                    <!--Leste medlinger-->
                    <?php
                    //Ny metode
                    //$lestmeldingsliste = $user->getUlesteMeldinger(); 
                    $lestmeldingsliste = $mysqli->query($lestmeld); 
                    ?>
                    <h3>Leste Meldinger (<?php echo(mysqli_num_rows($lestmeldingsliste)); ?>):</h3>
                    <table>
                        <tr class="meldrow">
                            <th>Sender</th>
                            <th>Tittel</th>
                            <th>Tid Sendt</th>
                        </tr>
                    <?php
                    //Vis liste av alle leste meldinger
                    while($row = mysqli_fetch_array($lestmeldingsliste))
                    {
                        $meldingid = $row['idmelding'];
                        $senderid = $row['sender'];
                        $tittel = $row['tittel'];
                        $tidsendt = $row['tid'];
                        //Spørring for å hente ut brukernavn til sender
                        $result = $user -> getBrukernavn($senderid);
                        //Sender, tittel, tid sendt
                        echo '<tr class="meldrow"> 
                        <td>',$result['brukernavn'],'</td>
                        <td>',$tittel,'</td>
                        <td>',$tidsendt,'</td>
                        <td>
                        <form method="POST" action="lesmelding.php">
                            <button type="submit" name="btn_lesmelding" value="',$meldingid,'">Les melding</button>
                        </form>
                        </td>
                        </tr>';
                        //Ny metode
                        //$result = $user->getUlesteMeldinger();
                        $result = $mysqli->query($lestmeld);
                        $row = mysqli_fetch_array($result);
                    
                    }
                    //Hvis det er ingen så vises det en melding
                    //Ny metode
                    //$result = $user->getUlesteMeldinger();
                    $result = $mysqli->query($lestmeld);
                    if(intval(mysqli_num_rows($result))==0)
                    {
                    ?>
                        <tr class="meldrow">
                            <td colspan="4">Du har ingen leste meldinger</td>
                        </tr>
                    <?php
                    }
                    
                    ?>
                    </table>
                </div>
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
