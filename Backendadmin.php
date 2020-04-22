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
    <title>Klima ADMIN Logget Inn</title>
</head>
<body>


    <div class="container1">
        <h1>Klima</h1>
        </div>
		
	<section id="tekst">
	<h2 id="adminmelding" style="margin-left:580px;"> Du er logget inn som administrator</h2>
	<div class="administrer" style="margin-left:700px;">
	
	<p><a href="Advarsel.php"><p> Administrer brukere</p> </a>
	<a href="Advarsel.php"><p> Sett bruker i karantene</p> </a>
	<a href="Advarsel.php"><p> Utvise bruker</p></a>
	<a href="Advarsel.php"><p> Gi advarsel</p></a>
 
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
                                                            $user->artikkelKommentar($ingress, $tekst, $tid, $artikkelid, $bruker);
                                                        }
                                                
                                                    
                                                    $mysqli = new mysqli("128.39.19.159", "usr_klima", "pw_klima", "klima");
                                                    $stmt = "SELECT * FROM kommentar";
                                                    $resultkom = $mysqli->query($stmt);
                                                    while ($row = mysqli_fetch_array($resultkom))
                                                        {
                                                            echo $row['bruker']."<br>";
                                                            echo $row['tid']."<br>";
                                                            echo nl2br($row['tekst'])."<br><br><br>";
                                                        }
                                                    
                                                ?>
                                            </form>
                                        </div>
                                        

                                            <?php echo $artikkelid['idartikkel']; ?>" type="text" class="form-control" placeholder="Skriv inn din kommentar"/></textarea>-->

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
