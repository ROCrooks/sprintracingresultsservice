<?php
//Get class details from regatta database
//$getclassdetailssql = "SELECT `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText` FROM `classes` WHERE `Race` = ? ";
//mysqli_prepare();
//mysqli_stmt_bind_param();

$classdetails = array();
$classdetails[0] = array("JSV"=>"J","MW"=>"M","CK"=>"C","Spec"=>"","Abil"=>"D","Ages"=>"","FreeText"=>"");

//Container to store boat types
$boattypesstore = "";

//Loop to create each individual class type
foreach($classdetails as $classkey=>$class)
  {
  $namewords = array();

  //Define athlete type
  if (($class['JSV'] == "J") AND ($class['MW'] == "M"))
    $namewords['JSVMW'] = "Boys";
  elseif (($class['JSV'] == "J") AND ($class['MW'] == "W"))
    $namewords['JSVMW'] = "Girls";
  elseif ((($class['JSV'] == "S") AND ($class['MW'] == "M")) OR (($class['JSV'] == "") AND ($class['MW'] == "M")))
    $namewords['JSVMW'] = "Mens";
  elseif ((($class['JSV'] == "S") AND ($class['MW'] == "W")) OR (($class['JSV'] == "") AND ($class['MW'] == "W")))
    $namewords['JSVMW'] = "Womens";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == "M"))
    $namewords['JSVMW'] = "Mens Masters";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == "W"))
    $namewords['JSVMW'] = "Womens Masters";
  elseif (($class['JSV'] == "J") AND ($class['MW'] == ""))
    $namewords['JSVMW'] = "Junior";
  elseif (($class['JSV'] == "S") AND ($class['MW'] == ""))
    $namewords['JSVMW'] = "Senior";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == ""))
    $namewords['JSVMW'] = "Masters";
  elseif (($class['JSV'] == "J") AND ($class['MW'] == "MW"))
    $namewords['JSVMW'] = "Boys/Girls";
  elseif (($class['JSV'] == "S") AND ($class['MW'] == "MW"))
    $namewords['JSVMW'] = "Mens/Womens";
  elseif (($class['JSV'] == "V") AND ($class['MW'] == "MW"))
    $namewords['JSVMW'] = "Mens/Womens Masters";
  else
    $namewords['JSVMW'] = $jsvmw = "";

  //Name special type of race
  if ($class['Spec'] == "PC")
    $namewords['Special'] = "Paracanoe";
  elseif ($class['Spec'] == "PD")
    $namewords['Special'] = "Paddleability";
  elseif ($class['Spec'] == "IS")
    $namewords['Special'] = "Inter-Services";
  elseif ($class['Spec'] == "LT")
    $namewords['Special'] = "Mini-Kayak";
  elseif ($class['CK'] == "C")
    $namewords['Special'] = "Canoe";
  else
    $namewords['Special'] = "";

  //Classes for paracanoe
  if ($namewords['Special'] == "Paracanoe")
    {
    //Format class name
    $boattypeinband = true;
    if (($class['Abil'] == "LTA") OR ($class['Abil'] == "TA") OR ($class['Abil'] == "A"))
      {
      $namewords['Band'] = $class['Abil'];
      //LTA class doesn't have the boat name
      $boattypeinband = false;
      }
    //Numerical paracanoe classes
    elseif (($class['Abil'] == "123") OR ($class['Abil'] == "123"))
      $namewords['Band'] = "1-3";
    elseif ($class['Abil'] == "23")
      $namewords['Band'] = "2+3";
    elseif ($class['Abil'] == "12")
      $namewords['Band'] = "1+2";
    elseif (($class['Abil'] == "1") OR ($class['Abil'] == "2") OR ($class['Abil'] == "3"))
      $namewords['Band'] = $class['Abil'];

    //VL or KL depending on if kayak or va'a
    if ($boattypeinband == true)
      {
      $namewords['Band'] = $class['CK'] . "L" . $namewords['Band'];
      }
    }
  //Non paracanoe ability bands
  else
    {
    if ($class['Abil'] == "O")
      $namewords['Band'] = "Open";
    else
      {
      $namewords['Band'] = $class['Abil'];
      $namewords['Band'] = str_split($namewords['Band']);
      $namewords['Band'] = implode("/",$namewords['Band']);
      }
    }

  //Put a tag in place of the boat
  if ($class['CK'] == "K")
    {
    $namewords['Boat'] = "<Kayak>";
    $boattypesstore = $boattypesstore . "K";
    }
  elseif ($class['CK'] == "C")
    {
    $namewords['Boat'] = "<Canoe>";
    $boattypesstore = $boattypesstore . "C";
    }
  elseif ($class['CK'] == "V")
    {
    $namewords['Boat'] = "<Vaa>";
    $boattypesstore = $boattypesstore . "V";
    }
  else
    $namewords['Boat'] = "";

  print_r($namewords);
  }
?>
