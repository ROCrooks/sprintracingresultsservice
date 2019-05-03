<?php
//Process user inputs
include_once 'required-functions.php';

$jsv = "";
$mw = "";
$ck = "";
$club = "";

//Race IDs of singles, doubles and fours races
$boatsizesql = "SELECT `Key` FROM `races` WHERE `Boat` = ?";
$boatsizestmt = dbprepare($srrsdblink,$boatsizesql);
$singlesraceids = resulttocolumn(dbexecute($boatsizestmt,1));
$doublesraceids = resulttocolumn(dbexecute($boatsizestmt,2));
$foursraceids = resulttocolumn(dbexecute($boatsizestmt,4));

$distancesql = "SELECT `Key` FROM `races` WHERE `Dist` = ?";
$distancestmt = dbprepare($srrsdblink,$distancesql);
$race200ids = resulttocolumn(dbexecute($distancestmt,200));
$race500ids = resulttocolumn(dbexecute($distancestmt,500));
$race1000ids = resulttocolumn(dbexecute($distancestmt,1000));
$distancesql = "SELECT `Key` FROM `races` WHERE `Dist` > ?";
$raceldids = resulttocolumn(dbprepareandexecute($srrsdblink,$distancesql,1000));

$year = 2010;
$lookupby = "size";

//Get the regatta IDs for a particular year
include 'filter-year-regatta-ids.php';
$regattalist = $yearregattaids;
unset($yearregattaids);

//Get the race IDs from those regattas in that year
include 'filter-regatta-race-ids.php';
$regattaraceids;

$seatcounts = array();

$raceids = array($regattaraceids,$singlesraceids);
$raceids = arrayinall($raceids);
include 'count-paddlers.php';
$singlespaddlers = $paddlerscount;

$raceids = array($regattaraceids,$doublesraceids);
$raceids = arrayinall($raceids);
include 'count-paddlers.php';
$doublespaddlers = $paddlerscount*2;

$raceids = array($regattaraceids,$foursraceids);
$raceids = arrayinall($raceids);
include 'count-paddlers.php';
$fourspaddlers = $paddlerscount*4;

echo $singlespaddlers . "<br>";
echo $doublespaddlers . "<br>";
echo $fourspaddlers . "<br>";
?>
