<?php
include_once 'required-functions.php';

//Processing flag
$processing = true;

if ((isset($_POST['submitregatta']) == true) AND (isset($_GET['Regatta']) == false))
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
  $filename = "regatta" . $regattaid . ".txt";
  file_put_contents($filename,$regattatext);
  include 'cleanup-results-file.php';
  }
elseif ((isset($_POST['submittext']) == true) AND (isset($_GET['Regatta']) == true))
  {
  //Get the file and retrieve as an array
  $regattaid = $_GET['Regatta'];
  $filename = "regatta" . $regattaid . ".txt";
  $regattatext = file_get_contents($filename);
  $regattatext = explode("Race:",$regattatext);

  //Amend the first race in the regatta text file
  $regattatext[1] = $_POST['RaceText'];
  $regattatext = implode("Race:",$regattatext);
  file_put_contents($filename,$regattatext);

  //Clean new results file to avoid introducing errors
  include 'cleanup-results-file.php';
  }
elseif ((isset($_POST['submitfields']) == true) AND (isset($_GET['Regatta']) == true))
  {
  //Get the file and retrieve as an array
  $regattaid = $_GET['Regatta'];
  $filename = "regatta" . $regattaid . ".txt";

  //Process race form and check for errors
  include 'race-form-processor.php';
  $raceerror = false;
  include 'check-race-import.php';

  if ($raceerror == true)
    {
    include 'race-error-form.php';
    $finished = false;
    }
  else
    {
    //Import directly into database from form
    include 'import-race-db.php';

    //Get the file and retrieve as an array
    $regattatext = file_get_contents($filename);
    $regattatext = explode("Race:",$regattatext);

    //Amend the first race in the regatta text file
    unset($regattatext[0]);
    $regattatext[1] = "";
    $regattatext = implode("Race:",$regattatext);
    file_put_contents($filename,$regattatext);
    }
  }
//What to do if going directly to a numbered regatta
elseif ((isset($_POST['submittext']) == false) AND (isset($_POST['submitfields']) == false) AND (isset($_GET['Regatta']) == true))
  {
  $regattaid = $_GET['Regatta'];
  $filename = "regatta" . $regattaid . ".txt";
  }
//What to do if there is no form input
else
  {
  //Widths for the columns in the form
  $width1 = 150;
  $width2 = 300;

  //The form to insert a new regatta
  $processing = false;
  $addregattaformhtml = '<form action="add-regatta.php" method="post">';
  $addregattaformhtml = $addregattaformhtml . '<div style="display: table-row;">';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width1 . 'px; display: table-cell;">Regatta Name:</div>';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width2 . 'px; display: table-cell;"><input type="text" name="RegattaName" size=""></div>';
  $addregattaformhtml = $addregattaformhtml . '</div>';
  $addregattaformhtml = $addregattaformhtml . '<div style="display: table-row;">';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width1 . 'px; display: table-cell;">Regatta Date:</div>';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width2 . 'px; display: table-cell;"><input type="date" name="RegattaDate"></div>';
  $addregattaformhtml = $addregattaformhtml . '</div>';
  $addregattaformhtml = $addregattaformhtml . '<div style="display: table-row;">';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width1 . 'px; display: table-cell;">Regatta Days:</div>';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width2 . 'px; display: table-cell;"><input type="text" name="RegattaDays" size="1"></div>';
  $addregattaformhtml = $addregattaformhtml . '</div>';
  $addregattaformhtml = $addregattaformhtml . '<div style="display: table-row;">';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width1 . 'px; display: table-cell;">Regatta Text:</div>';
  $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width2 . 'px; display: table-cell;"><textarea cols="30" rows="10" name="RegattaText"></textarea></div>';
  $addregattaformhtml = $addregattaformhtml . '</div>';
  $addregattaformhtml = $addregattaformhtml . '<p><input type="submit" name="submitregatta" value="Submit"> <input type="reset" name="reset" value="Reset">';
  $addregattaformhtml = $addregattaformhtml . '</form>';
  }
?>
