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
//$club = "LBZ";

//Container for the description of the race classes being retrieved
$classname = array();

//Specify if JSV in text
if (isset($jsv) == true)
  {
  if($jsv != '')
    {
    if ($jsv == "J")
      array_push($classname,"junior");
    elseif ($jsv == "S")
      array_push($classname,"senior");
    elseif ($jsv == "V")
      array_push($classname,"veteran");
    }
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

//Year range
$yearrange = "between " . $startyear . " and " . $endyear;
array_push($classname,$yearrange);

//Attach club to class name
if (isset($club) == true)
  {
  if ($club != '')
    {
    $clubtext = "from " . $club;
    array_push($classname,$clubtext);
    }
  }

//Make classname as text
$classname = implode(" ",$classname);

//Get event metrics
include 'engines/get-event-time-metrics-year.php';

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

//Create HTML for scientific table
$number = 1;
$caption = "Entries and finishers metrics for " . $classname . ". Total number of
entries and finishers, with breakdown of non-finishers into did not start (DNS),
did not finish (DNF), disqualified (DSQ), timing error (ERR), or unknown no time
listed (???).";
$finishersmetricstablehtml = scientifictable($finishersmetricstable,$number,$caption);

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
$caption = "Time metrics for " . $classname . ". Showing the fastest times in the
calendar year, along with the times which 5%, 10%, 25%, 50%, 75% and 100% of
results are within, the mean (and standard deviation) time in the event, the
range between the fastest and slowest times.";
$timesmetricstablehtml = scientifictable($timesmetricstable,$number,$caption);
?>
<div class="item">
<p>Event analytics for <?php echo $classname; ?>.</p>

<?php echo $finishersmetricstablehtml; ?>

<?php echo $timesmetricstablehtml; ?>

</div>
