<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Prepare race count query
if (isset($countracesstmt) == false)
  {
  $countracessql = "SELECT COUNT(`Key`) FROM `races` WHERE `Class` = ?";
  $countracesstmt = dbprepare($srrsdblink,$countracessql);
  }

//Prepare query to get autoclasses
if (isset($autoclassgetstmt) == false)
  {
  $autoclassgetsql = "SELECT `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText` FROM `autoclasses` WHERE `RaceName` = ?";
  $autoclassgetstmt = dbprepare($srrsdblink,$autoclassgetsql);
  }

//Count number of races with this class text
$countraces = dbexecute($countracesstmt,$findclassname);
$numberclassraces = $countraces[0]['COUNT(`Key`)'];

//Get race names from autoclasses
$classdetails = dbexecute($autoclassgetstmt,$findclassname);
if (count($classdetails) > 0)
  {
  include $engineslocation . 'format-class.php';
  $autoclassname = $raceclass;
  }
else
  $autoclassname = "No Autoclass Specified";
?>
