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
/*Fill the background with a particular colour

$colour is the specified colour*/
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
/*Make the Y axis of a plot

$title is the title of the axis
$labels is the location of labels
$ticks is the location of ticks*/
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
/*Creates the x axis on the plot

$title is the title of the axis
$labels is the location of labels
$ticks is the location of ticks*/
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

Function returns an array with the X and Y coordinates to draw the chart line*/
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

		$location = round($location*530);
		$location = 530-$location;
		$location = $location+20;
		$outputarray[$ykey]['Y'] = $location;
		}

	Return $outputarray;
	}
//---FunctionBreak---
/*Convert an X,Y array of coordinates into a line

$coordinates is the array of X and Y coordinates
$linecolour is the colour of the line
$position is the position of the line
$name is the name of the line (optional - default is the "line $position")

Function returns javascript for drawing the line*/
//---DocumentationBreak---
function drawpaddlertrendline($coordinates,$linecolour,$position,$name='')
	{
	//Define the name of
	if (($name == '') OR (is_string($name) == false))
		$name = "Line " . $position;

	//Begin canvas path
	$js = begincanvaspath();

	//Define line colour
	$js = $js . 'ctx.strokeStyle = "' . $linecolour . '";';
	$js = $js . 'ctx.lineWidth=3;';

	//Add each of the coordinates
	$started = false;
	foreach ($coordinates as $coordinate)
		{
		if ($started == false)
			{
			$js = $js . 'ctx.moveTo(' . $coordinate['X'] . ',' . $coordinate['Y'] . ');';
			$started = true;
			}
		else
			$js = $js . 'ctx.lineTo(' . $coordinate['X'] . ',' . $coordinate['Y'] . ');';
		}

	//Finish the line
	$js = $js . 'ctx.stroke();';
	$js = $js . 'ctx.restore();';

	//Define locations of key elements
	$locations = array();
	$locations[1] = array("LineStart"=>40,"LineStop"=>70,"TextStart"=>75);
	$locations[2] = array("LineStart"=>262,"LineStop"=>292,"TextStart"=>297);
	$locations[3] = array("LineStart"=>485,"LineStop"=>515,"TextStart"=>520);
	$locations[4] = array("LineStart"=>727,"LineStop"=>757,"TextStart"=>762);

	//Get location for this element of the legend
	$locations = $locations[$position];

	//Draw line
	$js = $js . begincanvaspath();
	$js = $js . 'ctx.strokeStyle = "' . $linecolour . '";';
	$js = $js . 'ctx.lineWidth=3;';
	$js = $js . 'ctx.moveTo(' . $locations['LineStart'] . ',610);';
	$js = $js . 'ctx.lineTo(' . $locations['LineStop'] . ',610);';
	$js = $js . 'ctx.stroke();';
	$js = $js . 'ctx.restore();';

	begincanvaspath();
	$js = $js . 'ctx.fillStyle = "#000000";';
	$js = $js . 'ctx.font = "15px Arial";';
	$js = $js . 'ctx.textAlign="left";';
	$js = $js . 'ctx.fillText("' . $name . '",' . $locations['TextStart'] . ',615);';

	Return $js;
	}
//---FunctionBreak---
?>
