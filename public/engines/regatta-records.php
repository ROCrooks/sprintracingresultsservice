<?php
include_once 'required-functions.php';

$year = "";
$club = "";

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
WHERE `MW` = ? AND `CK` = ? AND `Boat` = ? AND `Dist` = ? AND `NR` = ''";
if ($year != "")
  {
  $geteventrecordsql = $geteventrecordsql . " AND `Year` = ?";
  array_push($endconstraints,$year);
  }
if ($club != "")
  {
  $geteventrecordsql = $geteventrecordsql . " AND `Club` = ?";
  array_push($endconstraints,$club);
  }
$geteventrecordsql = $geteventrecordsql . " ORDER BY
    p.`Time` ASC
LIMIT 0,1";
$getrecordsstmt = dbprepare($srrsdblink,$geteventrecordsql);

//All options to search through
$mwoptions = array("M","W");
$ckoptions = array("K","C");
$boatoptions = array(1,2,4);
$distanceoptions = array(200,500,1000);

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

          //Add the description for the race
          $eventdescription = $ckoption . $distanceoption . " " . $distanceoption . "m";
          if ($mwoption == "M")
            $eventdescription = "Mens " . $eventdescription;
          if ($mwoption == "W")
            $eventdescription = "Womens " . $eventdescription;

          //This key allows lookup of records in a loop
          $recordkey = $mwoption . "-" . $ckoption . $boatoption . "-" . $distanceoption;
          $allrecords[$recordkey] = $record;
          }
        }
      }
    }
  }
?>
