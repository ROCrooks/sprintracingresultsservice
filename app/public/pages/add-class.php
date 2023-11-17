<?php
//Flag to search for new race classes to add to database
$findnextrace = true;

//Update the race name input from form
if (isset($_POST['UpdateInput']) == true)
  {
  $racenametoset = $_POST['DBClass'];
  $inputclass = $_POST['InputClass'];
  
  //Look up autoclasses for the input class name
  $findclassname = $inputclass;
  include $engineslocation . "find-autoclasses.php";
  unset($findclassname);

  //Make the form classes (as output in the HTML) those found by searching for the input class
  $formclasses = $foundautoclasses;

  //Flag to not look up the next race in the database
  $findnextrace = false;
  $endofraces = false;
  }
elseif (isset($_POST['SubmitClasses']) == true)
  {
  include $engineslocation . "class-add-form-reading.php";
  
  //If add button pressed, add the classes
  if ($_POST['SubmitClasses'] == "Add Classes")
    {
    //Assign the classes
    $classesadd = $formclasses;
    include $engineslocation . 'class-assignclasses.php';
    
    //Clear the variables which came from the form originally if the form data was added to the database
    unset($totalclassrows);
    unset($totalracerows);
    unset($racenametoset);
    unset($inputclass);
    unset($classesadd);
    unset($classfieldsdata);
    unset($forminputdata);
    unset($racenamecomponents);
    
    //As classes have been added, flag to search for the new race name
    $findnextrace = true;
    }
  else
    {
    //Make the form classes the form input data for a final check
    $formclasses = $formclasses;
    $findnextrace = false;
    $endofraces = false;
    }    
  }

//Get the next racename to set and automatically set any races that can be found in the database
if ($findnextrace == true)
  {
  include $engineslocation . "class-findnextracename.php";
  if ($endofraces == false)
    {
    $formclasses = $foundautoclasses;
    $inputclass = $racenametoset;
    }
  }

//Make the form to add
if ($endofraces == false)
  include $engineslocation . "class-form-html.php";
else
  $classformhtml = '<p>Success! All race classes have been set!</p>';

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Add Classes</p>';
$pagehtml = $pagehtml . $classformhtml;
$pagehtml = $pagehtml . '</section>';
?>
