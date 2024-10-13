<?php
include_once $engineslocation . 'srrs-required-functions.php';

$clubcode = $_GET['club'];

//Run SQL query to get club details
$clubfindsql = "SELECT `LongName`, `ShortName`, `WWW`, `WWWapp` FROM `clubs` WHERE `code` = ? LIMIT 0,1 ";
$clubfindstmt = dbprepare($srrsdblink,$clubfindsql);
$clubfindresult = dbexecute($clubfindstmt,$clubcode);

//Make empty array if no club found
if (count($clubfindresult) == 0)
    {
    $clubfindresult[0] = array("LongName"=>"","ShortName"=>"","WWW"=>"","WWWapp"=>0);
    }

//Make the SQL result a single array
$clubfindresult = $clubfindresult[0];

print_r($clubfindresult);

//echo $clubcode;
?>