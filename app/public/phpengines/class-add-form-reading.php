<?php
//The list of field names to retrieve
$tablefieldsget = array("JSV","MW","CK","Abil","Ages","Spec","FreeText");

//Get the number of race class rows to retrieve and the number of autoclass check boxes to retrieve
$totalatomizedclasses = $_POST['TotalAtomizedClassRows'];
$totaltablerows = $_POST['TotalTableRows'];

//Get the name of the race to set
$racenametoset = $_POST['InputClass'];

//Retrieve contents of race classes inputs and place in lookup array for class lines
$atomizedclasspointer = 1;
$tablerowpointer = 1;

//Retrieve the classes from the form, along with their codes, and put them into the array
$formclasses = array();
while($atomizedclasspointer <= $totalatomizedclasses)
    {
    //Retrieve the race name, and make an array key with this race name
    $racenamefield = "RaceName" . $atomizedclasspointer;
    $racename = $_POST[$racenamefield];
    $formclasses[$racename] = array();

    //Get the autoclass flag from the form and add it to the array
    $autoclassfield = "AutoClass" . $atomizedclasspointer;
    if (isset($_POST[$autoclassfield]) == true)
        $formclasses[$racename]['AutoClass'] = $_POST[$autoclassfield];
    else
        $formclasses[$racename]['AutoClass'] = "Blank";
    
    //Make the array that holds the class codes
    $formclasses[$racename]['Classcodes'] = array();

    //Get the class range from the field, and split to get the start and finish keys for the field range
    $classrangefield = "ClassRange" . $atomizedclasspointer;
    $classrange = $_POST[$classrangefield];
    $classrange = explode("-",$classrange);
    $keyclassline = $classrange[0];
    $endclassline = $classrange[1];

    //Read all of the classlines and add to array if not blank
    while ($keyclassline <= $endclassline)
        {
        //Read each of the fields and add to the form data line array
        $formdataline = array();
        foreach ($tablefieldsget as $field)
            {
            $postfieldname = $field . $keyclassline;
            $formdataline[$field] = $_POST[$postfieldname];
            //Make the race class upper case when being added
            if ($field != "FreeText")
                $formdataline[$field] = strtoupper($formdataline[$field]);
            }
        
        $checkline = implode("", $formdataline);
        if ($checkline != '')
            {
            //Add the form data line to the classes array
            array_push($formclasses[$racename]['Classcodes'],$formdataline);
            }

        $keyclassline++;
        }

    $atomizedclasspointer++;
    }

/*
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
*/
?>