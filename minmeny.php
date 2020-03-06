<?php
require_once 'PDO.php';

$btype = $_SESSION['btype'];



if($btype == 1){

   ?>
  
         <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"></img></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="Interesse.php" class="mellomrom1">Artikler</a></li>
			 <li><a href="Backend.php" class="mellomrom1">Profil</a></li>
			 <li><a href="Sok.php" class="mellomrom2">Administrere brukere</a></li>
			 
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
else if($btype == 2){

   
    ?>
	
       <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:48px;"></img></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="Interesse.php" class="mellomrom1">Skrive artikler</a></li>
			 <li><a href="Backend.php" class="mellomrom1">Meny</a></li>
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

     ?>
       <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png"style="width:48px;"></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
		            <a href="#" class="w3-bar-item" title="Konto">
                <a href="Brukerside.php"<img src="Bruker.png" class="w3-circle" style="height:28px;width:38px" alt="Avatar"> </a>
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
            <li><a href="registrer.php">Registrer</a></li>
        </ul>   
    </header>
	 <?php
   }
    ?>
