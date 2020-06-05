
<?php
/* 
The PHP Data Objects ( PDO ) extension defines a lightweight, 
consistent interface for accessing databases in PHP. ... 
PDO provides a data-access abstraction layer, which means that, 
regardless of which database you're using, 
you use the same functions to issue queries and fetch data.


A session is a way to store information (in variables)
 to be used across multiple pages.
Unlike a cookie, the information is not stored on the 
users computer.*/
session_start();

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
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

/* 
The include_once statement includes and evaluates the specified file during the 
execution of the script. This is a behavior similar to the include statement, 
with the only difference being that if the code from a file has already been included,
it will not be included again, and include_once returns TRUE.
*/
include_once 'Class.User.php';
$user = new USER($DB_con);

include 'Class.Calendar.php';
include 'Class.Artikkel.php';

?>