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
    <title>Meldinger</title>
</head>
<body>

    <div class="container1">
        <h1 class="meldinger-tittel">Meldinger</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            <div class="main-content">
                <div class="meldinger">
                    <?php 
                    $mysqli = new mysqli("localhost", "Logginn", "asd", "klima");
                    mysqli_set_charset($mysqli,'utf8');
                    $meldingid = $_POST['btn_lesmelding'];
                    //sql spørring for å hente fram melding
                    $sql = "SELECT * FROM melding WHERE mottaker = '{$brukerid}' AND idmelding = '{$meldingid}'";
                    //Merkerer meldingen som lest
                    $user->meldingLest($meldingid);
                    //Henter ut data om meldingen
                    $result = $mysqli->query($sql);
                    $row = mysqli_fetch_array($result);
                    $senderid = $row['sender'];
                    $tittel = $row['tittel'];
                    $tekst = $row['tekst'];
                    $tidsendt = $row['tid'];
                    $result = $user -> getBrukernavn($senderid);

                    ?>
                    <h2><?php echo $tittel ?></h2>
                    <div>Sendt av <b><?php echo $result['brukernavn'] ?></b> på <?php echo $tidsendt ?></div>
                    <p><?php echo $tekst ?><br></p>
                </div>
                <a href="Meldinger.php">Gå tilbake til alle meldinger</a>
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
