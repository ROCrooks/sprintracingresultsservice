<?php
include_once $engineslocation . 'srrs-required-functions.php';

$raceerror = false;
include $engineslocation . 'process-form.php';

if (($processing == true) AND ($raceerror == false))
  include $engineslocation . 'import-races-engine.php';

$pagehtml = '<section>';

if ($processing == false)
  {
  //Form to add a new regatta if none is specified
  $pagehtml = $pagehtml . '<p class="blockheading">Add New Regatta</p>';

  if (isset($regattaid) == false)
    $pagehtml = $pagehtml . '<p>Add a new regatta to the SRRS database using this form and where possible it will automatically be processed into races.</p>';
  elseif (isset($regattaid) == true)
    $pagehtml = $pagehtml . '<p>Add new races to a regatta.</p>';
  $pagehtml = $pagehtml . $addregattaformhtml;
  }
elseif (($finished == false) AND ($raceerror == true))
  {
  //Form to correct an error when importing a race
  $pagehtml = $pagehtml . '<p class="blockheading">Error Inserting Race</p>';

  $pagehtml = $pagehtml . '<p>Error(s) have been detected in this race:</p>';
  $pagehtml = $pagehtml . $addpaddlerformhtml;
  }
elseif (($finished == true) AND ($raceerror == false))
  {
  //Form to correct an error when importing a race
  $pagehtml = $pagehtml . '<p class="blockheading">Finished!</p>';

  $pagehtml = $pagehtml . '<p>The regatta has been imported!</p>';
  }
$pagehtml = $pagehtml . '</section>';
?>
