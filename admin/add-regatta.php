<div class="item">
<?php
include 'srrsadminrelativepaths.php';
include 'srrsadmindefaulturls.php';

$raceerror = false;
include $adminenginesrelativepath . 'process-form.php';

if (($processing == true) AND ($raceerror == false))
  include $adminenginesrelativepath . 'import-races-engine.php';

if ($processing == false)
  {
  //Form to add a new regatta if none is specified
  echo '<p class="blockheading">Add New Regatta</p>';

  if (isset($regattaid) == false)
    echo '<p>Add a new regatta to the SRRS database using this form and where possible it will automatically be processed into races.</p>';
  elseif (isset($regattaid) == true)
    echo '<p>Add new races to a regatta.</p>';
  echo $addregattaformhtml;
  }
elseif (($finished == false) AND ($raceerror == true))
  {
  //Form to correct an error when importing a race
  echo '<p class="blockheading">Error Inserting Race</p>';

  echo '<p>Error(s) have been detected in this race:</p>';
  echo $addpaddlerformhtml;
  }
elseif (($finished == true) AND ($raceerror == false))
  {
  //Form to correct an error when importing a race
  echo '<p class="blockheading">Finished!</p>';

  echo '<p>The regatta has been imported!</p>';
  }
?>
</div>
