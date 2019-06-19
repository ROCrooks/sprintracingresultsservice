<?php
include_once 'required-functions.php';

$totalpaddlers = 0;
if (isset($searchsingles) == true)
  {
  $raceids = $searchsingles;
  include 'count-paddlers.php';
  $totalpaddlers = $totalpaddlers+$paddlerscount;
  }
if (isset($searchdoubles) == true)
  {
  $raceids = $searchdoubles;
  include 'count-paddlers.php';
  $totalpaddlers = $totalpaddlers+($paddlerscount*2);
  }
if (isset($searchfours) == true)
  {
  $raceids = $searchfours;
  include 'count-paddlers.php';
  $totalpaddlers = $totalpaddlers+($paddlerscount*4);
  }
?>
