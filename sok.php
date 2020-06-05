<?php
include_once "PDO.php"; 



if($user->is_loggedin()=="")
{
    $user->redirect('default.php');
}
else {
	$fnavn = $_SESSION['fnavn'];
	$enavn = $_SESSION['enavn'];
}
// elias push
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
/* brukere har same interest*/
if(isset($_POST['interesse']))
{
    $interesseId= trim($_POST['interesser']);
    $BrukerArray=$user->sOk($interesseId);
    $lagTabel= True;
}
else{
    $lagTabel= False;
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
    <title>Søk på Bruker</title>
</head>
<body>

 
<main>
<div class="container">

<table>
    <?php
    if($lagTabel == True){
        #echo ('<tr><td>');
        #print_r($BrukerArray);
        #echo ('</td></tr><br> <br>');
        foreach($BrukerArray as $brukernavnSok)
        {
            $bn = $brukernavnSok[0]['brukernavn'];
            {
                echo <<<EOT
                    <tr><td>$bn</td></tr>
                    EOT;
            }
        }
    }
    ?>

</table>
<!--  Other user interest form -->
    <form method="post">
            <h2> Søk etter andre brukere etter interrese </h2>
            <select name ="interesser">
                <?php
                $result = $user-> getInterreser();
                foreach($result as $row)
                {
                    $interesse = $row['interessenavn'];
                    $interesseid = $row['idinteresse'];
                    echo <<<EOT
                        <option value="$interesseid">$interesse</option> 
                    EOT;

                }
                ?>
            </select>
        <button class="btn-large waves-effect waves-light" type="submit" name="interesse">Søk
            <i class="material-icons right">send</i>
        </button>
    </form>
</main>
<?php
include "./includefooter.php";
?>
</body>
</html>
