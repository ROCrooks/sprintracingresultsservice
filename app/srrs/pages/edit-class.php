<?php
//Function to sort classes
function srrsclassessort($a, $b)
	{
	if ($a['JSV'] == $b['JSV'])
		{
		if ($a['MW'] == $b['MW'])
			{
      if ($a['CK'] == $b['CK'])
        {
        if ($a['Abil'] == $b['Abil'])
          {
          if ($a['Spec'] == $b['Spec'])
            {
            if ($a['Ages'] == $b['Ages'])
              {
              if ($a['Band'] == $b['Band'])
                {
                if ($a['ShowBand'] == $b['ShowBand'])
                  {
                  if ($a['FreeText'] == $b['FreeText'])
                    {
                    return 0;
                    }
                  }
                }
              }
            }
          }
        }
			}
		}
	return ($a < $b) ? -1 : 1;
	}

//Get class name from URL
$autoclassfind = $_GET['class'];

//Find the codes associated with that autoclass
include $srrsenginesfolder . "find-single-autoclass.php";

//The script to run to update the autoclass
if (isset($_POST['submit']) == true)
  {
  //Array of output messages
  $updatemessages = array();

  //Function that checks if the fields have been set in the input form
  function checkpostfunction($line,$fields)
    {
    //The default output is that the line input is false
    $lineinput = false;

    //Check every field to see if it has any content
    foreach($fields as $field)
        {
        $checkpost = $field . $line;
        if (isset($_POST[$checkpost]) == true)
          {
          if ($_POST[$checkpost] != "")
            $lineinput = true;
          } 
        }
    
    //Return line input
    return $lineinput;
    }
  
  //Function that creates the constraint variables
  function constraintvaluesarray($racename,$values)
    {
    //Start the array with the racename
    $outputarray = array($racename);

    //Add each of the class values to the array
    foreach($values as $value)
      {
      array_push($outputarray,$value);
      }
    
    //Return the filled array
    return $outputarray;
    }

  //The fields that are found in both the database entry and the form
  $dualfields = array("JSV","MW","CK","Abil","Spec","Ages","Band","ShowBand","FreeText");

  //Read each line of the form and add it to the array
  $formfields = array();
  $formline = 1;
  while (checkpostfunction($formline,$dualfields) == true)
    {
    //Add each field from the input form to the line in the input fields array
    $formfieldsarrayline = array();
    foreach ($dualfields as $inputfield)
      {
      $formitemname = $inputfield . $formline;
      if (isset($_POST[$formitemname]) == true)
        {
        if (($inputfield != "FreeText") AND ($inputfield != "Band") AND ($inputfield != "ShowBand"))
          $formfieldsarrayline[$inputfield] = strtoupper($_POST[$formitemname]);
        else
          $formfieldsarrayline[$inputfield] = $_POST[$formitemname];
        }
      else
        $formfieldsarrayline[$inputfield] = 0;
      } 
    
    //Retrieve the delete flag
    $formitemname = "Delete" . $formline;
    if (isset($_POST[$formitemname]) == true)
      $formfieldsarrayline['Delete'] = $_POST[$formitemname];
    else
      $formfieldsarrayline['Delete'] = 0;

    //Add this line to the array from the form input
    array_push($formfields,$formfieldsarrayline);
    $formline++;
    }

  //Check the form fields and compare them to the rows
  $inputlinekey = 0;
  while ($inputlinekey < count($formfields))
    {
    //Retrieve delete flag and remove it from the input fields array
    $deleteflag = $formfields[$inputlinekey]['Delete'];
    unset($formfields[$inputlinekey]['Delete']);

    if ($deleteflag == 1)
      {
      //Set the delete class statement if it hasn't already been set
      if (isset($deleteclassstmt) == false)
        {
        //Set the SQL query constraints if they haven't already been set
        if (isset($sqlconstraints) == false)
          $sqlconstraints = "WHERE `RaceName` = ? AND `" . implode("` = ? AND `",array_keys($autoclass[$inputlinekey])) . "` = ?";
        
        $deleteclasssql = "DELETE FROM `autoclasses` " . $sqlconstraints;
        $deleteclassstmt = dbprepare($srrsdblink,$deleteclasssql);
        }
      
      //Make the values for deleting the class
      $deleteclassvalues = constraintvaluesarray($_GET['class'],$formfields[$inputlinekey]);

      //Update message
      array_push($updatemessages,"Class deleted from autoclass!");

      //Run the edit class statement
      if (isset($deleteclassstmt) == true)
        {
        dbexecute($deleteclassstmt,$deleteclassvalues);
        }

      //Delete the row from the form input lines
      unset($formfields[$inputlinekey]);
      }
    elseif (isset($autoclass[$inputlinekey]) == false)
      {
      //Set the add class statement if it hasn't already been set
      if (isset($addclassstmt) == false)
        {
        //Make the values section of the SQL query
        $valuesarraysize = count($dualfields);
        $valuesarray = array_fill(0,$valuesarraysize,"?");
        $valuessql = " VALUES (?, " . implode(", ",$valuesarray) . ")";

        $addclasssql = "INSERT INTO `autoclasses` (`RaceName`, `" . implode("`, `",array_keys($autoclass[$inputlinekey-1])) . "`)" . $valuessql;
        $addclassstmt = dbprepare($srrsdblink,$addclasssql);
        }
      
      //Default the band to the 0 if it's not specified
      if ($formfields[$inputlinekey]['Band'] == '')
        {
        $formfields[$inputlinekey]['Band'] = 0;
        $formfields[$inputlinekey]['ShowBand'] = 0;
        }
      
      //Make the values for adding a new class
      $addclassvalues = constraintvaluesarray($_GET['class'],$formfields[$inputlinekey]);
      
      //Update message
      array_push($updatemessages,"Class added to autoclass!");

      //Run the add class statement
      if (isset($addclassstmt) == true)
        {
        dbexecute($addclassstmt,$addclassvalues);
        }
      }
    elseif ($formfields[$inputlinekey] != $autoclass[$inputlinekey])
      {
      //Set the edit class statement if it hasn't already been set
      if (isset($editclassstmt) == false)
        {
        //Set the SQL query constraints if they haven't already been set
        if (isset($sqlconstraints) == false)
          $sqlconstraints = "WHERE (`RaceName` = ? AND `" . implode("` = ? AND `",array_keys($autoclass[$inputlinekey])) . "` = ?)";
        
        //SQL syntax to make the updates
        $sqlupdate = "`" . implode("` = ?, `",array_keys($formfields[$inputlinekey])) . "` = ? ";

        $editclasssql = "UPDATE `autoclasses` SET " . $sqlupdate . $sqlconstraints;
        $editclassstmt = dbprepare($srrsdblink,$editclasssql);
        }
      
      //Make the arrays of values for the original and new classes
      $newclassvalues = array_values($formfields[$inputlinekey]);
      $oldclassvalues = constraintvaluesarray($_GET['class'],$autoclass[$inputlinekey]);
      //Merge original and new classes to make constraints for query
      $editclassvalues = array_merge($newclassvalues,$oldclassvalues);
      
      //Update message
      array_push($updatemessages,"Class edited in the autoclass!");
      
      //Run the edit class statement
      if (isset($editclassstmt) == true)
        {
        dbexecute($editclassstmt,$editclassvalues);
        }
      }
    $inputlinekey++;
    }

  //Make the class that's displayed in the form the same as that submitted in the form
  $displayclass = $formfields;
  }
