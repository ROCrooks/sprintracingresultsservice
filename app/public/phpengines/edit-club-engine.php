<?php
include_once $engineslocation . 'srrs-required-functions.php';

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
if ($forminput['OriginalCode'] != $forminput['Code'])
    {
    //Statement to check the database
    $clubcodecheckingsql = "SELECT COUNT(1) FROM `clubs` WHERE `Code` = ? ";
    $clubcodecheckingstmt = dbprepare($srrsdblink,$clubcodecheckingsql);
    if ($forminput['OriginalCode'] != '')
        {
        $checkoriginalcoderesult = dbexecute($clubcodecheckingstmt,$forminput['OriginalCode']);
        $originalcodeexists = sqlrecordchecktrueorfalse($checkoriginalcoderesult);
        }
    else
        $originalcodeexists = false;
    $checknewcoderesult = dbexecute($clubcodecheckingstmt,$forminput['Code']);
    $newcodeexists = sqlrecordchecktrueorfalse($checknewcoderesult);
    
    //Select behaviour based on the codes
    if (($originalcodeexists == true) AND ($newcodeexists == true))
        $clubcodebehaviour = "CodeClash";
    elseif (($originalcodeexists == true) AND ($newcodeexists == false))
        $clubcodebehaviour = "UpdateCode";
    elseif ($originalcodeexists == false)
        $clubcodebehaviour = "Error";
    }
else
    $clubcodebehaviour = "NoCodeChange";

if (($clubcoloursbehaviour == "CodeClash") OR ($clubcodebehaviour == "CodeClash"))
    {
    //If there is a code clash, create an error message
    $clubchangeformerrormessage = "<p>Error - You are trying to give a club a code that has already been assigned to another club!</p>";
    }
elseif ($clubcodebehaviour == "Error")
    {
    //If the original club doesn't exist, create an error message
    $clubchangeformerrormessage = "<p>Error - The club you're trying to change doesn't seem to exist!</p>";
    }
elseif (($clubcodebehaviour == "UpdateCode") OR ($clubcodebehaviour = "NoCodeChange"))
    {
    //If the club is updating a new club
    $updateclubsql = "UPDATE `clubs` SET `Code` = ?, `ShortName` = ?, `LongName` = ?, `WWW` = ?, `WWWapp` = ? WHERE `Code` = ? ";
    $sqlconstraints = array_values($forminput);
    dbprepareandexecute($srrsdblink,$updateclubsql,$sqlconstraints);
    
    //Rename club colours file if needed
    if ($clubcoloursbehaviour == "RenameFile")
        {
        rename($originalcolourfile,$newcolourfile);
        }
    }

?>