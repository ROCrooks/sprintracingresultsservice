<?php
include_once 'required-functions.php';

//Standard that all texts have
$classsql = "SELECT DISTINCT `Race` FROM `classes`";

//Format user inputs into array for generating match query
$classcodes = array();
if ($jsv != "")
  $classcodes['JSV'] = $jsv;
else
  $classcodes['JSV'] = "*";
if ($mw != "")
  $classcodes['MW'] = $mw;
else
  $classcodes['MW'] = "*";
if ($ck != "")
  $classcodes['CK'] = $ck;
else
  $classcodes['CK'] = "*";

if ($spec != "")
  $classcodes['Spec'] = $spec;
else
  $classcodes['Spec'] = "";

if ($abil != "")
  $classcodes['Abil'] = $abil;
else
  $classcodes['Abil'] = "*";

if ($ages != "")
  $classcodes['Ages'] = $ages;
else
  $classcodes['Ages'] = "*";

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

//Prepare an SQL statement to run multiple times, as this engine can be called in a loop
if (isset($retainedsql) == false)
  {
  $retainedsql = $classsql;
  $classstmt = dbprepare($srrsdblink,$retainedsql);
  }
elseif ($retainedsql != $classsql)
  {
  $retainedsql = $classsql;
  $classstmt = dbprepare($srrsdblink,$retainedsql);
  }

//Get race IDs for races with these classes
$getids = dbexecute($classstmt,$classesconstraintvalues);
$classraceids = resulttocolumn($getids,"Race");
?>
