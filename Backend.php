<?php

include_once "PDO.php";

if($user->is_loggedin()=="")
{
    $user->redirect('Default.php');
}
else {
	$fnavn = $_SESSION['fnavn'];
	$enavn = $_SESSION['enavn'];
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
            <?php
            $calendar = new Calendar();
            echo $calendar->show();
            ?>
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
                                        <div class="kommentar">
                                        <?php 
                                            if(isset($_POST['kommenter']))
                                                {   
                                                    $ingress = (' test ');
                                                    $tittel = trim($_POST['tittel']);
                                                    $artikkel = trim($_POST['artikkeltekst']);
                                                    $user->artikkelKommentar($ingress, $tekst, $tid, $artikkelid);
                                                    
                                                }
                                        ?>
                                            <div class="a1">
                                            <button type="submit" class="btn btn-block btn-primary" name="kommenter">
                                                <i class="glyphicon glyphicon-open-file"></i>&nbsp;lagre                            </button>
                                            </div>
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
