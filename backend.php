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

// $Month = $_GET['month'];
// $Year = $_GET['year'];
// $date = $Year;
// $date .= '-';
// $date .= $Month;
// echo ($date);
include "./minmeny.php";
?>


<!DOCTYPE HTML>
<html>
<head>
	<meta charset ="UTF-8">
    <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <link type="text/css" rel="stylesheet" href="css/Flat.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </script>
    <title>Klima Logget Inn</title>
</head>
<body>
    <div class="container">
        <h1>Klima</h1>
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
        </div> 
        <h2>Regler<h2>
        <a href="regler\regler.php">finner du her</a>
            
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
