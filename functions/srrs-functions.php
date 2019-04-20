<?php
//---FunctionBreak---
/*Sort race finishers function

Call this function with usort*/
//---DocumentationBreak---
function sortfinishers($a,$b)
	{
  if ($a['Result'] == $b['Result'])
		{
		if ($a['Time'] == $b['Time'])
			{
		  return 0;
		  }
		return ($a < $b) ? -1 : 1;
    }
  return ($a > $b) ? -1 : 1;
	}
//---FunctionBreak---
/*Sort races in the following order

Class
Distance
Round
Draw

Call this function with usort*/
//---DocumentationBreak---
function sortraceslist($a,$b)
	{
  if ($a['Class'] == $b['Class'])
		{
		if ($a['Distance'] == $b['Distance'])
			{
			if ($a['Round'] == $b['Round'])
				{
				if ($a['Draw'] == $b['Draw'])
					{
				  return 0;
				  }
				return ($a['Draw'] < $b['Draw']) ? -1 : 1;
			  }
			return ($a['Round'] < $b['Round']) ? -1 : 1;
		  }
		return ($a['Distance'] < $b['Distance']) ? -1 : 1;
    }
  return ($a['Class'] < $b['Class']) ? -1 : 1;
	}
//---FunctionBreak---
/*Convert a time in seconds to a time in HH:MM:SS

$time is the time in seconds

Output is the time in HH:MM:SS format.*/
//---DocumentationBreak---
function secstohms($time)
	{
	//Format time in seconds for display
	$hours = floor($time/3600);
	$mins = (floor($time/60))-($hours*60);
	$seconds = $time%60;
	$hms = $seconds;
	if (($mins > 0) OR ($hours > 0))
		{
		if ($seconds < 10)
			$hms = "0" . $hms;
		$hms = $mins . ":" . $hms;
		if ($hours > 0)
			{
			if ($mins < 10)
				$hms = "0" . $hms;

			$hms = $hours . ":" . $hms;
			}
		}

	Return $hms;
	}
//---FunctionBreak---
/*Convert a time in HH:MM:SS to a time in seconds

$time is the time in HH:MM:SS

Output is the time in seconds.*/
//---DocumentationBreak---
function hmstosecs($time)
	{
	//Convert display time to a time in seconds
	$time = explode(":",$time);

	$time = array_reverse($time);

	$seconds = $time[0];
	if (isset($time[1]) == true)
		$seconds = $seconds+($time[1]*60);
	if (isset($time[2]) == true)
		$seconds = $seconds+($time[2]*60*60);

	Return $seconds;
	}
//---FunctionBreak---
?>
