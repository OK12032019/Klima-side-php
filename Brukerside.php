<?php
$error = '';
require_once 'PDO.php';

$brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];
$debug = $_SESSION['debug'];


if($user->is_loggedin()=="")
{
  $user->redirect('Default.php');
} 
else 
{ 
  $username=$_SESSION['bnavn'];
  $fnavn=$_SESSION['fnavn'];
  $enavn=$_SESSION['enavn'];
  if($brukertype == 1)
  {
    $user->redirect('backendadmin.php');   
  }
}
if(isset($_POST['btn-logout']))
{
    if($user->logout())
    {
    $user->redirect('Default.php');
    }
    else
    {
    $error = "Kunne ikke logge ut";
    } 
}
if(isset($_POST['interesse']))
{
    $interesseid = $_POST['interesser'];
    $user->setEksisterendeInteresse($brukerid, $interesseid);
}
if(isset($_POST['nyInteresseKnapp']))
{
    $interessenavn = $_POST['nyInteresse'];
    if($user->sjekkOmInteresseEksisterer($interessenavn) == True){
        #$interessenavn = 'hahahahha';
        echo('Denne interessen finnes allerede');
    }
    else{
        $user->setInteresse($interessenavn);
    }

}
if(isset($_POST['sletteInteresseKnapp']))
{
    $interesseid = $_POST['sletteInteresser'];
    $userid = $brukerid;
    $user->sletteInteresse($userid, $interesseid);
}
#Skriver artikkel og laster opp bilde
if(isset($_POST['setArtikkel']))
{   
   
    $tittel = trim($_POST['tittel']);
    $artikkel = trim($_POST['artikkeltekst']);
    $user->largeArtikkel($tittel, $artikkel, $brukerid);
    echo $tittel;
    echo $artikkel;
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 500000) {
          $result = $user->getidArtikkel($tittel);
          var_dump($result);
          foreach($result as $row) {
            echo $row['idartikkel'], '<br>';
            $ArtikkelIDtilBilde = $row['idartikkel'];
            }
          print_r($ArtikkelIDtilBilde);
          $fileNameNew = $ArtikkelIDtilBilde.".".$fileActualExt;
          
          $fileDestination = 'uploads/'.$fileNameNew;
          move_uploaded_file($fileTempName, $fileDestination);
          $user->uploadBilde($ArtikkelIDtilBilde, $fileDestination);

        }
        else {
          echo "Your file is too big!";
        }
      }
      else {
        echo "There was an error uploading your file, try again!";
      }
    }
    else {
      echo "You cannot upload files of this type!";
    }
  }
if(isset($_POST['setProfilBilde']))
{   
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 500000) {
            $fileNameNew = $brukerid.".".$fileActualExt;
            
            $fileDestination = 'profilBilde/'.$fileNameNew;
            move_uploaded_file($fileTempName, $fileDestination);
            $user->uploadProfilBilde($fileDestination, $brukerid);

            }
            else {
            echo "Your file is too big!";
            }
        }
        else {
            echo "There was an error uploading your file, try again!";
        }
    }
    else {
    echo "You cannot upload files of this type!";
    }
}
if(isset($_POST['setBio']))
{   
   
    $Bio = trim($_POST['biotekst']);
    $user->setBeskrivelse($brukerid, $Bio);
}
if(isset($_POST['regelKnapp']))
{
    $regel = trim($_POST['regel']);
    $user->setRegel($regel);
}
$profilBilde = $user->getProfilBilde($brukerid);

