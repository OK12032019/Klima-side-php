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
                    $ulestmeldingsliste = $user->getUlesteMeldinger();
                    ?>
                    <h3>Uleste Meldinger (<?php
                    $ulestMeldTeller = 0;
                    foreach($ulestmeldingsliste as $row) {
                        $ulestMeldTeller = $ulestMeldTeller + 1;
                    }
                    echo($ulestMeldTeller);
                    ?>)</h3>
                    
                    <table>
                        <tr class="meldrow">
                            <th>Sender</th>
                            <th>Tittel</th>
                            <th>Tekst</th>
                            <th>Tid Sendt</th>
                        </tr>
                    <?php
                    //Vis liste av alle uleste meldinger
                    foreach($ulestmeldingsliste as $row)
                    {
                        $meldingid = $row['idmelding'];
                        $senderid = $row['sender'];
                        $tittel = $row['tittel'];
                        $tidsendt = $row['tid'];
                        //Spørring for å hente ut brukernavn til sender
                        $brukernavn = $user -> getBrukernavn($senderid);
                        //Sender, tittel, tid sendt
                        echo '<tr class="meldrow"> 
                        <td>',$brukernavn['brukernavn'],'</td>
                        <td>',$tittel,'</td>
                        <td>',$tidsendt,'</td>
                        <td>
                        <form method="POST" action="lesmelding.php">
                            <button type="submit" name="btn_lesmelding" value="',$meldingid,'">Les melding</button>
                        </form>
                        </td>
                        </tr>';
                    
                    }

                    if($ulestMeldTeller==0)
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
                    $lestmeldingsliste = $user->getLesteMeldinger(); 
                    ?>
                    <h3>Leste Meldinger (<?php
                    $lestMeldTeller = 0;
                    foreach($lestmeldingsliste as $row) {
                        $lestMeldTeller = $lestMeldTeller + 1;
                    }
                    echo($lestMeldTeller);
                    ?>):</h3>
                    <table>
                        <tr class="meldrow">
                            <th>Sender</th>
                            <th>Tittel</th>
                            <th>Tid Sendt</th>
                        </tr>
                    <?php
                    //Vis liste av alle leste meldinger
                    foreach($lestmeldingsliste as $row)
                    {
                        $meldingid = $row['idmelding'];
                        $senderid = $row['sender'];
                        $tittel = $row['tittel'];
                        $tidsendt = $row['tid'];
                        //Spørring for å hente ut brukernavn til sender
                        $brukernavn = $user -> getBrukernavn($senderid);
                        //Sender, tittel, tid sendt
                        echo '<tr class="meldrow"> 
                        <td>',$brukernavn['brukernavn'],'</td>
                        <td>',$tittel,'</td>
                        <td>',$tidsendt,'</td>
                        <td>
                        <form method="POST" action="lesmelding.php">
                            <button type="submit" name="btn_lesmelding" value="',$meldingid,'">Les melding</button>
                        </form>
                        </td>
                        </tr>';
                    
                    }
                    //Hvis det er ingen så vises det en melding
                    if($lestMeldTeller==0)  
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
<?php
include "./includefooter.php";
?>
</body>
</html>
