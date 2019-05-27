<?php
//Get the results file
$regattafile = "clean-results.txt";
$regattatext = file_get_contents($regattafile);
//This is to make a copy in order to test that the file is deleted afterwards
$regattafile = "reading-test.txt";
file_put_contents($regattafile,$regattatext);
$regattatext = file_get_contents($regattafile);
$regattatext = explode("Race:",$regattatext);

//Flag for if there's an error, gets set to true if error found
$raceerror = false;

$noraces = count($regattatext);
unset($regattatext[0]);
$regattalookupkey = 1;
while (($regattalookupkey < $noraces) AND ($raceerror == false))
  {
  //Process race text into race arrays
  $racetext = $regattatext[$regattalookupkey];
  include 'process-race-input.php';
  //Check race arrays for errors
  if ($regattalookupkey == 3)
    $raceerror = true;
  //If there are no errors import race into the database
  if ($raceerror == false)
    {
    print_r($racedetails);
    echo "<br>";
    print_r($allpaddlerdetails);
    echo "<hr>";
    unset($regattatext[$regattalookupkey]);
    }
  else
    {
    $racetext = implode("\n",$racetext);
    include 'race-error-form.php';
    echo $addpaddlerformhtml;
    }

  $regattalookupkey++;
  }

//Either add remaining races to file, or delete the file
if (count($regattatext) > 0)
  {
  $regattatext = "Race: " . implode("Race:",$regattatext);
  file_put_contents($regattafile,$regattatext);
  }
else
  unlink($regattafile);
?>
