<?php
//$racedetails = array("RaceName"=>"Boys Open","defCK"=>"K","Boat"=>1);

//Add canoe to the RaceName if it is needed
if ((strpos($racedetails['RaceName'],"CANOE") === false) AND ($racedetails['defCK'] == "C"))
  $racedetails['RaceName'] = $racedetails['RaceName'] . " Canoe";

//Lookup words to identify different types of paddler
$womenwords = array("WOMEN","GIRL","WMASTER");
$menwords = array("MEN","BOY","MASTER");
$juniorwords = array("JUNIOR","BOY","GIRL","LIGHTNING","MINI");
$seniorwords = array("SENIOR","MEN","WOMEN","PARA","PADDLEABILITY");
$veteranwords = array("MASTER","LADIES");

//Reformat if SUP
if (strpos($racedetails['RaceName'],"SUP") !== false)
  {
  $racedetails['defCK'] = "P";
  }

$mwflags = array("M"=>0,"W"=>0);
//Find if womens words are mentioned
foreach ($womenwords as $word)
  {
  if (strpos($racedetails['RaceName'],$word) !== false)
    $mwflags['W']++;
  }
//Find in mens words are mentioned
foreach ($menwords as $word)
  {
  if (strpos($racedetails['RaceName'],$word) !== false)
    {
    //Extra check as Master will also find WMaster
    if ($word == "Master")
      {
      if (strpos($racedetails['RaceName'],"WMaster") !== false)
        $mwflags['M']++;
      }
    else
      $mwflags['M']++;
    }
  }

//Assign the default MW to the race
if (($mwflags['M'] > 0) AND ($mwflags['W'] == 0))
  $racedetails['defMW'] = "M";
elseif (($mwflags['W'] > 0) AND ($mwflags['M'] == 0))
  $racedetails['defMW'] = "W";
else
  $racedetails['defMW'] = "";

$jsvflags = array("J"=>0,"S"=>0,"V"=>0);
//Find if junior words are mentioned
foreach ($juniorwords as $word)
  {
  if (strpos($racedetails['RaceName'],$word) !== false)
    $jsvflags['J']++;
  }
//Find if senior words are mentioned
foreach ($seniorwords as $word)
  {
  if (strpos($racedetails['RaceName'],$word) !== false)
    $jsvflags['S']++;
  }
//Find if veteran words are mentioned
foreach ($veteranwords as $word)
  {
  if (strpos($racedetails['RaceName'],$word) !== false)
    $jsvflags['V']++;
  }

//Assign the default JSV to the race
if (($jsvflags['J'] > 0) AND ($jsvflags['S'] == 0) AND ($jsvflags['V'] == 0))
  $racedetails['defJSV'] = "J";
elseif (($jsvflags['J'] == 0) AND ($jsvflags['S'] > 0) AND ($jsvflags['V'] == 0))
  $racedetails['defJSV'] = "S";
elseif (($jsvflags['J'] == 0) AND ($jsvflags['S'] == 0) AND ($jsvflags['V'] > 0))
  $racedetails['defJSV'] = "V";
else
  $racedetails['defJSV'] = "";
?>
