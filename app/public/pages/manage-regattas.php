<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

//Hide or delete a regatta
if (isset($_GET['action']) == true)
  {
  $action = $_GET['action'];
  $doregatta = $_GET['regatta'];

  //Delete a specified regatta
  if ($action == "delete")
    {
    include $engineslocation . 'delete-regatta.php';
    $actionmessage = "<p>Regatta Deleted!</p>";
    }
  //Delete a specified regatta
  if (($action == "hide") OR ($action == "release"))
    {
    include $engineslocation . 'releasehide-regatta.php';

    if ($action == "hide")
      $actionmessage = "<p>Regatta Hidden!</p>";
    elseif ($action == "release")
      $actionmessage = "<p>Regatta Released!</p>";
    }
  }

//Club and paddler are null when retrieving regattas
$club = '';
$paddler = '';
$getallregattas = true;

include $engineslocation . 'list-regattas.php';

usort($allregattaslist,'sortregattas');

//Widths of cells in the table
$boxheight = 50;
$widths = array();
$widths['Name'] = 400;
$widths['Date'] = 100;
$widths['Apend'] = 50;
$widths['Delete'] = 50;
$widths['HideRelease'] = 50;
$totalwidth = array_sum($widths);

//Hyperlinks for management pages
$manageregattahyperlink = "EditRegatta?regatta=";
$apendraceshyperlink = "AddRegatta?regatta=";
$deleteregattahyperlink = "ManageRegattas?action=delete&regatta=";
$hidehyperlink = "ManageRegattas?action=hide&regatta=";
$releasehyperlink = "ManageRegattas?action=release&regatta=";

$pagehtml = "";

if (isset($actionmessage) == true)
  {
  $pagehtml = $pagehtml . '<section>';
  $pagehtml = $pagehtml . $actionmessage;
  $pagehtml = $pagehtml . '</section>';
  }

$pagehtml = $pagehtml . '<section>';

$pagehtml = $pagehtml . '<form action="EditRegatta" method="post">';
$pagehtml = $pagehtml . '<p>Go directly to race: <input type="text" name="race" value="" size="5"> <input type="submit" name="submit" value="Go"></p>';
$pagehtml = $pagehtml . '</form>';

$pagehtml = $pagehtml . '<p><a href="AddRegatta">Add Regatta</a></p>';
$pagehtml = $pagehtml . '<p><a href="ManageClasses">Manage Classes</a></p>';

$pagehtml = $pagehtml . '</section>';

$pagehtml = $pagehtml . '<section>';

//Make list of regattas
$pagehtml = $pagehtml . '<div style="display: table; width: ' . $totalwidth . ';">';
foreach ($allregattaslist as $regattadetails)
  {
  //Make the row with the regatta details
  $pagehtml = $pagehtml . '<div style="display: table-row; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;">';
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Name'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $manageregattahyperlink . $regattadetails['Key'] . '">' . $regattadetails['Name'] . '</a></p></div>';
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Date'] . 'px; height: ' . $boxheight . 'px;"><p>' . $regattadetails['Date'] . '</p></div>';
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Apend'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $apendraceshyperlink . $regattadetails['Key'] . '">Apend Races</a></p></div>';
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['Delete'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $deleteregattahyperlink . $regattadetails['Key'] . '" onclick="return confirm(\'This will delete the regatta. Are you sure you want to continue?\')">Delete Regatta</a></p></div>';
  //Toggle hide and release for set and unset regatta
  if ($regattadetails['Hide'] == 0)
    {
    $hiderelease = "Hide Regatta";
    $hidereleasehyperlink = $hidehyperlink;
    }
  elseif ($regattadetails['Hide'] == 1)
    {
    $hiderelease = "Release Regatta";
    $hidereleasehyperlink = $releasehyperlink;
    }
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $widths['HideRelease'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $hidereleasehyperlink . $regattadetails['Key'] . '">' . $hiderelease . '</a></p></div>';
  $pagehtml = $pagehtml . '</div>';
  }
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . '</section>';
?>
