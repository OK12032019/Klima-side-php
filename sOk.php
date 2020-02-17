<?php
include_once "PDO.php"; 



if($user->is_loggedin()=="")
{
    $user->redirect('default.php');
}
else {
	$fnavn = $_SESSION['fnavn'];
	$enavn = $_SESSION['enavn'];
}
// elias push
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

<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset ="UTF-8">
    <link rel="stylesheet" href="FellesCSS.css">
    <title>Søk på Bruker</title>
</head>
<body>

    <header class="hovedheader">
        <a href="default.php" class="logoen"><img src="img/Klimalogo.png"style="width:80px;"></a>
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
		
		            <a href="#" class="w3-bar-item" title="Konto">
                <a href="Brukerside.php"><img src="img/Bruker.png" class="w3-circle" style="height:28px;width:38px" alt="Avatar"> </a>
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

<main>

<br>
<br>
<br>
<br>
<br>
<br>
<table border="1" cellspacing="5" cellpadding="5" width="100%">
	<thead>
		<tr>
			<th>brukernavn</th>
		</tr>
	</thead>
	<tbody>
<?php
if(isset($_POST['registrer']))
{
    $brukersOk= trim($_POST['brukernavn']);
    if($result=$user->sOk($brukersOk))
    {
            ?>
                <tr>
                    <td><label><?php echo ($brukersOk); ?></label></td>
                </tr>
                <?php
    } ?>
</tbody>

    <?php } ?>
<div class="container">
<div class="form-container">
        <form method="post">
        <h2 id="Mellomrom4">Søk.</h2><hr />
        <div class="form-group">
            <input type="text" class="form-control" name="brukernavn" placeholder="Enter Username" id="Mellomrom5"/>
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="registrer">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;Søk
                </button>
            </div>
            </form>
    
</main>
</body>

</html>
