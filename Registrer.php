<?php
require_once 'PDO.php';


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
   $btype= trim($_POST['Brukertype']);
 
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
   else if($btype=="") {
      $error[] = "Oppgi brukertype!";
	  
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
            if($user->register($bnavn,$epost,$pw,$btype,$fnavn,$enavn,$telefon,$btype)) 
            {
                $user->redirect('Logginn.php');
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}
include "./minmeny.php";
?>

<!DOCTYPE HTML>
<html>
  <head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <link type="text/css" rel="stylesheet" href="css/Flat.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
	<meta charset ="UTF-8">
  <title>Registrering</title>
  </head>
 
  <body>
  <div class="femti">
<div class="container">
     <div class="form-container">
        <form method="post">
            <h2 style="text-align:center;">Registrering</h2><hr />
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
            <input type="text" class="form-control" name="Brukernavn" placeholder="Skriv inn brukernavn" style="margin-left:510px;" value="<?php if(isset($error)){echo $bnavn;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="Epost" placeholder="Skriv inn epost" style="margin-left:510px; value="<?php if(isset($error)){echo $epost;}?>" />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="Passord" placeholder="Skriv inn passord" style="margin-left:510px;" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Fnavn" placeholder="Fornavn" style="margin-left:510px;" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Enavn" placeholder="Etternavn" style="margin-left:510px;" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Telefon" placeholder="Telefonnummer" style="margin-left:510px;" />
            </div>
			<div class="form-group">
             <input type="text" class="form-control" name="Brukertype" placeholder="Brukertype" style="margin-left:510px;" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="registrer">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;REGISTRER
                </button>
            </div>
            <br />
            <label style="margin-left:496px;">Har du konto? <a href="Logginn.php">Log inn</a></label>
        </form>
       </div>
   </div>
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