<?php
$files = array("srrs","userinput");

//Include each required functions file
foreach ($files as $file)
  {
  $url = "../functions/" . $file . "-functions.php";
  include_once $url;
  }

//Database connection file
include_once '../../dbconnect-function.php';
?>
