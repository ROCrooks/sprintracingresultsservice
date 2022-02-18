<?php
include_once $engineslocation . 'srrs-required-functions.php';

//$classsearch = array("JSV"=>"S","MW"=>"M","CK"=>"K","Abil"=>"A");
$classsearch = false;
//$analyticsby = "Distance";
//$analyticsboatsizes = array(1,2,4);
//$analyticsdistances = $distances;
//$analyticsjsv = array("J","S","V");
//$analyticsmw = array("M","W");
//$analyticsck = array("C","K","V","P");
//$startyear = 2007;
//$endyear = 2018;

//Prepare the SQL statement for the analytics
include $engineslocation . 'prepare-analytics-stmt.php';

//Run the analytics
include $engineslocation . 'run-analytics-stmt.php';
?>
