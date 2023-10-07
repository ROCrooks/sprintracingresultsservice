<?php
//The list of field names to retrieve
$classfieldsget = array("JSV", "MW", "CK", "Abil", "Age", "Spec", "FreeText");
$racefieldsget = array("RaceName", "AddAutoClass", "IsAutoClass", "ClassRange");

//Get the number of race class rows to retrieve and the number of autoclass check boxes to retrieve
$classfieldsget = $_POST['ClassRows'];
$raceclassboxes = $_POST['RaceClassBoxes'];

echo $classfieldsget . '<br>';
echo $raceclassboxes . '<br>';

/*
//Retrieve contents of race classes inputs and place in lookup array for class lines
$raceclasspointer = 1;
$racefieldsdata = array();
While($autoclasspointer <= $raceclassboxes)
    {
    $raceformdataline = array();

    //Retrieve the data about each race name
    foreach ($racefieldsget as $field) {
        $postfieldname = $field . $raceclasspointer;
        $raceformdataline[$field] = $_POST[$postfieldname];
    }

    //Make the start and finish of the class line ranges
    $racerange = explode("-", $raceformdataline['ClassRange']);
    $keyclassline = $racerange[0];
    $endclassline = $racerange[1];

    //Add to look up array for class lines
    while ($keyclassline <= $endclassline) {
        $classlinedata = array();
        $classlinedata['RaceName'] = $raceformdata['RaceName'];
        $classlinedata['AddAutoClass'] = $raceformdata['AddAutoClass'];
        $classlinedata['IsAutoClass'] = $raceformdata['IsAutoClass'];
        $racefieldsdata[$keyclassline] = $classlinedata;
        $keyclassline++;
    }

    //Increment the pointer
    $raceclasspointer++;
    }

$classrowspointer = 1;
$formdata = array();
while ($classrowspointer <= $classfieldsget)
    {
    $formdataline = array();
    //Retrieve field data and add to formdataline array
    foreach ($classfieldsget as $field) {
        $postfieldname = $field . $classrowspointer;
        $formdataline[$field] = $_POST[$postfieldname];
    }

    //Check if the user editable fields have any contents, if so add to array
    $checkline = implode("", $formdataline)
    if ($checkline != '') {
        //Get the data from the array of class data
        $formdataline = array_merge($formdataline, $racefieldsdata[$classrowspointer]);
        array_push($formdata, $formdataline);
    }

    //increment class form row pointer
    $classrowspointer++;
    }
*/
?>