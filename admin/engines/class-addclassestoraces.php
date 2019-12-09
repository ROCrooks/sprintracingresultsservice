<?php
include 'required-functions.php';

//Include the required paths if they haven't been already set
//I.e. called from another script
if ((isset($publicenginesrelativepath) == false) AND (isset($adminenginesrelativepath) == false))
  include '../srrsadminrelativepaths.php';

//Prepare the race keys getting query
if (isset($racekeysracenamestmt) == false)
  {
  $racekeysracenamesql = "SELECT `Key` FROM `races` WHERE `Class` = ? AND `Set` = 0";
  $racekeysracenamestmt = dbprepare($srrsdblink,$racekeysracenamesql);
  }

//Prepare the inserting classes query
if (isset($addclassstmt) == false)
  {
  $addclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $addclassstmt = dbprepare($srrsdblink,$addclasssql);
  }

//Get the race keys for all races that match a RaceName

//Get the keys for the races to add classes to
$racekeysclass = dbexecute($racekeysracenamestmt,$racename);
$racekeysclass = resulttocolumn($racekeysclass,"Key");

//Loop each race ID
foreach($racekeysclass as $listracekeyclass)
  {
  $listracekeyclass = array("Race"=>$listracekeyclass);

  //Loop each class and add
  foreach($classdetails as $insertclasses)
    {
    $insertclasses = array_merge($listracekeyclass,$insertclasses);
    dbexecute($addclassstmt,$insertclasses);
    }
  }
?>
