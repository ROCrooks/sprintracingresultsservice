<?php
include_once 'required-functions.php';

//Flag for if the result is a finish or not
if ($paddler['NR'] == '')
  {
  $paddler['Result'] = true;
  $paddler['Time'] = secstohms($paddler['Time']);
  }
else
  {
  //A no result line
  $paddler['Result'] = false;
  $paddler['Time'] = $paddler['NR'];
  $paddler['Position'] = 0;
  }

//Default lane and position to blank if not set or 0
if (isset($paddler['Position']) == true)
  {
  if ($paddler['Position'] == 0)
    $paddler['Position'] = "";
  }
else
  $paddler['Position'] = "";

if (isset($paddler['Lane']) == true)
  {
  if ($paddler['Lane'] == 0)
    $paddler['Lane'] = "";
  }
else
  $paddler['Lane'] = "";

unset($paddler['NR']);
?>
