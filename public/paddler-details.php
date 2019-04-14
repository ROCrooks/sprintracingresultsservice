<?php
include_once 'required-functions.php';

//$paddlerid = 1523;
$raceid = 123;

//Search either by paddler or by race
if (isset($paddlerid) == true)
  {
  $paddlersql = "SELECT `Race`, `Position`, `Lane`, `Crew`, `Club`, `NR`, `Time`, `JSV`, `MW`, `CK` FROM `paddlers` WHERE `Key` = ? ";
  $searchid = $paddlerid;
  }
elseif (isset($raceid) == true)
  {
  $paddlersql = "SELECT `Key`, `Position`, `Lane`, `Crew`, `Club`, `NR`, `Time`, `JSV`, `MW`, `CK` FROM `paddlers` WHERE `Race` = ? ";
  $searchid = $raceid;
  }

//Get paddler details from database
$paddlerdetails = dbprepareandexecute($srrsdblink,$paddlersql,$searchid);

foreach ($paddlerdetails as $paddlerkey=>$paddler)
  {
  //Flag for if the result is a finish or not
  if ($paddler['NR'] == '')
    {
    $paddler['Result'] = true;

    //Format time in seconds for display
    $hours = floor($paddler['Time']/3600);
    $mins = (floor($paddler['Time']/60))-($hours*60);
    $seconds = $paddler['Time']%60;
    $paddler['DisplayTime'] = $seconds;
    if (($mins > 0) OR ($hours > 0))
      {
      if ($seconds < 10)
        $paddler['DisplayTime'] = "0" . $paddler['DisplayTime'];
      $paddler['DisplayTime'] = $mins . ":" . $paddler['DisplayTime'];
      if ($hours > 0)
        {
        if ($mins < 10)
          $paddler['DisplayTime'] = "0" . $paddler['DisplayTime'];

        $paddler['DisplayTime'] = $hours . ":" . $paddler['DisplayTime'];
        }
      }
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
