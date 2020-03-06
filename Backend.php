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
$Month = $_GET['month'];
$Year = $_GET['year'];
$date = $Year;
$date .= '-';
$date .= $Month;
echo ($date);

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
    <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png"style="width:80px;"></a>


        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
		
		            <a href="#" class="w3-bar-item" title="Konto">

                <a href="Brukerside.php" <img src="Bruker.png" class="w3-circle" style="height:28px;width:38px" alt="Avatar"> </a>

            </a>
			
        <ul class="menu">
		
            <a href="#" class="logoen1">Artikler</a>
			
            <a href="Brukerside.php" class="logoen2">Profil</a>
			
			
            <a href="#" class="logoen3">Arrangementer</a>
			
			

			
              <a href="Passord.php" class="nullpass">Nullstill Passord</a>
			
			
        <div class="a123">
        <form method="post">
            <button type="submit" name="btn-logout" class="btn btn-block btn-primary">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
            </button>
            </form>
        </div>
        </ul>   

    </header>
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
            <div class= "events">

            <h2>Ting som skjer denne måneden</h2>
            <?php
            $mysqli = new mysqli("localhost", "Logginn", "asd", "klima");

            $sql = "SELECT * FROM event WHERE month(tidspunkt)={$Month} AND year(tidspunkt)={$Year}";
            $result = $mysqli->query($sql);
            if ($result) {
                while($row = mysqli_fetch_array($result)) {
                echo "<h1>Tittle: ",$row['eventnavn'],"<br>";
                echo "<option value='",$row['eventnavn'],"'>",$row['eventtekst'],"</option>";
                echo "<p>Dato: ",$row['tidspunkt'],"<br>";
                echo "<p>Veibeskrivelse: ",$row['veibeskrivelse'],"<br><br><br><br><br>";
                }

            }
            else {
                echo "error";//mysql_error();
            }
            // $result = $user->getEvents($Month, $Year);
            // for 
            // echo ($result['eventtekst']);
            // }
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
                        $artikkelid = $result['idartikkel'];
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
                                        <div class="form-group">
                                            <form method="post" action="" input id="<?php echo $artikkelid; ?>">
                                                <p> <?php echo $artikkelid; ?></p>
                                                <textarea cols="30" rows="2" name="komtekst" placeholder="skriv inn din kommentar"></textarea>

                                                <input type="submit" class="btn btn-block btn-primary" name="input" value="Kommenter"/>

                                                <?php
                                                    
                                                    if(isset($_POST['input']))
                                                        {
                                                            $ingress = ('test');
                                                            $tekst = $_POST['komtekst'];
                                                            $tid = date("Y-m-d H:i:s");
                                                            
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
                                                    $stmt = "SELECT * FROM kommentar WHERE artikkel = {$artikkelid};";
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
