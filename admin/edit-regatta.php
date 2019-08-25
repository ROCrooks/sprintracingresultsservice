<?php
include 'relative-path.php';

//Get regatta ID
if (isset($_GET['regatta']) == true)
  $regattaid = $_GET['regatta'];
else
  $regattaid = 0;

//Get the regatta and race details
$club = '';
$paddler = '';
$jsv = '';
$mw = '';
$ck = '';
$abil = '';
$spec = '';
$ages = '';
include $relativepath . 'get-races.php';

echo '<p>Regatta:</p>';

print_r($regattaresults['Details']);

echo '<p>Races:</p>';

print_r($regattaresults['Races']);

?>
