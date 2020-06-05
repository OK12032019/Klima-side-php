<?php
require_once 'PDO.php';

$url='backend.php';

if($user->is_loggedin()!="")
{
 $user->redirect('backend.php');
}
/* Logged User Button*/
if(isset($_POST['btn-login']))
{
	$bnavn = $_POST['brukernavn'];
    $pw = $_POST['pass'];
       /* Check User if exist or not */   
    if($user->feilLoginAntall($bnavn))
    {
        if($user->sjekkOgNullstill($bnavn))
        {
            /* Do login user and set SESSION for user */
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
            /* If Already login so update date time*/
            $user->setFeilLoginSiste($bnavn);
            $user->feilLoginTeller($bnavn);
        }     
    }
}
/* Password Button */
if(isset($_POST['nyPassordKnapp']))
{
    $email = $_POST['email'];
      /* check user email already exist or not*/
    if($user->epostFinnes($email))
    {
        $to = $email;
        $subject = "Reset your password";
        $msg = "Hi there, click on this <a href=s120.hbv.no\gruppe30\nyttPassord.php>link</a> to reset your password on our site";
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
                <h2 style="text-align: center;">Logg Inn</h2><hr />
                <div class="form-group">
                    <input type="text" name="brukernavn" placeholder="Brukernavn eller epost" required />
                </div>
                <div class="form-group">
                <input type="password"  name="pass" placeholder="Passord" required />
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="btn-login">Logg Inn
                    <i class="material-icons right">send</i>
                </button>
                <div class="form-group">
                    <label>Har du ikke konto? <a style="font-weight:bold" href="registrer.php">Registrer her</a></label>
                </div>
            </form>

        </div>
        <div class="card blue-grey darken-1">
            <form method="post">
                <h2 style="text-align: center;"> Glemt Passord? </h2><hr />
                <div class="form-group">
                    <input type="email" name="email" placeholder="Skriv eposten din">
                </div>
                <button class="btn waves-effect waves-light" type="submit" name="nyPassordKnapp">Reset passord
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>

</div>

<?php
include "./includefooter.php";
?>
</body>
</html>
