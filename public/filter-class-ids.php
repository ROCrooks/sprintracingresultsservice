<?php
include_once 'required-functions.php';

$jsv = "J";
$mw = "M";
$ck = "K";
$abil = "B";

//Standard that all texts have
$classsql = "SELECT DISTINCT `Race` FROM `classes`";

$classcodes = array();
if (isset($jsv) == true)
  $classcodes['JSV'] = $jsv;
else
  $classcodes['JSV'] = "*";
if (isset($mw) == true)
  $classcodes['MW'] = $mw;
else
  $classcodes['MW'] = "*";
if (isset($ck) == true)
  $classcodes['CK'] = $ck;
else
  $classcodes['CK'] = "*";

if (isset($spec) == true)
  $classcodes['Spec'] = $spec;
else
  $classcodes['Spec'] = "";

if (isset($abil) == true)
  $classcodes['Abil'] = $abil;
else
  $classcodes['Abil'] = "*";

if (isset($ages) == true)
  $classcodes['Ages'] = $ages;
else
  $classcodes['Ages'] = $classcodes['Ages'] = "*";

//Construct values and constraints
$constrainttext = array();
$constraintvalues = array();
foreach ($classcodes as $field=>$class)
  {
  if ($class == "")
    {
    //An explicitly blank value
    $class = "";
    $field = "`" . $field . "` = ?";
    }
  else
    {
    //Make generic class
    if ($class == "*")
      $class = "";

    $class = "%" . $class . "%";
    $field = "`" . $field . "` = ?";
    }

  //Put to constraint arrays
  array_push($constrainttext,$class);
  array_push($constraintvalues,$field);
  }

if (count($constrainttext) > 0)
  {
  
  }
?>
