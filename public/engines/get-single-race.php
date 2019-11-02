<?php
include_once 'required-functions.php';

//Process race details
$racesql = "SELECT `Regatta`, `R`, `D`, `Boat`, `Dist`, `FreeText` FROM `races` WHERE `Key` = ?";
$racesqlresultline = dbprepareandexecute($srrsdblink,$racesql,$raceid);
if (count($racesqlresultline) > 0)
  {
  $racesqlresultline = $racesqlresultline[0];
  }
else
  $racesqlresultline = "";

include 'process-race-details.php';

//Process paddlers
$paddlersql = "SELECT `Key`, `Position`, `Lane`, `Club`, `Crew`, `Time`, `NR`, `JSV`, `MW`, `CK` FROM `paddlers` WHERE `Race` = ?";
$paddlerresults = dbprepareandexecute($srrsdblink,$paddlersql,$raceid);

foreach ($paddlerresults as $paddlerkey=>$paddlerdetails)
  {
  include 'process-paddler-details.php';
  $paddlerresults[$paddlerkey] = $paddlerdetails;
  }

$racedetails['Paddlers'] = $paddlerresults;
?>
