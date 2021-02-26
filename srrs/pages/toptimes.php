<?php
//Get the directory of the engines
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$enginesdirectory = str_replace($removedirs,"",$currentdirectory);
$enginesdirectory = $enginesdirectory . "/srrs/engines/";

include $enginesdirectory . 'user-input-processing.php';
include $enginesdirectory . 'defaulturls.php';

//Define join to attach URL variables
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

//Get input parameters from user
$dist = $_GET['dist'];
$boat = $_GET['boat'];
$tofind = $_GET['find'];

//Get the data
include $enginesdirectory . 'find-top-n.php';

//Lookup month names
//There might be a function that does this already
$months = array();
$months['01'] = "January";
$months['02'] = "February";
$months['03'] = "March";
$months['04'] = "April";
$months['05'] = "May";
$months['06'] = "June";
$months['07'] = "July";
$months['08'] = "August";
$months['09'] = "September";
$months['10'] = "October";
$months['11'] = "November";
$months['12'] = "December";

//Parameters for div table
$columnwidths = array();
$columnwidths['Position'] = 40;
$columnwidths['Crew'] = 250;
$columnwidths['Club'] = 80;
$columnwidths['Time'] = 60;
$columnwidths['Date'] = 140;
$columnwidths['ViewRace'] = 100;
$columnwidths['ViewRegatta'] = 100;
$totalwidth = array_sum($columnwidths);

//Define the name of the event
if ($mw == "M")
  $eventname = "Mens";
elseif ($mw == "W")
  $eventname = "Womens";

$eventname = $eventname . " " . $ck . $boat . " " . $dist . "m";

//Define if it is for a year or all time
if ($year != '')
  $rangetext = 'by seasons best in the ' . $year . ' season';
else
  $rangetext = 'by all time personal best';

if ($club != '')
  $clubtext = 'from ' . $club;
else
  $clubtext = '';

//Make the HTML for the output table
$besttimeshtml = '<div style="display: table; margin: auto; width: ' . $totalwidth . 'px;">';

foreach($topnresults as $resultkey=>$result)
  {
  //Define position based on the array key
  $position = $resultkey+1;

  //Split into 2 lines if it is a K4/C4
  if ($boat == 4)
    {
    $result['Crew'] = explode("/",$result['Crew']);
    $result['Crew'] = $result['Crew'][0] . "/" . $result['Crew'][1] . "<br>" . $result['Crew'][2] . "/" . $result['Crew'][3];

    if (strlen($result['Club']) == 15)
      {
      $result['Club'] = explode("/",$result['Club']);
      $result['Club'] = $result['Club'][0] . "/" . $result['Club'][1] . "<br>" . $result['Club'][2] . "/" . $result['Club'][3];
      }
    }

  //Convert seconds time to display time
  $result['Time'] = secstohms($result['Time']);

  //Convert date into Month and Year
  $result['Date'] = explode("-",$result['Date']);

  if (count($result['Date']) == 3)
    {
    $month = $result['Date'][1];
    $month = $months[$month];
    $result['Date'] = $month . " " . $result['Date'][0];
    }
  else
    //If cannot generate date correctly, return unknown
    $result['Date'] = "Unknown";

  //Generate URLs to go to regatta and race
  $raceurl = $defaulturls['RaceResults'] . $ahrefjoin . 'race=' . $result['Race'];
  $regattaurl = $defaulturls['RegattaResults'] . $ahrefjoin . 'regatta=' . $result['Regatta'];

  //Apend club to URL
  if ($club != '')
    {
    $raceurl = $raceurl . '&club=' . $club;
    $regattaurl = $regattaurl . '&club=' . $club;
    }

  $racehtmllink = '<a href="' . $raceurl . '">View Race</a>';
  $regattahtmllink = '<a href="' . $regattaurl . '">View Regatta</a>';

  $besttimeshtml = $besttimeshtml . '<div style="display: table-row; margin: auto; width: ' . $totalwidth . 'px;">';
  $besttimeshtml = $besttimeshtml . '<div style="display: table-cell; width: ' . $columnwidths['Position'] . 'px;"><p>' . $position . '</p></div>';
  $besttimeshtml = $besttimeshtml . '<div style="display: table-cell; width: ' . $columnwidths['Crew'] . 'px;"><p>' . $result['Crew'] . '</p></div>';
  $besttimeshtml = $besttimeshtml . '<div style="display: table-cell; width: ' . $columnwidths['Club'] . 'px;"><p>' . $result['Club'] . '</p></div>';
  $besttimeshtml = $besttimeshtml . '<div style="display: table-cell; width: ' . $columnwidths['Time'] . 'px;"><p>' . $result['Time'] . '</p></div>';
  $besttimeshtml = $besttimeshtml . '<div style="display: table-cell; width: ' . $columnwidths['Date'] . 'px;"><p>' . $result['Date'] . '</p></div>';
  $besttimeshtml = $besttimeshtml . '<div style="display: table-cell; width: ' . $columnwidths['ViewRace'] . 'px;"><p>' . $racehtmllink . '</p></div>';
  $besttimeshtml = $besttimeshtml . '<div style="display: table-cell; width: ' . $columnwidths['ViewRegatta'] . 'px;"><p>' . $regattahtmllink . '</p></div>';
  $besttimeshtml = $besttimeshtml . '</div>';
  }

$besttimeshtml = $besttimeshtml . '</div>';

//Make the links to change the number of
$originaltofindtext = "&find=" . $tofind;
//Get the current URL
$currenturl = $defaulturls['TopNTimes'] . $ahrefjoin . 'mw=' . $mw . '&ck=' . $ck . '&boat=' . $boat . '&find=' . $tofind . '&dist=' . $dist;

$numbers = array(5,10,20,50,100,250);

$newlinkshtml = array();

foreach ($numbers as $number)
  {
  $replacetext = "&find=" . $number;
  $newurl = str_replace($originaltofindtext,$replacetext,$currenturl);

  //Make the text and hyperlink if needed
  $urlhtml = "Top " . $number;
  if ($newurl != $currenturl)
    $urlhtml = '<a href="' . $newurl . '">' . $urlhtml . '</a>';

  array_push($newlinkshtml,$urlhtml);
  }

$newlinkshtml = '<div class="item"><p class="blockheading">Change Ranking Size</p><p>' . implode(" | ",$newlinkshtml) . '</p></div>';
echo $newlinkshtml;
?>

<div class="item">
<p>All Time Rankings</p>

<p>Ranking of top <?php echo $tofind; ?> paddlers <?php echo $clubtext; ?> in <?php echo $eventname; ?> <?php echo $rangetext; ?>.</p>

<?php echo $besttimeshtml; ?>
