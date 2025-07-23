<?php
//Create the event links page
include $engineslocation . 'create-event-links.php';

$pagehtml = '<section>
<p class="blockheading">Find Best Paddlers</p>
<p>Find a list of the best paddlers, ranked by fastest PB in each event at all
  regattas. Results are available for overall, as well as junior and masters events<p>';
$pagehtml = $pagehtml . $eventslisthtml;
$pagehtml = $pagehtml . '</section>';
?>
