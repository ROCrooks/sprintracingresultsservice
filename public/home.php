<?php
include 'defaulturls.php';

//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>$defaulturls['RegattasList'],"Text"=>"Browse Regattas");
$subsectionurls[1] = array("URL"=>$defaulturls['ClubSearch'],"Text"=>"Club Search");
$subsectionurls[2] = array("URL"=>$defaulturls['PaddlerSearch'],"Text"=>"Paddler Search");
$subsectionurls[3] = array("URL"=>$defaulturls['EventRecords'],"Text"=>"Event Records");
$subsectionurls[4] = array("URL"=>$defaulturls['Analytics'],"Text"=>"Regatta Analytics");

foreach($subsectionurls as $listurl)
  {
  echo '<p><a href="' . $listurl['URL'] . '">' . $listurl['Text'] . '</a></p>';
  }
?>
