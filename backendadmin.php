<?php
$error = '';
require_once 'PDO.php';

$brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];
$debug = $_SESSION['debug'];
$date = $_SESSION['date'];




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
if(isset($_POST['setEvent']))
{   
   
    $eventnavn = trim($_POST['eventnavn']);
    $eventtekst = trim($_POST['eventtekst']);
    $veibeskrivelse = trim($_POST['veibeskrivelse']);
    $tidspunkt = $_POST['eventTime'];
    $fylke = $_POST['fylke'];
    $InsertID = $user->setEvent($eventnavn, $eventtekst, $tidspunkt, $veibeskrivelse, $brukerid, $fylke);
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
            print_r($InsertID);
            $fileNameNew = $InsertID.".".$fileActualExt;
            
            $fileDestination = 'uploads/'.$fileNameNew;
            move_uploaded_file($fileTempName, $fileDestination);
            $user->uploadEventBilde($fileDestination, $InsertID);
  
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
	<!-- 	
	<section id="tekst">
	<h2 id="adminmelding" style="margin-left:580px;"> Du er logget inn som administrator</h2>
	<div class="administrer" style="margin-left:700px;">
	
	<p><a href="Brukerside.php"><p> Administrer brukere</p> </a>
	<a href="Brukerside.php"><p> Sett bruker i karantene</p> </a>
	<a href="Brukerside.php"><p> Utvise bruker</p></a>
	<a href="Brukerside.php"><p> Gi advarsel</p></a>
    -->
	
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
               

			   <div>
                    <h2>Ting som skjer denne måneden</h2>
                    <br>
                    <?php
                    if(isset($_GET['month'])){
                    $month=$_GET['month'];
                    $year=$_GET['year'];
                    $day = "01";
                    
                    $date = ($year."-".$month."-".$day);
                    }
                    #$nextMonth = strtotime($date);
                    $nextMonth = date('Y-m-d', strtotime($date. ' + 1 months'));

                    #echo $date;
                    #echo $nextMonth;

                    $result=$user->getEvents($date, $nextMonth);
                    #var_dump($result);
                    if(!empty($result)){
                    $counter = 1;
                    foreach($result as $row) {
                        if($counter % 2 == 0){ 
                            $newRow = '';
                            $endRow = '</div>';
                        } 
                        else{ 
                            $newRow = '<div class="row">';
                            $endRow = '';
                        }
                        $eventID = $row['idevent'];
                        $eventnavn = $row['eventnavn'];
                        $eventtekst = $row['eventtekst'];
                        $veibeskrivelse = $row['veibeskrivelse'];
                        $tidspunkt = $row['tidspunkt'];
                        $fylke = $row['fylke'];
                        $Bilde = $user->getEventBilde($eventID);
                        if(empty($Bilde)){
                            $hvor='images/iceberg.jpg';
                        }
                        else{
                            $hvor=$Bilde[0]['hvor'];           
                        }
                        echo <<<EOT
                        
                        $newRow
                            <div class="col s12 m6">
                                <div class="card">
                                <div class="card-image">
                                    <img src="$hvor">
                                    <span class="card-title"> $eventnavn </span>
                                    <a class="btn-floating halfway-fab waves-effect waves-light red" href="eventer.php?eventid=$eventID"><i class="material-icons">add</i></a>
                                </div>
                                <div class="card-content">
                                    <p> $fylke </p>
                                </div>
                                </div>
                            </div>
                        $endRow
                        EOT;
                    $counter = $counter + 1;
                    }
                }?>
                    </div>
                </div> 
            
        <div class="row">
            <div class="col m6 s12">
            <h1> Lag Event </h1>
                <form method="post" enctype="multipart/form-data">
                <h2> event navn </h2>
                    <textarea name="eventnavn" id="tittel" cols="50" rows="2" maxlength="45"></textarea>
                    <h2> Event tekst</h2>
                    <textarea name="eventtekst" id="artikkelinnhold" cols="50" rows="8" maxlength="1000"></textarea>
                    <h2>Når?</h2>
                    <input type="date" name="eventTime">
                    <h2>Veibeskrivelse</h2>
                    <textarea name="veibeskrivelse" id="veibeskrivelse" cols="50" rows="2" maxlength="45"></textarea>
                    <h2>Fylke</h2>
                    <select name="fylke" id="Fylker">
                        <option Value='2'>Oslo</option>
                        <option value='3'>Rogaland</option>
                        <option value='4'>Møre og Romsdal</option>
                        <option value='5'>Norland</option>
                        <option value='6'>Viken</option>
                        <option value='7'>Innland</option>
                        <option value='8'>Vestfold og Telemark</option>
                        <option value='9'>Agder</option>
                        <option value='10'>Vestland</option>
                        <option value='11'>Trøndelag</option>
                        <option value='12'>Troms of Finnmark</option>   
                    </select>
                    <input type="file" name="file">
                    <button class="btn-large waves-effect waves-light" type="submit" name="setEvent">Lag Event
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
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
        </div>
        <div class="row">
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
