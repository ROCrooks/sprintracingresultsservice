<?php
//Function to make race details form
function raceformbox($label,$name,$content,$size)
  {
  $html = '<div style="width: 100%; display: table;">';
  $html = $html . '<div style="display: table-row;">';
  $html = $html . '<div style="width: 100px; display: table-cell;">' . $label . '</div>';
  $html = $html . '<div style="display: table-cell;"><input type="text" name="' . $name . '" value="' . $content . '" size="' . $size . '"></div>';
  $html = $html . '</div>';
  $html = $html . '</div>';
  return $html;
  }

if (isset($racetext) == false)
  {
  $regattafile = "regatta" . $regattaid . ".txt";
  $racetext = file_get_contents($regattafile);
  $racetext = explode("Race:",$racetext);
  $racetext = $racetext[1];
  }

//Containter for the form HTML
$formhtml = "";

//Make the race details part of the form
$racedetailshtml = array();
$racedetailshtml['Distance'] = raceformbox("Distance","Distance",$racedetails['Distance'],2);
$racedetailshtml['Boat'] = raceformbox("Boat","Boat",$racedetails['Boat'],1);
$racedetailshtml['Round'] = raceformbox("Round","Round",$racedetails['Round'],1);
$racedetailshtml['Draw'] = raceformbox("Draw","Draw",$racedetails['Draw'],1);
$racedetailshtml['RaceName'] = raceformbox("Name","RaceName",$racedetails['RaceName'],20);
$racedetailshtml = implode("",$racedetailshtml);

//Widths for the defaults
$widths = array();
$widths['Position'] = 50;
$widths['Lane'] = 50;
$widths['Club'] = 50;
$widths['Crew'] = 100;
$widths['Time'] = 50;
$widths['JSV'] = 50;
$widths['MW'] = 50;
$widths['CK'] = 50;

//Field sizes for form
$sizes = array();
$sizes['Position'] = 1;
$sizes['Lane'] = 1;
$sizes['Club'] = 15;
$sizes['Crew'] = 50;
$sizes['Time'] = 5;
$sizes['JSV'] = 1;
$sizes['MW'] = 1;
$sizes['CK'] = 1;

//width: 100%;

$paddlerdetailshtml = '<div style="display: table;">';
//Defaults for JSV, MW, CK for all paddlers
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="display: table-row;">';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Time'] . 'px; display: table-cell;"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" name="defJSV" value="' . $racedetails['defJSV'] . '" size="' . $sizes['JSV'] . '"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" name="defMW" value="' . $racedetails['defMW'] . '" size="' . $sizes['MW'] . '"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" name="defCK" value="' . $racedetails['defCK'] . '" size="' . $sizes['CK'] . '"></div>';
$paddlerdetailshtml = $paddlerdetailshtml . '</div>';
//The headers for the paddler details column headings
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="display: table-row;">';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;">Position</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;">Lane</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Club'] . 'px; display: table-cell;">Club</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;">Crew</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Time'] . 'px; display: table-cell;">Time</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;">JSV</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;">MW</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;">CK</div>';
$paddlerdetailshtml = $paddlerdetailshtml . '</div>';
$paddlerline = 1;
//Each paddler line on a form
foreach($allpaddlerdetails as $paddlerdetails)
  {
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="display: table-row;">';
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Position'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'Position" value="' . $paddlerdetails['Position'] . '" size="' . $sizes['Position'] . '"></div>';
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'Lane" value="' . $paddlerdetails['Lane'] . '" size="' . $sizes['Lane'] . '"></div>';
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Lane'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'Club" value="' . $paddlerdetails['Club'] . '" size="' . $sizes['Club'] . '"></div>';
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Crew'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'Crew" value="' . $paddlerdetails['Crew'] . '" size="' . $sizes['Crew'] . '"></div>';
  if ($paddlerdetails['Time'] != "")
    $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Time'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'Time" value="' . $paddlerdetails['Time'] . '" size="' . $sizes['Time'] . '"></div>';
  else
    $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['Time'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'Time" value="' . $paddlerdetails['NR'] . '" size="' . $sizes['Time'] . '"></div>';
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['JSV'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'JSV" value="' . $paddlerdetails['JSV'] . '" size="' . $sizes['JSV'] . '"></div>';
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['MW'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'MW" value="' . $paddlerdetails['MW'] . '" size="' . $sizes['MW'] . '"></div>';
  $paddlerdetailshtml = $paddlerdetailshtml . '<div style="width: ' . $widths['CK'] . 'px; display: table-cell;"><input type="text" name="' . $paddlerline . 'CK" value="' . $paddlerdetails['CK'] . '" size="' . $sizes['CK'] . '"></div>';
  $paddlerdetailshtml = $paddlerdetailshtml . '</div>';
  //The line of the form for the paddler
  $paddlerline++;
  }
$paddlerdetailshtml = $paddlerdetailshtml . '</div>';

//Format error list
$errorlist = implode("<br>",$errorlist);
$errorlist = "<p>- " . $errorlist . "</p>";

//Format form HTML
$manualformhtml = '<form action="add-regatta.php?Regatta=' . $regattaid . '" method="post"><p>Race Details</p>' . $racedetailshtml . "<p>Paddler Details</p>" . $paddlerdetailshtml . '<p><input type="submit" name="submitfields" value="Add Race Fields"></p></form>';
$textformhtml = '<form action="add-regatta.php?Regatta=' . $regattaid . '" method="post"><p><textarea rows="10" cols="45" name="RaceText">' . $racetext . '</textarea></p><p><input type="submit" name="submittext" value="Add Race Text"></p></form>';
$addpaddlerformhtml = $errorlist . "<p>Manually Add</p>" . $manualformhtml . "<p>Amend the Text</p>" . $textformhtml;
?>
