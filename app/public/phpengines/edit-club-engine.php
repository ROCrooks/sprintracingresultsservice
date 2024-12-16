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
//Only conduct this check if the club code is being changed
if ($forminput['Code'] != $forminput['OriginalCode'])
    {
    //Get the locations for the original and new club filenames
    $originalcolourfile = "clubcolours/" . $forminput['OriginalCode'] . ".png";
    $newcolourfile = "clubcolours/" . $forminput['Code'] . ".png";
    
    //Check if the files exist
    $originalcolourexists = file_exists($originalcolourfile);
    $newcolourexists = file_exists($newcolourfile);
    
    //Choose behaviour depending on whether the new club colour code file already exists
    if (($originalcolourexists == true) AND ($newcolourexists == true))
        $clubcoloursbehaviour = "CodeClash";
    elseif (($originalcolourexists == true) AND ($newcolourexists === false))
        $clubcoloursbehaviour = "RenameFile";
    elseif (($originalcolourexists === false) AND ($newcolourexists == true))
        $clubcoloursbehaviour = "ReplaceDBOnly";
    elseif (($originalcolourexists === false) AND ($newcolourexists === false))
        $clubcoloursbehaviour = "ReplaceDBOnly";
    }
else
    $clubcoloursbehaviour = "ReplaceDBOnly";

//Check for the existence of club code clashes

//Run SQL query
$updateclubsql = "UPDATE `clubs` SET `Code` = ?, `ShortName` = ?, `LongName` = ?, `WWW` = ?, `WWWapp` = ? WHERE `Code` = ? ";

?>