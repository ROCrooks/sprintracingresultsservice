<?php
//Get race ID from either POST or GET
if (isset($_GET['race']) == true)
  $raceid = $_GET['race'];
elseif (isset($_POST['race']) == true)
  $raceid = $_POST['race'];

//Process forms
if ((isset($_POST['RaceEdit']) == true) OR (isset($_POST['ClassEdit']) == true) OR (isset($_POST['ClassDelete']) == true) OR (isset($_POST['ClassAdd']) == true) OR (isset($_POST['PaddlerEdit']) == true) OR (isset($_POST['PaddlerDelete']) == true) OR (isset($_POST['PaddlerAdd']) == true))
  include $engineslocation . 'edit-race-engine.php';

$includeclassids = true;
include $engineslocation . 'get-single-race.php';

//Regatta ID for back linking
$regatta = $racedetails['Regatta'];

//Make the Round/Draw name of the race
if ($racedetails['Round'] == 1)
  $round = "H";
if ($racedetails['Round'] == 2)
  $round = "Q";
if ($racedetails['Round'] == 3)
  $round = "S";
if ($racedetails['Round'] == 4)
  $round = "F";
$rounddraw = $round . $racedetails['Draw'];

//Table cell widths can be changed here
$widths = array();
$widths['Label'] = 150;
$widths['Box'] = 350;
$widths['JSV'] = 50;
$widths['MW'] = $widths['JSV'];
$widths['CK'] = $widths['JSV'];
$widths['Abil'] = 70;
$widths['Spec'] = $widths['Abil'];
$widths['Ages'] = $widths['Abil'];
$widths['FreeText'] = 100;
$widths['Button'] = 60;
$widths['Position'] = 60;
$widths['Lane'] = 50;
$widths['Crew'] = 220;
$widths['Club'] = 100;
$widths['Result'] = 90;

//Sizes of input fields
$fieldsizes = array();
$fieldsizes['Position'] = 1;
$fieldsizes['Lane'] = 1;
$fieldsizes['Crew'] = 30;
$fieldsizes['Club'] = 10;
$fieldsizes['Result'] = 8;
$fieldsizes['JSV'] = 1;
$fieldsizes['MW'] = 1;
$fieldsizes['CK'] = 1;
$fieldsizes['Abil'] = 2;
$fieldsizes['Spec'] = 2;
$fieldsizes['Ages'] = 2;
$fieldsizes['FreeText'] = 10;

$pagehtml = '<section>';

if (isset($outputmessage) == true)
  $pagehtml = $pagehtml . $outputmessage;

$pagehtml = $pagehtml . '<form action="EditRace?race=' . $raceid . '" method="post">';

//The generic race details
$pagehtml = $pagehtml . '<p class="blockheading">Race Details</p>';

$pagehtml = $pagehtml . '<p>' . $racedetails['Name'] . '</p>';

$pagehtml = $pagehtml . '<div style="display: table;">';

$pagehtml = $pagehtml . '<div style="display: table-row;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Regatta Number:</div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="2" value="' . $racedetails['Regatta'] . '" name="Regatta"> (This will move the regatta the race is in)</div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="display: table-row;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Boat Size:</div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="1" value="' . $racedetails['BoatSize'] . '" name="BoatSize"></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="display: table-row;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Distance:</div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="3" value="' . $racedetails['Distance'] . '" name="Distance"></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="display: table-row;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Round/Draw:</div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="1" value="' . $rounddraw . '" name="RoundDraw"></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<div style="display: table-row;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Free Text:</div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="10" value="' . $racedetails['FreeText'] . '" name="FreeText"></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</div>';

//The button of the form
$pagehtml = $pagehtml . '<p><input type="submit" name="RaceEdit" value="Edit"></p>';
$pagehtml = $pagehtml . '</form>';

//The class details
$pagehtml = $pagehtml . '<p class="blockheading">Class Details</p>';

