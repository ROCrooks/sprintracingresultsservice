<?php
include_once 'required-functions.php';

include 'user-input-processing.php';

$regattaid = 6;

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


//Format each line using the engine
$racesdetailsarray = dbprepareandexecute($srrsdblink,$regattaracessql,$raceconstraints);
foreach($racesdetailsarray as $racesdetailskey=>$racesqlresultline)
  {
  $raceid = $racesqlresultline['Key'];

  include 'process-race-details.php';

  $racesdetailsarray[$racesdetailskey] = $racedetails;
  }

//print_r($racesdetailsarray);
usort($racesdetailsarray,'sortraceslist');
print_r($racesdetailsarray);
?>
