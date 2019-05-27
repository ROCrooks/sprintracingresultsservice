<?php
include_once 'required-functions.php';

$regattaid = 1000;

$paddlertimesql = "INSERT INTO `paddlers` (`Race`, `Position`, `Lane`, `Crew`, `Club`, `Time`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$paddlernrsql = "INSERT INTO `paddlers` (`Race`, `Position`, `Lane`, `Crew`, `Club`, `NR`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$racesql = "INSERT INTO `races` (`Regatta`, `Class`, `Boat`, `Dist`, `R`, `D`) VALUES (?, ?, ?, ?, ?, ?)"
?>
