<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//Get class name from URL
$findclassname = $_GET['class'];

//Update the
if (isset($_POST['UpdateClass']) == true)
  {
  //Read the input form to get the class to add
  include $adminenginesrelativepath . "class-formtoclass.php";
  $classdetails = $inputclassesarray;

  //Include the class to add
  include $adminenginesrelativepath . "class-assignclasses.php";
  }

//Temporary class details are retrieved from the form when new line is clicked
if (isset($_POST['NewLine']) == true)
  {
  //Read the input form and make it the only input class
  include $adminenginesrelativepath . "class-formtoclass.php";
  $classdetails = $inputclassesarray;

  //Format the race class for the class being added
  include $publicenginesrelativepath . 'format-class.php';

  //Place class details and name into array
  $allraceclasses = array();
  $allraceclasses[0]['Details'] = $classdetails;
  $allraceclasses[0]['ClassName'] = $raceclass;

  //Note that the class is being updated
  $updatingnote = "Note, this class is being updated currently, upon pressing
  the update button all classes and autoclasses will be updated. The classes
  shown are not those that are contained in the database.";
  }
else
  {
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

  //Wrap form in form
  $classformhtml = $classformhtml . '<p><input type="submit" name="UpdateClass" value="Update"> <input type="submit" name="NewLine" value="New Line"></p>';
  $classformhtml = '<form action="' . $classformactionurl . '" method="post">' . $classformhtml . '</form>';

  array_push($classesformhtml,$classformhtml);
  }

//Make the HTML forms
$classesformhtml = "<hr>" . implode("<hr>",$classesformhtml) . "<hr>";

//Display the notes and warnings
$displaywarnings = array();
if (isset($autoclasswarning) == true)
  array_push($displaywarnings,$autoclasswarning);
if (isset($updatingnote) == true)
  array_push($displaywarnings,$updatingnote);
if (isset($multiracewarning) == true)
  array_push($displaywarnings,$multiracewarning);

//Format warnings into display warning
if (count($displaywarnings) > 0)
  $displaywarnings = '<p>' . implode("<br>",$displaywarnings) . '</p>';
else
  $displaywarnings = '';
?>
<div class="item">
<p><?php echo $findclassname;?></p>

<?php echo $displaywarnings; ?>

<?php echo $classesformhtml; ?>

<p>Test</p>
</div>
