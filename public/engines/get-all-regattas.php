<?php
include_once 'required-functions.php';

//Get regatta details from regatta database
$regattasdetailssql = "SELECT `Key`, `Date`, `Days`, `Name` FROM `regattas`";
$regattasdetailsresults = dbprepareandexecute($srrsdblink,$regattasdetailssql,array());

foreach($regattasdetailsresults as $regattadetailskeys=>$regattadetailsline)
  {
  include 'process-regatta-details.php';
  $regattasdetailsresults[$regattadetailskeys] = $regattadetailsline;
  }

print_r($regattasdetailsresults);
?>
