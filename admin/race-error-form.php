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

$racedetails = array("Distance"=>"1000","defCK"=>"K","Boat"=>"4","Draw"=>"0","Round"=>"F","RaceName"=>"GIRLS A","defMW"=>"W","defJSV"=>"J");
$allpaddlerdetails = array();
$allpaddlerdetails[0] = array("Time"=>"4:22.95","NR"=>"","Position"=>"1","Lane"=>"5","Club"=>"WCS","Crew"=>"ROWLANDS/HOLMES/FERGUSON/COLLINS","JSV"=>"J","MW"=>"W","CK"=>"K");
$allpaddlerdetails[1] = array("Time"=>"4:29.68","NR"=>"","Position"=>"2","Lane"=>"3","Club"=>"WCS","Crew"=>"R. BEER/R. AYRES/R. MIDDLEHURST/R. CHURNSIDE","JSV"=>"J","MW"=>"W","CK"=>"K");
$allpaddlerdetails[2] = array("Time"=>"4:37.17","NR"=>"","Position"=>"3","Lane"=>"2","Club"=>"ELM","Crew"=>"R. WILLIAMS/R. ILLINESI/R. DE-FERRER/R. O-CALLAGHAN","JSV"=>"J","MW"=>"W","CK"=>"K");
$allpaddlerdetails[3] = array("Time"=>"4:38.64","NR"=>"","Position"=>"4","Lane"=>"7","Club"=>"LBZ/LBZ/LBZ/TRU","Crew"=>"R. OXTOBY/R. OXTOBY/R. DOUGALL/R. HARRIS","JSV"=>"J","MW"=>"W","CK"=>"K");
$allpaddlerdetails[4] = array("Time"=>"4:52.41","NR"=>"","Position"=>"5","Lane"=>"6","Club"=>"BAS/BAS/BAS/BOA","Crew"=>"R. SMITH/R. SMITH/R. SIMMONS/R. ILLIDGE","JSV"=>"J","MW"=>"W","CK"=>"K");
$allpaddlerdetails[5] = array("Time"=>"4:55.78","NR"=>"","Position"=>"6","Lane"=>"1","Club"=>"WEY","Crew"=>"R. CHILDERSTONE/R. CROUCHER R HAWS/R. THOMAS","JSV"=>"J","MW"=>"W","CK"=>"K");
$allpaddlerdetails[6] = array("Time"=>"5:00.47","NR"=>"","Position"=>"7","Lane"=>"4","Club"=>"LBZ/LBZ/LBZ/BAN","Crew"=>"R. HUSSEY/R. ROONEY/R. CREAMER/R. WOOD","JSV"=>"J","MW"=>"W","CK"=>"K");

//Get the first race from the file
$racefile = "clean-results.txt";
$racetext = file_get_contents($racefile);
$racetext = explode("Race:",$racetext);
$racetext = $racetext[1];

//Containter for the form HTML
$formhtml = "";

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
  }
$paddlerdetailshtml = $paddlerdetailshtml . '</div>';

$manualformhtml = '<form><p>Race Details</p>' . $racedetailshtml . "<p>Paddler Details</p>" . $paddlerdetailshtml . '</form>';
$textformhtml = '<form><textarea rows="10" cols="45">' . $racetext . '</textarea></form>';
$addpaddlerformhtml = "<p>Manually Add</p>" . $manualformhtml . "<p>Amend the Text</p>" . $textformhtml;

echo $addpaddlerformhtml;
?>
