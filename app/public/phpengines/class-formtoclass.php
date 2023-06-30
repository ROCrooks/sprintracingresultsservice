<?php
//Names of the fields to retrieve
$classfieldnames = array("RaceName","AutoClass","JSV","MW","CK","Abil","Spec","Ages","FreeText");

//Name of the initial fields to retrieve
$racerowkey = 1;
$racecheckfield = "RaceName" . $racerowkey;

//Create array to insert classes
$insertclassesarray = array();

while (isset($_POST[$racecheckfield]) == true)
  {
  //Make the field name for the JSV check
  $subclassrowkey = 1;
  $classcheckfield = "JSV" . $racerowkey . "-" . $subclassrowkey;

  while (isset($_POST[$classcheckfield]) == true)
    {
    $insertclassesline = array();
    foreach ($classfieldnames as $classfieldkey=>$classfieldname)
      {
      //Make the field name
      $postfield = $classfieldname . "-" . $racerowkey;
      if ($classfieldkey > 1)
        $postfield = $postfield . "-" . $subclassrowkey;

      //Retrieve the field and add it to the insert class array line
      $insertclassesline[$classfieldname] = $_POST[$postfield];
      }

    //Add the line to the insert classes array
    array_push($insertclassesarray,$insertclassesline);

    //Make the field name for the JSV check for next cycle of loop
    $subclassrowkey++;
    $jsvfield = "JSV" . $racerowkey . "-" . $subclassrowkey;
    }

  //Make the names for the fields for next loop cycle
  $racerowkey++;
  $racecheckfield = "RaceName" . $racerowkey;
  }
?>
