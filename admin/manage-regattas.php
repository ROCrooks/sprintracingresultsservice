<?php
//Hide or delete a regatta
if (isset($_GET['action']) == true)
  {
  $action = $_GET['action'];
  $doregatta = $_GET['regatta'];

  //Delete a specified regatta
  if ($action == "delete")
    {
    $deleteregatta = $doregatta;
    include 'engines/delete-regatta.php';
    $actionmessage = "<p>Regatta Deleted!</p>";
    }
  }
else
  $actionmessage = "";

//Club and paddler are null when retrieving regattas
$club = '';
$paddler = '';
$getallregattas = true;

include '../public/engines/list-regattas.php';

include 'defaulturls.php';

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
$manageregattahyperlink = "edit-regatta.php?regatta=";
$apendraceshyperlink = $defaulturls['AddRegatta'] . $ahrefjoin . "regatta=";
$deleteregattahyperlink = $defaulturls['ManageRegattas'] . $ahrefjoin . "action=delete&regatta=";
$hidehyperlink = $defaulturls['ManageRegattas'] . $ahrefjoin . "action=hide&regatta=";
$releasehyperlink = $defaulturls['ManageRegattas'] . $ahrefjoin . "action=release&regatta=";

echo $actionmessage;

//Make list of regattas
foreach ($allregattaslist as $regattadetails)
  {
  //Make the row with the regatta details
  echo '<div style="display: table; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;">';
  echo '<div style="display: table-cell; width: ' . $widths['Name'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $manageregattahyperlink . $regattadetails['Key'] . '">' . $regattadetails['Name'] . '</a></p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Date'] . 'px; height: ' . $boxheight . 'px;"><p>' . $regattadetails['Date'] . '</p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Apend'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $apendraceshyperlink . $regattadetails['Key'] . '">Apend Races</a></p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Delete'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $deleteregattahyperlink . $regattadetails['Key'] . '" onclick="return confirm(\'This will delete the regatta. Are you sure you want to continue?\')">Delete Regatta</a></p></div>';
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
  echo '<div style="display: table-cell; width: ' . $widths['HideRelease'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $hidereleasehyperlink . $regattadetails['Key'] . '">' . $hiderelease . '</a></p></div>';
  echo '</div>';
  }
?>
