<?php
include_once 'required-functions.php';

//Base query
$raceconstraints = array($regattaid);
$regattaracessql = "SELECT `Key`, `Regatta`, `Boat`, `Dist`, `R`, `D` FROM `races` WHERE `Regatta` = ?";

//Flag to highlight if any of the filters have returned nothing
$noresult = false;

//Check for paddler/club constraints
if (($paddler != "") OR ($club != ""))
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
if (($paddler == "") AND (($jsv != "") OR ($mw != "") OR ($ck != "") OR ($spec != "") OR ($abil != "") OR ($ages != "")))
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

if ($noresult == false)
  {
  //Format each line using the engine
  $racesdetailsarray = dbprepareandexecute($srrsdblink,$regattaracessql,$raceconstraints);
  foreach($racesdetailsarray as $racesdetailskey=>$racesqlresultline)
    {
    $raceid = $racesqlresultline['Key'];

    include 'process-race-details.php';

    //Get race finishers
    $paddlersql = "SELECT `Position`, `Club`, `Crew`, `Time`, `NR` FROM `paddlers` WHERE `Race` = ?";
    $paddlerconstraints = array($raceid);
    $dbpaddlers = dbprepareandexecute($srrsdblink,$paddlersql,$paddlerconstraints);

    //Process the paddler details
    foreach($dbpaddlers as $paddlerkey=>$paddler)
      {
      include 'process-paddler-details.php';
      $dbpaddlers[$paddlerkey] = $paddler;
      }
    usort($dbpaddlers,'sortfinishers');

    $racedetails['Paddlers'] = $dbpaddlers;
    $racesdetailsarray[$racesdetailskey] = $racedetails;
    }

  usort($racesdetailsarray,'sortraceslist');
  }
else
  $racesdetailsarray = array();
?>
