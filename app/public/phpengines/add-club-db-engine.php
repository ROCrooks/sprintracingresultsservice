<?php
//Create and run query to add club name
$addnewclubsql = "INSERT INTO `clubs` (`Code`, `ShortName`, `LongName`, `WWW`, `WWWApp`) VALUES (?, ?, ?, ?, ?)";
dbprepareandexecute($srrsdblink,$addnewclubsql,$clubaddfields);
?>