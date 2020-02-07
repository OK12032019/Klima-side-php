<?php
require_once 'PDO.php';

$btype = '3';

if($user->is_loggedin()!="")
{
    $user->redirect('Backend.php');
}

if(isset($_POST['registrer']))
{
   $bnavn = trim($_POST['Brukernavn']);
   $epost = trim($_POST['Epost']);
   $pw = trim($_POST['Passord']);
   $fnavn = trim($_POST['Fnavn']);
   $enavn = trim($_POST['Enavn']);
   $telefon = trim($_POST['Telefon']);
 
   if($bnavn=="") {
      $error[] = "Oppgi brukernavn!"; 
   }
   else if($epost=="") {
      $error[] = "Oppgi epost!"; 
   }
   else if(!filter_var($epost, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Oppgi gyldig epost!';
   }
   else if($pw=="") {
      $error[] = "Oppgi passord!";
   }
   else if(strlen($pw) < 6){
      $error[] = "Passord må være i hvert fall 6 tegn"; 
   }
   else
   {
      try
      {
         $stmt = $DB_con->prepare("SELECT brukernavn,epost FROM bruker WHERE brukernavn=:bnavn OR epost=:epost");
         $stmt->execute(array(':bnavn'=>$bnavn, ':epost'=>$epost));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if($row['brukernavn']==$bnavn) {
            $error[] = "Bekalger, brukernavnen er allerede i bruk!";
         }
         else if($row['epost']==$epost) {
            $error[] = "Beklager, emailen er allerede i bruk!";
         }
         else
         {
            if($user->register($bnavn,$epost,$pw,$btype,$fnavn,$enavn,$telefon)) 
            {
                $user->redirect('logginn.php');
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}

?>
<html>
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script language="Javascript" src=""></script>
  <link rel="stylesheet" href="FellesCSS.css">  
  <title>Registrering</title>
  </head>
  	    <header class="hovedheader">

        <a href="default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:80px;"></img></a>

        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="Default.php">Hovedside</a></li>
            <li><a href="logginn.php">Logg inn</a></li>
        </ul>   
    </header>
  <body>
  <div class="femti">
<div class="container">
     <div class="form-container">
        <form method="post">
            <h2>Registrering</h2><hr />
            <?php
            if(isset($error))
            {
               foreach($error as $error)
               {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                  </div>
                  <?php
               }
            }
            else if(isset($_GET['joined']))
            {
                 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Registrering vellykket. <a href='index.php'>Log inn</a> her
                 </div>
                 <?php
            }
            ?>
            <div class="form-group">
            <input type="text" class="form-control" name="Brukernavn" placeholder="Skriv inn brukernavn" value="<?php if(isset($error)){echo $bnavn;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="Epost" placeholder="Skriv inn epost" value="<?php if(isset($error)){echo $epost;}?>" />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="Passord" placeholder="Skriv inn passord" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Fnavn" placeholder="Fornavn" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Enavn" placeholder="Etternavn" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Telefon" placeholder="Telefonnummer" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="registrer">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;REGISTRER
                </button>
            </div>
            <br />
            <label>Har du konto? <a href="logginn.php">Log inn</a></label>
        </form>
       </div>
</div>
</div>

</body>
</html>