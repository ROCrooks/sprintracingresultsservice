<?php
include $engineslocation . 'srrs-required-functions.php';
include $engineslocation . 'srrs-user-input-processing.php';

$getallregattas = false;
include $engineslocation . 'list-regattas.php';

usort($allregattaslist,'sortregattas');

$namesection = 400;
$datesection = 100;
$boxheight = 50;
$totalwidth = $namesection+$datesection;

$js = "";

//Make the appropriate hyperlinks
$hyperlink1 = $defaulturls['RegattaLookup'] . $ahrefjoin . "regatta=";
$hyperlink2 = "";
if ($club != '')
  $hyperlink2 = $hyperlink2 . "&club=" . $club;
if ($paddler != '')
  $hyperlink2 = $hyperlink2 . "&paddler=" . $paddler;

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p>Browse the regattas stored in SRRS. Click on a year to expand the list of regattas in that year.</p>';

//Display all regatta details
$startyear = "NULL";
foreach ($allregattaslist as $regattadetails)
  {
  //Make the year beginning
  if ($regattadetails['Year'] != $startyear)
    {
    if ($startyear != "NULL")
      $pagehtml = $pagehtml . '</div>';

    $startyear = $regattadetails['Year'];
    $pagehtml = $pagehtml . '<div style="border-style: solid; border-color: #000000; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;" onclick="show' . $startyear . '()">' . $regattadetails['Year'] . '</div>';
    //Make section that toggles between visible and invisible
    $pagehtml = $pagehtml . '<div id="' . $startyear . 'races" style="display: none;">';
    $js = $js . 'function show' . $startyear . '()
      {
      var raceblock = document.getElementById("' . $startyear . 'races");
      if (raceblock.style.display === "none")
        {
        raceblock.style.display = "block";
        }
      else
        {
        raceblock.style.display = "none";
        }
      }';
    }

  //Make the row with the regatta details
  $pagehtml = $pagehtml . '<div style="display: table; width: ' . $totalwidth . 'px; height: ' . $boxheight . 'px;">';
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $namesection . 'px; height: ' . $boxheight . 'px;"><p><a href="' . $hyperlink1 . $regattadetails['Key'] . $hyperlink2 . '">' . $regattadetails['Name'] . '</a></p></div>';
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $datesection . 'px; height: ' . $boxheight . 'px;"><p>' . $regattadetails['Date'] . '</p></div>';
  $pagehtml = $pagehtml . '</div>';
  }
$pagehtml = $pagehtml . '</div>';
$pagehtml = $pagehtml . '</section>';

//Echo the Javascript
$pagehtml = $pagehtml . '<script>';
$pagehtml = $pagehtml . $js;
$pagehtml = $pagehtml . '</script>';
?>
