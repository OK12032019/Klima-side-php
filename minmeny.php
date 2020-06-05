<?php
require_once 'PDO.php';

if($user->is_loggedin()=="True")
{
$btype = $_SESSION['btype'];
}
else{
    $btype = 0;
}

/* For Admin Option*/
if($btype == 1){

   ?>   

    <nav class>
        <div class="nav-wrapper">
            <a href="default.php" class="brand-logo"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
            <a href="javascript:void(0);" onclick="myFunction()" data-target="mobile-demo" class="top-nav sidenav-trigger hide-on-large-only   "><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="Artikkler.php">Artikler</a></li>
                <li><a href="brukerside.php">Profil</a></li>
                <li><a href="sok.php">Administrere brukere</a></li>
                <li><a href="meldinger.php">Meldinger</a></li>
                <li><a href="regelside.php">Regler</a></li>
                <li><a href="nymelding.php">Ny melding</a></li>
                <li><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
            </ul>
        </div>
    </nav>


    <ul class="sidenav hide-on-large-only" id="mobile-demo">
        <li><a href="artikkler.php">Artikler</a></li>
        <li><a href="brukerside.php">Profil</a></li>
        <li><a href="sok.php">Administrere brukere</a></li>
        <li><a href="meldinger.php">Meldinger</a></li>
        <li><a href="regelside.php">Regler</a></li>
        <li><a href="nymelding.php">Nymelding</a></li>
        <li><a href="logout.php">Logg ut</a></li>
    </ul>
    

	<?php
   }
else if($btype == 2){
    /* For User option*/  

    ?>
	
    <nav class>
        <div class="nav-wrapper">
            <a href="default.php" class="brand-logo"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
            <a href="javascript:void(0);" onclick="myFunction()" data-target="mobile-demo" class="top-nav sidenav-trigger hide-on-large-only   "><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="Artikkler.php">Artikler</a></li>
                <li><a href="brukerside.php">Profil</a></li>
                <li><a href="sok.php">Administrere brukere</a></li>
                <li><a href="meldinger.php">Meldinger</a></li>
                <li><a href="regelside.php">Regler</a></li>
                <li><a href="nymelding.php">Ny melding</a></li>
                <li><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
            </ul>
        </div>
    </nav>


    <ul class="sidenav hide-on-large-only" id="mobile-demo">
        <li><a href="artikkler.php">Artikler</a></li>
        <li><a href="brukerside.php">Profil</a></li>
        <li><a href="sok.php">Administrere brukere</a></li>
        <li><a href="meldinger.php">Meldinger</a></li>
        <li><a href="regelside.php">Regler</a></li>
        <li><a href="nymelding.php">Ny Melding</a></li>
        <li><a href="logout.php">Logg ut</a></li>
    </ul>
    
	
		<?php 
   }
 else if($btype== 3){
    #$user->getEkskludering($brukerid)
    #$tildato = 
    $brukerid = $_SESSION['brukerid'];
/* Get Exclusion of user*/
$result=$user->getEkskludering($brukerid);
foreach($result as $row) {
    $tildato = $row['datotil'];
    /* Til dato must be smaller than current date*/
    if($tildato > date()){
        $user->logout();
        $user->redirect('default.php');
    }/* Otherwise delete*/
    elseif ($tildato < date()){
        $user->deleteEkskludering($brukerid);
    }
}

     ?>
    <nav class>
        <div class="nav-wrapper">
            <a href="default.php" class="brand-logo"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
            <a href="javascript:void(0);" onclick="myFunction()" data-target="mobile-demo" class="top-nav sidenav-trigger hide-on-large-only   "><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li class="customLi"><a href="artikkler.php">Artikler</a></li>
                <li class="customLi"><a href="brukerside.php">Profil</a></li>
                <li class="customLi"><a href="regelside.php">Regler</a></li>
                <li class="customLi"><a href="backend.php">Arrangementer</a></li>
                <li class="customLi"><a href="sok.php">Søk</a></li>
                <li class="customLi"><a href="meldinger.php">Meldinger</a></li>
                <li class="customLi"><a href="rapport.php">Rapporter bruker</a></li>
                <li class="customLi"><a href="passord.php">Nullstill Passord</a></li>
                <li class="customLi"><a href="nymelding.php">Ny melding</a></li>
                <li class="customLi"><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
            </ul>
        </div>
    </nav>


    <ul class="sidenav hide-on-large-only" id="mobile-demo">
        <li><a href="artikkler.php">Artikler</a></li>
        <li><a href="brukerside.php">Profil</a></li>
        <li><a href="backend.php">Arrangementer</a></li>
        <li><a href="sok.php">Søk</a></li>
        <li><a href="meldinger.php">Meldinger</a></li>
        <li><a href="rapport.php">Rapporter bruker</a></li>
        <li><a href="passord.php">Nullstill Passord</a></li>
        <li><a class="waves-effect waves-light btn-large" href="logout.php">Logg ut</a></li>
    </ul>

    
	 <?php
   }

   
else{
   ?>
    <nav>
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"><img></a>
            <a href="javascript:void(0);" onclick="myFunction()" data-target="mobile-demo" class="top-nav sidenav-trigger hide-on-large-only   "><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="registrer.php">Registrer</a></li>
                <li><a href="logginn.php">Logg Inn</a></li>
            </ul>
        </div>
    </nav>

  <ul class="sidenav hide-on-large-only" id="mobile-demo">
    <li><a href="registrer.php">Registrer</a></li>
    <li><a href="logginn.php">Logg Inn</a></li>
  </ul>

	 <?php
   }
    ?>
<script>
function myFunction() {
  var x = document.getElementById("mobile-demo");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>