<?php
//Get the relative paths for the engines
include 'srrsadminrelativepaths.php';

//Get classes list engine
include 'engines/class-getallclasses.php';

//Widths
$racenamewidth = 300;
$numberraceswidth = 20;
$fullwidthtable = $racenamewidth+$numberraceswidth;

echo '<div style="display: table; width: ' . $fullwidthtable . ';">';
foreach($uniqueclassnames as $classitem)
  {
  echo '<div style="display: table-row; width: ' . $fullwidthtable . ';">';
  echo '<div style="display: table-cell; width: ' . $racenamewidth . ';">' . $classitem['InputClass'] . '<br>' . $classitem['AutoClass'] . '</div>';
  echo '<div style="display: table-cell; width: ' . $numberraceswidth . '; vertical-align: middle;">' . $classitem['RaceCount'] . '</div>';
  echo '</div>';
  }
echo '</div>';

print_r($uniqueclassnames);
/*
Assign classes and approve more

List all classes - Delete Class

Edit Autoclass



Purge autoclass


Engines Maybe Needed
- Add class to races (class-addclassestoraces.php)
- Add overall freetext to races (class-addfreetextstoraces.php)
- Purge class (class-purgeclass.php)
- Get each race name and corresponding autoclass (class-getallclasses.php)
- Add autoclass (class-addautoclass.php)
- Delete autoclass (class-deleteautoclass.php)
- Add overall FreeText (class-addfreetext.php)
- Delete overall FreeText (class-deletefreetext.php)
- Update hidden race names (class-updateracename.php)
*/
?>
