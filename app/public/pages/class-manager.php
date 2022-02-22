<?php
//Get classes list engine
include $engineslocation . 'class-getallclasses.php';

//Widths
$racenamewidth = 200;
$numberraceswidth = 20;
$editlinkwidth = 20;
$fullwidthtable = $racenamewidth+$numberraceswidth+$editlinkwidth;

$allclasseslisthtml = '<div style="display: table; width: ' . $fullwidthtable . ';">';
foreach($uniqueclassnames as $classitem)
  {
  //Encode the input class name as HTML entity
  $urlclass = urlencode($classitem['InputClass']);

  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-row; width: ' . $fullwidthtable . 'px;">';
  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-cell; width: ' . $racenamewidth . 'px;"><p>' . $classitem['InputClass'] . '<br>' . $classitem['AutoClass'] . '</p></div>';
  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-cell; width: ' . $numberraceswidth . 'px; vertical-align: middle;"><p>' . $classitem['RaceCount'] . '</p></div>';
  $allclasseslisthtml = $allclasseslisthtml . '<div style="display: table-cell; width: ' . $editlinkwidth . 'px; vertical-align: middle;"><p><a href="EditClass?class=' . $urlclass . '">Edit</a></p></div>';
  $allclasseslisthtml = $allclasseslisthtml . '</div>';
  }
$allclasseslisthtml = $allclasseslisthtml . '</div>';

$addclasslinkhtml = '<p><a href="AddClass">Add Classes</a></p>';

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Class Manager</p>';
$pagehtml = $pagehtml . $addclasslinkhtml;
$pagehtml = $pagehtml . $allclasseslisthtml;
$pagehtml = $pagehtml . '</section>';
?>
