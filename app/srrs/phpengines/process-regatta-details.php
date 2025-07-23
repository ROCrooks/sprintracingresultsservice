<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get start and end dates for regatta
$regattaadddays = $regattadetailsline['Days']-1;
$regattaadddays = ' + ' . $regattaadddays . ' days';
$startdate = strtotime($regattadetailsline['Date']);
$enddate = strtotime($regattadetailsline['Date']. $regattaadddays);

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
unset($regattadetailsline['Days']);
$regattadetailsline['Year'] = date('Y',$startdate);
$regattadetailsline['FullDate'] = $regattadates;
$regattadetailsline['MonthDate'] = date('F Y',$startdate);
?>
