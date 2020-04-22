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
include "./minmeny.php";
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

  <!--##########  HER HAR JEG BRUKT 'BOOTSTRAP RESPONSIVE LINKS' ####### -->  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
        <title>Logg inn</title>
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
