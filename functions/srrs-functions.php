<?php
//---FunctionBreak---
/*Sort regattas function

Call this function with usort to sort a batch of regattas by date*/
//---DocumentationBreak---
function sortregattas($a,$b)
	{
  if ($a['Date'] == $b['Date'])
		{
	  return 0;
    }
  return ($a['Date'] > $b['Date']) ? -1 : 1;
	}
//---FunctionBreak---
/*Sort race finishers function

Call this function with usort*/
//---DocumentationBreak---
function sortfinishers($a,$b)
	{
  if ($a['Result'] == $b['Result'])
		{
		if ($a['Secs'] == $b['Secs'])
			{
		  return 0;
		  }
		return ($a['Secs'] < $b['Secs']) ? -1 : 1;
    }
  return ($a['Result'] > $b['Result']) ? -1 : 1;
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
	$seconds = $time-($mins*60)-($hours*3600);

	//Round seconds to 2dp
	$seconds = round($seconds,2);

	//Add the trailing 0 if the seconds are exactly 1/10th
	if (substr($seconds,-2,1) == ".")
		$seconds = $seconds . "0";

	//Add the .00 if the seconds are exactly 1s
	if (strpos($seconds,".") === false)
		$seconds = $seconds . ".00";

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
/*Decide whether to highlight a row on a results record

$userinputs are the details from the user inputs
$paddlerdetails are the details for the paddler

Output is true if row should be highlighted, else false.*/
//---DocumentationBreak---
function highlightcheck($userinputs,$paddlerdetails)
	{
	//This function is inactive until logic is ready
	Return false;
	}
//---FunctionBreak---
/*Makes an list of possibilities of how a name could be stored in the SRRS database

$paddler is the text of the paddler name in the format A. Surname

Output is an array with all possible names which can be passed to elementlisttoconstraint()*/
//---DocumentationBreak---
function paddlertopossibilities($paddler)
  {
  //Create array of possibilities
  $possibilities = array();
  array_push($possibilities,"%" . $paddler . "%");

  //Add ambiguous surnames for unknown first name, and paddlers not known
  $surname = substr($paddler,3);
  array_push($possibilities,"%?. " . $surname . "%");
  array_push($possibilities,"%/" . $surname . "/%");
  array_push($possibilities,"%/" . $surname);
  array_push($possibilities,$surname . "/%");
  array_push($possibilities,$surname);

  //Output all the possibilities
  Return $possibilities;
  }
//---FunctionBreak---
/*Turns the race class types into an array to merge onto an SQL constraints array

$jsv is the JSV status
$mw is the MW status
$ck is the CK status
$abil is the Ability band
$spec is any special codes
$ages is the ages of the paddlers

Output is an array with values of the appropriate constraints*/
//---DocumentationBreak---
function raceclasstoconstraints($jsv,$mw,$ck,$abil,$spec,$ages)
	{
	//Attach wildcards to every class
	$jsv = "%" . $jsv . "%";
	$mw = "%" . $mw . "%";
	$ck = "%" . $ck . "%";
	$abil = "%" . $abil . "%";
	$spec = "%" . $spec . "%";
	$ages = "%" . $ages . "%";

	$output = array($jsv,$mw,$ck,$abil,$spec,$ages);
	Return $output;
	}
//---FunctionBreak---
?>