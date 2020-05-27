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
    <div class="femtien">
        <div class="container">
            <div class="form-container">
                <form method="post">
                    <h2 style="text-align:center;">Logg Inn</h2><hr />
                    <?php
                    if(isset($error))
                    {
                        ?>
                        <div class="alert alert-danger">
                            <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                    <input type="text" class="form-control input" name="brukernavn" placeholder="Brukernavn eller epost" required />
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control input" name="pass" placeholder="Passord" required />
                    </div>
                    <div class="clearfix"></div><hr />
                    <div class="form-group">
                    <button type="submit" name="btn-login" class="btn btn-block btn-primary input">
                        <i class="glyphicon glyphicon-log-in"></i>&nbsp;LOGG INN
                        </button>
                    </div>
                    <br />
                    <label>Har du ikke konto? <a href="Registrer.php">Registrer her</a></label>
                </form>
            </div>
        </div>
    </div>

    <div class="c123">	
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
    </div>
</body>
</html>
