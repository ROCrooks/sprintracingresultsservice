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

print_r($forminput);

//Run SQL query
$updateclubsql = "UPDATE `clubs` SET `Code` = ?, `ShortName` = ?, `LongName` = ?, `WWW` = ?, `WWWapp` = ? WHERE `Code` = ? ";

?>