<?php
include_once $srrsenginesfolder . 'srrs-required-functions.php';
include_once $srrsenginesfolder . 'srrs-user-input-processing.php';

//Create the event links page
include $srrsenginesfolder . 'create-event-links.php';

$pagehtml = '<section>';
$pagehtml = $pagehtml . '<p class="blockheading">Times Analysis</p>';
$pagehtml = $pagehtml . '<p>Analyze the fastest performances and distribution of times in each year for each event. Results available for overall, as well as junior and masters events.<p>';
$pagehtml = $pagehtml . $eventslisthtml;
$pagehtml = $pagehtml . '</section>';
?>
