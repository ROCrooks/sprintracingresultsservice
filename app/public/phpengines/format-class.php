<?php
include_once $engineslocation . 'srrs-required-functions.php';

if (isset($boatsize) == false)
  $boatsize = "*";

//Container to store boat types
$boattypesstore = array();
$classnames = array();

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
  elseif ($class['CK'] == "T")
    $namewords['Special'] = "Touring Canoe";
  elseif ($class['CK'] == "P")
    $namewords['Special'] = "SUP";
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

    if (isset($namewords['Band']) == false)
      $namewords['Band'] = '';

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
    elseif ($class['Abil'] == "I")
      $namewords['Band'] = "Intermediate";
    else
      {
      $namewords['Band'] = $class['Abil'];
      $namewords['Band'] = str_split($namewords['Band']);
      $namewords['Band'] = implode("/",$namewords['Band']);
      }
    }

  //Process the ages of paddlers
  $namewords['Ages'] = str_split($class['Ages'],3);
  foreach($namewords['Ages'] as $ageskey=>$age)
    {
    //Format codes into long names
    if (substr($age,0,1) == "U")
      $age = str_replace("U","Under ",$age);
    elseif (substr($age,0,1) == "O")
      $age = str_replace("O","Over ",$age);
    else
      {
      $short = array("JUN","SEN","VET");
      $long = array("Junior","Senior","Veteran");
      $age = str_replace($short,$long,$age);
      }

    $namewords['Ages'][$ageskey] = $age;
    }
  $namewords['Ages'] = implode("/",$namewords['Ages']);

  $namewords['FreeText'] = $class['FreeText'];

  //Specify boat type
  if ($class['CK'] == "K")
    {
    $namewords['Boat'] = "K" . $boatsize;
    }
  elseif ($class['CK'] == "C")
    {
    $namewords['Boat'] = "C" . $boatsize;
    }
  elseif ($class['CK'] == "V")
    {
    $namewords['Boat'] = "V" . $boatsize;
    }
  elseif ($class['CK'] == "T")
    {
    $namewords['Boat'] = "TC" . $boatsize;
    }
  elseif ($class['CK'] == "P")
    {
    $namewords['Boat'] = "SUP";
    }
  elseif ($class['CK'] == "")
    $namewords['Boat'] = "";
  array_push($boattypesstore,$namewords['Boat']);

  //Create class name by putting words together
  $classname = "";
  foreach($namewords as $wordkey=>$word)
    {
    if ($word != "")
      {
      //Remove if it has already been included
      if (strpos($classname,$word) !== false)
        unset($namewords[$wordkey]);
      else
        $classname = $classname . $word;
      }
    else
      unset($namewords[$wordkey]);
    }

  //Commit sub classname to array
  $classname = implode(" ",$namewords);
  array_push($classnames,$classname);
  }

$raceclass = implode(" &amp; ",$classnames);

//Rationalise boat type if needed
$boattypesstore = array_unique($boattypesstore);

if (count($boattypesstore) == 1)
  {
  $boattype = $boattypesstore[0];
  $raceclass = str_replace($boattype,"",$raceclass);
  $raceclass = $raceclass . " " . $boattype;
  }

//Remove any doubles
$doubles = array("  ");
$singles = array(" ");
$replacements = 1;
while ($replacements > 0)
  {
  $raceclass = str_replace($doubles,$singles,$raceclass,$replacements);
  }
?>
