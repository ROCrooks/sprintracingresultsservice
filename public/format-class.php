<?php
//Get class details from regatta database
//$getclassdetailssql = "SELECT `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText` FROM `classes` WHERE `Race` = ? ";
//mysqli_prepare();
//mysqli_stmt_bind_param();

$classdetails = array();
$classdetails[0] = array("JSV"=>"J","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"D","Ages"=>"","FreeText"=>"");

//Container to store boat types
$boattypesstore = "";

//Loop to create each individual class type
foreach($classdetails as $classkey=>$class)
  {
  //Define athlete type
  if (($class['JSV'] == "J") AND ($class['MW'] == "M"))
    $jsvmw = "Boys";
  elseif (($class['JSV'] == "J") AND ($class['MW'] == "W"))
    $jsvmw = "Girls";
  elseif ((($class['JSV'] == "S") AND ($class['MW'] == "M")) OR (($class['JSV'] == "") AND ($class['MW'] == "M")))
    $jsvmw = "Mens";
  elseif ((($class['JSV'] == "S") AND ($class['MW'] == "W")) OR (($class['JSV'] == "") AND ($class['MW'] == "W")))
    $jsvmw = "Womens";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == "M"))
    $jsvmw = "Mens Masters";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == "W"))
    $jsvmw = "Womens Masters";
  elseif (($class['JSV'] == "J") AND ($class['MW'] == ""))
    $jsvmw = "Junior";
  elseif (($class['JSV'] == "S") AND ($class['MW'] == ""))
    $jsvmw = "Senior";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == ""))
    $jsvmw = "Masters";
  elseif (($class['JSV'] == "J") AND ($class['MW'] == "MW"))
    $jsvmw = "Boys/Girls";
  elseif (($class['JSV'] == "S") AND ($class['MW'] == "MW"))
    $jsvmw = "Mens/Womens";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == "MW"))
    $jsvmw = "Mens/Womens Masters";
  else
    $jsvmw = "";

  //Name special type of race
  if ($class['Spec'] == "PC")
    $special = "Paracanoe";
  elseif ($class['Spec'] == "PD")
    $special = "Paddleability";
  elseif ($class['Spec'] == "IS")
    $special = "Inter-Services";
  elseif ($class['Spec'] == "LT")
    $special = "Mini-Kayak";
  else
    $special = "";

  //Classes for paracanoe
  if ($special == "Paracanoe")
    {
    
    }
  }
?>
