<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

include $engineslocation . 'regatta-race-count.php';

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p style="font-size: 200%; text-align: center;">' . $regattaresults['Details']['Name'] . '</p>';

$pagehtml = $pagehtml . '<p>Browse results of a regatta by class, or show all results.</p>';

//Output each class
foreach($regattaresults['ClassesFound'] as $classfound)
  {
  $hyperlink = "RegattaResults?regatta=" . $regattaid;
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

  $pagehtml = $pagehtml . '<p><a href="' . $hyperlink . '">' . $classfound['Text'] . "</a> - " . $classfound['RacesCount'] . "</p>";
  }
$pagehtml = $pagehtml . '</section>';
?>
