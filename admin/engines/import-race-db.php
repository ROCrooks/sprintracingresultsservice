<?php
include_once 'required-functions.php';
/*
//Testing code
$racedetails = array("Distance"=>"200","defCK"=>"K","Boat"=>"1","Draw"=>"1","Round"=>"F","RaceName"=>"MEN OPEN (INC U23) K","defMW"=>"M","defJSV"=>"S");
$allpaddlerdetails = array();
$allpaddlerdetails[0] = array("Time"=>"35.41","NR"=>"","Position"=>"1","Lane"=>"5","Club"=>"WEY","Crew"=>"L. HEATH","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[1] = array("Time"=>"35.77","NR"=>"","Position"=>"2","Lane"=>"6","Club"=>"SOR","Crew"=>"J. SCHOFIELD","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[2] = array("Time"=>"36.09","NR"=>"","Position"=>"3","Lane"=>"4","Club"=>"SPS","Crew"=>"L. FLETCHER","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[3] = array("Time"=>"36.58","NR"=>"","Position"=>"4","Lane"=>"3","Club"=>"SPS","Crew"=>"I. JAMES","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[4] = array("Time"=>"37.01","NR"=>"","Position"=>"5","Lane"=>"7","Club"=>"NOT","Crew"=>"S. NAFTANAILA","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[5] = array("Time"=>"37.14","NR"=>"","Position"=>"6","Lane"=>"2","Club"=>"EAL","Crew"=>"T. THOMSON","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[6] = array("Time"=>"37.56","NR"=>"","Position"=>"7","Lane"=>"8","Club"=>"CDF","Crew"=>"M. ROBINSON","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[7] = array("Time"=>"37.67","NR"=>"","Position"=>"8","Lane"=>"9","Club"=>"RDG","Crew"=>"D. ATKINS","JSV"=>"S","MW"=>"M","CK"=>"K");
$allpaddlerdetails[8] = array("Time"=>"38.67","NR"=>"","Position"=>"9","Lane"=>"1","Club"=>"LEA","Crew"=>"N. DEMBELE","JSV"=>"S","MW"=>"M","CK"=>"K");

$regattaid = 1000;
*/

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
  if ($paddlerdetails['NR'] == "")
    {
    //Insert race if paddler has a time
    if (isset($paddlertimestmt) == false)
      {
      //Prepare statement if not already prepared
      $paddlertimesql = "INSERT INTO `paddlers` (`Race`, `Position`, `Lane`, `Crew`, `Club`, `Time`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    	$paddlertimestmt = dbprepare($srrsdblink,$paddlertimesql);
      }
    //Convert time to seconds
    $paddlerdetails['Time'] = hmstosecs($paddlerdetails['Time']);

    $insertpaddlerdetails = array($raceid,$paddlerdetails['Position'],$paddlerdetails['Lane'],$paddlerdetails['Crew'],$paddlerdetails['Club'],$paddlerdetails['Time'],$paddlerdetails['JSV'],$paddlerdetails['MW'],$paddlerdetails['CK']);
    dbexecute($paddlertimestmt,$insertpaddlerdetails);
    }
  elseif ($paddlerdetails['NR'] != "")
    {
    //Insert race if paddler doesn't have a time
    if (isset($paddlernrstmt) == false)
      {
      //Prepare statement if not already prepared
      $paddlernrsql = "INSERT INTO `paddlers` (`Race`, `Position`, `Lane`, `Crew`, `Club`, `NR`, `JSV`, `MW`, `CK`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    	$paddlernrstmt = dbprepare($srrsdblink,$paddlernrsql);
      }
    $insertpaddlerdetails = array($raceid,$paddlerdetails['Position'],$paddlerdetails['Lane'],$paddlerdetails['Crew'],$paddlerdetails['Club'],$paddlerdetails['NR'],$paddlerdetails['JSV'],$paddlerdetails['MW'],$paddlerdetails['CK']);
    dbexecute($paddlernrstmt,$insertpaddlerdetails);
    }
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
