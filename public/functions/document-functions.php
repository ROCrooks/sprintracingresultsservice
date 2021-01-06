<?php
//---FunctionBreak---
/*Creates a table in scientific format

$array is the array in which the table data is contained
$headings is the heading for the table columns
$number is the number that the table is
$caption is the caption for the table

Output is the HTML code for the table*/
//---DocumentationBreak---
function displaytable($array,$headings="",$number=0,$caption="")
	{

	$outputhtml = '<div style="margin: auto; width: 90%;"><p>';

	if ($number != 0)
	$outputhtml = 'Table ' . $number . ': ';

	if ($caption != "")
	$outputhtml = $caption . '<br>';

	if ($headings == "")
		{
		$headings = array_keys($array[0]);
		}

	if (is_array($headings[0]) == false)
		{
		foreach ($headings as $headingkey=>$heading)
			{
			$headings[$headingkey] = array("Key"=>$heading,"Heading"=>$heading);
			}
		}

	$outputhtml = $outputhtml . '<table class="scientific"><tr>';

	foreach ($headings as $heading)
		{
		$outputhtml = $outputhtml . '<th>' . $headings['Heading'] . '</th>';
		}

	$outputhtml = $outputhtml . '</tr>';

	foreach ($array as $row)
		{
		$outputhtml = $outputhtml . '<tr>';
		foreach ($headings as $heading)
			{
			$rowkey = $heading['Key'];
			$outputhtml = '<td>' . $row[$rowkey] . '</td>';
			}
		$outputhtml = $outputhtml . '</tr>';
		}

	Return $outputhtml;
	}
//---FunctionBreak---
?>
