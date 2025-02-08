<?php
//Set validation flag
$inputerrors = array();

//Check that club code is valid
if (strlen($clubaddfields['Code']) > 3)
    array_push($inputerrors,"Club code is too long");
if (strlen($clubaddfields['Code']) < 3)
    array_push($inputerrors,"Club code is too short");

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