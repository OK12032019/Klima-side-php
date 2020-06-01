<?php
require_once 'PDO.php';

$url='backend.php';

if($user->is_loggedin()!="")
{
 $user->redirect('backend.php');
}

if(isset($_POST['btn-login']))
{
	$bnavn = $_POST['brukernavn'];
    $pw = $_POST['pass'];
        
    if($user->feilLoginAntall($bnavn))
    {
        if($user->sjekkOgNullstill($bnavn))
        {
            if($user->login($bnavn, $pw));
            {
                $user->redirect($url);
            }
        }
        else
        {
            $error =  "Du må vente 5 minuter før du kan prøve igjen";
        }
    }
    else
    {
        if($user->login($bnavn,$pw))
        {      
            $user->redirect($url);
        }
        else
        {
            $user->setFeilLoginSiste($bnavn);
            $user->feilLoginTeller($bnavn);
        }     
    }
}
if(isset($_POST['nyPassordKnapp']))
{
    $email = $_POST['email'];
    if($user->epostFinnes($email))
    {
        $to = $email;
        $subject = "Reset your password on app2000.notreal";
        $msg = "Hi there, click on this <a href=localhost\loggintest\nyttPassord.php>link</a> to reset your password on our site";
        $msg = wordwrap($msg,70);
        $headers = "From: admin@app2000.notreal";
        if(mail($to, $subject, $msg, $headers))
            {
                echo("mail er sent til din epost");
                $_SESSION['pwReset'] = ('True');
            }
            else
            {
                echo("Vi kunne ikke sende deg mail, venligst kontakt en admin.");
            }
    }
    else{
        echo ("Vi har ingen brukere med den eposten addressen.");
    }
}
include "./minmeny.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <link type="text/css" rel="stylesheet" href="css/Flat.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
    <meta charset ="UTF-8">
</head>

<body>
<div class="container">
    <div class ="row">
        <div class="card blue-grey darken-1">
            <form method="post">
                <h2>Logg Inn</h2><hr />
                <input type="text" name="brukernavn" placeholder="Brukernavn eller epost" required />
                
                <input type="password"  name="pass" placeholder="Passord" required />
                
                <button class="btn waves-effect waves-light" type="submit" name="btn-login">Logg in
                    <i class="material-icons right">send</i>
                </button>
            </form>
        
            <label>Har du ikke konto? <a href="registrer.php">Registrer her</a></label>
        </div>
        <div class="card blue-grey darken-1">
            <form method="post">
                <h2> glemt passord? </h2>
                <label>Skriv eposten din</label>
                <input type="email" name="email">
                <button class="btn waves-effect waves-light" type="submit" name="nyPassordKnapp">Reset passord
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>


    <footer>
        <section">
            <a href="">Om oss</a>
            <a href="">Sidekart</a>
            <a href="">Kariarre</a>
            <a href="">Støtt oss</a>
            <a href="">In English</a>
        </section>
        <section class="copyright">Gruppe 30 | copyright 2019</section>
        </footer>
</div>
</body>
</html>
