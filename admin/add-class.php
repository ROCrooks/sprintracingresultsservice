<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//Get input from the form
if ((isset($_POST['NewLine']) == true) OR (isset($_POST['AddClass']) == true) OR (isset($_POST['FinalCheck']) == true))
  {
  include $adminenginesrelativepath . "class-formtoclass.php";
  }
else
  $classdetails = array();

if ((isset($_POST['NewLine']) == false) AND (isset($_POST['FinalCheck']) == false))
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
<?php echo $addclassdisplayhtml; ?>
</div>
