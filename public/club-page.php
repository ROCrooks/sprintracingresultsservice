<?php
include 'engines/user-input-processing.php';

//Make variables for the URLs
$urlvariables = array();
if ($club != '')
  array_push($urlvariables,"club=" . $club);

include 'defaulturls.php';

//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>$defaulturls['RegattasList'],"Text"=>"Browse Regattas");
$subsectionurls[1] = array("URL"=>$defaulturls['EventRecords'],"Text"=>"Club Records");
$subsectionurls[2] = array("URL"=>$defaulturls['Analytics'],"Text"=>"Regatta Analytics");

foreach($subsectionurls as $listurl)
  {
  echo '<p><a href="' . $listurl['URL'] . $urlvariables . '">' . $listurl['Text'] . '</a></p>';
  }
?>
