<?php
include '../srrsadminrelativepaths.php';
include '../srrsadmindefaulturls.php';
include 'required-functions.php';

//Get all hidden class names from race table
$eachraceclasssql = "SELECT DISTINCT `Class` FROM `races` ORDER BY `Class` ASC";
$eachraceclass = dbprepareandexecute($srrsdblink,$eachraceclasssql);
$eachraceclass = resulttocolumn($eachraceclass,"Class");

//Get all class names from autoclass table
$eachautoclasssql = "SELECT DISTINCT `Class` FROM `autoclasses` ORDER BY `Class` ASC";
$eachautoclass = dbprepareandexecute($srrsdblink,$eachautoclasssql);
$eachautoclass = resulttocolumn($eachautoclass,"Class");

//Get all class names from autofreetext table
$eachautofreetextclasssql = "SELECT DISTINCT `Class` FROM `autofreetext` ORDER BY `Class` ASC";
$eachautofreetextclass = dbprepareandexecute($srrsdblink,$eachautofreetextclasssql);
$eachautofreetextclass = resulttocolumn($eachautofreetextclass,"Class");

$uniqueclassnames = array_merge($eachraceclass,$eachautoclass,$eachautofreetextclass);
//$uniqueclassnames = array_unique($uniqueclassnames);

print_r($uniqueclassnames);

$countracessql = "SELECT COUNT(`Key`) FROM `races` WHERE `Class` = ?";
$countracesstmt = dbprepare($srrsdblink,$countracessql);

foreach($uniqueclassnames as $classkey=>$uniqueclassname)
  {
  $uniqueclassname['InputClass'] = $uniqueclassnames['Class'];
  unset($uniqueclassnames['Class']);

  $uniqueclassnames[$classkey] = $uniqueclassname;
  }

print_r($uniqueclassnames);
?>
