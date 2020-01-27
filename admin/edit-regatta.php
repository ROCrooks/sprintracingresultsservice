<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

//Get regatta ID
if (isset($_GET['regatta']) == true)
  $regattaid = $_GET['regatta'];
else
  $regattaid = 0;

if (isset($_GET['deleterace']) == true)
  {
  $deleterace = $_GET['deleterace'];
  include $adminenginesrelativepath . 'delete-race.php';
  }

//Get the regatta and race details
$club = '';
$paddler = '';
$jsv = '';
$mw = '';
$ck = '';
$abil = '';
$spec = '';
$ages = '';

//Get races engine
include $publicenginesrelativepath . 'get-races.php';

echo '<div class="item">';

if (isset($regattaresults['Details']) == true)
  {
  echo '<p class="blockheading">Edit Regatta</p>';
  echo '<p>Regatta Name: <input type="text" size="80" value="' . $regattaresults['Details']['Name'] . '"></p>';
  echo '<p>Regatta Date: <input type="text" size="15" value="' . $regattaresults['Details']['FullDate'] . '"></p>';
  }

if (isset($regattaresults['Details']) == true)
  {
  echo '<p class="blockheading">Races</p>';
  foreach ($regattaresults['Races'] as $race)
    {
    print '<p><a href="' . $defaulturls['EditRace'] . $ahrefjoin . 'race=' . $race['Key'] . '">' . $race['Name'] . '</a></p>';
    }
  }

echo '</div>';
?>
