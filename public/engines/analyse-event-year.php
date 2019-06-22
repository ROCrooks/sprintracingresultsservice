<?php
include_once 'required-functions.php';

//This section will be moved into the event data engine
//Find distance and boat size
$finddistances = array(500);
$selectas = "All";
include 'filter-distance-race-ids.php';
$findsizes = array(1);
include 'filter-size-race-ids.php';
$distancesizeraceids = array($sizeraceids,$distanceraceids['All']);

$year = "2012";
include 'filter-year-regatta-id.php';


?>
