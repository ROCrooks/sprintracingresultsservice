<?php
include_once 'required-functions.php';

$findsizes = array(1,2,4);
$selectas = "Individual";

$sizeraceids = array();

//Get race IDs for individual boat sizes
//Currently no case for getting them together as a batch
foreach($findsizes as $racesize)
  {
  if (isset($findsizeracesstmt) == false)
    {
    $findsizeracessql = "SELECT `Key` FROM `races` WHERE `Boat` = ?";
    $findsizeracesstmt = dbprepare($srrsdblink,$findsizeracessql);
    }

  $result = dbexecute($findsizeracesstmt,$racesize);

  //Get result as a single array
  $result = resulttocolumn($result,"Key");
  $sizeraceids[$racesize] = $result;
  }
?>
