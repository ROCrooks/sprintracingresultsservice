<?php
include 'relative-path.php';
include 'defaulturls.php';

//To attach variables to the URL
if (strpos($defaulturls['EditRace'],"?") === false)
  $variablejoin = "?";
else
  $variablejoin = "&";

$raceid = $_GET['race'];

if (isset($_POST['ClassEdit']) == true)
  {
  echo "<p>Edit Class Button</p>";
  }
elseif (isset($_POST['ClassDelete']) == true)
  {
  echo "<p>Delete Class Button</p>";
  }
elseif (isset($_POST['ClassAdd']) == true)
  {
  echo "<p>Add Class Button</p>";
  }

$includeclassids = true;
include $publicenginesrelativepath . 'get-single-race.php';

echo '<p>Race Details:</p>';
print_r($racedetails);
echo '<br>';

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
$widths['Position'] = 50;
$widths['Lane'] = 50;
$widths['Crew'] = 150;
$widths['Club'] = 50;
$widths['Result'] = 50;

echo '<form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post">';

//The generic race details
echo '<p class="blockheading">Race Details</p>';
echo '<div style="display: table;">';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Regatta Number:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="2" value="' . $racedetails['Regatta'] . '"> (This will move the regatta the race is in)</div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Boat Size:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="1" value="' . $racedetails['BoatSize'] . '"></div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Distance:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="3" value="' . $racedetails['Distance'] . '"></div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Round/Draw:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="1" value="' . $rounddraw . '"></div>';
echo '</div>';

echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: ' . $widths['Label'] . 'px;">Free Text:</div>';
echo '<div style="display: table-cell; width: ' . $widths['Box'] . 'px;"><input type="text" size="10" value="' . $racedetails['FreeText'] . '"></div>';
echo '</div>';

echo '</div>';

//The button of the form
echo '<p><input type="submit" name="RaceEdit" value="Edit"></p>';
echo '</form>';

//The class details
echo '<p class="blockheading">Class Details</p>';

//Header for class list
echo '<div style="width: 50%; display: table;">';

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
  echo '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"><input type="hidden" name="ClassID" value="' . $individualclass['Key'] . '"></div>';
  echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" size="1" value="' . $individualclass['JSV'] . '" name="JSV"></div>';
  echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" size="1" value="' . $individualclass['MW'] . '" name="MW"></div>';
  echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" size="1" value="' . $individualclass['CK'] . '" name="CK"></div>';
  echo '<div style="width: ' . $widths['Abil'] . 'px; display: table-cell;"><input type="text" size="2" value="' . $individualclass['Abil'] . '" name="Abil"></div>';
  echo '<div style="width: ' . $widths['Spec'] . 'px; display: table-cell;"><input type="text" size="2" value="' . $individualclass['Spec'] . '" name="Spec"></div>';
  echo '<div style="width: ' . $widths['Ages'] . 'px; display: table-cell;"><input type="text" size="4" value="' . $individualclass['Ages'] . '" name="Ages"></div>';
  echo '<div style="width: ' . $widths['FreeText'] . 'px; display: table-cell;"><input type="text" size="10" value="' . $individualclass['FreeText'] . '" name="FreeText"></div>';
  echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Edit" name="ClassEdit"></div>';
  echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Delete" name="ClassDelete"></div>';
  echo '<div style="0px; display: table-cell;"></form></div>';
  echo '</div>';
  }

//Form to add a new class
echo '<div style="display: table-row;">';
echo '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"></div>';
echo '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" size="1"></div>';
echo '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" size="1"></div>';
echo '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" size="1"></div>';
echo '<div style="width: ' . $widths['Abil'] . 'px; display: table-cell;"><input type="text" size="2"></div>';
echo '<div style="width: ' . $widths['Spec'] . 'px; display: table-cell;"><input type="text" size="2"></div>';
echo '<div style="width: ' . $widths['Ages'] . 'px; display: table-cell;"><input type="text" size="4"></div>';
echo '<div style="width: ' . $widths['FreeText'] . 'px; display: table-cell;"><input type="text" size="10"></div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"><input type="submit" value="Add" name="ClassAdd"></div>';
echo '<div style="width: ' . $widths['Button'] . 'px; display: table-cell;"></div>';
echo '<div style="display: table-cell;"></form></div>';
echo '</div>';

echo '</div>';

//The paddler details
echo '<p class="blockheading">Paddler Details</p>';

//Header for paddler list
echo '<div style="width: 50%; display: table;">';

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

echo '</div>';
?>
