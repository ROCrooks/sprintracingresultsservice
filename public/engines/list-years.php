<?php
include_once 'required-functions.php';

//Move to user interface
$club = '';
$paddler = '';
$getallregattas = false;

//Get the regattas
$regattafieldswanted = "g.`Date`";
include 'get-regattas.php';

//Find unique years
$uniqueyears = array();
foreach($allregattaslist as $regattadate)
  {
  $regattadate = $regattadate['Date'];
  $regattayear = explode("-",$regattadate);
  $regattayear = $regattayear[0];

  //Add to list of unique years if not already there
  if (($regattayear != '') AND (in_array($regattayear,$uniqueyears) == false))
    array_push($uniqueyears,$regattayear);
  }

sort($uniqueyears);
?>
