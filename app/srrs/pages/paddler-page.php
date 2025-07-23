<?php
include_once $engineslocation . 'srrs-required-functions.php';
include_once $engineslocation . 'srrs-user-input-processing.php';

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

//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>"RegattaList","Text"=>"Browse Regattas");
$subsectionurls[1] = array("URL"=>"EventRecords","Text"=>"Record Times");

$pagehtml = '<section>';

foreach($subsectionurls as $listurl)
  {
  $linkurlvariables = implode("&",$urlvariables);
  $pagehtml = $pagehtml . '<p><a href="' . $listurl['URL'] . "?" . $linkurlvariables . '">' . $listurl['Text'] . '</a></p>';
  }

$pagehtml = $pagehtml . '</section>';
?>
