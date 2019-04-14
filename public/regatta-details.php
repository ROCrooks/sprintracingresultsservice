<?php
include_once 'required-functions.php';

//Find a regatta ID
$regatta = 4;

//Get regatta details from regatta database
$getregattadetailssql = "SELECT `Date`, `Days`, `Name` FROM `regattas` WHERE `Key` = ? ";
$sqlresults = dbprepareandexecute($srrsdblink,$getregattadetailssql,$regatta);
$sqlresults = $sqlresults[0];

//Get start and end dates for regatta
$regattaadddays = $sqlresults['Days']-1;
$regattaadddays = ' + ' . $regattaadddays . ' days';
$startdate = strtotime($sqlresults['Date']);
$enddate = strtotime($sqlresults['Date']. $regattaadddays);

$startmonth = date('m',$startdate);
$endmonth = date('m',$enddate);
if ($startmonth == $endmonth)
  {
  //Format regatta dates if they're in the same month
  //Date is European standard
  $startday = date('d',$startdate);
  $endday = date('d',$enddate);
  $templatemy = date('m/Y',$startdate);
  $regattadates = $startday . "-" . $endday . "/" . $templatemy;
  }
else
  {
  $startyear = date('Y',$startdate);
  $endyear = date('Y',$enddate);

  if ($startyear == $endyear)
    {
    //Format regatta dates if they're not in the same month
    //Date is European standard
    $startday = date('d/m',$startdate);
    $endday = date('d/m',$enddate);
    $templatemy = date('Y',$startdate);
    $regattadates = $startday . "-" . $endday . "/" . $templatemy;
    }
  else
    {
    //Format regatta dates if they're not in the same year
    //Date is European standard
    $startday = date('d/m/Y',$startdate);
    $endday = date('d/m/Y',$enddate);
    $regattadates = $startday . "-" . $endday;
    }
  }

//Put regatta details into an array
$regattadetails = array();
$regattadetails['Key'] = $regatta;
$regattadetails['FullDate'] = $regattadates;
$regattadetails['MonthDate'] = date('F Y',$startdate);
$regattadetails['Name'] = $sqlresults['Name'];
print_r($regattadetails);
?>
