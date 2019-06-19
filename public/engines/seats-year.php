<?php
include_once 'required-functions.php';

$year = 2018;

include 'filter-year-regatta-ids.php';
$regattalist = $yearregattaids;
include 'filter-regatta-race-ids.php';
print_r($regattaraceids); 
?>
