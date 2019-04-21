<?php
include_once 'required-functions.php';

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
echo $regattaracessql . "<br>";

//Count the number of races of this type
//If none were found using the class query then result is 0
if (count($classconstraints['SQLValues']) > 0)
  {
  $racescount = dbprepareandexecute($srrsdblink,$regattaracessql,$raceconstraints);
  $racescount = $racescount[0]['COUNT(*)'];
  }
else
  $racescount = 0;
?>
