<?php
	session_start();
    $SALT = 'IT2_2020';
	
	$USER = $_POST['user'];
	$PASS = $_POST['pass'];
	
	$USER = stripcslashes($USER);
	$PASS = stripcslashes($PASS);
	
	$PW= sha1($SALT.$PASS);
	
	$mysqli = new mysqli("localhost", "root", "", "klima");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	echo $mysqli->host_info . "\n";

		//Sjekk sisteinnlogging
		if (!($stmt = $mysqli->prepare('SELECT feillogginnsiste FROM bruker WHERE brukernavn = ? ;'))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		
		if (!$stmt->bind_param('s',$epost)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		//echo $stmt;
		//while (stmt->fetch)
		$Resultat = mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		echo ' ',$Resultat;
		

		$timeNow = date('Y-m-d H:i:s', strtotime('-5 minutes'));
		if ($Resultat < $timeNow) {
			

			// reset counter
			if (!($stmt = $mysqli->prepare('UPDATE bruker SET feillogginnteller = 0 WHERE brukernavn = ? ;'))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
			if (!$stmt->bind_param('s',$epost)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}

			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
				// innloggingsforsøk +1

				if (!($stmt = $mysqli->prepare('UPDATE bruker SET feillogginnteller = feillogginnteller+1 WHERE brukernavn = ? ;'))) {
					echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				}
				
				if (!$stmt->bind_param('s',$epost)) {
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}

				if (!$stmt->execute()) {
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}
			
					// sjekk antall innloggingsforsøk

					if (!($stmt = $mysqli->prepare('SELECT * FROM bruker WHERE brukernavn =  ? ;'))) {
						echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
					}
					if (!$stmt->bind_param('s',$epost)) {
						echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
					}
				
					if (!$stmt->execute()) {
						echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
					}
					$Resultat = mysqli_stmt_get_result($stmt);

					$ROW = mysqli_fetch_assoc($Resultat);
			
					echo $ROW;

						if ($ROW['feillogginnteller'] < 5) {

							// $RESULT = mysqli_query($mysqli, "select * from bruker where epost = '{$USER}' and passord = '{$PW}'");

							if ($ROW['epost'] == $USER && $ROW['passord'] == $PW) {
								header('Location: backend.php');
								$_SESSIONS['bruker'] = $bruker;
								$_SESSIONS['brukertype'] = $row['brukertype'];
								
							}
							
							else {
								echo $ROW,' ', $USER,' ', $PW;
								//header("Location: uvelkommen.html");
							}
						}
						else {
							echo 'Feillogginnteller er ikke < 5';
						}

		}
		else {
			echo 'Du har forsøk å logg inn for mange ganger';
		}
?>