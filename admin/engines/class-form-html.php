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

$classtablewidth = $classwidths['JSV']+$classwidths['MW']+$classwidths['CK']+$classwidths['Abil']+$classwidths['Spec']+$classwidths['Ages']+$classwidths['FreeText']+$classwidths['Button']+$classwidths['Button'];

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
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"></div>';
$classformhtml = $classformhtml . '<div style="display: table-cell;"></div>';
$classformhtml = $classformhtml . '</div>';


//Each class to edit
foreach ($classdetails as $individualclass)
  {
  //Set default values
  $classkeys = array("Key","JSV","MW","CK","Abil","Spec","Ages","FreeText");
  $individualclass = createblanksinarray($individualclass,$classkeys);

  //Pass the name of the
  $classformhtml = $classformhtml . '<div style="display: table-row;">';
  $classformhtml = $classformhtml . '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"><input type="hidden" name="ItemKey" value="' . $individualclass['Key'] . '"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" value="' . $individualclass['JSV'] . '" name="JSV"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" value="' . $individualclass['MW'] . '" name="MW"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" value="' . $individualclass['CK'] . '" name="CK"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" value="' . $individualclass['Abil'] . '" name="Abil"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" value="' . $individualclass['Spec'] . '" name="Spec"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" value="' . $individualclass['Ages'] . '" name="Ages"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" value="' . $individualclass['FreeText'] . '" name="FreeText"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"><input type="submit" value="Edit" name="ClassEdit"></div>';
  $classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"><input type="submit" value="Delete" name="ClassDelete" onclick="return confirm(\'This will delete the race class. Are you sure you want to continue?\')"></div>';
  $classformhtml = $classformhtml . '<div style="0px; display: table-cell;"></form></div>';
  $classformhtml = $classformhtml . '</div>';
  }

//Form to add a new class
$classformhtml = $classformhtml . '<div style="display: table-row;">';
$classformhtml = $classformhtml . '<div style="display: table-cell; width: 0px;"><form action="' . $defaulturls['EditRace'] . $variablejoin . 'race=' . $raceid . '" method="post"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['JSV'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['JSV'] . '" name="JSV"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['MW'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['MW'] . '" name="MW"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['CK'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['CK'] . '" name="CK"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Abil'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Abil'] . '" name="Abil"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Spec'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Spec'] . '" name="Spec"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Ages'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['Ages'] . '" name="Ages"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['FreeText'] . 'px; display: table-cell;"><input type="text" size="' . $fieldsizes['FreeText'] . '" name="FreeText"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"><input type="submit" value="Add" name="ClassAdd"></div>';
$classformhtml = $classformhtml . '<div style="width: ' . $classwidths['Button'] . 'px; display: table-cell;"></div>';
$classformhtml = $classformhtml . '<div style="display: table-cell;"></form></div>';
$classformhtml = $classformhtml . '</div>';
?>
