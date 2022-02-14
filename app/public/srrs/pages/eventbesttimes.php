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
<div class="item">
<p class="blockheading">Find Best Paddlers</p>
<p>Find a list of the best paddlers, ranked by fastest PB in each event at all
  regattas. Results are available for overall, as well as junior and masters events<p>
<?php echo $eventslisthtml; ?>
</div>
