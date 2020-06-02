<?php
$error = '';
require_once 'PDO.php';

$brukertype = $_SESSION['btype'];
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
include "./includefooter.php";
?>

<!DOCTYPE html>
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
    <?php 
    $result=$user->getArtikkler();
    $counter = 1;
    foreach($result as $row) {
        if($counter % 3 == 0){ 
            $newRow = '';
            $endRow = '</div>';
        } 
        else{ 
            $newRow = '<div class="row">';
            $endRow = '';
        } 
        $artnavn = $row['artnavn'];
        $artinngress = $row['artinngress'];
        $artID = $row['idartikkel'];
        $Bilde = $user->getBilde($artID);
        if(empty($Bilde)){
            $hvor='images/iceberg.jpg';
        }
        foreach($Bilde as $row){
            $hvor=$row['hvor'];           
        }
        echo <<<EOT
        
        $newRow
            <div class="col s12 m6 l4">
                <div class="card">
                <div class="card-image">
                    <img src="$hvor">
                    <span class="card-title"> $artnavn </span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red" href="artikkel.php?artID=$artID"><i class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    <p> $artinngress </p>
                </div>
                </div>
            </div>
        $endRow
        EOT;
    $counter = $counter + 1;
    }
    ?>
    </div>
</div>
<div class ="row">

</body>
</html>
