<?php
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
    $doubleaddsfind = array("A C K","B C K","C C K","D C K","A K C","B K C","C K C","D K C","A K K","B K K","C K K","D K K","A C C","B C C","C C C","D C C");
    $doubleaddsreplace = array("A C","B C","C C","D C","A K","B K","C K","D K","A K","B K","C K","D K","A C","B C","C C","D C");
    $racenamecomponents[$racenamekey] = str_replace($doubleaddsfind,$doubleaddsreplace,$racenamecomponents[$racenamekey]);
    }
  }
?>