<?php

session_start();

$DB_host = "128.39.19.159";
$DB_user = "usr_klima";
$DB_pass = "pw_klima";
$DB_name = "klima";

try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}


include_once 'Class.User.php';
$user = new USER($DB_con);
include 'Class.Calendar.php';
