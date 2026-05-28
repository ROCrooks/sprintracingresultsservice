<?php
include_once $srrsenginesfolder . 'srrs-required-functions.php';

include $srrsenginesfolder . "atomize-racenames.php";

//Find matching race classes in the autoclasses list
$foundautoclasses = array();
foreach($racenamecomponents as $namecomponent)
  {
  //Find if the autoclass is in the autoclasses database
  $autoclassfind = $namecomponent;
  include $srrsenginesfolder . "find-single-autoclass.php";

  if (count($autoclass) > 0)
    $foundautoclasses[$namecomponent] = array("ClassCodes"=>$autoclass,"AutoClass"=>"Is");
  else
    $foundautoclasses[$namecomponent] = array("ClassCodes"=>array(),"AutoClass"=>"Blank");
  }
?>
