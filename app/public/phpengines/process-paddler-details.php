<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Flag for if the result is a finish or not
//No time means no result
if (($paddlerdetails['NR'] == '') AND ($paddlerdetails['Time'] > 0))
  {
  $paddlerdetails['Result'] = true;
  $paddlerdetails['Secs'] = $paddlerdetails['Time'];
  $paddlerdetails['Time'] = secstohms($paddlerdetails['Time']);
  }
else
  {
  //A no result line
  //If NR is unspecified then NR = ???
  if ($paddlerdetails['NR'] == '')
    $paddlerdetails['NR'] = "???";

  $paddlerdetails['Result'] = false;
  $paddlerdetails['Secs'] = 0;
  $paddlerdetails['Time'] = $paddlerdetails['NR'];
  $paddlerdetails['Position'] = 0;
  }

//Default lane and position to blank if not set or 0
if (isset($paddlerdetails['Position']) == true)
  {
  if ($paddlerdetails['Position'] == 0)
    $paddlerdetails['Position'] = "";
  }
else
  $paddlerdetails['Position'] = "";

if (isset($paddlerdetails['Lane']) == true)
  {
  if ($paddlerdetails['Lane'] == 0)
    $paddlerdetails['Lane'] = "";
  }
else
  $paddlerdetails['Lane'] = "";

unset($paddlerdetails['NR']);
?>
