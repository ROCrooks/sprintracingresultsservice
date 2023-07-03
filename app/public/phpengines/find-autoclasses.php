<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Separate RaceName into component parts - components are stored as separate auto races
//Standardize all breaks into "+"
$variablebreaks = array(" +"," + ","+ "," &"," & ","& ","&")
$racenamecomponents = str_replace($variablebreaks,"+",$racenameinput);

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
?>
