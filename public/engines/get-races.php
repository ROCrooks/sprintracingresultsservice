<?php
include_once 'required-functions.php';

//Get the details about the regatta
$regattadetailssql = "SELECT `Date`, `Days`, `Name` FROM `regattas` WHERE `Key` = ?";
$regattadetailsline = dbprepareandexecute($srrsdblink,$regattadetailssql,$regattaid);
if (count($regattadetailsline) > 0)
  {
  $regattadetailsline = $regattadetailsline[0];
  include 'engines/process-regatta-details.php';
  }

//Base query
$raceconstraints = array($regattaid);
$regattaracessql = "SELECT `Key`, `Regatta`, `Boat`, `Dist`, `R`, `D` FROM `races` WHERE `Regatta` = ?";

//Check for paddler/club constraints
if (($paddler != "") OR ($club != ""))
  {
  include 'filter-paddler-race-ids.php';

  $paddlerconstraints = makesqlrange($paddlerraceids,"Key");
  $regattaracessql = $regattaracessql . " AND " . $paddlerconstraints['SQLText'];
  $raceconstraints = array_merge($raceconstraints,$paddlerconstraints['SQLValues']);
  }

//Check for class constraints
if (($paddler == "") AND (($jsv != "") OR ($mw != "") OR ($ck != "") OR ($spec != "") OR ($abil != "") OR ($ages != "")))
  {
  include 'filter-class-race-ids.php';

  $classconstraints = makesqlrange($classraceids,"Key");
  $regattaracessql = $regattaracessql . " AND " . $classconstraints['SQLText'];
  $raceconstraints = array_merge($raceconstraints,$classconstraints['SQLValues']);
  }

//Prepare a statement to get races
$paddlersql = "SELECT `Position`, `Club`, `Crew`, `Time`, `NR` FROM `paddlers` WHERE `Race` = ?";
$paddlerstmt = dbprepare($srrsdblink,$paddlersql);

$racesdetailsarray = dbprepareandexecute($srrsdblink,$regattaracessql,$raceconstraints);
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
