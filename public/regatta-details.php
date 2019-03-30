<?php
//Get regatta details from regatta database
//$getregattadetailssql = "SELECT `Date`, `Days`, `Name` FROM `regattas` WHERE `Key` = ? ";
//mysqli_prepare();
//mysqli_stmt_bind_param();

//Get start and end dates for regatta
$date = "2019-12-31";
$regattalength = 2;
$regattalength = $regattalength-1;
$regattalength = ' + ' . $regattalength . ' days';
//$startdate = date('Y-m-d', strtotime($date));
//echo $startdate . "<br>";
//$enddate = date('Y-m-d', strtotime($date. $regattalength));
$startdate = strtotime($date);
$enddate = strtotime($date. $regattalength);


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
$regattadetails['FullDate'] = $regattadates;
$regattadetails['MonthDate'] = date('F Y',$startdate);
print_r($regattadetails);
?>
