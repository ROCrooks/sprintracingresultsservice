<?php
//Get the directory of the engines
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);
$enginesdirectory = $currentdirectory . "/srrs/engines/";

include $enginesdirectory . 'user-input-processing.php';
include $enginesdirectory . 'defaulturls.php';

//Define join to attach club variable
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

include $enginesdirectory . 'regatta-race-count.php';

echo '<div class="item">';
echo '<p style="font-size: 200%; text-align: center;">' . $regattaresults['Details']['Name'] . '</p>';

echo '<p>Browse results of a regatta by class, or show all results.</p>';

//Output each class
foreach($regattaresults['ClassesFound'] as $classfound)
  {
  $hyperlink = $defaulturls['RegattaResults'] . $ahrefjoin . "regatta=" . $regattaid;
  if ($classfound['JSV'] != '')
    $hyperlink = $hyperlink . "&jsv=" . $classfound['JSV'];
  if ($classfound['MW'] != '')
    $hyperlink = $hyperlink . "&mw=" . $classfound['MW'];
  if ($classfound['CK'] != '')
    $hyperlink = $hyperlink . "&ck=" . $classfound['CK'];
  if ($classfound['Abil'] != '')
    $hyperlink = $hyperlink . "&abil=" . $classfound['Abil'];
  if ($classfound['Spec'] != '')
    $hyperlink = $hyperlink . "&spec=" . $classfound['Spec'];
  if ($classfound['Ages'] != '')
    $hyperlink = $hyperlink . "&ages=" . $classfound['Ages'];
  if ($club != '')
    $hyperlink = $hyperlink . "&club=" . $club;
  if ($paddler != '')
    $hyperlink = $hyperlink . "&paddler=" . $paddler;

  echo '<p><a href="' . $hyperlink . '">' . $classfound['Text'] . "</a> - " . $classfound['RacesCount'] . "</p>";
  }
echo '</div>';
?>
