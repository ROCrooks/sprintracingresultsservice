<?php
include_once 'required-functions.php';

$classsearch = array("JSV"=>"S","MW"=>"M","CK"=>"K","Abil"=>"A");
$analyticsby = "BoatSize";
$analyticsboatsizes = array(1,2,4);
$analyticsdistances = array(200,500,1000,"LD");
$analyticsjsv = array("J","S","V");
$analyticsmw = array("M","W");
$analyticsck = array("C","K","V","P");
$startyear = 2007;
$endyear = 2018;

//Prepare the SQL statement for the analytics
include 'prepare-analytics-stmt.php';

echo $paddlerfindsql . "<br>";

print_r($baseconstraintvalues);
?>
