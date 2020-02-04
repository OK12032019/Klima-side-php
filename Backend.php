<?php

include_once "PDO.php";

SESSION_START();
$USER = $_SESSION['user_session'];
if (EMPTY($_SESSION['user_session'] )) {
    
	header('Location: default.php');

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
    <div class="textbox1">
        <p> velkomen <?php echo $fnavn; ?>  <?php echo $enavn; ?> </p>
        <textarea id="subject" name="subject" placeholder="Velkomen" readonly style="height:200px; width:55%; margin-top:2em;"></textarea> 
    </div>
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
