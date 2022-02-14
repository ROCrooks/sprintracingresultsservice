<?php
include 'srrs-required-functions.php';

//Prepare query to purge the classes
if (isset($purgeclassesstmt) == false)
  {
  $purgeclassessql = "DELETE c FROM `classes` c LEFT JOIN `races` r ON c.`Race` = r.`Key` WHERE r.`Class` = ?";
  $purgeclassesstmt = dbprepare($srrsdblink,$purgeclassessql);
  }

//Prepare query to purge autoclasses
if (isset($purgeautoclassesstmt) == false)
  {
  $purgeautoclassessql = "DELETE FROM `autoclasses` WHERE `RaceName` = ?";
  $purgeautoclassesstmt = dbprepare($srrsdblink,$purgeautoclassessql);
  }

//Unset race classes
if (isset($unsetracesclassesstmt) == false)
  {
  $unsetracesclassessql = "UPDATE `races` SET `Set` = 0 WHERE `Class` = ?";
  $unsetracesclassesstmt = dbprepare($srrsdblink,$unsetracesclassessql);
  }

//Execute purge queries
dbexecute($purgeclassesstmt,$findclassname);
dbexecute($purgeautoclassesstmt,$findclassname);
dbexecute($unsetracesclassesstmt,$findclassname);
?>
