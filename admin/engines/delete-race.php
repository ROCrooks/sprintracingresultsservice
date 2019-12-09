<?php
include 'required-functions.php';

//Queries to delete the regatta and all linked records
$deletepaddlersql = "DELETE FROM `paddlers` WHERE `Race` = ?";
$deleteclasssql = "DELETE FROM `classes` WHERE `Race` = ?";
$deleteracessql = "DELETE FROM `races` WHERE `Key` = ?";

//Delete the regattas
dbprepareandexecute($srrsdblink,$deletepaddlersql,$deleterace);
dbprepareandexecute($srrsdblink,$deleteclasssql,$deleterace);
dbprepareandexecute($srrsdblink,$deleteracessql,$deleterace);
?>
