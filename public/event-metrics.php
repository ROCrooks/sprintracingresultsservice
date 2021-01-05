<?php
//Start and end years
$startyear = 2006;
$endyear = 2019;

//Event to search for
$mw = "M";
$ck = "K";
$dist = 500;
$boat = 1;
//$jsv = "J";
//$year = 2014;
//$club = "LBZ";

$classname = array();

//Specify if JSV in text
if (isset($jsv) == true)
  {
  if ($jsv == "J")
    array_push($classname,"junior");
  elseif ($jsv == "S")
    array_push($classname,"senior");
  elseif ($jsv == "V")
    array_push($classname,"veteran");
  }

//Male or female in text
if ($mw == "M")
  array_push($classname,"men's");
elseif ($mw == "W")
  array_push($classname,"women's");

//Boat type in text
$boattype = $ck . $boat;
array_push($classname,$boattype);

//Distance in text
$distancetext = $dist . "m";
array_push($classname,$distancetext);





//Get event metrics
include 'engines/get-event-time-metrics-year.php';

print_r($eventmetrics);

//Parameters to format metrics table
$metricsparams = array(
"NumberedRows"=>false,
"Headings"=>true,
"FirstRow"=>false);

//Fields and corresponding headings for finishers table
$finishersmetricsfields = array("Year","Entries","DNS","DNF","DSQ","ERR","???","Finishers");
$finishersmetricsheadings = array("Year","Entries","DNS","DNF","DSQ","ERR","???","Finishers");
$finishersmetricstable = arraytotable($eventmetrics,$finishersmetricsfields,$metricsparams,$finishersmetricsheadings);

//Fields and corresponding headings for finishers table
$timesmetricsfields = array("Year","TopD","5%D","10%D","25%D","50%D","75%D","100%D","MeanD","StDevD","RangeD");
$timesmetricsheadings = array("Year","Fastest","5%","10%","25%","50%","75%","100%","Mean Time","StDev","Range");
$timesmetricstable = arraytotable($eventmetrics,$timesmetricsfields,$metricsparams,$timesmetricsheadings);

echo "<p>Finishers Table Array</p>";

//print_r($finishersmetricstable);

$number = 1;
$caption = "";
$finishersmetricstablehtml = scientifictable($finishersmetricstable);

echo $finishersmetricstablehtml;

echo "<p>Times Table Array</p>";

//Edit the Mead and SD to be one cell
foreach($timesmetricstable as $rowkey=>$editingrow)
  {
  //Merge the mean and SD into one cell
  if ($editingrow[8] != "Mean Time")
    $editingrow[8] = $editingrow[8] . " &plusmn; " . $editingrow[9];

  //Remove the SD cell
  unset($editingrow[9]);

  //Amend the row in the array
  $timesmetricstable[$rowkey]=$editingrow;
  }

$number = 2;
$caption = "";
$timesmetricstablehtml = scientifictable($timesmetricstable);

echo $timesmetricstablehtml;
?>
