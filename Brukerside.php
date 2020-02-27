<?php
$error = '';
require_once 'PDO.php';

$Brukertype = $_SESSION['btype'];
$brukerid = $_SESSION['brukerid'];

if($user->is_loggedin()=="")
{
  $user->redirect('Default.php');
} 
else 
{ 
  $username=$_SESSION['bnavn'];
  $fnavn=$_SESSION['fnavn'];
  $enavn=$_SESSION['enavn'];
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
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['delete'])) // sjekk om "slett interesse" -handlinger ble utført
{
    $mysqli = new mysqli("localhost", "Logginn", "asd", "klima");
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

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset ="UTF-8">
    <link rel="stylesheet" href="FellesCSS.css">
    <title>Brukerside for <?php echo $username;?></title>
</head>


    <header class="hovedheader">
        <a href="Default.php" class="logoen"><img src="img/Klimalogo.png" alt="Logoen" style="width:80px;"></img></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="Interesse.php" class="mellomrom1">Intereser</a></li>
			 <li><a href="Backend.php" class="mellomrom1">Hovedside</a></li>
			 <li><a href="Sok.php" class="mellomrom2">Søk</a></li>
			 <li><a href="Passord.php" class="mellomrom3">Nullstill Passord</a></li>
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


<body>
    <!-- <header class="hovedheader">
        <a href="Default.php" class="logoen"> LOGO</a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="Interesse.php">Intereser</a></li>
                <form method="post">
                    <button type="submit" name="btn-logout" class="btn btn-block btn-primary">
                        <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
                    </button>
                </form>
             <li><a href="Passord.php">Nullstill Passord</a></li>
        </ul> 
    </header>
    -->



 

    <div  class="brukerside">
        <h1>Brukerside for '<?php echo $username;?>'</h1>

        <div class="brukerbilde">
            <img src="img/bruker.png" alt="Default brukerbilde">
        </div>

            <p>Full navn: <?php echo $fnavn; echo(' '); echo $enavn;?></p>

            


            <h2> Dine Intresser </h2>

            <?php
                $mysqli = new mysqli("localhost", "Logginn", "asd", "klima");

                $stmt = "SELECT idbruker FROM bruker WHERE brukernavn = '{$username}';";
                $result = $mysqli->query($stmt);
                $row = mysqli_fetch_array($result);
                $brukerid = $row['idbruker'];

                $sql = "SELECT * FROM brukerinteresse WHERE bruker = '{$brukerid}';";
                $result = $mysqli->query($sql);
                if ($result) {
                $old_result = $result;
                while($row = mysqli_fetch_array($old_result)) {
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
                            <?php 
                                $mysqli = new mysqli("128.39.19.159", "usr_klima", "pw_klima", "klima");

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
				
				<h1> Skriv artikkel </h1> 
    <aside class="brukertekst">
        <div class="artikkeltekstarea">
        <form method="post">
		<h2> tittel </h2>
            <textarea name="tittel" id="artikkeltittel" cols="50" rows="2"></textarea>
			<h2> Artikkelinnhold</h2>
            <textarea name="artikkeltekst" id="artikkelinnhold" cols="50" rows="8"></textarea>
           
        
            <!-- <input type="text" name="tittel" placeholder="Skriv inn tittelen" class="brukertittel">
            <input type="text" name="brukerartikkel" class="brukerinnlegg"> -->
        </div>

        <div class="form-container">
           
                <div class="form-group">
                </div>
                    <div class="clearfix"></div><hr />
                    <div class="form-group">
					<div class="a1">
                        <button type="submit" class="btn btn-block btn-primary" name="registrer">
                            <i class="glyphicon glyphicon-open-file"></i>&nbsp;lagre                            </button>
							</div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        if(isset($_POST['registrer']))
        {   
   
            $tittel = trim($_POST['tittel']);
            $artikkel = trim($_POST['artikkeltekst']);
            $user->largeArtikkel($tittel, $artikkel, $brukerid);
            echo $tittel;
            echo $artikkel;
        }
    ?>

    </aside>
                
            <?php
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
