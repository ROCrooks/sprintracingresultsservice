<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>"RegattaList?club=" . $club,"Text"=>"Browse Regattas");
$subsectionurls[1] = array("URL"=>"EventRecords?club=" . $club,"Text"=>"Club Records");
$subsectionurls[2] = array("URL"=>"RegattaAnalytics?club=" . $club,"Text"=>"Regatta Analytics");

$pagehtml = '<section>';
foreach($subsectionurls as $listurl)
  {
  $pagehtml = $pagehtml . '<p><a href="' . $listurl['URL'] . '">' . $listurl['Text'] . '</a></p>';
  }
$pagehtml = $pagehtml . '</section>';
?>
