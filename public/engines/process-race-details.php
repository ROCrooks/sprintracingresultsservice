<?php
include_once 'required-functions.php';

//Format name of round and draw
if (($racesqlresultline['R'] == "H") OR ($racesqlresultline['R'] == 1))
  {
  $rounddraw = "Heat";
  if ($racesqlresultline['D'] > 0)
    $rounddraw = $rounddraw . " " . $racesqlresultline['D'];
  $roundno = 1;
  }
if (($racesqlresultline['R'] == "QF") OR ($racesqlresultline['R'] == "Q") OR ($racesqlresultline['R'] == 2))
  {
  $rounddraw = "Quarter-Final";
  if ($racesqlresultline['D'] > 0)
    $rounddraw = $rounddraw . " " . $racesqlresultline['D'];
  $roundno = 2;
  }
if (($racesqlresultline['R'] == "SF") OR ($racesqlresultline['R'] == "S") OR ($racesqlresultline['R'] == 3))
  {
  $rounddraw = "Semi-Final";
  if ($racesqlresultline['D'] > 0)
    $rounddraw = $rounddraw . " " . $racesqlresultline['D'];
  $roundno = 3;
  }
if (($racesqlresultline['R'] == "F") OR ($racesqlresultline['R'] == 4))
  {
  $rounddraw = "Final";
  if ($racesqlresultline['D'] > 0)
    $rounddraw = $rounddraw . " " . $racesqlresultline['D'];
  $roundno = 4;
  }

//Format distance
if ($racesqlresultline['Dist'] <= 1000)
  $distance = $racesqlresultline['Dist'] . "m";
if ($racesqlresultline['Dist'] > 1000)
  $distance = $racesqlresultline['Dist']/1000 . "km";

//Format the class of the race from the classes table
$getclassdetailssql = "SELECT `JSV`, `MW`, `CK`, `Abil`, `Spec`, `Ages`, `FreeText` FROM `classes` WHERE `Race` = ? ";
$classdetails = dbprepareandexecute($srrsdblink,$getclassdetailssql,$raceid);
$boatsize = $racesqlresultline['Boat'];
include 'format-class.php';

//Format name of race
$racename = $raceclass . " " . $distance . " " . $rounddraw;

//Race details into an array
$racedetails = array();
$racedetails['Key'] = $raceid;
$racedetails['Regatta'] = $racesqlresultline['Regatta'];
$racedetails['Name'] = $racename;
$racedetails['Class'] = $raceclass;
$racedetails['Distance'] = $racesqlresultline['Dist'];
$racedetails['Round'] = $roundno;
$racedetails['Draw'] = $racesqlresultline['D'];
?>
