<?php
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
$hidereleasehyperlink = $defaulturls['ManageRegattas'] . $ahrefjoin . "action=hide&regatta=";

foreach ($allregattaslist as $regattadetails)
  {
  $regattadetails['Set'] = 0;

  //Make the row with the regatta details
  echo '<div style="display: table; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;">';
  echo '<div style="display: table-cell; width: ' . $widths['Name'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $manageregattahyperlink . $regattadetails['Key'] . '">' . $regattadetails['Name'] . '</a></p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Date'] . 'px; height: ' . $boxheight . 'px;"><p>' . $regattadetails['Date'] . '</p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Apend'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $apendraceshyperlink . $regattadetails['Key'] . '">Apend Races</a></p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Delete'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $deleteregattahyperlink . $regattadetails['Key'] . '" onclick="return confirm(\'This will delete the regatta. Are you sure you want to continue?\')">Delete Regatta</a></p></div>';
  //Toggle hide and release for set and unset regatta
  if ($regattadetails['Set'] == 1)
    $hiderelease = "Hide Regatta";
  elseif ($regattadetails['Set'] == 0)
    $hiderelease = "Release Regatta";
  echo '<div style="display: table-cell; width: ' . $widths['HideRelease'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $hidereleasehyperlink . $regattadetails['Key'] . '">' . $hiderelease . '</a></p></div>';
  echo '</div>';
  }
?>
