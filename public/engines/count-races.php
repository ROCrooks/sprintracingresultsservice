<?php
include_once 'required-functions.php';

//Base query
$raceconstraints = array($regattaid);
$regattaracessql = "SELECT COUNT(*) FROM `races` WHERE `Regatta` = ?";

//Flag to highlight if any of the filters have returned nothing
$noresult = false;

//Check for paddler/club constraints
if ($club != "")
  {
  include 'filter-paddler-race-ids.php';

  //Only include this part in the SQL if results are found
  if (count($paddlerraceids) == 0)
    $noresult = true;
  else
    {
    $paddlerconstraints = makesqlrange($paddlerraceids,"Key");
    $regattaracessql = $regattaracessql . " AND " . $paddlerconstraints['SQLText'];
    $raceconstraints = array_merge($raceconstraints,$paddlerconstraints['SQLValues']);
    }
  }

//Check for class constraints
if (($jsv != "") OR ($mw != "") OR ($ck != "") OR ($spec != "") OR ($abil != "") OR ($ages != ""))
  {
  include 'filter-class-race-ids.php';

  //Only include this part in the SQL if results are found
  if (count($classraceids) == 0)
    $noresult = true;
  else
    {
    $classconstraints = makesqlrange($classraceids,"Key");
    $regattaracessql = $regattaracessql . " AND " . $classconstraints['SQLText'];
    $raceconstraints = array_merge($raceconstraints,$classconstraints['SQLValues']);
    }
  }

//Count the number of races of this type
//If none were found using the class query then result is 0
if ($noresult == false)
  {
  $racescount = dbprepareandexecute($srrsdblink,$regattaracessql,$raceconstraints);
  $racescount = $racescount[0]['COUNT(*)'];
  }
else
  $racescount = 0;
?>
