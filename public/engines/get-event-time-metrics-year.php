<?php
include_once 'required-functions.php';

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

?>
