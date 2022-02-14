<?php
//Get the directory of the engines
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);
$enginesdirectory = $currentdirectory . "/srrs/engines/";

include $enginesdirectory . 'user-input-processing.php';
include $enginesdirectory . 'defaulturls.php';

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

//Define join to attach club variable
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>$defaulturls['RegattasList'],"Text"=>"Browse Regattas");
$subsectionurls[1] = array("URL"=>$defaulturls['EventRecords'],"Text"=>"Record Times");

echo '<div class="item">';

foreach($subsectionurls as $listurl)
  {
  $linkurlvariables = implode("&",$urlvariables);
  echo '<p><a href="' . $listurl['URL'] . $ahrefjoin . $linkurlvariables . '">' . $listurl['Text'] . '</a></p>';
  }

echo '</div>';
?>
