<?php
include_once $engineslocation . 'srrs-required-functions.php';

//Separate RaceName into component parts - components are stored as separate auto races
//Standardize all breaks into "+"
$variablebreaks = array(" +"," + ","+ "," &"," & ","& ","&");
$racenamecomponents = str_replace($variablebreaks,"+",$findclassname);

//Find out if it's a kayak class or a canoe class
$racenamecomponents = explode(" ",$racenamecomponents);
$boattype = array_pop($racenamecomponents);
$racenamecomponents = implode(" ",$racenamecomponents);

//Explode racename by the + between each race class
$racenamecomponents = explode("+",$racenamecomponents);

//If the boat type is only 1 letter, add it to each race class
if(strlen($boattype) == 1)
  {
  foreach ($racenamecomponents as $racenamekey=>$racename)
    {
    $racenamecomponents[$racenamekey] = $racename . " " . $boattype;

    //Replace erroneously double inserted boat types
    $doubleaddsfind = array("A C K","B C K","C C K","D C K","A K C","B K C","C K C","D K C");
    $doubleaddsreplace = array("A C","B C","C C","D C","A K","B K","C K","D K");
    $racenamecomponents[$racenamekey] = str_replace($doubleaddsfind,$doubleaddsreplace,$racenamecomponents[$racenamekey]);
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
    $foundautoclasses = array_merge($foundautoclasses,$autoclass);
  }
?>
