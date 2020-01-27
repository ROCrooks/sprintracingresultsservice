<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//Get input from the form
if ((isset($_POST['NewLine']) == true) OR (isset($_POST['AddClass']) == true) OR (isset($_POST['FinalCheck']) == true))
  {
  $racenametoset = $_POST['ClassName'];
  include $adminenginesrelativepath . "class-formtoclass.php";
  $classdetails = $inputclassesarray;
  }
else
  $classdetails = array();

//Get the autoclass flag
if (isset($_POST['AutoClass']) == true)
  {
  $autoclass = $_POST['AutoClass'];
  if ($autoclass == "true")
    $autoclass = true;
  }
else
  $autoclass = false;

//Add the class to the database if button is pressed
if (isset($_POST['AddClass']) == true)
  {
  $findclassname = $racenametoset;
  include $adminenginesrelativepath . "class-assignclasses.php";

  //Unset the racename to set and class details after adding to database
  unset($racenametoset);
  $classdetails = array();
  }

//Get the next unset class in the races table if a class details array is not set
if (isset($racenametoset) == false)
  include $adminenginesrelativepath . "class-getunassignedclass.php";

if ($racenametoset != false)
  {
  //Message defining which class to set for
  $addclassdisplayhtml = '<p>Specify a class code for:<br>' . $racenametoset . '</p>';

  //Generate the current class name able to account for form input etc
  include $publicenginesrelativepath . 'format-class.php';

  //Make the add classes form
  $multirowform = true;
  include $adminenginesrelativepath . "class-form-html.php";

  //Format class adding form
  $classformhtml = '<form action="' . $defaulturls['AddClass'] . '" method="post">' . $classformhtml;
  $classformhtml = $classformhtml . '<p>Make Autoclass: <input type="checkbox" name="AutoClass" value="checked"';
  if ($autoclass == true)
    $classformhtml = $classformhtml . ' checked';
  $classformhtml = $classformhtml . '></p>';
  $classformhtml = $classformhtml . '<input type="hidden" name="ClassName" value="' . $racenametoset . '">';
  $classformhtml = $classformhtml . '<p>';
  $classformhtml = $classformhtml . '<input type="submit" name="NewLine" value="New Line"> ';
  $classformhtml = $classformhtml . '<input type="submit" name="FinalCheck" value="Final Check"> ';
  $classformhtml = $classformhtml . '<input type="submit" name="AddClass" value="Add">';
  $classformhtml = $classformhtml . '</p>';
  $classformhtml = $classformhtml . '</form>';

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
?>

<div class="item">
<p class="blockheading">Add Classes</p>
<?php echo $addclassdisplayhtml; ?>
</div>
