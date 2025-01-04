<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the club code to delete the club
$deletecode = $_GET['deleteclub'];

//Query to find club name after deleting
$clubnamefindsql = "SELECT `LongName` FROM `clubs` WHERE `Code` = ?";

//Find the club name that's being deleted
$nameofdeletedclub = dbprepareandexecute($srrsdblink,$clubnamefindsql,$deletecode);
$deleteclubname = $nameofdeletedclub[0]['LongName'];

//Query to delete the club
$deleteclubsql = "DELETE FROM `clubs` WHERE `Code` = ?";

//Delete the club
dbprepareandexecute($srrsdblink,$deleteclubsql,$deletecode);

//Delete the club colours if they exist
$colourfile = "clubcolours/" . $deletecode . ".png";
if (file_exists($colourfile) == true)
    unlink($colourfile);

//Create delete message
$deletemessage = "<p>Deleted the club " . $deleteclubname . " from the database!</p>";
?>