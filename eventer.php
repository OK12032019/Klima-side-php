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

  

$eventID = $_GET["eventid"];
$result = $user->getevent($eventID);
foreach($result as $row){
    $eventID = $row['idevent'];
    $eventnavn = $row['eventnavn'];
    $eventtekst = $row['eventtekst'];
    $veibeskrivelse = $row['veibeskrivelse'];
    $tidspunkt = $row['tidspunkt'];
    $fylkeid = $row['fylke'];
    $fylkenavnresult = $user->getFylkeNavn($fylkeid);
    $fylkenavn = $fylkenavnresult[0]['fylkenavn'];
    $Bilde = $user->getEventBilde($eventID);
        if(empty($Bilde)){
            $hvor='img/iceberg.jpg';
        }
        else{
            $hvor=$Bilde[0]['hvor'];           
        }
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
    <p><?php $eventnavn ?></p>

  <div class="row">
    <div class="col s12">
      <div class="card">
        <div class="card-image">
          <img src="<?php echo $hvor; ?>">
          <span class="card-title"><?php echo $eventnavn; ?></span>
          </div>
          <div class="card-content">
          <p>
            <?php echo $eventtekst; ?><br><div class="divider"></div>
            <section> <h3>veibeskrivelse:</h3>
            <?php echo $veibeskrivelse; ?><br><div class="divider"></div>
            <section> <h3>tidspunkt:</h3>
            <?php echo $tidspunkt; ?><br><div class="divider"></div>
            <section> <h3>Fylke:</h3>
            <?php echo $fylkenavn; ?><br><div class="divider"></div>
            </p>
         </div>
        </div>
        
      </div>
    </div>
</div>
</div>
						<?php
include "./includefooter.php";
?>
</body>
</html>