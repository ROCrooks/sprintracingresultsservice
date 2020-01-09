<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//To attach variables to the URL
if (strpos($defaulturls['EditRace'],"?") === false)
  $variablejoin = "?";
else
  $variablejoin = "&";

//Get race ID from either POST or GET
if (isset($_GET['race']) == true)
  $raceid = $_GET['race'];
elseif (isset($_POST['race']) == true)
  $raceid = $_POST['race'];

//Process forms
if ((isset($_POST['RaceEdit']) == true) OR (isset($_POST['ClassEdit']) == true) OR (isset($_POST['ClassDelete']) == true) OR (isset($_POST['ClassAdd']) == true) OR (isset($_POST['PaddlerEdit']) == true) OR (isset($_POST['PaddlerDelete']) == true) OR (isset($_POST['PaddlerAdd']) == true))
  include $adminenginesrelativepath . 'edit-race-engine.php';

$includeclassids = true;
include $publicenginesrelativepath . 'get-single-race.php';

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

echo '<div class="item">';

echo '<form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post">';

//The generic race details
echo '<p class="blockheading">Race Details</p>';

echo '<p>' . $racedetails['Name'] . '</p>';

echo '<div style="display: table;">';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Regatta Number:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="2" value="' . $racedetails['Regatta'] . '" name="Regatta"> (This will move the regatta the race is in)</div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Boat Size:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="1" value="' . $racedetails['BoatSize'] . '" name="BoatSize"></div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Distance:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="3" value="' . $racedetails['Distance'] . '" name="Distance"></div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Round/Draw:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="1" value="' . $rounddraw . '" name="RoundDraw"></div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Free Text:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="10" value="' . $racedetails['FreeText'] . '" name="FreeText"></div>';
echo '</div>';

echo '</div>';

//The button of the form
echo '<p><input type="submit" name="RaceEdit" value="Edit"></p>';
echo '</form>';

//The class details
echo '<p class="blockheading">Class Details</p>';

//Echo the class form
$classformactionurl = $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid;
$multirowform = false;
include $adminenginesrelativepath . 'class-form-html.php';
echo $classformhtml;

/*
$paddlerstablewidth = $widths['JSV']+$widths['MW']+$widths['CK']+$widths['Abil']+$widths['Spec']+$widths['Ages']+$widths['FreeText']+$widths['Button'];

//Header for class list

echo '<div style="width: ' . $paddlerstablewidth . 'px; display: table;">';
//echo '<div style="width: 50%; display: table;">';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell;"></div>';
echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;">JSV</div>';
echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;">MW</div>';
echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;">CK</div>';
echo '<div style="width: ' . $widths['Abil'] . 'px; display: table-cell;">Abil</div>';
echo '<div style="width: ' . $widths['Spec'] . 'px; display: table-cell;">Spec</div>';
echo '<div style="width: ' . $widths['Ages'] . 'px; display: table-cell;">Ages</div>';
echo '<div style="width: ' . $widths['FreeText'] . 'px; display: table-cell;">FreeText</div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></div>';
echo '<div style="display: table-cell;"></div>';
echo '</div>';


//Each class to edit
foreach ($classdetails as $individualclass)
  {
  //Pass the name of the
  echo '<div style="display: table-row;">';
  echo '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"><input type="hidden" name="ItemKey" value="' . $individualclass['Key'] . '"></div>';
  echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" value="' . $individualclass['JSV'] . '" name="JSV"></div>';
  echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" value="' . $individualclass['MW'] . '" name="MW"></div>';
  echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" value="' . $individualclass['CK'] . '" name="CK"></div>';
  echo '<div style="width: ' . $widths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" value="' . $individualclass['Abil'] . '" name="Abil"></div>';
  echo '<div style="width: ' . $widths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" value="' . $individualclass['Spec'] . '" name="Spec"></div>';
  echo '<div style="width: ' . $widths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" value="' . $individualclass['Ages'] . '" name="Ages"></div>';
  echo '<div style="width: ' . $widths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="' . $individualclass['FreeText'] . '" name="FreeText"></div>';
  echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Edit" name="ClassEdit"></div>';
  echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Delete" name="ClassDelete" onclick="return confirm(\'This will delete the race class. Are you sure you want to continue?\')"></div>';
  echo '<div style="0px; display: table-cell;"></form></div>';
  echo '</div>';
  }

//Form to add a new class
echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"></div>';
echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" name="JSV"></div>';
echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" name="MW"></div>';
echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" name="CK"></div>';
echo '<div style="width: ' . $widths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" name="Abil"></div>';
echo '<div style="width: ' . $widths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" name="Spec"></div>';
echo '<div style="width: ' . $widths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" name="Ages"></div>';
echo '<div style="width: ' . $widths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" name="FreeText"></div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Add" name="ClassAdd"></div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></div>';
echo '<div style="display: table-cell;"></form></div>';
echo '</div>';
*/

