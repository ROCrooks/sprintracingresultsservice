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
?>
