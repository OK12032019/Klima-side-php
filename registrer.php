<?php
  //Sjekk for registrering
  session_start();
  $salt = "IT2_2020";
  $bnavn = $_POST['Brukernavn'];
  $epost = $_POST['Epost'];
  $pw = $_POST['Passord'];
  $pwSjekk = $_POST['Bekreft_passord'];
  $fnavn = $_POST['Fornavn'];
  $enavn = $_POST['Etternavn'];
  $tlf = $_POST['Telefonnr'];
  $brukerType = '1';
  echo "test1 ";
  if($pw == $pwSjekk and strlen($epost) <= 50 and strlen($pw) <= 40 and strlen($fnavn) <= 50 and strlen($enavn) <= 50
  and strlen($tlf) <= 40) {
    //Krypterer passord
    $pw = sha1($salt.$pw);
    //sql kode for å registrere bruker, bruk INSERT-setning
    echo "test2 ";

    $mysqli = new mysqli("localhost", "root", "", "klima");
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    echo $mysqli->host_info . "\n",'   ';


    if (!($stmt = $mysqli->prepare('INSERT INTO bruker(brukernavn, passord, fnavn, enavn, epost, telefon, brukertype) VALUES (?,?,?,?,?,?,?)'))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param('sssssss',$bnavn, $pw, $fnavn, $enavn, $epost, $tlf, $brukerType)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    //echo $epost ,'	', $pw ,'	' , $fnavn ,'	' , $enavn , '	' , $tlf ,'		' , $kjønn ,'	', $fdato;
    mysqli_query($mysqli,"INSERT INTO bruker (brukernavn, passord, fnavn, enavn, epost, telefon, brukertype) 
    VALUES ('{$bnavn}','{$pw}','{$epost}','{$fnavn}','{$enavn}','{$epost}','{$tlf}');");
    //mysqli_query($mysqli,"INSERT INTO users (epost, passord) VALUES ('testtest', 'testtest');");
    
    
    
    echo "New record has id: " . mysqli_insert_id($mysqli);
	}
?>
