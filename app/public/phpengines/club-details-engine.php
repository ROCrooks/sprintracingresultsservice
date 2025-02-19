<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Default the getting the club metrics flag to be false
if (isset($clubmetrics) == false)
    $clubmetrics = false;

if ($clubcode != '')
    {
    //Run SQL query to get club details
    $clubfindsql = "SELECT `LongName`, `ShortName`, `WWW`, `WWWapp` FROM `clubs` WHERE `code` = ? LIMIT 0,1 ";
    $clubfindstmt = dbprepare($srrsdblink,$clubfindsql);
    $clubfindresult = dbexecute($clubfindstmt,$clubcode);
    }
else
    $clubfindresult = array();

//Make empty array if no club found
if (count($clubfindresult) == 0)
    {
    $clubfindresult[0] = array("LongName"=>"","ShortName"=>"","WWW"=>"","WWWapp"=>0);
    }
elseif ($clubmetrics == true)
    {
    //Count the number of boats with this club in the SRRS database
    
    //Make a wildcard version of the club code
    $wildcardclub = "%" . $clubcode . "%";
    
    //Make the queries
    $countpaddlerssql = "SELECT COUNT(1) FROM `paddlers` WHERE `Club` LIKE ?";
    $countracessql = "SELECT COUNT(DISTINCT `Race`) FROM `paddlers` WHERE `Club` LIKE ?";
    $countregattassql = "SELECT COUNT(DISTINCT r.`Regatta`) FROM `races` r INNER JOIN `paddlers` p ON p.`Race`=r.`Key` WHERE `Club` LIKE ?";
    
    //Prepare and execute the queries to get the club metrics
    $countpaddlersresult = dbprepareandexecute($srrsdblink,$countpaddlerssql,$wildcardclub);
    $countracesresult = dbprepareandexecute($srrsdblink,$countracessql,$wildcardclub);
    $countregattasresult = dbprepareandexecute($srrsdblink,$countregattassql,$wildcardclub);

    //Make the club metrics readable
    $clubpaddlers = sqlcountoutput($countpaddlersresult);
    $clubraces = sqlcountoutput($countracesresult);
    $clubregattas = sqlcountoutput($countregattasresult);
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

//Attach club colours to the club details array
$clubfindresult['Colours'] = $coloursfile;
?>