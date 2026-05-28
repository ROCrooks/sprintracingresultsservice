<?php
include_once $srrsenginesfolder . 'srrs-required-functions.php';

//Find the AutoClasses
if (isset($findclassstmt) == false)
  {
  $findclasssql = "SELECT `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `Band`, `ShowBand`, `FreeText` FROM `autoclasses` WHERE `RaceName` = ?";
  $findclassstmt = dbprepare($srrsdblink,$findclasssql);
  }

//Add the autoclass if it's found
$autoclass = dbexecute($findclassstmt,$autoclassfind);
?>