else
  {
  //Make the class that's displayed in the form the same as that retrieved from the autoclasses
  $displayclass = $autoclass;
  }

//Define field and cell sizes
include $srrsenginesfolder . "class-field-size-info.php";

$classformhtml = '<form action="EditClass?class=' . $autoclassfind . '" method="post">';
$classformhtml = $classformhtml . '<input type="hidden" name="" value="' . $autoclassfind . '"</p>';
$classformhtml = $classformhtml . '<p>Edit the autoclass codes for: ' . $autoclassfind . '</p>';

//Make the autoclass into a form table
if (count($autoclass) > 0)
  {
  //Form headings
  $classformhtml = $classformhtml . '<div style="display: table-row;">';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><p>JSV</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><p>MW</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><p>CK</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><p>Abil</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><p>Spec</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><p>Ages</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Band'] . 'px; display: table-cell;"><p>Band</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"><p>Show Band</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><p>FreeText</p></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Delete'] . 'px; display: table-cell;"><p>Delete</p></div>';
  $classformhtml = $classformhtml . '</div>';

  //Display each line in the autoclass in separate fields
  $formrow = 1;
  foreach ($displayclass as $displayclassline)
    {
    //Add form elements to line
      $classformhtml = $classformhtml . '<div style="display: table-row;">';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" value="' . $displayclassline['JSV'] . '" name="JSV' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" value="' . $displayclassline['MW'] . '" name="MW' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" value="' . $displayclassline['CK'] . '" name="CK' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" value="' . $displayclassline['Abil'] . '" name="Abil' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" value="' . $displayclassline['Spec'] . '" name="Spec' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" value="' . $displayclassline['Ages'] . '" name="Ages' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Band'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Band'] . '" value="' . $displayclassline['Band'] . '" name="Band' . $formrow . '"></div>';
      if ($displayclassline['ShowBand'] == 1)
        $bandlineshow = " checked";
      else
        $bandlineshow = "";
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"><input type="checkbox" value="1" id="ShowBand' . $formrow . '" name="ShowBand' . $formrow . '"' . $bandlineshow . '></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="' . $displayclassline['FreeText'] . '" name="FreeText' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"><input type="checkbox" value="1" id="Delete' . $formrow . '" name="Delete' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '</div>';

      //Increment form row count
      $formrow++;
    }
  
  //Add an empty cell to the line
  $classformhtml = $classformhtml . '<div style="display: table-row;">';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" value="" name="JSV' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" value="" name="MW' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" value="" name="CK' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" value="" name="Abil' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" value="" name="Spec' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" value="" name="Ages' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Band'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Band'] . '" value="" name="Band' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"><input type="checkbox" value="1" id="ShowBand' . $formrow . '" name="ShowBand' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="" name="FreeText' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"></div>';
  $classformhtml = $classformhtml . '</div>';
  }

