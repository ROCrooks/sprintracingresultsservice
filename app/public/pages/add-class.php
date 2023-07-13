<?php
//Get the next unset class in the races table if a class details array is not set
if (isset($racenametoset) == false)
  include $engineslocation . "class-getunassignedclass.php";

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Add Classes</p>';
$pagehtml = $pagehtml . $racenametoset;
$pagehtml = $pagehtml . '</section>';
?>
