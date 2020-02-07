<?php
require_once 'PDO.php';

$url='backend.php';

if($user->is_loggedin()!="")
{
 $user->redirect('Backend.php');
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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='stylesheet' type="text/css" href="FellesCSS.css"/>
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		   <script language="Javascript" src=""></script>
  <link rel="stylesheet" href="FellesCSS.css">  
        <title>Logg inn</title>
    </head>
	  	    <header class="hovedheader">

        <a href="default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:80px;"></img></a>

        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="Default.php">Hovedside</a></li>
            <li><a href="registrer.php">Registrer</a></li>
        </ul>   
    </header>
    <body>
	

<div class="femtien">
<div class="containers">
     <div class="form-container">
        <form method="post">
            <h2>Logg Inn</h2><hr />
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
             <input type="text" class="form-control" name="brukernavn" placeholder="Brukernavn eller epost" required />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="pass" placeholder="Passord" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                 <i class="glyphicon glyphicon-log-in"></i>&nbsp;LOGG INN
                </button>
            </div>
            <br />
            <label>Har du ikke konto? <a href="registrer.php">Registrer her</a></label>
        </form>
       </div>

</div>
</div>
</div>

</body>
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
	</main>
</html>
	