//Make the submit button for the form
$classformhtml = $classformhtml . '<p><input type="submit" name="submit" value="Submit"></p>';

//Close the form
$classformhtml = $classformhtml . '</form>';

//Make the page HTML
$pagehtml = "<section>" . $classformhtml . "</section>";

//Add the edit message
if (isset($updatemessages) == true)
  {
  $updatemessages = implode("<br>",$updatemessages);
  $pagehtml = "<section><p>" . $updatemessages . "</p></section>" . $pagehtml;
  }

/*
if (isset($_POST['AutoClass']) == true)
  {
  $autoclass = $_POST['AutoClass'];
  if ($autoclass == "true")
    $autoclass = true;
  }
else
  $autoclass = false;

//Update the
if (isset($_POST['UpdateClass']) == true)
  {
  //Read the input form to get the class to add
  include $srrsenginesfolder . "class-formtoclass.php";
  $classdetails = $inputclassesarray;

  //Purge Old classes
  include $srrsenginesfolder . "class-purgeclasses.php";

  //Include the class to add
  include $srrsenginesfolder . "class-assignclasses.php";
  }

//Temporary class details are retrieved from the form when new line is clicked
if (isset($_POST['NewLine']) == true)
  {
  //Read the input form and make it the only input class
  include $srrsenginesfolder . "class-formtoclass.php";
  $classdetails = $inputclassesarray;

  //Format the race class for the class being added
  include $srrsenginesfolder . 'format-class.php';

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
  include $srrsenginesfolder . "class-getoneclass.php";
  $autoclassdetails = array();
  $autoclassdetails['Details'] = $classdetails;
  $autoclassdetails['ClassName'] = $autoclassname;
  //$autoclassdetails['Type'] = "Auto Class";

  //Get details about how this race is named in the records
  include $srrsenginesfolder . "class-getraceclassnames.php";

  //Check if there is an autoclass
  if ($autoclassdetails['ClassName'] == "No Autoclass Specified")
    {
    $autoclasswarning = "Note: No autoclass is specified, if this is a common
    class it is recommended to have one.";
    }
  //Check if the autoclass needs adding
  elseif (in_array($autoclassdetails,$allraceclasses) === false)
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

//Set autoclass if there isn't one
if (isset($autoclassdetails) == false)
  $autoclassdetails = false;

//Parameters needed for form generator
$multirowform = true;
$classformactionurl = "EditClass?class=" . $findclassname;
//Make each form for race classes
foreach($allraceclasses as $individualclass)
  {
  //If it matches the autoclass set autoclass flag to true
  if ($individualclass == $autoclassdetails)
    $autoclass = true;

  //Make the form with the class list
  $classdetails = $individualclass['Details'];
  include $srrsenginesfolder . "class-form-html.php";

  //Add the name of this class
  $classformhtml = '<p>' . $individualclass['ClassName'] . '</p>' . $classformhtml;

  //Add checkbox to make an autoclass
  $classformhtml = $classformhtml . '<p>This is an autoclass: <input type="checkbox" name="AutoClass" value="checked"';

  //Automatically checked if it is the class in the autoclass table
  if ($autoclass == true)
    $classformhtml = $classformhtml . ' checked';

  $classformhtml = $classformhtml . '></p>';

  //Wrap form in form HTML tags
  $classformhtml = $classformhtml . '<p><input type="submit" name="UpdateClass" value="Update"> <input type="submit" name="NewLine" value="New Line"></p>';
  $classformhtml = '<form action="' . $classformactionurl . '" method="post">' . $classformhtml . '</form>';

  array_push($classesformhtml,$classformhtml);
  }

//Make the HTML forms
$classesformhtml = "<hr>" . implode("<hr>",$classesformhtml);

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

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Class Editor</p>';
$pagehtml = $pagehtml . '<p>Editing the class: ' . $findclassname . '</p>';

$pagehtml = $pagehtml . $displaywarnings;

$pagehtml = $pagehtml . $classesformhtml;

$pagehtml = $pagehtml . '</section>';
*/
?>
