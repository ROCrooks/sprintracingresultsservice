<?php
//---FunctionBreak---
/*Draw a graph on an HTML canvas

$array is the array with the data
$xaxis is the data for the x axis of the plot
$yaxis is the data for the y axis of the plot
$colour is the colour to draw the line
$graphdetails is an array with details about the graph
$lineno is the number of the line of the graph, used to decide the position of the key

This function is to be updated*/
//---DocumentationBreak---
function plotline($array,$xaxis,$yaxis,$colour,$graphdetails,$lineno)
	{
	//Check that maximums are set
	if ((is_numeric($graphdetails['MaxX']) == true) AND (is_numeric($graphdetails['MaxY']) == true))
		{
		//Set defaults to zero if they are not set or are illegal inputs
		if ((isset($graphdetails['MinX']) == false) OR (is_numeric($graphdetails['MinX']) == false))
			$graphdetails['MinX'] = 0;
		if ((isset($graphdetails['MinY']) == false) OR (is_numeric($graphdetails['MinY']) == false))
			$graphdetails['MinY'] = 0;
		if (isset($graphdetails['SkipX']) != true)
			$graphdetails['SkipX'] = false;
		if (isset($graphdetails['SkipY']) != true)
			$graphdetails['SkipY'] = false;
		if (is_numeric($lineno) == false)
			$lineno = 1;
		
		//Begin canvas path
		begincanvaspath();
		
		//Define line colour
		echo 'ctx.strokeStyle = "' . $colour . '";';
		echo 'ctx.lineWidth=3;';
		
		//Array loop parameters
		$key = 0;
		$count = count($array);
		while ($key < $count)
			{
			//Get array line
			$line = $array[$key];
			
			//X and Y values
			$x = $line[$xaxis];
			$y = $line[$yaxis];
			
			//X and Y coordinates
			$xcoordinate = coordinate('x',$graphdetails['MinX'],$graphdetails['MaxX'],$x,$graphdetails['SkipX']);
			$ycoordinate = coordinate('y',$graphdetails['MinY'],$graphdetails['MaxY'],$y,$graphdetails['SkipY']);

			//Echo line point
			if ($key == 0)
				echo 'ctx.moveTo(' . $xcoordinate . ',' . $ycoordinate . ');';
			else
				echo 'ctx.lineTo(' . $xcoordinate . ',' . $ycoordinate . ');';
			$key++;
			}
		
		echo 'ctx.stroke();';
		echo 'ctx.restore();';
		
		//Define locations of key elements
		$locations = array();
		$locations[1] = array("LineStart"=>40,"LineStop"=>70,"TextStart"=>75);
		$locations[2] = array("LineStart"=>262,"LineStop"=>292,"TextStart"=>297);
		$locations[3] = array("LineStart"=>485,"LineStop"=>515,"TextStart"=>520);
		$locations[4] = array("LineStart"=>727,"LineStop"=>757,"TextStart"=>762);
		
		//Get location for this element of the legend
		$locations = $locations[$lineno];
		
		//Draw line
		begincanvaspath();
		echo 'ctx.strokeStyle = "' . $colour . '";';
		echo 'ctx.lineWidth=3;';
		echo 'ctx.moveTo(' . $locations['LineStart'] . ',610);';
		echo 'ctx.lineTo(' . $locations['LineStop'] . ',610);';
		echo 'ctx.stroke();';
		echo 'ctx.restore();';
		
		begincanvaspath();
		echo 'ctx.fillStyle = "#000000";';
		echo 'ctx.font = "15px Arial";';
		echo 'ctx.textAlign="left";';
		echo 'ctx.fillText("' . $yaxis . '",' . $locations['TextStart'] . ',615);';
		}
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function begincanvaspath()
	{
	echo 'ctx.save();';
	echo 'ctx.beginPath();';
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function fillgraphbackground($colour)
	{
	//Begin path and save, required before any canvas scripting code
	begincanvaspath();
	
	//Draw a rectangular background on the colour
	echo 'ctx.fillStyle = "' . $colour . '";';
	echo 'ctx.fillRect(0,0,950,650);';
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function yaxis($title,$min,$max,$labels,$ticks,$skip)
	{
	//Check inputs for validity
	$min = defaultcheck($min,0,"numeric");
	$max = defaultcheck($max,10000,"numeric");
	$range = $max-$min;
	$labels = defaultcheck($labels,$range,"numeric");
	
	//Checking range is divisible by range
	$labelsmodulus = $range%$labels;
	$labelsdivide = $range/$labels;
	if (($labelsmodulus != 0) OR ($labelsdivide > 10))
		$labels = $range;
	
	$ticks = defaultcheck($labels,$range,"numeric");
	
	//Checking range is divisible by range
	$ticksmodulus = $range%$ticks;
	$ticksdivide = $range/$ticks;
	if (($ticksmodulus != 0) OR ($ticksdivide > 10))
		$tickss = $labels;
	
	begincanvaspath();
	//Echo axis title
	echo 'ctx.save();';
	echo 'ctx.translate(12,300);';
	echo 'ctx.rotate(-90 * Math.PI / 180);';
	echo 'ctx.fillStyle = "#000000";';
	echo 'ctx.font = "15px Arial";';
	echo 'ctx.textAlign="center";';
	echo 'ctx.fillText("' . $title . '",0,0);';
	echo 'ctx.restore();';
	
	begincanvaspath();
	//Draw axis line
	echo 'ctx.moveTo(40,20);';
	echo 'ctx.lineTo(40,530);';
	if (($min == 0) OR ($skip == false))
		{
		echo 'ctx.lineTo(40,550);';
		$pixelminfloor = 550;
		}
	elseif (($min > 0) AND ($skip == true))
		{
		//Draw axis line if graph does not start at 0
		echo 'ctx.lineTo(35,535);';
		echo 'ctx.lineTo(45,545);';
		echo 'ctx.lineTo(40,550);';
		$pixelminfloor = 530;
		}
	echo 'ctx.stroke();';
	
	//Label value for start of loop
	$labelvalue = $min;
	while ($labelvalue <= $max)
		{
		//Get y axis location
		$coordinate = coordinate("y",$min,$max,$labelvalue,$skip);
		$coordinate = $coordinate+4;
		
		//Write label
		begincanvaspath();
		echo 'ctx.fillStyle = "#000000";';
		echo 'ctx.font = "10px Arial";';
		echo 'ctx.textAlign="end";';
		echo 'ctx.fillText("' . $labelvalue . '",30,' . $coordinate . ');';
		
		//Increment label lab
		$labelvalue = $labelvalue+$labels;
		}

	//Label value for start of loop
	$tickvalue = $min;
	while ($tickvalue <= $max)
		{
		//Get y axis location
		$coordinate = coordinate("y",$min,$max,$tickvalue,$skip);
		
		//Draw tick
		begincanvaspath();
		echo 'ctx.fillStyle = "#000000";';
		echo 'ctx.moveTo(40,' . $coordinate . ');';
		echo 'ctx.lineTo(35,' . $coordinate . ');';
		echo 'ctx.stroke();';
		
		//Increment label lab
		$tickvalue = $tickvalue+$ticks;
		}
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function coordinate($axis,$min,$max,$value,$skip)
	{
	//Get the fraction 
	$numerator = $value-$min;
	$denominator = $max-$min;
	$fraction = $numerator/$denominator;
	
	//Get the pixel range for the axis
	if ($axis == 'x')
		{
		$pixelrange = 870;
		$offset = 40;
		}
	elseif ($axis == 'y')
		{
		$pixelrange = 530;
		$fraction = 1-$fraction;
		$offset = 20;
		}
	
	//Correct if there is a skip
	if ($skip == true)
		{
		$pixelrange = $pixelrange-20;
		if ($axis == 'x')
			$offset = 60;
		}
	
	//Define pixel location
	$pixellocation = $pixelrange*$fraction;
	$pixellocation = $pixellocation+$offset;
	$pixellocation = round($pixellocation);
	
	Return $pixellocation;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function xaxis($title,$min,$max,$labels,$ticks,$skip)
	{
	//Check inputs for validity
	$min = defaultcheck($min,0,"numeric");
	$max = defaultcheck($max,10000,"numeric");
	$range = $max-$min;
	$labels = defaultcheck($labels,$range,"numeric");
	
	//Checking range is divisible by range
	$labelsmodulus = $range%$labels;
	$labelsdivide = $range/$labels;
	if (($labelsmodulus != 0) OR ($labelsdivide > 10))
		$labels = $range;
	
	$ticks = defaultcheck($labels,$range,"numeric");
	
	//Checking range is divisible by range
	$ticksmodulus = $range%$ticks;
	$ticksdivide = $range/$ticks;
	if (($ticksmodulus != 0) OR ($ticksdivide > 10))
		$tickss = $labels;
	
	begincanvaspath();
	//Echo axis title
	echo 'ctx.save();';
	echo 'ctx.fillStyle = "#000000";';
	echo 'ctx.font = "15px Arial";';
	echo 'ctx.textAlign="center";';
	echo 'ctx.fillText("' . $title . '",475,590);';
	echo 'ctx.restore();';
	
	begincanvaspath();
	//Draw axis line
	echo 'ctx.moveTo(910,550);';
	echo 'ctx.lineTo(60,550);';
	if (($min == 0) OR ($skip == false))
		{
		echo 'ctx.lineTo(40,550);';
		$pixelminfloor = 550;
		}
	elseif (($min > 0) AND ($skip == true))
		{
		//Draw axis line if graph does not start at 0
		echo 'ctx.lineTo(55,545);';
		echo 'ctx.lineTo(45,555);';
		echo 'ctx.lineTo(40,550);';
		$pixelminfloor = 530;
		}
	echo 'ctx.stroke();';
	
	//Label value for start of loop
	$labelvalue = $min;
	while ($labelvalue <= $max)
		{
		//Get y axis location
		$coordinate = coordinate("x",$min,$max,$labelvalue,$skip);
		
		//Write label
		begincanvaspath();
		echo 'ctx.fillStyle = "#000000";';
		echo 'ctx.font = "10px Arial";';
		echo 'ctx.textAlign="center";';
		echo 'ctx.fillText("' . $labelvalue . '",' . $coordinate . ',565);';
		
		//Increment label lab
		$labelvalue = $labelvalue+$labels;
		}

	//Label value for start of loop
	$tickvalue = $min;
	while ($tickvalue <= $max)
		{
		//Get y axis location
		$coordinate = coordinate("x",$min,$max,$tickvalue,$skip);
		
		//Draw tick
		begincanvaspath();
		echo 'ctx.fillStyle = "#000000";';
		echo 'ctx.moveTo(' . $coordinate . ',550);';
		echo 'ctx.lineTo(' . $coordinate . ',555);';
		echo 'ctx.stroke();';
		
		//Increment label lab
		$tickvalue = $tickvalue+$ticks;
		}
	}
//---FunctionBreak---
?>