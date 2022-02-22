<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get regatta ID
if (isset($_GET['regatta']) == true)
  $regattaid = $_GET['regatta'];
else
  $regattaid = 0;

if (isset($_GET['deleterace']) == true)
  {
  $deleterace = $_GET['deleterace'];
  include $engineslocation . 'delete-race.php';
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
include $engineslocation . 'get-races.php';

$pagehtml = '<section>';

if (isset($regattaresults['Details']) == true)
  {
  $pagehtml = $pagehtml . '<p class="blockheading">Edit Regatta</p>';
  $pagehtml = $pagehtml . '<p>Regatta Name: <input type="text" size="80" value="' . $regattaresults['Details']['Name'] . '"></p>';
  $pagehtml = $pagehtml . '<p>Regatta Date: <input type="text" size="15" value="' . $regattaresults['Details']['FullDate'] . '"></p>';
  }

if (isset($regattaresults['Details']) == true)
  {
  $pagehtml = $pagehtml . '<p class="blockheading">Races</p>';
  foreach ($regattaresults['Races'] as $race)
    {
    $pagehtml = $pagehtml . '<p><a href="EditRace?race=' . $race['Key'] . '">' . $race['Name'] . '</a></p>';
    }
  }

$pagehtml = $pagehtml . '</section>';
?>
