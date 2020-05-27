<?php
$error = '';
require_once 'PDO.php';

$brukertype = $_SESSION['btype'];
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
  if($brukertype == 1)
  {
    $user->redirect('backendadmin.php');   
  }
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

  

$artID = $_GET["artID"];
$result = $user->getArtikkel($artID);
foreach($result as $row){
$artnavn = $row['artnavn'];
$artinngress = $row['artinngress'];
$arttekst = $row['arttekst'];
}
$Bilde = $user->getBilde($artID);
        if(empty($Bilde)){
            $hvor='images/iceberg.jpg';
        }
        foreach($Bilde as $row){
            $hvor=$row['hvor'];           
        }
if(isset($_POST['kommenter']))
{
    $ingress = 'test';
    $tekst = $_POST['kommentar'];
    $tid = date("Y-m-d H:i:s");
    $artikkelid = $artID;
    $bruker = $brukerid;
    $user->artikkelKommentar($ingress, $tekst, $tid, $artikkelid, $bruker);
}  
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
	<title> Klima</title>
		
    </head>
<body>
<div class="container">
  <div class="center-align">
    <h1></h1>
    <p><? $artnavn ?></p>

  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-image">
          <img src="<?php echo $hvor; ?>">
          <span class="card-title"><?php echo $artnavn; ?></span>
          </div>
          <div class="card-content">
          <p>
              <?php echo $arttekst; ?>
            </p>
         </div>
        </div>
        
      </div>
    </div>
  <!-- KOMMENTARER -->
    <?php 
    $result = $user->getKommentar($artID);
    foreach($result as $row){
        $komtekst = $row['komtekst'];
        $komBruker = $row['bruker'];
        echo <<<EOT
        <div class="card-panel grey lighten-5 z-depth-1">
          <div class="row valign-wrapper">
            <div class="col s2">
              <p> $komBruker </p>
            </div>
            <div class="col s10">
              <span class="black-text">
                $komtekst
              </span>
            </div>
          </div>
        </div>
        EOT;
    }
    ?>
    <form method="post">
        <div class="form-group shadow-textarea">
            <label for="exampleFormControlTextarea6">Kommentar</label>
            <textarea class="form-control z-depth-1" id="Kommentar" name="kommentar" rows="3" placeholder="Skriv kommentar her..."></textarea>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="kommenter">Kommenter
            <i class="material-icons right">send</i>
        </button>
    </form>
        

</div>
</div>
</body>
</html>