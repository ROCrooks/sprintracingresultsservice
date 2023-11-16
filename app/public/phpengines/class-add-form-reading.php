<?php
//The list of field names to retrieve
$tablefieldsget = array("JSV","MW","CK","Abil","Ages","Spec","FreeText");

//Get the number of race class rows to retrieve and the number of autoclass check boxes to retrieve
$totalatomizedclasses = $_POST['TotalAtomizedClassRows'];
$totaltablerows = $_POST['TotalTableRows'];

//Get the name of the race to set
$racenametoset = $_POST['DBClass'];
$inputclass = $_POST['InputClass'];

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
    $formclasses[$racename]['ClassCodes'] = array();

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
            array_push($formclasses[$racename]['ClassCodes'],$formdataline);
            }

        $keyclassline++;
        }

    $atomizedclasspointer++;
    }
?>