<?php
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

//Single row forms are wider than multi row forms
//Also include the rowcount element
if ($multirowform == true)
  {
  $classtablewidth = $classwidths['JSV']+$classwidths['MW']+$classwidths['CK']+$classwidths['Abil']+$classwidths['Spec']+$classwidths['Ages']+$classwidths['FreeText'];
  $rowcount = 1;
  }
elseif ($multirowform == false)
  {
  $classtablewidth = $classwidths['JSV']+$classwidths['MW']+$classwidths['CK']+$classwidths['Abil']+$classwidths['Spec']+$classwidths['Ages']+$classwidths['FreeText']+$classwidths['Button']+$classwidths['Button'];
  $rowcount = '';
  }

$classformhtml = '';

//Header for class list
$classformhtml = $classformhtml . '<div style="width: ' . $classtablewidth . 'px; display: table;">';
//echo '<div style="width: 50%; display: table;">';

$classformhtml = $classformhtml . '<div style="display: table-row;">';
$classformhtml = $classformhtml . '<div style="display: table-cell;"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;">JSV</div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;">MW</div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;">CK</div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;">Abil</div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;">Spec</div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;">Ages</div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;">FreeText</div>';

//Only generate buttons if it's a single row not multiple rows
if ($multirowform == false)
  {
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"></div>';
  }

$classformhtml = $classformhtml . '<div style="display: table-cell;"></div>';
$classformhtml = $classformhtml . '</div>';

//Each class to edit
foreach ($classdetails as $individualclass)
  {
  //Increase rowcount if it is a number rather than blank
  if ($rowcount != '')
    $rowcount = $rowcount++;

  //Set default values
  $classkeys = array("Key","JSV","MW","CK","Abil","Spec","Ages","FreeText");
  $individualclass = createblanksinarray($individualclass,$classkeys);

  //Pass the name of the
  $classformhtml = $classformhtml . '<div style="display: table-row;">';
  $classformhtml = $classformhtml . '<div style="display: table-cell; width: 0px;"><form action="' . $classformactionurl . '" method="post"><input type="hidden" name="ItemKey' . $rowcount . '" value="' . $individualclass['Key'] . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" value="' . $individualclass['JSV'] . '" name="JSV' . $rowcount . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" value="' . $individualclass['MW'] . '" name="MW' . $rowcount . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" value="' . $individualclass['CK'] . '" name="CK' . $rowcount . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" value="' . $individualclass['Abil'] . '" name="Abil' . $rowcount . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" value="' . $individualclass['Spec'] . '" name="Spec' . $rowcount . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" value="' . $individualclass['Ages'] . '" name="Ages' . $rowcount . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="' . $individualclass['FreeText'] . '" name="FreeText' . $rowcount . '"></div>';

  //Only generate buttons if it's a single row not multiple rows
  if ($multirowform == false)
    {
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"><input type="submit" value="Edit" name="ClassEdit"></div>';
    $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"><input type="submit" value="Delete" name="ClassDelete" onclick="return confirm(\'This will delete the race class. Are you sure you want to continue?\')"></div>';
    }

  $classformhtml = $classformhtml . '<div style="0px; display: table-cell;"></form></div>';
  $classformhtml = $classformhtml . '</div>';
  }

if ($rowcount != '')
  $rowcount = "NEW";

//Form to add a new class
$classformhtml = $classformhtml . '<div style="display: table-row;">';
$classformhtml = $classformhtml . '<div style="display: table-cell; width: 0px;"><form action="' . $classformactionurl . '" method="post"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" name="JSV' . $rowcount . '"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" name="MW' . $rowcount . '"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" name="CK' . $rowcount . '"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" name="Abil' . $rowcount . '"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" name="Spec' . $rowcount . '"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" name="Ages' . $rowcount . '"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" name="FreeText' . $rowcount . '"></div>';

//Only generate buttons if it's a single row not multiple rows
if ($multirowform == false)
  {
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"><input type="submit" value="Add" name="ClassAdd"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"></div>';
  }

$classformhtml = $classformhtml . '<div style="display: table-cell;"></form></div>';
$classformhtml = $classformhtml . '</div>';
?>
