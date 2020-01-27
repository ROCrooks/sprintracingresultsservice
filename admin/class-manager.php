<?php
//Get the relative paths for the engines
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//Get classes list engine
include $adminenginesrelativepath . 'class-getallclasses.php';

//Widths
$racenamewidth = 450;
$numberraceswidth = 20;
$editlinkwidth = 20;
$fullwidthtable = $racenamewidth+$numberraceswidth+$editlinkwidth;

echo '<div style="display: table; width: ' . $fullwidthtable . ';">';
foreach($uniqueclassnames as $classitem)
  {
  //Encode the input class name as HTML entity
  $urlclass = urlencode($classitem['InputClass']);

  echo '<div style="display: table-row; width: ' . $fullwidthtable . ';">';
  echo '<div style="display: table-cell; width: ' . $racenamewidth . ';"><p>' . $classitem['InputClass'] . '<br>' . $classitem['AutoClass'] . '</p></div>';
  echo '<div style="display: table-cell; width: ' . $numberraceswidth . '; vertical-align: middle;"><p>' . $classitem['RaceCount'] . '</p></div>';
  echo '<div style="display: table-cell; width: ' . $editlinkwidth . '; vertical-align: middle;"><p><a href="' . $defaulturls['EditClass'] . $ahrefjoin . 'class=' . $urlclass . '">Edit</a></p></div>';
  echo '</div>';
  }
echo '</div>';
?>
