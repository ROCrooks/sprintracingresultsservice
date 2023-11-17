<?php
//Get required files
include_once $engineslocation . 'srrs-required-functions.php';

//Set flags for found a manual class and finishing the search to false
$manualaddclassflag = false;
$endofraces = false;

//Loop that continues automatically adding classes until one that needs assigning has been added
while (($manualaddclassflag == false) AND ($endofraces == false))
    {
    //Get a single unassigned class
    include $engineslocation . "class-getunassignedclass.php";
    
    //Set the end of races flag if no more races have been found
    if ($racenametoset == false)
        $endofraces = true;
    
    if ($racenametoset != false)
        {
        //Find any autoclasses asssociated with that full class name
        $findclassname = $racenametoset;
        include $engineslocation . "find-autoclasses.php";
        
        //Set flag for manually adding a race to false
        $manualaddclassflag = false;

        //Check each atomized class to see if there is an autoclass found for them
        foreach ($foundautoclasses as $foundautoclass)
            {
            if (count($foundautoclass['ClassCodes']) == 0)
                $manualaddclassflag = true;
            }
        
        //Set the class automatically
        if ($manualaddclassflag == false)
            {
            $classesadd = array();
            foreach ($foundautoclasses as $foundautoclass)
                {
                //Set a flag that the race is an autoclass
                $foundautoclass['AutoClass'] = "Is";
                
                //Add the found autoclass to the array to add the classes
                array_push($classesadd,$foundautoclass);
                }
            
            include $engineslocation . "class-assignclasses.php";
            }
        }
    }
?>