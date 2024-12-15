<?php
//Get the inputs from the form
$forminput['Code'] = $_POST['Code'];
$forminput['ShortName'] = $_POST['ShortName'];
$forminput['LongName'] = $_POST['LongName'];
$forminput['WWW'] = $_POST['WWW'];
if (isset($_POST['WWWapp']) == true)
    $forminput['WWWapp'] = 1;
else
    $forminput['WWWapp'] = 0;

//The original club code from the page
$forminput['OriginalCode'] = $clubcode;

print_r($forminput);

//Check for the existence of club colours files

//Check for the existence of club code clashes


//Run SQL query
$updateclubsql = "UPDATE `clubs` SET `Code` = ?, `ShortName` = ?, `LongName` = ?, `WWW` = ?, `WWWapp` = ? WHERE `Code` = ? ";

?>