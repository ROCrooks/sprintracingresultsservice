<?php
$paddlerdetails = array();

$raceline = strtoupper($raceline);
$raceline = explode(" ",$raceline);

//Check the first 2 elements for LD race lane numbers, and unset them if they're found
foreach($regex['longdistancelanes'] as $ldracelane)
  {
  if (isset($raceline[0]) == true)
    {
    if (preg_match($ldracelane,$raceline[0]) == true)
    unset($raceline[0]);
    }
  if (isset($raceline[1]) == true)
    {
    if (preg_match($ldracelane,$raceline[1]) == true)
      unset($raceline[1]);
    }
  }

//Get the last element of the array as the time or the no result
$timeelement = array_pop($raceline);

//Check if the last element is a time
$regexcount = count($regex['timeformats']);
$regexkey = 0;
$foundtime = false;
while (($regexkey < $regexcount) AND ($foundtime == false))
  {
  if (preg_match($regex['timeformats'][$regexkey],$timeelement) == true)
    {
    $paddlerdetails['Time'] = $timeelement;
    $paddlerdetails['NR'] = "";
    $foundtime = true;
    }
  $regexkey++;
  }

//Search for no results
$regexcount = count($regex['notfinishings']);
$regexkey = 0;
while (($regexkey < $regexcount) AND ($foundtime == false))
  {
  if ($regex['notfinishings'][$regexkey] == $timeelement)
    {
    $paddlerdetails['Time'] = "";
    $paddlerdetails['NR'] = $timeelement;
    $foundtime = true;
    }
  $regexkey++;
  }

//Set the time and no results fields to empty if they haven't already been set 
if (isset($paddlerdetails['Time']) == false)
  $paddlerdetails['Time'] = "";
if (isset($paddlerdetails['NR']) == false)
  $paddlerdetails['NR'] = "";

$raceline = array_values($raceline);

//Get the position and lane from the first 2 elements
if ((is_numeric($raceline[0]) == true) AND (is_numeric($raceline[1]) == true))
  {
  $paddlerdetails['Position'] = $raceline[0];
  $paddlerdetails['Lane'] = $raceline[1];
  unset($raceline[0]);
  unset($raceline[1]);
  }
elseif ((is_numeric($raceline[0]) == true) AND ($paddlerdetails['NR'] == ""))
  {
  $paddlerdetails['Position'] = $raceline[0];
  $paddlerdetails['Lane'] = 0;
  unset($raceline[0]);
  }
elseif ((is_numeric($raceline[0]) == true) AND ($paddlerdetails['NR'] != ""))
  {
  $paddlerdetails['Position'] = 0;
  $paddlerdetails['Lane'] = $raceline[0];
  unset($raceline[0]);
  }
else
  {
  $paddlerdetails['Position'] = 0;
  $paddlerdetails['Lane'] = 0;
  }

$raceline = array_values($raceline);

//Check if the first element is a club and if so make it the default club
$regexcount = count($regex['defaultclub']);
$regexkey = 0;
$defaultclub = false;
while (($regexkey < $regexcount) AND ($defaultclub == false))
  {
  if (preg_match($regex['defaultclub'][$regexkey],$raceline[0]) == true)
    {
    $defaultclub = $raceline[0];
    unset($raceline[0]);
    }
  $regexkey++;
  }

//Make the default club ??? if it is not found
if ($defaultclub == false)
  $defaultclub = "???";

$raceline = array_values($raceline);

//Get the different class flag from the raceline
$differentclassflag = preg_grep($regex['differentclassflag'],$raceline);
if ($differentclassflag != false)
  {
  //Get the key of the flag in order to remove it
  $differentclassflagkey = array_key_first($differentclassflag);
  $differentclassflag = str_split($differentclassflag[$differentclassflagkey]);
  
  $paddlerdetails['JSV'] = $differentclassflag[1];
  $paddlerdetails['MW'] = $differentclassflag[2];
  $paddlerdetails['CK'] = $differentclassflag[3];
  
  unset($raceline[$differentclassflagkey]);
  }
else
  {
  //Set the class as the default for the race
  $paddlerdetails['JSV'] = $racedetails['defJSV'];
  $paddlerdetails['MW'] = $racedetails['defMW'];
  $paddlerdetails['CK'] = $racedetails['defCK'];
  }

$raceline = array_values($raceline);

//Format the clubs and paddlers
$raceline = implode(" ",$raceline);
$paddlers = explode("/",$raceline);
$clubs = explode("/",$defaultclub);

//Turn the club into the format of multiple clubs to standardize
if (count($clubs) == 1)
  {
  $singleclub = $clubs[0];
  
  if ($racedetails['Boat'] == 2)
    $clubs = array($singleclub,$singleclub);
  
  if ($racedetails['Boat'] == 4)
    $clubs = array($singleclub,$singleclub,$singleclub,$singleclub);
  }

foreach($paddlers as $paddlerkey=>$paddler)
  {
  //Remove spaces at the beginning and end of paddler
  $endofpaddler = substr($paddler,-1);
  while ($endofpaddler == " ")
    {
    $paddler = substr($paddler,1);
    $endofpaddler = substr($paddler,0,-1);
    }
  $startofpaddler = substr($paddler,0,1);
  while ($startofpaddler == " ")
    {
    $paddler = substr($paddler,1);
    $startofpaddler = substr($paddler,0,1);
    }
  
  //Initialize the first letter in the paddler name
  $paddler = explode(" ",$paddler);
  if (strlen($paddler[0]) == 1)
    {
    $paddler[0] = $paddler[0] . ".";
    }
  $paddler = implode(" ",$paddler);
  
  //Find a different club flag
  $differentclub = array();
  preg_match($regex['individualclub'],$paddler,$differentclub);
  if (count($differentclub) == 1)
    {
    //Remove the different club flag from the paddler text
    str_replace($differentclub[0],"",$paddler);
    $differentclub = substr($differentclub[0],1,-1);
    
    //Change the club to a different club
    $clubs[$paddlerkey] = $differentclub;
    }
  
  //Add the formatted paddler back to the array
  $paddlers[$paddlerkey] = $paddler;
  }

//Replace the club array with a single club if only 1 club is present
$uniqueclubs = array_unique($clubs);
if (count($uniqueclubs) == 1)
  $clubs = $clubs[0];
else
  $clubs = implode("/",$clubs);

//Add the clubs and crew to the paddler details
$paddlerdetails['Club'] = $clubs;
$paddlerdetails['Crew'] = implode("/",$paddlers);
?>