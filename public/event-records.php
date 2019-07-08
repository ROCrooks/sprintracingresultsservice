<?php
//Create the records table for a MW/CK combination
function boattyperecords($allrecords,$mwckcode)
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

        $widths = array("Description"=>150,"Crew"=>250,"Club"=>80,"Time"=>100,"Regatta"=>120);
        $totalwidth = array_sum($widths);

        //Split 4s races into 2 lines
        if ($recordboatsize == 4)
          {
          $record['Crew'] = explode("/",$record['Crew']);
          $record['Crew'] = $record['Crew'][0] . "/" . $record['Crew'][1] . "<br>" . $record['Crew'][2] . "/" . $record['Crew'][3];

          $record['Club'] = explode("/",$record['Club']);
          if (count($record['Club']) == 4)
            $record['Club'] = $record['Club'][0] . "/" . $record['Club'][1] . "<br>" . $record['Club'][2] . "/" . $record['Club'][3];
          else
            $record['Club'] = implode("/",$record['Club']);
          }

        //Create records table
        $htmloutput = $htmloutput . '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Description'] . 'px;"><p><a href="?page=RaceView&race=' . $record['Race'] . '">' . $record['EventDescription'] . '</a></p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Crew'] . 'px;"><p>' . $record['Crew'] . '</p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Club'] . 'px;"><p>' . $record['Club'] . '</p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Time'] . 'px;"><p>' . $record['Time'] . '</p></div>';
        $htmloutput = $htmloutput .  '<div style="display: table-cell; width: ' . $widths['Regatta'] . 'px;"><p><a href="?page=Regatta&regatta=' . $record['Regatta'] . '">' . $record['MonthDate'] . '</a></p></div>';
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
$recordshtml = boattyperecords($allrecords,"M-K");
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
$recordshtml = boattyperecords($allrecords,"W-K");
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
$recordshtml = boattyperecords($allrecords,"M-C");
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
$recordshtml = boattyperecords($allrecords,"W-C");
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
?>
