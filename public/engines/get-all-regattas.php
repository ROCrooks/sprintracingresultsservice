<?php
include_once 'required-functions.php';

//Default SQL to retrieve regattas
$regattasdetailssql = "SELECT `Key`, `Date`, `Days`, `Name` FROM `regattas`";

//Make constraints if there are club or paddler specified
if (($club != "") OR ($paddler != ""))
  {
  include 'filter-paddler-race-ids.php';

  $racesfilter = makesqlrange($paddlerraceids,"Key");

  //Search for regatta IDs that are in the races
  $regattaidssql = "SELECT DISTINCT `Regatta` FROM `races` WHERE " . $racesfilter['SQLText'];
  $regattaidsconstraints = $racesfilter['SQLValues'];
  $regattaids = dbprepareandexecute($srrsdblink,$regattaidssql,$regattaidsconstraints);
  $regattaids = resulttocolumn($regattaids,"Regatta");

  //Filter regatta list
  $regattasfilter = makesqlrange($regattaids,"Key");
  $regattasdetailssql = $regattasdetailssql . " WHERE " . $regattasfilter['SQLText'];
  $regattalistsqlconstraints = $regattasfilter['SQLValues'];
  }
else
  $regattalistsqlconstraints = array();


//Get regatta details from regatta database
$regattasdetailsresults = dbprepareandexecute($srrsdblink,$regattasdetailssql,$regattalistsqlconstraints);

foreach($regattasdetailsresults as $regattadetailskeys=>$regattadetailsline)
  {
  include 'process-regatta-details.php';
  $regattasdetailsresults[$regattadetailskeys] = $regattadetailsline;
  }
?>
