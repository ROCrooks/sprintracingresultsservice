<?php
include 'engines/user-input-processing.php';

//Make variables for the URLs
$urlvariables = array();
if ($paddler != '')
  array_push($urlvariables,"paddler=" . $paddler);
if ($club != '')
  array_push($urlvariables,"club=" . $club);
if ($padjsv != '')
  array_push($urlvariables,"padjsv=" . $padjsv);
if ($padmw != '')
  array_push($urlvariables,"padmw=" . $padmw);
if ($padck != '')
  array_push($urlvariables,"padck=" . $padck);

include 'defaulturls.php';

//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>$defaulturls['RegattasList'],"Text"=>"Browse Regattas");
$subsectionurls[1] = array("URL"=>$defaulturls['EventRecords'],"Text"=>"Record Times");

foreach($subsectionurls as $listurl)
  {
  echo '<p><a href="' . $listurl['URL'] . $urlvariables . '">' . $listurl['Text'] . '</a></p>';
  }
?>
