<?php

include_once "PDO.php";

if($user->is_loggedin()=="")
{
    $user->redirect('Default.php');
}
else {
	$fnavn = $_SESSION['fnavn'];
    $enavn = $_SESSION['enavn'];
    $bruker = $_SESSION['brukerid'];
}

// elias push
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset ="UTF-8">
    <link rel="stylesheet" href="FellesCSS.css">
    <title>Klima Logget Inn</title>
</head>
<body>

    <div class="container1">
        <h1>Klima</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            
            <div class="main-content">
                <div class="calendar">
                    <script>
                    function getDate(clicked_id) 
                    {
                        
                        var year=clicked_id.slice(0,7);
                        //alert (year);

                        // var newURL = window.location.href;
                        // alert (newURL);
                        // var newURL = newURL + '&' + year;
                        // location.href = newURL;
                    }
                    </script>
                    <?php
                    $calendar = new Calendar();
                    echo $calendar->show();
                    ?>
                </div>   
                <div class= "events">
                    <h2>Ting som skjer denne måneden</h2>
                    <?php
                    // $result = $user->getEvents($Month, $Year);
                    // echo ($result['eventtekst']);
                    ?>
                    <br>
                </div> 
                <h2 class="nylig-artikkel-overskrift">Nylige artikler</h2>
            
                <div class="articlefeed1">

                    <?php 
                    $count=$user->artikkelsOk();
                    $count=$count+1;
                    $forrigeArtikkelID = $count;
                    while($forrigeArtikkelID != '1'){
                        $result = $user->artikkel($forrigeArtikkelID);
                        
                        ?>                            
                        <section id="tekst">
                            <div class="content-artikkel-side clearfix">
                                
                                <div class="main-content-artikkel-side">
                                    <h2 class="artikkel-overskrift"><?php echo $result['artnavn']; ?></h2>
                                
                                    <div class="artikkel-side-innhold">
                                        <!-- <img src="img/africa_forest_fire.jpg" width="290" height="150" alt="" class="artikkel-bilde"> --->
                                        <div class="artikkel-tekst-innhold">
                                            <p class="preview-text">
                                            <?php echo $result['arttekst']; ?>
                                            </p>
                                        </div>
                                        <div class="artikkel-info">
                                            <i class="far fa-user"><?php // echo $result['bruker'] ?></i>
                                            &nbsp;
                                        </div>

                                        <!-- <div class="kommentarer">
                                        </div>-->

                                        <div class="form-group">
                                            <form method="post" action="" input id="<?php echo $artikkelid['idartikkel']; ?>">
                                                <textarea cols="30" rows="2" name="komtekst" placeholder="skriv inn din kommentar"></textarea>

                                                <input type="submit" class="btn btn-block btn-primary" name="kommentar" value="kommenter"/>

                                                <?php
                                                    
                                                    if(isset($_POST['kommentar']))
                                                        {
                                                            $ingress = ('test');
                                                            $tekst = $_POST['komtekst'];
                                                            $tid = date("Y-m-d H:i:s");
                                                            $artikkelid = $result['idartikkel'];
                                                            // echo $artikkelid;
                                                            // echo "<br>";
                                                            // echo $ingress;
                                                            // echo "<br>";
                                                            // echo $tekst;
                                                            // echo "<br>";
                                                            // echo $tid;
                                                            // echo "<br>";
                                                            $user->artikkelKommentar($ingress, $tekst, $tid, $artikkelid, $bruker);
                                                        }
                                                
                                                    
                                                    $mysqli = new mysqli("localhost", "Logginn", "asd", "klima");
                                                    $stmt = "SELECT * FROM kommentar";
                                                    $resultkom = $mysqli->query($stmt);
                                                    while ($row = mysqli_fetch_array($resultkom))
                                                        {
                                                            echo $row['bruker']."<br>";
                                                            echo $row['tid']."<br>";
                                                            echo nl2br($row['komtekst'])."<br><br><br>";
                                                        }
                                                    
                                                ?>
                                            </form>
                                        </div>
                                        

                                    <!--<form method="post">
                                        <div class="form-group">
                                            <textarea name="kommentar" input id="<?php echo $artikkelid['idartikkel']; ?>" type="text" class="form-control" placeholder="Skriv inn din kommentar"/></textarea>-->
                                            <?php 
                                                //if(isset($_POST['kommentar']))
                                                    {   
                                                        //$ingress = (' test ');
                                                        //$tekst = $_POST['kommentar'];
                                                        //$tid = date("Y-m-d H:i:s");
                                                        //$artikkelid = $result['idartikkel'];
                                                        //$artikkelid = ('test');
                                                        //$test = $artikkelid['idartikkel'];
                                                        //echo $test;
                                                        //echo $ingress; 
                                                        //echo $tekst;
                                                        //echo $tid;
                                                        //echo $artikkelid;  
                                                        //$user->artikkelKommentar($ingress, $tekst, $tid, $artikkelid);
                                                    }    
                                            ?>
                                        <!-- </div>
                                            <button type="submit" name="kommentar">Kommenter</button>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-primary" name="kommentar">
                                                    <i class="glyphicon glyphicon-open-file"></i>&nbsp;Legg inn kommentar
                                                </button>
                                            </div>
                                        </form> -->


                                    </div>

                                </div>
                            </div>
                        </section>
                        <?php 
                        $forrigeArtikkelID = $result['idartikkel'];
                        echo $forrigeArtikkelID;
                    }?>
                </div>
            </div>
        </div>
    </section>
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
