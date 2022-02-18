<?php
include_once $engineslocation . 'srrs-required-functions.php';

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



foreach($uniqueclassnames as $uniqueclasskey=>$findclassname)
  {
  include 'class-getoneclass.php';

  //Define the input class name
  $uniqueclassnames[$uniqueclasskey] = array();
  $uniqueclassnames[$uniqueclasskey]['InputClass'] = $findclassname;
  $uniqueclassnames[$uniqueclasskey]['RaceCount'] = $numberclassraces;
  $uniqueclassnames[$uniqueclasskey]['AutoClass'] = $autoclassname;
  }
?>
