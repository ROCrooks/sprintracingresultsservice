<?php
include_once $engineslocation . 'srrs-required-functions.php';

$year = "";
$club = "";
$jsv = "";

//Get regatta metrics
$endconstraints = array();
$geteventanalyticssql = "SELECT
    `Club`,
    `Crew`,
    `Dist`,
    `Boat`,
    `JSV`,
    `MW`,
    `CK`,
    `Year`
FROM
    `paddlers` p
LEFT JOIN `races` r ON r.`Key` = p.`Race`
LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta`
WHERE `MW` = ? AND `CK` = ? AND `Boat` = ? AND `Dist` = ? AND `NR` = ''";
if ($year != "")
  {
  $geteventanalyticssql = $geteventanalyticssql . " AND `Year` = ?";
  array_push($endconstraints,$year);
  }
if ($club != "")
  {
  $geteventanalyticssql = $geteventanalyticssql . " AND `Club` = ?";
  array_push($endconstraints,$club);
  }
if ($jsv != "")
  {
  $geteventanalyticssql = $geteventanalyticssql . " AND `JSV` = ?";
  array_push($endconstraints,$jsv);
  }
"ORDER BY
    p.`Key` ASC";
$querydata = array("M","K",1,500);
$querydata = array_merge($querydata,$endconstraints);

$eventdata = dbprepareandexecute($srrsdblink,$geteventanalyticssql,$querydata);

print_r($eventdata);
?>
