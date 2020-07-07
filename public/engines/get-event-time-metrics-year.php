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

//Array to store each year data
$eventmetrics = array();

//Loop through each year
$year = $startyear;
while ($year <= $endyear)
  {
  //Get year metrics
  include 'get-event-time-metrics-single.php';

  //Commit year metrics to array if there are results
  if (count($resultsarray) > 0)
    {
    $resultsarray['Year'] = $year;
    array_push($eventmetrics,$resultsarray);
    }

  //Increment year
  $year++;
  }

print_r($eventmetrics);
?>
