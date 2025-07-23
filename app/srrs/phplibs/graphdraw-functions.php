<?php
//---FunctionBreak---
/*Has no arguments, but begins a path on HTML canvas drawing with javascript*/
//---DocumentationBreak---
function begincanvaspath()
	{
	echo 'ctx.save();';
	echo 'ctx.beginPath();';
	}
//---FunctionBreak---
/*Sets the background colour of a graph.

$colour is the colour to use for the background*/
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
/*Draw a yaxis on an HTML canvas.

$title is the title of the axis
$min is the minimum value of the axis
$max is the maximum value of the axis
$labels is the gap between labels on the axis
$ticks is the gap between ticks
$skip Defaults to false. If set includes a skip in the axis

In future, an array to broadcast the axis parameters should be used to allow different labels and values (eg seconds and display times). Work on this.*/
//---DocumentationBreak---
function yaxis($title,$min,$max,$labels,$ticks,$skip=false)
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
/*Draw a xaxis on an HTML canvas.

$title is the title of the axis
$min is the minimum value of the axis
$max is the maximum value of the axis
$labels is the gap between labels on the axis
$ticks is the gap between ticks
$skip Defaults to false. If set includes a skip in the axis

In future, an array to broadcast the axis parameters should be used to allow different labels and values (eg seconds and display times). Work on this.*/
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