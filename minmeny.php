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
  
         <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"></img></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
		<li><a href="Backend.php" class="mellomrom1">Artikler</a></li>
		<li><a href="Brukerside.php" class="mellomrom1">Profil</a></li>
		<li><a href="Sok.php" class="mellomrom2">Administrere brukere</a></li>
		<li><a href="Meldinger.php" class="mellomrom1">Meldinger</a></li>
		<li><a href="Regelside.php" class="mellomrom1">Regler</a></li>
		<li><a href="Lesmelding.php" class="mellomrom1">Lesmelding</a></li>
		<li><a href="Nymelding.php" class="mellomrom1">Nymelding</a></li>
		<div class="e123">
            <form method="post">
        <button type="submit" name="btn-logout" class="btn1 btn-block btn-primary">
            <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
        </button>
        </form>
        </div>
        </ul>
        <!-- ####### FOR ADMINISTRATOR MENY ######### -->
        <ul class="menu">
		<li><a href="Backend.php" class="mellomrom1">Advare Brukeren</a></li>
		<li><a href="Brukerside.php" class="mellomrom1">Karantene Ekskluderer Bruker</a></li>
		<li><a href="Sok.php" class="mellomrom2">Avregistrering Bruker</a></li>
		<li><a href="Meldinger.php" class="mellomrom1">Rapport om Brukermisbruk</a></li>
		<li><a href="Regelside.php" class="mellomrom1">Rediger Regler</a></li>
		<li><a href="Lesmelding.php" class="mellomrom1">Kvalifiser Bruker</a></li>
        </ul>     
    </header>
	<?php
   }
else if($btype == 2){

   
    ?>
	
       <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"></img></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
		<li><a href="Brukerside.php" class="mellomrom1">Skrive artikler</a></li>
		<li><a href="Backend.php" class="mellomrom1">Meny</a></li>
		<li><a href="Meldinger.php" class="mellomrom1">Meldinger</a></li>
		<li><a href="Rapport.php" class="mellomrom1">Rapporter bruker</a></li>
			 <div class="e123">
            <form method="post">    
        <button type="submit" name="btn-logout" class="btn1 btn-block btn-primary">
            <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
        </button>
        </form>
        </div>
    </ul>   
        </ul> 
    </header>
	
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
       <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png"style="width:48px;"></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
		<li><a href="Backend.php" class="logoen1">Artikler</a></li>
		<li><a href="Brukerside.php" class="logoen2">Profil</a></li>
		<li><a href="Backend.php" class="logoen3">Arrangementer</a></li>
		<li><a href="sok.php" class="logoen1">Søk</a></li>
		<li><a href="Meldinger.php" class="logoen1">Meldinger</a></li>
		<li><a href="Rapport.php" class="mellomrom1">Rapporter bruker</a></li>
		<li><a href="Passord.php" class="nullpass">Nullstill Passord</a></li>
        <div class="a123">
        <form method="post">
            <button type="submit" name="btn-logout" class="btn btn-block btn-primary">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
            </button>
            </form>
        </div>
        </ul>   
    </header>
	 <?php
   }

   
else{
   echo "Du er ikke logget inn";
   ?>
       <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:73px;"></img></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="Logginn.php">Login</a></li>
            <li><a href="Registrer.php">Registrer</a></li>
        </ul>   
    </header>
	 <?php
   }
    ?>
