<?php
include_once 'required-functions.php';

//Prepare SQL query
$endconstraints = array();
$geteventrecordsql = "SELECT
    `Regatta`,
    `Race`,
    `Club`,
    `Crew`,
    `Time`,
    `Date`,
    `Days`
FROM
    `paddlers` p
LEFT JOIN `races` r ON r.`Key` = p.`Race`
LEFT JOIN `regattas` g ON g.`Key` = r.`Regatta`
WHERE p.`MW` = ? AND p.`CK` = ? AND r.`Boat` = ? AND r.`Dist` = ? AND p.`NR` = ''";
if ($year != "")
  {
  $yearstart = $year . "-01-01";
  $yearend = $year . "-12-31";

  $geteventrecordsql = $geteventrecordsql . " AND `Year` BETWEEN ? AND ?";
  array_push($endconstraints,$yearstart);
  array_push($endconstraints,$yearend);
  }
if ($club != "")
  {
  //Make club constraint
  $clubarray = str_replace(" ","",$club);
  $clubarray = explode(",",$clubarray);
  $clubconstraint = elementlisttoconstraint($clubarray,"Club","p");

  //Turn constraint into a LIKE constraint if it is a paddler being searched for
  if ($paddler != '')
    {
    foreach($clubconstraint['SQLValues'] as $valueskey=>$sqlvalue)
      {
      $clubconstraint['SQLValues'][$valueskey] = "%" . $sqlvalue . "%";
      }

    $clubconstraint['SQLText'] = str_replace(" = "," LIKE ",$clubconstraint['SQLText']);
    }

  $endconstraints = array_merge($endconstraints,$clubconstraint['SQLValues']);
  $geteventrecordsql = $geteventrecordsql . " AND " . $clubconstraint['SQLText'];
  }
if ($paddler != '')
  {
  //Add the paddler details to the search
  $paddlerpossibilities = paddlertopossibilities($paddler);
  $paddlerconstraint = elementlisttoconstraint($paddlerpossibilities,"Crew","p","LIKE");
  $endconstraints = array_merge($endconstraints,$paddlerconstraint['SQLValues']);
  $geteventrecordsql = $geteventrecordsql . " AND " . $paddlerconstraint['SQLText'];

  //Search for paddler only by JSV status
  if (($padjsv != '') AND ($padjsv != "JSV"))
    {
    $padjsvlist = str_split($padjsv);
    $padjsvsql = elementlisttoconstraint($padjsvlist,"JSV","p");
    $geteventrecordsql = $geteventrecordsql . " AND " . $padjsvsql['SQLText'];
    $endconstraints = array_merge($endconstraints,$padjsvsql['SQLValues']);
    }
  //Search for paddler only by MW status
  if (($padmw != '') AND ($padmw != "MW"))
    {
    $padmwlist = str_split($padmw);
    $padmwsql = elementlisttoconstraint($padmwlist,"MW","p");
    $geteventrecordsql = $geteventrecordsql . " AND " . $padmwsql['SQLText'];
    $endconstraints = array_merge($endconstraints,$padmwsql['SQLValues']);
    }
  //Search for paddler only by CK status
  if (($padck != '') AND ($padck != "CK"))
    {
    $padcklist = str_split($padck);
    $padcksql = elementlisttoconstraint($padcklist,"CK","p");
    $geteventrecordsql = $geteventrecordsql . " AND " . $padcksql['SQLText'];
    $endconstraints = array_merge($endconstraints,$padcksql['SQLValues']);
    }
  }
//Search for junior or masters records
if (($jsv == "J") OR ($jsv == "V"))
  {
  $geteventrecordsql = $geteventrecordsql . " AND `JSV` = ?";
  array_push($endconstraints,$jsv);
  }

$geteventrecordsql = $geteventrecordsql . " ORDER BY
    p.`Time` ASC
LIMIT 0,1";
$getrecordsstmt = dbprepare($srrsdblink,$geteventrecordsql);

//All options to search through
$mwoptions = array("M","W");
$ckoptions = array("K","C");
$boatoptions = array(1,2,4);
$distanceoptions = array(200,500,1000,5000);

//Lookup all records in a loop
$allrecords = array();
foreach ($mwoptions as $mwoption)
  {
  foreach ($ckoptions as $ckoption)
    {
    foreach ($boatoptions as $boatoption)
      {
      foreach ($distanceoptions as $distanceoption)
        {
        $recordquerydata = array($mwoption,$ckoption,$boatoption,$distanceoption);
        $recordquerydata = array_merge($recordquerydata,$endconstraints);
        $record = dbexecute($getrecordsstmt,$recordquerydata);
        if (count($record) > 0)
          {
          $record = $record[0];

          //Process name of the regatta
          $regattadetailsline = array("Days"=>$record['Days'],"Date"=>$record['Date']);
          include 'process-regatta-details.php';
          unset($record['Date']);
          unset($record['Days']);
          $record['MonthDate'] = $regattadetailsline['MonthDate'];

          $record['Time'] = secstohms($record['Time']);

          //Add the description for the race
          $eventdescription = $ckoption . $boatoption . " " . $distanceoption . "m";
          if ($mwoption == "M")
            $eventdescription = "Mens " . $eventdescription;
          if ($mwoption == "W")
            $eventdescription = "Womens " . $eventdescription;
          $record['EventDescription'] = $eventdescription;

          //This key allows lookup of records in a loop
          $recordkey = $mwoption . "-" . $ckoption . $boatoption . "-" . $distanceoption;
          $allrecords[$recordkey] = $record;
          }
        }
      }
    }
  }
?>
