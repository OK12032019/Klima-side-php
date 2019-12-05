<?
session_start();
session_unset();
session_destroy();
header("location:default.html");
//include 'home.php';
exit();
?>