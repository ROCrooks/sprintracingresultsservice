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
				return ($a < $b) ? -1 : 1;
			  }
			return ($a < $b) ? -1 : 1;
		  }
		return ($a < $b) ? -1 : 1;
    }
  return ($a < $b) ? -1 : 1;
	}
//---FunctionBreak---
?>
