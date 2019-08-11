<?php
include 'defaulturls.php';

//Define join to attach club variable
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

include 'engines/user-input-processing.php';

include 'engines/regatta-race-count.php';

echo '<div class="item">';
echo '<p style="font-size: 200%; text-align: center;">' . $regattaresults['Details']['Name'] . '</p>';

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
