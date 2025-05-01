<?php
if (isset($_GET['club']) == true)
    $clubcode = $_GET['club'];
else
    $clubcode = '';

//Run the update club engine if the submit button is pressed
if (isset($_POST['Submit']) == true)
    include $engineslocation . 'edit-club-engine.php';    

//Get the details of the club
$clubmetrics = false;
include $engineslocation . 'club-details-engine.php';

$pagehtml = "<section>";
$pagehtml = $pagehtml . '<div style="display: table; width: 100%; display: flex;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 30%; display: flex;"><img src="' . $clubfindresult['Colours'] . '" width="100%"></div>';

//Decide if the checkbox for approved URL is set
if ($clubfindresult['WWWapp'] == 1)
    $activecheckbox = '<input type="checkbox" name="WWWapp" value= "1" checked>';
elseif ($clubfindresult['WWWapp'] == 0)
    $activecheckbox = '<input type="checkbox" name="WWWapp" value= "1">';

//Specify form cell widths
$labelwidth = 130;
$formcellwidth = 630;

//Make the form for changing the club details
$pagehtml = $pagehtml . '<form enctype="multipart/form-data" id="ClubDetailsForm" method="post" action="EditClub?club=' . $clubfindresult['Code'] . '">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 70%;">';
if (isset($clubchangeformerrormessage) == true)
    {
    $pagehtml = $pagehtml . '<div style="display: table;">';
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth+$formcellwidth . 'px;">' . $clubchangeformerrormessage . '</div>';
    $pagehtml = $pagehtml . '</div>';
    }
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Code:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" id="Code" name="Code" value= "' . $clubfindresult['Code'] . '" size="3"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Long Name:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" name="LongName" value= "' . $clubfindresult['LongName'] . '" size="30"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Short Name:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" name="ShortName" value= "' . $clubfindresult['ShortName'] . '" size="20"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Website:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><p><input type="text" name="WWW" value= "' . $clubfindresult['WWW'] . '" size="30"> Active: ' . $activecheckbox .'</div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Colours:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><input type="file" name="ColoursFile" id="ColoursFile" accept="image/png"></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth+$formcellwidth . 'px;"><p><input type="submit" name="Submit" value="Submit"></p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</form>';

$pagehtml = $pagehtml . "</section>";
?>