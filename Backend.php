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
	<a href="default.php" class="logoen"><img src="n1.png"></a>
	    <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
		
		 <ul class="menu">
		<a href="defaultr.php" class="logoen1">Artikler</a>

		<a href="defaulte.php" class="logoen2">Profil</a>
		
		
		<a href="defaultp.php" class="logoen3">Arrangementer</a>
		

				  <a href="#" class="w3-bar-item" title="My Account">
    <img src="/w3images/avatar2.png" class="w3-circle" style="height:23px;width:23px" alt="Avatar">
  </a>
  
  <a href="Passord.php" class="nullpass">Nullstill Passord</a>
  
       
		<div class="a123">
        <form method="post">
            <button type="submit" name="btn-logout" class="btn123">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
            </button>
            </form>
			</div>
            
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
