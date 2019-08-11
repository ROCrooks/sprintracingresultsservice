<?php
include 'required-files.php';

//Queries to delete the regatta and all linked records
$deletepaddlersql = "DELETE p
FROM sprintcanoeing.`paddlers` p
LEFT JOIN sprintcanoeing.`races` r ON p.`Race` = r.`Key`
LEFT JOIN sprintcanoeing.`regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteclasssql = "DELETE p
FROM sprintcanoeing.`classes` c
LEFT JOIN sprintcanoeing.`races` r ON p.`Race` = r.`Key`
LEFT JOIN sprintcanoeing.`regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteracesql = "DELETE p
FROM sprintcanoeing.`races` r
LEFT JOIN sprintcanoeing.`regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteregattasql = "DELETE FROM `regattas` WHERE `Key` = ?";

//Delete the regattas
dbexecute($deletepaddlersql,$deleteregatta);
dbexecute($deleteclasssql,$deleteregatta);
dbexecute($deleteracessql,$deleteregatta);
dbexecute($deleteregattasql,$deleteregatta);
?>
