<?php
//Start and end years
$startyear = 2006;
$endyear = 2019;

//Event to search for
$mw = "M";
$ck = "K";
$dist = 500;
$boat = 1;
//$jsv = "J";
//$year = 2014;
//$club = "LBZ";

//Get event metrics
include 'engines/get-event-time-metrics-year.php';

print_r($eventmetrics);
?>
