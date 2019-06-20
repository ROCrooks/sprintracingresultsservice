<?php
include_once 'required-functions.php';

if ($analyticsby != "BoatSize")
  $totalpaddlers = 0;

if (isset($searchsingles) == true)
  {
  $raceids = $searchsingles;
  include 'count-paddlers.php';
  if ($analyticsby == "BoatSize")
    $singlespaddlers = $paddlerscount;
  else
    $totalpaddlers = $totalpaddlers+$paddlerscount;
  }
if (isset($searchdoubles) == true)
  {
  $raceids = $searchdoubles;
  include 'count-paddlers.php';
  if ($analyticsby == "BoatSize")
    $doublespaddlers = $paddlerscount*2;
  else
    $totalpaddlers = $totalpaddlers+($paddlerscount*2);
  }
if (isset($searchfours) == true)
  {
  $raceids = $searchfours;
  include 'count-paddlers.php';
  if ($analyticsby == "BoatSize")
    $fourspaddlers = $paddlerscount*4;
  else
    $totalpaddlers = $totalpaddlers+($paddlerscount*4);
  }
?>
