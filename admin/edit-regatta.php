<?php
include 'relative-path.php';
include 'defaulturls.php';

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

if (isset($regattaresults['Details']) == true)
  {
  echo '<p>Regatta:</p>';
  echo '<p>Regatta Name: <input type="text" size="80" value="' . $regattaresults['Details']['Name'] . '"></p>';
  echo '<p>Regatta Date: <input type="text" size="15" value="' . $regattaresults['Details']['FullDate'] . '"></p>';
  }

if (isset($regattaresults['Details']) == true)
  {
  echo '<p>Races:</p>';
  foreach ($regattaresults['Races'] as $race)
    {
    print '<p>' . $race['Name'] . '</p>';
    }
  }

?>
