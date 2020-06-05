<?php
require_once 'PDO.php';


if($user->is_loggedin()!="")
{
    $user->redirect('backend.php');
}

/* When User SignUp*/
if(isset($_POST['registrer']))
{
   $bnavn = trim($_POST['Brukernavn']);
   $epost = trim($_POST['Epost']);
   $pw = trim($_POST['Passord']);
   $fnavn = trim($_POST['Fnavn']);
   $enavn = trim($_POST['Enavn']);
   $telefon = trim($_POST['Telefon']);
   $btype= "3";

   /* Validation for Registration */
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
         /* Get Users */
         $stmt = $DB_con->prepare("SELECT brukernavn,epost FROM bruker WHERE brukernavn=:bnavn OR epost=:epost");
         $stmt->execute(array(':bnavn'=>$bnavn, ':epost'=>$epost));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         /* condition for already exist user name and email*/
         if($row['brukernavn']==$bnavn) {
            $error[] = "Bekalger, brukernavnen er allerede i bruk!";
         }
         else if($row['epost']==$epost) {
            $error[] = "Beklager, emailen er allerede i bruk!";
         }
         else
         {
              /* Otherwise registered user with given data*/
            if($user->register($bnavn,$epost,$pw,$btype,$fnavn,$enavn,$telefon,$btype)) 
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
       <!--  Register Form -->
        <form method="post">
            <h2 style="text-align:center;">Registrering</h2><hr />
            <?php
            if(isset($error))
            {
               /* Show Errors */
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
            <input type="text" class="form-control" name="Brukernavn" placeholder="Skriv inn brukernavn"" value="<?php if(isset($error)){echo $bnavn;}?>" />
            </div>
            <div class="form-group">
            <input type="email" class="form-control" name="Epost" placeholder="Skriv inn epost" value="<?php if(isset($error)){echo $epost;}?>" />
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
            <div class="form-group">
               <label>Har du konto? <a style="font-weight:bold" href="logginn.php">Log Inn Her</a></label>
            </div>
        </form>
       </div>
   </div>
</div>


</body>
<?php
include "./includefooter.php";
?>
</html>
