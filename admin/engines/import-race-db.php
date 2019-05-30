<?php
include_once 'required-functions.php';

$regattaid = 1000;

//SQL statements required for inserting races
$paddlertimesql = "INSERT INTO `paddlers` (`Race`, `Position`, `Lane`, `Crew`, `Club`, `Time`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$paddlernrsql = "INSERT INTO `paddlers` (`Race`, `Position`, `Lane`, `Crew`, `Club`, `NR`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$racesql = "INSERT INTO `races` (`Regatta`, `Class`, `Boat`, `Dist`, `R`, `D`, `Set`) VALUES (?, ?, ?, ?, ?, ?, ?)";
$findclasssql = "SELECT * FROM `autoclasses` WHERE `Class` = ?";
$insertclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


?>
