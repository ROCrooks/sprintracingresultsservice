<?php
include 'engines/user-input-processing.php';

include 'defaulturls.php';

//Define join to attach club variable
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";


//List of links
$subsectionurls = array();
$subsectionurls[0] = array("URL"=>$defaulturls['RegattasList'],"Text"=>"Browse Regattas");
$subsectionurls[1] = array("URL"=>$defaulturls['EventRecords'],"Text"=>"Club Records");
$subsectionurls[2] = array("URL"=>$defaulturls['Analytics'],"Text"=>"Regatta Analytics");

echo '<div class="item">';
foreach($subsectionurls as $listurl)
  {
  echo '<p><a href="' . $listurl['URL'] . $ahrefjoin . 'club=' . $club . '">' . $listurl['Text'] . '</a></p>';
  }
echo '</div>';
?>
