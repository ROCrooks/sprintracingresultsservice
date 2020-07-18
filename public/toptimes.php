<?php
//Include defaults
include 'defaulturls.php';

//This gets and processes user input
include 'engines/user-input-processing.php';

//Get input parameters from user
//$mw = "M";
//$ck = "C";
$dist = $_GET['distance'];
$boat = $_GET['boat'];
$tofind = $_GET['find'];

//Get the data
include 'engines/find-top-n.php';

print_r($topnresults);
?>
