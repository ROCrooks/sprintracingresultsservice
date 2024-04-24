<?php
$paddlerdetails = array();

$raceline = explode(" ",$raceline);
print_r($raceline);
echo "<br>";

//Check the first 2 elements for LD race lane numbers, and unset them if they're found
foreach($regex['longdistancelanes'] as $ldracelane)
  {
  if (isset($raceline[0]) == true)
    {
    if (preg_match($ldracelane,$raceline[0]) == true)
    unset($raceline[0]);
    }
  if (isset($raceline[1]) == true)
    {
    if (preg_match($ldracelane,$raceline[1]) == true)
      unset($raceline[1]);
    }
  }

//Get the last element of the array as the time or the no result
$timeelement = array_pop($raceline);

//Check if the last element is a time
$regexcount = count($regex['timeformats']);
$regexkey = 0;
$foundtime = false;
while (($regexkey < $regexcount) AND ($foundtime == false))
  {
  if (preg_match($regex['timeformats'][$regexkey],$timeelement) == true)
    {
    $paddlerdetails['Time'] = $timeelement;
    $paddlerdetails['NR'] = "";
    $foundtime = true;
    }
  $regexkey++;
  }

//Search for no results
$regexcount = count($regex['notfinishings']);
$regexkey = 0;
while (($regexkey < $regexcount) AND ($foundtime == false))
  {
  if ($regex['notfinishings'][$regexkey] == $timeelement)
    {
    $paddlerdetails['Time'] = 0;
    $paddlerdetails['NR'] = $timeelement;
    $foundtime = true;
    }
  $regexkey++;
  }

$raceline = array_values($raceline);

//Get the position and lane from the first 2 elements
echo $raceline[0] . "<br>";
echo $raceline[1] . "<br>";
if ((is_numeric($raceline[0]) == true) AND (is_numeric($raceline[1]) == true))
  {
  $paddlerdetails['Position'] = $raceline[0];
  $paddlerdetails['Lane'] = $raceline[1];
  unset($raceline[0]);
  unset($raceline[1]);
  }
elseif ((is_numeric($raceline[0]) == true) AND ($paddlerdetails['NR'] == ""))
  {
  $paddlerdetails['Position'] = $raceline[0];
  $paddlerdetails['Lane'] = 0;
  unset($raceline[0]);
  }
elseif ((is_numeric($raceline[0]) == true) AND ($paddlerdetails['NR'] != ""))
  {
  $paddlerdetails['Position'] = 0;
  $paddlerdetails['Lane'] = $raceline[0];
  unset($raceline[0]);
  }
else
  {
  $paddlerdetails['Position'] = 0;
  $paddlerdetails['Lane'] = 0;
  }

$raceline = array_values($raceline);

print_r($raceline);
echo "<br>";

print_r($paddlerdetails);
echo "<br>";

