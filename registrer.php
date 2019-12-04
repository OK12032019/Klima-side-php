<?php
  //Sjekk for registrering
  session_start();
  $salt = "IT2_2020";
  $epost = $_POST['Epost'];
  $pw = $_POST['Passord'];
  $pwSjekk = $_POST['Bekreft_passord'];
  $fnavn = $_POST['Fornavn'];
  $enavn = $_POST['Etternavn'];
  $tlf = $_POST['Telefonnr'];
  $kjønn = $_POST['Kjønn'];
  $fdato = $_POST['Fødselsdato'];
  echo "test1 ";
  if($pw == $pwSjekk) {
    //Krypterer passord
    $pw = sha1($salt.$pw);
    //sql kode for å registrere bruker, bruk INSERT-setning
	echo "test ";

	$mysqli = new mysqli("localhost", "root", "", "klima");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	echo $mysqli->host_info . "\n";
	
	
	mysqli_query($mysqli,"INSERT INTO users (Epost, Passord, Fornavn, Etternavn, Telefonnr, Kjønn, Fødselsdato) VALUES ('{$epost}', '{$pw}','{$fnavn}','{$enavn}','{$tlf}','{$kjønn}','{$fdato}');" );
	
	echo "New record has id: " . mysqli_insert_id($mysqli);
	}
?>
