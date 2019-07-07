<?php
include_once 'required-functions.php';

//Flag for if the result is a finish or not
if ($paddlerdetails['NR'] == '')
  {
  $paddlerdetails['Result'] = true;
  $paddlerdetails['Time'] = secstohms($paddlerdetails['Time']);
  }
else
  {
  //A no result line
  $paddlerdetails['Result'] = false;
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
