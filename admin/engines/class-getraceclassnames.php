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

$allraceclasses = array();

//Get all class details and autoclass names
foreach ($racekeys as $raceid)
  {
  $classtoadd = array();
  //Get the race class
  include $publicenginesrelativepath . 'get-race-classes.php';
  $classtoadd['Details'] = $classdetails;

  //Get the race class
  include $publicenginesrelativepath . 'format-class.php';
  $classtoadd['ClassName'] = $raceclass;

  //Only include class details and autoclass names that are new
  if (in_array($classtoadd,$allraceclasses) === false)
    array_push($allraceclasses,$classtoadd);
  }

//Check that there is only one race name and class generated, otherwise warn
if (count($allraceclasses) > 1)
  $multiracewarning = "Warning! This class has different class names specified
   in different races! Recommend purging this class and re-assigning a single
   class to all races instead.";
?>
