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
                <!-- Here make year from date -->
                <script>
                function getDate(clicked_id) 
                {
                    
                    var year=clicked_id.slice(0,7);

                }
                </script>
                <?php
                /* Set Calendar instance */
                $calendar = new Calendar();
                echo $calendar->show();
                ?>
            </div>   
            <h2>Ting som skjer denne måneden</h2>
                    <br>
                    <?php
                    if(isset($_GET['month'])){
                    $month=$_GET['month'];
                    $year=$_GET['year'];
                    $day = "01";
                    
                    $date = ($year."-".$month."-".$day);
                    }
                    else
                    {
                        $date = date("Y-m-d");
                    }
                    #$nextMonth = strtotime($date);
                    $nextMonth = date('Y-m-d', strtotime($date. ' + 1 months'));

                    #echo $date;
                    #echo $nextMonth;

                    /* Get event of current and next month*/
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
                        /* Get Countries*/
                        $fylkeNavn = $user->getFylkeNavn($fylke);
                        $fylkeNavn = $fylkeNavn[0]['fylkenavn'];
                        /* Get Event pictures*/
                        $Bilde = $user->getEventBilde($eventID);
                        if(empty($Bilde)){
                            $hvor='img/iceberg.jpg';
                        }
                        else{
                            $hvor=$Bilde[0]['hvor'];           
                        }
                        echo

						<<<EOT
                        
                        $newRow
                            <div class="col s12 m6">
                                <div class="card">
                                <div class="card-image">
                                    <img src="$hvor">
                                    <span class="card-title"> $eventnavn </span>
                                    <a class="btn-floating halfway-fab waves-effect waves-light red" href="eventer.php?eventid=$eventID"><i class="material-icons">add</i></a>
                                </div>
                                <div class="card-content">
                                    <p> $fylkeNavn </p>
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
        <h2>Regler</h2>
        <p><a href="regelside.php">finner du her</a></p>
            
    </div>         
    </section>
<?php
include "./includefooter.php";
?>
</body>
</html>
