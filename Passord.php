<?php
    session_start();
    $salt = "IT2_2020";
    $epost = $_POST['Epost'];
    $pw = $_POST['Passord'];
    $pwt = $_POST['PassordTest'];

    if($pw == $pwt) {
        //Krypterer passord
        $pw = sha1($salt.$pw);

        $mysqli = new mysqli("localhost", "root", "", "klima");
        if ($mysqli->connect_errno) {
          echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        echo $mysqli->host_info . "\n",'   ';

        if (!($stmt = $mysqli->prepare('UPDATE bruker SET passord =  (?) WHERE epost = (?)'))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
          }
          if (!$stmt->bind_param('sss',$pw, $epost, $gpw)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
          }
      
          if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
          }


         echo "New record has id: " . mysqli_insert_id($mysqli);
		 
		 header("Location: logginn.html");
    }
?>
