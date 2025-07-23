<?php
//Get the required function files
$files = array("srrs","userinput","db","array","drawgraph","document");

//Include each required functions file
foreach ($files as $file)
  {
  $url = $functionslocation . "/" . $file . "-functions.php";
  include_once $url;
  }

//Create database connection
//Only create if not already created
if (isset($srrsdblink) == false)
  {
  include_once $functionslocation . '/dbconnect-function.php';
  $srrsdblink = createdbconnection("SRRS");
  }
?>
