<?php
require_once 'PDO.php';

if($user->is_loggedin()!="")
{
 $user->redirect('Backend.php');
}

if(isset($_POST['btn-login']))
{
	$bnavn = $_POST['brukernavn'];
	$pw = $_POST['pass'];

	if($user->login($bnavn,$pw))
	{
	$user->redirect('Backend.php');
	}
	else
	{
	$error = "Wrong Details !";
	} 
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='stylesheet' type="text/css" href="logginn.css"/>
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		   <script language="Javascript" src=""></script>
  <link rel="stylesheet" href="FellesCSS.css">  
        <title>Logg inn</title>
    </head>
    <body>
<div class="container">
     <div class="form-container">
        <form method="post">
            <h2>Sign in.</h2><hr />
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
             <input type="text" class="form-control" name="brukernavn" placeholder="Username or E mail ID" required />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="pass" placeholder="Your Password" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                 <i class="glyphicon glyphicon-log-in"></i>&nbsp;SIGN IN
                </button>
            </div>
            <br />
            <label>Don't have account yet ! <a href="registrer.php">Sign Up</a></label>
        </form>
       </div>
</div>

</body>
	
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
	</main>
</html>
	

