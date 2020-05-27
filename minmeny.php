<?php
require_once 'PDO.php';

if($user->is_loggedin()=="True")
{
$btype = $_SESSION['btype'];
}
else{
    $btype = 0;
}

if($btype == 1){

   ?>
   <script type="text/javascript" src="js/materialize.js">
    </script>
<nav class="nav-extended">
    <div class="nav-wrapper">
        <a href="default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="backend.php">Artikler</a></li>
        <li><a href="brukerside.php">Profil</a></li>
        <li><a href="sok.php">Administrere brukere</a></li>
        <li><a href="meldinger.php">Meldinger</a></li>
        <li><a href="regelside.php">Regler</a></li>
        <li><a href="lesmelding.php">Lesmelding</a></li>
        <li><a href="nymelding.php">Nymelding</a></li>
        <li><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
        </ul>
    </div>
    <div class="nav-content">
        <ul class="tabs tabs-transparent">
            <li class="tab disabled">ADMIN VERKTØY:</a></li>
            <li class="tab"><a href="backend.php">Advare Brukeren</a></li>
            <li class="tab"><a href="brukerside.php">Karantene Ekskluderer Bruker</a></li>
            <li class="tab"><a href="sok.php">Avregistrering Bruker</a></li>
            <li class="tab"><a href="meldinger.php">Rapport om Brukermisbruk</a></li>
            <li class="tab"><a href="regelside.php">Rediger Regler</a></li>
            <li class="tab"><a href="lesmelding.php">Kvalifiser Bruker</a></li>
        </ul>
    </div>
</nav>   

	<?php
   }
else if($btype == 2){

   
    ?>
	
    <nav>
    <div class="nav-wrapper">
        <a href="default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
        <ul id="nav-mobile" class="right">
        <li><a href="backend.php">Artikler</a></li>
        <li><a href="brukerside.php">Profil</a></li>
        <li><a href="sok.php">Administrere brukere</a></li>
        <li><a href="meldinger.php">Meldinger</a></li>
        <li><a href="regelside.php">Regler</a></li>
        <li><a href="lesmelding.php">Lesmelding</a></li>
        <li><a href="nymelding.php">Nymelding</a></li>
        <li><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
        </ul>
    </div>
</nav>
	
		<?php 
   }
 else if($btype== 3){
    #$user->getEkskludering($brukerid)
    #$tildato = 
    $brukerid = $_SESSION['brukerid'];

$result=$user->getEkskludering($brukerid);
foreach($result as $row) {
    $tildato = $row['datotil'];
    if($tildato > date()){
        $user->logout();
        $user->redirect('default.php');
    }
    elseif ($tildato < date()){
        $user->deleteEkskludering($brukerid);
    }
}
     ?>
     <nav class="nav-extended">
    <div class="nav-wrapper">
        <a href="default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
        <ul id="nav-mobile" class="right ">
        <li class="customLi"><a href="artikkler.php">Artikler</a></li>
		<li class="customLi"><a href="brukerside.php">Profil</a></li>
		<li class="customLi"><a href="backend.php">Arrangementer</a></li>
		<li class="customLi"><a href="sok.php">Søk</a></li>
		<li class="customLi"><a href="meldinger.php">Meldinger</a></li>
		<li class="customLi"><a href="rapport.php">Rapporter bruker</a></li>
		<li class="customLi"><a href="passord.php">Nullstill Passord</a></li>
        <li class="customLi"><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
        </ul>
    </div>
</nav>
    
	 <?php
   }

   
else{
   ?>
<nav>
<div class="nav-wrapper">
    <a href="default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:60px;"><img></a>
    <ul id="myLinks" class="right Mobil">
    <li class="test"><a href="logginn.php">Logg inn</a></li>
    <li class="test"><a href="registrer.php">Registrer</a></li>
</ul>
</div>
<a href="javascript:void(0);" class="icon invis" onclick="myFunction()">
    <i class="material-icons right">send</i>
  </a>
</nav>

	 <?php
   }
    ?>
<script>
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
