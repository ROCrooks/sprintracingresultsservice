<?php
$analyticsby = "All";
$analyticsboatsizes = array(1,2,4);
$analyticsdistances = array(200,500,1000,"LD");
$analyticsjsv = array("J","S","V");
$analyticsmw = array("M","W");
$analyticsck = array("C","K");
$startyear = 2018;
$endyear = 2018;

include 'filter-distance-race-ids.php';

print_r($distanceraceids);

/*
if ($analyticsby == "Distance")
  {
  //Array where distance keys are stored
  $distancekeys = array();

  if (in_array(200,$analyticsdistances) == true)
    {
    echo "200m being searched for<br>";
    }
  if (in_array(500,$analyticsdistances) == true)
    {
    echo "500m being searched for<br>";
    }
  if (in_array(1000,$analyticsdistances) == true)
    {
    echo "1000m being searched for<br>";
    }
  if (in_array("LD",$analyticsdistances) == true)
    {
    echo "Long distances being searched for<br>";
    }
  }
elseif ((in_array(200,$analyticsdistances) == false) OR (in_array(500,$analyticsdistances) == false) OR (in_array(1000,$analyticsdistances) == false) OR (in_array("LD",$analyticsdistances) == false))
  {
  $distancekeys = array();

  if (in_array(200,$analyticsdistances) == true)
    {
    echo "200m being searched for<br>";
    }
  if (in_array(500,$analyticsdistances) == true)
    {
    echo "500m being searched for<br>";
    }
  if (in_array(1000,$analyticsdistances) == true)
    {
    echo "1000m being searched for<br>";
    }
  if (in_array("LD",$analyticsdistances) == true)
    {
    echo "Long distances being searched for<br>";
    }
  }
*/
?>
