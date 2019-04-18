<?php
$integers = array(3,17,8,2,4,5,18,15,55,"");
$fieldname = "Key";

//Sort and make unique
$integers = array_unique($integers);
sort($integers);

$inrange = false;
$constraints = array();
$integerskey = 0;
$end = count($integers);
while ($integerskey < $end)
  {
  if (is_int($integers[$integerskey]) == true)
    {
    //Define next number
    if (isset($integers[$integerskey+1]) == true)
      $nextno = $integers[$integerskey+1];
    else
      $nextno = "";

    if ($inrange == false)
      {
      //Open a range
      if ($nextno == $integers[$integerskey]+1)
        {
        $inrange = true;
        $constraint = "(`" . $fieldname . "` BETWEEN " . $integers[$integerskey] . " AND ";
        }
      else
        {
        $constraint = "`" . $fieldname . "` = " . $integers[$integerskey];
        array_push($constraints,$constraint);
        }
      }
    elseif ($inrange == true)
      {
      //Close a range
      if ($nextno != $integers[$integerskey]+1)
        {
        $constraint = $constraint . $integers[$integerskey] . ")";
        array_push($constraints,$constraint);
        $inrange = false;
        }
      }
    }
  $integerskey++;
  }

$constraints = "(" . implode(" OR ",$constraints) . ")";
echo $constraints . "<br>";
?>
