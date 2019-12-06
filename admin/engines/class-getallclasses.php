<?php
include '../srrsadminrelativepaths.php';
include '../srrsadmindefaulturls.php';
include 'required-functions.php';

//Get all hidden class names from race table
$eachraceclasssql = "SELECT DISTINCT `Class` FROM `races` ORDER BY `Class` ASC";
$eachraceclass = dbprepareandexecute($srrsdblink,$eachraceclasssql);
$eachraceclass = resulttocolumn($eachraceclass,"Class");

//Get all class names from autoclass table
$eachautoclasssql = "SELECT DISTINCT `RaceName` FROM `autoclasses` ORDER BY `RaceName` ASC";
$eachautoclass = dbprepareandexecute($srrsdblink,$eachautoclasssql);
$eachautoclass = resulttocolumn($eachautoclass,"RaceName");

//Get all class names from autofreetext table
$eachautofreetextclasssql = "SELECT DISTINCT `RaceName` FROM `autofreetext` ORDER BY `RaceName` ASC";
$eachautofreetextclass = dbprepareandexecute($srrsdblink,$eachautofreetextclasssql);
$eachautofreetextclass = resulttocolumn($eachautofreetextclass,"RaceName");

$uniqueclassnames = array_merge($eachraceclass,$eachautoclass,$eachautofreetextclass);
$uniqueclassnames = array_unique($uniqueclassnames);

//Prepare race count query
$countracessql = "SELECT COUNT(`Key`) FROM `races` WHERE `Class` = ?";
$countracesstmt = dbprepare($srrsdblink,$countracessql);

//Prepare query to get autoclasses
$autoclassgetsql = "SELECT `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText` FROM `autoclasses` WHERE `RaceName` = ?";
$autoclassgetstmt = dbprepare($srrsdblink,$autoclassgetsql);

foreach($uniqueclassnames as $classkey=>$uniqueclassname)
  {
  //Define the input class name
  $uniqueclassnames[$classkey] = array();
  $uniqueclassnames[$classkey]['InputClass'] = $uniqueclassname;

  //Count number of races with this class text
  $countraces = dbexecute($countracesstmt,$uniqueclassnames[$classkey]['InputClass']);
  $uniqueclassnames[$classkey]['RaceCount'] = $countraces[0]['COUNT(`Key`)'];

  //Get race names from autoclasses
  $classdetails = dbexecute($autoclassgetstmt,$uniqueclassnames[$classkey]['InputClass']);
  if (count($classdetails) > 0)
    {
    include '../' . $publicenginesrelativepath . 'format-class.php';
    $uniqueclassnames[$classkey]['AutoClass'] = $raceclass;
    }
  else
    $uniqueclassnames[$classkey]['AutoClass'] = "No Autoclass Specified";
  }
?>
