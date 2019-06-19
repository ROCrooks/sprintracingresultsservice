<?php
include_once 'required-functions.php';

$yeardata = array();

//Get all the race IDs from the year specified
include 'filter-year-regatta-ids.php';
$regattalist = $yearregattaids;
include 'filter-regatta-race-ids.php';
$raceids = $regattaraceids;

//Make the base race lists for singles, doubles and fours
if (isset($sizeraceids[1]) == true)
  $searchsingles = array($raceids,$sizeraceids[1]);
if (isset($sizeraceids[2]) == true)
  $searchdoubles = array($raceids,$sizeraceids[2]);
if (isset($sizeraceids[4]) == true)
  $searchfours = array($raceids,$sizeraceids[4]);

//Attach distance race IDs to the array
if (isset($distanceraceids['All']) == true)
  {
  if (isset($searchsingles) == true)
    array_push($searchsingles,$distanceraceids['All']);
  if (isset($searchdoubles) == true)
    array_push($searchdoubles,$distanceraceids['All']);
  if (isset($searchfours) == true)
    array_push($searchfours,$distanceraceids['All']);
  }

//Contract all race IDs at this point if the search is not by distance
if ($analyticsby != "Distance")
  {
  if (isset($searchsingles) == true)
    $searchsingles = arrayinall($searchsingles);
  if (isset($searchdoubles) == true)
    $searchdoubles = arrayinall($searchdoubles);
  if (isset($searchfours) == true)
    $searchfours = arrayinall($searchfours);
  }

//Set the JSV, MW, CK variables if needed
if (($analyticsby != "JSV") AND (count($analyticsjsv) < 3))
  $countjsv = $analyticsjsv;
if (($analyticsby != "MW") AND (count($analyticsmw) < 2))
  $countmw = $analyticsmw;
if (($analyticsby != "CK") AND (count($analyticsck) < 4))
  $countck = $analyticsck;

if ($analyticsby == "All")
  {
  //Get everyone together
  include 'count-seats.php';
  }
if ($analyticsby == "JSV")
  {
  //Get each age
  foreach($analyticsjsv as $jsv)
    {
    $countjsv = array($jsv);
    include 'count-seats.php';
    $yeardata[$jsv] = $totalpaddlers;
    }
  }
if ($analyticsby == "MW")
  {
  //Get each sex
  foreach($analyticsmw as $mw)
    {
    $countmw = array($mw);
    include 'count-seats.php';
    $yeardata[$mw] = $totalpaddlers;
    }
  }
if ($analyticsby == "CK")
  {
  //Get each boat type
  foreach($analyticsck as $ck)
    {
    $countck = array($ck);
    include 'count-seats.php';
    $yeardata[$ck] = $totalpaddlers;
    }
  }
if ($analyticsby == "Distance")
  {
  //Holder for the singles, doubles and fours IDs
  $searchsingleskeep = $searchsingles;
  $searchdoubleskeep = $searchdoubles;
  $searchfourskeep = $searchfours;

  //Get each distance
  //This requires merging all distance race IDs separately
  foreach($distanceraceids as $distance=>$distanceids)
    {
    if (isset($searchsingles) == true)
      {
      array_push($searchsingles,$distanceids);
      $searchsingles = arrayinall($searchsingles);
      }
    if (isset($searchdoubles) == true)
      {
      array_push($searchdoubles,$distanceraceids[$distance]);
      $searchdoubles = arrayinall($searchdoubles);
      }
    if (isset($searchfours) == true)
      {
      array_push($searchfours,$distanceids);
      $searchfours = arrayinall($searchfours);
      }

    include 'count-seats.php';
    $yeardata[$distance] = $totalpaddlers;

    //Reset to what the singles, doubles and fours were initially
    $searchsingles = $searchsingleskeep;
    $searchdoubles = $searchdoubleskeep;
    $searchfours = $searchfourskeep;
    }
  }

print_r($yeardata);
?>
