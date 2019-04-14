<?php
include_once 'required-functions.php';

$raceid = 14;

//Get race details from regatta database
$getracedetailssql = "SELECT `Regatta`, `Boat`, `Dist`, `R`, `D` FROM `races` WHERE `Key` = ? ";
$racesqlresult = dbprepareandexecute($srrsdblink,$getracedetailssql,$raceid);
$racesqlresult = $racesqlresult[0];

//Format name of round and draw
if (($racesqlresult['R'] == "H") OR ($racesqlresult['R'] == 1))
  {
  $rounddraw = "Heat " . $racesqlresult['D'];
  $roundno = 1;
  }
if (($racesqlresult['R'] == "QF") OR ($racesqlresult['R'] == "Q") OR ($racesqlresult['R'] == 2))
  {
  $rounddraw = "Quarter-Final " . $racesqlresult['D'];
  $roundno = 2;
  }
if (($racesqlresult['R'] == "SF") OR ($racesqlresult['R'] == "S") OR ($racesqlresult['R'] == 3))
  {
  $rounddraw = "Semi-Final " . $racesqlresult['D'];
  $roundno = 3;
  }
if (($racesqlresult['R'] == "F") OR ($racesqlresult['R'] == 4))
  {
  $rounddraw = "Final " . $racesqlresult['D'];
  $roundno = 4;
  }

//Format distance
if ($racesqlresult['Dist'] <= 1000)
  $distance = $racesqlresult['Dist'] . "m";
if ($racesqlresult['Dist'] > 1000)
  $distance = $racesqlresult['Dist']/1000 . "km";

//Format the class of the race from the classes table
$getclassdetailssql = "SELECT `JSV`, `MW`, `CK`, `Abil`, `Spec`, `Ages`, `FreeText` FROM `classes` WHERE `Race` = ? ";
$classdetails = dbprepareandexecute($srrsdblink,$getclassdetailssql,$raceid);
$boatsize = $racesqlresult['Boat'];
include 'format-class.php';

//Format name of race
$racename = $raceclass . " " . $distance . " " . $rounddraw;

//Race details into an array
$racedetails = array();
$racedetails['Key'] = $raceid;
$racedetails['Regatta'] = $racesqlresult['Regatta'];
$racedetails['Name'] = $racename;
$racedetails['Class'] = $raceclass;
$racedetails['Distance'] = $racesqlresult['Dist'];
$racedetails['Round'] = $roundno;
$racedetails['Draw'] = $racesqlresult['D'];

print_r($racedetails);
?>
