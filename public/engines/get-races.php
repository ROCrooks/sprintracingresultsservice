<?php
include_once 'required-functions.php';

//Get the details about the regatta
$regattadetailssql = "SELECT `Date`, `Days`, `Name` FROM `regattas` WHERE `Key` = ?";
$regattadetailsline = dbprepareandexecute($srrsdblink,$regattadetailssql,$regattaid);
if (count($regattadetailsline) > 0)
  {
  $regattadetailsline = $regattadetailsline[0];
  include 'process-regatta-details.php';
  }

//Base query
$raceconstraints = array($regattaid);
$regattaracessql = "SELECT `Key`, `Regatta`, `Boat`, `Dist`, `R`, `D`, `FreeText` FROM `races` WHERE `Regatta` = ?";

//Make the race search statement using engine
$searchtype = "rows";
include 'make-race-find-stmt.php';

//Make the constr
$classconstraints = raceclasstoconstraints($jsv,$mw,$ck,$abil,$spec,$ages);
$raceconstraints = array_merge($racefindbaseconstraints,$classconstraints);

//Prepare a statement to get races
$paddlersql = "SELECT `Position`, `Club`, `Crew`, `Time`, `NR` FROM `paddlers` WHERE `Race` = ?";
$paddlerstmt = dbprepare($srrsdblink,$paddlersql);

$racesdetailsarray = dbexecute($racesfindstmt,$raceconstraints);
foreach($racesdetailsarray as $racesdetailskey=>$racesqlresultline)
  {
  $raceid = $racesqlresultline['Key'];

  include 'process-race-details.php';

  //Get race finishers
  $paddlerconstraints = array($raceid);
  $dbpaddlers = dbexecute($paddlerstmt,$paddlerconstraints);
  //$dbpaddlers = dbprepareandexecute($srrsdblink,$paddlersql,$paddlerconstraints);

  //Process the paddler details
  foreach($dbpaddlers as $paddlerkey=>$paddlerdetails)
    {
    include 'process-paddler-details.php';
    $dbpaddlers[$paddlerkey] = $paddlerdetails;
    }
  usort($dbpaddlers,'sortfinishers');
  $racedetails['Paddlers'] = $dbpaddlers;
  $racesdetailsarray[$racesdetailskey] = $racedetails;
  }

usort($racesdetailsarray,'sortraceslist');

$regattaresults = array("Details"=>$regattadetailsline,"Races"=>$racesdetailsarray);
?>
