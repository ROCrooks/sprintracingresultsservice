<?php
include 'defaulturls.php';

//Define join to attach club variable
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

//Create the records table for a MW/CK combination
function boattyperecords($allrecords,$mwckcode,$defaulturls,$ahrefjoin)
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
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Description'] . 'px;"><p>' . $record['EventDescription'] . '</p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Crew'] . 'px;"><p>' . $record['Crew'] . '</p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Club'] . 'px;"><p>' . $record['Club'] . '</p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Time'] . 'px;"><p>' . $record['Time'] . '</p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Regatta'] . 'px;"><p><a href="' . $defaulturls['RegattaLookup'] . $ahrefjoin . 'regatta=' . $record['Regatta'] . '">' . $record['MonthDate'] . '</a></p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['ViewRace'] . 'px;"><p><a href="' . $defaulturls['RaceResults'] . $ahrefjoin . 'race=' . $record['Race'] . '">View Race</a></p></div>';
        $htmloutput = $htmloutput .  '</div>';
        }
      }
    }

  Return $htmloutput;
  }

//Get user inputs
include 'engines/user-input-processing.php';
//Unset all of the unneccesary user inputs
unset($raceid);
unset($mw);
unset($ck);
unset($abil);
unset($spec);
unset($ages);
unset($regattaid);

include 'engines/regatta-records.php';

//Mens Kayak
$recordshtml = boattyperecords($allrecords,"M-K",$defaulturls,$ahrefjoin);
if ($recordshtml != "")
  {
  echo '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    echo "Junior ";
  if ($jsv == "V")
    echo "Veteran ";
  echo 'Mens Kayak</p>';

  echo $recordshtml;
  }

//Womens Kayak
$recordshtml = boattyperecords($allrecords,"W-K",$defaulturls,$ahrefjoin);
if ($recordshtml != "")
  {
  echo '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    echo "Junior ";
  if ($jsv == "V")
    echo "Veteran ";
  echo 'Womens Kayak</p>';

  echo $recordshtml;
  }

//Mens Canoe
$recordshtml = boattyperecords($allrecords,"M-C",$defaulturls,$ahrefjoin);
if ($recordshtml != "")
  {
  echo '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    echo "Junior ";
  if ($jsv == "V")
    echo "Veteran ";
  echo 'Mens Canoe</p>';

  echo $recordshtml;
  }

//Womens Canoe
$recordshtml = boattyperecords($allrecords,"W-C",$defaulturls,$ahrefjoin);
if ($recordshtml != "")
  {
  echo '<p style="font-size: 150%; text-align: center;">';
  if ($jsv == "J")
    echo "Junior ";
  if ($jsv == "V")
    echo "Veteran ";
  echo 'Womens Canoe</p>';

  echo $recordshtml;
  }

$getallregattas = false;
include 'engines/list-years.php';

//Define the width of the cells where the links are held
$cellwidth = 150;
if($paddler == '')
  $totalwidth = $cellwidth*3;

//Make the base hyperlink for the records page
$basehyperlink = $defaulturls['EventRecords'];
$baseconstraints = array();

if ($club != '')
  array_push($baseconstraints,"club=" . $club);
if ($paddler != '')
  array_push($baseconstraints,"paddler=" . $club);


$baseconstraintshyperlink = $ahrefjoin . implode("&",$baseconstraints);
$basehyperlink = $basehyperlink . $baseconstraintshyperlink;

//The all time records
echo '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';
$hyperlink = $basehyperlink;
echo '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">All Time Records</a></p></div>';

//The all time records if paddler isn't set
if ($paddler == '')
  {
  $hyperlink = $basehyperlink . "&jsv=J";
  echo '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">All Time Junior Records</a></p></div>';
  $hyperlink = $basehyperlink . "&jsv=V";
  echo '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">All Time Masters Records</a></p></div>';
  }

echo '</div>';

rsort($uniqueyears);

foreach($uniqueyears as $uniqueyear)
  {
  $yearhyperlink = $basehyperlink . "&year=" . $uniqueyear;
  //The all time records
  echo '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';
  $hyperlink = $yearhyperlink;
  echo '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">' . $uniqueyear . ' Records</a></p></div>';

  //The all time records if paddler isn't set
  if ($paddler == '')
    {
    $hyperlink = $yearhyperlink . "&jsv=J";
    echo '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">' . $uniqueyear . ' Junior Records</a></p></div>';
    $hyperlink = $yearhyperlink . "&jsv=V";
    echo '<div style="display: table-cell; width: ' . $cellwidth . 'px;"><p><a href="' . $hyperlink . '">' . $uniqueyear . ' Masters Records</a></p></div>';
    }

  echo '</div>';
  }
?>
