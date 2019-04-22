<?php
include_once 'required-functions.php';

//Standard that all texts have
$regattasql = "SELECT DISTINCT `Key` FROM `regattas`";

//Standardise a single year into a year list
if (isset($year) == true)
  {
  $yearlist = array($yearid);
  }

//Make SQL query for regatta IDs
if (isset($yearlist) == true)
  {
  $yearsql = makesqlrange($regattalist,"Year");
  $yearlist = $yearsql['SQLValues'];
  $regattasql = $regattasql . " WHERE " . $yearsql['SQLText'];
  }
else
  $yearlist = array();

//Get race IDs for races with these classes
$getids = dbprepareandexecute($srrsdblink,$regattasql,$yearlist);
$yearregattaids = resulttocolumn($getids,"Key");
?>
