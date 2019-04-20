<?php
include_once 'required-functions.php';

$jsv = "J";
$mw = "M";
$ck = "K";
$abil = "";

//Standard that all texts have
$classsql = "SELECT DISTINCT `Race` FROM `classes`";

//Format user inputs into array for generating match query
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
$classesconstrainttext = array();
$classesconstraintvalues = array();
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
    $field = "`" . $field . "` LIKE ?";
    }

  //Put to constraint arrays
  array_push($classesconstrainttext,$field);
  array_push($classesconstraintvalues,$class);
  }

//Turn the constraint fields into an SQL
if (count($classesconstrainttext) > 0)
  {
  $classesconstraintsqltext = implode(" AND ",$classesconstrainttext);
  }

if (isset($classesconstraintsqltext) == true)
  {
  $classsql = $classsql . "WHERE " . $classesconstraintsqltext;
  }

//Get race IDs for races with these classes
$getids = dbprepareandexecute($srrsdblink,$classsql,$classesconstraintvalues);
$classraceids = resulttocolumn($getids,"Race");
?>
