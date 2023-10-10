<?php
//Function to sort the form lines into the correct order
function sortformlines($a,$b)
  {
  if ($a['RaceName'] == $b['RaceName'])
    {
    if ($a['Line'] == $b['Line'])
      {
      return 0;
      }
    return ($a['Line'] > $b['Line']) ? -1 : 1;
    }
  return ($a['RaceName'] > $b['RaceName']) ? -1 : 1;
  }

//Get the race name and the input class if it has been sent by a form
if (isset($_POST['DBClass']) == true)
  {
  $racenametoset = $_POST['DBClass'];

  if (isset($_POST['InputClass']) == true)
    $inputclass = $_POST['InputClass'];
  else
    $inputclass = $racenametoset;
  }

//Get the input from the form
if (isset($_POST['SubmitClasses']) == true)
  include $engineslocation . "class-add-form-reading.php";

//If add button pressed, add the classes

//If the change input class button is pressed, change the input class

//Get the next unset class in the races table if a class details array is not set
if (isset($racenametoset) == false)
  include $engineslocation . "class-getunassignedclass.php";

if (isset($forminputdata) == false)
  {
  //Get any specified autoclasses
  $findclassname = $inputclass;
  include $engineslocation . "find-autoclasses.php";
  
  //Put the autoclasses into the classes to add array
  $classestoadd = $foundautoclasses;
  unset($foundautoclasses);
  }
else
  {
  //Put the form input into the classes to add array
  $classestoadd = $forminputdata;
  unset($forminputdata);
  }

//Process found autoclasses into form data
$formdata = array();
foreach($classestoadd as $classtoadd)
  {
  //Create array of the race name if it doesn't already exist
  if(array_key_exists($classtoadd['RaceName'],$formdata) == false)
    $formdata[$classtoadd['RaceName']] = array();
  
  //Convert the database data to the form data
  array_push($formdata[$classtoadd['RaceName']],$classtoadd);
  }

//Make the racenamecomponents array if it does not already exist
if (isset($racenamecomponents) == false)
  {
  
  }

//Add the unfound race components to the race form array
foreach($racenamecomponents as $racenamecomponent)
  {
  if (isset($formdata[$racenamecomponent]) == false)
  $formdata[$racenamecomponent] = array();
  }

print_r($formdata);
echo '<br>';

  //unset($findclassname);

//$formdata = $foundautoclasses;
//unset($foundautoclasses);

//Make the form to add
include $engineslocation . "class-form-html.php";

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Add Classes</p>';
$pagehtml = $pagehtml . $classformhtml;
$pagehtml = $pagehtml . '</section>';
?>
