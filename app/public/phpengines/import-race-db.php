<?php
include_once $engineslocation . 'srrs-required-functions.php';

if (isset($racestmt) == false)
  {
  $racesql = "INSERT INTO `races` (`Regatta`, `Class`, `Boat`, `Dist`, `R`, `D`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, '')";
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

//Separate RaceName into component parts - components are stored as separate auto races
//Standardize all breaks into "+"
$variablebreaks = array(" +"," + ","+ "," &"," & ","& ","&")
$racenamecomponents = str_replace($variablebreaks,"+",$racedetails['RaceName']);

//Find out if it's a kayak class or a canoe class
$racenamecomponents = explode(" ",$racenamecomponents);
$boattype = array_pop($racenamecomponents);

//If the boat type is only 1 letter, add it to each race class
if(strlen($boattype) == 1)
  {
  foreach ($racenamecomponents as $racenamekey=>$racename)
    {
    $racenamecomponents[$racenamekey] = $racename . " " . $boattype;
    }
  }

//Find matching race classes in the autoclasses list
$foundautoclasses = array();
foreach($racenamecomponents as $namecomponent)
  {
  //Find the AutoClasses
  if (isset($findclassstmt) == false)
    {
    $findclasssql = "SELECT * FROM `autoclasses` WHERE `RaceName` = ?";
  	$findclassstmt = dbprepare($srrsdblink,$findclasssql);
    }

  //Add the autoclass if it's found
  $autoclass = dbexecute($findclassstmt,$namecomponent);
  if (count($autoclass) > 0)
    array_push($foundautoclasses,$autoclass);
  }

if (count($foundautoclasses) == count($racenamecomponents))
  {
  //Add each race class
  foreach ($foundautoclasses as $classadd)
    {
    if (isset($insertclassstmt) == false)
      {
      //Create insert class statement if not already created
      $insertclasssql = "INSERT INTO `classes` (`Race`, `JSV`, `MW`, `CK`, `Spec`, `Abil`, `Ages`, `FreeText`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    	$insertclassstmt = dbprepare($srrsdblink,$insertclasssql);
      }

    $insertclassdetails = array($raceid,$classadd['JSV'],$classadd['MW'],$classadd['CK'],$classadd['Spec'],$classadd['Abil'],$classadd['Ages'],$classadd['FreeText']);
    dbexecute($insertclassstmt,$insertclassdetails);
    }

  //Prepare the set race query if not already prepared
  if (isset($setracestmt) == false)
    {
    $setracesql = "UPDATE `races` SET `Set` = 1 WHERE `Key` = ?";
    $setracestmt = dbprepare($srrsdblink,$setracesql);
    }

  //Execute set race query as the class has been added by the race import script
  dbexecute($setracestmt,$raceid);
  }

?>
