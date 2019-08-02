<?php
include 'required-functions.php';

$data = array();
$data[0] = array("Year"=>2010,"Y1"=>70,"Y2"=>84);
$data[1] = array("Year"=>2011,"Y1"=>80,"Y2"=>36);
$data[2] = array("Year"=>2012,"Y1"=>80,"Y2"=>94);
$data[3] = array("Year"=>2013,"Y1"=>105,"Y2"=>64);
$data[4] = array("Year"=>2014,"Y1"=>60,"Y2"=>34);

//Get an array with all the individual line names
$linekeys = array_keys($analyticsresults[0]);

//Array of line colours
$linecolours = array();
$linecolours[1] = "#000000";
$linecolours[2] = "#FF0000";
$linecolours[3] = "#00FF00";
$linecolours[4] = "#0000FF";

//Array of line titles
$linetitles = array();
$linetitles['Y1'] = "Year 1";

$dataoppositeorientation = array();
//Get the range of X and Y values
$xmin = INF;
$xmax = -INF;
$ymax = -INF;
foreach ($analyticsresults as $linekey=>$dataline)
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

//Create lines
$linesjs = array();
foreach($linekeys as $linekey=>$linefield)
	{
	if ($linefield != "Year")
		{
		//Get the line title
		if (isset($linetitles[$linefield]) == true)
			$linetitle = $linetitles[$linefield];
		else
			$linetitle = $linefield;

		//Format single line
		$linecoordinates = makecoordinates($dataoppositeorientation['Year'],$dataoppositeorientation[$linefield],$xmin,$xmax,$ymin,$ymax);
		$linejs = drawpaddlertrendline($linecoordinates,$linecolours[$linekey],$linekey,$linetitle);
		array_push($linesjs,$linejs);
		}
	}
$linesjs = implode("",$linesjs);

//Create javascript
$js = 'var canvas = document.getElementById("SRRSChart");';
$js = $js . 'var ctx = canvas.getContext("2d");';

$js = $js . fillgraphbackground("#FFFFFF");

$js = $js . yaxis("Paddlers",$ylabels,$yticks);

$js = $js . xaxis("Year",$xlabels,$xticks);

$js = $js . $linesjs;

//Encapsulate JS into script tag
$js = '<script>' . $js . '</script>';

//Create canvas
$canvas = '<canvas id="SRRSChart" width="950" height="650"></canvas>';

//Returns $canvas and $js containing the HTML canvas and the Javascript respectively
?>
