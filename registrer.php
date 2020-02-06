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
      $error[] = "provide username !"; 
   }
   else if($epost=="") {
      $error[] = "provide email id !"; 
   }
   else if(!filter_var($epost, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   }
   else if($pw=="") {
      $error[] = "provide password !";
   }
   else if(strlen($pw) < 6){
      $error[] = "Password must be atleast 6 characters"; 
   }
   else
   {
      try
      {
         $stmt = $DB_con->prepare("SELECT brukernavn,epost FROM bruker WHERE brukernavn=:bnavn OR epost=:epost");
         $stmt->execute(array(':bnavn'=>$bnavn, ':epost'=>$epost));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if($row['brukernavn']==$bnavn) {
            $error[] = "sorry username already taken !";
         }
         else if($row['epost']==$epost) {
            $error[] = "sorry email id already taken !";
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
  <body>
<div class="container">
     <div class="form-container">
        <form method="post">
            <h2>Sign up.</h2><hr />
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
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
            }
            ?>
            <div class="form-group">
            <input type="text" class="form-control" name="Brukernavn" placeholder="Enter Username" value="<?php if(isset($error)){echo $bnavn;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="Epost" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $epost;}?>" />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="Passord" placeholder="Enter Password" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Fnavn" placeholder="Fornavn" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Enavn" placeholder="Etternavn" />
            </div>
            <div class="form-group">
             <input type="text" class="form-control" name="Telefon" placeholder="Telefon nummer" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="registrer">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ! <a href="index.php">Sign In</a></label>
        </form>
       </div>
</div>

</body>
</html>