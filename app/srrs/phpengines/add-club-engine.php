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

//Create error message
if (count($inputerrors) == 0)
    {
    //If a club URL is specified, make the URL approved
    if ($clubaddfields['WWW'] == "")
        $clubaddfields['WWWApp'] = 0;
    else
        $clubaddfields['WWWApp'] = 1;
    
    //Create and run query to add new club
    $clubaddconstraints = array_values($clubaddfields);
    $addnewclubsql = "INSERT INTO `clubs` (`Code`, `ShortName`, `LongName`, `WWW`, `WWWApp`) VALUES (?, ?, ?, ?, ?)";
    dbprepareandexecute($srrsdblink,$addnewclubsql,$clubaddconstraints);

    //Create adding message
    $addclubmessage = "<p>Success! The club " . $clubaddfields['LongName'] . " (" . $clubaddfields['ShortName'] . ") with the club code " . $clubaddfields['Code'] . " has been added!";
    if ($clubaddfields['WWW'] != "")
        $addclubmessage = $addclubmessage . " Its website is: " . $clubaddfields['WWW'];
    $addclubmessage = $addclubmessage . "</p>";

    //Upload club colours
    if (isset($_FILES["ColoursFile"]["tmp_name"]) == true)
        {
        $clubcoloursfile = $clubcoloursfileslocation . $clubaddfields['Code'] . ".png";
        move_uploaded_file($_FILES["ColoursFile"]["tmp_name"],$clubcoloursfile);
        }
    
    //Make the club add array fields empty
    $clubaddfields['Code'] = "";
    $clubaddfields['LongName'] = "";
    $clubaddfields['ShortName'] = "";
    $clubaddfields['WWW'] = "";
    $clubaddfields['WWWApp'] = 0;
    }
else
    $addclubmessage = "<p>" . implode("<br>",$inputerrors) . "</p>";
?>