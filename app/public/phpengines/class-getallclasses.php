<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get all class names from race table
$eachraceclasssql = "SELECT DISTINCT `Class` FROM `races` ORDER BY `Class` ASC";
$eachraceclass = dbprepareandexecute($srrsdblink,$eachraceclasssql);
$eachraceclass = resulttocolumn($eachraceclass,"Class");

//Get the atomized race names from the classes table
$atomizedracenames = array();
foreach ($eachraceclass as $eachracename)
  {
  //Replace different ways of dividing race classes with a single way
  $variablebreaks = array(" +"," + ","+ "," &"," & ","& ","&");
  $eachracename = str_replace($variablebreaks,"+",$eachracename);

  //Explode into the atomized races, and merge with the database
  $eachracename = explode("+",$eachracename);
  $atomizedracenames = array_merge($atomizedracenames,$eachracename);
  }

//Get all class names from autoclass table
$eachautoclasssql = "SELECT DISTINCT `RaceName` FROM `autoclasses` ORDER BY `RaceName` ASC";
$eachautoclass = dbprepareandexecute($srrsdblink,$eachautoclasssql);
$eachautoclass = resulttocolumn($eachautoclass,"RaceName");

//Make an array of unique race names
$uniqueclassnames = array_merge($atomizedracenames,$eachautoclass);
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
