<?php
include_once 'required-functions.php';

//Containter to store the values
$baseconstraintvalues = array();

//Write the SQL query
$paddlerfindsql = "SELECT COUNT(*)
FROM `paddlers` p
LEFT JOIN `races` r ON p.`Race` = r.`Key`
LEFT JOIN `regattas` g ON r.`Regatta` = g.`Key`";

if ($classsearch == true)
  $paddlerfindsql = $paddlerfindsql . " RIGHT JOIN `classes` c ON c.`Race` = r.`Key`";

$paddlerfindsql = $paddlerfindsql . " WHERE";

//Add race distance limits to query
if (($analyticsby != "Distance") AND ((in_array(200,$analyticsdistances) == false) OR (in_array(500,$analyticsdistances) == false) OR (in_array(1000,$analyticsdistances) == false) OR (in_array("LD",$analyticsdistances) == false)))
  {
  //Treat long distance races separately
  $ldkey = array_search("LD",$analyticsdistances);
  if ($ldkey != false)
    {
    //Convert LD tag to > 1000 constraint
    unset($analyticsdistances[$ldkey]);
    $distancessql = elementlisttoconstraint($analyticsdistances,"Dist");
    $distancessql['SQLText'] = str_replace(")"," OR `Dist` > 1000)",$distancessql['SQLText']);
    }
  else
    $distancessql = elementlisttoconstraint($analyticsdistances,"Dist");

  //Specify table on distance
  $distancessql['SQLText'] = str_replace("`Dist`","p.`Dist`",$distancessql['SQLText']);

  //Add the distance to the query and base values
  $paddlerfindsql = $paddlerfindsql . " " . $distancessql['SQLText'] . " AND";
  $baseconstraintvalues = array_merge($baseconstraintvalues,$distancessql['SQLValues']);
  }

//Add JSV limits to query
if (($analyticsby != "JSV") AND ((in_array("J",$analyticsjsv) == false) OR (in_array("S",$analyticsjsv) == false) OR (in_array("V",$analyticsjsv) == false)))
  {
  $paddlerjsvsql = elementlisttoconstraint($analyticsjsv,"JSV","p");
  $paddlerfindsql = $paddlerfindsql . " " . $paddlerjsvsql['SQLText'] . " AND";
  $baseconstraintvalues = array_merge($baseconstraintvalues,$paddlerjsvsql['SQLValues']);
  }

//Add MW limits to query
if (($analyticsby != "MW") AND ((in_array("M",$analyticsmw) == false) OR (in_array("W",$analyticsmw) == false)))
  {
  $paddlermwsql = elementlisttoconstraint($analyticsmw,"MW","p");
  $paddlerfindsql = $paddlerfindsql . " " . $paddlermwsql['SQLText'] . " AND";
  $baseconstraintvalues = array_merge($baseconstraintvalues,$paddlermwsql['SQLValues']);
  }

//Add CK limits to query
if (($analyticsby != "CK") AND ((in_array("C",$analyticsck) == false) OR (in_array("K",$analyticsck) == false) OR (in_array("P",$analyticsck) == false) OR (in_array("T",$analyticsck) == false) OR (in_array("V",$analyticsck) == false)))
  {
  $paddlermwsql = elementlisttoconstraint($analyticsck,"CK","p");
  $paddlerfindsql = $paddlerfindsql . " " . $paddlermwsql['SQLText'] . " AND";
  $baseconstraintvalues = array_merge($baseconstraintvalues,$paddlermwsql['SQLValues']);
  }

if ($classsearch != false)
  {
  foreach ($classsearch as $classfield=>$classvalue)
    {
    //Add SQL query text
    $paddlerfindsql = $paddlerfindsql . " c.`" . $classfield . "` LIKE ? AND";
    //Add values to base constraints
    $classvalue = "%" . $classvalue . "%";
    array_push($baseconstraintvalues,$classvalue);
    }
  }

// These always go at the end as they are year and boat size
$paddlerfindsql = $paddlerfindsql . " (g.`Date` BETWEEN ? AND ?)";

//Add the constraint to search by distance in each year
if ($analyticsby == "Distance")
  {
  $paddlerfindsql = $paddlerfindsql . " AND r.`Dist` = ?";

  //Create the SQL for searching for
  if (in_array("LD",$analyticsdistances) == true)
    $longdistancepaddlerfindsql = str_replace("r.`Dist` = ?","r.`Dist` > 1000",$paddlerfindsql);
  echo $longdistancepaddlerfindsql . "<br>";
  }
//Add the constraint to search by JSV in each year
elseif ($analyticsby == "JSV")
  {
  $paddlerfindsql = $paddlerfindsql . " AND p.`JSV` = ?";
  }
//Add the constraint to search by MW in each year
elseif ($analyticsby == "MW")
  {
  $paddlerfindsql = $paddlerfindsql . " AND p.`MW` = ?";
  }
//Add the constraint to search by CK in each year
elseif ($analyticsby == "CK")
  {
  $paddlerfindsql = $paddlerfindsql . " AND p.`CK` = ?";
  }

//Attach boat size to query
$paddlerfindsql = $paddlerfindsql . " AND r.`Boat` = ?";
?>
