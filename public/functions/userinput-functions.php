<?php
//---FunctionBreak---
/*Only allows legal characters in a string and returns a string that removes illegal characters.

$input is the input string
$legals is the list of allowed characters

Output is the input minus any characters not included in the legals string*/
//---DocumentationBreak---
function legalcharactersonly($input,$legals)
	{
	//Split legals into array if it is not an array
	if (is_array($legals) == false)
		$legals = str_split($legals);

	//If originally an array
	$originarray = false;

	//Convert string to array if not already
	if (is_array($input) == false)
		{
		$output = "";
		$input = str_split($input);
		$originarray = true;
		}
	else
		$output = array();

	//Loop through each character
	foreach($input as $inputkey=>$character)
		{
		//Unset character if it is not found in the legals array
		if (in_array($character,$legals) == false)
			{
			unset($input[$inputkey]);
			}
		}

	//Convert back to string and return
	$input = implode("",$input);
	Return $input;
	}
//---FunctionBreak---
/*Takes a piece of text and standardises the new line format to ensure compatibility between Windows and Android origin input

$text is the text to standardise lines of

Output is an array with standard new lines.*/
//---DocumentationBreak---
function standardisenewlines($text)
	{
	//
	$text = str_replace("\r","\n",$text);
	$replaced = 1;

	//Replace all double new lines and replace with singles until no more new lines are found
	while ($replaced > 0)
		{
		$text = str_replace("\n\n","\n",$text,$replaced);
		}

	//Remove new line tags from start and end if found
	if (substr($text,0,2) == "\n")
		$text = substr($text,2);
	if (substr($text,-2) == "\n")
		$text = substr($text,0,-2);

	Return $text;
	}
//---FunctionBreak---
/*Takes a piece of text and standardises the new line format to ensure compatibility between Windows and Android origin input

$text is the text to standardise lines of

Output is an array with standard new lines.*/
//---DocumentationBreak---
function getandprocessinput($inputname,$inputdetails=array())
	{
	//Get input from either POST or GET
	if ((isset($_POST[$inputname]) == true) AND (isset($_GET[$inputname]) == false) AND (isset($_SESSION[$inputname]) == false))
		$input = $_POST[$inputname];
	if ((isset($_POST[$inputname]) == false) AND (isset($_GET[$inputname]) == true) AND (isset($_SESSION[$inputname]) == false))
		$input = $_GET[$inputname];
	if ((isset($_POST[$inputname]) == false) AND (isset($_GET[$inputname]) == false) AND (isset($_SESSION[$inputname]) == true))
		$input = $_SESSION[$inputname];

	//Only process input if it is
	if (isset($input) == true)
		{
		//Check that the value of the input is allowed
		if (isset($inputdetails['AllowedValues']) == true)
			{
			if(in_array($input,$inputdetails['AllowedValues']) == false)
				$input = "";
			}

		//Check that the input contains only values in the Whitelist
		if (isset($inputdetails['WhiteList']) == true)
			{
			//Convert input and whitelist to arrays
			if (is_array($inputdetails['WhiteList']) == false)
				$inputdetails['WhiteList'] = strsplit($inputdetails['WhiteList']);
			if (is_array($input) == false)
				$input = strsplit($input);

			//Check each value against whitelist and put into input variable
			$inputvalues = $input;
			$input = "";
			foreach ($inputvalues as $value)
				{
				if (in_array($value,$inputdetails['WhiteList']) == true)
					$input = $input . $value;
				}
			}
		}
	else
		$input = false;

	Return $input;
	}
//---FunctionBreak---
?>
