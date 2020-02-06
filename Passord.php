<?php

require_once 'PDO.php';

SESSION_START();
$USER = $_SESSION['user_session'];
if (EMPTY($_SESSION['user_session'] )) {
    
	header('Location: default.php');

} 


if(isset($_POST['PassordReset']))
{
  $bnavn = $_POST['Brukernavn'];
  $pw = $_POST['pass'];
  $npw = $_POST['npass'];
  $npw2 = $_POST['npass2'];
  if($npw!=$npw2)
    {
      $error[] = "Nye passord stemmer ikke overens";
    }
  else
    {
    try
    {  
      if($user->PassordReset($bnavn,$pw,$npw))
        {
        $user->redirect('Backend.php');
        }
      else
        {
        $error[] = "Wrong !";
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
        <title>Passord</title>
    </head>

    <body>
        <main>
            <header class="hovedheader">
                <a href="default.php" class="logoen">LOGO</a>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
                <ul class="menu">
                  <li><a href="logginn.html">Logg inn</a></li>
                  <li><a href="registrer.html">Registrer</a></li>
                </ul>
            </header>

            
            <div class="Passord">
                <form method="POST">
                  <h1>Nytt Passord</h1>
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
            ?>
                  <p>Vennligst skriv inn brukernavnet din og det nye passordet</p>
                    <table>
                        <tr>
                            <td>Brukernavn:</td> 
                            <td class="regtextbox"><input type="text" name="Brukernavn" placeholder="Epost" value="<?php if(isset($error)){echo $bnavn;}?>"></td>
                        </tr>
                        <tr>
                            <td>Gammelt Passord:</td> 
                            <td class="regtextbox"><input type="password" name="pass" placeholder="passord" value="<?php if(isset($error)){echo $pass;}?>"></td>
                        </tr>
                        <tr>
                            <td>Nytt Passord:</td> 
                            <td class="regtextbox"><input type="password" name="npass" placeholder="Passord"></td>
                        </tr>
                        <tr>
                            <td>Nytt Passord:</td> 
                            <td class="regtextbox"><input type="password" name="npass2" placeholder="Passord"></td>
                        </tr>
                        </table>
                    <input type='submit' id='btn' value='PassordReset' name='PassordReset' />
                </form>
            </div>
        </main>
    </body>
</html>