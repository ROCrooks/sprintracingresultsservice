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

$racesformhtml = array();

foreach($allraceclasses as $raceclass)
  {

  }
?>
<div class="item">
<p><?php echo $findclassname;?></p>

<?php print_r($allraceclasses);?>
</div>
