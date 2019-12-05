<?php
    session_start();
    $salt = "IT2_2020";
    $epost = $_POST['Epost'];
    $gpw = $_POST['GPassord'];
    $pw = $_POST['Passord'];
    $pwt = $_POST['PassordTest'];

    if($pw == $pwt) {
        //Krypterer passord
        $pw = sha1($salt.$pw);
        $gpw = sha1($salt.$gpw);

        $mysqli = new mysqli("localhost", "root", "", "klima");
        if ($mysqli->connect_errno) {
          echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        echo $mysqli->host_info . "\n",'   ';

        mysqli_query($mysqli,"UPDATE bruker SET passord = '{$pw}' WHERE epost = '{$epost}' AND passord = '{$gpw}';");

        echo "New record has id: " . mysqli_insert_id($mysqli);
    }
?>