<?php
include_once 'required-functions.php';

$mw = "M";
$ck = "K";
$dist = 500;
$boat = 1;
//$jsv = "J";
//$year = 2014;
//$club = "LBZ";

//Make common SQL and constraint arrays
//Prepare array of common constraints
$commonconstraints = array($mw,$ck,$dist,$boat);

//Prepare common SQL constraints used in all SQLs
$commonsql = "WHERE p.`MW` = ?
AND p.`CK` = ?
AND r.`Dist` = ?
AND r.`Boat` = ?";

//Attach JSV if specified
if (isset($jsv) == true)
  {
  array_push($commonconstraints,$jsv);
  $commonsql = $commonsql . " AND r.`JSV` = ?";
  }

//Attach year to constraints if specified
if (isset($year) == true)
  {
  //Make start and end dates for SQL range
  $startdate = $year . "-01-01";
  $enddate = $year . "-12-31";

  array_push($commonconstraints,$startdate);
  array_push($commonconstraints,$enddate);

  $commonsql = $commonsql . " AND g.`Date` BETWEEN ? AND ?";
  }

//Attach club to constrains if specified
if (isset($club) == true)
  {
  array_push($eventmetricsconstraints,$club);

  $commonsql = $commonsql . " AND p.`Club` LIKE ?";
  }

//Prepare statements for the queries to run
//SQL statement to count total number of boats in event
if (isset($noboatsstmt) == false)
  {
  //Write the SQL statement
  $noboatssql = "
  SELECT COUNT(*) FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

  //Bind common SQL constraints to query
  $noboatssql = $noboatssql . $commonsql;

  //Prepare the query
  $noboatsstmt = dbprepare($srrsdblink,$noboatssql);
  }

//SQL statement to count total number of non-finishing boats in event
if (isset($noboatsnrstmt) == false)
  {
  //Write the SQL statement
  $noboatsnrsql = "
  SELECT COUNT(*) FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

  //Bind common SQL constraints to query
  $noboatsnrsql = $noboatsnrsql . $commonsql;

  //Bind no result flag to SQL
  $noboatsnrsql = $noboatsnrsql . " AND p.`NR` = ?";

  //Prepare the query
  $noboatsnrstmt = dbprepare($srrsdblink,$noboatsnrsql);
  }

//SQL statement to get the mean time
if (isset($meantimestmt) == false)
  {
  //Write the SQL statement
  $meantimesql = "
  SELECT AVG(`Time`) FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

  //Bind common SQL constraints to query
  $meantimesql = $meantimesql . $commonsql;

  //Bind constraint for only results
  $meantimesql = $meantimesql . " AND p.`NR` = ''";

  //Prepare the query
  $meantimestmt = dbprepare($srrsdblink,$meantimesql);
  }

//SQL statement to get the mean time
if (isset($sdtimestmt) == false)
  {
  //Write the SQL statement
  $sdtimesql = "
  SELECT STD(`Time`) FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

  //Bind common SQL constraints to query
  $sdtimesql = $sdtimesql . $commonsql;

  //Bind constraint for only results
  $sdtimesql = $sdtimesql . " AND p.`NR` = ''";

  //Prepare the query
  $sdtimestmt = dbprepare($srrsdblink,$sdtimesql);
  }

//Run the queries
//Make constraints and run query for counting all entrants and summary statistics
$noboatsresult = dbexecute($noboatsstmt,$commonconstraints);
$meantimeresult = dbexecute($meantimestmt,$commonconstraints);
$sdtimeresult = dbexecute($sdtimestmt,$commonconstraints);

//Make constraints for counting no results
$noboatsnrconstraints = $commonconstraints;
$noboatsnrconstraints[4] = "DNS";
$noboatsdnsresult = dbexecute($noboatsnrstmt,$noboatsnrconstraints);
$noboatsnrconstraints[4] = "DNF";
$noboatsdnfresult = dbexecute($noboatsnrstmt,$noboatsnrconstraints);
$noboatsnrconstraints[4] = "DSQ";
$noboatsdsqresult = dbexecute($noboatsnrstmt,$noboatsnrconstraints);
$noboatsnrconstraints[4] = "ERR";
$noboatserrresult = dbexecute($noboatsnrstmt,$noboatsnrconstraints);
$noboatsnrconstraints[4] = "???";
$noboatsunkresult = dbexecute($noboatsnrstmt,$noboatsnrconstraints);

//Compile results of the queries into output
$resultsarray = array();
$resultsarray['Entries'] = $noboatsresult[0]['COUNT(*)'];
$resultsarray['DNS'] = $noboatsdnsresult[0]['COUNT(*)'];
$resultsarray['DNF'] = $noboatsdnfresult[0]['COUNT(*)'];
$resultsarray['DSQ'] = $noboatsdsqresult[0]['COUNT(*)'];
$resultsarray['ERR'] = $noboatserrresult[0]['COUNT(*)'];
$resultsarray['???'] = $noboatsunkresult[0]['COUNT(*)'];
$resultsarray['Finishers'] = $resultsarray['Entries']-$resultsarray['DNS']-$resultsarray['DNF']-$resultsarray['DSQ']-$resultsarray['ERR']-$resultsarray['???'];
$resultsarray['Means'] = $meantimeresult[0]['AVG(`Time`)'];
$resultsarray['StDevs'] = $sdtimeresult[0]['STD(`Time`)'];



print_r($resultsarray);
?>
