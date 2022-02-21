<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Queries to delete the regatta and all linked records
$deletepaddlersql = "DELETE p
FROM `paddlers` p
LEFT JOIN `races` r ON p.`Race` = r.`Key`
LEFT JOIN `regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteclasssql = "DELETE c
FROM `classes` c
LEFT JOIN `races` r ON c.`Race` = r.`Key`
LEFT JOIN `regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteracessql = "DELETE r
FROM `races` r
LEFT JOIN `regattas` g ON r.`Regatta` = g.`Key`
WHERE g.`Key` = ?";
$deleteregattasql = "DELETE FROM `regattas` WHERE `Key` = ?";

//Delete the regattas
dbprepareandexecute($srrsdblink,$deletepaddlersql,$doregatta);
dbprepareandexecute($srrsdblink,$deleteclasssql,$doregatta);
dbprepareandexecute($srrsdblink,$deleteracessql,$doregatta);
dbprepareandexecute($srrsdblink,$deleteregattasql,$doregatta);

//Delete any temporary files associated with the the regatta
$tempfilename = $tempfileslocation . "regatta" . $doregatta . ".txt";
if (file_exists($tempfilename) == true)
  unlink($tempfilename);
?>
