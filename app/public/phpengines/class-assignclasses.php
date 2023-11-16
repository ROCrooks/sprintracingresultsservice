<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Example of a class to add in a consistent format
/*$classesadd = array();
$classesaddline = array();
$classesaddline['AutoClass'] = "Add";
$classesaddline['ClassCodes'] = array();
$classesaddline['ClassCodes'][0] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","FreeText"=>"");
$classesadd['MENS A K'] = $classesaddline;
$classesaddline = array();
$classesaddline['AutoClass'] = "Is";
$classesaddline['ClassCodes'] = array();
$classesaddline['ClassCodes'][0] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","FreeText"=>"");
$classesadd['WOMENS A K'] = $classesaddline;*/

if (isset($racekeys) == false)
  {
  //Get the race keys
  $getracessql = "SELECT `Key` FROM `races` WHERE `Class` = ?";
  $racekeys = dbprepareandexecute($srrsdblink,$getracessql,$racenametoset);
  $racekeys = resulttocolumn($racekeys);
  }

//For each class from the class details
foreach ($classesadd as $atomizedracename=>$classline)
  {
  $classcodeslines = $classline['ClassCodes'];
  $racename = $atomizedracename;
  $autoclassflag = $classline['AutoClass'];

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
        $insertclassstmt = dbprepare($srrsdblink,$insertclasssql);
        }
      
      //Add class using the class lines and the race keys
      $classaddconstraints = array($racekey,$classcodes['JSV'],$classcodes['MW'],$classcodes['CK'],$classcodes['Spec'],$classcodes['Abil'],$classcodes['Ages'],$classcodes['FreeText']);
      dbexecute($insertclassstmt,$classaddconstraints);
      }
    
    //Statement to set the race to set once the classes have been assigned
    if (isset($setracesstmt) == false)
      {
      $setracessql = "UPDATE `races` SET `Set` = 1 WHERE `Key` = ?";
      $setracesstmt = dbprepare($srrsdblink,$setracessql);
      }
    
    //Update the races to set them
    $racekeysconstraints = array($racekey);
    dbexecute($setracesstmt,$racekeysconstraints);
    }
  
  //Add the autoclass if add autoclass has been set
  if ($autoclassflag == "Add")
    {
    //Prepare statement to add the autoclass
    if (isset($addautoclassstmt) == false)
      {
      $addautoclasssql = "INSERT INTO `autoclasses` (`RaceName`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $addautoclassstmt = dbprepare($srrsdblink,$addautoclasssql);
      }
    
    //Add class to the autoclasses table
    $classaddconstraints = array($atomizedracename,$classcodes['JSV'],$classcodes['MW'],$classcodes['CK'],$classcodes['Spec'],$classcodes['Abil'],$classcodes['Ages'],$classcodes['FreeText']);
    dbexecute($addautoclassstmt,$classaddconstraints);
    }
  }

//Unset the data arrays of the classes added in order to tidy up code
unset($classesadd);
unset($racekeys);
?>
