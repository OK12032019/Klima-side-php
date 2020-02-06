<?php

include_once "PDO.php";

if($user->is_loggedin()=="")
{
    $user->redirect('default.php');
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
?>

<html>
<head>
    <link rel="stylesheet" href="FellesCSS.css">
    <title>Test Backend</title>
</head>
<body>
    <header class="hovedheader">
        <a href="default.php" class="logoen">LOGO</a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
        <form method="post">
            <button type="submit" name="btn-logout" class="btn btn-block btn-primary">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
            </button>
            </form>
            <li><a href="Passord.php">Nullstill Passord</a></li>
        </ul>   
    </header>
    <div class="container">
        <h1>Klima</h1>
      </div>
		
	<section id="tekst">
	    <div class="content clearfix">
            
            <div class="main-content">
                <h2 class="nylig-artikkel-overskrift">Nylige artikler</h2>
            
                <div class="articlefeed1">
                    <img src="img/city_people_street.jpg" width="290" height="150" alt="" class="artikkel-bilde">
                    <div class="post-preview">
                        <h2><a href="article-itsnoteasybeinggreen.html" class="post-lenke">"It's not easy being green!"</a></h2>
                        <i class="far fa-user">Alvin King</i>
                        &nbsp;
                        <i class="far calendar"> Feb 01, 2020</i>
                        <p class="preview-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore facere, magnam veritatis quae non, vitae accusantium similique, nemo officiis harum recusandae a quos? Accusantium, non id odit commodi error mollitia!
                        </p>
                    </div>
                </div>
                
                <div class="articlefeed2">
                    <img src="img/ice_formation.jpg" width="290" height="150" alt="" class="artikkel-bilde">
                    <div class="post-preview">
                        <h2><a href="article-globalwarming.html" class="post-lenke">Global Warming</a></h2>
                        <i class="far fa-user">Alvin King</i>
                        &nbsp;
                        <i class="far calendar"> Feb 01, 2020</i>
                        <p class="preview-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore facere, magnam veritatis quae non, vitae accusantium similique, nemo officiis harum recusandae a quos? Accusantium, non id odit commodi error mollitia!
                        </p>
                    </div>
                </div> 

                <div class="articlefeed3">
                    <img src="img/africa_forest_fire.jpg" width="290" height="150" alt="" class="artikkel-bilde">
                    <div class="post-preview">
                        <h2><a href="article-afrikaregnskogbrann.html" class="post-lenke">Tusenvis av branner i Afrikas største regnskog</a></h2>
                        <i class="far fa-user">Alvin King</i>
                        &nbsp;
                        <i class="far calendar"> Feb 01, 2020</i>
                        <p class="preview-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore facere, magnam veritatis quae non, vitae accusantium similique, nemo officiis harum recusandae a quos? Accusantium, non id odit commodi error mollitia!
                        </p>
                    </div>
                </div> 

                <div class="articlefeed4">
                    <img src="img/earth_desert_dry.jpg" width="290" height="150" alt="" class="artikkel-bilde">
                    <div class="post-preview">
                        <h2><a href="article-iskaldtiorkenen.html" class="post-lenke">Iskaldt i ørkenen</a></h2>
                        <i class="far fa-user">Alvin King</i>
                        &nbsp;
                        <i class="far calendar"> Feb 01, 2020</i>
                        <p class="preview-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempore facere, magnam veritatis quae non, vitae accusantium similique, nemo officiis harum recusandae a quos? Accusantium, non id odit commodi error mollitia!
                        </p>
                    </div>
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
