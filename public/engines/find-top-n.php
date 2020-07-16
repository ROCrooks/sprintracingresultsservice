<?php
include_once 'required-functions.php';

//This is test data
$mw = "M";
$ck = "K";
$dist = 500;
$boat = 1;

//SQL statements for the distinct and detailed best results SQL
$besttimesdistinctsql = "
  SELECT DISTINCT `Crew` FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

$besttimesdetailssql = "
  SELECT `Crew`, `Time` FROM `paddlers` p
  LEFT JOIN `races` r ON r.`Key` = p.`Race`
  LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta` ";

$besttimescommonconstraints = array($mw,$ck,$dist,$boat);

//Common SQL for best times
$besttimescommonsql = "WHERE p.`MW` = ?
  AND p.`CK` = ?
  AND r.`Dist` = ?
  AND r.`Boat` = ?
  AND p.`NR` = ''";

//Attach JSV constraints if specified
if (isset($jsv) == true)
  {
  array_push($besttimescommonconstraints,$jsv);
  $besttimescommonsql = $besttimescommonsql . " AND p.`JSV` = ?";
  }

//Attach year to constraints if specified
if (isset($year) == true)
  {
  //Make start and end dates for SQL range
  $startdate = $year . "-01-01";
  $enddate = $year . "-12-31";

  array_push($besttimescommonconstraints,$startdate);
  array_push($besttimescommonconstraints,$enddate);

  $besttimescommonsql = $besttimescommonsql . " AND g.`Date` BETWEEN ? AND ?";
  }

//Attach club to constrains if specified
if (isset($club) == true)
  {
  $clublike = "%" . $club . "%";
  array_push($besttimescommonconstraints,$clublike);

  $besttimescommonsql = $besttimescommonsql . " AND p.`Club` LIKE ?";
  }

//Create the SQL statements
$besttimesdistinctsql = $besttimesdistinctsql . $besttimescommonsql .
" ORDER BY `Time` ASC LIMIT ?, ? ";
$besttimesdetailssql = $besttimesdetailssql . $besttimescommonsql .
" AND `Crew` = ?
 ORDER BY `Time` ASC LIMIT 0, 1 ";

if (isset($besttimesdistinctstmt) == true)
  $besttimesdistinctstmt = dbprepare($srrsdblink,$besttimesdistinctsql);



echo $besttimesdistinctsql;
echo "<br>";
echo $besttimesdetailssql;

?>
