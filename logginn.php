<?php
	session_start();
    $SALT = 'IT2_2020';
	
	$USER = $_POST['user'];
	$PASS = $_POST['pass'];
	
	$USER = stripcslashes($USER);
	$PASS = stripcslashes($PASS);
	// $USER = mysql_real_escape_string($USER);
	// $USER = mysql_real_escape_string($PASS);
	
	$PW= sha1($SALT.$PASS);
	
	$mysqli = new mysqli("localhost", "root", "", "bruker");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	echo $mysqli->host_info . "\n";
	
	
	$RESULT = mysqli_query($mysqli, "select * from users where epost = '{$USER}' and passord = '{$PW}'");
	$ROW = mysqli_fetch_array($RESULT);
	if ($ROW['epost'] == $USER && $ROW['passord'] == $PW) {
		header('Location: backend.php');
		$_SESSIONS['bruker'] = $bruker;
		$_SESSIONS['brukertype'] = $row['brukertype'];
		
	}
	
	else {
         header("Location: uvelkommen.html");
	}
?>