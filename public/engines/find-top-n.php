<?php
include_once 'required-functions.php';

//This is test data
$mw = "M";
$ck = "";
$dist = 500;
$boat = 1;

//This is also test data for the number of rows to retrieve
$tofind = 10;

//SQL statements for the distinct and detailed best results SQL
$besttimesdistinctsql = "
  SELECT DISTINCT `Crew`, MIN(`Time`) FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

$besttimesdetailssql = "
  SELECT `Race`, `Regatta`, `Date`, `Club` FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

//Array of constraints that are common to all queries
$besttimescommonconstraints = array($mw,$ck,$dist,$boat);

//Common SQL for best times
$besttimescommonsql = "WHERE p.`MW` = ?
  AND p.`CK` = ?
  AND r.`Dist` = ?
  AND r.`Boat` = ?
  AND p.`NR` = ''";

//Attach JSV constraints if specified
if (isset($jsv == true)
  {
  if ($jsv != '')
    {
    array_push($besttimescommonconstraints,$jsv);
    $besttimescommonsql = $besttimescommonsql . " AND p.`JSV` = ?";
    }
  }

//Attach year to constraints if specified
if (isset($year) == true)
  {
  if ($year != '')
    {
    //Make start and end dates for SQL range
    $startdate = $year . "-01-01";
    $enddate = $year . "-12-31";

    array_push($besttimescommonconstraints,$startdate);
    array_push($besttimescommonconstraints,$enddate);

    $besttimescommonsql = $besttimescommonsql . " AND g.`Date` BETWEEN ? AND ?";
    }
  }

//Attach club to constrains if specified
if (isset($club) == true)
  {
  if ($club != '')
    {
    $clublike = "%" . $club . "%";
    array_push($besttimescommonconstraints,$clublike);

    $besttimescommonsql = $besttimescommonsql . " AND p.`Club` LIKE ?";
    }
  }

//Create the SQL statement endings
$besttimesdistinctsql = $besttimesdistinctsql . $besttimescommonsql .
" GROUP BY `Crew`
 ORDER BY MIN(`Time`) ASC LIMIT ?, ? ";
$besttimesdetailssql = $besttimesdetailssql . $besttimescommonsql .
" AND `Crew` = ?
 AND `Time` = ?
 ORDER BY g.`Date` ASC
 LIMIT 0, 1 ";

//Prepare statements
if (isset($besttimesdistinctstmt) == false)
  $besttimesdistinctstmt = dbprepare($srrsdblink,$besttimesdistinctsql);
if (isset($besttimesdetailsstmt) == false)
  $besttimesdetailsstmt = dbprepare($srrsdblink,$besttimesdetailssql);

//Make constraints for the distinct rankings
$besttimesdistinctconstraints = $besttimescommonconstraints;
$besttimesdetailsconstraints = $besttimescommonconstraints;

//Storage arrays for results as they're being retrieved
$topnresults = array();
$allreadyfound = array();
//Flag that can be set if no more results are found
$resultsend = false;

$startlimit = 0;

while ((count($topnresults) < $tofind) AND ($resultsend == false))
  {
  //End limit is the number of records to retrieve
  $endlimit = $tofind-count($topnresults);

  //Define the start and end limit keys
  if ((isset($startlimitkey) == false) AND (isset($endlimitkey) == false))
    {
    $startlimitkey = count($besttimesdistinctconstraints);
    $endlimitkey = $startlimitkey+1;
    }

  //Add the limits constraints to the array
  $besttimesdistinctconstraints[$startlimitkey] = $startlimit;
  $besttimesdistinctconstraints[$endlimitkey] = $endlimit;

  //Run the query
  $distinctpaddlersresults = dbexecute($besttimesdistinctstmt,$besttimesdistinctconstraints);

  //Set flag to be at the end if no results found
  if (count($distinctpaddlersresults) == false)
    $resultsend = true;
  else
    {
    //Put the results into the output array
    foreach ($distinctpaddlersresults as $distinctresult)
      {
      //Make crew name for array checking
      //This solves the problem of same crew described in different ways
      $stndcrewname = $distinctresult['Crew'];

      //Only do standardise crew names for crew boats
      if ($boat > 1)
        {
        $stndcrewname = explode("/",$stndcrewname);
        foreach($stndcrewname as $stndcrewnamekey=>$stndmember)
          {
          $stndmember = explode(".",$stndmember);
          $stndmember = array_pop($stndmember);
          $stndmember = str_replace(" ","",$stndmember);
          $stndcrewname[$stndcrewnamekey] = $stndmember;
          }
        sort($stndcrewname);
        $stndcrewname = implode("/",$stndcrewname);
        }

      if (in_array($stndcrewname,$allreadyfound) === false)
        {
        //Add the standard name to the already found list
        array_push($allreadyfound,$stndcrewname);

        $topnresultsrow = array();
        $topnresultsrow['Crew'] = $distinctresult['Crew'];
        $topnresultsrow['Time'] = $distinctresult['MIN(`Time`)'];

        //Define the crew and time keys
        if ((isset($crewconstraintkey) == false) AND (isset($timeconstraintkey) == false))
          {
          $crewconstraintkey = count($besttimesdetailsconstraints);
          $timeconstraintkey = $startlimitkey+1;
          }

        //Attach crew and time constraints to query
        $besttimesdetailsconstraints[$crewconstraintkey] = $topnresultsrow['Crew'];
        $besttimesdetailsconstraints[$timeconstraintkey] = $topnresultsrow['Time'];

        //Get data about this result
        $resultdetails = dbexecute($besttimesdetailsstmt,$besttimesdetailsconstraints);

        //Apend data to the results row array
        $fields = array("Race","Regatta","Date","Club");
        foreach($fields as $field)
          {
          $topnresultsrow[$field] = $resultdetails[0][$field];
          }

        array_push($topnresults,$topnresultsrow);
        }
      }
    }

  //New start limit is the first record after the end
  $startlimit = $startlimit+$endlimit;
  }

print_r($topnresults);
?>
