<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the clubs from the club table
$clubdetailssql = "SELECT * FROM `clubs`";
$clubdetailsstmt = dbprepare($srrsdblink,$clubdetailssql);
$clubdetailsresult = dbexecute($clubdetailsstmt,"");

//Get the clubs from the paddlers table
$allclubssql = "SELECT DISTINCT `club` FROM `paddlers`";
$allclubsstmt = dbprepare($srrsdblink,$allclubssql);
$allclubsresult = dbexecute($allclubsstmt,"");

print_r($clubdetailsresult);
echo "<br>";

print_r($allclubsresult);
echo "<br>";
?>