<?php
//Set validation flag
$inputerrors = array();

//Check that club code is valid
if (strlen($clubaddfields['Code']) <> 3)
    array_push($inputerrors,"Club code is the wrong length");

//Create and run query to add club name
//$addnewclubsql = "INSERT INTO `clubs` (`Code`, `ShortName`, `LongName`, `WWW`, `WWWApp`) VALUES (?, ?, ?, ?, ?)";
//dbprepareandexecute($srrsdblink,$addnewclubsql,$clubaddfields);
?>