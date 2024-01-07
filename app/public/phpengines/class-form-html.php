<?php
//Example of a class to add in a consistent format
/*$classesadd = array();
$classesaddline = array();
$classesaddline['AutoClass'] = "Add";
$classesaddline['ClassCodes'] = array();
$classesaddline['ClassCodes'][0] = array("JSV"=>"S","MW"=>"M","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","FreeText"=>"");
$classesadd['MENS A K'] = $classesaddline;
$classesaddline = array();
$classesaddline['AutoClass'] = "Is";
$classesaddline['ClassCodes'] = array();
$classesaddline['ClassCodes'][0] = array("JSV"=>"S","MW"=>"W","CK"=>"K","Spec"=>"","Abil"=>"A","Ages"=>"","FreeText"=>"");
$classesadd['WOMENS A K'] = $classesaddline;
$formclasses = $classesadd;

print_r($formclasses);*/

$classformhtml = '';

$classformhtml = $classformhtml . '<form action="AddClass" method="post">';
$classformhtml = $classformhtml . '<p>Assigning classes to: ' . $racenametoset . '</p>';
$classformhtml = $classformhtml . '<p>Update the input class text to attempt to find autoclasses.</p>';
$classformhtml = $classformhtml . '<input type="hidden" name="DBClass" value="' . $racenametoset . '">';
$classformhtml = $classformhtml . '<p>Update class name to: <input type="text" name="InputClass" value="' . $inputclass . '"></p>';
$classformhtml = $classformhtml . '<p><input type="submit" name="UpdateInput" value="Update"></p>';
$classformhtml = $classformhtml . '</form>';

//Define cell widths
$classwidths = array();
$classwidths['JSV'] = 50;
$classwidths['MW'] = $classwidths['JSV'];
$classwidths['CK'] = $classwidths['JSV'];
$classwidths['Abil'] = 70;
$classwidths['Spec'] = $classwidths['Abil'];
$classwidths['Ages'] = $classwidths['Abil'];
$classwidths['Band'] = 70;
$classwidths['ShowBand'] = 70;
$classwidths['FreeText'] = 100;
$classwidths['Button'] = 60;

//Set field sizes
$fieldsizes = array();
$fieldsizes['JSV'] = 2;
$fieldsizes['MW'] = $fieldsizes['JSV'];
$fieldsizes['CK'] = $fieldsizes['JSV'];
$fieldsizes['Abil'] = 6;
$fieldsizes['Spec'] = 6;
$fieldsizes['Ages'] = $fieldsizes['Abil'];
$fieldsizes['Band'] = $fieldsizes['Ages'];
$fieldsizes['FreeText'] = 15;

//Form headings
$classformhtml = $classformhtml . '<div style="display: table-row;">';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><p>JSV</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><p>MW</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><p>CK</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><p>Abil</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><p>Spec</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><p>Ages</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Band'] . 'px; display: table-cell;"><p>Band</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"><p>Show<br>Band</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><p>FreeText</p></div>';
$classformhtml = $classformhtml . '</div>';

//Form row value that is incremented
$formrow = 1;
$classrow = 1;

$classformhtml = $classformhtml . '<form action="AddClass" method="post">';

