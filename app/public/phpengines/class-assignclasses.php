<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Make the add classes statement
if (isset($insertclassstmt) == false)
  {
  //Create insert class statement if not already created
  $insertclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $insertclassstmt = dbprepare($srrsdblink,$insertclasssql);
  }

//Get the race keys
$getracessql = "SELECT `Key` FROM `races` WHERE `Class` = ?";
$racekeys = dbprepareandexecute($srrsdblink,$getracessql,$findclassname);
$racekeys = resulttocolumn($racekeys);

//For each race key and the list of classes
foreach ($racekeys as $racekey)
  {
  //For each class from the class details
  foreach ($classdetails as $classline)
    {
    //Add class
    $classaddconstraints = array($racekey,$classline['JSV'],$classline['MW'],$classline['CK'],$classline['Spec'],$classline['Abil'],$classline['Ages'],$classline['FreeText']);
    dbexecute($insertclassstmt,$classaddconstraints);
    }
  }

//Mark races with that class as set
if (isset($setracesclassesstmt) == false)
  {
  $setracesclassessql = "UPDATE `races` SET `Set` = 1 WHERE `Class` = ?";
  $setracesclassesstmt = dbprepare($srrsdblink,$setracesclassessql);
  }

//Update the race to say that the class has been set
dbexecute($setracesclassesstmt,$findclassname);

//Check each atomized class to see if it is to be added as an AutoClass for future use
foreach ($classdetails as $classline)
  {
  if ($classline['AutoClass'] == false)
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
