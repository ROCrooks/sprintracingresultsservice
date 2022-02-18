<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Processing flag
$processing = true;

if ((isset($_POST['submitregatta']) == true) AND (isset($_GET['Regatta']) == false))
  {
  if (isset($_GET['regatta']) == true)
    //Just use the regatta ID directly if specified
    $regattaid = $_GET['regatta'];
  else
    {
    //Generate regatta ID with DB query
    //Get regatta information from form
    $regattaname = $_POST['RegattaName'];
    $regattadate = $_POST['RegattaDate'];
    $regattadays = $_POST['RegattaDays'];

    //Run database query and get regatta insert ID
    $insertregattasql = "INSERT INTO `regattas` (`Name`, `Date`, `Days`, `Hide`) VALUES (?, ?, ?, 1)";
    $insertregattaconstraints = array($regattaname,$regattadate,$regattadays);
    dbprepareandexecute($srrsdblink,$insertregattasql,$insertregattaconstraints);
    $regattaid = mysqli_insert_id($srrsdblink);
    }

  $regattatext = $_POST['RegattaText'];

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
elseif ((isset($_POST['submittext']) == false) AND (isset($_POST['submitfields']) == false) AND (isset($_GET['regatta']) == true))
  {
  $regattaid = $_GET['regatta'];
  $filename = "regatta" . $regattaid . ".txt";

  //If the filename doesn't exist, make a form to add races to an already generated regatta
  if (file_exists($filename) == false)
    {
    $processing = false;

    //Widths for the columns in the form
    $width1 = 150;
    $width2 = 300;

    //The form to insert a new regatta
    $addregattaformhtml = '<form action="' . $defaulturls['AddRegatta'] . $ahrefjoin . 'regatta=' . $regattaid . '" method="post">';
    $addregattaformhtml = $addregattaformhtml . '<div style="display: table-row;">';
    $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width1 . 'px; display: table-cell;">Regatta Text:</div>';
    $addregattaformhtml = $addregattaformhtml . '<div style="width: ' . $width2 . 'px; display: table-cell;"><textarea cols="30" rows="10" name="RegattaText"></textarea></div>';
    $addregattaformhtml = $addregattaformhtml . '</div>';
    $addregattaformhtml = $addregattaformhtml . '<p><input type="submit" name="submitregatta" value="Submit"> <input type="reset" name="reset" value="Reset">';
    $addregattaformhtml = $addregattaformhtml . '</form>';
    }
  }
//What to do if there is no form input
else
  {
  $processing = false;

  //Widths for the columns in the form
  $width1 = 150;
  $width2 = 300;

  //The form to insert a new regatta
  $addregattaformhtml = '<form action="' . $defaulturls['AddRegatta'] . '" method="post">';
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
