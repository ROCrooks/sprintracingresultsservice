<?php
include_once $engineslocation . 'srrs-required-functions.php';

include $engineslocation . "atomize-racenames.php";

//Find matching race classes in the autoclasses list
$foundautoclasses = array();
foreach($racenamecomponents as $namecomponent)
  {
  //Find the AutoClasses
  if (isset($findclassstmt) == false)
    {
    $findclasssql = "SELECT `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText` FROM `autoclasses` WHERE `RaceName` = ?";
  	$findclassstmt = dbprepare($srrsdblink,$findclasssql);
    }

  //Add the autoclass if it's found
  $autoclass = dbexecute($findclassstmt,$namecomponent);
  if (count($autoclass) > 0)
    $foundautoclasses[$namecomponent] = array("ClassCodes"=>$autoclass,"AutoClass"=>"Is");
  else
    $foundautoclasses[$namecomponent] = array("ClassCodes"=>array(),"AutoClass"=>"Blank");
  }
?>
