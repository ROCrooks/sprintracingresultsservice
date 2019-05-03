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
?>
