<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//Get class name from URL
$findclassname = $_GET['class'];

//Get details about how this race is named in the records
include $adminenginesrelativepath . "class-getoneclass.php";
$autoclassdetails = array();
$autoclassdetails['Details'] = $classdetails;
$autoclassdetails['ClassName'] = $autoclassname;
//$autoclassdetails['Type'] = "Auto Class";

//Get details about how this race is named in the records
include $adminenginesrelativepath . "class-getraceclassnames.php";

//Check if the autoclass needs adding
if (in_array($autoclassdetails,$allraceclasses) === false)
  {
  array_push($allraceclasses,$autoclassdetails);
  if (count($allraceclasses) > 1)
    {
    $autoclasswarning = "Warning, there is an autoclass specified which is
    different to classes used in any of the races! Recommend purging this class
    and re-assigning a single class to all races instead.";
    }
  }

//Array to store forms in
$classesformhtml = array();

//Parameters needed for form generator
$multirowform = true;
$classformactionurl = $defaulturls['EditClass'] . $ahrefjoin . "class=" . $findclassname;
//Make each form for race classes
foreach($allraceclasses as $individualclass)
  {
  //Make the form with the class list
  $classdetails = $individualclass['Details'];
  include $adminenginesrelativepath . "class-form-html.php";

  array_push($classesformhtml,$classformhtml);
  }

//Make the HTML forms
$classesformhtml = "<hr>" . implode("<hr>",$classesformhtml) . "<hr>";
?>
<div class="item">
<p><?php echo $findclassname;?></p>

<?php echo $classesformhtml; ?>

<p>Test</p>
</div>
