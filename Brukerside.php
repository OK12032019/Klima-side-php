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


?>

<html>
<head>
    <link rel="stylesheet" href="FellesCSS.css">
    <title>Test Backend</title>
</head>
<body>
    <!-- <header class="hovedheader">
        <a href="default.php" class="logoen"> LOGO</a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <ul class="menu">
            <li><a href="interesse.php">Intereser</a></li>
                <form method="post">
                    <button type="submit" name="btn-logout" class="btn btn-block btn-primary">
                        <i class="glyphicon glyphicon-log-in"></i>&nbsp;Logg ut
                    </button>
                </form>
             <li><a href="Passord.php">Nullstill Passord</a></li>
        </ul> 
    </header>
    -->

    <aside class="brukertekst">
        <div class="artikkeltekstarea">
        <form method="post">
            <textarea name="tittel" id="artikkeltittel" cols="30" rows="10"></textarea>
            <textarea name="artikkeltekst" id="artikkelinnhold" cols="30" rows="10"></textarea>
           
        
            <!-- <input type="text" name="tittel" placeholder="Skriv inn tittelen" class="brukertittel">
            <input type="text" name="brukerartikkel" class="brukerinnlegg"> -->
        </div>

        <div class="form-container">
           
                <div class="form-group">
                </div>
                    <div class="clearfix"></div><hr />
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" name="registrer">
                            <i class="glyphicon glyphicon-open-file"></i>&nbsp;lagre                            </button>
                    </div>
                </div>
            </form>
        </div>

    </aside>

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

    <div  class="brukerside">
        <h1>Brukerside for '<?php echo $username;?>'</h1>

        <div class="brukerbilde">
            <img src="img/bruker.png" alt="Default brukerbilde">
        </div>

            <p>Full navn: <?php echo $fnavn; echo(' '); echo $enavn;?></p>

            


            <h2> Dine Intresser </h2>

            <?php
                $mysqli = new mysqli("localhost", "root", "", "klima");

                $stmt = "SELECT idbruker FROM bruker WHERE brukernavn = '{$username}';";
                $result = $mysqli->query($stmt);
                $row = mysqli_fetch_array($result);
                $brukerid = $row['idbruker'];

                $sql = "SELECT * FROM brukerinteresse WHERE bruker = '{$brukerid}';";
                $result = $mysqli->query($sql);
                if ($result) {
                $old_result = $result;
                while($row = mysqli_fetch_array($old_result)) {
                    $stmt = "SELECT interessenavn FROM interesse WHERE idinteresse = '{$row["interesse"]}';";

                    $result = $mysqli->query($stmt);
                    $row = mysqli_fetch_array($result);
                    $label = $row['interessenavn'];
                    echo ' - ',$label;
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
                    $user->SubmitButton1($interesseid,$brukerid);
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
