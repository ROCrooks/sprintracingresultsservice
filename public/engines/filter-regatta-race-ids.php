<?php
include_once 'required-functions.php';

//Standard that all texts have
$racesql = "SELECT DISTINCT `Key` FROM `races`";

//Standardise a single regatta into a regatta list
if (isset($regattaid) == true)
  {
  $regattalist = array($regattaid);
  }

//Make SQL query for regatta IDs
if (isset($regattalist) == true)
  {
  $regattaidsql = makesqlrange($regattalist,"Regatta");
  $regattalist = $regattaidsql['SQLValues'];
  $racesql = $racesql . " WHERE " . $regattaidsql['SQLText'];
  }
else
  $regattalist = array();

//Get race IDs for races with these classes
$getids = dbprepareandexecute($srrsdblink,$racesql,$regattalist);
$regattaraceids = resulttocolumn($getids,"Key");
?>
