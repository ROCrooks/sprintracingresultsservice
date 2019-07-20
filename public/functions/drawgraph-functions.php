<?php
//---FunctionBreak---
/*Begin an HTML canvas path*/
//---DocumentationBreak---
function begincanvaspath()
	{
	$js = 'ctx.save();';
	$js = $js . 'ctx.beginPath();';
	Return $js;
	}
//---FunctionBreak---
/*Fill the background with a particular colour*/
//---DocumentationBreak---
function fillgraphbackground($colour)
	{
	//Begin path and save, required before any canvas scripting code
	$js = begincanvaspath();

	//Draw a rectangular background on the colour
	$js = $js . 'ctx.fillStyle = "' . $colour . '";';
	$js = $js . 'ctx.fillRect(0,0,950,650);';
	Return $js;
	}
//---FunctionBreak---
/*Make the Y axis of a plot*/
//---DocumentationBreak---
function yaxis($title,$labels,$ticks)
	{
	$js = begincanvaspath();
	//Echo axis title
	$js = $js . 'ctx.save();';
	$js = $js . 'ctx.translate(12,300);';
	$js = $js . 'ctx.rotate(-90 * Math.PI / 180);';
	$js = $js . 'ctx.fillStyle = "#000000";';
	$js = $js . 'ctx.font = "15px Arial";';
	$js = $js . 'ctx.textAlign="center";';
	$js = $js . 'ctx.fillText("' . $title . '",0,0);';
	$js = $js . 'ctx.restore();';

	$js = $js . begincanvaspath();
	//Draw axis line
	$js = $js . 'ctx.moveTo(40,20);';
	$js = $js . 'ctx.lineTo(40,550);';
	$js = $js . 'ctx.stroke();';

	//Work out increment of label positions
	$labelspaces = 530/(count($labels)-1);

	//Write labels
	$labelstartposition = 550;
	foreach ($labels as $label)
		{
		//Get y axis location
		$coordinate = round($labelstartposition);
		$coordinate = $coordinate+4;

		//Write label
		$js = $js . begincanvaspath();
		$js = $js . 'ctx.fillStyle = "#000000";';
		$js = $js . 'ctx.font = "10px Arial";';
		$js = $js . 'ctx.textAlign="end";';
		$js = $js . 'ctx.fillText("' . $label . '",30,' . $coordinate . ');';

		//Increment label lab
		$labelstartposition = $labelstartposition-$labelspaces;
		}

	//Work out increment of tick positions
	$tickspaces = 530/(count($ticks)-1);

	//Write ticks
	$tickstartposition = 550;
	foreach ($ticks as $tick)
		{
		//Get y axis location
		$coordinate = round($tickstartposition);

		//Draw tick
		$js = $js . begincanvaspath();
		$js = $js . 'ctx.fillStyle = "#000000";';
		$js = $js . 'ctx.moveTo(40,' . $coordinate . ');';
		$js = $js . 'ctx.lineTo(35,' . $coordinate . ');';
		$js = $js . 'ctx.stroke();';

		//Increment label lab
		$tickstartposition = $tickstartposition-$tickspaces;
		}

	Return $js;
	}
//---FunctionBreak---
/**/
//---DocumentationBreak---
function xaxis($title,$labels,$ticks)
	{
	//Echo axis title
	$js = begincanvaspath();
	$js = $js . 'ctx.save();';
	$js = $js . 'ctx.fillStyle = "#000000";';
	$js = $js . 'ctx.font = "15px Arial";';
	$js = $js . 'ctx.textAlign="center";';
	$js = $js . 'ctx.fillText("' . $title . '",475,590);';
	$js = $js . 'ctx.restore();';

	//Draw axis line
	$js = $js . begincanvaspath();
	$js = $js . 'ctx.moveTo(910,550);';
	$js = $js . 'ctx.lineTo(40,550);';
	$js = $js . 'ctx.stroke();';

	//Work out increment of label positions
	$labelspaces = 870/(count($labels)-1);

	//Write labels
	$labelstartposition = 40;
	foreach ($labels as $label)
		{
		//Get y axis location
		$coordinate = round($labelstartposition);

		//Write label
		$js = $js . begincanvaspath();
		$js = $js . 'ctx.fillStyle = "#000000";';
		$js = $js . 'ctx.font = "10px Arial";';
		$js = $js . 'ctx.textAlign="center";';
		$js = $js . 'ctx.fillText("' . $label . '",' . $coordinate . ',565);';

		//Increment label lab
		$labelstartposition = $labelstartposition+$labelspaces;
		}

	//Work out increment of tick positions
	$tickspaces = 870/(count($ticks)-1);

	//Write ticks
	$tickstartposition = 40;
	foreach ($ticks as $tick)
		{
		//Get y axis location
		$coordinate = round($tickstartposition);

		//Draw tick
		$js = $js . begincanvaspath();
		$js = $js . 'ctx.fillStyle = "#000000";';
		$js = $js . 'ctx.moveTo(' . $coordinate . ',550);';
		$js = $js . 'ctx.lineTo(' . $coordinate . ',555);';
		$js = $js . 'ctx.stroke();';

		//Increment label lab
		$tickstartposition = $tickstartposition+$tickspaces;
		}

	Return $js;
	}
//---FunctionBreak---
/*Convert and X and Y array to coordinates

$x is the array of X values
$y is the array of Y values
$minx is the minimum X value on the scale
$maxx is the maximum X value on the scale
$miny is the minimum Y value on the scale
$maxy is the maximum Y value on the scale

This function is to be updated*/
//---DocumentationBreak---
function makecoordinates($x,$y,$minx,$maxx,$miny,$maxy)
	{
	$outputarray = array();

	//Make X coordinates
	foreach ($x as $xkey=>$value)
		{
		$numerator = $value-$minx;
		$denominator = $maxx-$minx;
		$location = $numerator/$denominator;
		$location = round($location*870);
		$location = $location+40;
		$outputarray[$xkey]['X'] = $location;
		}

	//Make Y coordinates
	foreach ($y as $ykey=>$value)
		{
		$numerator = $value-$miny;
		$denominator = $maxy-$miny;
		$location = $numerator/$denominator;
		
		echo $location . "<br>";
		$location = round($location*530);
		$location = 530-$location;
		$location = $location+20;
		$outputarray[$ykey]['Y'] = $location;
		}

	Return $outputarray;
	}
//---FunctionBreak---
/*Draw a graph on an HTML canvas

$array is the array with the data
$xvalue is
$yvalue is
$colour is the colour to draw the line
$graphdetails is an array with details about the graph
$lineno is the number of the line of the graph, used to decide the position of the key

This function is to be updated*/
//---DocumentationBreak---
/*
function plotline($array,$name,$colour,$graphdetails,$lineno)
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
			$x = $line['X'];
			$y = $line['Y'];

			//X and Y coordinates
			$xcoordinate = normalise($x,$graphdetails['MinX'],$graphdetails['MaxX']);
			$ycoordinate = normalise($y,$graphdetails['MinY'],$graphdetails['MaxY']);
			$xcoordinate = $xcoordinate*;
			$ycoordinate = normalise($y,$graphdetails['MinY'],$graphdetails['MaxY']);

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
*/
//---FunctionBreak---
/**/
//---DocumentationBreak---
/*
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
*/
//---FunctionBreak---
?>
