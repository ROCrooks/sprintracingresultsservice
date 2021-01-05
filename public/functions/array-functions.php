<?php
//---FunctionBreak---
/*Returns an array with only values found in all arrays

$wholearray is an array of arrays

Output is an array containing only values that are found in all arrays*/
//---DocumentationBreak---
function arrayinall($wholearray)
  {
  //Remove an array from the list of arrays
  $basearray = array_pop($wholearray);

  //Check each other array
  foreach ($wholearray as $checkarray)
    {
    $roundarray = array();
    foreach ($basearray as $value)
      {
      //Only include value if it is found in multiple arrays
      if (in_array($value,$checkarray) == true)
        array_push($roundarray,$value);
      }
    //Replace the base array with an array containing only those values found in each other array
    $basearray = $roundarray;
    }

  Return $basearray;
  }
//---FunctionBreak---
/*Fills blank values in an array with an empty ''

$array is the array to fill in blanks
$keys is the list of keys which need blank values set
$blanks is the optional default value, default is ''
*/
//---DocumentationBreak---
function createblanksinarray($array,$keys,$blank="")
  {
  //Look up each key
  foreach($keys as $key)
    {
    //Set defaults
    if (isset($array[$key]) === false)
      $array[$key] = $blank;
    }

  //Return array
  return $array;
  }
//---FunctionBreak---
/*Creates a table array that can be turned directly into HTML

$array is the array to produce the table from
$params (optional) is the parameters used to decide which table to build
$fields is the array fields to retrieve and in which order
$headings (optional) is optional headings to replace the field names

Output is an array that can be turned directly into a table*/
//---DocumentationBreak---
function arraytotable($array,$fields,$params=false,$headings=false)
  {
  //Set headings to array fields if not specified
  if ($headings === false)
    $headings = $fields;

  //Create default parameters
  if ($params == false)
    $params = array();
  //Add a column with a row number and make the top left cell empty
  if (isset($params['NumberedRows']) == false)
    $params['NumberedRows'] = false;
  //Display the column headings or not
  if (isset($params['Headings']) == false)
    $params['Headings'] = false;
  //Make the first column a row heading with no column heading
  if ((isset($params['FirstRow']) == false) AND ($params['NumberedRows'] == false))
    $params['FirstRow'] = false;
  elseif ($params['NumberedRows'] == true)
    $params['FirstRow'] = true;

  //Create table array
  $tablearray = array();

  //Create row number counter
  if ($params['NumberedRows'] == true)
    $rownumber = 1;

  //Create header row if needed
  if ($params['Headings'] == true)
    {
    $row = array();

    //Add the empty top left cell if needed
    if($params['FirstRow'] == true)
      array_push($row,"");

    $row = array_merge($row,$headings);
    array_push($tablearray,$row);
    }

  foreach($array as $readrow)
    {
    //Create output array line
    $outputrow = array();

    //Create first numbered row
    if($params['NumberedRows'] == true)
      {
      array_push($outputrow,$rownumber);
      $rownumber++;
      }

    //Retrieve each requested field
    foreach($fields as $field)
      {

      if (isset($readrow[$field]) == true)
        $cell = $readrow[$field];
      //Default to an empty cell if not found
      else
        $cell = "";

      //Add cell to row
      array_push($outputrow,$cell);
      }

    //Add row to output array
    array_push($tablearray,$outputrow);
    }

  //Return array
  return $tablearray;
  }
//---FunctionBreak---
/*Converts and array table directly into HTML

$array is the array to produce the table from
$number (optional) is the number of the table in the document
$caption (optional) is the table caption
$heading (optional) is if the table contains a heading

Output is the HTML for the table in scientific format*/
//---DocumentationBreak---
function scientifictable($array,$number=false,$caption=false,$heading=true)
  {
  //Container for the HTML
  $tablehtml = array();

  foreach($array as $arrayrow)
    {
    //Make table heading
    if ($heading == true)
      {
      $arrayrow = "<th>" . implode("</th><th>",$arrayrow) . "</th>";
      $heading = false;
      }
    else
      $arrayrow = "<td>" . implode("</td><td>",$arrayrow) . "</td>";

    //Add array row to the HTML
    array_push($tablehtml,$arrayrow);
    }

  //Make HTML table
  $tablehtml = '<table class="scientific"><tr>' . implode("</tr><tr>",$tablehtml) . '</tr></table>';

  //Make table number HTML
  $tablecaptionhtml = "";
  if ($number != false)
    {
    //Add the table number
    $tablecaptionhtml = $tablecaptionhtml . "Table " . $number;

    //Add colon to join to caption if caption also specified
    if ($caption != false)
      $tablecaptionhtml = $tablecaptionhtml . ":";
    }

  //Make Table caption HTML
  if ($caption != false)
    $tablecaptionhtml = $tablecaptionhtml . $caption;

  //Place the line break after the table caption
  if ($tablecaptionhtml != "")
    $tablecaptionhtml = $tablecaptionhtml . '<br>';

  //Wrap 
  $html = '<div style="margin: auto; width: 90%;"><p>' . $tablecaptionhtml . $tablehtml . '</p></div>';
  return($html);
  }
//---FunctionBreak---
?>
