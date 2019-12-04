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
  
//  if($kjønn == 'Mann') {$kjønn = '0';}
//  if($kjønn == 'Kvinne') {$kjønn = '1';}
//  if($kjønn == 'Annen') {$kjønn = '2';}
  echo "test1 ";
  if($pw == $pwSjekk and strlen($epost) <= 50 and strlen($pw) <= 40 and strlen($fnavn) <= 50 and strlen($enavn) <= 50
     and strlen($tlf) <= 50{
    //Krypterer passord
    $pw = sha1($salt.$pw);
    //sql kode for å registrere bruker, bruk INSERT-setning
	echo "test2 ";

	$mysqli = new mysqli("localhost", "root", "", "klima");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  echo $mysqli->host_info . "\n",'   ';

	//echo $epost ,'	', $pw ,'	' , $fnavn ,'	' , $enavn , '	' , $tlf ,'		' , $kjønn ,'	', $fdato;
	mysqli_query($mysqli,"INSERT INTO users (epost, passord, fornavn, etternavn, tlf, kjOnn, fdato) VALUES ('{$epost}','{$pw}','{$fnavn}','{$enavn}','{$tlf}','{$kjønn}','{$fdato}');" );
	//mysqli_query($mysqli,"INSERT INTO users (epost, passord) VALUES ('testtest', 'testtest');");
	
	
	
	echo "New record has id: " . mysqli_insert_id($mysqli);
	}
?>
