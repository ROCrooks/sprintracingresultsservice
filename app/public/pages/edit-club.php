<?php
//Get the details of the club
include $engineslocation . 'club-details-engine.php';

print_r($clubfindresult);

$pagehtml = "<section>";
$pagehtml = $pagehtml . '<div style="display: table; width: 100%;">';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 30%;"><img src="' . $clubfindresult['Colours'] . '" width="100%"></div>';
$pagehtml = $pagehtml . '<div style="display: table-cell; width: 70%;"><p>Club</p></div>';
$pagehtml = $pagehtml . '</div>';

$pagehtml = $pagehtml . "</section>";
?>