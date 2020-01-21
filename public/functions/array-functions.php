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
?>
