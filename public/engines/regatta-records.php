<?php
include_once 'required-functions.php';

if (isset($year) == false)
  $year = "";

if (isset($club) == false)
  $club = "";
if (isset($paddler) == false)
  $paddler = "";

//Get the IDs of each boat size and distance
$finddistances = array(200,500,1000,5000);
$selectas = "Individual";
include 'filter-distance-race-ids.php';
$findsizes = array(1,2,4);
include 'filter-size-race-ids.php';

//Restrict only to a single season
$baseinterestraces = array();
if ($year != "")
  {
  include 'filter-year-regatta-ids.php';
  $regattalist = $yearregattaids;
  include 'filter-regatta-race-ids.php';
  array_push($baseinterestraces,$regattaraceids);
  }

//Non distance or boatsize dividers
if (isset($padmw) == true)
  $lookupmw = strsplit($padmw);
else
  $lookupmw = array("M","W");
if (isset($padck) == true)
  $lookupmw = strsplit($padck);
else
  $lookupck = array("C","K");

$basefindrecordsql = "SELECT `Race`, `Club`, `Crew`, `Time` FROM `paddlers` WHERE `NR` = '' AND ";
$basesqlconstraints = array();
//Add a limitation by club
if ($club != "")
  {
  //Process multiple clubs if a paddler name is specified
  if ($paddler != "")
    {
    //Allow multiple clubs if a paddler is being searched for
    $clubs = explode(",",$club);
    $clubssqltext = array_fill(0,count($clubs),"`Club` LIKE ?");
    $basefindrecordsql = $basefindrecordsql . "(" . implode(" OR ",$clubssqltext) . ") AND ";
    //Add wildcards to clubs
    foreach ($clubs as $clubkey=>$clubitem)
      {
      $clubs[$clubkey] = "%" . $clubitem . "%";
      }

    $basesqlconstraints = array_merge($basesqlconstraints,$clubs);
    }
  else
    {
    $basefindrecordsql = $basefindrecordsql . "`Club` = ? AND ";
    array_push($basesqlconstraints,$club);
    }
  }

if ($paddler != "")
  {
  //Add paddler constraint
  $paddlerconstraintsql = array_fill(0,4,"`Crew` LIKE ?");
  $paddlerconstraintsql = "(" . implode(" OR ",$paddlerconstraintsql) . ") AND ";
  $basefindrecordsql = $basefindrecordsql . $paddlerconstraintsql;

  //Make names as constraint values
  $surname = substr($paddler,3);
  $names = array();
  $names[0] = "%" . $paddler . "%";
  $names[1] = "%/" . $surname . "/%";
  $names[2] = $surname . "/%";
  $names[3] = "%/" . $surname;
  $basesqlconstraints = array_merge($basesqlconstraints,$names);
  }

//Add age limitation
if (isset($jsv) == true)
  {
  $basefindrecordsql = $basefindrecordsql . "`JSV` = ? AND ";
  array_push($basesqlconstraints,$jsv);
  }

//Containers used to store data to prevent repeated database queries
$regattadetailsrace = array();
$regattadetailsregatta = array();

//Get regatta details statements
$allrecords = array();
$getregattasql = "SELECT `Regatta` FROM `races` WHERE `Key` = ?";
$getregattastmt = dbprepare($srrsdblink,$getregattasql);
$getregattadetailssql = "SELECT `Days`, `Date` FROM `regattas` WHERE `Key` = ?";
$getregattadetailsstmt = dbprepare($srrsdblink,$getregattadetailssql);

//Cycle through each distance and boat size
foreach ($distanceraceids as $distance=>$specificdistanceraceids)
  {
  foreach ($sizeraceids as $size=>$specificsizeraceids)
    {
    $interestraces = $baseinterestraces;
    array_push($interestraces,$specificsizeraceids);
    array_push($interestraces,$specificdistanceraceids);
    $interestraces = arrayinall($interestraces);

    //Add races to base SQL query and make placeholders for MW and CK
    $raceconstraints = makesqlrange($interestraces,"Race");
    $findrecordsql = $basefindrecordsql . $raceconstraints['SQLText'] . " AND `MW` = ? AND `CK` = ? ORDER BY `Time` ASC LIMIT 0, 1 ";
    $distanceboatsizeconstraints = array_merge($basesqlconstraints,$raceconstraints['SQLValues']);

    //Make the DB statement
    $findrecordstmt = dbprepare($srrsdblink,$findrecordsql);

    //Search for each MW and CK
    foreach ($lookupmw as $querymw)
      {
      foreach ($lookupck as $queryck)
        {
        //Get record
        $queryconstraints = $distanceboatsizeconstraints;
        array_push($queryconstraints,$querymw);
        array_push($queryconstraints,$queryck);
        $record = dbexecute($findrecordstmt,$queryconstraints);
        if (count($record) > 0)
          {
          $record = $record[0];
          $record['Distance'] = $distance;
          $record['BoatSize'] = $size;
          $record['MW'] = $querymw;
          $record['CK'] = $queryck;
          $record['Time'] = secstohms($record['Time']);

          //Get the regatta details for the record
          if (isset($regattadetailsrace[$record['Race']]) == true)
            {
            //If the race has already been found, look it up
            $record['Regatta'] = $regattadetailsrace[$record['Race']]['Regatta'];
            $record['MonthYear'] = $regattadetailsrace[$record['Race']]['MonthYear'];
            }
          else
            {
            //Lookup regatta ID
            $findregattaid = dbexecute($getregattastmt,$record['Race']);
            $findregattaid = $findregattaid[0]['Regatta'];

            if (isset($regattadetailsregatta[$findregattaid]) == true)
              {
              //Get regatta details if already looked up
              $record['Regatta'] = $regattadetailsregatta[$findregattaid]['Regatta'];
              $record['MonthYear'] = $regattadetailsregatta[$findregattaid]['MonthYear'];
              }
            else
              {
              //Get regatta details from database
              $regattadetailsline = dbexecute($getregattadetailsstmt,$findregattaid);
              //echo $findregattaid . "<br>";
              //print_r($regattadetailsline);
              //echo "<br>";
              $regattadetailsline = $regattadetailsline[0];

              include 'process-regatta-details.php';

              $regattadetailsrace[$record['Race']]['Regatta'] = $findregattaid;
              $regattadetailsrace[$record['Race']]['MonthYear'] = $regattadetailsline['MonthDate'];
              $regattadetailsregatta[$findregattaid]['Regatta'] = $findregattaid;
              $regattadetailsregatta[$findregattaid]['MonthYear'] = $regattadetailsline['MonthDate'];
              $record['Regatta'] = $findregattaid;
              $record['MonthYear'] = $regattadetailsline['MonthDate'];
              }
            }

          array_push($allrecords,$record);
          }
        }
      }
    }
  }
?>
