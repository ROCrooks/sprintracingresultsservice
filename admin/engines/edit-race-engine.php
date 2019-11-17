<?php
include_once 'required-functions.php';

echo "<p>Form submitted</p>";

//Get from the form
function getfromform($input)
  {
  if (isset($_POST[$input]) == true)
    $output = $_POST[$input];
  else
    $output = "";

  Return $output;
  }

//Get inputs from form
$inputjsv = getfromform("JSV");
$inputmw = getfromform("MW");
$inputck = getfromform("CK");
$inputregatta = getfromform("Regatta");
$inputboatsize = getfromform("BoatSize");
$inputdistance = getfromform("Distance");
$inputrounddraw = getfromform("RoundDraw");
$inputfreetext = getfromform("FreeText");
$inputabil = getfromform("Abil");
$inputspec = getfromform("Spec");
$inputages = getfromform("Ages");
$inputposition = getfromform("Position");
$inputlane = getfromform("Lane");
$inputcrew = getfromform("Crew");
$inputclub = getfromform("Club");
$inputresult = getfromform("Result");
$inputkey = getfromform("ItemKey");



//Convert input rounds into numbers
if ($inputrounddraw != '')
  {
  $inputround = substr($inputrounddraw,0,1);

  //Format the draw
  $inputdraw = str_replace($inputround,"",$inputrounddraw);
  if ($inputdraw == '')
    $inputdraw = 0;
  }
else
  {
  $inputround = '';
  $inputdraw = '';
  }

//Convert result to time and no result
if (($inputresult == "DNS") OR ($inputresult == "DNF") OR ($inputresult == "DSQ") OR ($inputresult == "ERR") OR ($inputresult == "???"))
  {
  $inputnr = $inputresult;
  $inputtime = 0;
  }
elseif ($inputresult != '')
  {
  $inputtime = hmstosecs($inputresult);
  //Make NR blank if a valid time in seconds
  if (is_numeric($inputtime) == true)
    $inputnr = "";
  else
    {
    $inputnr = "???";
    $inputtime = 0;
    }
  }
else
  {
  $inputnr = '???';
  $inputtime = 0;
  }

//Make SQL and constraints
if (isset($_POST['RaceEdit']) == true)
  {
  $runsql = "UPDATE `races` SET `Regatta` = ?, `Boat` = ?, `Dist` = ?, `R` = ?, `D` = ?, `FreeText` = ? WHERE `Key` = ?";
  $runconstraints = array($inputregatta,$inputboatsize,$inputdistance,$inputround,$inputdraw,$inputfreetext,$raceid);
  }
if (isset($_POST['ClassEdit']) == true)
  {
  $runsql = "UPDATE `classes` SET `JSV` = ?, `MW` = ?, `CK` = ?, `Spec` = ?, `Abil` = ?, `Ages` = ?, `FreeText` = ? WHERE `Key` = ?";
  $runconstraints = array($inputjsv,$inputmw,$inputck,$inputspec,$inputabil,$inputages,$inputfreetext,$inputkey);
  }
if (isset($_POST['ClassDelete']) == true)
  {
  $runsql = "DELETE FROM `classes` WHERE `Key` = ?";
  $runconstraints = array($inputkey);
  }
if (isset($_POST['ClassAdd']) == true)
  {
  $runsql = "INSERT INTO `classes` (`JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $runconstraints = array($inputjsv,$inputmw,$inputck,$inputspec,$inputabil,$inputages,$inputfreetext);
  }
if (isset($_POST['PaddlerEdit']) == true)
  {
  $runsql = "UPDATE `paddlers` SET `Position` = ?, `Lane` = ?, `Crew` = ?, `Club` = ?, `NR` = ?, `Time` = ?, `JSV` = ?, `MW` = ?, `CK` = ? WHERE `Key` = ?";
  $runconstraints = array($inputposition,$inputlane,$inputcrew,$inputclub,$inputnr,$inputtime,$inputjsv,$inputmw,$inputck,$inputkey);
  }
if (isset($_POST['PaddlerDelete']) == true)
  {
  $runsql = "DELETE FROM `paddlers` WHERE `Key` = ?";
  $runconstraints = array($inputkey);
  }
if (isset($_POST['PaddlerAdd']) == true)
  {
  $runsql = "INSERT INTO `paddlers` (`Position`, `Lane`, `Crew`, `Club`, `NR`, `Time`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $runconstraints = array($inputposition,$inputlane,$inputcrew,$inputclub,$inputnr,$inputtime,$inputjsv,$inputmw,$inputck);
  }

if ((isset($runsql) == true) AND (isset($runconstraints) == true))
  {
  echo "<p>" . $runsql . "</p>";
  echo "<p>" . implode(" - ",$runconstraints) . "</p>";
  }
?>
