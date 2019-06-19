<?php
include_once 'required-functions.php';

$year = 2018;

//Get all the race IDs from the year specified
include 'filter-year-regatta-ids.php';
$regattalist = $yearregattaids;
include 'filter-regatta-race-ids.php';
$raceids = $regattaraceids;

//Make the base race lists for singles, doubles and fours
$searchraces = array($raceids);
if (isset($sizeraceids[1]) == true)
  $searchsingles = array($raceids,$sizeraceids[1]);
if (isset($sizeraceids[2]) == true)
  $searchdoubles = array($raceids,$sizeraceids[2]);
if (isset($sizeraceids[4]) == true)
  $searchfours = array($raceids,$sizeraceids[4]);

//Attach distance race IDs to the array
if (isset($distanceraceids['All']) == true)
  {
  array_push($searchsingles,$distanceraceids['All']);
  array_push($searchdoubles,$distanceraceids['All']);
  array_push($searchfours,$distanceraceids['All']);
  }

//Contract all race IDs at this point if the search is not by distance
if ($analyticsby != "Distance")
  {
  $searchsingles = arrayinall($searchsingles);
  $searchdoubles = arrayinall($searchdoubles);
  $searchfours = arrayinall($searchfours);
  }

if ($analyticsby == "All")
  {
  //Count the number of paddlers in singles, doubles and fours
  $totalpaddlers = 0;
  $raceids = $searchsingles;
  include 'count-paddlers.php';
  $totalpaddlers = $totalpaddlers+$paddlerscount;
  $raceids = $searchdoubles;
  include 'count-paddlers.php';
  $totalpaddlers = $totalpaddlers+($paddlerscount*2);
  $raceids = $searchfours;
  include 'count-paddlers.php';
  $totalpaddlers = $totalpaddlers+($paddlerscount*4);
  echo $totalpaddlers;
  }
?>
