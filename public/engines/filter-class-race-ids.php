<?php
include_once 'required-functions.php';

//Standard that all texts have
$classsql = "SELECT DISTINCT `Race` FROM `classes`";

//Format user inputs into array for generating match query
$classcodes = array();
if ($jsv != "")
  $classcodes['JSV'] = $classjsv;
else
  $classcodes['JSV'] = "*";
if ($mw != "")
  $classcodes['MW'] = $classmw;
else
  $classcodes['MW'] = "*";
if ($ck != "")
  $classcodes['CK'] = $classck;
else
  $classcodes['CK'] = "*";

if ($spec != "")
  $classcodes['Spec'] = $classspec;
else
  $classcodes['Spec'] = "";

if ($abil != "")
  $classcodes['Abil'] = $classabil;
else
  $classcodes['Abil'] = "*";

if ($ages != "")
  $classcodes['Ages'] = $classages;
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
if (isset($retainedclassfiltersql) == false)
  {
  $retainedclassfiltersql = $classsql;
  $classfilterstmt = dbprepare($srrsdblink,$retainedclassfiltersql);
  }
elseif ($retainedclassfiltersql != $classsql)
  {
  $retainedclassfiltersql = $classsql;
  $classfilterstmt = dbprepare($srrsdblink,$retainedclassfiltersql);
  }

//Get race IDs for races with these classes
$getids = dbexecute($classfilterstmt,$classesconstraintvalues);
$classraceids = resulttocolumn($getids,"Race");
?>
