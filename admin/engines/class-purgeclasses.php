<?php
include 'required-functions.php';

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

//Execute purge queries
dbexecute($purgeclassesstmt,$findclassname);
dbexecute($purgeautoclassesstmt,$findclassname);
?>
