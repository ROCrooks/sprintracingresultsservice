<?php
//Get the functions directory
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);
$admindirectory = $currentdirectory . "/admin/";
$functionsdirectory = $currentdirectory . "/functions/";

//Get the required function files
$files = array("srrs","userinput","db","array","drawgraph","document");

//Include each required functions file
foreach ($files as $file)
  {
  $url = $functionsdirectory . "/" . $file . "-functions.php";
  include_once $url;
  }

//Create database connection
//Only create if not already created
if (isset($srrsdblink) == false)
  {
  include_once $admindirectory . '/dbconnect-function.php';
  $srrsdblink = createdbconnection("SRRS");
  }
?>
