<?php
include_once $engineslocation . 'srrs-required-functions.php';

include $engineslocation . 'club-list-engine.php';

print_r($clubdetailsresult);
echo "<br>";
print_r($orphanclubs);
echo "<br>";

$pagehtml = "<section><p>Test</p></section>";
?>