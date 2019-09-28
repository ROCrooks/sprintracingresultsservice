<?php
include 'relative-path.php';
include 'defaulturls.php';

$raceid = $_GET['race'];

if (isset($_POST['ClassEdit']) == true)
  {
  echo "<p>Edit Button</p>";
  }
elseif (isset($_POST['ClassDelete']) == true)
  {
  echo "<p>Delete Button</p>";
  }
elseif (isset($_POST['ClassAdd']) == true)
  {
  echo "<p>Add Button</p>";
  }

$includeclassids = true;
include $publicenginesrelativepath . 'get-single-race.php';

echo '<p>Race Details:</p>';
print_r($racedetails);
echo '<br>';
echo '<p>Class Details:</p>';
print_r($classdetails);
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

//The generic race details
echo '<p class="blockheading">Race Details</p>';
echo '<p>Regatta Number: <input type="text" size="2" value="' . $racedetails['Regatta'] . '"> (This will move the regatta the race is in)</p>';
echo '<p>Boat Size: <input type="text" size="1" value="' . $racedetails['BoatSize'] . '"></p>';
echo '<p>Distance: <input type="text" size="3" value="' . $racedetails['Distance'] . '"></p>';
echo '<p>Race Round/Draw: <input type="text" size="1" value="' . $rounddraw . '"></p>';
echo '<p>Free Text: <input type="text" size="10" value="' . $racedetails['FreeText'] . '"></p>';

//The class details
echo '<p class="blockheading">Class Details</p>';

//Table cell widths can be changed here
$widths = array();
$widths['JSV'] = 5;
$widths['MW'] = $widths['JSV'];
$widths['CK'] = $widths['JSV'];
$widths['Abil'] = 50;
$widths['Spec'] = $widths['Abil'];
$widths['Ages'] = $widths['Abil'];
$widths['FreeText'] = 100;
$widths['Button'] = 7;

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

//To attach variables to the URL
if (strpos($defaulturls['EditRace'],"?") === false)
  $variablejoin = "?";
else
  $variablejoin = "&";

//Each class to edit
foreach ($classdetails as $individualclass)
  {
  //Pass the name of the
  echo '<div style="display: table-row;">';
  echo '<div style="display: table-cell;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"><input type="hidden" name="ClassID" value="' . $individualclass['Key'] . '"></div>';
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
echo '<div style="display: table-cell;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"></div>';
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


?>
