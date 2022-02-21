<?php
include_once $engineslocation . 'srrs-required-functions.php';

if (isset($racestmt) == false)
  {
  $racesql = "INSERT INTO `races` (`Regatta`, `Class`, `Boat`, `Dist`, `R`, `D`) VALUES (?, ?, ?, ?, ?, ?)";
	$racestmt = dbprepare($srrsdblink,$racesql);
  }

//Create array of race details
if ($racedetails['Round'] == "H")
  $round = 1;
if ($racedetails['Round'] == "Q")
  $round = 2;
if ($racedetails['Round'] == "S")
  $round = 3;
if ($racedetails['Round'] == "F")
  $round = 4;
$insertracedetails = array($regattaid,$racedetails['RaceName'],$racedetails['Boat'],$racedetails['Distance'],$round,$racedetails['Draw']);
dbexecute($racestmt,$insertracedetails);
$raceid = mysqli_insert_id($srrsdblink);

foreach ($allpaddlerdetails as $paddlerdetails)
  {
  if (isset($paddlerstmt) == false)
    {
    //Prepare statement if not already prepared
    $paddlersql = "INSERT INTO `paddlers` (`Race`, `Position`, `Lane`, `Crew`, `Club`, `NR`, `Time`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $paddlerstmt = dbprepare($srrsdblink,$paddlersql);
    }

  if ($paddlerdetails['NR'] == "")
    //Convert time to seconds
    $paddlerdetails['Time'] = hmstosecs($paddlerdetails['Time']);
  else
    $paddlerdetails['Time'] = 0;

  $insertpaddlerdetails = array($raceid,$paddlerdetails['Position'],$paddlerdetails['Lane'],$paddlerdetails['Crew'],$paddlerdetails['Club'],$paddlerdetails['NR'],$paddlerdetails['Time'],$paddlerdetails['JSV'],$paddlerdetails['MW'],$paddlerdetails['CK']);

  dbexecute($paddlerstmt,$insertpaddlerdetails);
  }

if (isset($findclassstmt) == false)
  {
  $findclasssql = "SELECT * FROM `autoclasses` WHERE `RaceName` = ?";
	$findclassstmt = dbprepare($srrsdblink,$findclasssql);
  }

$autoclasses = dbexecute($findclassstmt,$racedetails['RaceName']);
$raceset = false;

//Add each race class
foreach ($autoclasses as $classadd)
  {
  if (isset($insertclassstmt) == false)
    {
    //Create insert class statement if not already created
    $insertclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  	$insertclassstmt = dbprepare($srrsdblink,$insertclasssql);
    }

  $insertclassdetails = array($raceid,$classadd['JSV'],$classadd['MW'],$classadd['CK'],$classadd['Spec'],$classadd['Abil'],$classadd['Ages'],$classadd['FreeText']);
  dbexecute($insertclassstmt,$insertclassdetails);

  //Set race to class is set if not already done so
  if ($raceset == false)
    {
    if (isset($setracestmt) == false)
      {
      $setracesql = "UPDATE `races` SET `Set` = 1 WHERE `Key` = ?";
      $setracestmt = dbprepare($srrsdblink,$setracesql);
      }

    dbexecute($setracestmt,$raceid);
    $raceset = true;
    }
  }
?>
