<?php
//Get the class as it appears in the races database table
if (isset($_POST['DBClass']) == true)
  $racenametoset = $_POST['DBClass'];

//Check if any of the new line buttons have been pressed
$newlineno = 1;
$newlineflag = false;
$checkraceline = "RaceName" . $newlineno;
while ((isset($_POST[$checkraceline]) == true) AND ($newlineflag == false))
  {
  //If the new line button has been pressed, set the flag to the race
  $newlinebuttoncheck = "NewLine" . $newlineno;
  if (isset($_POST[$newlinebuttoncheck]) == true)
    $newlineflag = $newlineno;

  //Increment the check number and race name field
  $newlineno++;
  $checkraceline = "RaceName" . $newlineno;
  }

//Get input from the form
if (($newlineflag != true) OR (isset($_POST['FinalCheck']) == true) OR (isset($_POST['AddClasses']) == true))
  {
  $racenametoset = $_POST['DBClass'];
  include $engineslocation . "class-formtoclass.php";
  $classdetails = $inputclassesarray;
  }
else
  $classdetails = array();

//Create a substitute class
if (isset($_POST['SubstituteClassSubmit']) == true)
  $substituteclasses = $_POST['SubstituteClass'];

//Add the class to the database if add classes button is pressed
if (isset($_POST['AddClasses']) == true)
  {
  $findclassname = $racenametoset;
  include $engineslocation . "class-assignclasses.php";

  //Unset the racename to set and class details after adding to database
  unset($racenametoset);
  $classdetails = array();
  }

//Get the next unset class in the races table if a class details array is not set
if (isset($racenametoset) == false)
  include $engineslocation . "class-getunassignedclass.php";

if ($racenametoset != false)
  {
  //Look for any autoclasses and populate the class details using engine
  if (isset($substituteclasses) == true)
    $findclassname = $substituteclasses;
  else
    $findclassname = $racenametoset;
  include $engineslocation . "find-autoclasses.php";

  //Message defining which class to set for
  $addclassdisplayhtml = '<p>Specify a class code for:<br>' . $racenametoset . '</p>';

  //Generate the current class name able to account for form input etc
  include $engineslocation . 'format-class.php';

  //Make the add classes form
  $multirowform = true;
  include $engineslocation . "class-form-html.php";

  //Format class adding form
  $classformhtml = '<form action="AddClass" method="post">' . $classformhtml . '</form>';

  //Format and display the name of the race
  $classformhtml = "<p>Input class: " . $racenametoset . "</p>
  <p>Generated class: " . $raceclass . "</p>" . $classformhtml;

  $addclassdisplayhtml = $classformhtml;
  }
else
  {
  //Message to display when all races are completed
  $addclassdisplayhtml = '<p>All classes have been set and there are no more
  unset races or class names to set! All regattas can be released now</p>';
  }

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Add Classes</p>';
$pagehtml = $pagehtml . $addclassdisplayhtml;
$pagehtml = $pagehtml . '</section>';
?>
