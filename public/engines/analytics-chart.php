<?php
include 'required-functions.php';

$data = array();
$data[0] = array("Year"=>2010,"Y1"=>70);
$data[1] = array("Year"=>2011,"Y1"=>80);
$data[2] = array("Year"=>2012,"Y1"=>80);
$data[3] = array("Year"=>2013,"Y1"=>105);
$data[4] = array("Year"=>2014,"Y1"=>60);

$dataoppositeorientation = array();
//Get the range of X and Y values
$xmin = INF;
$xmax = -INF;
$ymax = -INF;
foreach ($data as $linekey=>$dataline)
	{
	//Make array in the opposite orientation for display
	foreach ($dataline as $rowname=>$datavalue)
		{
		$dataoppositeorientation[$rowname][$linekey] = $datavalue;
		}

	//The maximum x value
	if ($dataline['Year'] > $xmax)
		$xmax = $dataline['Year'];
	//The maximum y value
	if ($dataline['Year'] < $xmin)
		$xmin = $dataline['Year'];
	unset($dataline['Year']);

	//The maximum y value
	$ysetmax = max($dataline);
	if ($ysetmax > $ymax)
		{
		$ymax = $ysetmax;
		}
	}
$ymin = 0;

$xlabels = array();
$xticks = array();
$yearpush = $xmin;
while ($yearpush <= $xmax)
	{
	array_push($xlabels,$yearpush);
	array_push($xticks,$yearpush);
	$yearpush++;
	}

//Get the range that the y axis should be
$logrange = log10($ymax);
$magnitude = ceil($logrange);
$numbers = 10**$magnitude;
$singlenumber = $ymax/$numbers;
//Create locations of y axis labels and ticks
$ylabels = array();
$yticks = array();
$labelnumber = 0.0;
array_push($yticks,$labelnumber*(10**$magnitude));
array_push($ylabels,$labelnumber*(10**$magnitude));
while ($labelnumber <= $singlenumber)
	{
	$labelnumber = $labelnumber+0.05;
	array_push($yticks,$labelnumber*(10**$magnitude));
	$labelnumber = $labelnumber+0.05;
	array_push($yticks,$labelnumber*(10**$magnitude));
	array_push($ylabels,$labelnumber*(10**$magnitude));
	$ymax = $labelnumber*(10**$magnitude);
	}

$linecoordinates = makecoordinates($dataoppositeorientation['Year'],$dataoppositeorientation['Y1'],$xmin,$xmax,$ymin,$ymax);
$linejs = drawpaddlertrendline($linecoordinates,"#000000",1,"Test");

//Create javascript
$js = 'var canvas = document.getElementById("SRRSChart");';
$js = $js . 'var ctx = canvas.getContext("2d");';

$js = $js . fillgraphbackground("#FFFFFF");

$js = $js . yaxis("Paddlers",$ylabels,$yticks);

$js = $js . xaxis("Year",$xlabels,$xticks);

$js = $js . $linejs;

//Encapsulate JS into script tag
$js = '<script>' . $js . '</script>';

//Create canvas
$canvas = '<canvas id="SRRSChart" width="950" height="650"></canvas>';

echo "<p>Hello World</p>";

echo $canvas;

echo $js;

/*
//Generate Y axis
function maxyaxis($maxvalue)
	{
	//Get log to base 10 of axis, round up
	$logmaxvalue = log10($maxvalue);
	$ceilinglogmaxvalue = ceil($logmaxvalue);

	//Minus 1, to reduce the order of magnitude and calculate to nearest significant figure
	$logminus1 = $ceilinglogmaxvalue-1;
	$magnitude = 10**$logminus1;

	//Divide max value by magnitude to get number between 1 and 10 round up to nearest integer
	$maxoriginalrange = $maxvalue/$magnitude;
	$ceilingoforiginal = ceil($maxoriginalrange);

	//Multiply ceiling by magnitude, return
	$axistop = $ceilingoforiginal*$magnitude;
	Return $axistop;
	}

//Make dividers for y axis
function yaxisnumbers($range)
	{
	//Get Log10 of range
	$logrange = log10($range);

	//Roundup then minus 1 - different to round down in the case of 10, 100, 1000 etc
	$roundlog = ceil($logrange);
	$magnitude = $roundlog-1;

	//Get initial numbers and ticks
	$numbers = 10**$magnitude;
	$dividers = $numbers/2;

	//Output
	$output = array("Numbers"=>$numbers,"Ticks"=>$dividers);

	//Output result
	Return $output;
	}
*/
?>
