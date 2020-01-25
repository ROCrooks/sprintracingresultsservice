<?php
//Get required files
include 'required-functions.php';

//Get a single unset racename
$getracenametosetsql = "SELECT `Class` FROM `races` WHERE `Set` = 0 ORDER BY `Class` ASC LIMIT 0,1";
$racenametoset = dbprepareandexecute($srrsdblink,$getracenametosetsql);

//Return the race name, or false if there is none
if (count($racenametoset) == 1)
  $racenametoset = $racenametoset[0]['Class'];
else
  $racenametoset = false;
?>
