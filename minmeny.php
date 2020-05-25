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
        <a href="Default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="Backend.php">Artikler</a></li>
        <li><a href="Brukerside.php">Profil</a></li>
        <li><a href="Sok.php">Administrere brukere</a></li>
        <li><a href="Meldinger.php">Meldinger</a></li>
        <li><a href="Regelside.php">Regler</a></li>
        <li><a href="Lesmelding.php">Lesmelding</a></li>
        <li><a href="Nymelding.php">Nymelding</a></li>
        <li><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
        </ul>
    </div>
    <div class="nav-content">
        <ul class="tabs tabs-transparent">
            <li class="tab disabled">ADMIN VERKTØY:</a></li>
            <li class="tab"><a href="Backend.php">Advare Brukeren</a></li>
            <li class="tab"><a href="Brukerside.php">Karantene Ekskluderer Bruker</a></li>
            <li class="tab"><a href="Sok.php">Avregistrering Bruker</a></li>
            <li class="tab"><a href="Meldinger.php">Rapport om Brukermisbruk</a></li>
            <li class="tab"><a href="Regelside.php">Rediger Regler</a></li>
            <li class="tab"><a href="Lesmelding.php">Kvalifiser Bruker</a></li>
        </ul>
    </div>
</nav>   

	<?php
   }
else if($btype == 2){

   
    ?>
	
    <nav>
    <div class="nav-wrapper">
        <a href="Default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="Backend.php">Artikler</a></li>
        <li><a href="Brukerside.php">Profil</a></li>
        <li><a href="Sok.php">Administrere brukere</a></li>
        <li><a href="Meldinger.php">Meldinger</a></li>
        <li><a href="Regelside.php">Regler</a></li>
        <li><a href="Lesmelding.php">Lesmelding</a></li>
        <li><a href="Nymelding.php">Nymelding</a></li>
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
        $user->redirect('Default.php');
    }
    elseif ($tildato < date()){
        $user->deleteEkskludering($brukerid);
    }
}
     ?>
     <nav class="nav-extended">
    <div class="nav-wrapper">
        <a href="Default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="Backend.php">Artikler</a></li>
		<li><a href="Brukerside.php">Profil</a></li>
		<li><a href="Backend.php">Arrangementer</a></li>
		<li><a href="sok.php">Søk</a></li>
		<li><a href="Meldinger.php">Meldinger</a></li>
		<li><a href="Rapport.php">Rapporter bruker</a></li>
		<li><a href="Passord.php">Nullstill Passord</a></li>
        <li><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
        </ul>
    </div>
</nav>
    
	 <?php
   }

   
else{
   ?>
<nav>
<div class="nav-wrapper">
    <a href="Default.php" class="brand-logo"><img src="images/Klimalogo.png" alt="Logoen" style="width:60px;"><img></a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
    <li><a href="Logginn.php">Logg inn</a></li>
    <li><a href="Registrer.php">Registrer</a></li>
    </ul>
</div>
</nav>   
	 <?php
   }
    ?>
