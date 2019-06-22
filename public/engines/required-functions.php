<?php
$files = array("srrs","userinput","db","array");

//Get current directory
//This makes the location independent of the location of the calling script
$directory = dirname(__DIR__);
$directory = str_replace("Git/public","Git/public/functions",$directory);

//Include each required functions file
foreach ($files as $file)
  {
  $url = $directory . "/" . $file . "-functions.php";
  include_once $url;
  }

//Change the directory to where the database script is
$directory = str_replace("Git/public/functions","",$directory);

//Create database connection
include_once $directory . '/dbconnect-function.php';
$srrsdblink = createdbconnection("SRRS");
?>
