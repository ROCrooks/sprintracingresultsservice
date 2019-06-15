<?php
if (isset($_POST['submitregatta']) == true)
  {
  //Get regatta information from form
  $regattaname = $_POST['RegattaName'];
  $regattadate = $_POST['RegattaDate'];
  $regattadays = $_POST['RegattaDays'];
  $regattatext = $_POST['RegattaText'];

  //Run database query and get regatta insert ID
  $insertregattasql = "INSERT INTO `regattas` (`Name`, `Date`, `Days`, `Hide`) VALUES (?, ?, ?, 1)";
  $insertregattaconstraints = array($regattaname,$regattadate,$regattadays);
  dbprepareandexecute($srrsdblink,$insertregattasql,$insertregattaconstraints);
  $regattaid = mysqli_insert_id($srrsdblink);

  //Put results text into file
  
  //Cleanup results file
  include 'cleanup-results-file.php';
  }
elseif (isset($_POST['submittext']) == true)
  {
  //Get the file and retrieve as an array
  $regattafile = "reading-test.txt";
  $regattatext = file_get_contents($regattafile);
  $regattatext = explode("Race:",$regattatext);

  //Amend the first race in the regatta text file
  $regattatext[1] = $_POST['RaceText'];
  $regattatext = implode("Race:",$regattatext);
  file_put_contents("clean-results.txt",$regattatext);

  //Clean new results file to avoid introducing errors
  include 'cleanup-results-file.php';
  }
elseif (isset($_POST['submitfields']) == true)
  {
  //Process race form and check for errors
  include 'race-form-processor.php';
  $raceerror = false;
  include 'check-race-import.php';

  if ($raceerror == true)
    include 'race-error-form.php';
  else
    {
    //Import directly into database from form
    include 'import-race-db.php';

    //Get the file and retrieve as an array
    $regattafile = "reading-test.txt";
    $regattatext = file_get_contents($regattafile);
    $regattatext = explode("Race:",$regattatext);

    //Amend the first race in the regatta text file
    unset($regattatext[0]);
    $regattatext[1] = "";
    $regattatext = implode("Race:",$regattatext);
    file_put_contents("clean-results.txt",$regattatext);
    }
  }
?>
