<?php
//Get the directory of the engines
$currentdirectory = getcwd();
$removedirs = array("/pages","/engines","/admin","/srrs");
$currentdirectory = str_replace($removedirs,"",$currentdirectory);
$enginesdirectory = $currentdirectory . "/srrs/engines/";

include $enginesdirectory . 'defaulturls.php';

//Define join to attach URL variables
if (strpos($defaulturls['RegattaLookup'],"?") === false)
  $ahrefjoin = "?";
else
  $ahrefjoin = "&";

//Get URL to send to the engine
$lookupurl = $defaulturls['TopNTimes'];

//Create the event links page
include $enginesdirectory . 'create-event-links.php';
?>

<?php echo $eventslisthtml; ?>
