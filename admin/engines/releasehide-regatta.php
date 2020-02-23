<?php
include 'required-functions.php';

//Hide or release regatta based on action code
if ($action == "hide")
  $set = 1;
if ($action == "release")
  $set = 0;

//Run the query to hide or release the regatta
$hidereleaseregattasql = "UPDATE `regattas` SET `Hide` = ? WHERE `Key` = ?";
$hidereleaseconstraints = array($set,$doregatta);
dbprepareandexecute($srrsdblink,$hidereleaseregattasql,$hidereleaseconstraints);
?>
