<?php
include_once $engineslocation . 'race-reading-regexs.php';

/*
$racedetails = array("Distance"=>"200","defCK"=>"K","Boat"=>"1","Draw"=>"1","Round"=>"F","RaceName"=>"MEN OPEN (INC U23) K","defMW"=>"M","defJSV"=>"S");
$allpaddlerdetails = array();
$allpaddlerdetails[0] = array("Time"=>"35.41","NR"=>"","Position"=>"1","Lane"=>"5","Club"=>"WEY","Crew"=>"L. HEATH","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[1] = array("Time"=>"35.77","NR"=>"","Position"=>"2","Lane"=>"6","Club"=>"SOR","Crew"=>"J. SCHOFIELD","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[2] = array("Time"=>"36.09","NR"=>"","Position"=>"3","Lane"=>"4","Club"=>"SPS","Crew"=>"L. FLETCHER","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[3] = array("Time"=>"36.58","NR"=>"","Position"=>"4","Lane"=>"3","Club"=>"SPS","Crew"=>"I. JAMES","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[4] = array("Time"=>"37.01","NR"=>"","Position"=>"5","Lane"=>"7","Club"=>"NOT","Crew"=>"S. NAFTANAILA","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[5] = array("Time"=>"37.14","NR"=>"","Position"=>"6","Lane"=>"2","Club"=>"EAL","Crew"=>"T. THOMSON","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[6] = array("Time"=>"37.56","NR"=>"","Position"=>"7","Lane"=>"8","Club"=>"CDF","Crew"=>"M. ROBINSON","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[7] = array("Time"=>"37.67","NR"=>"","Position"=>"8","Lane"=>"9","Club"=>"RDG","Crew"=>"D. ATKINS","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[8] = array("Time"=>"38.67","NR"=>"","Position"=>"9","Lane"=>"1","Club"=>"LEA","Crew"=>"N. DEMBELE","JSV"=>"S","MW"=>"M","CK"=>"K");
*/

//A list of errors
$errorlist = array();

//Check that the distance is legal
$legaldistances = array(200,500,1000,2500,3000,5000,6000,10000);
if (in_array($racedetails['Distance'],$legaldistances) === false)
  {
  $raceerror = true;
  array_push($errorlist,"Invalid race distance specified");
  }

//Check that the round is legal
$legalrounds = array("H","QF","SF","F");
if (in_array($racedetails['Round'],$legalrounds) === false)
  {
  $raceerror = true;
  array_push($errorlist,"Invalid round specified");
  }

//Check that the draw is legal
if (($racedetails['Round'] != "F") AND ($racedetails['Draw'] == 0))
  {
  $raceerror = true;
  array_push($errorlist,"Draw missing from a round that needs one");
  }

$legalboats = array(1,2,4);
if (in_array($racedetails['Boat'],$legalboats) === false)
  {
  $raceerror = true;
  array_push($errorlist,"Invalid boat size specified");
  }

$legaljsvs = str_split("JSV");
$legalmw = str_split("MWX");
$legalck = str_split("CKVTP");
$legalnrs = array("DSQ","ERR","DNS","DNF","???");
foreach ($allpaddlerdetails as $paddlerdetails)
  {
  //Check JSV is legal
  if (in_array($paddlerdetails['JSV'],$legaljsvs) === false)
    {
    $raceerror = true;
    array_push($errorlist,"Invalid JSV specified");
    }

  //Check MW is legal
  if (in_array($paddlerdetails['MW'],$legalmw) === false)
    {
    $raceerror = true;
    array_push($errorlist,"Invalid MW specified");
    }

  //Check CK is legal
  if (in_array($paddlerdetails['CK'],$legalck) === false)
    {
    $raceerror = true;
    array_push($errorlist,"Invalid CK specified");
    }

  //Check NR is legal
  if ((in_array($paddlerdetails['NR'],$legalnrs) === false) AND ($paddlerdetails['Time'] == 0))
    {
    $raceerror = true;
    array_push($errorlist,"Invalid no result code specified");
    }

  //Check that the time is valid if there is a result
  $validtimes = array_merge($regex['timeformats'],$regex['notfinishings']);
  $validtimescount = count($validtimes);
  $validtimeskey = 0;
  $validtimefound = false;
  //Check each valid format until either it is found, or options run out
  while (($validtimeskey < $validtimescount) AND ($validtimefound == false))
    {
    if (preg_match($validtimes[$validtimeskey],$paddlerdetails['Time']) != false)
      $validtimefound = true;
    
    $validtimeskey++;
    }
  
  //If none of the valid race times have been found, return an error
  if ($validtimefound == false)
    {
    $raceerror = true;
    array_push($errorlist,"Invalid time specified");
    }

  //Check club is legal
  if ((($racedetails['Boat'] == 1) AND (strlen($paddlerdetails['Club']) <> 3)) OR (($racedetails['Boat'] == 2) AND (strlen($paddlerdetails['Club']) <> 3) AND (strlen($paddlerdetails['Club']) <> 7)) OR (($racedetails['Boat'] == 4) AND (strlen($paddlerdetails['Club']) <> 3) AND (strlen($paddlerdetails['Club']) <> 15)))
    {
    $raceerror = true;
    array_push($errorlist,"Invalid club code specified");
    }
  
  //Check if there are any weird characters in crew names
  $weirdcharacters = str_split("()[]");
  $weirdcharacterskey = 0;
  $weirdcharacterscount = count($weirdcharacters);
  $weirdcharacterfound = false;
  while (($weirdcharacterskey < $weirdcharacterscount) AND ($weirdcharacterfound == false))
    {
    if (str_contains($paddlerdetails['Crew'],$weirdcharacters[$weirdcharacterskey]) == true)
      {
      $raceerror = true;
      array_push($errorlist,"Weird character found in crew name");
      $weirdcharacterfound = true;
      }
    
    $weirdcharacterskey++;
    }
  }
$errorlist = array_unique($errorlist);
?>
