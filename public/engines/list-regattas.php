<?php
include_once 'required-functions.php';

//Get the regattas
$regattafieldswanted = "g.`Key`, g.`Name`, g.`Date`, g.`Days`";
include 'get-regattas.php';

foreach($allregattaslist as $allregattaslistkey=>$regattadetailsline)
  {
  include 'process-regatta-details.php';
  $allregattaslist[$allregattaslistkey] = $regattadetailsline;
  }
?>