if(empty($profilBilde)){
    $hvor='images/iceberg.jpg';
}
foreach($profilBilde as $row){
    $hvor=$row['hvor'];           
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
    <title>Brukerside for <?php echo $username;?></title>
</head>





<body>
    <h3>DEBUGGER:</h3>
    <?php
    var_dump($debug);
    ?>
    -->
    <div  class="container">
        <h1 style="margin-top: 150px;">Brukerside for <?php echo $username;?></h1>
        <!-- TODO Bruker bilde -->
        <div class="row">
            <div class="col s12 m6">
            <div class="section">
            <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <div class="row">
                    <div class="col s12 m6">
                        <!-- < ?php var_dump($profilBilde); ?> -->
                        <img class="responsive-img" src="<?php echo $profilBilde[0]['hvor']; ?>">
                    </div>  
                    <div class="col s12 m6">
                        <form method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="file">
                        <button type="submit" class="btn" name="setProfilBilde">
                        <i class="material-icons right">send</i>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <div class="section">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <h2>Mine Interesser</h2>
                    <ul>

                    <?php 
                    $interesseNavnArray=$user->getBrukersInterreser($brukerid);
                    foreach($interesseNavnArray as $row){
                        $interesseprint = $row['0']['interessenavn'];
                        echo ('<li>'.$interesseprint.'</li>');
                    }
                    ?>
                    </ul>
                </div>
                </div>
            </div>
            </div>
            </div>
            <div class="col s12 m6">
                <div class="card blue-grey darken-1 ">
                    <div class="card-content white-text">
                    <span class="card-title">Bio</span>
                    <p>
                        <?php $bio = $user->getBio($brukerid);
                        echo $bio[0]['beskrivelse'];
                        ?>
                    </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col m4 s12">
            <div class="card blue-grey darken-1 center-align">
            <div class="card-content white-text">
            <!-- INTERRESSER NY -->
            <!-- DROPDOWN LISTE MED ALLEREDE REGISTRERTE INTERRESER -->
            <form method="post">
            <h2> Legg til en ny interesse </h2>
            <select name ="interesser">
                <?php
                $result = $user-> getInterreser();
                foreach($result as $row)
                {
                    $interesse = $row['interessenavn'];
                    $interesseid = $row['idinteresse'];
                    echo <<<EOT
                        <option value="$interesseid">$interesse</option> 
                    EOT;

                }
                ?>
            </select>
            <button class="btn-large waves-effect waves-light" type="submit" name="interesse">Leggtil eksisterende interesse
            <i class="material-icons right">send</i>
            </button>
            </form>
            </div>
            </div>
            </div>

            <!-- SLETTE INTERESSE -->
            <div class="col m4 s12">
            <div class="card blue-grey darken-1 center-align">
            <div class="card-content white-text">
            <form method="post">
            <h2> Slett en interesse </h2>
            <select name ="sletteInteresser">
                <?php
                $result = $user-> getBrukersInterreser($brukerid);
                foreach($result as $row)
                {
                    $interesse = $row[0]['interessenavn'];
                    $interesseid = $row[0]['idinteresse'];
                    echo <<<EOT
                        <option value="$interesseid">$interesse</option> 
                    EOT;

                }
                ?>
            </select>
            <br>
            <button class="btn-large waves-effect waves-light" type="submit" name="sletteInteresseKnapp">Slette interesse
            <i class="material-icons right">send</i>
            </button>
            </form>
            </div>
            </div>
            </div>


            <!-- NY INTERESSE -->
            <div class="col m4 s12">
            <div class="card blue-grey darken-1 center-align">
            <div class="card-content white-text">
            <form method="post">
            <h2> Lag en ny interesse </h2>
            <textarea name="nyInteresse" id="nyInteresse" cols="35" rows="1" maxlength="45"></textarea>
            <button class="btn-large waves-effect waves-light" type="submit" name="nyInteresseKnapp">Leggtil ny interesse
            <i class="material-icons right">send</i>
            </button>
            </form>
            </div>
            </div>
            </div>

        </div>
        

        <!-- SKRIVE ARTIKKEL -->
        <!-- TODO DAMMEL CSS -->
        <div class="row">
            <div class="col m6 s12">
            <h1> Skriv artikkel </h1>
                <form method="post" enctype="multipart/form-data">
                <h2> tittel </h2>
                    <textarea name="tittel" id="artikkeltittel" cols="50" rows="2" maxlength="45"></textarea>
                    <h2> Artikkelinnhold</h2>
                    <textarea name="artikkeltekst" id="artikkelinnhold" cols="50" rows="8" maxlength="1000"></textarea>
                    <input type="file" name="file">
                    <button class="btn-large waves-effect waves-light" type="submit" name="setArtikkel">Publiser Artikkel
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
            <div class="col m6 s12">
            <h1>  Ny bio </h1> 
                <form method="post" enctype="multipart/form-data">
                    <textarea name="biotekst" id="artikkelinnhold" cols="50" rows="8" maxlength="1000"></textarea>
                    <input type="file" name="file">
                    <button class="btn-large waves-effect waves-light" type="submit" name="setBio">Oppdater Bio
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
        <!-- NY REGEL KUNN ADMIN -->
        <div class="row">
            <div class="col m12 s12">
            <h1> Ny regel </h1>
                <form method="post">
                <h2> tittel </h2>
                    <textarea name="regel" id="Regel" cols="50" rows="2" maxlength="45"></textarea>
                    <h2>Regel</h2>
                    <button class="btn-large waves-effect waves-light" type="submit" name="regelKnapp">Publiser regel
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
<footer class="background-color ">
<div class ="row">
<section class="col m6 s12 center-align">
<a href="">Om oss</a>
<a href="">Sidekart</a>
<a href="">Kariarre</a>
<a href="">Støtt oss</a>
<a href="">In English</a>
</section>
<section class="col m6 s12 center-align">Gruppe 30 | copyright 2019</section>
</footer>
</body>

   <!-- SKRIVE ARTIKLER TODO kun for brukertype 2elns 
        </aside>
                
            <   ?php
            //echo ('$username: ');
            //echo $username;
            //echo ('<br>');
            $interesseid = '0';
            if(isset($_POST['SubmitButton1']))
            {
                $input = $_POST['interesse1'];
                $error = 'test1';
                if($user->InteresseFinnes($input))
                {
                    $interesseid = $_SESSION['interesseid'];
                    $error = 'test2';
                    $user->SubmitButton1($brukerid,$input);
                }
                else
                {  
                
                $error = 'test3';
                if($user->nyInteresse($input))
                {
                    $error = 'testFuckYou';

                    $interesseid = $_SESSION['interesseid'];
                    $error = $_SESSION['interesseid'];
                    if($user->SubmitButton1($interesseid,$brukerid))
                    {

                        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
                        header("Pragma: no-cache"); // HTTP 1.0.
                        header("Expires: 0");
                        header('refresh:0');
                    }
                    else
                    {
                        $error='error etter eller annet';
                    }
                }
                else
                {
                    $error = 'NOOOOOOO';
                }
                }
            }
            if(isset($_POST['SubmitButton2']))
            {
                $error = 'test4';
                $input = $_POST['interesse2'];
                //echo ('username test:');
                //echo $username;
                //echo('<br>');
                $user->SubmitButton2($username,$input);
            }
            echo ('<p>'.$error.'</p>');

        
            ?>           
    </div>
    
<!-- GAMMEL INTERESSER 
<h2> Dine Intresser </h2>

< ?php
                $mysqli = new mysqli("localhost", "root", "", "klima");
                echo ($brukerid);
                echo ($username);
                $sql = "SELECT * FROM brukerinteresse WHERE bruker = '{$brukerid}';";
                $result = $mysqli->query($sql);
                if ($result) {
                    var_dump($result);
                    echo ('FUUUUUUUUUUCK!!!!!!!!!');
                    $old_result = $result;
                    while($row = mysqli_fetch_array($old_result)) {
                        echo('FUUUUCK IGJEN');
                        $stmt = "SELECT * FROM interesse WHERE idinteresse = '{$row["interesse"]}';";
                        
                        $result = $mysqli->query($stmt);
                        $row = mysqli_fetch_array($result);
                        $label = $row['interessenavn'];
                        $interesseid = $row['idinteresse'];
                        echo ' - ',$label,'<form action="" method="post">
                        <button type="submit" name="delete" value="', $interesseid, '" class="btn-link">Delete</button>
                        </form>';
                        echo '<br />';    
                        }
                }
                else {
                echo ('Du har foreløpig ingen interesser');
                }
            ?>

            <br />

            <form action="Brukerside.php" method="POST">

                <h2>Legg til din ny interesse</h2>
                <table>
                    <tr>
                        <td>interesse</td>
                        <td class="interesse"><input type="text" name="interesse1" placeholder="interesse"></td>
                    </tr>
                    </table>
                
                <input type="submit" name="SubmitButton1"/>

                <h2> Velg en interesse</h2>
                <table>
                    <tr> 
                        <td>interesse</td>
                        <td>
                        <select name="interesse2">
                            < ?php
                                $mysqli = new mysqli("localhost", "root", "", "klima");

                                $sql = "SELECT * FROM interesse";
                                $result = $mysqli->query($sql);
                                if ($result) {
                                    while($row = mysqli_fetch_array($result)) {
                                    echo "<option value='",$row['interessenavn'],"'>",$row['interessenavn'],"</option>";
                                    }

                                }
                                else {
                                    echo mysql_error();
                                }
                            ?>
                            
                        </select>
                        </td>
                    </tr>
                    </table>
                
                <input type="submit" name="SubmitButton2"/>
                </form>
                $mysqli = new mysqli("localhost", "root", "", "klima");
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['delete'])) // sjekk om "slett interesse" -handlinger ble utført
{
    $mysqli = new mysqli("localhost", "root", "", "klima");
  // mottar  brukerid og interest id
  $stmt = "SELECT idbruker FROM bruker WHERE brukernavn = '{$username}';";
  $result = $mysqli->query($stmt);
  $row = mysqli_fetch_array($result);
  $userid = $row['idbruker'];
  $interesseid = $_POST['delete'];

  // slettinv av brukerens interesser. 
  echo $userid;
  echo $interesseid;
  $user->sletteInteresse($userid, $interesseid);
}
                            -->
</html>
