<?php
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
$fieldsizes['FreeText'] = 15;

//Form headings
$classformhtml = $classformhtml . '<div style="display: table-row;">';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><p>JSV</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><p>MW</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><p>CK</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><p>Abil</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><p>Spec</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><p>Ages</p></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><p>FreeText</p></div>';
$classformhtml = $classformhtml . '</div>';

//Form row value that is incremented
$formrow = 1;
$classrow = 1;

$classformhtml = $classformhtml . '<form action="AddClass" method="post">';

foreach ($formdata as $itemkey=>$formitem)
  {
  //Display the name of the individual race class on the page
  $classformhtml = $classformhtml . '<p>' . $itemkey . '</p>';
  
  //Retrieve the autoclass flag and remove it to prevent confusion when reading classes
  $autoclassflag = $formitem['AutoClass'];
  unset($formitem['AutoClass']);

  $classformhtml = $classformhtml . '<input type="hidden" name="RaceName' . $classrow . '" value="' . $itemkey . '">';
  
  //The start of the range that the class fields refer to
  $startrow = $formrow;
  foreach ($formitem as $formline)
    {
    //Add form elements to line
    $classformhtml = $classformhtml . '<div style="display: table-row;">';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" value="' . $formline['JSV'] . '" name="JSV' . $formrow . '"></div>';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" value="' . $formline['MW'] . '" name="MW' . $formrow . '"></div>';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" value="' . $formline['CK'] . '" name="CK' . $formrow . '"></div>';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" value="' . $formline['Abil'] . '" name="Abil' . $formrow . '"></div>';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" value="' . $formline['Spec'] . '" name="Spec' . $formrow . '"></div>';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" value="' . $formline['Ages'] . '" name="Ages' . $formrow . '"></div>';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="' . $formline['FreeText'] . '" name="FreeText' . $formrow . '"></div>';
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
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="" name="FreeText' . $formrow . '"></div>';
  $classformhtml = $classformhtml . '</div>';
  
  //Add the autoclass box depending on the status of the autoclass
  if ($autoclassflag == "Is")
    {
    $classformhtml = $classformhtml . '<p>This is already an automatic class.</p>';
    $classformhtml = $classformhtml . '<input type="hidden" name="AutoClass' . $classrow . '" value="Is">';
    }
  elseif ($autoclassflag == "Blank")
    $classformhtml = $classformhtml . '<p>Add automatic class <input type="checkbox" name="AutoClass' . $classrow . '" value="Add"></p>';
  elseif ($autoclassflag == "Add")
    $classformhtml = $classformhtml . '<p>Add automatic class <input type="checkbox" name="AutoClass' . $classrow . '" value="Add" checked></p>';

  //The end of the range that the class fields refer to
  $endrow = $formrow;
  
  //The class range
  $classformhtml = $classformhtml . '<input type="hidden" name="ClassRange' . $classrow . '" value="' . $startrow . '-' . $endrow . '">';

  //Increment form and class row count
  $formrow++;
  $classrow++;
  }

//Hidden global data to send through the form
$classformhtml = $classformhtml . '<input type="hidden" name="ClassRows" value="' . $classrow-1 . '">';
$classformhtml = $classformhtml . '<input type="hidden" name="RaceRows" value="' . $formrow-1 . '">';
$classformhtml = $classformhtml . '<input type="hidden" name="DBClass" value="' . $racenametoset . '">';
$classformhtml = $classformhtml . '<input type="hidden" name="InputClass" value="' . $inputclass . '">';

//Submit buttons
$classformhtml = $classformhtml . '<p>';
$classformhtml = $classformhtml . '<input type="submit" name="SubmitClasses" value="Add Classes">';
$classformhtml = $classformhtml . ' ';
$classformhtml = $classformhtml . '<input type="submit" name="SubmitClasses" value="Final Check">';
$classformhtml = $classformhtml . ' ';
$classformhtml = $classformhtml . '<input type="submit" name="SubmitClasses" value="Add Rows">';
$classformhtml = $classformhtml . '</p>';
$classformhtml = $classformhtml . '</form>';
?>
