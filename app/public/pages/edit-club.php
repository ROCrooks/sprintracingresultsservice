<?php
//Get the details of the club
include $engineslocation . 'club-details-engine.php';

print_r($clubfindresult);

$pagehtml = "<section>";
$pagehtml = $pagehtml . '<div style="display: table; width: 100%; display: flex;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 30%; display: flex;"><img src="' . $clubfindresult['Colours'] . '" width="100%"></div>';


//Specify form cell widths
$labelwidth = 130;
$formcellwidth = 330;
//Make the form for changing the club details

$pagehtml = $pagehtml . '<div style="display: table-cell; width: 70%;">';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Code:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" name="Code" value= "' . $clubfindresult['Code'] . '" size="3"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Long Name:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" name="LongName" value= "' . $clubfindresult['LongName'] . '" size="30"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Short Name:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" name="LongName" value= "' . $clubfindresult['ShortName'] . '" size="20"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Website:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" name="WWW" value= "' . $clubfindresult['WWW'] . '" size="30"> Active: <input type="checkbox" name="WWWapp" value= "' . $clubfindresult['WWWapp'] . '"></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . "</section>";
?>