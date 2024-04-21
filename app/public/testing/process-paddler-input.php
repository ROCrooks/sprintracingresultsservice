<?php
include 'common-testing-files.php';
include $engineslocation . 'race-reading-regexs.php';

$allpaddlerdetails = array();
$racedetails['defJSV'] = "S";
$racedetails['defMW'] = "M";
$racedetails['defCK'] = "K";

//Test data
$singleracelines = array();
$singleracelines[0] = "3 4 NOR S Cook 3:23.87";
$singleracelines[1] = "4 NOR S Cook 3:23.87";
$singleracelines[2] = "4 S Cook 3:23.87";
$singleracelines[3] = "4 NOR S Cook DNS";
$singleracelines[4] = "4 S Cook DNS";
$singleracelines[5] = "S Cook DNS";
$singleracelines[6] = "4 NOR S Cook ???";
$singleracelines[7] = "4 S Cook ???";
$singleracelines[8] = "S Cook ???";
$singleracelines[9] = "4 NOR S Cook DNF";
$singleracelines[10] = "4 S Cook DNF";
$singleracelines[11] = "S Cook DNF";
$singleracelines[12] = "4 NOR S Cook DSQ";
$singleracelines[13] = "4 S Cook DSQ";
$singleracelines[14] = "S Cook DSQ";


$doubleracelines[1] = "3 4 NOR S Cook/T THOMPSON 3:23.87";
$doubleracelines[2] = "3 NOR S Cook/T THOMPSON 3:23.87";
$doubleracelines[2] = "NOR S Cook/T THOMPSON 3:23.87";
$doubleracelines[3] = "3 4 NOR S Cook/T THOMPSON(MAI) 3:23.87";
$doubleracelines[4] = "3 NOR S Cook/T THOMPSON(MAI) 3:23.87";
$doubleracelines[4] = "NOR S Cook/T THOMPSON(MAI) 3:23.87";
$doubleracelines[5] = "3 4 NOR/MAI S Cook/T THOMPSON 3:23.87";
$doubleracelines[6] = "3 NOR/MAI S Cook/T THOMPSON 3:23.87";
$doubleracelines[7] = "NOR/MAI S Cook/T THOMPSON 3:23.87";
$doubleracelines[8] = "3 NOR S Cook/T THOMPSON(MAI) ???";
$doubleracelines[9] = "3 NOR S Cook/T THOMPSON(MAI) DNF";
$doubleracelines[10] = "3 NOR S Cook/T THOMPSON(MAI) DNS";
$doubleracelines[11] = "3 NOR S Cook/T THOMPSON(MAI) DSQ";


$racedetails['Boat'] = 1;
foreach ($singleracelines as $raceline)
    {
    echo $raceline . "<br>";

    include $engineslocation . 'process-paddler-input.php';

    print_r($paddlerdetails);
    echo "<br>";
    }

$racedetails['Boat'] = 2;
foreach ($doubleracelines as $raceline)
    {
    echo $raceline . "<br>";

    include $engineslocation . 'process-paddler-input.php';

    print_r($paddlerdetails);
    echo "<br>";
    }
?>