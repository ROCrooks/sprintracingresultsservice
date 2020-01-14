<?php
include 'required-functions.php';

//Include the required paths if they haven't been already set
//I.e. called from another script
if ((isset($publicenginesrelativepath) == false) AND (isset($adminenginesrelativepath) == false))
  include '../srrsadminrelativepaths.php';

//Retrieve all race keys with a particular race name
$getracekeyssql = "SELECT `Key` FROM `races` WHERE `Class` = ?";
$racekeys = dbprepareandexecute($srrsdblink,$getracekeyssql,$findclassname);
$racekeys = resulttocolumn($racekeys);

//Get all class details and autoclass names
foreach ($racekeys as $raceid)
  {
  //Get the race class
  include $publicenginesrelativepath . 'get-race-classes.php';

  //Get the race class
  include $publicenginesrelativepath . 'format-class.php';

  echo $raceclass . "<br>";
  }

//Only include class details and autoclass names that are new

//Check that there is only one race name and class generated, otherwise warn
?>
