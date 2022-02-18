<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Array to store each year data
$eventmetrics = array();

//To find flag for event best time
$tofind = 1;

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

    //Get the top performance of the year
    include 'find-top-n.php';

    //Push the top performances to the array
    $resultsarray['Crew'] = $topnresults[0]['Crew'];
    $resultsarray['Club'] = $topnresults[0]['Club'];
    $resultsarray['Race'] = $topnresults[0]['Race'];

    //Push the results for the year to the output array
    array_push($eventmetrics,$resultsarray);
    }
  //Increment year
  $year++;
  }

?>
