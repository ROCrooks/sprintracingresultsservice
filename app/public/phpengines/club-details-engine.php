<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the club code from the URL if one is specified
if (isset($_GET['club']) == true)
    {
    $clubcode = $_GET['club'];
    
    //Run SQL query to get club details
    $clubfindsql = "SELECT `LongName`, `ShortName`, `WWW`, `WWWapp` FROM `clubs` WHERE `code` = ? LIMIT 0,1 ";
    $clubfindstmt = dbprepare($srrsdblink,$clubfindsql);
    $clubfindresult = dbexecute($clubfindstmt,$clubcode);    
    }
else
    {
    $clubcode = "";
    $clubfindresult = array();
    }

//Make empty array if no club found
if (count($clubfindresult) == 0)
    {
    $clubfindresult[0] = array("LongName"=>"","ShortName"=>"","WWW"=>"","WWWapp"=>0);
    }

//Make the SQL result a single array
$clubfindresult = $clubfindresult[0];

//Add the club code to the result array
$clubfindresult['Code'] = $clubcode;

//Get the club colours file, or a plain colours if not found
$coloursfile = $clubcoloursfileslocation . $clubfindresult['Code'] . ".png";
if (file_exists($coloursfile) == true)
    $coloursfile = "../clubcolours/" . $clubfindresult['Code'] . ".png";
else
    $coloursfile = "../clubcolours/" . "unknown.png";

$clubfindresult['Colours'] = $coloursfile;

print_r($clubfindresult);
?>