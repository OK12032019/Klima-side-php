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
  $fnavn=$_SESSION['fnavn'];
  $enavn=$_SESSION['enavn'];
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
        <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <link type="text/css" rel="stylesheet" href="css/Flat.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
	<meta charset ="UTF-8">
    </head>
    <body>
    <div class="Regler">
        <h1>Regler for nettsiden</h1>
        
        <?php
        $result = $user ->getRegler();
        #var_dump($result);
        #echo ('test');
        #print_r($result);
        foreach($result as $row) {
            echo $row['regeltekst'], '<br>';
            }   ?>
    </div>

<?php
if($Brukertype == 1){ ?>
    <form method="post">
    <h2> Ny Regel</h2>
            <textarea name="regeltekst" id="regeltekst" cols="50" rows="8" maxlength="255"></textarea>
            <div class="form-container">
           
           <div class="form-group">
           </div>
               <div class="clearfix"></div><hr />
               <div class="form-group">
               <div class="a1">
                   <button type="submit" class="btn btn-block btn-primary" name="nyRegel">
                       <i class="glyphicon glyphicon-open-file"></i>&nbsp;lagre                            </button>
                       </div>
               </div>
           </div>
       </form>
       <?php
}

if(isset($_POST['nyRegel']))
{
    $regeltekst = trim($_POST['regeltekst']);
    $user->setRegler($regeltekst, $brukerid);
}
?>
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
