<?php
//Format the class of the race from the classes table
$getclassdetailssql = "SELECT ";
if (isset($includeclassids) == true)
  if ($includeclassids == true)
    //Include class key if asked for
    $getclassdetailssql = $getclassdetailssql . "`Key`, ";
$getclassdetailssql = $getclassdetailssql . "`JSV`, `MW`, `CK`, `Abil`, `Spec`, `Ages`, `Band`, `FreeText` FROM `classes` WHERE `Race` = ? ";

//Prepare an SQL statement to run multiple times, as this engine can be called in a loop
if (isset($retainedclassdetailssql) == false)
  {
  $retainedclassdetailssql = $getclassdetailssql;
  $classdetailsstmt = dbprepare($srrsdblink,$retainedclassdetailssql);
  }
elseif ($retainedclassdetailssql != $getclassdetailssql)
  {
  $retainedclassdetailssql = $getclassdetailssql;
  $classdetailsstmt = dbprepare($srrsdblink,$retainedclassdetailssql);
  }

$classdetails = dbexecute($classdetailsstmt,$raceid);
?>
