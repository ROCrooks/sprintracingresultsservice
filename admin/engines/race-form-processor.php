<?php
//Get race details from race details section of form
$racedetails = array();
$racedetails['Distance'] = $_POST['Distance'];
$racedetails['Boat'] = $_POST['Boat'];
$racedetails['Round'] = $_POST['Round'];
$racedetails['Draw'] = $_POST['Draw'];
$racedetails['RaceName'] = $_POST['RaceName'];

//Get each paddler and commit to paddler array
$allpaddlerdetails = array();
$paddlerrow  = 1;
$crewfield = $paddlerrow . "Crew";
while (isset($_POST[$crewfield]) == true)
  {
  $positionfield = $paddlerrow . "Position";
  $lanefield = $paddlerrow . "Lane";
  $clubfield = $paddlerrow . "Club";
  $crewfield = $paddlerrow . "Crew";
  $timefield = $paddlerrow . "Time";
  $jsvfield = $paddlerrow . "JSV";
  $mwfield = $paddlerrow . "MW";
  $ckfield = $paddlerrow . "CK";

  //Get paddler row details from the
  $paddlerdetails = array();
  $paddlerdetails['Position'] = $_POST[$positionfield];
  $paddlerdetails['Lane'] = $_POST[$lanefield];
  $paddlerdetails['Club'] = $_POST[$clubfield];
  $paddlerdetails['Crew'] = $_POST[$crewfield];
  $paddlerdetails['Time'] = $_POST[$timefield];
  $paddlerdetails['JSV'] = $_POST[$jsvfield];
  $paddlerdetails['MW'] = $_POST[$mwfield];
  $paddlerdetails['CK'] = $_POST[$ckfield];
  array_push($allpaddlerdetails,$paddlerdetails);

  $paddlerrow++;
  }
?>
