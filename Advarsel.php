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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset ="UTF-8">
        <link rel="stylesheet" href="FellesCSS.css">
    </head>
    <body>

    <div class="container1">
        <h1>Advarsel</h1>
    </div>


<?php

if($Brukertype == 3){ ?>
        <section id="tekst">
            <div class="content clearfix">
                <div class="main-content">
                    <div class="advarsel">
                        <?php
                            $result = $user ->getAdvarsel();
                            foreach($result as $row) {
                                echo $row['advarseltekst'], '<br>';
                            }
                        ?>    
                    </div>
                </div>
            </div>
        </section>
    }


<?php
elif($Brukertype == 1)?>{ 
    <form method="post">
        <h2>Advarsel</h2>
            <textarea name="advarseltekst" id="advarseltekst" cols="50" rows="8"></textarea>
            <div class="form-container">
                <div class="form-group">
                    <div class="clearfix"></div><hr />
                    <div class="form-group">
                            <div class="a1">
                                <button type="submit" class="btn btn-block btn-primary" name="Advarsel">
                                    <i class="glyphicon glyphicon-open-file"></i>&nbsp;Send Advarsel</button>
                            </div>
                    </div>
                </div>
            </div>
    </form>

<?php

}



else{
    echo "Du er ikke logget inn";
}
    ?>


<?php

if(isset($_POST['Advarsel']))
{
    $advarseltekst = trim($_POST['advarseltekst']);
    $user->setAdvarsel($advarseltekst, $brukerid);
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