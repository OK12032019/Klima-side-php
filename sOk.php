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

<!-- <table border="1" cellspacing="5" cellpadding="5" width="100%">
	<thead>
		<tr>
			<th>No.</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>User Name</th>
		</tr>
	</thead>
	<tbody>

<?php/* 
$db = $DB_con;
$getPlayers = $db->query("SELECT * FROM bruker");
foreach ($getPlayers as $row) {
	?>
		<tr>
			<td><label><?php echo $row['idbruker']; ?></label></td>
			<td><label><?php echo $row['fnavn']; ?></label></td>
			<td><label><?php echo $row['enavn']; ?></label></td>
			<td><label><?php echo $row['brukernavn']; ?></label></td>
		</tr>
        <?php 
        
        } ?>
        
</table> */ ?>