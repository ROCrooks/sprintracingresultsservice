<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the club code to delete the club
$deletecode = $_GET['deleteclub'];

//Query to delete the club
$deleteclubsql = "DELETE FROM `clubs` WHERE `Code` = ?";

//Delete the club
dbprepareandexecute($srrsdblink,$deleteclubsql,$deletecode);
?>