<?php
//Get the required general function files that are shared with other applications
$generalfiles = array("userinput","db","array","drawgraph","document");

//Include each required functions file
foreach ($generalfiles as $file)
  {
  $url = $generalfunctionsfolder . "/" . $file . "-functions.php";
  include_once $url;
  }

//Also include the specific SRRS functions
include_once $srrsfunctionsfolder . "/srrs-functions.php";

//Create database connection
//Only create if not already created
if (isset($srrsdblink) == false)
  {
  include_once $generalfunctionsfolder . '/dbconnect-function.php';
  $srrsdblink = createdbconnection("SRRS");
  }
?>
