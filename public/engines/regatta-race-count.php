<?php
include_once 'required-functions.php';

include 'user-input-processing.php';

//All types of class to display
$classsearches = array();
$classsearches[0] = array("JSV"=>"","MW"=>"","CK"=>"","Spec"=>"","Abil"=>"","Ages"=>"","Text"=>"All Races");
$classsearches[1] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"","Text"=>"All Mens");
$classsearches[2] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","Text"=>"Mens A");
$classsearches[3] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"B","Ages"=>"","Text"=>"Mens B");
$classsearches[4] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"C","Ages"=>"","Text"=>"Mens C");
$classsearches[5] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"D","Ages"=>"","Text"=>"Mens D");
$classsearches[6] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"SEN","Text"=>"Senior Mens");
$classsearches[7] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U23","Text"=>"Mens Under 23");
$classsearches[8] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"","Text"=>"All Womens");
$classsearches[9] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","Text"=>"Womens A");
$classsearches[10] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"B","Ages"=>"","Text"=>"Womens B");
$classsearches[11] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"C","Ages"=>"","Text"=>"Womens C");
$classsearches[12] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"D","Ages"=>"","Text"=>"Womens D");
$classsearches[13] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"SEN","Text"=>"Senior Womens");
$classsearches[14] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U23","Text"=>"Womens Under 23");
$classsearches[15] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"","Text"=>"All Boys");
$classsearches[16] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","Text"=>"Boys A");
$classsearches[17] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"B","Ages"=>"","Text"=>"Boys B");
$classsearches[18] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"C","Ages"=>"","Text"=>"Boys C");
$classsearches[19] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"D","Ages"=>"","Text"=>"Boys D");
$classsearches[20] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"JUN","Text"=>"Junior Boys");
$classsearches[21] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U18","Text"=>"Boys Under 18");
$classsearches[22] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U17","Text"=>"Boys Under 17");
$classsearches[23] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U16","Text"=>"Boys Under 16");
$classsearches[24] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U14","Text"=>"Boys Under 14");
$classsearches[25] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"","Text"=>"All Girls");
$classsearches[26] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","Text"=>"Girls A");
$classsearches[27] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"B","Ages"=>"","Text"=>"Girls B");
$classsearches[28] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"C","Ages"=>"","Text"=>"Girls C");
$classsearches[29] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"D","Ages"=>"","Text"=>"Girls D");
$classsearches[30] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"JUN","Text"=>"Junior Girls");
$classsearches[31] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U18","Text"=>"Girls Under 18");
$classsearches[31] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U17","Text"=>"Girls Under 17");
$classsearches[32] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U16","Text"=>"Girls Under 16");
$classsearches[33] = array("JSV"=>"J","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"U14","Text"=>"Girls Under 14");
$classsearches[34] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"","Text"=>"Mens Masters");
$classsearches[35] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","Text"=>"Mens Masters A");
$classsearches[36] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"B","Ages"=>"","Text"=>"Mens Masters B");
$classsearches[37] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"C","Ages"=>"","Text"=>"Mens Masters C");
$classsearches[38] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"D","Ages"=>"","Text"=>"Mens Masters D");
$classsearches[39] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"VET","Text"=>"Mens Masters");
$classsearches[40] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O34","Text"=>"Mens Masters Over 34");
$classsearches[41] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O35","Text"=>"Mens Masters Over 35");
$classsearches[42] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O44","Text"=>"Mens Masters Over 44");
$classsearches[43] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O45","Text"=>"Mens Masters Over 45");
$classsearches[44] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O54","Text"=>"Mens Masters Over 54");
$classsearches[45] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O55","Text"=>"Mens Masters Over 55");
$classsearches[46] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O64","Text"=>"Mens Masters Over 64");
$classsearches[47] = array("JSV"=>"V","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"","Ages"=>"O65","Text"=>"Mens Masters Over 65");
$classsearches[48] = array("JSV"=>"","MW"=>"","CK"=>"C","Spec"=>"","Abil"=>"","Ages"=>"","Text"=>"All Canoes");
$classsearches[49] = array("JSV"=>"","MW"=>"","CK"=>"","Spec"=>"PC","Abil"=>"","Ages"=>"","Text"=>"Paracanoe");
$classsearches[50] = array("JSV"=>"","MW"=>"","CK"=>"","Spec"=>"PD","Abil"=>"","Ages"=>"","Text"=>"Paddleability");
$classsearches[51] = array("JSV"=>"","MW"=>"","CK"=>"","Spec"=>"LT","Abil"=>"","Ages"=>"","Text"=>"Mini-Kayak");
$classsearches[52] = array("JSV"=>"","MW"=>"","CK"=>"","Spec"=>"IS","Abil"=>"","Ages"=>"","Text"=>"Inter-Services");
$classsearches[53] = array("JSV"=>"","MW"=>"","CK"=>"","Spec"=>"SP","Abil"=>"","Ages"=>"","Text"=>"Special Races");

$classesfound = array();
foreach ($classsearches as $lookupclass)
  {
  $classjsv = $lookupclass['JSV'];
  $classmw = $lookupclass['MW'];
  $classck = $lookupclass['CK'];
  $classspec = $lookupclass['Spec'];
  $classabil = $lookupclass['Abil'];
  $classages = $lookupclass['Ages'];

  include 'count-races.php';

  if ($racescount > 0)
    {
    $lookupclass['RacesCount'] = $racescount;
    array_push($classesfound,$lookupclass);
    }
  }
?>
