<?php
include_once 'required-functions.php';

if (is_array($racesqlresultline) == true)
  {
  //Format name of round and draw
  if (($racesqlresultline['R'] == "H") OR ($racesqlresultline['R'] == 1))
    {
    $rounddraw = "Heat";
    $roundno = 1;
    }
  if (($racesqlresultline['R'] == "QF") OR ($racesqlresultline['R'] == "Q") OR ($racesqlresultline['R'] == 2))
    {
    $rounddraw = "Quarter-Final";
    $roundno = 2;
    }
  if (($racesqlresultline['R'] == "SF") OR ($racesqlresultline['R'] == "S") OR ($racesqlresultline['R'] == 3))
    {
    $rounddraw = "Semi-Final";
    $roundno = 3;
    }
  if (($racesqlresultline['R'] == "F") OR ($racesqlresultline['R'] == 4))
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

  //Format the class of the race from the classes table
  $getclassdetailssql = "SELECT `JSV`, `MW`, `CK`, `Abil`, `Spec`, `Ages`, `FreeText` FROM `classes` WHERE `Race` = ? ";

  //Prepare an SQL statement to run multiple times, as this engine can be called in a loop
  if (isset($retainedclassdetailssql) == false)
    {
    $retainedclassdetailssql = $getclassdetailssql;
    $classdetailsstmt = dbprepare($srrsdblink,$retainedclassdetailssql);
    }
  elseif ($retainedclassdetailssql != $getclassdetailssql)
    {
    $retainedclassdetailssql = $getclassdetailssql;
    $classdetailsstmt = dbprepare($srrsdblink,$retainedclassdetailssql);
    }

  $classdetails = dbexecute($classdetailsstmt,$raceid);
  //$classdetails = dbprepareandexecute($srrsdblink,$getclassdetailssql,$raceid);
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
  $racedetails['BoatSize'] = $racesqlresultline['Boat'];
  $racedetails['Round'] = $roundno;
  $racedetails['Draw'] = $racesqlresultline['D'];
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
  }
?>
