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
$lookupurl = $defaulturls['TimesAnalysis'];

//Create the event links page
include $enginesdirectory . 'create-event-links.php';
?>
<div class="item">
<p class="blockheading">Times Analysis</p>
<p>Analyze the fastest performances and distribution of times in each year for each event. Results available for overall, as well as junior and masters events.<p>
<?php echo $eventslisthtml; ?>
</div>