foreach ($formclasses as $itemkey=>$formitem)
  {
  //Display the name of the individual race class on the page
  $classformhtml = $classformhtml . '<p>' . $itemkey . '</p>';
  
  //Retrieve the autoclass flag and the race classes as lines
  $autoclassflag = $formitem['AutoClass'];
  $classlines = $formitem['ClassCodes'];

  $classformhtml = $classformhtml . '<input type="hidden" name="RaceName' . $classrow . '" value="' . $itemkey . '">';
  
  //The start of the range that the class fields refer to
  $startrow = $formrow;
  
  if ($autoclassflag == "Is")
    {
    foreach ($classlines as $classline)
      {
      //Add form elements to line
      $classformhtml = $classformhtml . '<div style="display: table-row;">';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['JSV'] . '" value="' . $classline['JSV'] . '" name="JSV' . $formrow . '"><p>' . $classline['JSV'] . '</p></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['MW'] . '" value="' . $classline['MW'] . '" name="MW' . $formrow . '"><p>' . $classline['MW'] . '</p></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['CK'] . '" value="' . $classline['CK'] . '" name="CK' . $formrow . '"><p>' . $classline['CK'] . '</p></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['Abil'] . '" value="' . $classline['Abil'] . '" name="Abil' . $formrow . '"><p>' . $classline['Abil'] . '</p></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['Spec'] . '" value="' . $classline['Spec'] . '" name="Spec' . $formrow . '"><p>' . $classline['Spec'] . '</p></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['Ages'] . '" value="' . $classline['Ages'] . '" name="Ages' . $formrow . '"><p>' . $classline['Ages'] . '</p></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Band'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['Band'] . '" value="' . $classline['Band'] . '" name="Band' . $formrow . '"><p>' . $classline['Band'] . '</p></div>';
      //Format the band show to be a yes or no
      if ($classline['ShowBand'] == 1)
        $bandlineshow = "Yes";
      else
        $bandlineshow = "No";
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"><input type="hidden" value="' . $classline['ShowBand'] . '" name="Band' . $formrow . '"><p>' . $bandlineshow . '</p></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="hidden" size="' . $fieldsizes['FreeText'] . '" value="' . $classline['FreeText'] . '" name="FreeText' . $formrow . '"><p>' . $classline['FreeText'] . '</p></div>';
      $classformhtml = $classformhtml . '</div>';

      //Increment form row count
      $formrow++;
      }
    
    //Add the default autoclass box for Is
    $classformhtml = $classformhtml . '<p>This is already an automatic class.</p>';
    $classformhtml = $classformhtml . '<input type="hidden" name="AutoClass' . $classrow . '" value="Is">';
    }
  else
    {
    foreach ($classlines as $classline)
      {
      //Add form elements to line
      $classformhtml = $classformhtml . '<div style="display: table-row;">';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" value="' . $classline['JSV'] . '" name="JSV' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" value="' . $classline['MW'] . '" name="MW' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" value="' . $classline['CK'] . '" name="CK' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" value="' . $classline['Abil'] . '" name="Abil' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" value="' . $classline['Spec'] . '" name="Spec' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" value="' . $classline['Ages'] . '" name="Ages' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Band'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Band'] . '" value="' . $classline['Band'] . '" name="Band' . $formrow . '"></div>';
      if ($classline['ShowBand'] == 1)
        $bandlineshow = " checked";
      else
        $bandlineshow = "";
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['ShowBand'] . 'px; display: table-cell;"><input type="checkbox" value="1" id="ShowBand' . $formrow . '" name="ShowBand' . $formrow . '"' . $bandlineshow . '></div>';
      $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="' . $classline['FreeText'] . '" name="FreeText' . $formrow . '"></div>';
      $classformhtml = $classformhtml . '</div>';

      //Increment form row count
      $formrow++;
      }
    
    //Add last empty row
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
    $classformhtml = $classformhtml . '</div>';

    //Increment form row count
    $formrow++;
    
    //Display the autoclass box on the form
    if ($autoclassflag == "Blank")
      $classformhtml = $classformhtml . '<p>Add automatic class <input type="checkbox" name="AutoClass' . $classrow . '" value="Add"></p>';
    elseif ($autoclassflag == "Add")
      $classformhtml = $classformhtml . '<p>Add automatic class <input type="checkbox" name="AutoClass' . $classrow . '" value="Add" checked></p>';
    }

  //The end of the range that the class fields refer to
  $endrow = $formrow-1;
  
  //The class range
  $classformhtml = $classformhtml . '<input type="hidden" name="ClassRange' . $classrow . '" value="' . $startrow . '-' . $endrow . '">';

  //Increment form and class row count
  $classrow++;
  }

//Hidden global data to send through the form
$classformhtml = $classformhtml . '<input type="hidden" name="TotalAtomizedClassRows" value="' . $classrow-1 . '">';
$classformhtml = $classformhtml . '<input type="hidden" name="TotalTableRows" value="' . $formrow-1 . '">';
$classformhtml = $classformhtml . '<input type="hidden" name="DBClass" value="' . $racenametoset . '">';
$classformhtml = $classformhtml . '<input type="hidden" name="InputClass" value="' . $inputclass . '">';

//Submit buttons
$classformhtml = $classformhtml . '<p>';
$classformhtml = $classformhtml . '<input type="submit" name="SubmitClasses" value="Add Classes">';
$classformhtml = $classformhtml . ' ';
$classformhtml = $classformhtml . '<input type="submit" name="SubmitClasses" value="Final Check">';
$classformhtml = $classformhtml . '</p>';
$classformhtml = $classformhtml . '</form>';
?>
