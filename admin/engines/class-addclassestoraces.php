<?php
//Include the required paths if they haven't been already set
//I.e. called from another script
if ((isset($publicenginesrelativepath) == false) AND (isset($adminenginesrelativepath) == false))
  include '../srrsadminrelativepaths.php';

include 'required-functions.php';

//Get the race keys for all races that match a RaceName
$racekeysracenamesql = "SELECT `Key` FROM `races` WHERE `Class` = ?";
$racekeysclass = dbprepareandexecute($srrsdblink,$racekeysracenamesql,$racename);
$racekeysclass = resulttocolumn($racekeysclass,"Key");

?>
