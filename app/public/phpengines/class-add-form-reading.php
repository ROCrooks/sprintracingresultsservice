<?php
//The list of field names to retrieve
$racefieldsget = array("JSV","MW","CK","Abil","Ages","Spec","FreeText");
$classfieldsget = array("RaceName","AutoClass","ClassRange");

//Get the number of race class rows to retrieve and the number of autoclass check boxes to retrieve
$totalclassrows = $_POST['ClassRows'];
$totalracerows = $_POST['RaceRows'];

//Retrieve contents of race classes inputs and place in lookup array for class lines
$classpointer = 1;
$classfieldsdata = array();

While($classpointer <= $totalclassrows)
    {
    //Retrieve the data about each race name
    $raceformdataline = array();
    foreach ($classfieldsget as $field)
        {
        $postfieldname = $field . $classpointer;
        //Default auto class to blank if not set on form
        if (($field == "AutoClass") AND (isset($_POST[$postfieldname]) == false))
            $raceformdataline[$field] = "Blank";
        else
            $raceformdataline[$field] = $_POST[$postfieldname];
        }

    //Make the start and finish of the class line ranges
    $racerange = explode("-", $raceformdataline['ClassRange']);
    $keyclassline = $racerange[0];
    $endclassline = $racerange[1];

    //Add to look up array for class lines
    while ($keyclassline <= $endclassline)
        {
        $classlinedata = array();
        $classlinedata['RaceName'] = $raceformdataline['RaceName'];
        $classlinedata['AutoClass'] = $raceformdataline['AutoClass'];
        $classfieldsdata[$keyclassline] = $classlinedata;
        $keyclassline++;
        }

    //Increment the pointer
    $classpointer++;
    }

//Retrieve the race lines from the form
$racerowspointer = 1;
$forminputdata = array();
while ($racerowspointer <= $totalracerows)
    {
    $formdataline = array();
    //Retrieve field data and add to formdataline array
    foreach ($racefieldsget as $field)
        {
        $postfieldname = $field . $racerowspointer;
        $formdataline[$field] = $_POST[$postfieldname];
        //Make the race class upper case when being added
        if ($field != "FreeText")
           $formdataline[$field] = strtoupper($formdataline[$field]);
        }

    //Check if the user editable fields have any contents, if so add to array
    $checkline = implode("", $formdataline);
    if ($checkline != '')
        {
        //Get the data from the array of class data
        $formdataline = array_merge($formdataline,$classfieldsdata[$racerowspointer]);
        array_push($forminputdata,$formdataline);
        }
    
    //increment class form row pointer
    $racerowspointer++;
    }
?>