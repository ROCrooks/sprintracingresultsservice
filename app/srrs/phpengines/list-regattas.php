<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the regattas
$regattafieldswanted = "g.`Key`, g.`Name`, g.`Date`, g.`Days`, g.`Hide`";
include 'get-regattas.php';

foreach($allregattaslist as $allregattaslistkey=>$regattadetailsline)
  {
  include 'process-regatta-details.php';
  $allregattaslist[$allregattaslistkey] = $regattadetailsline;
  }
?>
