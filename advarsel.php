<?php
$error = '';
require_once 'PDO.php';

$Brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];


if($user->is_loggedin()=="")
{
  $user->redirect('default.php');
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
    $user->redirect('default.php');
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
                        $result = $user ->getAdvarsel($brukerid);
                        foreach($result as $row) {
                            echo $row['advarseltekst'], '<br>';
                        }
                    ?>    
                </div>
            </div>
        </div>
    </section>
<?php
}

elseif($Brukertype == 1){ ?>

<div class="advarsel">
    <?php
        $result = $user ->getAdvarselAdmin();
        foreach($result as $row) {
            echo $row['advarseltekst'], '<br>';
        }
    ?>    
</div>
    <form method="post">
        <h2>Advarsel</h2>
        <textarea name="advarseltekst" id="advarseltekst" cols="50" rows="8"></textarea>
        <h2 class="nymeldtit">Mottaker</h2>
            <select name="mottakermeny">
            <?php 
                $result = $user->getBrukerliste();
                if ($result) {
                    foreach($result as $row) {
                    echo "<option value='",$row['idbruker'],"'>",$row['brukernavn'],"</option>";
                    }
                }
                else {
                    echo mysql_error();
                }
                
            $mottaker = $_POST["mottakermeny"];
            ?>
            </select>
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
    </div>
    </form>
<div>
<form method="post">
    <h2>Ekskludering</h2>
    <textarea name="grunnlag" id="grunnlag" cols="50" rows="8"></textarea>
        <h2 class="nymeldtit">Mottaker</h2>
            <select name="mottakermeny">
            <?php 
                $result = $user->getBrukerliste();
                if ($result) {
                    foreach($result as $row) {
                    echo "<option value='",$row['idbruker'],"'>",$row['brukernavn'],"</option>";
                    }
                }
                else {
                    echo mysql_error();
                }
                
            $mottaker = $_POST["mottakermeny"];
            ?>
            </select>
        <h2>start dato</h2>
        <input type="date" id="startdato" name="startdato">
        <H2>Slutt dato</h2>
        <input type="date" id="sluttdato" name="sluttdato">

    <div class="form-container">
    <div class="form-group">
        <div class="clearfix"></div><hr />
        <div class="form-group">
                <div class="a1">
                    <button type="submit" class="btn btn-block btn-primary" name="Ekskluder">
                        <i class="glyphicon glyphicon-open-file"></i>&nbsp;Ekskluder</button>
                </div>
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
    $user->setAdvarsel($advarseltekst, $brukerid, $mottaker);
}
if(isset($_POST['Ekskluder']))
{
    $grunnlag = trim($_POST['grunnlag']);
    $datofra = ($_POST['startdato']);
    $datotil = ($_POST['sluttdato']);

    $user->setEkskludering($grunnlag, $datofra, $datotil, $mottaker, $brukerid);
}
?>  


						<?php
include "./includefooter.php";
?>
</body>


</html>
