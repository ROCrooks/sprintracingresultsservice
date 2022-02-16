<?php
include_once $engineslocation . 'srrs-required-functions.php';

if (is_array($racesqlresultline) == true)
  {
  //Format name of round and draw
  if (($racesqlresultline['R'] == "H") OR ($racesqlresultline['R'] == 1))
    {
    $rounddraw = "Heat";
    $roundno = 1;
    }
  elseif (($racesqlresultline['R'] == "QF") OR ($racesqlresultline['R'] == "Q") OR ($racesqlresultline['R'] == 2))
    {
    $rounddraw = "Quarter-Final";
    $roundno = 2;
    }
  elseif (($racesqlresultline['R'] == "SF") OR ($racesqlresultline['R'] == "S") OR ($racesqlresultline['R'] == 3))
    {
    $rounddraw = "Semi-Final";
    $roundno = 3;
    }
  elseif (($racesqlresultline['R'] == "F") OR ($racesqlresultline['R'] == 4))
    {
    $rounddraw = "Final";
    $roundno = 4;
    }
  else
    {
    $rounddraw = "";
    $roundno = 0;
    }

  if ($racesqlresultline['D'] > 0)
    $rounddraw = $rounddraw . " " . $racesqlresultline['D'];

  //Format distance
  if ($racesqlresultline['Dist'] <= 1000)
    $distance = $racesqlresultline['Dist'] . "m";
  if ($racesqlresultline['Dist'] > 1000)
    $distance = $racesqlresultline['Dist']/1000 . "km";

  //Run the engine to get the classes of the race for the $raceid
  include 'get-race-classes.php';

  //$classdetails = dbprepareandexecute($srrsdblink,$getclassdetailssql,$raceid);
  $boatsize = $racesqlresultline['Boat'];
  include 'format-class.php';

  //Format name of race
  $racename = "";
  if ($racesqlresultline['FreeText'] != '')
    $racename = $racename . " " . $racesqlresultline['FreeText'];
  if ($raceclass != '')
    $racename = $racename . " " . $raceclass;
    $racename = $racename . " " . $distance . " " . $rounddraw;
  $racename = substr($racename,1);

  //Race details into an array
  $racedetails = array();
  $racedetails['Key'] = $raceid;
  $racedetails['Regatta'] = $racesqlresultline['Regatta'];
  $racedetails['Name'] = $racename;
  $racedetails['Class'] = $raceclass;
  $racedetails['Distance'] = $racesqlresultline['Dist'];
  $racedetails['BoatSize'] = $racesqlresultline['Boat'];
  $racedetails['Round'] = $roundno;
  $racedetails['Draw'] = $racesqlresultline['D'];
  $racedetails['FreeText'] = $racesqlresultline['FreeText'];
  }
else
  {
  //Race details into an array
  $racedetails = array();
  $racedetails['Key'] = $raceid;
  $racedetails['Regatta'] = 0;
  $racedetails['Name'] = "";
  $racedetails['Class'] = "";
  $racedetails['Distance'] = 0;
  $racedetails['BoatSize'] = 0;
  $racedetails['Round'] = 0;
  $racedetails['Draw'] = 0;
  $racedetails['FreeText'] = $racesqlresultline['FreeText'];
  }
?>
