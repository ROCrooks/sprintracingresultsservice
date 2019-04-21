<?php
include_once 'required-functions.php';

$regattaid = 6;

//Base query
$raceconstraints = array($regattaid);
$regattaracessql = "SELECT COUNT(*) FROM `races` WHERE `Regatta` = ?";

//Check for paddler/club constraints
if ($club != "")
  {
  include 'filter-paddler-race-ids.php';

  $paddlerconstraints = makesqlrange($paddlerraceids,"Key");
  $regattaracessql = $regattaracessql . " AND " . $paddlerconstraints['SQLText'];
  $raceconstraints = array_merge($raceconstraints,$paddlerconstraints['SQLValues']);
  }

//Check for class constraints
if (($jsv != "") OR ($mw != "") OR ($ck != "") OR ($spec != "") OR ($abil != "") OR ($ages != ""))
  {
  include 'filter-class-race-ids.php';

  $classconstraints = makesqlrange($classraceids,"Key");
  $regattaracessql = $regattaracessql . " AND " . $classconstraints['SQLText'];
  $raceconstraints = array_merge($raceconstraints,$classconstraints['SQLValues']);
  }

//Format each line using the engine
$racescount = dbprepareandexecute($srrsdblink,$regattaracessql,$raceconstraints);
$racescount = $racescount[0]['COUNT(*)'];
print_r($racescount);
?>
