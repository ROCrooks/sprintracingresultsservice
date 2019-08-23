<?php
include 'required-functions.php';

//Queries to delete the regatta and all linked records
$deletepaddlersql = "DELETE p
FROM sprintcanoeing.`paddlers` p
LEFT JOIN sprintcanoeing.`races` r ON p.`Race` = r.`Key`
LEFT JOIN sprintcanoeing.`regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteclasssql = "DELETE c
FROM sprintcanoeing.`classes` c
LEFT JOIN sprintcanoeing.`races` r ON c.`Race` = r.`Key`
LEFT JOIN sprintcanoeing.`regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteracessql = "DELETE r
FROM sprintcanoeing.`races` r
LEFT JOIN sprintcanoeing.`regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteregattasql = "DELETE FROM `regattas` WHERE `Key` = ?";

//Delete the regattas
dbprepareandexecute($srrsdblink,$deletepaddlersql,$deleteregatta);
dbprepareandexecute($srrsdblink,$deleteclasssql,$deleteregatta);
dbprepareandexecute($srrsdblink,$deleteracessql,$deleteregatta);
dbprepareandexecute($srrsdblink,$deleteregattasql,$deleteregatta);
?>
