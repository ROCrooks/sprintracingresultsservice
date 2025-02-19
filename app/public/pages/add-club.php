<?php
include_once $engineslocation . 'srrs-required-functions.php';

if (isset($_POST['Submit']) == true)
    {
    //Get the input items from the club input form
    $clubaddfields['Code'] = $_POST['Code'];
    $clubaddfields['LongName'] = $_POST['LongName'];
    $clubaddfields['ShortName'] = $_POST['ShortName'];
    $clubaddfields['WWW'] = $_POST['WWW'];

    //Run the import engine
    include $engineslocation . 'add-club-db-engine.php';
    }
else
    {
    //Get the club code from the URL
    if (isset($_GET['code']) == true)
        $clubaddfields['Code'] = $_GET['code'];
    else
        $clubaddfields['Code'] = "";
    
    $clubaddfields['LongName'] = "";
    $clubaddfields['ShortName'] = "";
    $clubaddfields['WWW'] = "";
    }

//Specify form cell widths
$labelwidth = 130;
$formcellwidth = 630;

//Make the form for adding a new club
$pagehtml = '<form method="post" action="AddClub" enctype="multipart/form-data">';

//Make and display an error message
if (isset($addclubmessage) == true)
    $pagehtml = $pagehtml. $addclubmessage;

//Make the form for adding a club
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Code:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><input type="text" id="Code" name="Code" value= "' . $clubaddfields['Code'] . '" size="3"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Long Name:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><input type="text" name="LongName" value= "' . $clubaddfields['LongName'] . '" size="30"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Short Name:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><input type="text" name="ShortName" value= "' . $clubaddfields['ShortName'] . '" size="20"></p></div>';
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Website:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><input type="text" name="WWW" value= "' . $clubaddfields['WWW'] . '" size="30"></div>';
$pagehtml = $pagehtml . '</div>';
/*$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth . 'px;"><p>Colours:</p></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $formcellwidth . 'px;"><input type="file" name="ColoursFile" id="ColoursFile" accept="image/png"></div>';
$pagehtml = $pagehtml . '</div>';*/

//Submit buttons
$pagehtml = $pagehtml . '<div style="display: table;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $labelwidth+$formcellwidth . 'px;"><p><input type="submit" name="Submit" value="Submit"> <input type="reset" name="Reset" value="reset"></p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</form>';

$pagehtml = "<section>" . $pagehtml . "</section>";
?>