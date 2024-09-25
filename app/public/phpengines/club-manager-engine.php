<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the clubs from the club table
$clubdetailssql = "SELECT * FROM `clubs`";
$clubdetailsstmt = dbprepare($srrsdblink,$clubdetailssql);
$clubdetailsresult = dbexecute($clubdetailsstmt,"");
//Make a list of clubs found in the database
$clubcodesfound = resulttocolumn($clubdetailsresult,"Code");

//Get the clubs from the paddlers table
$allclubssql = "SELECT DISTINCT `Club` FROM `paddlers` WHERE `Club` != '' ";
$allclubsstmt = dbprepare($srrsdblink,$allclubssql);
$allclubsresult = dbexecute($allclubsstmt,"");
//Make the clubs into an array of club codes
$allclubsresult = resulttocolumn($allclubsresult,"Club");

$foundclubs = array();
//Process results to find a single array of found clubs
foreach ($allclubsresult as $crewclub)
    {
    //Explode the club to find the individual clubs of the class
    $crewclub = explode("/",$crewclub);
    $foundclubs = array_merge($foundclubs,$crewclub);
    }
//Make a unique club array
$foundclubs = array_unique($foundclubs);

print_r($foundclubs);

//print_r($clubcodesfound);
//echo "<br>";

//print_r($allclubsresult);

//print_r($allsingleclubsresult);
//echo "<br>";

//print_r($allcrewclubsresult);
//echo "<br>";
?>