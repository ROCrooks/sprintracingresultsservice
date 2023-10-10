<?php
//The list of field names to retrieve
$racefieldsget = array("JSV", "MW", "CK", "Abil", "Age", "Spec", "FreeText");
$classfieldsget = array("RaceName",/*"AddAutoClass", "IsAutoClass", */"ClassRange");

//Get the number of race class rows to retrieve and the number of autoclass check boxes to retrieve
$totalclassrows = $_POST['ClassRows'];
$totalracerows = $_POST['RaceRows'];

echo $totalclassrows . '<br>';
echo $totalracerows . '<br>';

//Retrieve contents of race classes inputs and place in lookup array for class lines
$classpointer = 1;
$classfieldsdata = array();

While($classpointer <= $totalclassrows)
    {
    echo $classpointer . '<br>';

    //Retrieve the data about each race name
    $raceformdataline = array();
    foreach ($classfieldsget as $field)
        {
        $postfieldname = $field . $classpointer;
        $raceformdataline[$field] = $_POST[$postfieldname];
        echo $raceformdataline[$field] . '<br>';
        }

    //Make the start and finish of the class line ranges
    $racerange = explode("-", $raceformdataline['ClassRange']);
    $keyclassline = $racerange[0];
    $endclassline = $racerange[1];
    
    echo $keyclassline . ' to ' . $endclassline . '<br>';

    //Add to look up array for class lines
    while ($keyclassline <= $endclassline)
        {
        $classlinedata = array();
        $classlinedata['RaceName'] = $raceformdataline['RaceName'];
        //$classlinedata['AddAutoClass'] = $raceformdataline['AddAutoClass'];
        //$classlinedata['IsAutoClass'] = $raceformdataline['IsAutoClass'];
        $classfieldsdata[$keyclassline] = $classlinedata;
        $keyclassline++;
    }

    //Increment the pointer
    $classpointer++;
    }

print_r($classfieldsdata);
echo '<br>';

//Retrieve the race lines from the form
$racerowspointer = 1;
$formdata = array();
while ($racerowspointer <= $totalracerows)
    {
    $formdataline = array();
    //Retrieve field data and add to formdataline array
    foreach ($racefieldsget as $field)
        {
        $postfieldname = $field . $classrowspointer;
        $formdataline[$field] = $_POST[$postfieldname];
        }
    /*

    //Check if the user editable fields have any contents, if so add to array
    $checkline = implode("", $formdataline)
    if ($checkline != '') {
        //Get the data from the array of class data
        $formdataline = array_merge($formdataline, $racefieldsdata[$classrowspointer]);
        array_push($formdata, $formdataline);
    }
    */
    
    //increment class form row pointer
    $racerowspointer++;
    }
?>