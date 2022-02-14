<?php
//Get race details from race details section of form
$racedetails = array();
$racedetails['Distance'] = $_POST['Distance'];
$racedetails['Boat'] = $_POST['Boat'];
$racedetails['Round'] = $_POST['Round'];
$racedetails['Draw'] = $_POST['Draw'];
$racedetails['RaceName'] = $_POST['RaceName'];

//Get defaults for JSV, MW, CK
$racedetails['defJSV'] = $_POST['defJSV'];
$racedetails['defMW'] = $_POST['defMW'];
$racedetails['defCK'] = $_POST['defCK'];

//Get each paddler and commit to paddler array
$allpaddlerdetails = array();
$paddlerrow  = 1;
$crewfield = $paddlerrow . "Crew";
while (isset($_POST[$crewfield]) == true)
  {
  $positionfield = $paddlerrow . "Position";
  $lanefield = $paddlerrow . "Lane";
  $clubfield = $paddlerrow . "Club";
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

  //Define time and no result
  if (($paddlerdetails['Time'] == "???") OR ($paddlerdetails['Time'] == "DNS") OR ($paddlerdetails['Time'] == "DNF") OR ($paddlerdetails['Time'] == "DSQ") OR ($paddlerdetails['Time'] == "ERR"))
    {
    $paddlerdetails['NR'] = $paddlerdetails['Time'];
    $paddlerdetails['Time'] = 0;
    }
  else
    $paddlerdetails['NR'] = "";

  //Use defaults for JSV, MW, CK if not specified
  if ($_POST[$jsvfield] != "")
    $paddlerdetails['JSV'] = $_POST[$jsvfield];
  else
    $paddlerdetails['JSV'] = $racedetails['defJSV'];
  if ($_POST[$mwfield] != "")
    $paddlerdetails['MW'] = $_POST[$mwfield];
  else
    $paddlerdetails['MW'] = $racedetails['defMW'];
  if ($_POST[$ckfield] != "")
    $paddlerdetails['CK'] = $_POST[$ckfield];
  else
    $paddlerdetails['CK'] = $racedetails['defCK'];

  array_push($allpaddlerdetails,$paddlerdetails);

  //Crew is defined here, due to loop
  $paddlerrow++;
  $crewfield = $paddlerrow . "Crew";
  }
?>