echo '</div>';

//The paddler details
echo '<p class="blockheading">Paddler Details</p>';

$paddlerstablewidth = $widths['Position']+$widths['Lane']+$widths['Crew']+$widths['Club']+$widths['Result']+$widths['JSV']+$widths['MW']+$widths['CK']+$widths['Button']+$widths['Button'];

//Header for paddler list
echo '<div style="width: ' . $paddlerstablewidth . 'px; display: table;">';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: 0px;"></div>';
echo '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;">Position</div>';
echo '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;">Lane</div>';
echo '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;">Crew</div>';
echo '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;">Club</div>';
echo '<div style="width: ' . $widths['Result'] . 'px; display: table-cell;">Result</div>';
echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;">JSV</div>';
echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;">MW</div>';
echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;">CK</div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></div>';
echo '<div style="display: table-cell;"></div>';
echo '</div>';

//Each paddler in a form line
foreach ($racedetails['Paddlers'] as $paddler)
  {
  echo '<div style="display: table-row;">';
  echo '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"><input type="hidden" name="ItemKey" value="' . $paddler['Key'] . '"></div>';
  echo '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;"><input type="text" name="Position" value="' . $paddler['Position'] . '" size="' . $fieldsizes['Position'] . '"></div>';
  echo '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;"><input type="text" name="Lane" value="' . $paddler['Lane'] . '" size="' . $fieldsizes['Lane'] . '"></div>';
  echo '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;"><input type="text" name="Crew" value="' . $paddler['Crew'] . '" size="' . $fieldsizes['Crew'] . '"></div>';
  echo '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;"><input type="text" name="Club" value="' . $paddler['Club'] . '" size="' . $fieldsizes['Club'] . '"></div>';
  echo '<div style="width: ' . $widths['Result'] . 'px; display: table-cell;"><input type="text" name="Result" value="' . $paddler['Time'] . '" size="' . $fieldsizes['Result'] . '"></div>';
  echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" name="JSV" value="' . $paddler['JSV'] . '" size="' . $fieldsizes['JSV'] . '"></div>';
  echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" name="MW" value="' . $paddler['MW'] . '" size="' . $fieldsizes['MW'] . '"></div>';
  echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" name="CK" value="' . $paddler['CK'] . '" size="' . $fieldsizes['CK'] . '"></div>';
  echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Edit" name="PaddlerEdit"></div>';
  echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Delete" name="PaddlerDelete" onclick="return confirm(\'This will delete the paddler. Are you sure you want to continue?\')"></div>';
  echo '<div style="display: table-cell;"></form></div>';
  echo '</div>';
  }

//New paddler insert
echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"></div>';
echo '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;"><input type="text" name="Position" value="" size="' . $fieldsizes['Position'] . '"></div>';
echo '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;"><input type="text" name="Lane" value="" size="' . $fieldsizes['Lane'] . '"></div>';
echo '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;"><input type="text" name="Crew" value="" size="' . $fieldsizes['Crew'] . '"></div>';
echo '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;"><input type="text" name="Club" value="" size="' . $fieldsizes['Club'] . '"></div>';
echo '<div style="width: ' . $widths['Result'] . 'px; display: table-cell;"><input type="text" name="Result" value="" size="' . $fieldsizes['Result'] . '"></div>';
echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" name="JSV" value="" size="' . $fieldsizes['JSV'] . '"></div>';
echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" name="MW" value="" size="' . $fieldsizes['MW'] . '"></div>';
echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" name="CK" value="" size="' . $fieldsizes['CK'] . '"></div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Add" name="PaddlerAdd"></div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></form></div>';
echo '<div style="display: table-cell;"></div>';
echo '</div>';

//Close Paddlers Table
echo '</div>';

echo '<p><a href="' . $defaulturls['EditRegatta'] . $ahrefjoin . 'regatta=' . $racedetails['Regatta'] . '?deleterace=' . $raceid . '" onclick="return confirm(\'This will delete the race. Are you sure you want to continue?\')">Delete Race</a></p>';

//Close page container
echo '</div>';
?>
