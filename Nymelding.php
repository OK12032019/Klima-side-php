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
        <h1 class="meldinger-tittel">Ny melding</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            <div class="main-content">
                <form method="POST">
                    <h2 class="nymeldtit">Tittel</h2>
                    <textarea name="tittel" id="meldingtittel" cols="50" rows="2"></textarea>
                    <h2 class="nymeldtit">Tekst</h2>
                    <textarea name="tekst" id="meldingtekst" cols="50" rows="8"></textarea>
                    <div class="nymeldknapp">
                    <button type="submit" name="btn_sendmelding">Send Melding</button>
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