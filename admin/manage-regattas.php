<?php
//Club and paddler are null when retrieving regattas
$club = '';
$paddler = '';
$getallregattas = true;
include '../public/engines/list-regattas.php';

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
$apendraceshyperlink = "add-regatta.php?regatta=";
$deleteregattahyperlink = "manage-regattas.php?regatta=";
$hidereleasehyperlink = "manage-regattas.php?regatta=";

foreach ($allregattaslist as $regattadetails)
  {
  $regattadetails['Set'] = 0;

  //Make the row with the regatta details
  echo '<div style="display: table; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;">';
  echo '<div style="display: table-cell; width: ' . $widths['Name'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $manageregattahyperlink . $regattadetails['Key'] . '">' . $regattadetails['Name'] . '</a></p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Date'] . 'px; height: ' . $boxheight . 'px;"><p>' . $regattadetails['Date'] . '</p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Apend'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $apendraceshyperlink . $regattadetails['Key'] . '">Apend Races</a></p></div>';
  echo '<div style="display: table-cell; width: ' . $widths['Delete'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $deleteregattahyperlink . $regattadetails['Key'] . '">Delete Regatta</a></p></div>';
  if ($regattadetails['Set'] == 1)
    $hiderelease = "Hide Regatta";
  elseif ($regattadetails['Set'] == 0)
    $hiderelease = "Release Regatta";
  echo '<div style="display: table-cell; width: ' . $widths['HideRelease'] . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $hidereleasehyperlink . $regattadetails['Key'] . '">' . $hiderelease . '</a></p></div>';
  echo '</div>';
  }
?>
