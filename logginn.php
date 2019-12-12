<?php
	session_start();
    $SALT = 'IT2_2020';
	
	$USER = $_POST['brukernavn'];
	$PASS = $_POST['pass'];
	
	$USER = stripcslashes($USER);
	$PASS = stripcslashes($PASS);
	
	$PW= sha1($SALT.$PASS);
	
	$mysqli = new mysqli("localhost", "root", "", "klima");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	echo $mysqli->host_info . "\n";
	echo ' test -1 ';



	//hent infor for sjekk for <5 feil
	if (!($stmt = $mysqli->prepare('SELECT * FROM bruker WHERE brukernavn = ? ;'))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	if (!$stmt->bind_param('s',$USER)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	echo 'test A ';

	// Sett resultat som variabel
	$Resultat = mysqli_stmt_get_result($stmt);

	#echo 'Resultat1 : ', $Resultat;

	$ROW = mysqli_fetch_array($Resultat);
	
	//sjekk for <5 feil
	$feilAntall = $ROW['feillogginnteller'];

	echo 'feilAntall : ',$feilAntall;

	if ($ROW['feillogginnteller'] < 5) {
		// $RESULT = mysqli_query($mysqli, "select * from bruker where epost = '{$USER}' and passord = '{$PW}'");

		if (!($stmt = $mysqli->prepare('SELECT * FROM bruker WHERE brukernavn = ? and passord = ? ;'))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
		if (!$stmt->bind_param('ss',$USER,$PW)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
	
		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$Resultat = mysqli_stmt_get_result($stmt);
		//echo ' Resultat: ',$Resultat;
		$ROW = mysqli_fetch_array($Resultat);
		echo 'mambo nr. 5 : ', $ROW['brukernavn'], $ROW['passord'];

		if ($ROW['brukernavn'] == $USER && $ROW['passord'] == $PW) {
			echo ' test 1';
			
			$_SESSION['brukernavn'] = $USER;
			$_SESSION['brukertype'] = $ROW['brukertype'];
			header('Location: backend.php');
		}
		else {
			//echo 'ROW for andre gang: ',$ROW,' USER: ', $USER,' PASS: ', $PW;
			

			//oppdater feil innlogging teller
			if (!($stmt = $mysqli->prepare('UPDATE bruker SET feillogginnteller = feillogginnteller +1 WHERE brukernavn = ? ;'))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
			if (!$stmt->bind_param('s',$USER)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
		
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}

			//ny siste 
			if (!($stmt = $mysqli->prepare('UPDATE bruker SET feillogginnsiste = now() WHERE brukernavn = ? ;'))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
			if (!$stmt->bind_param('s',$USER)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}

			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			echo 'add på teller';
			#header("Location: uvelkommen.html");
		}
	}
	else {
		//Sjekk sisteinnlogging
		if (!($stmt = $mysqli->prepare('SELECT * FROM bruker WHERE brukernavn = ? ;'))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
		if (!$stmt->bind_param('s',$USER)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		//echo $stmt;
		//while (stmt->fetch)
		$Resultat = mysqli_stmt_get_result($stmt);
		$ROW = mysqli_fetch_array($Resultat);
		#mysqli_stmt_close($stmt);
		#echo ' ',$ROW;
		

		$timeNow = date('Y-m-d H:i:s', strtotime('-1 minutes'));
		if ($ROW['feillogginnsiste'] < $timeNow) {
			

			// reset counter
			if (!($stmt = $mysqli->prepare('UPDATE bruker SET feillogginnteller = 0 AND SET feillogginnsiste = 0 WHERE brukernavn = ? ;'))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
			if (!$stmt->bind_param('s',$USER)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}

			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			header("Location: logginn.html");
		}
		else {
			echo 'test tid og shit ';

			#header("Location: uvelkommen.html");
		}
	}
	

?>