//Echo the class form
$classformactionurl = 'EditRace?race=' . $raceid;
$multirowform = false;
include $engineslocation . 'class-form-html.php';
$pagehtml = $pagehtml . $classformhtml;

//The paddler details
$pagehtml = $pagehtml . '<p class="blockheading">Paddler Details</p>';

$paddlerstablewidth = $widths['Position']+$widths['Lane']+$widths['Crew']+$widths['Club']+$widths['Result']+$widths['JSV']+$widths['MW']+$widths['CK']+$widths['Button']+$widths['Button'];

//Header for paddler list
$pagehtml = $pagehtml . '<div style="width: ' . $paddlerstablewidth . 'px; display: table;">';

$pagehtml = $pagehtml . '<div style="display: table-row;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 0px;"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;">Position</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;">Lane</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;">Crew</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;">Club</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Result'] . 'px; display: table-cell;">Result</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;">JSV</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;">MW</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;">CK</div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell;"></div>';
$pagehtml = $pagehtml . '</div>';

//Each paddler in a form line
foreach ($racedetails['Paddlers'] as $paddler)
  {
  $pagehtml = $pagehtml . '<div style="display: table-row;">';
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: 0px;"><form action="EditRace?race=' . $raceid . '" method="post"><input type="hidden" name="ItemKey" value="' . $paddler['Key'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;"><input type="text" name="Position" value="' . $paddler['Position'] . '" size="' . $fieldsizes['Position'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;"><input type="text" name="Lane" value="' . $paddler['Lane'] . '" size="' . $fieldsizes['Lane'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;"><input type="text" name="Crew" value="' . $paddler['Crew'] . '" size="' . $fieldsizes['Crew'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;"><input type="text" name="Club" value="' . $paddler['Club'] . '" size="' . $fieldsizes['Club'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['Result'] . 'px; display: table-cell;"><input type="text" name="Result" value="' . $paddler['Time'] . '" size="' . $fieldsizes['Result'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" name="JSV" value="' . $paddler['JSV'] . '" size="' . $fieldsizes['JSV'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" name="MW" value="' . $paddler['MW'] . '" size="' . $fieldsizes['MW'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" name="CK" value="' . $paddler['CK'] . '" size="' . $fieldsizes['CK'] . '"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Edit" name="PaddlerEdit"></div>';
  $pagehtml = $pagehtml . '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Delete" name="PaddlerDelete" onclick="return confirm(\'This will delete the paddler. Are you sure you want to continue?\')"></div>';
  $pagehtml = $pagehtml . '<div style="display: table-cell;"></form></div>';
  $pagehtml = $pagehtml . '</div>';
  }

//New paddler insert
$pagehtml = $pagehtml . '<div style="display: table-row;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 0px;"><form action="EditRace?race=' . $raceid . '" method="post"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;"><input type="text" name="Position" value="" size="' . $fieldsizes['Position'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;"><input type="text" name="Lane" value="" size="' . $fieldsizes['Lane'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;"><input type="text" name="Crew" value="" size="' . $fieldsizes['Crew'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;"><input type="text" name="Club" value="" size="' . $fieldsizes['Club'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Result'] . 'px; display: table-cell;"><input type="text" name="Result" value="" size="' . $fieldsizes['Result'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" name="JSV" value="" size="' . $fieldsizes['JSV'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" name="MW" value="" size="' . $fieldsizes['MW'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" name="CK" value="" size="' . $fieldsizes['CK'] . '"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Add" name="PaddlerAdd"></div>';
$pagehtml = $pagehtml . '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></form></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell;"></div>';
$pagehtml = $pagehtml . '</div>';

//Close Paddlers Table
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '<p><a href="EditRegatta?regatta=' . $racedetails['Regatta'] . '?deleterace=' . $raceid . '" onclick="return confirm(\'This will delete the race. Are you sure you want to continue?\')">Delete Race</a></p>';

//Close page container
$pagehtml = $pagehtml . '</section>';

$regattaid = $racedetails['Regatta'];
?>
