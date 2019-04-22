<?php
include_once 'required-functions.php';

$raceid = 143;

//Process race details
$racesql = "SELECT `Regatta`, `R`, `D`, `Boat`, `Dist` FROM `races` WHERE `Key` = ?";
$racesqlresultline = dbprepareandexecute($srrsdblink,$racesql,$raceid);
$racesqlresultline = $racesqlresultline[0];
include 'process-race-details.php';

//Process paddlers
$paddlersql = "SELECT `Position`, `Lane`, `Club`, `Crew`, `Time`, `NR`, `JSV`, `MW`, `CK` FROM `paddlers` WHERE `Race` = ?";
$paddlerresults = dbprepareandexecute($srrsdblink,$paddlersql,$raceid);

foreach ($paddlerresults as $paddlerkey=>$paddler)
  {
  include 'process-paddler-details.php';
  $paddlerresults[$paddlerkey] = $paddler;
  }

$racedetails['Paddlers'] = $paddlerresults;

print_r($racedetails);
?>
