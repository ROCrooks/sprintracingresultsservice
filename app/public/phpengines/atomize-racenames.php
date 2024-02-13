<?php
//Separate RaceName into component parts - components are stored as separate auto races
//Standardize all breaks into "+"
$variablebreaks = array("&");
$racenamecomponents = str_replace($variablebreaks,"+",$findclassname);

//Find out if it's a kayak class or a canoe class
$racenamecomponents = explode(" ",$racenamecomponents);
$boattype = array_pop($racenamecomponents);
//Add the boat type back in if it is not a valid boat type
if (($boattype != "K") AND ($boattype != "C") OR ($boattype != "V"))
  array_push($racenamecomponents,$boattype);
$racenamecomponents = implode(" ",$racenamecomponents);

//Explode racename by the + between each race class
$racenamecomponents = explode("+",$racenamecomponents);

//If the boat type is only 1 letter, add it to each race class
if(strlen($boattype) == 1)
  {
  foreach ($racenamecomponents as $racenamekey=>$racename)
    {
    //Remove any leading or trailing spaces
    $racename = str_split($racename);
    $arraysize = count($racename);
    $arrayfirst = " ";
    $keypointer = 0;
    //Unset any leading spaces starting with the first element
    while (($arrayfirst == " ") AND ($keypointer < $arraysize))
      {
      $arrayfirst = $racename[$keypointer];

      if ($arrayfirst == " ")
        unset($racename[$keypointer]);

      $keypointer++;
      }
    $arraylast = " ";
    $keypointer = $arraysize-1;
    //Unset any tailing spaces starting with the last element
    while (($arraylast == " ") AND ($keypointer >= 0))
      {
      $arraylast = $racename[$keypointer];

      if ($arraylast == " ")
        unset($racename[$keypointer]);

      $keypointer--;
      }
    
    $racenamecomponents[$racenamekey] = implode($racename) . " " . $boattype;

    //Replace erroneously double inserted boat types
    $doubleaddsfind = array("A C K","B C K","C C K","D C K","A K C","B K C","C K C","D K C","A K K","B K K","C K K","D K K","A C C","B C C","C C C","D C C");
    $doubleaddsreplace = array("A C","B C","C C","D C","A K","B K","C K","D K","A K","B K","C K","D K","A C","B C","C C","D C");
    $racenamecomponents[$racenamekey] = str_replace($doubleaddsfind,$doubleaddsreplace,$racenamecomponents[$racenamekey]);
    }
  }
?>