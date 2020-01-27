<?php
include 'required-functions.php';

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

//For each race key
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

dbexecute($setracesclassesstmt,$findclassname);

//Add the autoclass if it requested
if (isset($autoclass) == false)
  $autoclass = false;

if ($autoclass == true)
  {
  //Prepare statement to add the autoclass
  if (isset($addautoclassstmt) == false)
    {
    $addautoclasssql = "INSERT INTO `autoclasses` (`RaceName`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $addautoclassstmt = dbprepare($srrsdblink,$addautoclasssql);
    }

  //Add each class as an autoclass
  foreach ($classdetails as $classline)
    {
    //Add class to the autoclasses table
    $classaddconstraints = array($findclassname,$classline['JSV'],$classline['MW'],$classline['CK'],$classline['Spec'],$classline['Abil'],$classline['Ages'],$classline['FreeText']);
    dbexecute($addautoclassstmt,$classaddconstraints);
    }
  }
?>
