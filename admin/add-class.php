<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

include $adminenginesrelativepath . "class-getunassignedclass.php";

if ($racenametoset != false)
  {
  //Message defining which class to set for
  $addclassdisplayhtml = '<p>Specify a class code for:<br>' . $racenametoset . '</p>';

  if (isset($classdetails) == false)
    $classdetails = array();

  //Generate the current class name able to account for form input etc
  include $publicenginesrelativepath . 'format-class.php';

  print_r($classdetails);
  echo $raceclass . "<br>";
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
