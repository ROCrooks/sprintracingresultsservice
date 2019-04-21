<?php
$files = array("srrs","userinput","db");

//Include each required functions file
foreach ($files as $file)
  {
  $url = "../functions/" . $file . "-functions.php";
  include_once $url;
  }

//Create database connection
include_once '../../dbconnect-function.php';
$srrsdblink = createdbconnection("SRRS");
?>
