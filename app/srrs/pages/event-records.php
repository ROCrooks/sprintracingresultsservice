<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

//Create the records table for a MW/CK combination
function boattyperecords($allrecords,$mwckcode,$club)
  {
  $htmloutput = "";

  //Distances and boat sizes
  $recorddistances = array(200,500,1000,5000);
  $recordboatsizes = array(1,2,4);

  foreach ($recorddistances as $recorddistance)
    {
    foreach ($recordboatsizes as $recordboatsize)
      {
      $recordkey = $mwckcode . $recordboatsize . "-" . $recorddistance;
      if (isset($allrecords[$recordkey]) == true)
        {
        $record = $allrecords[$recordkey];

        $widths = array("Description"=>150,"Crew"=>250,"Club"=>80,"Time"=>100,"Regatta"=>120,"ViewRace"=>120);
        $totalwidth = array_sum($widths);

        //Split 4s races into 2 lines
        if ($recordboatsize == 4)
          {
          $record['Crew'] = explode("/",$record['Crew']);
          //Set unknown paddlers to ??????
          if (isset($record['Crew'][0]) == false)
            $record['Crew'][0] = "??????";
          if (isset($record['Crew'][1]) == false)
            $record['Crew'][1] = "??????";
          if (isset($record['Crew'][2]) == false)
            $record['Crew'][2] = "??????";
          if (isset($record['Crew'][3]) == false)
            $record['Crew'][3] = "??????";
          $record['Crew'] = $record['Crew'][0] . "/" . $record['Crew'][1] . "<br>" . $record['Crew'][2] . "/" . $record['Crew'][3];

          $record['Club'] = explode("/",$record['Club']);
          if (count($record['Club']) == 4)
            $record['Club'] = $record['Club'][0] . "/" . $record['Club'][1] . "<br>" . $record['Club'][2] . "/" . $record['Club'][3];
          else
            $record['Club'] = implode("/",$record['Club']);
          }

        //Create records table
        $htmloutput = $htmloutput . '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';
        $htmloutput = $htmloutput . '<div style="display: table-cell; width: ' . $widths['Description'] . 'px;"><p>' . $record['EventDescription'] . '</p></div>';
        $htmloutput = $htmloutput . '<div style="display: table-cell; width: ' . $widths['Crew'] . 'px;"><p>' . $record['Crew'] . '</p></div>';
        $htmloutput = $htmloutput . '<div style="display: table-cell; width: ' . $widths['Club'] . 'px;"><p>' . $record['Club'] . '</p></div>';
        $htmloutput = $htmloutput . '<div style="display: table-cell; width: ' . $widths['Time'] . 'px;"><p>' . $record['Time'] . '</p></div>';
        $htmloutput = $htmloutput . '<div style="display: table-cell; width: ' . $widths['Regatta'] . 'px;"><p><a href="ResultsLookup?regatta=' . $record['Regatta'];
        if ($club != '')
          $htmloutput = $htmloutput . '&club=' . $club;
        $htmloutput = $htmloutput . '">' . $record['MonthDate'] . '</a></p></div>';
        $htmloutput = $htmloutput . '<div style="display: table-cell; width: ' . $widths['ViewRace'] . 'px;"><p><a href="RaceView?race=' . $record['Race'];
        if ($club != '')
          $htmloutput = $htmloutput . '&club=' . $club;
        $htmloutput = $htmloutput . '">View Race</a></p></div>';
        $htmloutput = $htmloutput . '</div>';
        }
      }
    }

  Return $htmloutput;
  }

//Unset all of the unneccesary user inputs
unset($raceid);
unset($mw);
unset($ck);
unset($abil);
unset($spec);
unset($ages);
unset($regattaid);

include $engineslocation . 'regatta-records.php';

$pagehtml = '<section>';

//Mens Kayak
$recordshtml = boattyperecords($allrecords,"M-K",$club);
if ($recordshtml != "")
  {
  $pagehtml = $pagehtml . '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    $pagehtml = $pagehtml . "Junior ";
  if ($jsv == "V")
    $pagehtml = $pagehtml . "Masters ";
  $pagehtml = $pagehtml . 'Mens Kayak</p>';

  $pagehtml = $pagehtml . $recordshtml;
  }

//Womens Kayak
$recordshtml = boattyperecords($allrecords,"W-K",$club);
if ($recordshtml != "")
  {
  $pagehtml = $pagehtml . '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    $pagehtml = $pagehtml . "Junior ";
  if ($jsv == "V")
    $pagehtml = $pagehtml . "Masters ";
  $pagehtml = $pagehtml . 'Womens Kayak</p>';

  $pagehtml = $pagehtml . $recordshtml;
  }

//Mens Canoe
$recordshtml = boattyperecords($allrecords,"M-C",$club);
if ($recordshtml != "")
  {
  $pagehtml = $pagehtml . '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    $pagehtml = $pagehtml . "Junior ";
  if ($jsv == "V")
    $pagehtml = $pagehtml . "Masters ";
  $pagehtml = $pagehtml . 'Mens Canoe</p>';

  $pagehtml = $pagehtml . $recordshtml;
  }

//Womens Canoe
$recordshtml = boattyperecords($allrecords,"W-C",$club);
if ($recordshtml != "")
  {
  $pagehtml = $pagehtml . '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    $pagehtml = $pagehtml . "Junior ";
  if ($jsv == "V")
    $pagehtml = $pagehtml . "Masters ";
  $pagehtml = $pagehtml . 'Womens Canoe</p>';

  $pagehtml = $pagehtml . $recordshtml;
  }

$getallregattas = false;
include $engineslocation . 'list-years.php';

//Define the width of the cells where the links are held
$cellwidth = 150;
if($paddler == '')
  $totalwidth = $cellwidth*3;
else
  $totalwidth = $cellwidth;

//Make the base hyperlink for the records page
$basehyperlink = "EventRecords";
$baseconstraints = array();

if ($club != '')
  array_push($baseconstraints,"club=" . $club);
if ($paddler != '')
  array_push($baseconstraints,"paddler=" . $paddler);


$baseconstraintshyperlink = "?" . implode("&",$baseconstraints);
$basehyperlink = $basehyperlink . $baseconstraintshyperlink;

//The all time records
$pagehtml = $pagehtml . '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';
$hyperlink = $basehyperlink;
$pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">All Time Records</a></p></div>';

//The all time records if paddler isn't set
if ($paddler == '')
  {
  $hyperlink = $basehyperlink . "&jsv=J";
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">All Time Junior Records</a></p></div>';
  $hyperlink = $basehyperlink . "&jsv=V";
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">All Time Masters Records</a></p></div>';
  }

$pagehtml = $pagehtml . '</div>';

rsort($uniqueyears);

foreach($uniqueyears as $uniqueyear)
  {
  $yearhyperlink = $basehyperlink . "&year=" . $uniqueyear;
  //The all time records
  $pagehtml = $pagehtml . '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';
  $hyperlink = $yearhyperlink;
  $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">' . $uniqueyear . ' Records</a></p></div>';

  //The all time records if paddler isn't set
  if ($paddler == '')
    {
    $hyperlink = $yearhyperlink . "&jsv=J";
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">' . $uniqueyear . ' Junior Records</a></p></div>';
    $hyperlink = $yearhyperlink . "&jsv=V";
    $pagehtml = $pagehtml . '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">' . $uniqueyear . ' Masters Records</a></p></div>';
    }

  $pagehtml = $pagehtml . '</div>';
  }

$pagehtml = $pagehtml . '</section>';
?>
