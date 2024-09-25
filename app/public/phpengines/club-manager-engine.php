<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the clubs from the club table
$clubdetailssql = "SELECT * FROM `clubs`";
$clubdetailsstmt = dbprepare($srrsdblink,$clubdetailssql);
$clubdetailsresult = dbexecute($clubdetailsstmt,"");
//Make a list of clubs found in the database
$clubcodesfound = resulttocolumn($clubdetailsresult,"Code");

//Get the clubs from the paddlers table
$allclubssql = "SELECT DISTINCT `Club` FROM `paddlers`";
$allclubsstmt = dbprepare($srrsdblink,$allclubssql);
$allclubsresult = dbexecute($allclubsstmt,"");
//Make the clubs into an array of club codes
$allclubsresult = resulttocolumn($allclubsresult,"Club");



print_r($clubcodesfound);
echo "<br>";

//print_r($allclubsresult);

print_r($allclubsresult);
echo "<br>";
?>