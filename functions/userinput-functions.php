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
?>
