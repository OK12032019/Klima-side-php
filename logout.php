<?php
require_once 'PDO.php';
$user->logout();

$user->redirect('default.php');
/* The require_once statement is identical
 to require except PHP will check if the file
  has already been included, and if so, not include (require)*/