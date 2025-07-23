<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Get the results file
$regattatext = file_get_contents($filename);
$regattatext = explode("Race:",$regattatext);

//Flag for if there's an error, gets set to true if error found
$raceerror = false;

$noraces = count($regattatext);

$regattalookupkey = 1;
while (($regattalookupkey < $noraces) AND ($raceerror == false))
  {
  //Process race text into race arrays
  $racetext = $regattatext[$regattalookupkey];
  include $engineslocation . 'process-race-input.php';
  //Check race arrays for errors
  include $engineslocation . 'check-race-import.php';
  //If there are no errors import race into the database
  if ($raceerror == false)
    {
    include $engineslocation . 'import-race-db.php';
    unset($regattatext[$regattalookupkey]);
    }
  else
    {
    $racetext = implode("\n",$racetext);
    include $engineslocation . 'race-error-form.php';
    }

  $regattalookupkey++;
  }

//Either add remaining races to file, or delete the file
if (count($regattatext) > 1)
  {
  $regattatext = implode("Race:",$regattatext);
  file_put_contents($filename,$regattatext);
  $finished = false;
  }
else
  {
  unlink($filename);
  $finished = true;
  }
?>
