<?php
include_once 'required-functions.php';

foreach ($paddlerdetails as $paddlerkey=>$paddler)
  {
  //Flag for if the result is a finish or not
  if ($paddler['NR'] == '')
    {
    $paddler['Result'] = true;
    $paddler['Time'] = secstohms($secs);
    }
  else
    {
    //A no result line
    $paddler['Result'] = false;
    $paddler['Time'] = $paddler['NR'];
    }

  unset($paddler['NR']);
  $paddlerdetails[$paddlerkey] = $paddler;
  }

usort($paddlerdetails,'sortfinishers');

print_r($paddlerdetails);
?>
