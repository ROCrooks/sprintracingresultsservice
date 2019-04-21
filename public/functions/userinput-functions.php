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

	//Convert string to array if not already
	if (is_array($input) == false)
		{
		$output = "";
		$input = str_split($input);
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
	if ((isset($_POST[$inputname]) == true) AND (isset($_GET[$inputname]) == false))
		$input = $_POST[$inputname];
	if ((isset($_POST[$inputname]) == false) AND (isset($_GET[$inputname]) == true))
		$input = $_GET[$inputname];

	if (isset($input) == true)
		{
		//Check that the value is an allowed value
		if (isset($inputdetails['AllowedValues']) == true)
			{
			if (in_array($input,$inputdetails['AllowedValues']) == false)
				$input = "";
			}

		//Check that the character is in a whitelist
		if (isset($inputdetails['Whitelist']) == true)
			{
			if (is_array($inputdetails['Whitelist']) == false)
				$inputdetails['Whitelist'] = str_split($inputdetails['Whitelist']);

			$input = str_split($input);
			foreach($input as $inputkey=>$character)
				{
				if (in_array($character,$inputdetails['Whitelist']) == false)
					unset($input[$inputkey]);
				}
			$input = $implode($input);
			}

		//Check that the input is a specified type
		if (isset($inputdetails['Type']) == true)
			{
			if ($inputdetails['Type'] != gettype($input))
				$input = "";
			}
		}
	else
		$input = "";

	//Set a default value (if available) if the input value is blank
	if ((isset($inputdetails['Default']) == true) AND ($input == ""))
		$input = $inputdetails['Default'];

	Return $input;
	}
//---FunctionBreak---
?>
