<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the race keys
$getracessql = "SELECT `Key` FROM `races` WHERE `Class` = ?";
$racekeys = dbprepareandexecute($srrsdblink,$getracessql,$racenametoset);
$racekeys = resulttocolumn($racekeys);

//For each class from the class details
foreach ($forminputdata as $classline)
  {
  //For each race key and the list of classes
  foreach ($racekeys as $racekey)
    {
    //Make the add classes statement
    if (isset($insertclassstmt) == false)
      {
      //Create insert class statement if not already created
      $insertclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $insertclassstmt = dbprepare($srrsdblink,$insertclasssql);
      }
    
    //Add class
    $classaddconstraints = array($racekey,$classline['JSV'],$classline['MW'],$classline['CK'],$classline['Spec'],$classline['Abil'],$classline['Ages'],$classline['FreeText']);
    dbexecute($insertclassstmt,$classaddconstraints);

    //Mark races with that class as set statement
    if (isset($setracesclassesstmt) == false)
      {
      $setracesclassessql = "UPDATE `races` SET `Set` = 1 WHERE `Key` = ?";
      $setracesclassesstmt = dbprepare($srrsdblink,$setracesclassessql);
      }
    
    //Update the race to say that the class has been set
    dbexecute($setracesclassesstmt,$racekey);
    }
  
  //Add the class to the autoclasses table if the flag is set
  if ($classline['AutoClass'] == "Add")
    {
    //Prepare statement to add the autoclass
    if (isset($addautoclassstmt) == false)
      {
      $addautoclasssql = "INSERT INTO `autoclasses` (`RaceName`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $addautoclassstmt = dbprepare($srrsdblink,$addautoclasssql);
      }
    
    //Add class to the autoclasses table
    $classaddconstraints = array($classline['RaceName'],$classline['JSV'],$classline['MW'],$classline['CK'],$classline['Spec'],$classline['Abil'],$classline['Ages'],$classline['FreeText']);
    dbexecute($addautoclassstmt,$classaddconstraints);
    }
  }
?>
