<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Set validation flag
$inputerrors = array();

//Check that club code is valid length
if (strlen($clubaddfields['Code']) > 3)
    array_push($inputerrors,"Club code is too long");
if (strlen($clubaddfields['Code']) < 3)
    array_push($inputerrors,"Club code is too short");

//Create and run query to see if club code already exists
$checknewclubcodesql = "SELECT COUNT(1) FROM `clubs` WHERE `Code` = ?";
$checknewclubcoderesult = dbprepareandexecute($srrsdblink,$checknewclubcodesql,$clubaddfields['Code']);
$checknewclubcodetruefalse = sqlrecordchecktrueorfalse($checknewclubcoderesult);
if ($checknewclubcodetruefalse == true)
    array_push($inputerrors,"Club code already exists");

//Create and run query to see if club long name already exists
$checknewclublongnamesql = "SELECT COUNT(1) FROM `clubs` WHERE `LongName` = ?";
$checknewclublongnameresult = dbprepareandexecute($srrsdblink,$checknewclublongnamesql,$clubaddfields['LongName']);
$checknewclublongnametruefalse = sqlrecordchecktrueorfalse($checknewclublongnameresult);
if ($checknewclublongnametruefalse == true)
    array_push($inputerrors,"Club long name already exists");

//Create and run query to see if club long name already exists
$checknewclubshortnamesql = "SELECT COUNT(1) FROM `clubs` WHERE `ShortName` = ?";
$checknewclubshortnameresult = dbprepareandexecute($srrsdblink,$checknewclubshortnamesql,$clubaddfields['ShortName']);
$checknewclubshortnametruefalse = sqlrecordchecktrueorfalse($checknewclubshortnameresult);
if ($checknewclubshortnametruefalse == true)
    array_push($inputerrors,"Club short name already exists");

//Create and run query to add club name
//$addnewclubsql = "INSERT INTO `clubs` (`Code`, `ShortName`, `LongName`, `WWW`, `WWWApp`) VALUES (?, ?, ?, ?, ?)";
//dbprepareandexecute($srrsdblink,$addnewclubsql,$clubaddfields);

//Create error message
if (count($inputerrors) == 0)
    {
    //Create adding message
    $addclubmessage = "<p>Success! The club " . $clubaddfields['LongName'] . " (" . $clubaddfields['ShortName'] . ") with the club code " . $clubaddfields['Code'] . " has been added!";
    if ($clubaddfields['WWW'] != "")
        $addclubmessage = $addclubmessage . " Its website is: " . $clubaddfields['WWW'];
    $addclubmessage = $addclubmessage . "</p>";
    
    //Make the club add array fields empty
    $clubaddfields['Code'] = "";
    $clubaddfields['LongName'] = "";
    $clubaddfields['ShortName'] = "";
    $clubaddfields['WWW'] = "";
    }
else
    $addclubmessage = "<p>" . implode("<br>",$inputerrors) . "</p>";
?>