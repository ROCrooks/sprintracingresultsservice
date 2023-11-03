<?php
#include_once $engineslocation . 'srrs-required-functions.php';

$racekeys = array(1,2,3);
//Example of a class to add in a consistent format
$classesadd = array();
$classesaddline = array();
$classesaddline['AutoClass'] = "Add";
$classesaddline['ClassCodes'] = array();
$classesaddline['ClassCodes'][0] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","FreeText"=>"");
$classesadd['MENS A K'] = $classesaddline;
$classesaddline = array();
$classesaddline['AutoClass'] = "Is";
$classesaddline['ClassCodes'] = array();
$classesaddline['ClassCodes'][0] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","FreeText"=>"");
$classesadd['WOMENS A K'] = $classesaddline;

print_r($classesadd);
echo '<br>';

if (isset($racekeys) == false)
  {
  //Get the race keys
  $getracessql = "SELECT `Key` FROM `races` WHERE `Class` = ?";
  #$racekeys = dbprepareandexecute($srrsdblink,$getracessql,$racenametoset);
  #$racekeys = resulttocolumn($racekeys);
  }

//Rebuild the loops
//For each class from the class details
foreach ($classesadd as $atomizedracename=>$classline)
  {
  $classcodeslines = $classline['ClassCodes'];
  $racename = $atomizedracename;
  $autoclassflag = $classline['AutoClass'];

  print_r($classcodeslines);
  echo '<br>';
  echo $racename . '<br>';
  print_r($autoclassflag);
  echo '<br>';

  //Loop through each race number
  foreach ($racekeys as $racekey)
    {
    //Loop through each class code
    foreach ($classcodeslines as $classcodes)
      {     
      //Make the add classes statement
      if (isset($insertclassstmt) == false)
        {
        //Create insert class statement if not already created
        $insertclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertclassstmt = true;
        #$insertclassstmt = dbprepare($srrsdblink,$insertclasssql);
        }
      
      //Add class using the class lines and the race keys
      $classaddconstraints = array($racekey,$classcodes['JSV'],$classcodes['MW'],$classcodes['CK'],$classcodes['Spec'],$classcodes['Abil'],$classcodes['Ages'],$classcodes['FreeText']);
      print_r($classaddconstraints);
      echo '<br>';
      #dbexecute($insertclassstmt,$classaddconstraints);
      }
    }
  }

/*
//For each class from the class details
foreach ($classesadd as $atomizedracename=>$classline)
  {
  print_r($classline);
  echo '<br>';
  
  $classcodeslines = $classline['ClassCodes'];

  print_r($classcodes);
  echo '<br>';

  //For each race key and the list of classes
  foreach ($racekeys as $racekey)
    {
    //Add each race class from the class codes array
    
    //Make the add classes statement
    if (isset($insertclassstmt) == false)
      {
      //Create insert class statement if not already created
      $insertclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      #$insertclassstmt = dbprepare($srrsdblink,$insertclasssql);
      }
    
    //Add class
    $classaddconstraints = array($racekey,$classcodes['JSV'],$classcodes['MW'],$classcodes['CK'],$classcodes['Spec'],$classcodes['Abil'],$classcodes['Ages'],$classcodes['FreeText']);
    #dbexecute($insertclassstmt,$classaddconstraints);

    //Mark races with that class as set statement
    if (isset($setracesclassesstmt) == false)
      {
      $setracesclassessql = "UPDATE `races` SET `Set` = 1 WHERE `Key` = ?";
      #$setracesclassesstmt = dbprepare($srrsdblink,$setracesclassessql);
      }
    
    //Update the race to say that the class has been set
    #dbexecute($setracesclassesstmt,$racekey);
    }
  
  //Add the class to the autoclasses table if the flag is set
  if ($classline['AutoClass'] == "Add")
    {
    //Prepare statement to add the autoclass
    if (isset($addautoclassstmt) == false)
      {
      $addautoclasssql = "INSERT INTO `autoclasses` (`RaceName`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      #$addautoclassstmt = dbprepare($srrsdblink,$addautoclasssql);
      }
    
    //Add class to the autoclasses table
    $classaddconstraints = array($atomizedracename,$classcodes['JSV'],$classcodes['MW'],$classcodes['CK'],$classcodes['Spec'],$classcodes['Abil'],$classcodes['Ages'],$classcodes['FreeText']);
    print_r($classaddconstraints);
    echo '<br>';
    #dbexecute($addautoclassstmt,$classaddconstraints);
    }
  }
*/

//Unset the data arrays of the classes added in order to tidy up code
unset($classesadd);
unset($racekeys);
?>
