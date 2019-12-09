<?php
include 'required-files.php';

$purgeclassessql = "DELETE FROM `classes` c LEFT JOIN `races` r ON c.`Race` = r.`Key` WHERE r.`Class` = ?";

$purgeautoclassessql = "DELETE FROM `autoclasses` WHERE `RaceName` = ?";
?>