/*
//Common faults to find and replace
if ((isset($faultsfind) == false) AND (isset($faultsreplace) == false))
  {
  $faultsfind = array(" / ","//");
  $faultsreplace = array("/","/");
  }

$paddlerdetails = array();
    
//Preg to extract the position, lane and club
//Get the position, lane and club, from the preamble of the line
$linestartscount = count($regex['linestarts']);
$linestartskey = 0;
$foundlinestart = array();

//Test and extract each time format
while (($linestartskey < $linestartscount) AND (count($foundlinestart) == 0))
  {
  //Get the regex for the time format, in priority format
  $linestartformat = $regex['linestarts'][$linestartskey];
  
  //Get the formatted time
  preg_match($linestartformat,$raceline,$foundlinestart);

  $linestartskey++;
  }

//Make the line starts
if (count($foundlinestart) > 0)
  $foundlinestart = $foundlinestart[0];
else
  $foundlinestart = "";

$raceline = str_replace($foundlinestart,"",$raceline);

echo $raceline . "<br>";

//Explode the preamble into an array to separate out the parts
$foundlinestartarray = explode(" ",$foundlinestart);
//Extract the position, lane and club depending on the format
//This uses the key the loop stops on so that the format of the preamble is known
if (($linestartskey == 1) OR ($linestartskey == 2) OR ($linestartskey == 3))
  {
  $position = $foundlinestartarray[0];
  $lane = $foundlinestartarray[1];
  $defaultclub = $foundlinestartarray[2];
  }
elseif (($linestartskey == 4) OR ($linestartskey == 5))
  {
  //Default club is always the second element
  $defaultclub = $foundlinestartarray[1];

  //Store the single number, work out what it is later
  $singlenumber = $foundlinestartarray[0];
  }
elseif ($linestartskey == 6)
  {
  //Default club is always the first element
  $defaultclub = $foundlinestartarray[0];

  //Make sure the default club picked up is the club code, and not the last 3 letters of the name
  $startcheck = substr($raceline,0,3);
  if ($defaultclub != $startcheck)
    $defaultclub = "???";
  
  //Position and lane are always blank in this format
  $position = 0;
  $lane = 0;
  }
elseif (($linestartskey == 7) OR ($linestartskey == 8))
  {
  //Default club is blank in this format
  $defaultclub = "???";
  
  //Position and lane are first and second in this format
  $position = $foundlinestartarray[0];
  $lane = $foundlinestartarray[1];
  }
elseif ($linestartskey == 9)
  {
  //Default club is blank in this format
  $defaultclub = "???";
  
  //Position and lane are first and second in this format
  $position = $foundlinestartarray[0];
  $lane = 0;
  }
elseif ($linestartskey == 10)
  {
  //Default club is blank in this format
  $defaultclub = "???";
  
  //The single number is unclear at this point
  $singlenumber = $foundlinestartarray[0];
  }

//Specify a default club if it's missing
if ($defaultclub == "???")
  {
  //Loop through each club format until one that matches is found
  $clubregexescount = count($regex['defaultclub']);
  $clubregexeskey = 0;
  $foundclub = false;
  while (($clubregexeskey < $clubregexescount) AND ($foundclub == false))
    {
    $clubformatregex = $regex['defaultclub'][$clubregexeskey];

    //Check each type of club format
    preg_match($clubformatregex,$raceline,$defaultclub);
    echo count($defaultclub) . "<br>";
    if (count($defaultclub) == 1)
      {
      $defaultclub = $defaultclub[0];
      $defaultclub = str_replace(" ","",$defaultclub);
      $foundclub = true;
      }

    $clubregexeskey++;
    }
  
  if (is_array($defaultclub) == true)
    $defaultclub = "???";
  }

//Get the time from the paddler line
$timeformatscount = count($regex['timeformats']);
$timeformatskey = 0;
$foundtime = array();

//Test and extract each time format
while (($timeformatskey < $timeformatscount) AND (count($foundtime) == 0))
  {
  //Get the regex for the time format, in priority format
  $timeformat = $regex['timeformats'][$timeformatskey];
  
  //Get the formatted time
  preg_match($timeformat,$raceline,$foundtime);

  $timeformatskey++;
  }

$paddlers = $raceline;

//Assign the time if it is found
if (isset($foundtime[0]) == true)
  {
  $foundtime = $foundtime[0];
  $paddlers = str_replace($foundtime,'',$paddlers);
  }
else
  $foundtime = false;

//Assign what the single number found means
if (isset($singlenumber) == true)
  {
  if ($foundtime != false)
    {
    $position = $singlenumber;
    $lane = 0;
    $noresultflag = '';
    }
  else
    {
    $position = 0;
    $lane = $singlenumber;
    
    //Get the reason for no result by looking in the paddlers line
    $paddlers = explode(" ",$paddlers);
    $paddlerskey = 0;
    $paddlerscount = count($paddlers);
    $noresultflag = false;
    while (($paddlerskey < $paddlerscount) AND ($noresultflag == false))
      {
      $paddlerelement = $paddlers[$paddlerskey];

      $noresultflag = array_search($paddlerelement,$regex['notfinishings']);
      
      if (($noresultflag != false) OR ($noresultflag === 0)) 
        $noresultflag = $regex['notfinishings'][$noresultflag];
      
      $paddlerskey++;
      }
    
    //Remove the no result flag from the paddler line
    if ($noresultflag != false)
      unset($paddlers[$paddlerskey-1]);
    else
      $noresultflag = '';

    $paddlers = implode(" ",$paddlers);
    }
  }

//Read and remove the flag for a different class crew
preg_match($regex['differentclassflag'],$paddlers,$differentclass);
if (isset($differentclass[0]) == true)
  {
  $classcodes = substr($differentclass[0],1,-1);
  $classcodes = str_split($classcodes);
  $paddlerjsv = $classcodes[0];
  $paddlermw = $classcodes[1];
  $paddlerck = $classcodes[2];
  
  //Remove the different class flag from the paddler
  $paddlers = str_replace($differentclass[0],"",$paddlers);
  }
else
  {
  $paddlerjsv = $racedetails['defJSV'];
  $paddlermw = $racedetails['defMW'];
  $paddlerck = $racedetails['defCK'];      
  }

//Remove the start of the paddler line
$paddlers = str_replace($foundlinestart,"",$paddlers);
//Remove the time from the paddler line and replace with /
if ($foundtime != "")
  $paddlers = str_replace($foundtime,"/",$paddlers);
//Remove any double spaces
$doublespaces = 1;
while ($doublespaces > 0)
  {
  $paddlers = str_replace("  "," ",$paddlers,$doublespaces);
  }

//Remove weird slashes
$paddlers = str_replace(" / ","/",$paddlers);
$paddlers = str_replace("//","/",$paddlers);

//Remove spaces and and slashes from the start and finish of the paddlers
while ((substr($paddlers,0,1) == " ") OR (substr($paddlers,0,1) == "/"))
  {
  $paddlers = substr($paddlers,1);
  }
while ((substr($paddlers,-1) == " ") OR (substr($paddlers,-1) == "/"))
  {
  $paddlers = substr($paddlers,0,-1);
  }

//Remove errors in paddler names, and split paddlers into an array
$paddlers = str_replace($faultsfind,$faultsreplace,$paddlers);
$paddlers = explode("/",$paddlers);

//Find the paddlers and clubs from the paddlers array
$foundpaddlers = array();
$foundclubs = array();
foreach ($paddlers as $foundpaddler)
  {
  if (strlen($foundpaddler) > 0)
    {
    //Make the space better the initial and surname a space and period
    $foundpaddler = explode(" ",$foundpaddler);
    if (strlen($foundpaddler[0]) == 1)
      $foundpaddler[0] = $foundpaddler[0] . ".";
    $foundpaddler = implode(" ",$foundpaddler);

    //Extract any extra club from the paddler name
    preg_match($regex['individualclub'],$foundpaddler,$foundclub);
    if (count($foundclub) == 1)
      {
      $foundclub = $foundclub[0]; 
      //Remove the club in brackets from the found paddler string
      $foundpaddler = str_replace($foundclub,"",$foundpaddler);
      $foundclub = substr($foundclub,1,-1);
      }        
    else
      $foundclub = $defaultclub;
    
    //Add the club and paddlers to the found clubs and paddlers arrays
    array_push($foundclubs,$foundclub);
    array_push($foundpaddlers,$foundpaddler);
    }
  }

//Pad paddlers and club out with unknown ?. ?????? when the crew is too short
$paddlerpadinsertkey = count($foundpaddlers);
while ($paddlerpadinsertkey < $racedetails['Boat'])
  {
  array_push($foundpaddlers,"?. ??????");
  array_push($foundclubs,$defaultclub);
  $paddlerpadinsertkey++;
  }

//Format club as either a single club or a mixed club crew
$checkclub = array_unique($foundclubs);
if (count($checkclub) == 1)
  $foundclubs = $checkclub[0];
else
  $foundclubs = implode("/",$foundclubs);

//Turn the found paddlers into a string
$foundpaddlers = implode("/",$foundpaddlers);

//Add the position and lane to the paddlerdetails line
$paddlerdetails['Position'] = $position;
$paddlerdetails['Lane'] = $lane;

//Add the club and paddler to the paddlerdetails line
$paddlerdetails['Club'] = $foundclubs;
$paddlerdetails['Crew'] = $foundpaddlers;

//Add the found time to the paddlerdetails line
$paddlerdetails['Time'] = $foundtime;
if (isset($noresultflag) == true)
  $paddlerdetails['NR'] = $noresultflag;
else
  $paddlerdetails['NR'] = '';

//Define the JSV/MW/CK from the defaults for the race
$paddlerdetails['JSV'] = $paddlerjsv;
$paddlerdetails['MW'] = $paddlermw;
$paddlerdetails['CK'] = $paddlerck;

array_push($allpaddlerdetails,$paddlerdetails);

//Unset all found variables to stop them being reused in error
//unset($paddlerdetails);
unset($position);
unset($lane);
unset($foundclubs);
unset($foundpaddlers);
unset($foundtime);
unset($noresultflag);
unset($paddlerjsv);
unset($paddlermw);
unset($paddlerck);
unset($singlenumber);
*/
?>