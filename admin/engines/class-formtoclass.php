<?php
//Names of the fields to retrieve
$fieldnames = array("Key","JSV","MW","CK","Abil","Spec","Ages","FreeText");

//Number of the row
$classrowkey = 1;

//Name of the field to retrieve
$checkfield = "FreeText" . $classrowkey;

//Loop to read all rows
$inputclassesarray = array();
while (isset($_POST[$checkfield]) == true)
  {
  //Flag that the row is empty so it's not added
  $emptyrow = true;

  //Read each field
  $classrow = array();
  foreach($fieldnames as $field)
    {
    $formfield = $field . $classrowkey;
    $classrow[$field] = $_POST[$formfield];

    if ($classrow[$field] != '')
      $emptyrow = false;
    }

  //Put row to array if it is not empty
  if ($emptyrow == false)
    array_push($inputclassesarray,$classrow);

  //Increment row and checkfield
  $classrowkey++;
  $checkfield = "FreeText" . $classrow;
  }

?>
