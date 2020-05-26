<?php
$error = '';
require_once 'PDO.php';

$brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];
$debug = $_SESSION['debug'];


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
if(isset($_POST['setArtikkel']))
{   
   
    $tittel = trim($_POST['tittel']);
    $artikkel = trim($_POST['artikkeltekst']);
    $user->largeArtikkel($tittel, $artikkel, $brukerid);
    echo $tittel;
    echo $artikkel;
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 500000) {
          $result = $user->getidArtikkel($tittel);
          var_dump($result);
          foreach($result as $row) {
            echo $row['idartikkel'], '<br>';
            $ArtikkelIDtilBilde = $row['idartikkel'];
            }
          print_r($ArtikkelIDtilBilde);
          $fileNameNew = $ArtikkelIDtilBilde.".".$fileActualExt;
          
          $fileDestination = 'uploads/'.$fileNameNew;
          move_uploaded_file($fileTempName, $fileDestination);
          $user->uploadBilde($ArtikkelIDtilBilde, $fileDestination);

        }
        else {
          echo "Your file is too big!";
        }
      }
      else {
        echo "There was an error uploading your file, try again!";
      }
    }
    else {
      echo "You cannot upload files of this type!";
    }
  }
  if(isset($_POST['regelKnapp']))
{
    $regel = trim($_POST['regel']);
    $user->setRegel($regel,$brukerid);
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
    <title>Klima ADMIN Logget Inn</title>
</head>
<body>


    <div class="container">
        <h1>Klima</h1>
        </div>
		
	<section id="tekst">
	<h2 id="adminmelding" style="margin-left:580px;"> Du er logget inn som administrator</h2>
	<div class="administrer" style="margin-left:700px;">
	
	<p><a href="Brukerside.php"><p> Administrer brukere</p> </a>
	<a href="Brukerside.php"><p> Sett bruker i karantene</p> </a>
	<a href="Brukerside.php"><p> Utvise bruker</p></a>
	<a href="Brukerside.php"><p> Gi advarsel</p></a>
 
	</div>
	
	    <div class="content clearfix">
            
            <div class="main-content">
                <div class="calendar">
                    <script>
                    function getDate(clicked_id) 
                    {
                        
                        var year=clicked_id.slice(0,7);

                    }
                    </script>
                    <?php
                    $calendar = new Calendar();
                    echo $calendar->show();
                    ?>
                </div>   
               

			   <div class= "events">
                    <h2>Ting som skjer denne måneden</h2>
                    <br>
                </div> 
                <h2 class="nylig-artikkel-overskrift">Nylige artikler</h2>
            
        <div class="row">
            <div class="col m6 s12">
            <h1> Skriv artikkel </h1>
                <form method="post" enctype="multipart/form-data">
                <h2> tittel </h2>
                    <textarea name="tittel" id="artikkeltittel" cols="50" rows="2" maxlength="45"></textarea>
                    <h2> Artikkelinnhold</h2>
                    <textarea name="artikkeltekst" id="artikkelinnhold" cols="50" rows="8" maxlength="1000"></textarea>
                    <input type="file" name="file">
                    <button class="btn-large waves-effect waves-light" type="submit" name="setArtikkel">Publiser Artikkel
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
            <!-- NY REGEL KUNN ADMIN -->
            <div class="col m12 s12">
            <h1> Ny regel </h1>
                <form method="post">
                <h2> tittel </h2>
                    <textarea name="regel" id="Regel" cols="50" rows="2" maxlength="45"></textarea>
                    <h2>Regel</h2>
                    <button class="btn-large waves-effect waves-light" type="submit" name="regelKnapp">Publiser regel
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    </section>
    <footer class="background-color ">
<div class ="row">
<section class="col m6 s12 center-align">
<a href="">Om oss</a>
<a href="">Sidekart</a>
<a href="">Kariarre</a>
<a href="">Støtt oss</a>
<a href="">In English</a>
</section>
<section class="col m6 s12 center-align">Gruppe 30 | copyright 2019</section>
</footer>
</body>
</html>
