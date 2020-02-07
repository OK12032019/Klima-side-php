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
<html>
<body>
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
        <h2>Søk.</h2><hr />
        <div class="form-group">
            <input type="text" class="form-control" name="brukernavn" placeholder="Enter Username" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="registrer">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            </form>
    
</main>
</body>
</html>
