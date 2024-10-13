<?php
//Get the details of the club
include $engineslocation . 'club-details-engine.php';

print_r($clubfindresult);

$pagehtml = "<section>";

$pagehtml = $pagehtml . '<img src="' . $clubfindresult['Colours'] . '" width="500">';

$pagehtml = $pagehtml . "</section>";
?>