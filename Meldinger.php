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
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset ="UTF-8">
    <link rel="stylesheet" href="FellesCSS.css">
    <title>Meldinger</title>
</head>
<body>
    <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png"style="width:80px;"></a>


        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
		
		            <a href="#" class="w3-bar-item" title="Konto">

                <a href="Brukerside.php"><img src="img/Bruker.png" class="w3-circle" style="height:28px;width:38px" alt="Avatar"> </a>

            </a>
			
        <ul class="menu">
		
            <a href="#" class="logoen1">Artikler</a>
			
            <a href="Brukerside.php" class="logoen2">Profil</a>
			
			
            <a href="#" class="logoen3">Arrangementer</a>
			
			

			
              <a href="Passord.php" class="nullpass">Nullstill Passord</a>
			
			
        <div class="a123">
        <form method="post">
            <button type="submit" name="btn-logout" class="btn btn-block btn-primary">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
            </button>
            </form>
        </div>
        </ul>   

    </header>
    <div class="container1">
        <h1 class="meldinger-tittel">Meldinger</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            <div class="main-content">
                <div class="meldinger">
                    <h2>Alle meldinger:</h2>
                    <?php
                    $mysqli = new mysqli("localhost", "Logginn", "asd", "klima");
                    //To sql spørringer er utførte, en for uleste medlinger og en for leste meldinger
                    $ulestmeld = "SELECT * FROM melding WHERE mottaker = '{$brukerid}' AND lest = 0";
                    $lestmeld = "SELECT * FROM melding WHERE mottaker = '{$brukerid}' AND lest = 1";
                    $ulestmeldingsliste = $mysqli->query($ulestmeld);
                    ?>
                    <a href="NyMelding.php">Skriv ny melding</a><br/>
                    <h3>Uleste Meldinger (<?php echo(mysqli_num_rows($ulestmeldingsliste));?>)</h3>
                    <table>
                        <tr>
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
                        $tekst = $row['tekst'];
                        $tidsendt = $row['tid'];
                        //Spørring for å hente ut brukernavn til sender
                        $result = $user -> getBrukernavn($senderid);
                        //Sender, tittel, tekst, tid sendt
                        echo '<tr> 
                        <td>',$result['brukernavn'],'</td>
                        <td>',$tittel,'</td>
                        <td>',$tekst,'</td>
                        <td>',$tidsendt,'</td>
                        <td>
                        <form method="POST" action="Lesmelding.php">
                            <button type="submit" name="btn_lesmelding" value="',$meldingid,'">Les melding</button>
                        </form>
                        </td>
                        </tr>';
                        $result = $mysqli->query($ulestmeld);
                        $row = mysqli_fetch_array($result);
                    
                    }
                    //Hvis det er ingen så vises det en melding
                    $result = $mysqli->query($ulestmeld);
                    if(intval(mysqli_num_rows($result))==0)
                    {
                    ?>
                        <tr>
                            <td colspan="4">Du har ingen uleste meldinger</td>
                        </tr>
                    <?php
                    }
                    
                    ?>
                    </table>
                    <br />
                    <!--Leste medlinger-->
                    <?php $lestmeldingsliste = $mysqli->query($lestmeld); ?>
                    <h3>Leste Meldinger (<?php echo(mysqli_num_rows($lestmeldingsliste)); ?>):</h3>
                    <table>
                        <tr>
                            <th>Sender</th>
                            <th>Tittel</th>
                            <th>Tekst</th>
                            <th>Tid Sendt</th>
                        </tr>
                    <?php
                    //Vis liste av alle uleste meldinger
                    while($row = mysqli_fetch_array($lestmeldingsliste))
                    {
                        $senderid = $row['sender'];
                        $tittel = $row['tittel'];
                        $tekst = $row['tekst'];
                        $tidsendt = $row['tid'];
                        //Spørring for å hente ut brukernavn til sender
                        $result = $user -> getBrukernavn($senderid);
                        //Sender, tittel, tekst, tid sendt
                        echo '<tr> 
                        <td>',$result['brukernavn'],'</td>
                        <td>',$tittel,'</td>
                        <td>',$tekst,'</td>
                        <td>',$tidsendt,'</td>
                        <td>
                        <form method="POST">
                            <button type="submit" name="btn-lesmelding">Les melding</button>
                        </form>
                        </td>
                        </tr>';
                        $result = $mysqli->query($lestmeld);
                        $row = mysqli_fetch_array($result);
                    
                    }
                    //Hvis det er ingen så vises det en melding
                    $result = $mysqli->query($lestmeld);
                    if(intval(mysqli_num_rows($result))==0)
                    {
                    ?>
                        <tr>
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